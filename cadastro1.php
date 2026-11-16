<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro - Dados Pessoais</title>
    <link rel="stylesheet" href="css/style.css?v=5">
    <link rel="stylesheet" href="css/avisos.css">
</head>
<body class="pagina-login">
    <div class="caixa-formulario grande">
        <?php include "avisos.php"; ?>

        <h1>Cadastro - Etapa 1</h1>
        <p>Informe seus dados pessoais para criar sua conta.</p>

        <form action="salvar_usuario.php" method="POST">
            <label for="nome">Nome completo</label>
            <input id="nome" type="text" name="nome" required maxlength="150">

            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" required maxlength="254">

            <label for="cpf">CPF</label>
            <input id="cpf" type="text" name="cpf" required maxlength="14" placeholder="000.000.000-00">

            <label for="endereco">Endereço</label>
            <input id="endereco" type="text" name="endereco" required maxlength="200">

            <label for="bairro">Bairro</label>
            <input id="bairro" type="text" name="bairro" required maxlength="100">

            <label for="cidade">Cidade</label>
            <input id="cidade" type="text" name="cidade" required maxlength="100">

            <label for="estado">Estado</label>
            <input id="estado" type="text" name="estado" required maxlength="2" placeholder="SP">

            <label for="cep">CEP</label>
            <input id="cep" type="text" name="cep" required maxlength="9" placeholder="00000-000">

            <button type="submit" name="b1" value="1" class="botao-principal">
                Continuar
            </button>
        </form>

        <a href="login.php" class="atalho-voltar">Voltar para o login</a>
    </div>
</body>
</html>
