<?php

if (!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";


if ($_SERVER["REQUEST_METHOD"] != "POST") {

    header("Location: login.php");
    exit;

}


extract($_POST);


$login = addslashes(trim($login));


//LOGIN DO ADMINISTRADOR

if ($login == "adm" && $senha == "555") {

    $_SESSION["logado"] = "ok";

    $_SESSION["adm"] = "ok";

    $_SESSION["login"] = "adm";

    $_SESSION["nome"] = "Administrador";

    $_SESSION["id_usuario"] = 0;

    header("Location: adm.php");

    exit;
}


$senha = addslashes($senha);


//LOGIN NORMAL
$consulta = "SELECT
                login.id_usuario,
                login.login,
                login.senha,
                usuario.nome

             FROM login

             INNER JOIN usuario

             ON login.id_usuario =
                usuario.id_usuario

             WHERE login.login = '$login'

             AND login.senha = '$senha'";


$resultado = banco(
    $server,
    $user,
    $password,
    $db,
    $consulta
);


if (!$resultado || $resultado->num_rows == 0) {

    header("Location: login.php?erro=1");

    exit;

}


$dados = $resultado->fetch_assoc();

extract($dados);


$_SESSION["logado"] = "ok";

unset($_SESSION["adm"]);

$_SESSION["id_usuario"] = $id_usuario;

$_SESSION["nome"] = $nome;

$_SESSION["login"] = $login;


header("Location: index.php");

exit;

?>
