<?php
require_once '../resources/config.php';
include LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';

iniciaSesionSegura();

if (!isset($_SESSION['usuario']) or $_SESSION['usuario'] == null) {
    cierraSesionSegura();
    header('Location: login-form.php');
} else {
    if (isset($_POST) and isset($_SESSION['cuentas'])) {
        // Recogemos datos del formulario y saneamos las cadenas de entrada
        $alias = trim(filter_input(INPUT_POST, 'alias', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        if (empty($alias)) {
            $errores[] = "El alias es un campo requerido";
        } else {
            $indice = intval($_POST['indice']);
            $numCuentas = count($_SESSION['cuentas']);

            if ($indice < 0 or $indice >= $numCuentas) {
                $errores[] = "La cuenta a la que haces referencia no existe";
            } else {
                $cuenta = $_SESSION['cuentas'][$indice];
                $idCuenta = $cuenta['id_cuenta'];

                $result = actualizaAliasCuentaIdCuenta($dbConexion, $idCuenta, $alias);

                if (!$result) {
                    $errores[] = "Algo falló al intentar grabar los cambios";
                } else {
                    $_SESSION['cuentas'][$indice]['alias'] = $alias;
                }
            }
        }
    }
    if (isset($errores)) {
        $_SESSION['resultado'] = 'error';
        $_SESSION['errores'] = $errores;
    } else
        $_SESSION['resultado'] = 'ok';
}
header('Location: principal-cuenta-detalle-form.php?indice=' . $indice);
