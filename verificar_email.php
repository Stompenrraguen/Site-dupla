
<?php

include "app/cons.php";
require_once "app/DLL.php";

$confirmado = false;
$titulo = "";
$mensagem = "";

$token = trim($_GET['token'] ?? '');

if (!preg_match('/^[a-f0-9]{64}$/i', $token)) {

    $titulo = "Link inválido!";
    $mensagem = "O link de confirmação não é válido. Verifique se você acessou o endereço completo enviado por e-mail.";

} else {

    $tokenHash = hash('sha256', $token);

    $consulta = "SELECT id_usuario
                 FROM usuario
                 WHERE token_verificacao = '$tokenHash'
                 AND email_verificado = 0
                 LIMIT 1";

    $resultado = banco($server, $user, $password, $db, $consulta);

    if ($resultado->num_rows > 0) {

        $dados = $resultado->fetch_assoc();
        $id_usuario = (int) $dados['id_usuario'];

        $consulta = "UPDATE usuario
                     SET email_verificado = 1,
                     token_verificacao = NULL
                     WHERE id_usuario = $id_usuario
                     AND email_verificado = 0";

        banco($server, $user, $password, $db, $consulta);

        $confirmado = true;
        $titulo = "E-mail confirmado!";
        $mensagem = "Sua conta PoubreSteam foi confirmada com sucesso. Agora você já pode acessar sua conta.";

    } else {

        $titulo = "Link expirado ou inválido!";
        $mensagem = "Este link já foi utilizado ou não é válido. Se necessário, solicite uma nova confirmação.";

    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($titulo); ?> - PoubreSteam</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #11121a;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 480px;
            background: #1b1d2a;
            border: 1px solid #303247;
            border-radius: 15px;
            padding: 45px 30px;
            text-align: center;
            box-shadow: 0 10px 35px rgba(0,0,0,0.3);
        }

        .logo {
            font-size: 29px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #a78bfa;
            margin-bottom: 35px;
        }

        .logo span {
            color: #60a5fa;
        }

        .icone {
            width: 75px;
            height: 75px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 25px;
            border-radius: 50%;
            font-size: 35px;
            background: <?php echo $confirmado ? '#263c39' : '#46303a'; ?>;
            color: <?php echo $confirmado ? '#4ade80' : '#fb7185'; ?>;
        }

        h1 {
            color: #fff;
            font-size: 25px;
            margin-bottom: 15px;
        }

        p {
            color: #b8bac8;
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .botao {
            display: inline-block;
            background: #7651d6;
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 7px;
            font-weight: bold;
            transition: 0.2s;
        }

        .botao:hover {
            background: #8b6be8;
        }

        .rodape {
            margin-top: 30px;
            color: #71717a;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="logo">
            POUBRE<span>STEAM</span>
        </div>

        <div class="icone">
            <?php echo $confirmado ? '✓' : '!'; ?>
        </div>

        <h1>
            <?php echo htmlspecialchars($titulo); ?>
        </h1>

        <p>
            <?php echo htmlspecialchars($mensagem); ?>
        </p>

        <a href="login.php" class="botao">
            Ir para o login
        </a>

        <div class="rodape">
            POUBRESTEAM — Sua plataforma de jogos.
        </div>

    </div>

</body>
</html>
