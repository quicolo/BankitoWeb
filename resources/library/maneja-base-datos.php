<?php
include LIBRARY_PATH . '/maneja-consola.php';

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
    $queryRegistro = "SELECT * FROM registro_usuario WHERE token = '" . $token . "'";
    imprimePorConsola($queryRegistro);
    $result =  mysqli_query($dbConexion, $queryRegistro);
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
