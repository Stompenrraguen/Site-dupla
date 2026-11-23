
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "app/cons.php";
require_once "app/DLL.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["b1"])) {
    header("Location: cadastro1.php");
    exit;
}

$nome = trim($_POST["nome"] ?? "");
$email = strtolower(trim($_POST["email"] ?? ""));
$cpf = preg_replace("/[^0-9]/", "", $_POST["cpf"] ?? "");

$endereco = trim($_POST["endereco"] ?? "");
$bairro = trim($_POST["bairro"] ?? "");
$cidade = trim($_POST["cidade"] ?? "");
$estado = trim($_POST["estado"] ?? "");
$cep = trim($_POST["cep"] ?? "");

if (empty($nome)) {
    $_SESSION["erro_cadastro1"] = "Informe seu nome completo.";
    header("Location: cadastro1.php");
    exit;
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["erro_cadastro1"] = "Informe um endereço de e-mail válido.";
    header("Location: cadastro1.php");
    exit;
}

if (strlen($cpf) != 11) {
    $_SESSION["erro_cadastro1"] = "O CPF informado é inválido. Confira os 11 números.";
    header("Location: cadastro1.php");
    exit;
}

if (empty($endereco) || empty($bairro) || empty($cidade) || empty($estado) || empty($cep)) {
    $_SESSION["erro_cadastro1"] = "Preencha todos os campos de endereço.";
    header("Location: cadastro1.php");
    exit;
}

$consulta = "SELECT id_usuario FROM usuario WHERE cpf = '$cpf'";
$resultado = banco($server, $user, $password, $db, $consulta);

if ($resultado && $resultado->num_rows > 0) {
    $_SESSION["erro_cadastro1"] = "Este CPF já está cadastrado.";
    header("Location: cadastro1.php");
    exit;
}

$consulta_email = "SELECT id_usuario FROM usuario WHERE email = '$email'";
$resultado_email = banco($server, $user, $password, $db, $consulta_email);

if ($resultado_email && $resultado_email->num_rows > 0) {
    $_SESSION["erro_cadastro1"] = "Este e-mail já está cadastrado.";
    header("Location: cadastro1.php");
    exit;
}

$consulta_usuario = "INSERT INTO usuario (nome, cpf, email)
                     VALUES ('$nome', '$cpf', '$email')";

banco($server, $user, $password, $db, $consulta_usuario);

$consulta_id = "SELECT id_usuario FROM usuario WHERE cpf = '$cpf'";
$resultado = banco($server, $user, $password, $db, $consulta_id);

if (!$resultado || !($usuario = $resultado->fetch_assoc())) {
    $_SESSION["erro_cadastro1"] = "Não foi possível recuperar os dados do usuário cadastrado.";
    header("Location: cadastro1.php");
    exit;
}

$id_usuario = $usuario["id_usuario"];

$consulta_endereco = "INSERT INTO endereco
(id_usuario, endereco, bairro, cidade, estado, cep)
VALUES
('$id_usuario', '$endereco', '$bairro', '$cidade', '$estado', '$cep')";

banco($server, $user, $password, $db, $consulta_endereco);

$_SESSION["cpf_cadastro"] = $cpf;
$_SESSION["email_cadastro"] = $email;

header("Location: cadastro2.php");
exit;
?>
