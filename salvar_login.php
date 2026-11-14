<?php

if (!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";

if (!isset($_POST["b1"]) || empty($_SESSION["cpf_cadastro"])) {
    header("Location: cadastro1.php");
    exit;
}

$cpf = $_SESSION["cpf_cadastro"];


$login = preg_replace(
    "/[^a-zA-Z0-9_]/",
    "",
    trim($_POST["login"] ?? "")
);

$senha = trim($_POST["senha"] ?? "");


if (empty($login) || empty($senha)) {
    header("Location: cadastro2.php");
    exit;
}


$consulta = "SELECT * FROM login WHERE login = '$login'";

$resultado = banco(
    $server,
    $user,
    $password,
    $db,
    $consulta
);


if ($resultado->fetch_assoc()) {

    $_SESSION["erro_cadastro2"] = "login_existe";

    header("Location: cadastro2.php");
    exit;
}


$consulta_usuario = "SELECT id_usuario
                     FROM usuario
                     WHERE cpf = '$cpf'";

$resultado_usuario = banco(
    $server,
    $user,
    $password,
    $db,
    $consulta_usuario
);


$usuario = $resultado_usuario->fetch_assoc();


if (!$usuario) {

    $_SESSION["erro_cadastro2"] = "usuario_nao_encontrado";

    header("Location: cadastro1.php");
    exit;
}


$id_usuario = $usuario["id_usuario"];

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);


$consulta_login = "INSERT INTO login
                   (login, senha, id_usuario)
                   VALUES
                   ('$login', '$senhaHash', '$id_usuario')";


banco(
    $server,
    $user,
    $password,
    $db,
    $consulta_login
);


unset($_SESSION["cpf_cadastro"]);

$_SESSION["cadastro_ok"] = "ok";


header("Location: login.php");
exit;

?>
