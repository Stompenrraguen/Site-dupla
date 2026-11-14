<?php
if(!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";

if(!isset($_POST["b1"])){
header("Location: login.php");
exit;
}

$login=preg_replace("/[^a-zA-Z0-9_]/","",trim($_POST["login"]??""));
$senha=trim($_POST["senha"]??"");

if(empty($login)||empty($senha)){
$_SESSION["erro_login"]="1";
header("Location: login.php");
exit;
}

if($login==="ADM"&&$senha==="555"){
$_SESSION["logado"]=true;
$_SESSION["adm"]=true;
$_SESSION["login"]="ADM";
$_SESSION["nome"]="Administrador";
header("Location: adm.php");
exit;
}

$consulta="SELECT * FROM login WHERE login='$login'";
$resultado=banco($server,$user,$password,$db,$consulta);
$dadosLogin=$resultado->fetch_assoc();

if(!$dadosLogin){
$_SESSION["erro_login"]="1";
header("Location: login.php");
exit;
}

if(!password_verify($senha,$dadosLogin["senha"])){
$_SESSION["erro_login"]="1";
header("Location: login.php");
exit;
}

$id_usuario=$dadosLogin["id_usuario"];

$consulta="SELECT * FROM usuario WHERE id_usuario='$id_usuario'";
$resultado=banco($server,$user,$password,$db,$consulta);
$dadosUsuario=$resultado->fetch_assoc();

if(!$dadosUsuario){
$_SESSION["erro_login"]="1";
header("Location: login.php");
exit;
}

$_SESSION["logado"]=true;
$_SESSION["adm"]=false;
$_SESSION["login"]=$dadosLogin["login"];
$_SESSION["id_usuario"]=$id_usuario;
$_SESSION["cpf"]=$dadosUsuario["cpf"];
$_SESSION["nome"]=$dadosUsuario["nome"];
$_SESSION["usuario"]=$dadosUsuario;

if(!empty($_SESSION["adicionar_pendente"])){
if(empty($_SESSION["carrinho"])) $_SESSION["carrinho"]=[];
$_SESSION["carrinho"][]=$_SESSION["adicionar_pendente"];
unset($_SESSION["adicionar_pendente"]);
header("Location: carrinho.php");
}elseif(!empty($_SESSION["produto_pendente"])||!empty($_SESSION["carrinho"])){
header("Location: confirmar.php");
}else{
header("Location: index.php");
}
exit;
?>