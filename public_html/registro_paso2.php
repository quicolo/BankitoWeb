<?php

require_once '../resources/config.php';

if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}

if (isset($_GET['token'])) {
    // Desinfecta el token recibido
    $token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_SPECIAL_CHARS);

    $queryRegistro = "SELECT * FROM registro_usuario WHERE token = '" . $token . "'";
    $resultRegistro = mysqli_query($dbConexion, $queryRegistro);

    // Si está todo bien tenemos que salvar los datos en las tablas adecuadas
    if ($resultRegistro && mysqli_num_rows($resultRegistro) == 1) {
        $arrayRegistro = mysqli_fetch_assoc($resultRegistro);
        $nombre = $arrayRegistro['nombre'];
        $ape1 = $arrayRegistro['apellido1'];
        $ape2 = $arrayRegistro['apellido2'];
        $nif = $arrayRegistro['nif'];
        $email = $arrayRegistro['email'];
        $usuario = $arrayRegistro['usuario'];
        $password = $arrayRegistro['password'];

        // Asignamos por defecto el perfil de "cliente"
        $queryPerfil = "SELECT id_perfil_usuario FROM perfil_usuario WHERE nombre = 'Cliente'";
        $resultPerfil = mysqli_query($dbConexion, $queryPerfil);
        $arrayPerfil = mysqli_fetch_assoc($resultPerfil);
        $idPerfil = $arrayPerfil['id_perfil_usuario'];

        // Ahora hay que pasar los datos del registro a las tablas usuario
        $insertUsuario = "INSERT INTO usuario (nombre, password, fecha_creacion, perfil_usuario_id_perfil) "
                . "VALUES "
                . "('$usuario', '$password', now(), '$idPerfil')";

        $resultUsuario = mysqli_query($dbConexion, $insertUsuario);

        if ($resultUsuario) {
            $queryIdUsuario = "SELECT id_usuario FROM usuario WHERE nombre = '$usuario'";
            $resultIdUsuario = mysqli_query($dbConexion, $queryIdUsuario);
            $arrayIdUsuario = mysqli_fetch_assoc($resultIdUsuario);
            $idUsuario = $arrayIdUsuario['id_usuario'];

            $insertCliente = "INSERT INTO cliente (nombre, apellido1, apellido2, nif, email, fecha_creacion, usuario_id_usuario)"
                    . " VALUES ('$nombre', '$ape1', '$ape2', '$nif', '$email', now(), '$idUsuario')";
            $resultCliente = mysqli_query($dbConexion, $insertCliente);

            if ($resultUsuario) {
                header('Location: registro-final-ok.php');
            } else {
                $_SESSION['error'] = "Ha ocurrido un error en el proceso de validación del e-mail";
            }
        } else {
            $_SESSION['error'] = "Ha ocurrido un error en el proceso de validación del e-mail";
        }
    } else {
        $_SESSION['error'] = "Ha ocurrido un error en el proceso de validación del e-mail";
    }
} else {
    $_SESSION['error'] = "Error: URL mal formada";
}

if (isset($_SESSION['error'])) {
    header('Location: error-general.php');
}