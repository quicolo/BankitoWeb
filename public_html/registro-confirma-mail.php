<?php

require_once '../resources/config.php';
require LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';

iniciaSesionSegura();

if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}

if (isset($_GET['token'])) {
    // Desinfecta el token recibido
    $token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $resultRegistro = buscaRegistroUsuarioPorToken($dbConexion, $token);

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
        $resultPerfil = buscaPerfilPorNombre($dbConexion, 'Cliente');
        $arrayPerfil = mysqli_fetch_assoc($resultPerfil);
        $idPerfil = $arrayPerfil['id_perfil_usuario'];

        // Ahora hay que pasar los datos del registro a las tablas usuario
        $resultUsuario = insertaUsuario($dbConexion, $usuario, $password, $idPerfil);

        if ($resultUsuario) {
            $resultIdUsuario = buscaUsuarioPorNombre($dbConexion, $usuario);
            $arrayIdUsuario = mysqli_fetch_assoc($resultIdUsuario);
            $idUsuario = $arrayIdUsuario['id_usuario'];
            
            $resultCliente = insertaCliente($dbConexion, $nombre, $ape1, $ape2, $nif, $email, $idUsuario);
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