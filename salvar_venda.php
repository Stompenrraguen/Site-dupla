<?php
if (!isset($_SESSION)) session_start();
include "app/cons.php";
require_once "app/DLL.php";

extract($_POST, EXTR_SKIP);
if (empty($_SESSION["logado"]) || empty($b1)) {
    $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Faça login para concluir a compra."];
    header("Location: login.php");
    exit;
}

$formasPermitidas = ["Pix", "Cartão de Crédito", "Boleto", "Saldo PoubreSteam"];
$pagamento = trim($pagamento ?? "");
if (!in_array($pagamento, $formasPermitidas, true)) {
    $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Selecione uma forma de pagamento válida."];
    header("Location: confirmar.php");
    exit;
}

$idUsuario = (int)$_SESSION["id_usuario"];
$pagamentoSQL = addslashes($pagamento);
$numeroBase = "PS" . date("YmdHis") . bin2hex(random_bytes(4));

if (!empty($_SESSION["produto_pendente"])) {
    $idProduto = (int)$_SESSION["produto_pendente"];
    $consulta = "INSERT INTO vendas (numero_venda, id_usuario, id_produto, quantidade, valor_unitario, valor_total, forma_pagamento)
                 SELECT CONCAT('$numeroBase', p.id_produto), '$idUsuario', p.id_produto, 1, p.preco, p.preco, '$pagamentoSQL'
                 FROM produto p WHERE p.id_produto = '$idProduto'";
    $resultado = banco($server, $user, $password, $db, $consulta);
    if (!$resultado) {
        $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Não foi possível registrar a compra. Tente novamente."];
        header("Location: confirmar.php");
        exit;
    }
    unset($_SESSION["produto_pendente"]);
} else {
    $consulta = "SELECT id_carrinho FROM carrinho WHERE id_usuario = '$idUsuario' LIMIT 1";
    $resultado = banco($server, $user, $password, $db, $consulta);
    if (!$resultado || $resultado->num_rows === 0) {
        $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Seu carrinho está vazio."];
        header("Location: carrinho.php");
        exit;
    }

    $consulta = "INSERT INTO vendas (numero_venda, id_usuario, id_produto, quantidade, valor_unitario, valor_total, forma_pagamento)
                 SELECT CONCAT('$numeroBase', LPAD(c.id_carrinho, 10, '0')), '$idUsuario', c.id_produto, c.quantidade,
                        p.preco, p.preco * c.quantidade, '$pagamentoSQL'
                 FROM carrinho c INNER JOIN produto p ON p.id_produto = c.id_produto
                 WHERE c.id_usuario = '$idUsuario'";
    $resultado = banco($server, $user, $password, $db, $consulta);
    if (!$resultado) {
        $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Não foi possível registrar a compra. Tente novamente."];
        header("Location: confirmar.php");
        exit;
    }

    $consulta = "DELETE FROM carrinho WHERE id_usuario = '$idUsuario'";
    banco($server, $user, $password, $db, $consulta);
}

$_SESSION["aviso"] = ["tipo" => "sucesso", "texto" => "Compra concluída com sucesso. Seus jogos estão na biblioteca."];
header("Location: biblioteca.php");
exit;
?>
