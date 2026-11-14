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
    header("Location: index.php");
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
    die("Usuário não encontrado.");
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

unset($_SESSION["produto_pendente"]);
unset($_SESSION["carrinho"]);

$_SESSION["numero_venda"] = $numeroVenda;
$_SESSION["nomes_produtos"] = $nomesProdutos;
$_SESSION["total_venda"] = $total;
$_SESSION["forma_pagamento"] = $pagamento;

header("Location: confirmar.php");
exit;

?>