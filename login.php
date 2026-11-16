<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

extract($_POST, EXTR_SKIP);

if (!empty($b_comprar) && !empty($produto_id)) {
    $_SESSION["produto_pendente"] = (int)$produto_id;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - PoubreSteam</title>
    <link rel="stylesheet" href="css/style.css?v=5">
    <link rel="stylesheet" href="css/avisos.css">
</head>
<body class="pagina-login">
<div class="caixa-formulario">
    <?php include "avisos.php"; ?>

    <h1>Entrar na PoubreSteam</h1>
    <p>Acesse sua conta para continuar.</p>

    <form action="processa_login.php" method="POST">
        <label for="login">Login</label>
        <input id="login" type="text" name="login" required>

        <label for="senha">Senha</label>
        <input id="senha" type="password" name="senha" required>

        <button type="submit" name="b1" value="1" class="botao-principal">Entrar</button>
    </form>

    <a href="cadastro1.php" class="atalho-cadastro">Cadastrar novo usuário</a>
    <a href="index.php" class="atalho-voltar">Voltar para a loja</a>
</div>
</body>
</html>
