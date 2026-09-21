
<?php

if (!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";

if (!isset($_POST["b1"])) {
    header("Location: login.php");
    exit;
}


$login = preg_replace(
    "/[^a-zA-Z0-9_]/",
    "",
    trim($_POST["login"] ?? "")
);

$senha = trim($_POST["senha"] ?? "");


if (empty($login) || empty($senha)) {
    $_SESSION["erro_login"] = "1";
    header("Location: login.php");
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

$dadosLogin = $resultado->fetch_assoc();


if (!$dadosLogin) {
    $_SESSION["erro_login"] = "1";
    header("Location: login.php");
    exit;
}



$loginSalvo = $dadosLogin["login"];
$senhaSalva = $dadosLogin["senha"];
$id_usuario = $dadosLogin["id_usuario"];


if (!password_verify($senha, $senhaSalva)) {

    $_SESSION["erro_login"] = "1";

    header("Location: login.php");
    exit;
}

$consulta = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";

$resultado = banco(
    $server,
    $user,
    $password,
    $db,
    $consulta
);

$dadosUsuario = $resultado->fetch_assoc();


if (!$dadosUsuario) {

    $_SESSION["erro_login"] = "1";

    header("Location: login.php");
    exit;
}


$_SESSION["logado"]  = true;
$_SESSION["login"]   = $loginSalvo;
$_SESSION["id_usuario"] = $id_usuario;
$_SESSION["cpf"]     = $dadosUsuario["cpf"];
$_SESSION["nome"]    = $dadosUsuario["nome"];
$_SESSION["usuario"] = $dadosUsuario;



if (!empty($_SESSION["adicionar_pendente"])) {

    if (empty($_SESSION["carrinho"])) {
        $_SESSION["carrinho"] = [];
    }

    $_SESSION["carrinho"][] = $_SESSION["adicionar_pendente"];

    unset($_SESSION["adicionar_pendente"]);

    header("Location: carrinho.php");



} else if (
    !empty($_SESSION["produto_pendente"]) ||
    !empty($_SESSION["carrinho"])
) {

    header("Location: confirmar.php");


} else {

    header("Location: index.php");
}


exit;

?>
