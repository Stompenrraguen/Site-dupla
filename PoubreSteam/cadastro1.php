
<?php

if (!isset($_SESSION)) {
    session_start();
}

include "app/cons.php";
require_once "app/DLL.php";

if (!empty($_SESSION["logado"])) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PoubreSteam - Cadastro</title>
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
            <a href="login.php">Login</a>
        </div>

        <form class="busca" action="produtos.php" method="get">
            <input type="text" name="busca" placeholder="Buscar na loja">
            <button type="submit">🔍</button>
        </form>

    </nav>
</header>

<main class="conteudo">

    <section class="titulo-secao">
        <h2>Criar uma conta</h2>
    </section>

    <?php if (isset($_GET["erro"])) { ?>

        <div class="card">
            <div class="card-conteudo">
                <p>Não foi possível realizar o cadastro. Verifique os dados e tente novamente.</p>
            </div>
        </div>

        <br>

    <?php } ?>

    <form action="salvar_usuario.php" method="post">

        <div class="card">
            <div class="card-conteudo">

                <h3>Dados pessoais</h3>

                <br>

                <label for="nome">Nome completo:</label>
                <br>
                <input type="text" id="nome" name="nome" maxlength="150" required>

                <br><br>

                <label for="cpf">CPF:</label>
                <br>
                <input type="text" id="cpf" name="cpf" maxlength="14" placeholder="Somente números ou com pontuação" required>

                <br><br>

                <label for="email">E-mail:</label>
                <br>
                <input type="email" id="email" name="email" maxlength="150" required>

                <br><br>

                <h3>Endereço</h3>

                <br>

                <label for="endereco">Endereço:</label>
                <br>
                <input type="text" id="endereco" name="endereco" maxlength="200" required>

                <br><br>

                <label for="bairro">Bairro:</label>
                <br>
                <input type="text" id="bairro" name="bairro" maxlength="100" required>

                <br><br>

                <label for="cidade">Cidade:</label>
                <br>
                <input type="text" id="cidade" name="cidade" maxlength="100" required>

                <br><br>

                <label for="estado">Estado (UF):</label>
                <br>
                <input type="text" id="estado" name="estado" maxlength="2" minlength="2" required>

                <br><br>

                <label for="cep">CEP:</label>
                <br>
                <input type="text" id="cep" name="cep" maxlength="9" required>

                <br><br>

                <h3>Dados de acesso</h3>

                <br>

                <label for="login">Login:</label>
                <br>
                <input type="text" id="login" name="login" maxlength="50" required>

                <br><br>

                <label for="senha">Senha:</label>
                <br>
                <input type="password" id="senha" name="senha" minlength="8" required>

                <br><br>

                <input type="submit" value="Criar conta" class="botao">

            </div>
        </div>

    </form>

</main>

<footer class="rodape">
    PoubreSteam © 2026 - Loja de jogos
</footer>

</body>
</html>
