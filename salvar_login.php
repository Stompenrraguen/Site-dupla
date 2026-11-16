<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "app/cons.php";
require_once "app/DLL.php";
require_once "app/enviar_verificacao.php";

extract($_POST, EXTR_SKIP);

if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($b1) || empty($_SESSION["cpf_cadastro"])) {
    $_SESSION["aviso"] = [
        "tipo" => "erro",
        "texto" => "Reinicie o cadastro para continuar."
    ];
    header("Location: cadastro1.php");
    exit;
}

$cpf = addslashes($_SESSION["cpf_cadastro"]);
$login = preg_replace("/[^a-zA-Z0-9_]/", "", trim($login ?? ""));
$senha = (string)($senha ?? "");

if ($login === "" || strlen($senha) < 6) {
    $_SESSION["aviso"] = [
        "tipo" => "erro",
        "texto" => "Informe um login e uma senha com pelo menos 6 caracteres."
    ];
    header("Location: cadastro2.php");
    exit;
}

$loginSQL = addslashes($login);
$consulta = "SELECT id_login
             FROM login
             WHERE login = '$loginSQL'
             LIMIT 1";
$resultado = banco($server, $user, $password, $db, $consulta);

if ($resultado->num_rows > 0) {
    $_SESSION["aviso"] = [
        "tipo" => "erro",
        "texto" => "Este login já existe. Escolha outro."
    ];
    header("Location: cadastro2.php");
    exit;
}

$consulta = "SELECT id_usuario, nome, email
             FROM usuario
             WHERE cpf = '$cpf'
             LIMIT 1";
$resultado = banco($server, $user, $password, $db, $consulta);
$usuario = $resultado->fetch_assoc();

if (!$usuario) {
    $_SESSION["aviso"] = [
        "tipo" => "erro",
        "texto" => "Não encontramos os dados pessoais. Reinicie o cadastro."
    ];
    header("Location: cadastro1.php");
    exit;
}

$idUsuario = (int)$usuario["id_usuario"];
$nome = $usuario["nome"];
$email = $usuario["email"];
$senhaSQL = addslashes(password_hash($senha, PASSWORD_DEFAULT));

$consulta = "INSERT INTO login (login, senha, id_usuario)
             VALUES ('$loginSQL', '$senhaSQL', '$idUsuario')";
banco($server, $user, $password, $db, $consulta);

$token = bin2hex(random_bytes(32));
$tokenHash = hash("sha256", $token);

$consulta = "UPDATE usuario
             SET token_verificacao = '$tokenHash',
                 email_verificado = 0
             WHERE id_usuario = '$idUsuario'";
banco($server, $user, $password, $db, $consulta);

if (!enviarVerificacao($email, $nome, $token)) {
    $_SESSION["aviso"] = [
        "tipo" => "erro",
        "texto" => "A conta foi cadastrada, mas não foi possível enviar o e-mail de confirmação. Verifique a configuração SMTP."
    ];
    header("Location: login.php");
    exit;
}

unset($_SESSION["cpf_cadastro"]);

$_SESSION["aviso"] = [
    "tipo" => "sucesso",
    "texto" => "Cadastro concluído. Confirme seu e-mail antes de entrar."
];

header("Location: login.php");
exit;
?>
