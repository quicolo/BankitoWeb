<?php

require_once '../resources/config.php';
include LIBRARY_PATH . '/valida-entrada.php';
include LIBRARY_PATH . '/maneja-sesion.php';

iniciaSesionSegura();

// Recoger datos del formulario
if (isset($_POST)) {

    // Recogemos datos del formulario y saneamos las cadenas de entrada
    $nifForm = trim(filter_input(INPUT_POST, 'nif', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $emailForm = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $usuarioForm = trim(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    // Validamos el NIF
    if (empty($nifForm)) {
        $errores[] = "El NIF/NIE es un campo requerido";
    } else {
        if (!validaNif($nifForm)) {
            $errores[] = "El NIF/NIE no es correcto (formato: 00000000A)";
        }
    }

    // Validamos que al menos uno esté relleno
    if (empty($emailForm) && empty($usuarioForm)) {
        $errores[] = "Debes rellenar el e-mail o el nombre de usuario";
    }

    // Validamos el email
    if (!empty($emailForm) && !validaEmail($emailForm)) {
        $errores[] = "El email tiene un formato incorrecto";
    }

    // Validamos el nombre de usuario
    if (!empty($usuarioForm ) && !validaUsuario($usuarioForm)) {
        $errores[] = "El nombre de usuario tiene un formato incorrecto (solo letras, números, guiones y _)";
    }

    if (empty($errores)) {
        $_SESSION['nif'] = $nifForm;
        $_SESSION['email'] = $emailForm;
        $_SESSION['usuario'] = $usuarioForm;
        $_SESSION['direccionIp'] = $_SERVER['REMOTE_ADDR'] ?? "0.0.0.0";
        header("Location: olvido-enviar-mail.php");
    } else {
        $_SESSION['error_registro'] = $errores;
        header("Location: olvido-form.php");
    }
}
