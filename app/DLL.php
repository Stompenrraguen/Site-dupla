<?php

function teste_login($sessao)
{
    if ($sessao != "ok") {
        header("Location: index.php?erro=1");
        exit;
    }
}


function banco($server, $user, $password, $db, $consulta)
{
    $banco = new mysqli($server, $user, $password, $db);

    if ($banco->connect_error) {
        die("Erro na conexão com o banco de dados: " . $banco->connect_error);
    }

    $banco->set_charset("utf8mb4");

    $resultado = $banco->query($consulta);

    if (!$resultado) {
        die("Erro na consulta: " . $banco->error);
    }

    return $resultado;
}
?>

