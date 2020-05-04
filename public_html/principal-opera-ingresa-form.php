<?php
require_once '../resources/config.php';
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
                <h1 class="w3-text-teal">Ingreso en la cuenta <?= $cuenta['alias'] ?>
                </h1>
                <hr>
            </div>
            <div class="w3-third w3-container">
            </div>
        </div>

        <div class="w3-row">
            <div class="w3-twothird w3-container">
                <form class="w3-container" method="post" action="principal-opera-ingresa-valida-form.php">
                    <input type="text" name="indice" hidden value="<?= $indice ?>">
                    <div class="w3-row-padding w3-padding">
                        <div class="w3-col m6 l6">
                            <label>Concepto del ingreso</label>
                            <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="concepto" required placeholder="Ejemplos: nómina, cobro de factura...">
                        </div>
                        <div class="w3-col m6 l6">
                            <label>Importe</label>
                            <input class="w3-input w3-border w3-right-align w3-hover-border-black" style="width:100%;" type="text" 
                                   name="importe" pattern="([0-9]{1,8})|([0-9]{1,8}\.[0-9]{2})" title="Debes introducir un número y usar el punto como separador decimal" required placeholder="Ejemplo: 100.00">
                        </div>
                    </div>
                    <div class="w3-row-padding w3-margin">
                        <button type="submit" name="ingresar" class="w3-button w3-block w3-teal">Ingresar</button>
                    </div>
                </form>
            </div>
            <div class="w3-third w3-container">
                <div class="w3-card-4">
                    <img src="images/cajero.jpg" class="w3-image w3-round w3-animate-right" alt="Cajero automático">
                </div>
            </div>
        </div>

<?php
    }
}
include TEMPLATES_PATH . '/principal-footer.php';
?>