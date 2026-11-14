<?php
if (!isset($_SESSION)) session_start();
include "produtos.php";

if (empty($_SESSION["carrinho"])) {
    $_SESSION["carrinho"] = [];
}

if (isset($_POST["b_adicionar"])) {
    $idProduto = (int)($_POST["produto_id"] ?? 0);

    if (empty($_SESSION["logado"])) {
        if (isset($produtos[$idProduto])) {
            $_SESSION["adicionar_pendente"] = $idProduto;
        }
        header("Location: login.php");
        exit;
    }

    if (isset($produtos[$idProduto])) {
        $_SESSION["carrinho"][] = $idProduto;
    }
}

if (isset($_POST["b_remover"])) {
    $idProduto = (int)($_POST["produto_id"] ?? 0);
    $novoCarrinho = [];
    $removido = false;
    foreach ($_SESSION["carrinho"] as $id) {
        if ($id == $idProduto && $removido == false) {
            $removido = true;
        } else {
            $novoCarrinho[] = $id;
        }
    }
    $_SESSION["carrinho"] = $novoCarrinho;
}

if (isset($_POST["b_limpar"])) {
    $_SESSION["carrinho"] = [];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Carrinho - PoubreSteam</title>
    <link rel="stylesheet" href="css/style.css?v=4">
</head>
<body>
<header class="topo">
    <div class="marca">
        <img src="img/steam-logo.png" alt="Logo" class="logo-site">
        <div><h1>PoubreSteam</h1><p>Carrinho de compras</p></div>
    </div>
    <nav class="menu-principal">
        <a href="index.php">Loja</a>
        <a href="carrinho.php">Carrinho</a>
        <a href="biblioteca.php">Biblioteca</a>
        <a href="sobre.php">Sobre</a>
    </nav>
    <div class="area-login">
        <?php if (!empty($_SESSION["logado"])): ?>
            <p class="texto-usuario">Olá, <?= htmlspecialchars($_SESSION["nome"]) ?></p>
            <a href="logout.php" class="botao-secundario">Sair</a>
        <?php else: ?>
            <a href="login.php" class="botao-secundario">Login</a>
        <?php endif; ?>
    </div>
</header>

<main class="conteudo-principal pagina-carrinho">
    <h2 class="titulo-secao">Seu carrinho</h2>

    <?php if (empty($_SESSION["carrinho"])): ?>
        <div class="painel-vazio">
            <h3>Carrinho vazio</h3>
            <p>Volte para a loja e escolha pelo menos um jogo.</p>
            <a href="index.php" class="botao-principal atalho-botao">Ir para a loja</a>
        </div>
    <?php else: ?>
        <?php $total = 0; ?>
        <div class="lista-carrinho">
            <?php foreach ($_SESSION["carrinho"] as $id): ?>
                <?php if (isset($produtos[$id])): ?>
                    <?php $total = $total + $produtos[$id]["preco"]; ?>
                    <div class="item-carrinho">
                        <img src="<?= htmlspecialchars($produtos[$id]["imagem"]) ?>" alt="<?= htmlspecialchars($produtos[$id]["nome"]) ?>">
                        <div>
                            <h3><?= htmlspecialchars($produtos[$id]["nome"]) ?></h3>
                            <p><?= htmlspecialchars($produtos[$id]["descricao"]) ?></p>
                        </div>
                        <strong>R$ <?= number_format($produtos[$id]["preco"], 2, ",", ".") ?></strong>
                        <form action="carrinho.php" method="POST">
                            <input type="hidden" name="produto_id" value="<?= $id ?>">
                            <button type="submit" name="b_remover" class="botao-remover">Remover</button>
                        </form>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <section class="resumo-carrinho">
            <h3>Total: R$ <?= number_format($total, 2, ",", ".") ?></h3>
            <form action="carrinho.php" method="POST">
                <button type="submit" name="b_limpar" class="botao-secundario">Limpar carrinho</button>
            </form>
            <form action="<?= !empty($_SESSION["logado"]) ? "confirmar.php" : "login.php" ?>" method="POST">
                <button type="submit" name="b_finalizar" class="botao-principal">Finalizar compra</button>
            </form>
        </section>
    <?php endif; ?>
</main>

<footer>
    <p>PoubreSteam &copy; 2026 - Todos os direitos reservados.</p>
</footer>
</body>
</html>
