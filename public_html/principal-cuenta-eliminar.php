<?php
require_once '../resources/config.php';
include LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';
include LIBRARY_PATH . '/maneja-cuenta.php';
include LIBRARY_PATH . '/maneja-mensajes-form.php';

iniciaSesionSegura();

// Validamos la sesión y la existencia del índice en la sesión
if (!isset($_SESSION['usuario']) or $_SESSION['usuario'] == null or
    !isset($_SESSION['indice'])) {
  cierraSesionSegura();
  header('Location: login-form.php');
}
else {
  $indice = $_SESSION['indice'];
  $cuenta = $_SESSION['cuentas'][$indice];

  // Si la cuenta existe y el saldo el cero entonces borramos
  if (is_array($cuenta) and $cuenta['saldo'] == 0) {
    $idCuenta = $cuenta['id_cuenta'];
  
    $resultado = borraCuentaPorIdCuenta($dbConexion, $idCuenta);
    if ($resultado == false) {
        $_SESSION['resultado'] = 'error';
        $errores[] = 'Algo salió mal al borrar la cuenta';
    }
    else {
        $_SESSION['resultado'] = 'ok';
        unset($_SESSION['cuentas'][$indice]);
        header('Location: principal-cuenta.php');
    }
  }
  else { // Volvemos a la página anterior pero se mostrará un mensaje de error
    $_SESSION['resultado'] = 'error';
    $errores[] = 'Solo se pueden eliminar la cuentas con saldo CERO. Realice las operaciones necesarias antes de eliminar la cuenta.';
    $_SESSION['errores'] = $errores;
    header('Location: principal-cuenta-detalle-form.php?indice='.$indice);
  }

}
