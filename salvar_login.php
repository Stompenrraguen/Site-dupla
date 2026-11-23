
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "app/cons.php";
require_once "app/DLL.php";
require_once "app/enviar_verificacao.php";

if (!isset($_POST["b1"]) || empty($_SESSION["cpf_cadastro"])) {
    header("Location: cadastro1.php");
    exit;
}

$cpf = $_SESSION["cpf_cadastro"];
$login = preg_replace("/[^a-zA-Z0-9_]/", "", trim($_POST["login"] ?? ""));
$senha = trim($_POST["senha"] ?? "");

if (empty($login) || empty($senha)) {
    $_SESSION["erro_cadastro2"] = "campos_vazios";
    header("Location: cadastro2.php");
    exit;
}

$consulta = "SELECT login FROM login WHERE login = '$login'";
$resultado = banco($server, $user, $password, $db, $consulta);

if ($resultado && $resultado->num_rows > 0) {
    $_SESSION["erro_cadastro2"] = "login_existe";
    header("Location: cadastro2.php");
    exit;
}

$consulta_usuario = "SELECT id_usuario, nome, email
                     FROM usuario
                     WHERE cpf = '$cpf'";

$resultado_usuario = banco($server, $user, $password, $db, $consulta_usuario);
$usuario = $resultado_usuario ? $resultado_usuario->fetch_assoc() : null;

if (!$usuario) {
    $_SESSION["erro_cadastro2"] = "usuario_nao_encontrado";
    header("Location: cadastro2.php");
    exit;
}

$id_usuario = $usuario["id_usuario"];
$nome = $usuario["nome"];
$email = $usuario["email"];

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$consulta_login = "INSERT INTO login (login, senha, id_usuario)
                   VALUES ('$login', '$senhaHash', '$id_usuario')";

banco($server, $user, $password, $db, $consulta_login);

$token = bin2hex(random_bytes(32));

$consulta_token = "UPDATE usuario
                   SET token_verificacao = SHA2('$token', 256),
                       email_verificado = 0
                   WHERE id_usuario = '$id_usuario'";

banco($server, $user, $password, $db, $consulta_token);

if (!enviarVerificacao($email, $nome, $token)) {
    unset($_SESSION["cpf_cadastro"]);
    unset($_SESSION["email_cadastro"]);

    $_SESSION["erro_verificacao"] = "Cadastro realizado, mas não foi possível enviar o e-mail de verificação. Entre em contato com o suporte.";

    header("Location: login.php");
    exit;
}

unset($_SESSION["cpf_cadastro"]);
unset($_SESSION["email_cadastro"]);

$_SESSION["cadastro_ok"] = "ok";

header("Location: login.php");
exit;
?>
