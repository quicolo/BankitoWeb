<?php
require_once '../resources/config.php';
include LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';
include LIBRARY_PATH . '/maneja-cuenta.php';
include LIBRARY_PATH . '/maneja-mensajes-form.php';

iniciaSesionSegura();

// Validamos la sesión y la entrada del GET
if (!isset($_SESSION['usuario']) or $_SESSION['usuario'] == null) {
    cierraSesionSegura();
    header('Location: login-form.php');
} else {
    include TEMPLATES_PATH . '/principal-sidebar.php';
    include TEMPLATES_PATH . '/principal-header.php';

?>
    <div class="w3-row">
        <?php
        muestraMensajes();
        ?>
        <div class="w3-twothird w3-container">
            <h1 class="w3-text-teal">Creación de una nueva cuenta
            </h1>
            <hr>
        </div>
        <div class="w3-third w3-container">
        </div>
    </div>

    <div class="w3-row">
        <div class="w3-twothird w3-container">
            <form class="w3-container" method="post" action="principal-crea-cuenta-valida-form.php">
                <div class="w3-row-padding w3-padding">
                    <div class="w3-col">
                        <label>Indica un alias o nombre corto para la nueva cuenta</label>
                        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="alias" required placeholder="Ejemplos: Corriente, Ahorros, Negocio...">
                    </div>
                </div>
                <div class="w3-row-padding w3-margin">
                    <button type="submit" name="crea-cuenta" class="w3-button w3-block w3-teal">Crear cuenta</button>
                </div>
            </form>
        </div>
        <div class="w3-third w3-container">
            <div class="w3-card-4">
                <img src="images/Nueva-cuenta.png" class="w3-image w3-round w3-animate-right" alt="Nueva cuenta">
            </div>
        </div>
    </div>

<?php
}
?>