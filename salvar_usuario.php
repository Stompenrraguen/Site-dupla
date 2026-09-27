<?php
if (!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: cadastro1.php");
    exit;
}

extract($_POST);

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

$consulta = "INSERT INTO usuario (nome, cpf)
             VALUES ('$nome', '$cpf')";

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

header("Location: login.php?cadastro=ok");
exit;
?>
