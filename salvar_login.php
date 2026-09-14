<?php 
if (!isset($_SESSION)) session_start(); 

include "app/cons.php";
require_once "app/DLL.php";
 
if (!isset($_POST["b1"]) || empty($_SESSION["cpf_cadastro"])) { 
    header("Location: cadastro1.php"); 
    exit; 
} 
 
$cpf = $_SESSION["cpf_cadastro"]; 

$login = preg_replace("/[^a-zA-Z0-9_]/", "", trim($_POST["login"] ?? ""));
$senha = trim($_POST["senha"] ?? "");

if (empty($login) || empty($senha)) { 
    header("Location: cadastro2.php"); 
    exit; 
} 

$consulta = "SELECT * FROM login WHERE login = '$login'";
$resultado = banco($server, $user, $password, $db, $consulta);

if ($resultado->fetch_assoc()) {
    $_SESSION["erro_cadastro2"] = "login_existe";
    header("Location: cadastro2.php");
    exit;
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$consulta = "INSERT INTO login (login, senha, cpf)
             VALUES ('$login', '$senhaHash', '$cpf')";

banco($server, $user, $password, $db, $consulta);

unset($_SESSION["cpf_cadastro"]);
$_SESSION["cadastro_ok"] = "ok"; 
 
header("Location: login.php"); 
exit; 
?>
