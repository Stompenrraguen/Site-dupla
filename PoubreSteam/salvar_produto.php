
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "app/cons.php";
require_once "app/DLL.php";

// Verifica se o usuário é administrador.
if (
    empty($_SESSION["logado"]) ||
    empty($_SESSION["adm"])
) {
    header("Location: index.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: adm.php");
    exit;
}

extract($_POST, EXTR_SKIP);


$nome = trim($nome ?? "");
$descricao = trim($descricao ?? "");
$preco = str_replace(",", ".", trim($preco ?? ""));
$imagem = trim($imagem ?? "");

$desenvolvedora = trim($desenvolvedora ?? "");
$publicadora = trim($publicadora ?? "");
$genero = trim($genero ?? "");
$plataformas = trim($plataformas ?? "");
$tamanho = trim($tamanho ?? "");
$versao = trim($versao ?? "");
$classificacao = trim($classificacao ?? "");
$idiomas = trim($idiomas ?? "");
$modo = trim($modo ?? "");
$data_lancamento = trim($data_lancamento ?? "");
$licenca = trim($licenca ?? "");


if (
    $nome === "" ||
    strlen($nome) > 150 ||
    $descricao === "" ||
    !is_numeric($preco) ||
    (float)$preco < 0 ||
    !is_finite((float)$preco) ||
    $imagem === ""
) {
    header("Location: adm.php?erro=1");
    exit;
}


if (
    strlen($desenvolvedora) > 100 ||
    strlen($publicadora) > 100 ||
    strlen($genero) > 100 ||
    strlen($plataformas) > 100 ||
    strlen($tamanho) > 30 ||
    strlen($versao) > 20 ||
    strlen($classificacao) > 30 ||
    strlen($idiomas) > 100 ||
    strlen($modo) > 100 ||
    strlen($licenca) > 150
) {
    header("Location: adm.php?erro=1");
    exit;
}

if (
    $data_lancamento !== "" &&
    (
        !ctype_digit($data_lancamento) ||
        (int)$data_lancamento < 1901 ||
        (int)$data_lancamento > 2155
    )
) {
    header("Location: adm.php?erro=1");
    exit;
}


$imagem = str_replace("\\", "/", $imagem);

if (strpos($imagem, "../") !== false || strpos($imagem, "/") === 0) {
    header("Location: adm.php?erro=1");
    exit;
}

if (strpos($imagem, "/") === false) {
    $imagem = "img/" . $imagem;
} elseif (strpos($imagem, "img/") !== 0) {
    header("Location: adm.php?erro=1");
    exit;
}


$preco = number_format((float)$preco, 2, ".", "");

$data_lancamento_sql = $data_lancamento === ""
    ? "NULL"
    : "'" . (int)$data_lancamento . "'";

$consulta = "INSERT INTO produto (
                nome,
                descricao,
                preco,
                imagem,
                desenvolvedora,
                publicadora,
                genero,
                plataformas,
                tamanho,
                versao,
                classificacao,
                idiomas,
                modo,
                data_lancamento,
                licenca
             ) VALUES (
                '" . addslashes($nome) . "',
                '" . addslashes($descricao) . "',
                '$preco',
                '" . addslashes($imagem) . "',
                '" . addslashes($desenvolvedora) . "',
                '" . addslashes($publicadora) . "',
                '" . addslashes($genero) . "',
                '" . addslashes($plataformas) . "',
                '" . addslashes($tamanho) . "',
                '" . addslashes($versao) . "',
                '" . addslashes($classificacao) . "',
                '" . addslashes($idiomas) . "',
                '" . addslashes($modo) . "',
                $data_lancamento_sql,
                '" . addslashes($licenca) . "'
             )";

banco($server, $user, $password, $db, $consulta);


header("Location: adm.php?ok=1");
exit;

?>
