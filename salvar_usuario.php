<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$email = $_SESSION['dados_cadastro']['email'] ?? ($_POST['email'] ?? '');

$email = strtolower(trim($email));

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("E-mail inválido.");
}
if (!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";
require_once "app/enviar_verificacao.php";

if (!isset($_POST["b1"])) {
    header("Location: cadastro1.php");
    exit;
}

extract($_POST);

$email = strtolower(trim($email));

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "E-mail inválido.";
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


$consulta_usuario = "INSERT INTO usuario
(nome, cpf)
VALUES
('$nome', '$cpf')";

banco($server, $user, $password, $db, $consulta_usuario);

$consulta_id = "SELECT id_usuario FROM usuario WHERE cpf = '$cpf'";

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
