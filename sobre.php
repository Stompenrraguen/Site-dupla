<?php
if (!isset($_SESSION)) session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sobre - PoubreSteam</title>
    <link rel="stylesheet" href="css/style.css?v=4">
</head>
<body>
<header class="topo">
    <div class="marca"><img src="img/steam-logo.png" alt="Logo" class="logo-site"><div><h1>PoubreSteam</h1><p>Sobre a plataforma</p></div></div>
    <nav class="menu-principal"><a href="index.php">Loja</a><a href="carrinho.php">Carrinho</a><a href="biblioteca.php">Biblioteca</a><a href="sobre.php">Sobre</a></nav>
    <div class="area-login">
        <?php if (!empty($_SESSION["logado"])): ?>
            <p class="texto-usuario">Olá, <?= htmlspecialchars($_SESSION["nome"]) ?></p><a href="logout.php" class="botao-secundario">Sair</a>
        <?php else: ?>
            <a href="login.php" class="botao-secundario">Login</a>
        <?php endif; ?>
    </div>
</header>

<main class="conteudo-principal sobre-layout">
    <section class="cartao-confirmacao">
        <h2>Sobre o site</h2>
        <p>A PoubreSteam é uma loja oficial de revenda de jogos digitais, criada para oferecer uma seleção de títulos acessíveis, organizada e confiável.</p>
        <p>Nosso objetivo é aproximar jogadores de novos jogos por meio de ofertas selecionadas, navegação simples e uma experiência de compra direta, segura e profissional.</p>

        <h2>Criadores e Atendimento</h2>
        <p><strong>Criadores:</strong> Kaio Carvalho, Enzo Daniel e equipe.</p>
        <p><strong>Contato:</strong> atendimento@poubresteam.com</p>
    </section>
</main>

<footer><p>PoubreSteam &copy; 2026 - Todos os direitos reservados.</p></footer>
</body>
</html>
