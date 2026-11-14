
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarVerificacao($destinatario, $nome, $token) {

    $config = require 'C:/xampp/config/smtp.php';

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $config['usuario'];
        $mail->Password = $config['senha'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom($config['usuario'], 'PoubreSteam');
        $mail->addAddress($destinatario, $nome);

        $pasta = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');

        $link = 'http://' . $_SERVER['HTTP_HOST'] .
                $pasta . '/verificar_email.php?token=' .
                urlencode($token);

        $nomeSeguro = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
        $linkSeguro = htmlspecialchars($link, ENT_QUOTES, 'UTF-8');

        $mail->isHTML(true);
        $mail->Subject = 'Confirme sua conta - PoubreSteam';

        $mail->Body = "
        <!DOCTYPE html>
        <html lang='pt-BR'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Confirme seu e-mail</title>
        </head>

        <body style='margin:0;padding:0;background-color:#11121a;font-family:Arial,Helvetica,sans-serif;'>

            <table width='100%' cellpadding='0' cellspacing='0' style='background-color:#11121a;padding:35px 10px;'>
                <tr>
                    <td align='center'>

                        <table width='600' cellpadding='0' cellspacing='0' style='max-width:600px;background-color:#1b1d2a;border-radius:12px;overflow:hidden;'>

                            <tr>
                                <td align='center' style='padding:35px 20px;background-color:#222438;'>

                                    <h1 style='margin:0;color:#a78bfa;font-size:32px;letter-spacing:2px;'>
                                        POUBRE<span style='color:#60a5fa;'>STEAM</span>
                                    </h1>

                                    <p style='color:#a1a1aa;font-size:11px;letter-spacing:3px;margin-top:8px;'>
                                        SUA CENTRAL DE JOGOS
                                    </p>

                                </td>
                            </tr>

                            <tr>
                                <td style='padding:40px 35px;'>

                                    <p style='color:#a78bfa;font-size:12px;font-weight:bold;letter-spacing:2px;'>
                                        CONFIRMAÇÃO DE CONTA
                                    </p>

                                    <h2 style='color:#ffffff;font-size:27px;margin-bottom:20px;'>
                                        Bem-vindo à PoubreSteam!
                                    </h2>

                                    <p style='color:#d4d4d8;font-size:16px;line-height:1.7;'>
                                        Olá, <strong style='color:#ffffff;'>$nomeSeguro</strong>!
                                    </p>

                                    <p style='color:#d4d4d8;font-size:15px;line-height:1.8;'>
                                        Estamos felizes por ter você em nossa comunidade. Sua próxima aventura começa aqui!
                                    </p>

                                    <p style='color:#d4d4d8;font-size:15px;line-height:1.8;'>
                                        Para concluir seu cadastro e confirmar seu endereço de e-mail, clique no botão abaixo:
                                    </p>

                                    <table width='100%' cellpadding='0' cellspacing='0'>
                                        <tr>
                                            <td align='center' style='padding:25px 0;'>

                                                <a href='$linkSeguro' style='display:inline-block;background-color:#7651d6;color:#ffffff;text-decoration:none;padding:17px 35px;border-radius:7px;font-size:15px;font-weight:bold;letter-spacing:1px;'>
                                                    CONFIRMAR MEU E-MAIL
                                                </a>

                                            </td>
                                        </tr>
                                    </table>

                                    <p style='color:#a1a1aa;font-size:12px;line-height:1.7;'>
                                        Se o botão não funcionar, copie e cole este endereço no navegador:
                                    </p>

                                    <p style='color:#60a5fa;font-size:12px;word-break:break-all;'>
                                        $linkSeguro
                                    </p>

                                    <p style='color:#a1a1aa;font-size:12px;line-height:1.7;'>
                                        Se você não criou uma conta na PoubreSteam, pode ignorar esta mensagem.
                                    </p>

                                </td>
                            </tr>

                            <tr>
                                <td align='center' style='padding:25px;background-color:#222438;'>

                                    <p style='color:#a78bfa;font-size:17px;font-weight:bold;letter-spacing:2px;'>
                                        POUBRESTEAM
                                    </p>

                                    <p style='color:#a1a1aa;font-size:12px;'>
                                        Sua plataforma de jogos.
                                    </p>

                                    <p style='color:#71717a;font-size:11px;'>
                                        Mensagem automática. Não responda este e-mail.
                                    </p>

                                </td>
                            </tr>

                        </table>

                    </td>
                </tr>
            </table>

        </body>
        </html>
        ";

        $mail->AltBody = "Olá, $nome! Bem-vindo à PoubreSteam!

Para confirmar seu endereço de e-mail, acesse o link abaixo:

$link

Se você não criou uma conta, ignore esta mensagem.";

        $mail->send();

        return true;

    } catch (Exception $e) {

        error_log('Erro ao enviar e-mail: ' . $mail->ErrorInfo);

        return false;
    }
}
