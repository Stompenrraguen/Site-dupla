<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION["cpf_cadastro"])) {
    $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Informe seus dados pessoais primeiro."];
    header("Location: cadastro1.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro - Acesso</title>
    <link rel="stylesheet" href="css/style.css?v=5">
    <link rel="stylesheet" href="css/avisos.css">
</head>
<body class="pagina-login">
    <div class="caixa-formulario">
        <?php include "avisos.php"; ?>

        <h1>Cadastro - Etapa 2</h1>
        <p>Crie seu login e senha.</p>

        <form action="salvar_login.php" method="POST">
            <label for="login">Login</label>
            <input id="login" type="text" name="login" required maxlength="50">

            <label for="senha">Senha (mínimo 6 caracteres)</label>
            <input id="senha" type="password" name="senha" required minlength="6">

            <button type="submit" name="b1" value="1" class="botao-principal">
                Finalizar cadastro
            </button>
        </form>
    </div>
</body>
</html>
