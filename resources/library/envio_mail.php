<?php

// Requiere instalar Composer. Abrir una línea de comandos en la raíz del  
// proyecto y hacer: composer require phpmailer/phpmailer
// Esto descarga el paquete de software y crea una carpeta /vendor
// que contiene los ficheros carga automática de clases en memoria.
// 
// Acceso a una cuenta de google permitiendo el uso de aplicaciones menos
// seguras: https://support.google.com/accounts/answer/6010255?hl=es
// Configuración -> Cuentas e importación -> Otra configuración de la cuenta de
// Google -> Seguridad -> Activar acceso (no se recomienda)

require VENDOR_PATH . '/autoload.php';

function inicializaConGmail($mail) {
    $mail->isSMTP();
    // 2 para verbose
    // 0 para silent
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    // introducir usuario y contraseña de google
    $mail->Username = "iesgerena5";
    $mail->Password = "manuelangel";
    $mail->SetFrom('iesgerena5@gmail.com', 'Bankito');
}

function enviaConGmail($mail, $destino, $asunto, $contenidoHTML) {

    //destinatario
    $mail->AddAddress($destino);
    // asunto
    $mail->Subject = $asunto;
    $mail->MsgHTML($contenidoHTML);
    // adjuntos
    // $mail->addAttachment("archivo.xls");
    // enviar
    $resultado = $mail->Send();
    return $resultado;
}
