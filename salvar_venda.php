
<?php

if (!isset($_SESSION)) {
    session_start();
}

include "produtos.php";
include "app/cons.php";
require_once "app/DLL.php";

if (empty($_SESSION["logado"]) || !isset($_POST["b1"])) {
    header("Location: index.php");
    exit;
}

date_default_timezone_set("America/Sao_Paulo");

$pagamento = trim($_POST["pagamento"] ?? "");
$itensCompra = [];

if (!empty($_SESSION["produto_pendente"])) {
    $itensCompra[] = $_SESSION["produto_pendente"];
} else if (!empty($_SESSION["carrinho"])) {
    $itensCompra = $_SESSION["carrinho"];
}

if (empty($itensCompra)) {
    $_SESSION["erro_venda"] = "Não existem produtos para finalizar a compra.";
    header("Location: index.php");
    exit;
}

$formasPagamento = [
    "Pix",
    "Cartão de Crédito",
    "Boleto",
    "Saldo PoubreSteam"
];

if (!in_array($pagamento, $formasPagamento, true)) {
    $_SESSION["erro_venda"] = "Selecione uma forma de pagamento válida.";
    header("Location: confirmar.php");
    exit;
}

if (empty($_SESSION["cpf"])) {
    $_SESSION["erro_venda"] = "Não foi possível identificar sua conta. Faça login novamente.";
    header("Location: login.php");
    exit;
}

$cpf = $_SESSION["cpf"];

$consultaUsuario = "SELECT id_usuario
                    FROM usuario
                    WHERE cpf = '$cpf'";

$resultadoUsuario = banco(
    $server,
    $user,
    $password,
    $db,
    $consultaUsuario
);

$usuario = $resultadoUsuario->fetch_assoc();

if (!$usuario) {
    $_SESSION["erro_venda"] = "Usuário não encontrado. Verifique seus dados.";
    header("Location: confirmar.php");
    exit;
}

$idUsuario = $usuario["id_usuario"];
$numeroVenda = date("YmdHis") . rand(100, 999);
$dataHora = date("Y-m-d H:i:s");
$nomesProdutos = [];
$total = 0;
$quantidades = array_count_values($itensCompra);
$contador = 0;

foreach ($quantidades as $idProduto => $quantidade) {

    $idProduto = (int)$idProduto;

    if (isset($produtos[$idProduto])) {

        $nomeProduto = $produtos[$idProduto]["nome"];
        $preco = (float)$produtos[$idProduto]["preco"];
        $valorTotalProduto = $preco * $quantidade;

        $nomesProdutos[] = $nomeProduto;
        $total += $valorTotalProduto;

        $numeroVendaProduto = $numeroVenda . $contador;

        $consulta = "INSERT INTO vendas
        (
            numero_venda,
            id_usuario,
            id_produto,
            quantidade,
            valor_unitario,
            valor_total,
            forma_pagamento,
            data_hora
        )
        VALUES
        (
            '$numeroVendaProduto',
            '$idUsuario',
            '$idProduto',
            '$quantidade',
            '$preco',
            '$valorTotalProduto',
            '$pagamento',
            '$dataHora'
        )";

        banco(
            $server,
            $user,
            $password,
            $db,
            $consulta
        );

        $contador++;
    }
}

if ($contador == 0) {
    $_SESSION["erro_venda"] = "Não foi possível encontrar os produtos selecionados.";
    header("Location: index.php");
    exit;
}

unset($_SESSION["produto_pendente"]);
unset($_SESSION["carrinho"]);

$_SESSION["venda_concluida"] = true;
$_SESSION["numero_venda"] = $numeroVenda;
$_SESSION["nomes_produtos"] = $nomesProdutos;
$_SESSION["total_venda"] = $total;
$_SESSION["forma_pagamento"] = $pagamento;

header("Location: confirmar.php");
exit;

?>
