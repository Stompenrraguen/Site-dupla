<?php
if (!isset($_SESSION)) session_start();

if (empty($_SESSION["cpf_cadastro"])) {
    header("Location: cadastro1.php");
    exit;
}

$erro = "";
if (!empty($_SESSION["erro_cadastro2"])) {
    $erro = $_SESSION["erro_cadastro2"];
    unset($_SESSION["erro_cadastro2"]);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Acesso</title>
    <link rel="stylesheet" href="css/style.css?v=4">
</head>
<body class="pagina-login">

<div class="caixa-formulario">
    <h1>Cadastro - Etapa 2</h1>
    <p>Crie seu login e senha.</p>

    <?php if ($erro == "login_existe"): ?>
        <div class="alerta erro">Este login já existe. Escolha outro.</div>
    <?php endif; ?>

    <form action="salvar_login.php" method="POST">
        <label>Login</label>
        <input type="text" name="login" required>

        <label>Senha</label>
        <input type="password" name="senha" required>

        <button type="submit" name="b1" class="botao-principal">Finalizar cadastro</button>
    </form>
</div>

</body>
</html>
