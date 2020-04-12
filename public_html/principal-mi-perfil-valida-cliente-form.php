<?php
require_once '../resources/config.php';
include LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';
include LIBRARY_PATH . '/valida-entrada.php';

if (!isset($_SESSION['usuario']) or $_SESSION['usuario'] == null) {
    cierraSesionSegura();
    header('Location: login-form.php');
}
else {

    if (isset($_POST))  {
        // Recogemos datos del formulario y saneamos las cadenas de entrada
        $emailForm = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $direccionForm = trim(filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        
        // Validamos el email
        if (empty($emailForm)) {
            $errores[] = "El email es un campo requerido";
        } else {
            if (!validaEmail($emailForm)) {
                $errores[] = "El email tiene un formato incorrecto";
            }
        }

        $_SESSION['cliente']['email'] = $emailForm;
        $_SESSION['cliente']['direccion_completa'] = $direccionForm;     
        
        header('Location: principal-mi-perfil-form.php');
        if (!isset($errores)) {
            $resultCliente = buscaClientePorNif($dbConexion, $_SESSION['cliente']['nif']);
            if ($resultCliente && mysqli_num_rows($resultCliente) == 1) {
                $arrayCliente = mysqli_fetch_assoc($resultCliente);
                $idCliente = $arrayCliente['id_cliente'];
                
                $resultEmail = actualizaEmailCliente($dbConexion, $idCliente, $_SESSION['cliente']['email']);
                $resultDireccion = actualizaDireccionCliente($dbConexion, $idCliente, $_SESSION['cliente']['direccion_completa']);
                
                if(!$resultEmail or !$resultDireccion) {
                    $errores[]="Se produjo un error al guardar los datos";
                }
                else {
                    $_SESSION['actualiza_ok']=true;
                }
            }
            else {
                $errores[]="No se encuentra el cliente con NIF/NIE ".$_SESSION['cliente']['nif'];
            }
            
            if(isset($errores))
                $_SESSION['errores']=$errores;
        }
    } 
    else {
        cierraSesionSegura();
        header('Location: login-form.php');
    }

}