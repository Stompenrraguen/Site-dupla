<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "app/cons.php";
require_once "app/DLL.php";

extract($_POST, EXTR_SKIP);

if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($_SESSION["logado"]) || empty($b1)) {
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
$prefixoVenda = "PS" . date("YmdHis") . bin2hex(random_bytes(2));

if (!empty($_SESSION["produto_pendente"])) {
    $idProduto = (int)$_SESSION["produto_pendente"];

    $consulta = "SELECT id_produto FROM produto WHERE id_produto = '$idProduto' LIMIT 1";
    $resultado = banco($server, $user, $password, $db, $consulta);

    if ($resultado->num_rows === 0) {
        unset($_SESSION["produto_pendente"]);
        $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "O produto não foi encontrado."];
        header("Location: index.php");
        exit;
    }

    $consulta = "INSERT INTO vendas
                    (numero_venda, id_usuario, id_produto, quantidade,
                     valor_unitario, valor_total, forma_pagamento)
                 SELECT CONCAT('$prefixoVenda', LPAD(p.id_produto, 10, '0')),
                        '$idUsuario', p.id_produto, 1, p.preco, p.preco,
                        '$pagamentoSQL'
                 FROM produto p
                 WHERE p.id_produto = '$idProduto'";
    banco($server, $user, $password, $db, $consulta);

    unset($_SESSION["produto_pendente"]);
} else {
    $consulta = "SELECT id_carrinho
                 FROM carrinho
                 WHERE id_usuario = '$idUsuario'
                 LIMIT 1";
    $resultado = banco($server, $user, $password, $db, $consulta);

    if ($resultado->num_rows === 0) {
        $_SESSION["aviso"] = ["tipo" => "erro", "texto" => "Seu carrinho está vazio."];
        header("Location: carrinho.php");
        exit;
    }

    $consulta = "INSERT INTO vendas
                    (numero_venda, id_usuario, id_produto, quantidade,
                     valor_unitario, valor_total, forma_pagamento)
                 SELECT CONCAT('$prefixoVenda', LPAD(c.id_carrinho, 10, '0')),
                        '$idUsuario', c.id_produto, c.quantidade,
                        p.preco, p.preco * c.quantidade, '$pagamentoSQL'
                 FROM carrinho c
                 INNER JOIN produto p ON p.id_produto = c.id_produto
                 WHERE c.id_usuario = '$idUsuario'";
    banco($server, $user, $password, $db, $consulta);

    $consulta = "DELETE FROM carrinho WHERE id_usuario = '$idUsuario'";
    banco($server, $user, $password, $db, $consulta);
}

$_SESSION["aviso"] = [
    "tipo" => "sucesso",
    "texto" => "Compra concluída com sucesso. Seus jogos estão na biblioteca."
];

header("Location: biblioteca.php");
exit;
?>
