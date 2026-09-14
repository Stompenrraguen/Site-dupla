<?php 
if (!isset($_SESSION)) session_start(); 
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
 
$numeroVenda = date("YmdHis") . rand(100, 999); 
$nomesProdutos = []; 
$total = 0; 
 
foreach ($itensCompra as $id) { 
    if (isset($produtos[$id])) { 
        $nomesProdutos[] = $produtos[$id]["nome"]; 
        $total = $total + $produtos[$id]["preco"]; 
    } 
} 

$produtosTexto = implode(", ", $nomesProdutos);


$dataHora = date("Y-m-d H:i:s");

$consulta = "INSERT INTO vendas
(numero_venda, nome_usuario, cpf_usuario, produto, valor, forma_pagamento, data_hora)
VALUES
('$numeroVenda', '{$_SESSION["nome"]}', '{$_SESSION["cpf"]}', '$produtosTexto', '$total', '$pagamento', '$dataHora')";

banco($server, $user, $password, $db, $consulta);
 
unset($_SESSION["produto_pendente"], $_SESSION["carrinho"]);
?> 
<!DOCTYPE html> 
<html lang="pt-BR"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Compra Finalizada - PoubreSteam</title> 
    <link rel="stylesheet" href="css/style.css?v=4"> 
</head> 
<body class="pagina-login"> 
 
<div class="caixa-formulario"> 
    <h1>Compra confirmada!</h1> 
    <div class="alerta sucesso">Sua compra foi registrada com sucesso.</div> 
 
    <p><strong>Número da venda:</strong> <?= $numeroVenda ?></p> 
    <p><strong>Produtos:</strong> <?= htmlspecialchars(implode(", ", $nomesProdutos)) ?></p> 
    <p><strong>Total:</strong> R$ <?= number_format($total, 2, ",", ".") ?></p> 
    <p><strong>Pagamento:</strong> <?= htmlspecialchars($pagamento) ?></p> 
    <p><strong>Data:</strong> <?= date("d/m/Y H:i:s") ?></p> 
 
    <a href="biblioteca.php" class="botao-principal atalho-botao">Ver biblioteca</a> 
    <a href="index.php" class="atalho-voltar">Voltar para a loja</a> 
</div> 
 
</body> 
</html>
