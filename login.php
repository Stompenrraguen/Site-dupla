<?php
if (!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PoubreSteam - Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="topo">
    <nav class="menu">

        <a href="index.php" class="logo">
            <img src="img/steam-logo.png" alt="Logo PoubreSteam">
                <span>PoubreSteam</span>
        </a>

        <div class="menu-links">
            <a href="index.php">Loja</a>
            <a href="produtos.php">Produtos</a>
            <a href="carrinho.php">Carrinho</a>
            <a href="biblioteca.php">Biblioteca</a>
            <a href="sobre.php">Sobre</a>
            <a href="cadastro1.php">Cadastro</a>
        </div>

        <form class="busca" action="produtos.php" method="get">
            <input type="text" name="busca" placeholder="Buscar na loja">
            <button type="submit">🔍</button>
        </form>

    </nav>
</header>

<main class="conteudo">

    <section class="titulo-secao">
        <h2>Entrar na sua conta</h2>
    </section>

    <?php if (isset($_GET["cadastro"]) && $_GET["cadastro"] == "ok") { ?>

        <div class="card">
            <div class="card-conteudo">
                <p>Cadastro realizado com sucesso! Agora faça login.</p>
            </div>
        </div>

        <br>

    <?php } ?>

    <?php if (isset($_GET["erro"])) { ?>

        <div class="card">
            <div class="card-conteudo">
                <p>Login ou senha incorretos.</p>
            </div>
        </div>

        <br>

    <?php } ?>

    <form action="processa_login.php" method="post">

        <div class="card">
            <div class="card-conteudo">

                <h3>Dados de acesso</h3>

                <br>

                <label for="login">Login:</label>
                <br>
                <input type="text" id="login" name="login" required>

                <br><br>

                <label for="senha">Senha:</label>
                <br>
                <input type="password" id="senha" name="senha" required>

                <br><br>

                <input type="submit" value="Entrar" class="botao">

            </div>
        </div>

    </form>

</main>

<footer class="rodape">
    PoubreSteam © 2026 - Loja de jogos
</footer>

</body>
</html>
