<?php

require_once '../resources/config.php';
include LIBRARY_PATH . '/valida_entrada.php';

// Recoger datos del formulario
if (isset($_POST)) {

    // Recogemos datos del formulario y saneamos las cadenas de entrada
    $nombreForm = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING));
    $apellido1Form = trim(filter_input(INPUT_POST, 'apellido1', FILTER_SANITIZE_STRING));
    $apellido2Form = trim(filter_input(INPUT_POST, 'apellido2', FILTER_SANITIZE_STRING));
    $dniForm = trim(filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_STRING));
    $emailForm = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $usuarioForm = trim(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING));
    $passwordForm = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS));

    // Validamos el nombre
    if (empty($nombreForm)) {
        $errores[] = "El nombre es un campo requerido";
    } else {
        if (!validaNomApe($nombreForm)) {
            $errores[] = "El nombre tiene un formato incorrecto";
        }
    }

    // Validamos el apellido1
    if (empty($apellido1Form)) {
        $errores[] = "El primer apellido es un campo requerido";
    } else {
        if (!validaNomApe($apellido1Form)) {
            $errores[] = "El primer apellido tiene un formato incorrecto";
        }
    }

    // Validamos el apellido2, en este caso no será un campo requerido
    if (!validaNomApe($apellido2Form)) {
        $errores[] = "El segundo apellido tiene un formato incorrecto";
    }

    // Validamos el DNI
    if (empty($dniForm)) {
        $errores[] = "El DNI es un campo requerido";
    } else {
        if (!validaDNI($dniForm)) {
            $errores[] = "El DNI no es correcto";
        }
    }

    // Validamos el email
    if (empty($emailForm)) {
        $errores[] = "El email es un campo requerido";
    } else {
        if (!validaEmail($emailForm)) {
            $errores[] = "El email tiene un formato incorrecto";
        }
    }

    // Validamos el nombre de usuario
    if (empty($usuarioForm)) {
        $errores[] = "El nombre de usuario es un campo requerido";
    } else {
        if (!validaUsuario($usuarioForm)) {
            $errores[] = "El nombre de usuario tiene un formato incorrecto";
        }
    }

    // Validamos el password
    if (empty($passwordForm)) {
        $errores[] = "La contraseña de usuario es un campo requerido";
    } else {
        if (!validaPassword($passwordForm)) {
            $errores[] = errorPassword($passwordForm);
        }
    }


    $_SESSION['nombre'] = $nombreForm;
    $_SESSION['apellido1'] = $apellido1Form;
    $_SESSION['apellido2'] = $apellido2Form;
    $_SESSION['dni'] = $dniForm;
    $_SESSION['email'] = $emailForm;
    $_SESSION['usuario'] = $usuarioForm;
    
    if (empty($errores)) {
        $_SESSION['password'] = $passwordForm;
        header("Location: registro_paso1.php");
    } else {
        $_SESSION['error_registro'] = $errores;
         header("Location: registro.php");
    }
}
