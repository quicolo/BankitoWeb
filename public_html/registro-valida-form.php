<?php

require_once '../resources/config.php';
include LIBRARY_PATH . '/valida-entrada.php';
include LIBRARY_PATH . '/maneja-sesion.php';

iniciaSesionSegura();

// Recoger datos del formulario
if (isset($_POST)) {

    // Recogemos datos del formulario y saneamos las cadenas de entrada
    $nombreForm = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING));
    $apellido1Form = trim(filter_input(INPUT_POST, 'apellido1', FILTER_SANITIZE_STRING));
    $apellido2Form = trim(filter_input(INPUT_POST, 'apellido2', FILTER_SANITIZE_STRING));
    $nifForm = trim(filter_input(INPUT_POST, 'nif', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $emailForm = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $usuarioForm = trim(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $password1Form = trim(filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $password2Form = trim(filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    // Validamos el nombre
    if (empty($nombreForm)) {
        $errores[] = "El nombre es un campo requerido";
    } else {
        if (!validaNomApe($nombreForm)) {
            $errores[] = "El nombre tiene un formato incorrecto (solo letras espacios y guiones)";
        }
    }

    // Validamos el apellido1
    if (empty($apellido1Form)) {
        $errores[] = "El primer apellido es un campo requerido";
    } else {
        if (!validaNomApe($apellido1Form)) {
            $errores[] = "El primer apellido tiene un formato incorrecto (solo letras espacios y guiones)";
        }
    }

    // Validamos el apellido2, en este caso no será un campo requerido
    if (!empty($apellido2Form) && !validaNomApe($apellido2Form)) {
        $errores[] = "El segundo apellido tiene un formato incorrecto (solo letras espacios y guiones)";
    }

    // Validamos el NIF
    if (empty($nifForm)) {
        $errores[] = "El NIF/NIE es un campo requerido";
    } else {
        if (!validaNif($nifForm)) {
            $errores[] = "El NIF/NIE no es correcto (formato: 00000000A)";
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
            $errores[] = "El nombre de usuario tiene un formato incorrecto (solo letras, números, guiones y _)";
        }
    }

    // Validamos el password
    if (empty($password1Form)) {
        $errores[] = "La contraseña de usuario es un campo requerido";
    } else {
        if (!validaPassword($password1Form)) {
            $errores[] = errorPassword($password1Form);
        }
    }
    if (strcmp($password1Form, $password2Form) != 0) {
        $errores[] = "La contraseñas introducidas son distintas";
    }


    $_SESSION['nombre'] = $nombreForm;
    $_SESSION['apellido1'] = $apellido1Form;
    $_SESSION['apellido2'] = $apellido2Form;
    $_SESSION['nif'] = $nifForm;
    $_SESSION['email'] = $emailForm;
    $_SESSION['usuario'] = $usuarioForm;
    $_SESSION['direccionIp'] = $_SERVER['REMOTE_ADDR'] ?? "0.0.0.0";

    if (empty($errores)) {
        $_SESSION['password'] = $password1Form;
        header("Location: registro-enviar-mail.php");
    } else {
        $_SESSION['error_registro'] = $errores;
        header("Location: registro-form.php");
    }
}
