
<?php
if (!isset($_SESSION)) session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Dados Pessoais</title>
    <link rel="stylesheet" href="css/style.css?v=4">
    <script src="js/script.js" defer></script>
</head>
<body class="pagina-login">

<div class="caixa-formulario grande">
    <h1>Cadastro - Etapa 1</h1>
    <p>Informe seus dados pessoais para criar sua conta.</p>

    <form action="salvar_usuario.php" method="POST">

        <label for="nome">Nome completo</label>
        <input
            type="text"
            id="nome"
            name="nome"
            required
            maxlength="150"
            autocomplete="name"
        >

        <label for="email">E-mail</label>
        <input
            type="email"
            id="email"
            name="email"
            required
            maxlength="254"
            placeholder="seuemail@exemplo.com"
            autocomplete="email"
        >

        <label for="cpf">CPF</label>
        <input
            type="text"
            id="cpf"
            name="cpf"
            required
            maxlength="14"
            placeholder="000.000.000-00"
            inputmode="numeric"
            autocomplete="off"
        >

        <label for="endereco">Endereço</label>
        <input
            type="text"
            id="endereco"
            name="endereco"
            required
            maxlength="200"
            autocomplete="street-address"
        >

        <label for="bairro">Bairro</label>
        <input
            type="text"
            id="bairro"
            name="bairro"
            required
            maxlength="100"
        >

        <label for="cidade">Cidade</label>
        <input
            type="text"
            id="cidade"
            name="cidade"
            required
            maxlength="100"
            autocomplete="address-level2"
        >

        <label for="estado">Estado</label>
        <input
            type="text"
            id="estado"
            name="estado"
            required
            maxlength="2"
            placeholder="SP"
            autocomplete="address-level1"
        >

        <label for="cep">CEP</label>
        <input
            type="text"
            id="cep"
            name="cep"
            required
            maxlength="9"
            placeholder="00000-000"
            inputmode="numeric"
            autocomplete="postal-code"
        >

        <button type="submit" name="b1" class="botao-principal">
            Continuar
        </button>

    </form>

    <a href="login.php" class="atalho-voltar">Voltar para o login</a>
</div>

</body>
</html>
