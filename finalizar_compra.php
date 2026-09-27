<?php

if (!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";


if (empty($_SESSION["logado"])) {

    header("Location: login.php");
    exit;

}


if ($_SERVER["REQUEST_METHOD"] != "POST") {

    header("Location: carrinho.php");
    exit;

}


extract($_POST);


$id_usuario = $_SESSION["id_usuario"];


$forma_pagamento = trim($forma_pagamento);


$formas_permitidas = [
    "Pix",
    "Cartão",
    "Boleto"
];


if (!in_array($forma_pagamento, $formas_permitidas)) {

    header("Location: confirmar.php");
    exit;

}


$forma_pagamento = addslashes($forma_pagamento);



$consulta = "SELECT carrinho.id_carrinho
             FROM carrinho
             WHERE carrinho.id_usuario = '$id_usuario'";


$resultado = banco(
    $server,
    $user,
    $password,
    $db,
    $consulta
);


if (!$resultado || $resultado->num_rows == 0) {

    header("Location: carrinho.php");
    exit;

}


$consulta = "INSERT INTO vendas
             (
                 numero_venda,
                 id_usuario,
                 id_produto,
                 quantidade,
                 valor_unitario,
                 valor_total,
                 forma_pagamento
             )

             SELECT

                 CONCAT(
                     'PS',
                     DATE_FORMAT(NOW(), '%Y%m%d%H%i%s'),
                     LPAD(carrinho.id_carrinho, 6, '0')
                 ),

                 '$id_usuario',

                 carrinho.id_produto,

                 carrinho.quantidade,

                 produto.preco,

                 (
                     produto.preco *
                     carrinho.quantidade
                 ),

                 '$forma_pagamento'

             FROM carrinho

             INNER JOIN produto

             ON carrinho.id_produto =
                produto.id_produto

             WHERE carrinho.id_usuario =
                   '$id_usuario'";


banco(
    $server,
    $user,
    $password,
    $db,
    $consulta
);



$consulta = "DELETE FROM carrinho
             WHERE id_usuario = '$id_usuario'";


banco(
    $server,
    $user,
    $password,
    $db,
    $consulta
);


header("Location: biblioteca.php?compra=ok");

exit;

?>
