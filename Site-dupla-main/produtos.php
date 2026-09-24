<?php

include "app/cons.php";
require_once "app/DLL.php";

$consulta = "SELECT * FROM produto ORDER BY id_produto";

$resultado = banco(
    $server,
    $user,
    $password,
    $db,
    $consulta
);

$produtos = [];

while ($produto = $resultado->fetch_assoc()) {
    $produtos[$produto["id_produto"]] = $produto;
}