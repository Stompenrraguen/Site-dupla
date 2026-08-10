<?php
if (!isset($_SESSION)) session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Dados Pessoais</title>
    <link rel="stylesheet" href="css/style.css?v=4">
</head>
<body class="pagina-login">

<div class="caixa-formulario grande">
    <h1>Cadastro - Etapa 1</h1>
    <p>Informe seus dados pessoais para criar sua conta.</p>

    <form action="salvar_usuario.php" method="POST">
        <label>Nome completo</label>
        <input type="text" name="nome" required>

        <label>CPF</label>
        <input type="text" name="cpf" required maxlength="14" placeholder="000.000.000-00">

        <label>Endereço</label>
        <input type="text" name="endereco" required>

        <label>Bairro</label>
        <input type="text" name="bairro" required>

        <label>Cidade</label>
        <input type="text" name="cidade" required>

        <label>Estado</label>
        <input type="text" name="estado" required maxlength="2" placeholder="SP">

        <label>CEP</label>
        <input type="text" name="cep" required placeholder="00000-000">

        <button type="submit" name="b1" class="botao-principal">Continuar</button>
    </form>

    <a href="login.php" class="atalho-voltar">Voltar para o login</a>
</div>

</body>
</html>
