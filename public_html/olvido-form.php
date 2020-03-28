<?php
require_once '../resources/config.php';
include TEMPLATES_PATH . '/index-header.php';
?>

<!-- Olvido Password -->
<div class="w3-center w3-padding-64" id="olvido">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">Olvidé mi contraseña</span>
</div>

<?php
if (isset($_SESSION['error_registro'])) {
    ?>
    <div class="w3-container">
        <div class="w3-card w3-black w3-padding">
            <h1>¡UOPS!</H1>
            <?php
            echo implode("<br>", $_SESSION['error_registro']);
            ?>
        </div>
    </div>  
    <?php
}
?>
<div class="w3-container">
    <h3>Para recuperar tu contraseña debes rellenar el NIF/NIE y, al menos, uno de los otros dos campos.</h3>
</div>

<form class="w3-container" method="post" action="olvido-valida-form.php" target="_blank">
    <div class="w3-section">
        <label>NIF/NIE (*)</label>
        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="nif" 
                      pattern="[0-9]{8}[A-Z]{1}" title="Formato: 8 dígitos seguidos de una letra mayúscula" required placeholder="Formato 00000000A">
    </div>
    <hr>
    <div class="w3-section">
        <label>Email</label>
        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="email" name="email">
    </div>
    <div class="w3-section w3-center">
    o bien
    </div>
    <div class="w3-section">
        <label>Nombre de usuario</label>
        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="usuario">
    </div>

    <button type="submit" name="enviar" class="w3-button w3-block w3-black">Enviar</button>
</form>


<?php
include TEMPLATES_PATH . '/index-footer.php';
?>