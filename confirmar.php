<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "app/cons.php";
require_once "app/DLL.php";

extract($_POST, EXTR_SKIP);

if (empty($_SESSION["logado"]) || empty($_SESSION["id_usuario"])) {
    $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Entre na sua conta para confirmar a compra."];
    header("Location: login.php");
    exit;
}

if (!empty($b_comprar) && !empty($produto_id)) {
    $_SESSION["produto_pendente"] = (int)$produto_id;
}

$idUsuario = (int)$_SESSION["id_usuario"];
$itensCompra = [];

if (!empty($_SESSION["produto_pendente"])) {
    $idProduto = (int)$_SESSION["produto_pendente"];
    $consulta = "SELECT id_produto, nome, descricao, preco, imagem
                 FROM produto
                 WHERE id_produto = '$idProduto'
                 LIMIT 1";
    $resultado = banco($server, $user, $password, $db, $consulta);

    if ($produto = $resultado->fetch_assoc()) {
        $produto["quantidade"] = 1;
        $itensCompra[] = $produto;
    }
} else {
    $consulta = "SELECT p.id_produto, p.nome, p.descricao, p.preco, p.imagem,
                        c.quantidade
                 FROM carrinho c
                 INNER JOIN produto p ON p.id_produto = c.id_produto
                 WHERE c.id_usuario = '$idUsuario'
                 ORDER BY c.id_carrinho";
    $resultado = banco($server, $user, $password, $db, $consulta);

    while ($item = $resultado->fetch_assoc()) {
        $itensCompra[] = $item;
    }
}

if (empty($itensCompra)) {
    $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Não há produtos válidos para confirmar."];
    header("Location: carrinho.php");
    exit;
}

$total = 0;
foreach ($itensCompra as $item) {
    $total += (float)$item["preco"] * (int)$item["quantidade"];
}

$consulta = "SELECT endereco, bairro, cidade, estado, cep
             FROM endereco
             WHERE id_usuario = '$idUsuario'
             LIMIT 1";
$resultadoEndereco = banco($server, $user, $password, $db, $consulta);
$endereco = $resultadoEndereco->fetch_assoc() ?: [
    "endereco" => "", "bairro" => "", "cidade" => "", "estado" => "", "cep" => ""
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmar Compra - PoubreSteam</title>
    <link rel="stylesheet" href="css/style.css?v=5">
    <link rel="stylesheet" href="css/avisos.css">
</head>
<body>
<header class="topo">
    <div class="marca">
        <img src="img/steam-logo.png" alt="Logo PoubreSteam" class="logo-site">
        <div><h1>PoubreSteam</h1><p>Confirmação de compra</p></div>
    </div>
    <nav class="menu-principal">
        <a href="index.php">Loja</a><a href="carrinho.php">Carrinho</a>
        <a href="biblioteca.php">Biblioteca</a><a href="sobre.php">Sobre</a>
    </nav>
    <div class="area-login">
        <p class="texto-usuario"><?= htmlspecialchars($_SESSION["nome"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
        <a href="logout.php" class="botao-secundario">Sair</a>
    </div>
</header>

<?php include "avisos.php"; ?>

<main class="conteudo-principal confirmar-layout">
    <section class="cartao-confirmacao">
        <h2>Produtos escolhidos</h2>
        <?php foreach ($itensCompra as $item): ?>
            <div class="produto-confirmar">
                <img
                    src="<?= htmlspecialchars($item["imagem"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                    alt="<?= htmlspecialchars($item["nome"] ?? "", ENT_QUOTES, "UTF-8") ?>">
                <div>
                    <h3><?= htmlspecialchars($item["nome"] ?? "", ENT_QUOTES, "UTF-8") ?></h3>
                    <p><?= htmlspecialchars($item["descricao"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
                    <p>Quantidade: <?= (int)$item["quantidade"] ?></p>
                    <strong>R$ <?= number_format((float)$item["preco"] * (int)$item["quantidade"], 2, ",", ".") ?></strong>
                </div>
            </div>
        <?php endforeach; ?>
        <strong class="preco-grande">Total: R$ <?= number_format($total, 2, ",", ".") ?></strong>
    </section>

    <section class="cartao-confirmacao">
        <h2>Dados do comprador</h2>
        <p><strong>Nome:</strong> <?= htmlspecialchars($_SESSION["nome"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
        <p><strong>CPF:</strong> <?= htmlspecialchars($_SESSION["cpf"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
        <p><strong>Endereço:</strong> <?= htmlspecialchars($endereco["endereco"], ENT_QUOTES, "UTF-8") ?></p>
        <p><strong>Bairro:</strong> <?= htmlspecialchars($endereco["bairro"], ENT_QUOTES, "UTF-8") ?></p>
        <p><strong>Cidade:</strong> <?= htmlspecialchars($endereco["cidade"], ENT_QUOTES, "UTF-8") ?></p>
        <p><strong>Estado:</strong> <?= htmlspecialchars($endereco["estado"], ENT_QUOTES, "UTF-8") ?></p>
        <p><strong>CEP:</strong> <?= htmlspecialchars($endereco["cep"], ENT_QUOTES, "UTF-8") ?></p>

        <form action="salvar_venda.php" method="POST">
            <label for="pagamento">Forma de pagamento</label>
            <select id="pagamento" name="pagamento" required>
                <option value="">Selecione</option>
                <option value="Pix">Pix</option>
                <option value="Cartão de Crédito">Cartão de Crédito</option>
                <option value="Boleto">Boleto</option>
                <option value="Saldo PoubreSteam">Saldo PoubreSteam</option>
            </select>
            <button type="submit" name="b1" value="1" class="botao-principal">Confirmar compra</button>
        </form>
    </section>
</main>

<footer><p>PoubreSteam &copy; 2026 - Todos os direitos reservados.</p></footer>
</body>
</html>
