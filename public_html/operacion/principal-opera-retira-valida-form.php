<?php
require_once '../../resources/config.php';
include LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';
include LIBRARY_PATH . '/valida-entrada.php';
include LIBRARY_PATH . '/maneja-operacion.php';


iniciaSesionSegura();

if (!isset($_SESSION['usuario']) or $_SESSION['usuario'] == null) {
    cierraSesionSegura();
    header('Location: login-form.php');
} else {
    if (isset($_POST) and isset($_SESSION['cuentas'])) {
        // Recogemos datos del formulario y saneamos las cadenas de entrada
        $concepto = trim(filter_input(INPUT_POST, 'concepto', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $importe = trim(filter_input(INPUT_POST, 'importe', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        
        if (empty($concepto)) {
            $errores[] = "El concepto es un campo requerido";
        } 
        else if (empty($importe) or !validaImporte($importe)) {
            $errores[] = "El importe es un campo requerido y debe ser numérico";
        }
        else {
            $indice = intval($_POST['indice']);
            $numCuentas = count($_SESSION['cuentas']);

            if ($indice < 0 or $indice >= $numCuentas) {
                $errores[] = "La cuenta a la que haces referencia no existe";
            } else {
                $cuenta = $_SESSION['cuentas'][$indice];
                if($importe <= $cuenta['saldo']){
                    
                    $idCuenta = $cuenta['id_cuenta'];

                    $result = realizaRetirada($dbConexion, $idCuenta, $concepto, $importe);
                    if (!$result) {
                        $errores[] = "Algo falló al intentar realizar la retirada/gasto";
                    } else {
                        $_SESSION['cuentas'][$indice]['saldo'] -= $importe;
                    }
                }
                else {
                    $errores[] = "El importe a retirar no puede superar el saldo de tu cuenta.";
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
header('Location: principal-opera-retira-form.php?indice=' . $indice);
