<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

extract($_POST, EXTR_SKIP);

$_POST["pagamento"] = $forma_pagamento ?? $pagamento ?? "";
$_POST["b1"] = "1";

require "salvar_venda.php";
?>
