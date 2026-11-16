<?php
if (!isset($_SESSION)) session_start();
include "app/cons.php";
require_once "app/DLL.php";

extract($_POST, EXTR_SKIP);
$login = preg_replace("/[^a-zA-Z0-9_]/", "", trim($login ?? ""));
$senha = trim($senha ?? "");

if (empty($b1) || $login === "" || $senha === "") {
    $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Informe o login e a senha."];
    header("Location: login.php");
    exit;
}

// Acesso administrativo legado do projeto.
if ($login === "ADM" && $senha === "555") {
    session_regenerate_id(true);
    $_SESSION["logado"] = true;
    $_SESSION["adm"] = true;
    $_SESSION["login"] = "ADM";
    $_SESSION["nome"] = "Administrador";
    $_SESSION["id_usuario"] = 0;
    $_SESSION["aviso"] = ["tipo" => "sucesso", "texto" => "Login realizado com sucesso."];
    header("Location: adm.php");
    exit;
}

$loginSQL = addslashes($login);
$consulta = "SELECT l.id_usuario, l.login, l.senha, u.nome, u.cpf, u.email_verificado
             FROM login l INNER JOIN usuario u ON u.id_usuario = l.id_usuario
             WHERE l.login = '$loginSQL' LIMIT 1";
$resultado = banco($server, $user, $password, $db, $consulta);
$dadosLogin = $resultado->fetch_assoc();

if (!$dadosLogin || !password_verify($senha, $dadosLogin["senha"])) {
    $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Login ou senha incorretos."];
    header("Location: login.php");
    exit;
}
if (empty($dadosLogin["email_verificado"])) {
    $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Confirme seu e-mail antes de entrar."];
    header("Location: login.php");
    exit;
}

session_regenerate_id(true);
$_SESSION["logado"] = true;
$_SESSION["adm"] = false;
$_SESSION["login"] = $dadosLogin["login"];
$_SESSION["id_usuario"] = (int)$dadosLogin["id_usuario"];
$_SESSION["cpf"] = $dadosLogin["cpf"];
$_SESSION["nome"] = $dadosLogin["nome"];
$_SESSION["usuario"] = $dadosLogin;

if (!empty($_SESSION["adicionar_pendente"])) {
    $idUsuario = (int)$_SESSION["id_usuario"];
    $idProduto = (int)$_SESSION["adicionar_pendente"];
    $consulta = "INSERT INTO carrinho (id_usuario, id_produto, quantidade)
                 VALUES ('$idUsuario', '$idProduto', 1)
                 ON DUPLICATE KEY UPDATE quantidade = quantidade + 1";
    banco($server, $user, $password, $db, $consulta);
    unset($_SESSION["adicionar_pendente"]);
    $_SESSION["aviso"] = ["tipo" => "sucesso", "texto" => "Login realizado e jogo adicionado ao carrinho."];
    header("Location: carrinho.php");
} else {
    $_SESSION["aviso"] = ["tipo" => "sucesso", "texto" => "Login realizado com sucesso."];
    if (!empty($_SESSION["produto_pendente"]) || !empty($_SESSION["carrinho"])) {
        header("Location: confirmar.php");
    } else {
        header("Location: index.php");
    }
}
exit;
?>
