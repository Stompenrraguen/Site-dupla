<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "app/cons.php";
require_once "app/DLL.php";

if (empty($_SESSION["logado"]) || empty($_SESSION["adm"])) {
    $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Acesso restrito ao administrador."];
    header("Location: index.php");
    exit;
}

extract($_POST, EXTR_SKIP);

if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($b1)) {
    header("Location: adm.php");
    exit;
}

$nome = trim($nome ?? "");
$descricao = trim($descricao ?? "");
$precoTexto = trim($preco ?? "");
$desenvolvedora = trim($desenvolvedora ?? "");
$publicadora = trim($publicadora ?? "");
$genero = trim($genero ?? "");
$plataformas = trim($plataformas ?? "");
$tamanho = trim($tamanho ?? "");
$versao = trim($versao ?? "");
$classificacao = trim($classificacao ?? "");
$idiomas = trim($idiomas ?? "");
$modo = trim($modo ?? "");
$dataLancamento = (int)($data_lancamento ?? 0);
$licenca = trim($licenca ?? "");

if (
    $nome === "" ||
    $descricao === "" ||
    $precoTexto === "" ||
    !is_numeric($precoTexto) ||
    (float)$precoTexto < 0 ||
    empty($_FILES["imagem"]["tmp_name"])
) {
    $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Preencha nome, descrição, preço e escolha uma imagem válida."];
    header("Location: adm.php");
    exit;
}

$preco = (float)$precoTexto;
$arquivo = $_FILES["imagem"];
$maxBytes = 5 * 1024 * 1024;

if (($arquivo["error"] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || $arquivo["size"] > $maxBytes) {
    $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "O upload falhou ou a imagem ultrapassa 5 MB."];
    header("Location: adm.php");
    exit;
}

$informacaoImagem = @getimagesize($arquivo["tmp_name"]);
if ($informacaoImagem === false) {
    $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "O arquivo enviado não é uma imagem válida."];
    header("Location: adm.php");
    exit;
}

$tiposPermitidos = [
    IMAGETYPE_JPEG => "jpg",
    IMAGETYPE_PNG => "png",
    IMAGETYPE_WEBP => "webp"
];

$tipoImagem = $informacaoImagem[2] ?? 0;
if (!isset($tiposPermitidos[$tipoImagem])) {
    $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Use uma imagem JPG, PNG ou WEBP."];
    header("Location: adm.php");
    exit;
}

$pastaImagens = __DIR__ . "/img";
if (!is_dir($pastaImagens) || !is_writable($pastaImagens)) {
    $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "A pasta img/ não existe ou não permite gravação."];
    header("Location: adm.php");
    exit;
}

$nomeArquivo = bin2hex(random_bytes(12)) . "." . $tiposPermitidos[$tipoImagem];
$caminhoRelativo = "img/" . $nomeArquivo;

if (!move_uploaded_file($arquivo["tmp_name"], $pastaImagens . "/" . $nomeArquivo)) {
    $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Não foi possível salvar a imagem."];
    header("Location: adm.php");
    exit;
}

$nomeSQL = addslashes($nome);
$descricaoSQL = addslashes($descricao);
$caminhoSQL = addslashes($caminhoRelativo);
$desenvolvedoraSQL = addslashes($desenvolvedora);
$publicadoraSQL = addslashes($publicadora);
$generoSQL = addslashes($genero);
$plataformasSQL = addslashes($plataformas);
$tamanhoSQL = addslashes($tamanho);
$versaoSQL = addslashes($versao);
$classificacaoSQL = addslashes($classificacao);
$idiomasSQL = addslashes($idiomas);
$modoSQL = addslashes($modo);
$licencaSQL = addslashes($licenca);

$anoSQL = ($dataLancamento >= 1900 && $dataLancamento <= 2100)
    ? "'" . $dataLancamento . "'"
    : "NULL";

$consulta = "INSERT INTO produto
                (nome, descricao, preco, imagem, desenvolvedora, publicadora,
                 genero, plataformas, tamanho, versao, classificacao, idiomas,
                 modo, data_lancamento, licenca)
             VALUES
                ('$nomeSQL', '$descricaoSQL', '$preco', '$caminhoSQL',
                 '$desenvolvedoraSQL', '$publicadoraSQL', '$generoSQL',
                 '$plataformasSQL', '$tamanhoSQL', '$versaoSQL',
                 '$classificacaoSQL', '$idiomasSQL', '$modoSQL',
                 $anoSQL, '$licencaSQL')";
banco($server, $user, $password, $db, $consulta);

$_SESSION["aviso"] = ["tipo" => "sucesso", "texto" => "Produto cadastrado com sucesso."];
header("Location: adm.php");
exit;
?>
