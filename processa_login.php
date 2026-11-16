<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "app/cons.php";
require_once "app/DLL.php";

extract($_POST, EXTR_SKIP);

$login = preg_replace("/[^a-zA-Z0-9_]/", "", trim($login ?? ""));
$senha = (string)($senha ?? "");

if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($b1) || $login === "" || $senha === "") {
    $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Informe o login e a senha."];
    header("Location: login.php");
    exit;
}

/* Credenciais administrativas legadas: substituir por autenticação segura antes de publicar. */
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
$consulta = "SELECT l.id_usuario, l.login, l.senha,
                    u.nome, u.cpf, u.email_verificado
             FROM login l
             INNER JOIN usuario u ON u.id_usuario = l.id_usuario
             WHERE l.login = '$loginSQL'
             LIMIT 1";
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

/* Migra itens adicionados antes do login para o carrinho no MySQL. */
if (!empty($_SESSION["carrinho"]) && is_array($_SESSION["carrinho"])) {
    foreach ($_SESSION["carrinho"] as $idProdutoSessao) {
        $idProdutoSessao = (int)$idProdutoSessao;
        if ($idProdutoSessao <= 0) {
            continue;
        }

        $consulta = "INSERT INTO carrinho (id_usuario, id_produto, quantidade)
                     SELECT '" . (int)$_SESSION["id_usuario"] . "', p.id_produto, 1
                     FROM produto p
                     WHERE p.id_produto = '$idProdutoSessao'
                     ON DUPLICATE KEY UPDATE quantidade = quantidade + 1";
        banco($server, $user, $password, $db, $consulta);
    }
    unset($_SESSION["carrinho"]);
}

if (!empty($_SESSION["adicionar_pendente"])) {
    $idProduto = (int)$_SESSION["adicionar_pendente"];

    $consulta = "INSERT INTO carrinho (id_usuario, id_produto, quantidade)
                 SELECT '" . (int)$_SESSION["id_usuario"] . "', p.id_produto, 1
                 FROM produto p
                 WHERE p.id_produto = '$idProduto'
                 ON DUPLICATE KEY UPDATE quantidade = quantidade + 1";
    banco($server, $user, $password, $db, $consulta);

    unset($_SESSION["adicionar_pendente"]);
    $_SESSION["aviso"] = [
        "tipo" => "sucesso",
        "texto" => "Login realizado e jogo adicionado ao carrinho."
    ];
    header("Location: carrinho.php");
    exit;
}

$_SESSION["aviso"] = ["tipo" => "sucesso", "texto" => "Login realizado com sucesso."];

if (!empty($_SESSION["produto_pendente"])) {
    header("Location: confirmar.php");
} else {
    header("Location: carrinho.php");
}
exit;
?>
