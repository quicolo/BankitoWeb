<?php
require_once '../../resources/config.php';
include LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';

iniciaSesionSegura();

if (!isset($_SESSION['usuario']) or $_SESSION['usuario'] == null) {
    cierraSesionSegura();
    header('Location: login-form.php');
} else {
    if (isset($_POST) and isset($_SESSION['cuentas']) and isset($_SESSION['indice'])) {
        $eleccion = $_POST['operacion'];
        switch($eleccion) {
            case "interna-propia":
                header('Location: principal-opera-transfe-interna-propia-form.php');
            break;
            case "interna-ajena":
                header('Location: principal-opera-transfe-interna-ajena-form.php');
            break;
            case "externa":
                header('Location: principal-opera-transfe-externa-form.php');
            break;
            default:
                $errores[] = "Elección de tipo de cuenta errónea.";
        }
    }
    else {
        $errores[] = "Fallo en los datos de la sesión.";
    }
    if (isset($errores)) {
        $_SESSION['resultado'] = 'error';
        $_SESSION['errores'] = $errores;
        header('Location: principal-opera-transfe-form?indice='.$_SESSION['indice']);
    }
}
