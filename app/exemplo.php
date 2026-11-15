<?php
include "../app/cons.php";
require_once "../app/DLL.php";

// quando for select
    $sql_verifica = "SELECT * FROM acesso WHERE usuario = '$u'";
    $resultado = banco($server, $user, $password, $db, $sql_verifica);
    $linha = $resultado->fetch_assoc();
  
 //quando for os outros comandos   
     $consulta = "UPDATE $tabela SET descricao = '$descricao' WHERE numero = $numero";
     banco($server, $user, $password, $db, $consulta);

?>