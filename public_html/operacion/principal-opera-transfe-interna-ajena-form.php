<?php
require_once '../../resources/config.php';
include LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';
include LIBRARY_PATH . '/maneja-cuenta.php';

iniciaSesionSegura();

if (!isset($_SESSION['usuario']) or $_SESSION['usuario'] == null) {
    cierraSesionSegura();
    header('Location: login-form.php');
} else {

    if (isset($_POST) and isset($_SESSION['cuentas']) and isset($_SESSION['indice'])) {
        $numCuentas = count($_SESSION['cuentas']);
        if ($numCuentas > 1) {
            include TEMPLATES_PATH . '/principal-sidebar.php';
            include TEMPLATES_PATH . '/principal-header.php';

            $indice = $_SESSION['indice'];
            $cuentaOrigen = $_SESSION['cuentas'][$indice];
?>
            <div class="w3-row">
                <div class="w3-twothird w3-container">
                    <h1 class="w3-text-teal">Transferir a otra persona de Bankito
                    </h1>
                    <hr>
                </div>
                <div class="w3-third w3-container">
                </div>
            </div>

            <div class="w3-row">
                <div class="w3-twothird w3-container">
                    <form class="w3-container" method="post" action="principal-opera-transfe-realiza-oper-interna-ajena.php">
                        <input type="hidden" name="saldoOrigen" value="<?= $cuentaOrigen['saldo'] ?>">
                        <div class="w3-row-padding w3-padding">
                            <p>Cuenta origen</p>
                            <?php
                            muestraCuentaOrigen($cuentaOrigen);
                            ?>
                        </div>
                        <div class="w3-row-padding w3-margin">
                            <label>Indica la numeración de la cuenta de destino</label>
                            <input class="w3-input w3-border" style="width:100%" type="text" name="numeracionDestino" pattern="[0-9]{4}\-[0-9]{4}\-[0-9]{2}\-[0-9]{10}" title="Debes introducir la cuenta en el formato 0000-0000-00-0000000000" placeholder="0000-0000-00-0000000000" required>
                        </div>
                        <div class="w3-row-padding w3-margin">
                            <label>Concepto</label>
                            <input class="w3-input w3-border" style="width:100%;" type="text" name="concepto" required placeholder="Ejemplos: viaje, regalo de bodas...">
                        </div>
                        <div class="w3-row-padding w3-margin">
                            <label>Importe</label>
                            <input class="w3-input w3-border" style="width:100%;" type="text" name="importe" pattern="([0-9]{1,8})|([0-9]{1,8}\.[0-9]{2})" title="Debes introducir un número y usar el punto como separador decimal" required placeholder="Ejemplo: 100.00">
                        </div>
                        <div class="w3-row-padding w3-margin">
                            <button name="realizar-oper" class="w3-button w3-block w3-teal">Realizar operación</button>
                        </div>
                    </form>
                </div>
                <div class="w3-third w3-container">
                    <div class="w3-card-4">
                        <img src="<?=IMAGES_PATH?>/Transferencia.png" class="w3-image w3-round w3-animate-right" alt="Transferencia">
                    </div>
                </div>
            </div>


<?php
        } else {
            $errores = "Necesitas al menos dos cuentas para poder realizar la transferencia.";
        }
    } else {
        $errores[] = "Fallo en los datos de la sesión.";
    }
    if (isset($errores)) {
        $_SESSION['resultado'] = 'error';
        $_SESSION['errores'] = $errores;
        header('Location: principal-opera-transfe-form?indice=' . $_SESSION['indice']);
    } else {
        $_SESSION['resultado'] = 'ok';
    }
}
include TEMPLATES_PATH . '/principal-footer.php';
