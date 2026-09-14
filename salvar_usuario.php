<?php
if (!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";

if (!isset($_POST["b1"])) {
    header("Location: cadastro1.php");
    exit;
}

$cpf = preg_replace("/[^0-9]/", "", $_POST["cpf"] ?? "");
$nome = trim($_POST["nome"] ?? "");

if (empty($nome) || empty($cpf)) {
    header("Location: cadastro1.php");
    exit;
}

$endereco = trim($_POST["endereco"] ?? "");
$bairro = trim($_POST["bairro"] ?? "");
$cidade = trim($_POST["cidade"] ?? "");
$estado = trim($_POST["estado"] ?? "");
$cep = trim($_POST["cep"] ?? "");

$consulta = "INSERT INTO usuarios 
(nome, cpf, endereco, bairro, cidade, estado, cep)
VALUES 
('$nome', '$cpf', '$endereco', '$bairro', '$cidade', '$estado', '$cep')";

banco($server, $user, $password, $db, $consulta);

$_SESSION["cpf_cadastro"] = $cpf;

header("Location: cadastro2.php");
exit;
?>
