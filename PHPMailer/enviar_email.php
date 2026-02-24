

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'caminho/para/PHPMailer/src/Exception.php';

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
        // Adicione mais unidades conforme necessário
    ];

    // Verifique se a unidade existe no mapeamento, se não, use o e-mail padrão
    $destinatario = isset($unidades[$unidade]) ? $unidades[$unidade] : 'enviarcurriculos@jumpindoorpark.com.br';

    // Configuração do PHPMailer
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

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

    // Envie o e-mail
    if ($mail->send()) {
        echo 'Currículo enviado com sucesso.';
    } else {
        echo 'Erro ao enviar o e-mail.';
    }
} else {
    echo 'Método inválido.';
}


?>
