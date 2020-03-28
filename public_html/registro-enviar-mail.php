<?php

require_once '../resources/config.php';
require LIBRARY_PATH . '/envio-mail.php';
require LIBRARY_PATH . '/maneja-sesion.php';
require LIBRARY_PATH . '/maneja-fichero.php';
require LIBRARY_PATH . '/maneja-consola.php';
require LIBRARY_PATH . '/maneja-base-datos.php';

use PHPMailer\PHPMailer\PHPMailer;
imprimePorConsola('Fuera');
// Si se estableció el password es que no hubo errores
if (isset($_SESSION['password'])) {
    imprimePorConsola('Dentro');
    // Comprobamos si existe el cliente o el nombre de usuario previamente
    $resultCliente = buscaClientePorNif($dbConexion, $_SESSION['nif']);
    $resultUsuario = buscaUsuarioPorNombre($dbConexion, $_SESSION['usuario']);

    if (isset($resultCliente) && mysqli_num_rows($resultCliente) == 1) {
        $error[] = "Ya existe el cliente con NIF/NIE " . $_SESSION['nif'];
    }
    if (isset($resultUsuario) && mysqli_num_rows($resultUsuario) == 1) {
        $error[] = "Ya existe el nombre de usuario " . $_SESSION['usuario'];
    }

    imprimePorConsola($error);

    if (!isset($error)) {

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

        $resultInsert = insertaRegistroUsuario($dbConexion, $token, $ip, $nombre, $ape1, $ape2, $nif, $email, $usu, $pass);
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
                $error[] = "Error al enviar el mail a la dirección " . $_SESSION['email'];
            }
        }
        else {
            $error[] = "Error al escribir en la BD";
        }
    }

    // Borrado de los datos de sesión
    //cierraSesionSegura();
    
    if (isset($error)) {
        header('Location: error-general.php');
    }
    else {
        header('Location: registro-pendiente-mail.php');
    }
    
}