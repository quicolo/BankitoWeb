<?php
require_once '../../resources/config.php';
include LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';
include LIBRARY_PATH . '/maneja-cuenta.php';
include LIBRARY_PATH . '/valida-entrada.php';
include LIBRARY_PATH . '/maneja-operacion.php';
include LIBRARY_PATH . '/maneja-mensajes-form.php';

iniciaSesionSegura();

if (!isset($_SESSION['usuario']) or $_SESSION['usuario'] == null) {
    cierraSesionSegura();
    header('Location: login-form.php');
} else {
    if (
        $_POST['origen'] and $_POST['destino'] and $_POST['concepto'] and
        $_POST['importe'] and $_POST['saldoOrigen'] and isset($_SESSION['cuentas'])
    ) {

        $idCuentaOrigen = $_POST['origen'];
        $idCuentaDestino = $_POST['destino'];
        $saldoOrigen = $_POST['saldoOrigen'];
        $concepto = trim(filter_input(INPUT_POST, 'concepto', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $importe = trim(filter_input(INPUT_POST, 'importe', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        if (empty($concepto)) {
            $errores[] = "El concepto es un campo requerido";
        } else if (empty($importe) or !validaImporte($importe)) {
            $errores[] = "El importe es un campo requerido y debe ser numérico";
        } else if ($importe > $saldoOrigen) {
            $errores[] = "No hay saldo suficiente en la cuenta origen para realizar la transferencia";
        } else {
            $result = realizaTransferenciaInterna($dbConexion, $idCuentaOrigen, $idCuentaDestino, $concepto, $importe);
            if (!$result) {
                $errores[] = "Se produjo un error al realizar la transferencia.";
            }
        }
    } else {
        cierraSesionSegura();
        header('Location: login-form.php');
    }
    include TEMPLATES_PATH . '/principal-sidebar.php';
    include TEMPLATES_PATH . '/principal-header.php';
?>
    <div class="w3-row">
        <div class="w3-twothird w3-container">
            <h1 class="w3-text-teal">Resultado de la operación
            </h1>
            <hr>
        </div>
        <div class="w3-third w3-container">
        </div>
    </div>
    <?php
    muestraMensajesOperacion(false);

}
include TEMPLATES_PATH . '/principal-footer.php';
