<?php
if (!isset($_SESSION)) session_start();

if (!isset($_POST["b1"]) || empty($_SESSION["cpf_cadastro"])) {
    header("Location: cadastro1.php");
    exit;
}

$cpf   = $_SESSION["cpf_cadastro"];
$login = preg_replace("/[^a-zA-Z0-9_]/", "", trim($login);
$senha = trim($senha) ?? "");

if (empty($login) || empty($senha)) {
    header("Location: cadastro2.php");
    exit;
}

if (!is_dir("login")) {
    mkdir("login", 0777, true);
}

$arquivoLogin = "login/".$login.".DAT";

if (file_exists($arquivoLogin)) {
    $_SESSION["erro_cadastro2"] = "login_existe";
    header("Location: cadastro2.php");
    exit;
}

$f = fopen($arquivoLogin, "w");
fwrite($f, $login."\n");
fwrite($f, md5($senha)."\n");
fwrite($f, $cpf."\n");
fclose($f);

unset($_SESSION["cpf_cadastro"]); // Remove o CPF temporário usado durante o cadastro.
$_SESSION["cadastro_ok"] = "ok";

header("Location: login.php");
exit;
?>
