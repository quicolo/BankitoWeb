<?php

/***************************************/
/**********   TABLA CLIENTE   **********/
/***************************************/
function buscaClientePorNif($dbConexion, $nif) {
    $queryCliente = "SELECT * FROM cliente WHERE nif = '" . $nif . "'";
    return mysqli_query($dbConexion, $queryCliente);
}

function insertaCliente($dbConexion, $nombre, $ape1, $ape2, $nif, $email, $idUsuario) {
    $insertCliente = "INSERT INTO cliente (nombre, apellido1, apellido2, nif, email, fecha_creacion, usuario_id_usuario)"
    . " VALUES ('$nombre', '$ape1', '$ape2', '$nif', '$email', now(), $idUsuario)";
    
    return mysqli_query($dbConexion, $insertCliente);
}

/***************************************/
/**********   TABLA USUARIO   **********/
/***************************************/
function buscaUsuarioPorId($dbConexion, $idUsuario) {
    $queryUsuario = "SELECT * FROM usuario WHERE id_usuario = '" . $idUsuario . "'";
    return mysqli_query($dbConexion, $queryUsuario);
}

function buscaUsuarioPorNombre($dbConexion, $nombre) {
    $queryUsuario = "SELECT * FROM usuario WHERE nombre = '" . $nombre . "'";
    return mysqli_query($dbConexion, $queryUsuario);
}

function insertaUsuario($dbConexion, $nombre, $password, $idPerfil) {
    $insertUsuario = "INSERT INTO usuario (nombre, password, fecha_creacion, perfil_usuario_id_perfil) "
                . "VALUES "
                . "('$nombre', '$password', now(), $idPerfil)";

    return mysqli_query($dbConexion, $insertUsuario);
}

function actualizaPasswordUsuarioPorId ($dbConexion, $newPass, $idUsuario) {
    $queryActualiza = "UPDATE usuario SET password='".$newPass."' WHERE id_usuario=".$idUsuario;
    return mysqli_query($dbConexion, $queryActualiza);
}


/***************************************/
/*****   TABLA REGISTRO_USUARIO   ******/
/***************************************/
function insertaRegistroUsuario($dbConexion, $token, $ip, $nombre, $ape1, $ape2, $nif, $email, $usu, $pass) {
    $insertRegistro = "INSERT INTO registro_usuario 
            (token, direccion_ip, nombre, apellido1, apellido2, nif, email, usuario, password, fecha_creacion) 
            VALUES 
            ('$token', '$ip', '$nombre', '$ape1', '$ape2', '$nif', '$email', '$usu', '$pass', now())";

    return mysqli_query($dbConexion, $insertRegistro);
}

function buscaRegistroUsuarioPorToken($dbConexion, $token) {
    $queryRegistro = "SELECT * FROM registro_usuario WHERE token = '" . $token . "'";
    return mysqli_query($dbConexion, $queryRegistro);
}

/***************************************/
/***********   TABLA PERFIL   **********/
/***************************************/
function buscaPerfilPorNombre($dbConexion, $nombre) {
    $queryPerfil = "SELECT id_perfil_usuario FROM perfil_usuario WHERE nombre = '".$nombre."'";
    return mysqli_query($dbConexion, $queryPerfil);
}

/***************************************/
/*****   TABLA RESTABLECE_PASS   *******/
/***************************************/
function insertaRestablecePass($dbConexion, $token, $ip, $nif, $email, $usuario) {
    $insertRegistro = "INSERT INTO restablece_pass 
                    (token, direccion_ip, nif, email, usuario, fecha_creacion) 
        VALUES      ('$token', '$ip', '$nif', '$email', '$usuario', now())";

    return mysqli_query($dbConexion, $insertRegistro);
}

function buscaRestablecePassPorToken($dbConexion, $token) {
    $queryToken = "SELECT * FROM restablece_pass WHERE token = '" . $token . "'";
    return mysqli_query($dbConexion, $queryToken);
}
