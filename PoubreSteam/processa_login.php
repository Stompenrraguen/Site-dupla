
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "app/cons.php";
require_once "app/DLL.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

extract($_POST, EXTR_SKIP);


if (!isset($login, $senha) || $login === "" || $senha === "") {
    header("Location: login.php?erro=1");
    exit;
}

$login = trim($login);

// LOGIN DO ADMINISTRADOR
if ($login === "adm" && $senha === "555") {

    $_SESSION["logado"] = "ok";
    $_SESSION["adm"] = "ok";
    $_SESSION["login"] = "adm";
    $_SESSION["nome"] = "Administrador";
    $_SESSION["id_usuario"] = 0;

    header("Location: adm.php");
    exit;
}

// LOGIN DE USUÁRIO
$consulta = "SELECT
                login.id_usuario,
                login.login,
                login.senha,
                usuario.nome
             FROM login
             INNER JOIN usuario
             ON login.id_usuario = usuario.id_usuario
             WHERE login.login = '" . addslashes($login) . "'";

$resultado = banco($server, $user, $password, $db, $consulta);

if ($resultado->num_rows === 0) {
    header("Location: login.php?erro=1");
    exit;
}


$senha_digitada = $senha;

extract($resultado->fetch_assoc(), EXTR_OVERWRITE);

if (!password_verify($senha_digitada, $senha)) {
    header("Location: login.php?erro=1");
    exit;
}


$_SESSION["logado"] = "ok";

unset($_SESSION["adm"]);

$_SESSION["id_usuario"] = $id_usuario;
$_SESSION["nome"] = $nome;
$_SESSION["login"] = $login;

header("Location: index.php");
exit;

?>
