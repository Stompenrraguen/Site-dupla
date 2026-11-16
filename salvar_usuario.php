
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "app/cons.php";
require_once "app/DLL.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: cadastro1.php");
    exit;
}

extract($_POST);

$nome = trim($nome ?? "");
$cpf = preg_replace("/\D/", "", $cpf ?? "");
$email = trim($email ?? "");

$endereco = trim($endereco ?? "");
$bairro = trim($bairro ?? "");
$cidade = trim($cidade ?? "");
$estado = strtoupper(trim($estado ?? ""));
$cep = preg_replace("/\D/", "", $cep ?? "");

$login = trim($login ?? "");
$senha = $senha ?? "";

// Validação.
if (
    $nome === "" || strlen($nome) > 150 ||
    strlen($cpf) !== 11 ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150 ||
    $endereco === "" || strlen($endereco) > 200 ||
    $bairro === "" || strlen($bairro) > 100 ||
    $cidade === "" || strlen($cidade) > 100 ||
    !preg_match("/^[A-Z]{2}$/", $estado) ||
    strlen($cep) !== 8 ||
    $login === "" || strlen($login) > 50 ||
    strlen($senha) < 8
) {
    header("Location: cadastro1.php?erro=1");
    exit;
}


$senha = password_hash($senha, PASSWORD_DEFAULT);

// Cadastro do usuário.
$consulta = "INSERT INTO usuario (nome, cpf, email)
             VALUES (
                 '" . addslashes($nome) . "',
                 '" . addslashes($cpf) . "',
                 '" . addslashes($email) . "'
             )";

banco($server, $user, $password, $db, $consulta);


$consulta = "SELECT id_usuario
             FROM usuario
             WHERE cpf = '" . addslashes($cpf) . "'";

$resultado = banco($server, $user, $password, $db, $consulta);

if ($resultado->num_rows === 0) {
    header("Location: cadastro1.php?erro=1");
    exit;
}

extract($resultado->fetch_assoc());

$consulta = "INSERT INTO endereco
             (id_usuario, endereco, bairro, cidade, estado, cep)
             VALUES (
                 '$id_usuario',
                 '" . addslashes($endereco) . "',
                 '" . addslashes($bairro) . "',
                 '" . addslashes($cidade) . "',
                 '" . addslashes($estado) . "',
                 '" . addslashes($cep) . "'
             )";

banco($server, $user, $password, $db, $consulta);

$consulta = "INSERT INTO login (id_usuario, login, senha)
             VALUES (
                 '$id_usuario',
                 '" . addslashes($login) . "',
                 '" . addslashes($senha) . "'
             )";

banco($server, $user, $password, $db, $consulta);

header("Location: login.php?cadastro=ok");
exit;

?>
