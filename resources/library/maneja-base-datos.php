<?php
include_once LIBRARY_PATH . '/maneja-consola.php';

/***************************************/
/**********   TABLA CLIENTE   **********/
/***************************************/
function buscaClientePorNif($dbConexion, $nif) {
    $queryCliente = "SELECT * FROM cliente WHERE nif = '" . $nif . "'";
    imprimePorConsola($queryCliente);
    $result =  mysqli_query($dbConexion, $queryCliente);
    imprimePorConsola($result);
    return $result;
}

function buscaClientePorIdUsuario($dbConexion, $idUsuario) {
    $queryCliente = "SELECT * FROM cliente WHERE usuario_id_usuario = " . $idUsuario;
    imprimePorConsola($queryCliente);
    $result =  mysqli_query($dbConexion, $queryCliente);
    imprimePorConsola($result);
    return $result;
}

function insertaCliente($dbConexion, $nombre, $ape1, $ape2, $nif, $email, $idUsuario) {
    $insertCliente = "INSERT INTO cliente (nombre, apellido1, apellido2, nif, email, fecha_creacion, usuario_id_usuario)"
    . " VALUES ('$nombre', '$ape1', '$ape2', '$nif', '$email', now(), $idUsuario)";
    imprimePorConsola($insertCliente);
    $result =  mysqli_query($dbConexion, $insertCliente);
    imprimePorConsola($result);
    return $result;
}

function actualizaEmailCliente($dbConexion, $idCliente, $email) {
    $actualizaCliente = "UPDATE cliente SET email = '".$email."' WHERE id_cliente = ".$idCliente;
    imprimePorConsola($actualizaCliente);
    $result =  mysqli_query($dbConexion, $actualizaCliente);
    imprimePorConsola($result);
    return $result;
}

function actualizaDireccionCliente($dbConexion, $idCliente, $direccion) {
    $actualizaCliente = "UPDATE cliente SET direccion_completa = '".$direccion."' WHERE id_cliente = ".$idCliente;
    imprimePorConsola($actualizaCliente);
    $result =  mysqli_query($dbConexion, $actualizaCliente);
    imprimePorConsola($result);
    return $result;
}

/***************************************/
/**********   TABLA USUARIO   **********/
/***************************************/
function buscaUsuarioPorId($dbConexion, $idUsuario) {
    $queryUsuario = "SELECT * FROM usuario WHERE id_usuario = '" . $idUsuario . "'";
    imprimePorConsola($queryUsuario);
    $result =  mysqli_query($dbConexion, $queryUsuario);
    imprimePorConsola($result);
    return $result;
}

function buscaUsuarioPorNombre($dbConexion, $nombre) {
    $queryUsuario = "SELECT * FROM usuario WHERE nombre = '" . $nombre . "'";
    imprimePorConsola($queryUsuario);
    $result =  mysqli_query($dbConexion, $queryUsuario);
    imprimePorConsola($result);
    return $result;
}

function insertaUsuario($dbConexion, $nombre, $password, $idPerfil) {
    $insertUsuario = "INSERT INTO usuario (nombre, password, fecha_creacion, perfil_usuario_id_perfil) "
                . "VALUES "
                . "('$nombre', '$password', now(), $idPerfil)";

    imprimePorConsola($insertUsuario);
    $result =  mysqli_query($dbConexion, $insertUsuario);
    imprimePorConsola($result);
    return $result;
}

function actualizaPasswordUsuarioPorId ($dbConexion, $newPass, $idUsuario) {
    $queryActualiza = "UPDATE usuario SET password='".$newPass."' WHERE id_usuario=".$idUsuario;
    imprimePorConsola($queryActualiza);
    $result =  mysqli_query($dbConexion, $queryActualiza);
    imprimePorConsola($result);
    return $result;
}


/***************************************/
/*****   TABLA REGISTRO_USUARIO   ******/
/***************************************/
function insertaRegistroUsuario($dbConexion, $token, $ip, $nombre, $ape1, $ape2, $nif, $email, $usu, $pass) {
    $insertRegistro = "INSERT INTO registro_usuario 
            (token, direccion_ip, nombre, apellido1, apellido2, nif, email, usuario, password, fecha_creacion) 
            VALUES 
            ('$token', '$ip', '$nombre', '$ape1', '$ape2', '$nif', '$email', '$usu', '$pass', now())";

    imprimePorConsola($insertRegistro);
    $result =  mysqli_query($dbConexion, $insertRegistro);
    imprimePorConsola($result);
    return $result;
}

function buscaRegistroUsuarioPorToken($dbConexion, $token) {
    $insertCuentas = "SELECT * FROM registro_usuario WHERE token = '" . $token . "'";
    imprimePorConsola($insertCuentas);
    $result =  mysqli_query($dbConexion, $insertCuentas);
    imprimePorConsola($result);
    return $result;
}

/***************************************/
/***********   TABLA PERFIL   **********/
/***************************************/
function buscaPerfilPorNombre($dbConexion, $nombre) {
    $queryPerfil = "SELECT id_perfil_usuario FROM perfil_usuario WHERE nombre = '".$nombre."'";
    imprimePorConsola($queryPerfil);
    $result =  mysqli_query($dbConexion, $queryPerfil);
    imprimePorConsola($result);
    return $result;
}

/***************************************/
/*****   TABLA RESTABLECE_PASS   *******/
/***************************************/
function insertaRestablecePass($dbConexion, $token, $ip, $nif, $email, $usuario) {
    $insertRegistro = "INSERT INTO restablece_pass 
                    (token, direccion_ip, nif, email, usuario, fecha_creacion) 
        VALUES      ('$token', '$ip', '$nif', '$email', '$usuario', now())";

    imprimePorConsola($insertRegistro);
    $result =  mysqli_query($dbConexion, $insertRegistro);
    imprimePorConsola($result);
    return $result;
}

function buscaRestablecePassPorToken($dbConexion, $token) {
    $queryToken = "SELECT * FROM restablece_pass WHERE token = '" . $token . "'";
    imprimePorConsola($queryToken);
    $result =  mysqli_query($dbConexion, $queryToken);
    imprimePorConsola($result);
    return $result;
}

/***************************************/
/**********   TABLA CUENTA    **********/
/***************************************/
function buscaCuentasPorIdUsuario($dbConexion, $idUsuario) {
    $queryCuentas = "SELECT * FROM cuenta WHERE usuario_id_usuario = " . $idUsuario;
    imprimePorConsola($queryCuentas);
    $result =  mysqli_query($dbConexion, $queryCuentas);
    imprimePorConsola($result);
    return $result;
}

function buscaCuentaPorEntidadSucursal($dbConexion, $idEntidad, $idSucursal) {
    $queryCuentas = "SELECT * FROM cuenta WHERE num_entidad = '$idEntidad' and num_sucursal = '$idSucursal' order by num_cuenta desc";
    imprimePorConsola($queryCuentas);
    $result =  mysqli_query($dbConexion, $queryCuentas);
    imprimePorConsola($result);
    return $result;
}


function creaCuentaParaIdUsuario($dbConexion, $entidad, $sucursal, $dc, $numcc, $idUsuario) {
    $insertCuentas = "INSERT INTO cuenta (num_entidad, num_sucursal, num_digito_control, num_cuenta, saldo, fecha_creacion, usuario_id_usuario) VALUES ($entidad, $sucursal, $dc, $numcc, 0.0, now(), $idUsuario)";
    imprimePorConsola($insertCuentas);
    $result =  mysqli_query($dbConexion, $insertCuentas);
    imprimePorConsola($result);
    return $result;
}

function actualizaSaldoCuentaIdCuenta($dbConexion, $idCuenta, $saldo) {
    $actualizaCuenta = "UPDATE cuenta SET saldo=$saldo WHERE id_cuenta=$idCuenta";
    
    imprimePorConsola($actualizaCuenta);
    $result =  mysqli_query($dbConexion, $actualizaCuenta);
    imprimePorConsola($result);
    return $result;
}

function actualizaAliasCuentaIdCuenta($dbConexion, $idCuenta, $alias) {
    $actualizaCuenta = "UPDATE cuenta SET alias='$alias' WHERE id_cuenta=$idCuenta";
    
    imprimePorConsola($actualizaCuenta);
    $result =  mysqli_query($dbConexion, $actualizaCuenta);
    imprimePorConsola($result);
    return $result;
}

function borraCuentaPorIdCuenta($dbConexion, $idCuenta) {
    // Los movimientos de la cuenta se borran automáticamente
    // hay un ON DELETE CASCADE en la clave ajena
    $deleteCuentas = "DELETE FROM cuenta WHERE id_cuenta=$idCuenta";
    
    imprimePorConsola($deleteCuentas);
    $result =  mysqli_query($dbConexion, $deleteCuentas);
    imprimePorConsola($result);
    return $result;
}