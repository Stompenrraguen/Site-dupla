<?php
include "app/cons.php";
require_once "app/DLL.php";
extract($_POST);

if(isset($B1)){
    $consulta = "INSERT INTO contato (Id, Nome, insta, zap, niver) VALUES (NULL, '$nome', '$insta', '$zap', '$niver')";
     banco($server, $user, $password, $db, $consulta);
     exit();
}

if(isset($B2)){
    $consulta = "SELECT * FROM contato WHERE Nome = '$nome'";
    $resultado = banco($server, $user, $password, $db, $consulta);
    $linha = $resultado->fetch_assoc();
    echo $linha['Id']."</br>";
    echo $linha['Nome']."</br>";
    echo $linha['insta']."</br>";  
}


if(isset($B3)){
    $consulta = "SELECT * FROM contato order by Nome";
    $resultado = banco($server, $user, $password, $db, $consulta);
    while($linha = $resultado->fetch_assoc()){
         echo $linha['Id']."  ";
         echo $linha['Nome']."  ";
         echo $linha['insta']."</br>";
    }
}


if(isset($B4)){
    $consulta = "SELECT * FROM contato WHERE Nome = '$nome'";
    $resultado = banco($server, $user, $password, $db, $consulta);
    echo "<select name = 'opcao'>";
    while($linha = $resultado->fetch_assoc()){
         echo"<option value=".$linha['Id'].">".$linha['Id']." ".$linha['Nome']."</option>";
    }
    echo "</select>";
}

if(isset($B5)){
    $consulta = "SELECT * FROM contato WHERE Nome = '$nome' and insta = '$insta'";
    $resultado = banco($server, $user, $password, $db, $consulta);
    If ($linha = $resultado->fetch_assoc()){
        echo "acesso liberado";
    }else{
        echo "acesso negado";
    }
   
}

if(isset($B6)){
     $consulta = "DELETE FROM contato WHERE Nome = '$nome' and insta = '$insta'";
     banco($server, $user, $password, $db, $consulta);
     exit();
}

?>