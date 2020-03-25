<?php
require_once '../resources/config.php';
include LIBRARY_PATH . '/valida-entrada.php';


if (isset($_SESSION['token'])) {
    // Desinfectamos los parámetros recibidos
    $token = $_SESSION['token'];
    $password1Form = trim(filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $password2Form = trim(filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    // Validamos el password recibido
    if (empty($password1Form)) {
        $errorValida[] = "La contraseña de usuario es un campo requerido";
    } else {
        if (!validaPassword($password1Form)) {
            $errorValida[] = errorPassword($password1Form);
        }
    }
    if (strcmp($password1Form, $password2Form) != 0) {
        $errorValida[] = "La contraseñas introducidas son distintas";
    }

    if (!isset($errorValida)) {
        $queryToken = "SELECT * FROM restablece_pass WHERE token = '" . $token . "'";
        $resultToken = mysqli_query($dbConexion, $queryToken);

        // Si está todo bien tenemos que salvar los datos en las tablas adecuadas
        if ($resultToken && mysqli_num_rows($resultToken) == 1) {
            $arrayToken = mysqli_fetch_assoc($resultToken);
            
            // Valida que no haya caducado el token
            $ahoraTime = strtotime(date("Y-m-d H:i:s"));
            $tokenTime = strtotime($arrayToken['fecha_creacion']);
            $minutosDif = round(($ahoraTime - $tokenTime) / 60,2);
            if ($minutosDif > MINUTOS_CADUCA_TOKEN) {
                $_SESSION['error'] = "El enlace para cambiar la contraseña ha caducado. Repite el proceso, por favor";
            }
            else {
                // Buscamos el usuario asociado al NIF/NIE asociado al token
                $nif = $arrayToken['nif'];  
                $queryCliente = "SELECT * FROM cliente WHERE nif = '" . $nif . "'";
                $resultCliente = mysqli_query($dbConexion, $queryCliente);
                $arrayCliente = mysqli_fetch_assoc($resultCliente);
                $idUsuario = $arrayCliente['usuario_id_usuario'];
                $newPass = password_hash($password1Form, PASSWORD_BCRYPT );
                $queryActualiza = "UPDATE usuario SET password='".$newPass."' WHERE id_usuario=".$idUsuario;
                $resultActualiza = mysqli_query($dbConexion, $queryActualiza);
                
                if (!$resultActualiza){
                    $_SESSION['error'] = "Fallo al guardar la nueva contraseña";
                }
            }
            
        } else {
            $_SESSION['error'] = "Identificación incorrecta del usuario";
        }
    } 
    else { // Hay error en la validación
        $_SESSION['errorCambiaPass'] = implode("<br>", $errorValida);
    }
} 
else {
    $_SESSION['error'] = "URL mal formada";
}

if (isset($_SESSION['errorCambiaPass'])) {
    header('Location: olvido-cambia-pass-form.php');    
}
else if (isset($_SESSION['error'])) {
    header('Location: error-general.php'); 
}
else {
    header('Location: olvido-final-ok.php'); 
}
