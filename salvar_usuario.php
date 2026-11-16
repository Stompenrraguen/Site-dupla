<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "app/cons.php";
require_once "app/DLL.php";

extract($_POST, EXTR_SKIP);

if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($b1)) {
    header("Location: cadastro1.php");
    exit;
}

$nome = trim($nome ?? "");
$email = strtolower(trim($email ?? ""));
$cpf = preg_replace("/[^0-9]/", "", $cpf ?? "");
$endereco = trim($endereco ?? "");
$bairro = trim($bairro ?? "");
$cidade = trim($cidade ?? "");
$estado = strtoupper(trim($estado ?? ""));
$cep = preg_replace("/[^0-9]/", "", $cep ?? "");

if (
    $nome === "" ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    strlen($cpf) !== 11 ||
    $endereco === "" ||
    $bairro === "" ||
    $cidade === "" ||
    strlen($estado) !== 2 ||
    strlen($cep) !== 8
) {
    $_SESSION["aviso"] = [
        "tipo" => "erro",
        "texto" => "Confira os dados informados. CPF e CEP devem ter 11 e 8 números."
    ];
    header("Location: cadastro1.php");
    exit;
}

$nomeSQL = addslashes($nome);
$emailSQL = addslashes($email);
$cpfSQL = addslashes($cpf);
$enderecoSQL = addslashes($endereco);
$bairroSQL = addslashes($bairro);
$cidadeSQL = addslashes($cidade);
$estadoSQL = addslashes($estado);
$cepSQL = addslashes($cep);

$consulta = "SELECT id_usuario
             FROM usuario
             WHERE cpf = '$cpfSQL' OR email = '$emailSQL'
             LIMIT 1";
$resultado = banco($server, $user, $password, $db, $consulta);

if ($resultado->num_rows > 0) {
    $_SESSION["aviso"] = [
        "tipo" => "erro",
        "texto" => "Este CPF ou e-mail já está cadastrado."
    ];
    header("Location: cadastro1.php");
    exit;
}

$consulta = "INSERT INTO usuario (nome, cpf, email)
             VALUES ('$nomeSQL', '$cpfSQL', '$emailSQL')";
banco($server, $user, $password, $db, $consulta);

$consulta = "SELECT id_usuario
             FROM usuario
             WHERE cpf = '$cpfSQL'
             LIMIT 1";
$resultado = banco($server, $user, $password, $db, $consulta);
$usuario = $resultado->fetch_assoc();

if (!$usuario) {
    $_SESSION["aviso"] = [
        "tipo" => "erro",
        "texto" => "Não foi possível localizar os dados do cadastro."
    ];
    header("Location: cadastro1.php");
    exit;
}

$idUsuario = (int)$usuario["id_usuario"];

$consulta = "INSERT INTO endereco
                (id_usuario, endereco, bairro, cidade, estado, cep)
             VALUES
                ('$idUsuario', '$enderecoSQL', '$bairroSQL', '$cidadeSQL',
                 '$estadoSQL', '$cepSQL')";
banco($server, $user, $password, $db, $consulta);

$_SESSION["cpf_cadastro"] = $cpf;
$_SESSION["email_cadastro"] = $email;
$_SESSION["aviso"] = [
    "tipo" => "sucesso",
    "texto" => "Dados pessoais salvos. Agora crie seu login e senha."
];

header("Location: cadastro2.php");
exit;
?>
