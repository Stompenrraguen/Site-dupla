<?php
if (!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";
require_once "app/enviar_verificacao.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: cadastro1.php");
    exit;
}

extract($_POST);

$email = strtolower(trim($email));

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "E-mail inválido.";
    exit;
}

$emailEnvio = $email;
$token = bin2hex(random_bytes(32));
$tokenHash = hash('sha256', $token);
$cpf = preg_replace("/[^0-9]/", "", $cpf);
$cep = preg_replace("/[^0-9]/", "", $cep);
$estado = strtoupper(trim($estado));

if (strlen($cpf) != 11 || strlen($cep) != 8 || strlen($estado) != 2) {
    echo "Dados inválidos. Verifique CPF, CEP e Estado.";
    exit;
}

$nome = addslashes(trim($nome));
$cpf = addslashes($cpf);
$endereco = addslashes(trim($endereco));
$bairro = addslashes(trim($bairro));
$cidade = addslashes(trim($cidade));
$estado = addslashes($estado);
$cep = addslashes($cep);
$login = addslashes(trim($login));
$senha = addslashes($senha);

$email = addslashes($email);

$consulta = "INSERT INTO usuario
(nome, cpf, email, email_verificado, token_verificacao)
VALUES
('$nome', '$cpf', '$email', 0, '$tokenHash')";

banco($server, $user, $password, $db, $consulta);

$consulta = "SELECT id_usuario
             FROM usuario
             WHERE cpf = '$cpf'";

$resultado = banco($server, $user, $password, $db, $consulta);

if (!$resultado || $resultado->num_rows == 0) {
    echo "Não foi possível localizar o usuário cadastrado.";
    exit;
}

$dados = $resultado->fetch_assoc();

extract($dados);

$consulta = "INSERT INTO endereco
             (id_usuario, endereco, bairro, cidade, estado, cep)
             VALUES
             ('$id_usuario', '$endereco', '$bairro', '$cidade', '$estado', '$cep')";

banco($server, $user, $password, $db, $consulta);

$consulta = "INSERT INTO login
             (id_usuario, login, senha)
             VALUES
             ('$id_usuario', '$login', '$senha')";

banco($server, $user, $password, $db, $consulta);
if (enviarVerificacao($emailEnvio, stripslashes($nome), $token)) {

    header("Location: login.php?cadastro=email_enviado");
    exit;

} else {

    echo "Cadastro realizado, mas não foi possível enviar o e-mail. Verifique a configuração SMTP.";
    exit;

}
?>
