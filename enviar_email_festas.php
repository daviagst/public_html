<?php

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeCompleto = $_POST["nomeCompleto"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $unidade = $_POST["unidade"];
    $mensagem = $_POST["mensagem"];

    // Mapeie as unidades para os e-mails correspondentes
    $emailsUnidades = [
        'Unidade Parauapebas' => 'eventospbs@jumpindoorpark.com.br',
        'Unidade Marabá' => 'eventosmaraba@jumpindoorpark.com.br',
        'Unidade Gurupi' => 'eventosgurupi@jumpindoorpark.com.br',
    ];

    // Verifique se a unidade existe no mapeamento, se não, use um e-mail padrão
    $destinatario = isset($emailsUnidades[$unidade]) ? $emailsUnidades[$unidade] : 'eventos@jumpindoorpark.com.br';

    // Configuração do PHPMailer
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = true;
    $mail->Username = 'enviareventos@jumpindoorpark.com.br';
    $mail->Password = 'Fl2tr0n12@';

    $mail->setFrom('enviareventos@jumpindoorpark.com.br');
    $mail->addAddress($destinatario);
    $mail->Subject = "Nova Mensagem de Evento - $unidade";
    $mail->isHTML(true);
    $mail->Body = "Nome: $nomeCompleto<br>Email:  $email<br>Telefone:  $telefone<br>Unidade: $unidade<br>Mensagem: $mensagem";

    try {
        if ($mail->send()) {
            echo 'Mensagem de evento enviada com sucesso.';
        } else {
            echo 'Erro ao enviar a mensagem de evento: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo 'Exceção capturada: ' . $e->getMessage();
    }
} else {
    echo 'Método inválido.';
}
?>
