<?php
require_once '../resources/config.php';

// Borramos el contenido de la sesión por seguridad
if (!isset($_SESSION['errorCambiaPass'])) {
    session_unset();
}

if (!isset($_GET['token'])) {
    $_SESSION['error'] = "URL mal formada";
    header('Location: error-general.php');
}
else {
    // Desinfecta el token recibido
    $_SESSION['token'] = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_SPECIAL_CHARS);

    include TEMPLATES_PATH . '/index-header.php';

    if (isset($_SESSION['errorCambiaPass'])) {
?>
        <div class="w3-container">
            <div class="w3-card w3-black w3-padding">
                <h1>¡UOPS!</H1>
                <?php
                    echo $_SESSION['errorCambiaPass'];
                ?>
            </div>
        </div>  
        <?php
    }
    ?>

    <!-- Olvido Password -->
    <div class="w3-center w3-padding-64" id="olvido">
        <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">Restablece tu contraseña</span>
    </div>

    <div class="w3-container">
        <h3>Te recordamos que es tu responsabilidad utilizar una contraseña robusta.</h3>
    </div>

    <form class="w3-container" method="post" action="olvido-valida-cambia-pass-form.php" target="_blank">
        <div class="w3-section">
            <label>Nueva contraseña (*)</label>
            <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="password" required name="password1">
        </div>
        <div class="w3-section">
            <label>Repite la nueva contraseña (*)</label>
            <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="password" required name="password2">
        </div>

        <button type="submit" name="enviar" class="w3-button w3-block w3-black">Enviar</button>
    </form>

<?php
    unset($_SESSION['errorCambiaPass']);
    include TEMPLATES_PATH . '/index-footer.php';
} 
?>



