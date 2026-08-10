<?php
if (!isset($_SESSION)) session_start();

if (isset($_POST["b_comprar"]) && !empty($_POST["produto_id"])) {
    $_SESSION["produto_pendente"] = (int)$_POST["produto_id"];
}

$erro = "";
$cadastro = "";

if (!empty($_SESSION["erro_login"])) {
    $erro = $_SESSION["erro_login"];
    unset($_SESSION["erro_login"]); 
}

if (!empty($_SESSION["cadastro_ok"])) {
    $cadastro = $_SESSION["cadastro_ok"];
    unset($_SESSION["cadastro_ok"]); 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - PoubreSteam</title>
    <link rel="stylesheet" href="css/style.css?v=4">
</head>
<body class="pagina-login">

<div class="caixa-formulario">
    <h1>Entrar na PoubreSteam</h1>
    <p>Acesse sua conta para continuar.</p>

    <?php if ($erro == "1"): ?>
        <div class="alerta erro">Login ou senha incorretos.</div>
    <?php endif; ?>

    <?php if ($cadastro == "ok"): ?>
        <div class="alerta sucesso">Conta criada com sucesso. Faça login para continuar.</div>
    <?php endif; ?>

    <form action="processa_login.php" method="POST">
        <label>Login</label>
        <input type="text" name="login" required>

        <label>Senha</label>
        <input type="password" name="senha" required>

        <button type="submit" name="b1" class="botao-principal">Entrar</button>
    </form>

    <a href="cadastro1.php" class="atalho-cadastro">Cadastrar novo usuário</a>
    <a href="index.php" class="atalho-voltar">Voltar para a loja</a>
</div>

</body>
</html>
