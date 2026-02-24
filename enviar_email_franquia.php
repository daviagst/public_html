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
    $cidade = $_POST["cidade"];
    $estado = $_POST["estado"];
    $profissao = $_POST["profissao"];
    $capital = $_POST["capital"];
    $endereco = $_POST["endereco"];
    $observacoes = $_POST["observacoes"];

    // Configuração do PHPMailer
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = true;
    $mail->Username = 'enviarfranquia@jumpindoorpark.com.br';
    $mail->Password = 'Fl2tr0n12@';

    $mail->setFrom('enviarfranquia@jumpindoorpark.com.br');
    $mail->addAddress('franquias@jumpindoorpark.com.br');
    $mail->Subject = "Nova Proposta de Franquia";
    $mail->isHTML(true);
    $mail->Body = "Nome: $nomeCompleto<br>Email: $email<br>Telefone: $telefone<br>Cidade: $cidade<br>Estado: $estado<br>Profissao: $profissao<br>Capital disponivel: $capital<br>Endereco do ponto comercial: $endereco<br>Observacoes: $observacoes";

    try {
        if ($mail->send()) {
            echo 'Proposta de franquia enviada com sucesso.';
        } else {
            echo 'Erro ao enviar a proposta de franquia: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo 'Exceção capturada: ' . $e->getMessage();
    }
} else {
    echo 'Método inválido.';
}
?>
