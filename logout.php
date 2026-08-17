<?php
if (!isset($_SESSION)) session_start();

unset($_SESSION["logado"], $_SESSION["login"], $_SESSION["cpf"], $_SESSION["nome"], $_SESSION["usuario"], $_SESSION["produto_pendente"], $_SESSION["carrinho"]);
session_destroy();

header("Location: index.php");
exit;
?>
