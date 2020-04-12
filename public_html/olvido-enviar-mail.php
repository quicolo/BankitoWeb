<?php

require_once '../resources/config.php';
require LIBRARY_PATH . '/envio-mail.php';
require LIBRARY_PATH . '/maneja-sesion.php';
require LIBRARY_PATH . '/maneja-fichero.php';
require LIBRARY_PATH . '/maneja-base-datos.php';

use PHPMailer\PHPMailer\PHPMailer;

iniciaSesionSegura();
// Si se estableció el NIF/NIE es que no hubo errores
if (isset($_SESSION['nif'])) {

    // Comprobamos si existe el cliente buscando por el NIF/NIE
    $resultCliente = buscaClientePorNif($dbConexion, $_SESSION['nif']);

    if (isset($resultCliente) && mysqli_num_rows($resultCliente) == 1) {
        $arrayCliente = mysqli_fetch_assoc($resultCliente);
        if (isset($_SESSION['email']) && $_SESSION['email'] != "") {
            if ($_SESSION['email'] !== $arrayCliente['email']) {
                $errores[] = "Las direcciones de email no coinciden";
            }
        }
        else if (isset($_SESSION['usuario']) && $_SESSION['usuario'] != "") {
            // Buscar por usuario y decidir
            $idUsuario = $arrayCliente['usuario_id_usuario'];
            $resultUsuario = buscaUsuarioPorId($dbConexion, $idUsuario);
            
            if (isset($resultUsuario) && mysqli_num_rows($resultUsuario) == 1) {
                $arrayUsuario = mysqli_fetch_assoc($resultUsuario);
                if ($_SESSION['usuario'] !== $arrayUsuario['nombre']) {
                    $errores[] = "Los nombres de usuario no coinciden";
                }
            }
            else {
                $errores[] = "No existe el usuario";
            }
        }
        else {
            $errores[] = "Nombre de usuario y dirección de email vacíos";    
        }
    }
    else {
        $errores[] = "No existe ningún cliente con el NIF/NIE " . $_SESSION['nif'];
    }

    if (!isset($errores)) {

        // Generamos el token que identificará al intento de registro
        $cadenaSemilla = $_SESSION['nif'] . $arrayCliente['id_cliente'] . $arrayCliente['nombre'] . $arrayCliente['apellido1'];
        $token = password_hash($cadenaSemilla , PASSWORD_BCRYPT);
        // Preparamos el enlace que irá en el mail   
        $enlace = BASE_URL . 'olvido-cambia-pass-form.php' . '?token=' . $token;

        // Almacenamos el registro de usuario en la BD
        $ip = $_SESSION['direccionIp'] ?? "0.0.0.0";
        $nif = $_SESSION['nif'];
        $email = $_SESSION['email']  ?? "";;
        $usu = $_SESSION['usuario']  ?? "";;

        $resultInsert = insertaRestablecePass($dbConexion, $token, $ip, $nif, $email, $usu);
        if ($resultInsert) {
            // Cargamos la plantilla del mail
            $contenido = cargaFichero(TEMPLATES_PATH . '/olvido-contenido-mail.php');

            // Reemplazamos los valores en el contenido del mail
            $contenido = str_replace('%nombre%', $arrayCliente['nombre'], $contenido);
            $contenido = str_replace('%enlace_completar%', $enlace, $contenido);

            // Preparamos y enviamos el mail    
            $mail = new PHPMailer();
            inicializaConGmail($mail);
            $resulMail = enviaConGmail($mail, $arrayCliente['email'], "Restablece tu clave en Bankito", $contenido);

            if (!$resulMail) {
                $errores[] = "Error al enviar el mail a la dirección " . $arrayCliente['email'];
            }
        }
        else {
            $errores[] = "Error al escribir en la BD";
        }
    }
    
    if (isset($errores)) {
        // Limpiamos las variables de sesión
        session_unset();
        $_SESSION['error'] = implode("<br>", $errores);
        echo $_SESSION['error'];
        header('Location: error-general.php');
    }
    else {
        // Borrado de los datos de sesión
        cierraSesionSegura();
        header('Location: olvido-pendiente-mail.php');
    }
    
}
