<?php

require_once '../resources/config.php';
require LIBRARY_PATH . '/envio_mail.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer();
inicializaConGmail($mail);
$resul = enviaConGmail($mail, $_SESSION['email'], "Asunto de prueba", "Contenido de prueba");

if (!$resul) {
    echo "Error" . $mail->ErrorInfo;
} else {
    echo "Enviado";
}

