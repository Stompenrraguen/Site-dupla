<?php
if (!isset($_SESSION)) session_start();
include "produtos.php";

extract($_POST, EXTR_SKIP);

if (empty($_SESSION["carrinho"])) {
    $_SESSION["carrinho"] = [];
}

if (isset($b_adicionar)) {
    $idProduto = (int)($produto_id ?? 0);
    if (empty($_SESSION["logado"])) {
        if (isset($produtos[$idProduto])) {
            $_SESSION["adicionar_pendente"] = $idProduto;
            $_SESSION["aviso"] = ["tipo" => "info", "texto" => "Entre na sua conta para adicionar este jogo ao carrinho."];
        } else {
            $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Produto inválido."];
        }
        header("Location: login.php");
        exit;
    }

    if (isset($produtos[$idProduto])) {
        $idUsuario = (int)$_SESSION["id_usuario"];
        $consulta = "INSERT INTO carrinho (id_usuario, id_produto, quantidade)
                     VALUES ('$idUsuario', '$idProduto', 1)
                     ON DUPLICATE KEY UPDATE quantidade = quantidade + 1";
        banco($server, $user, $password, $db, $consulta);
        $_SESSION["aviso"] = ["tipo" => "sucesso", "texto" => "Jogo adicionado ao carrinho."];
    } else {
        $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Produto não encontrado."];
    }
    header("Location: carrinho.php");
    exit;
}

if (isset($b_remover)) {
    if (!empty($_SESSION["logado"])) {
        $idUsuario = (int)$_SESSION["id_usuario"];
        $idProduto = (int)($produto_id ?? 0);
        $consulta = "UPDATE carrinho SET quantidade = quantidade - 1
                     WHERE id_usuario = '$idUsuario' AND id_produto = '$idProduto' AND quantidade > 1";
        banco($server, $user, $password, $db, $consulta);
        $consulta = "DELETE FROM carrinho
                     WHERE id_usuario = '$idUsuario' AND id_produto = '$idProduto' AND quantidade <= 1";
        banco($server, $user, $password, $db, $consulta);
        $_SESSION["aviso"] = ["tipo" => "sucesso", "texto" => "Uma unidade foi removida do carrinho."];
    }
    header("Location: carrinho.php");
    exit;
}

if (isset($b_limpar)) {
    if (!empty($_SESSION["logado"])) {
        $idUsuario = (int)$_SESSION["id_usuario"];
        $consulta = "DELETE FROM carrinho WHERE id_usuario = '$idUsuario'";
        banco($server, $user, $password, $db, $consulta);
    }
    $_SESSION["aviso"] = ["tipo" => "sucesso", "texto" => "Carrinho limpo."];
    header("Location: carrinho.php");
    exit;
}

$itensCarrinho = [];
$total = 0;
if (!empty($_SESSION["logado"])) {
    $idUsuario = (int)$_SESSION["id_usuario"];
    $consulta = "SELECT c.id_produto, c.quantidade, p.nome, p.descricao, p.preco, p.imagem
                 FROM carrinho c INNER JOIN produto p ON p.id_produto = c.id_produto
                 WHERE c.id_usuario = '$idUsuario' ORDER BY c.id_carrinho DESC";
    $resultado = banco($server, $user, $password, $db, $consulta);
    while ($item = $resultado->fetch_assoc()) {
        $itensCarrinho[] = $item;
        $total += (float)$item["preco"] * (int)$item["quantidade"];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Carrinho - PoubreSteam</title>
    <link rel="stylesheet" href="css/style.css?v=5">
</head>
<body>
<header class="topo">
    <div class="marca"><img src="img/steam-logo.png" alt="Logo" class="logo-site"><div><h1>PoubreSteam</h1><p>Carrinho de compras</p></div></div>
    <nav class="menu-principal"><a href="index.php">Loja</a><a href="carrinho.php">Carrinho</a><a href="biblioteca.php">Biblioteca</a><a href="sobre.php">Sobre</a></nav>
    <div class="area-login">
        <?php if (!empty($_SESSION["logado"])): ?>
            <p class="texto-usuario">Olá, <?= htmlspecialchars($_SESSION["nome"], ENT_QUOTES, "UTF-8") ?></p><a href="logout.php" class="botao-secundario">Sair</a>
        <?php else: ?><a href="login.php" class="botao-secundario">Login</a><?php endif; ?>
    </div>
</header>
<?php include "app/avisos.php"; ?>
<main class="conteudo-principal pagina-carrinho">
    <h2 class="titulo-secao">Seu carrinho</h2>
    <?php if (empty($_SESSION["logado"])): ?>
        <div class="painel-vazio"><h3>Entre para acessar seu carrinho</h3><a href="login.php" class="botao-principal atalho-botao">Fazer login</a></div>
    <?php elseif (empty($itensCarrinho)): ?>
        <div class="painel-vazio"><h3>Carrinho vazio</h3><p>Volte para a loja e escolha pelo menos um jogo.</p><a href="index.php" class="botao-principal atalho-botao">Ir para a loja</a></div>
    <?php else: ?>
        <div class="lista-carrinho">
            <?php foreach ($itensCarrinho as $item): ?>
                <div class="item-carrinho">
                    <img src="<?= htmlspecialchars($item["imagem"], ENT_QUOTES, "UTF-8") ?>" alt="<?= htmlspecialchars($item["nome"], ENT_QUOTES, "UTF-8") ?>">
                    <div><h3><?= htmlspecialchars($item["nome"], ENT_QUOTES, "UTF-8") ?></h3><p><?= htmlspecialchars($item["descricao"], ENT_QUOTES, "UTF-8") ?></p><p>Quantidade: <?= (int)$item["quantidade"] ?></p></div>
                    <strong>R$ <?= number_format((float)$item["preco"] * (int)$item["quantidade"], 2, ",", ".") ?></strong>
                    <form action="carrinho.php" method="POST"><input type="hidden" name="produto_id" value="<?= (int)$item["id_produto"] ?>"><button type="submit" name="b_remover" class="botao-remover">Remover 1</button></form>
                </div>
            <?php endforeach; ?>
        </div>
        <section class="resumo-carrinho">
            <h3>Total: R$ <?= number_format($total, 2, ",", ".") ?></h3>
            <form action="carrinho.php" method="POST"><button type="submit" name="b_limpar" class="botao-secundario">Limpar carrinho</button></form>
            <form action="confirmar.php" method="POST"><button type="submit" name="b_finalizar" class="botao-principal">Finalizar compra</button></form>
        </section>
    <?php endif; ?>
</main>
<footer><p>PoubreSteam &copy; 2026 - Todos os direitos reservados.</p></footer>
</body>
</html>
