<?php

require_once '../resources/config.php';

// Recoger datos del formulario
if (isset($_POST)) {

    // Recogemos datos del formulario y saneamos las cadenas de entrada
    $usuarioForm = trim(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING));
    $passwordForm = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS));

    // Borramos la sesión antigua, si la hubiera, para que tras un login
    // exitoso, el siguiente intento se compruebe debidamente y no aproveche
    // la sessión del anterior
    if (isset($_SESSION['usuario'])) {
        unset($_SESSION['usuario']);
    }

    // Verificamos los caracteres permitidos en el nombre de usuario así como 
    // el tamaño mínimo y máximo del nombre de usuario
    if (preg_match('/^[a-zA-Z0-9]{5,50}$/', $usuarioForm)) {

        // Consulta para comprobar las credenciales del usuario
        $query = "SELECT * FROM usuario WHERE nombre = '$usuarioForm'";

        $resultado = mysqli_query($dbConexion, $query);

        if (isset($resultado) && mysqli_num_rows($resultado) == 1) {
            $arrayresult = mysqli_fetch_assoc($resultado);

            // Comprobar la contraseña
            $comprobacion = password_verify($passwordForm, $arrayresult['password']);

            if ($comprobacion) {
                // Guardamos el array asociativo del usuario en la sesión
                $_SESSION['usuario'] = $arrayresult;
            } else {
                // Si algo falla enviar una sesión con el fallo
                $_SESSION['error_login'] = "Usuario o contraseña incorrecto";
            }
        } else {
            $_SESSION['error_login'] = "Usuario o contraseña incorrecto";
        }
    } else {
        $_SESSION['error_login'] = "Usuario con caracteres prohibidos";
    }

    if (isset($_SESSION['usuario']))
        header('Location: principal.php');
    else
        header('Location: iniciarsesion.php');
}

