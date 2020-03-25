<?php

require_once '../resources/config.php';
require LIBRARY_PATH . '/envio-mail.php';
require LIBRARY_PATH . '/maneja-sesion.php';
require LIBRARY_PATH . '/maneja-fichero.php';

use PHPMailer\PHPMailer\PHPMailer;

// Si se estableció el password es que no hubo errores
if (isset($_SESSION['password'])) {

    // Comprobamos si existe el cliente o el nombre de usuario previamente
    $queryCliente = "SELECT * FROM cliente WHERE nif = '" . $_SESSION['nif'] . "'";
    $resultCliente = mysqli_query($dbConexion, $queryCliente);

    $queryUsuario = "SELECT * FROM usuario WHERE nombre = '" . $_SESSION['usuario'] . "'";
    $resultUsuario = mysqli_query($dbConexion, $queryUsuario);

    if (isset($resultCliente) && mysqli_num_rows($resultCliente) == 1) {
        $errores[] = "Ya existe el cliente con NIF/NIE " . $_SESSION['nif'];
    }
    if (isset($resultUsuario) && mysqli_num_rows($resultUsuario) == 1) {
        $errores[] = "Ya existe el nombre de usuario " . $_SESSION['usuario'];
    }

    if (!isset($errores)) {

        // Generamos el token que identificará al intento de registro
        $token = password_hash($_SESSION['nif'] . $_SESSION['usuario'] . $_SESSION['password'], PASSWORD_BCRYPT);
        // Preparamos el enlace que irá en el mail   
        $enlace = BASE_URL . 'registro-confirma-mail.php' . '?token=' . $token;

        // Almacenamos el registro de usuario en la BD
        $ip = $_SESSION['direccionIp'];
        $nombre = $_SESSION['nombre'];
        $ape1 = $_SESSION['apellido1'];
        $ape2 = $_SESSION['apellido2'];
        $nif = $_SESSION['nif'];
        $email = $_SESSION['email'];
        $usu = $_SESSION['usuario'];
        $pass = password_hash($_SESSION['password'], PASSWORD_BCRYPT);

        $insertRegistro = "INSERT INTO registro_usuario 
            (token, direccion_ip, nombre, apellido1, apellido2, nif, email, usuario, password, fecha_creacion) 
            VALUES 
            ('$token', '$ip', '$nombre', '$ape1', '$ape2', '$nif', '$email', '$usu', '$pass', now())";

        $resultInsert = mysqli_query($dbConexion, $insertRegistro);
        if ($resultInsert) {
            // Cargamos la plantilla del mail
            $contenido = cargaFichero(TEMPLATES_PATH . '/registro-contenido-mail.php');

            // Reemplazamos los valores en el contenido del mail
            $contenido = str_replace('%nombre%', $_SESSION['nombre'], $contenido);
            $contenido = str_replace('%enlace_completar%', $enlace, $contenido);

            // Preparamos y enviamos el mail    
            $mail = new PHPMailer();
            inicializaConGmail($mail);
            $resulMail = enviaConGmail($mail, $_SESSION['email'], "Completa tu registro en Bankito", $contenido);

            if (!$resulMail) {
                $errores[] = "Error al enviar el mail a la dirección " . $_SESSION['email'];
            }
        }
        else {
            $errores[] = "Error al escribir en la BD";
        }
    }
    // Borrado de los datos de sesión
    cierraSesionSegura();
    
    if (isset($errores)) {
        header('Location: error-general.php');
    }
    else {
        header('Location: registro-pendiente-mail.php');
    }
    
}