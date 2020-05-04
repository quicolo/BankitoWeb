<?php
require_once '../resources/config.php';
include LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';
include LIBRARY_PATH . '/maneja-cuenta.php';

iniciaSesionSegura();

if (!isset($_SESSION['usuario']) or $_SESSION['usuario'] == null) {
    cierraSesionSegura();
    header('Location: login-form.php');
} else {
    if (isset($_POST)) {
        // Recogemos datos del formulario y saneamos las cadenas de entrada
        $alias = trim(filter_input(INPUT_POST, 'alias', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        $nuevaCuenta = '';

        if (empty($alias)) {
            $errores[] = "El alias es un campo requerido";
        } else {
            // Comprobar cuántas cuentas tiene y que no se supere el máximo.
            $idUsuario = $_SESSION['usuario']['id_usuario'];
            $numCuentasActual = cuentaCuentasPorIdUsuario($dbConexion, $idUsuario);
            
            if ($numCuentasActual < NUM_MAX_CUENTAS_POR_USUARIO) {

                $arrayCuenta = generaSiguienteNumCuenta($dbConexion, COD_ENTIDAD, COD_SUCURSAL);
                
                $dc = $arrayCuenta['dc'];
                $numcc = $arrayCuenta['cuenta'];
                $resultado = creaCuentaParaIdUsuario($dbConexion, $alias, COD_ENTIDAD, COD_SUCURSAL, $dc, $numcc, $idUsuario);
                if ($resultado == false) {
                    $errores[] = "Algo falló al intentar grabar los datos de la nueva cuenta";
                }
                else {
                    $idCuenta = mysqli_insert_id($dbConexion);
                    $resultadoNuevaCuenta = buscaCuentaPorIdCuenta($dbConexion, $idCuenta);
                    if ($resultadoNuevaCuenta && mysqli_num_rows($resultadoNuevaCuenta) == 1) {
                        $nuevaCuenta = mysqli_fetch_assoc($resultadoNuevaCuenta);
                    }
                    else {
                        $errores[] = "Algo falló al intentar recuperar los datos de la nueva cuenta";
                    }
                }
            }
            else {
                $errores[] = 'Ya tienes '.NUM_MAX_CUENTAS_POR_USUARIO.' cuentas. No puedes crear más.';
            }
        }
        if (isset($errores)) {
            $_SESSION['resultado'] = 'error';
            $_SESSION['errores'] = $errores;
            header('Location: principal-crea-cuenta-form.php');
        } else {
            $_SESSION['resultado'] = 'ok';
            $_SESSION['cuentas'][] = $nuevaCuenta;
            $indice = count($_SESSION['cuentas']) - 1;
            header('Location: principal-cuenta-detalle-form.php?indice='.$indice);
        }
    }
    
}
