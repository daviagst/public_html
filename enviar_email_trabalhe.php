<?php

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeCompleto = $_POST["nomeCompleto"];
    $email = $_POST["email"];
    $telefoneFixo = $_POST["telefoneFixo"];
    $unidade = $_POST["unidade"];
    $tipoVaga = $_POST["tipoVaga"];

    // Mapeie as unidades para os e-mails correspondentes
    $unidades = [
        'Unidade Parauapebas' => 'vagaspbs@jumpindoorpark.com.br',
        'Unidade Marabá' => 'vagasmaraba@jumpindoorpark.com.br',
        'Unidade Gurupi' => 'vagasgurupi@jumpindoorpark.com.br',
        // Adicione mais unidades conforme necessário
    ];

    // Verifique se a unidade existe no mapeamento, se não, use o e-mail padrão
    $destinatario = isset($unidades[$unidade]) ? $unidades[$unidade] : 'enviarcurriculos@jumpindoorpark.com.br';

    // Configuração do PHPMailer
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = true;
    $mail->Username = 'enviarcurriculos@jumpindoorpark.com.br';
    $mail->Password = 'Fl2tr0n12@';

    $mail->setFrom('enviarcurriculos@jumpindoorpark.com.br');
    $mail->addAddress($destinatario);
    $mail->Subject = "Novo Currículo - $tipoVaga";
    $mail->isHTML(true);
    $mail->Body = "Nome: $nomeCompleto<br>Email: $email<br>Telefone: $telefoneFixo<br>Unidade: $unidade<br>Tipo de Vaga: $tipoVaga";

    // Anexar o arquivo do currículo
    $arquivo_path = $_FILES['arquivo']['tmp_name'];
    $mail->addAttachment($arquivo_path, "$nomeCompleto_Curriculo.pdf");

    // Envie o e-mail
    try {
        if ($mail->send()) {
            echo 'Currículo enviado com sucesso.';
        } else {
            echo 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo 'Exceção capturada: ' . $e->getMessage();
    }
} else {
    echo 'Método inválido.';
}
?>
