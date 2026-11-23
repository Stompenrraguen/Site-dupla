
<?php
if(!isset($_SESSION)) session_start();

function avisar($tipo, $mensagem){
    $_SESSION["aviso_tipo"] = $tipo;
    $_SESSION["aviso_mensagem"] = $mensagem;
    header("Location: adm.php");
    exit;
}

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

if(empty($nome)){
    avisar("erro", "Informe o nome do produto.");
}

if(empty($descricao)){
    avisar("erro", "Informe a descrição do produto.");
}

if($preco < 0){
    avisar("erro", "O preço informado é inválido.");
}

if(empty($_FILES["imagem"]["name"])){
    avisar("erro", "Selecione uma imagem para o produto.");
}

if(empty($nome)||empty($descricao)||$preco<0||empty($_FILES["imagem"]["name"])){
header("Location: adm.php");
exit;
}

$extensao=strtolower(pathinfo($_FILES["imagem"]["name"],PATHINFO_EXTENSION));
$permitidas=["jpg","jpeg","png","webp"];

if(!in_array($extensao,$permitidas)){
    avisar("erro", "Formato de imagem inválido. Use JPG, JPEG, PNG ou WEBP.");
    header("Location: adm.php");
    exit;
}

$nomeArquivo=basename($_FILES["imagem"]["name"]);
$pasta="IMG/";
$caminho=$pasta.$nomeArquivo;

if(!move_uploaded_file($_FILES["imagem"]["tmp_name"],$caminho)){
    avisar("erro", "Não foi possível enviar a imagem do produto.");
    header("Location: adm.php");
    exit;
}

$nomeBanco=$nome;
$descricaoBanco=$descricao;
$imagemBanco=$caminho;

$consulta="INSERT INTO produto(nome,descricao,preco,imagem,desenvolvedora,publicadora,genero,plataformas,tamanho,versao,classificacao,idiomas,modo,data_lancamento,licenca) VALUES('$nomeBanco','$descricaoBanco','$preco','$imagemBanco','$desenvolvedora','$publicadora','$genero','$plataformas','$tamanho','$versao','$classificacao','$idiomas','$modo','$data_lancamento','$licenca')";

banco($server,$user,$password,$db,$consulta);

avisar("sucesso", "Produto adicionado com sucesso à loja!");

header("Location: adm.php");
exit;
?>
