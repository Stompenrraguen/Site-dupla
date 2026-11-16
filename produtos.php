<?php
include_once __DIR__ . "/app/cons.php";
require_once __DIR__ . "/app/DLL.php";

$busca = trim($busca ?? "");
$buscaSQL = addslashes($busca);

$consulta = "SELECT *
             FROM produto";

if ($busca !== "") {
    $consulta .= " WHERE nome LIKE '%$buscaSQL%'";
}

$consulta .= " ORDER BY id_produto";

$resultado = banco($server, $user, $password, $db, $consulta);

$produtos = [];

while ($produto = $resultado->fetch_assoc()) {
    $produtos[(int)$produto["id_produto"]] = $produto;
}
?>
