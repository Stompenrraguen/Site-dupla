<?php
if(!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";

if(empty($_SESSION["logado"])||empty($_SESSION["adm"])){
header("Location: index.php");
exit;
}

if(!isset($_POST["b1"])){
header("Location: adm.php");
exit;
}

$nome=trim($_POST["nome"]??"");
$descricao=trim($_POST["descricao"]??"");
$preco=(float)($_POST["preco"]??0);
$desenvolvedora=trim($_POST["desenvolvedora"]??"");
$publicadora=trim($_POST["publicadora"]??"");
$genero=trim($_POST["genero"]??"");
$plataformas=trim($_POST["plataformas"]??"");
$tamanho=trim($_POST["tamanho"]??"");
$versao=trim($_POST["versao"]??"");
$classificacao=trim($_POST["classificacao"]??"");
$idiomas=trim($_POST["idiomas"]??"");
$modo=trim($_POST["modo"]??"");
$data_lancamento=(int)($_POST["data_lancamento"]??0);
$licenca=trim($_POST["licenca"]??"");

if(empty($nome)||empty($descricao)||$preco<0||empty($_FILES["imagem"]["name"])){
header("Location: adm.php");
exit;
}

$extensao=strtolower(pathinfo($_FILES["imagem"]["name"],PATHINFO_EXTENSION));
$permitidas=["jpg","jpeg","png","webp"];

if(!in_array($extensao,$permitidas)){
header("Location: adm.php");
exit;
}

$nomeArquivo=basename($_FILES["imagem"]["name"]);
$pasta="IMG/";
$caminho=$pasta.$nomeArquivo;

if(!move_uploaded_file($_FILES["imagem"]["tmp_name"],$caminho)){
header("Location: adm.php");
exit;
}

$nomeBanco=$nome;
$descricaoBanco=$descricao;
$imagemBanco=$caminho;

$consulta="INSERT INTO produto(nome,descricao,preco,imagem,desenvolvedora,publicadora,genero,plataformas,tamanho,versao,classificacao,idiomas,modo,data_lancamento,licenca) VALUES('$nomeBanco','$descricaoBanco','$preco','$imagemBanco','$desenvolvedora','$publicadora','$genero','$plataformas','$tamanho','$versao','$classificacao','$idiomas','$modo','$data_lancamento','$licenca')";

banco($server,$user,$password,$db,$consulta);

header("Location: adm.php");
exit;
?>