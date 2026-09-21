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

$endereco = trim($_POST["endereco"] ?? "");
$bairro = trim($_POST["bairro"] ?? "");
$cidade = trim($_POST["cidade"] ?? "");
$estado = trim($_POST["estado"] ?? "");
$cep = trim($_POST["cep"] ?? "");

if (empty($nome) || empty($cpf)) {
    header("Location: cadastro1.php");
    exit;
}


$consulta_usuario = "INSERT INTO usuarios
(nome, cpf)
VALUES
('$nome', '$cpf')";

banco($server, $user, $password, $db, $consulta_usuario);

$consulta_id = "SELECT id_usuario FROM usuarios WHERE cpf = '$cpf'";

$resultado = banco($server, $user, $password, $db, $consulta_id);

$usuario = $resultado->fetch_assoc();

$id_usuario = $usuario["id_usuario"];

$consulta_endereco = "INSERT INTO endereco
(id_usuario, endereco, bairro, cidade, estado, cep)
VALUES
('$id_usuario', '$endereco', '$bairro', '$cidade', '$estado', '$cep')";

banco($server, $user, $password, $db, $consulta_endereco);

$_SESSION["cpf_cadastro"] = $cpf;

header("Location: cadastro2.php");
exit;

?>
