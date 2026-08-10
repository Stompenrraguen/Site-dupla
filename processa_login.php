<?php
if (!isset($_SESSION)) session_start();

if (!isset($_POST["b1"])) {
    header("Location: login.php");
    exit;
}

$login = preg_replace("/[^a-zA-Z0-9_]/", "", trim($_POST["login"] ?? ""));
$senha = trim($_POST["senha"] ?? "");
$arquivoLogin = "login/".$login.".DAT";

if (!file_exists($arquivoLogin)) {
    $_SESSION["erro_login"] = "1";
    header("Location: login.php");
    exit;
}

$f = fopen($arquivoLogin, "r");
$loginSalvo = trim(fgets($f, 1000));
$senhaSalva = trim(fgets($f, 1000));
$cpf = trim(fgets($f, 1000));
fclose($f);

if (md5($senha) != $senhaSalva) {
    $_SESSION["erro_login"] = "1";
    header("Location: login.php");
    exit;
}

$arquivoUsuario = "usuarios/".$cpf.".DAT";

if (!file_exists($arquivoUsuario)) {
    $_SESSION["erro_login"] = "1";
    header("Location: login.php");
    exit;
}

$fu = fopen($arquivoUsuario, "r");
$dadosUsuario = [];
$dadosUsuario["nome"] = trim(fgets($fu, 1000));
$dadosUsuario["cpf"] = trim(fgets($fu, 1000));
$dadosUsuario["endereco"] = trim(fgets($fu, 1000));
$dadosUsuario["bairro"] = trim(fgets($fu, 1000));
$dadosUsuario["cidade"] = trim(fgets($fu, 1000));
$dadosUsuario["estado"] = trim(fgets($fu, 1000));
$dadosUsuario["cep"] = trim(fgets($fu, 1000));
fclose($fu);

$_SESSION["logado"]  = true;
$_SESSION["login"]   = $loginSalvo;
$_SESSION["cpf"]     = $cpf;
$_SESSION["nome"]    = $dadosUsuario["nome"];
$_SESSION["usuario"] = $dadosUsuario;

if (!empty($_SESSION["adicionar_pendente"])) {
    if (empty($_SESSION["carrinho"])) {
        $_SESSION["carrinho"] = [];
    }

    $_SESSION["carrinho"][] = $_SESSION["adicionar_pendente"];
    unset($_SESSION["adicionar_pendente"]);

    header("Location: carrinho.php");
} else if (!empty($_SESSION["produto_pendente"]) || !empty($_SESSION["carrinho"])) {
    header("Location: confirmar.php");
} else {
    header("Location: index.php");
}
exit;
?>
?>
