<?php
if (!isset($_SESSION)) session_start();
$erro = "";
$cadastro = "";
if (!empty($_SESSION["erro_login"])) { $erro = $_SESSION["erro_login"]; unset($_SESSION["erro_login"]); }
if (!empty($_SESSION["cadastro_ok"])) { $cadastro = $_SESSION["cadastro_ok"]; unset($_SESSION["cadastro_ok"]); }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Login - PoubreSteam</title><link rel="stylesheet" href="css/style.css?v=5"></head>
<body class="pagina-login">
<div class="caixa-formulario">
    <h1>Entrar na PoubreSteam</h1><p>Acesse sua conta para continuar.</p>
    <?php include "app/avisos.php"; ?>
    <?php if ($erro == "1"): ?><div class="alerta erro">Login ou senha incorretos.</div><?php endif; ?>
    <?php if ($cadastro == "ok"): ?><div class="alerta sucesso">Conta criada. Confirme o e-mail enviado antes de entrar.</div><?php endif; ?>
    <form action="processa_login.php" method="POST"><label for="login">Login</label><input id="login" type="text" name="login" required><label for="senha">Senha</label><input id="senha" type="password" name="senha" required><button type="submit" name="b1" value="1" class="botao-principal">Entrar</button></form>
    <a href="cadastro1.php" class="atalho-cadastro">Cadastrar novo usuário</a><a href="index.php" class="atalho-voltar">Voltar para a loja</a>
</div>
</body>
</html>
