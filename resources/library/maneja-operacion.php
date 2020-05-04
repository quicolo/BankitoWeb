<?php
include_once LIBRARY_PATH . '/maneja-base-datos.php';

function realizaIngreso($dbConexion, $idCuenta, $concepto, $importe)
{
    mysqli_autocommit($dbConexion, false);
    mysqli_begin_transaction($dbConexion, MYSQLI_TRANS_START_READ_WRITE);

    $resultado = buscaTipoMovimientoPorCodigo($dbConexion, 'INGRESO') ;
    $idTipoMovim = 0;
    $salida = false; 

    if ($resultado && mysqli_num_rows($resultado)==1) {
        $tipoMov = mysqli_fetch_assoc($resultado);
        $idTipoMovim = $tipoMov['id_tipo_movimiento'];
        
        $resultCrea = creaMovimiento($dbConexion, $concepto, $importe, $idCuenta, $idTipoMovim);
        if ($resultCrea) {
            $resultOper = incrementaSaldoCuentaPorIdCuenta($dbConexion, $idCuenta, $importe);

            if ($resultOper) {
                mysqli_commit($dbConexion);
                $salida =  true;
            }
            else {
                mysqli_rollback($dbConexion);
            }
        }
        else {
            mysqli_rollback($dbConexion);
        }
    }
    else {
        mysqli_rollback($dbConexion);
    }
    mysqli_autocommit($dbConexion, true);
    return $salida;
}

function realizaRetirada($dbConexion, $idCuenta, $concepto, $importe)
{
    mysqli_autocommit($dbConexion, false);
    mysqli_begin_transaction($dbConexion, MYSQLI_TRANS_START_READ_WRITE);

    $resultado = buscaTipoMovimientoPorCodigo($dbConexion, 'RETIRADA') ;
    $idTipoMovim = 0;
    $salida = false; 

    if ($resultado && mysqli_num_rows($resultado)==1) {
        $tipoMov = mysqli_fetch_assoc($resultado);
        $idTipoMovim = $tipoMov['id_tipo_movimiento'];
        
        $resultCrea = creaMovimiento($dbConexion, $concepto, $importe, $idCuenta, $idTipoMovim);
        if ($resultCrea) {
            $resultOper = decrementaSaldoCuentaPorIdCuenta($dbConexion, $idCuenta, $importe);

            if ($resultOper) {
                mysqli_commit($dbConexion);
                $salida =  true;
            }
            else {
                mysqli_rollback($dbConexion);
            }
        }
        else {
            mysqli_rollback($dbConexion);
        }
    }
    else {
        mysqli_rollback($dbConexion);
    }
    mysqli_autocommit($dbConexion, true);
    return $salida;
}

function realizaTransferenciaInterna($dbConexion, $idCuentaOrigen, $idCuentaDestino, $concepto, $importe)
{
    mysqli_autocommit($dbConexion, false);
    mysqli_begin_transaction($dbConexion, MYSQLI_TRANS_START_READ_WRITE);

    $resultadoSal = buscaTipoMovimientoPorCodigo($dbConexion, 'TRANS_SAL') ;
    $resultadoEnt = buscaTipoMovimientoPorCodigo($dbConexion, 'TRANS_ENT') ;
    $cuentaOrig = buscaCuentaPorIdCuenta($dbConexion, $idCuentaOrigen);
    $cuentaDestino = buscaCuentaPorIdCuenta($dbConexion, $idCuentaDestino);
    $idTipoMovim = 0;
    $salida = false; 

    if ($resultadoSal && mysqli_num_rows($resultadoSal)==1 &&
        $resultadoEnt && mysqli_num_rows($resultadoEnt)==1 &&
        $cuentaOrig &&  mysqli_num_rows($cuentaOrig)==1 &&
        $cuentaDestino &&  mysqli_num_rows($cuentaDestino)==1) 
    {
        $tipoMovSal = mysqli_fetch_assoc($resultadoSal);
        $idTipoMovimSal = $tipoMovSal['id_tipo_movimiento'];

        $tipoMovEnt = mysqli_fetch_assoc($resultadoEnt);
        $idTipoMovimEnt = $tipoMovEnt['id_tipo_movimiento'];
    
        $resultCreaSal = creaMovimiento($dbConexion, $concepto, $importe, $idCuentaOrigen, $idTipoMovimSal);
        $resultCreaEnt = creaMovimiento($dbConexion, $concepto, $importe, $idCuentaDestino, $idTipoMovimEnt);
        if ($resultCreaSal && $resultCreaEnt) {
            $resultOperSal = decrementaSaldoCuentaPorIdCuenta($dbConexion, $idCuentaOrigen, $importe);
            $resultOperEnt = incrementaSaldoCuentaPorIdCuenta($dbConexion, $idCuentaDestino, $importe);

            if ($resultOperSal && $resultOperEnt) {
                mysqli_commit($dbConexion);
                $salida =  true;
            }
            else {
                mysqli_rollback($dbConexion);
            }
        }
        else {
            mysqli_rollback($dbConexion);
        }
    }
    else {
        mysqli_rollback($dbConexion);
    }
    mysqli_autocommit($dbConexion, true);
    return $salida;
}

function realizaTransferenciaExterna($dbConexion, $idCuentaOrigen, $concepto, $importe)
{
    mysqli_autocommit($dbConexion, false);
    mysqli_begin_transaction($dbConexion, MYSQLI_TRANS_START_READ_WRITE);

    $resultadoSal = buscaTipoMovimientoPorCodigo($dbConexion, 'TRANS_SAL') ;
    $cuentaOrig = buscaCuentaPorIdCuenta($dbConexion, $idCuentaOrigen);
    $idTipoMovim = 0;
    $salida = false; 

    if ($resultadoSal && mysqli_num_rows($resultadoSal)==1 &&
        $cuentaOrig &&  mysqli_num_rows($cuentaOrig)==1) 
    {
        $tipoMovSal = mysqli_fetch_assoc($resultadoSal);
        $idTipoMovimSal = $tipoMovSal['id_tipo_movimiento'];
    
        $resultCreaSal = creaMovimiento($dbConexion, $concepto, $importe, $idCuentaOrigen, $idTipoMovimSal);
        if ($resultCreaSal) {
            $resultOperSal = decrementaSaldoCuentaPorIdCuenta($dbConexion, $idCuentaOrigen, $importe);

            if ($resultOperSal) {
                mysqli_commit($dbConexion);
                $salida =  true;
            }
            else {
                mysqli_rollback($dbConexion);
            }
        }
        else {
            mysqli_rollback($dbConexion);
        }
    }
    else {
        mysqli_rollback($dbConexion);
    }
    mysqli_autocommit($dbConexion, true);
    return $salida;
}