<?php
if (!isset($_SESSION)) session_start();
include "produtos.php";

if (empty($_SESSION["logado"])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST["b_comprar"]) && !empty($_POST["produto_id"])) {
    $_SESSION["produto_pendente"] = (int)$_POST["produto_id"];
}

$itensCompra = [];

if (!empty($_SESSION["produto_pendente"])) {
    $idProduto = $_SESSION["produto_pendente"];
    if (isset($produtos[$idProduto])) {
        $itensCompra[] = $idProduto;
    }
} else if (!empty($_SESSION["carrinho"])) {
    $itensCompra = $_SESSION["carrinho"];
}

if (empty($itensCompra)) {
    header("Location: index.php");
    exit;
}

$usuario = $_SESSION["usuario"]; 
$total = 0;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Compra - PoubreSteam</title>
    <link rel="stylesheet" href="css/style.css?v=4">
</head>
<body>

<header class="topo">
    <div class="marca">
        <img src="img/steam-logo.png" alt="Logo" class="logo-site">
        <div><h1>PoubreSteam</h1><p>Confirmação de compra</p></div>
    </div>
    <nav class="menu-principal">
        <a href="index.php">Loja</a>
        <a href="carrinho.php">Carrinho</a>
        <a href="biblioteca.php">Biblioteca</a>
        <a href="sobre.php">Sobre</a>
    </nav>
    <div class="area-login">
        <p class="texto-usuario"><?= htmlspecialchars($_SESSION["nome"]) ?></p>
        <a href="logout.php" class="botao-secundario">Sair</a>
    </div>
</header>

<main class="conteudo-principal confirmar-layout">
    <section class="cartao-confirmacao">
        <h2>Produto escolhido</h2>
        <?php foreach ($itensCompra as $id): ?>
            <?php if (isset($produtos[$id])): ?>
                <?php $total = $total + $produtos[$id]["preco"]; ?>
                <div class="produto-confirmar">
                    <img src="<?= $produtos[$id]["imagem"] ?>" alt="<?= htmlspecialchars($produtos[$id]["nome"]) ?>">
                    <div>
                        <h3><?= htmlspecialchars($produtos[$id]["nome"]) ?></h3>
                        <p><?= htmlspecialchars($produtos[$id]["descricao"]) ?></p>
                        <strong>R$ <?= number_format($produtos[$id]["preco"], 2, ",", ".") ?></strong>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <strong class="preco-grande">Total: R$ <?= number_format($total, 2, ",", ".") ?></strong>
    </section>

    <section class="cartao-confirmacao">
        <h2>Dados do comprador</h2>
        <p><strong>Nome:</strong> <?= htmlspecialchars($usuario["nome"]) ?></p>
        <p><strong>CPF:</strong> <?= htmlspecialchars($usuario["cpf"]) ?></p>
        <p><strong>Endereço:</strong> <?= htmlspecialchars($usuario["endereco"]) ?></p>
        <p><strong>Bairro:</strong> <?= htmlspecialchars($usuario["bairro"]) ?></p>
        <p><strong>Cidade:</strong> <?= htmlspecialchars($usuario["cidade"]) ?></p>
        <p><strong>Estado:</strong> <?= htmlspecialchars($usuario["estado"]) ?></p>
        <p><strong>CEP:</strong> <?= htmlspecialchars($usuario["cep"]) ?></p>

        <form action="salvar_venda.php" method="POST">
            <label>Forma de pagamento</label>
            <select name="pagamento" required>
                <option value="">Selecione</option>
                <option value="Pix">Pix</option>
                <option value="Cartão de Crédito">Cartão de Crédito</option>
                <option value="Boleto">Boleto</option>
                <option value="Saldo PoubreSteam">Saldo PoubreSteam</option>
            </select>
            <button type="submit" name="b1" class="botao-principal">Confirmar compra</button>
        </form>
    </section>
</main>

<footer>
    <p>PoubreSteam &copy; 2026 - Todos os direitos reservados.</p>
</footer>
</body>
</html>
