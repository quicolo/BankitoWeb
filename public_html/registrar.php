<?php

require_once '../resources/config.php';
include LIBRARY_PATH . '/valida_entrada.php';

// Recoger datos del formulario
if (isset($_POST)) {

    // Recoger datos del formulario y limpiamos de espacios el principio
    // y final de las cadenas
    $nombreForm = trim($_POST['nombre']);
    $apellido1Form = trim($_POST['apellido1']);
    $apellido2Form = trim($_POST['apellido2']);
    $emailForm = trim($_POST['email']);
    $usuarioForm = trim($_POST['usuario']);
    $passwordForm = trim($_POST['password']);

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
    
    if (empty($errores)) {
        echo "Registro correcto";
    } else {
        $_SESSION['error_registro'] = $errores;
        header("Location: registro.php");
    }
}
