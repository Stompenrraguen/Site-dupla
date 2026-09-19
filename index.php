<?php
if (!isset($_SESSION)) session_start();
include "produtos.php";

$busca = "";
if (isset($_POST["b_busca"]) && !empty($_POST["busca_campo"])) {
    $busca = trim($_POST["busca_campo"]);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>PoubreSteam - Loja de Jogos</title>
    <link rel="stylesheet" href="css/style.css?v=4">
</head>
<body>

<header class="topo">
    <div class="marca">
        <img src="img/steam-logo.png" alt="Logo" class="logo-site">
        <div>
            <h1>PoubreSteam</h1>
            <p>Loja digital de jogos</p>
        </div>
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

<section class="barra-busca">
    <form action="index.php" method="POST">
        <input type="text" name="busca_campo" placeholder="Pesquisar jogos na loja" value="<?= htmlspecialchars($busca) ?>">
        <button type="submit" name="b_busca">Pesquisar</button>
    </form>
</section>

<section class="chamada">
    <div>
        <h2>Promoções da Semana</h2>
        <p>Escolha seu jogo, adicione ao carrinho, faça login e confirme sua compra com praticidade.</p>
    </div>
</section>

<main class="conteudo-principal">
    <h2 class="titulo-secao">Jogos em destaque</h2>
    <div class="grade-produtos">
        <?php foreach ($produtos as $id => $p): ?>
            <?php
            $mostrar = true;
            if ($busca != "" && stripos($p["nome"], $busca) === false) {
                $mostrar = false;
            }
            ?>
            <?php if ($mostrar): ?>
            <div class="cartao-produto">
                <img src="<?=($p["imagem"]) ?>" alt="<?=($p["nome"]) ?>">
                <div class="conteudo-cartao">
                    <h3><?= ($p["nome"]) ?></h3>
                    <p><?=($p["descricao"]) ?></p>
                    <div class="rodape-cartao">
                        <strong>R$ <?= number_format($p["preco"], 2, ",", ".") ?></strong>
                        <form action="carrinho.php" method="POST">
                            <input type="hidden" name="produto_id" value="<?= $id ?>">
                            <button type="submit" name="b_adicionar" class="botao-comprar">Adicionar</button>
                        </form>
                        <form action="<?= !empty($_SESSION["logado"]) ? "confirmar.php" : "login.php" ?>" method="POST">
                            <input type="hidden" name="produto_id" value="<?= $id ?>">
                            <button type="submit" name="b_comprar" class="botao-direto">Comprar</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</main>

<footer>
    <div>
        <strong>PoubreSteam</strong>
        <p>&copy; 2026 PoubreSteam. Todos os direitos reservados.</p>
    </div>
    <div>
        <p><strong>Criadores:</strong> Kaio Carvalho, Enzo Daniel e equipe.</p>
    </div>
</footer>

</body>
</html>
