<?php
if (!isset($_SESSION)) session_start();

if (!isset($_POST["b1"])) {
    header("Location: cadastro1.php");
    exit;
}

$cpf = preg_replace("/[^0-9]/", "", $_POST["cpf"] ?? "");
$nome = trim($_POST["nome"] ?? "");

if (empty($nome) || empty($cpf)) {
    header("Location: cadastro1.php");
    exit;
}

if (!is_dir("usuarios")) {
    mkdir("usuarios", 0777, true);
}

$arquivo = fopen("usuarios/".$cpf.".DAT", "w");
fwrite($arquivo, $nome."\n");
fwrite($arquivo, $cpf."\n");
fwrite($arquivo, trim($_POST["endereco"] ?? "")."\n");
fwrite($arquivo, trim($_POST["bairro"] ?? "")."\n");
fwrite($arquivo, trim($_POST["cidade"] ?? "")."\n");
fwrite($arquivo, trim($_POST["estado"] ?? "")."\n");
fwrite($arquivo, trim($_POST["cep"] ?? "")."\n");
fclose($arquivo);

$_SESSION["cpf_cadastro"] = $cpf;

header("Location: cadastro2.php");
exit;
?>
