<?php
require_once '../../resources/config.php';
include LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';
include LIBRARY_PATH . '/maneja-cuenta.php';
include LIBRARY_PATH . '/maneja-mensajes-form.php';

iniciaSesionSegura();

// Validamos la sesión y la entrada del GET
if (
    !isset($_SESSION['usuario']) or $_SESSION['usuario'] == null or
    !isset($_GET['indice']) or $_GET['indice'] == null or
    !is_numeric($_GET['indice'])
) {
    cierraSesionSegura();
    header('Location: login-form.php');
} else {
    include TEMPLATES_PATH . '/principal-sidebar.php';
    include TEMPLATES_PATH . '/principal-header.php';

    //Rescatamos los datos de cliente y de usuario
    $indice = intval($_GET['indice']);
    $numCuentas = count($_SESSION['cuentas']);

    //Salvamos el índice en la sesión
    $_SESSION['indice'] = $indice;

    if ($indice < 0 or $indice >= $numCuentas) {
        $_SESSION['resultado'] = 'error';
        $_SESSION['errores'] = "La cuenta referida no existe";
    } else {
        $cuenta = $_SESSION['cuentas'][$indice];
?>
        <div class="w3-row">
            <?php
            muestraMensajesOperacion();
            ?>
            <div class="w3-twothird w3-container">
                <h1 class="w3-text-teal">Transferir desde la cuenta <?= $cuenta['alias'] ?>
                </h1>
                <hr>
            </div>
            <div class="w3-third w3-container">
            </div>
        </div>

        <div class="w3-row">
            <div class="w3-twothird w3-container">
                <form class="w3-container" method="post" action="principal-opera-transfe-reenvia.php">
                    <input type="text" name="indice" hidden value="<?= $indice ?>">

                    <div class="w3-row-padding w3-padding">
                        <p>Escoge el tipo de cuenta al que vas a hacer la transferencia:</p>
                        <p><input class="w3-radio" type="radio" name="operacion" value="interna-propia" checked>
                        <label>Transferir a una de mis cuentas en Bankito</label></p>
                        <p><input class="w3-radio" type="radio" name="operacion" value="interna-ajena">
                        <label>Transferir a una cuenta de Bankito de otra persona</label></p>
                        <p><input class="w3-radio" type="radio" name="operacion" value="externa">
                        <label>Transferir a una cuenta fuera de Bankito</label></p>
                    </div> 
                        <div class="w3-row-padding w3-margin">
                            <button type="submit" name="siguiente" class="w3-button w3-block w3-teal">Siguiente</button>
                        </div>
                </form>
            </div>
            <div class="w3-third w3-container">
                <div class="w3-card-4">
                    <img src="<?=IMAGES_PATH?>/elige-tipo-cuenta.jpg" class="w3-image w3-round w3-animate-right" alt="Transferencia">
                </div>
            </div>
        </div>

<?php
    }
}
include TEMPLATES_PATH . '/principal-footer.php';
?>