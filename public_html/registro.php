<?php
require_once '../resources/config.php';
include TEMPLATES_PATH . '/index_header.php';
?>

<!-- Registro -->
<div class="w3-center w3-padding-64" id="registro">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">Regístrate en Bankito</span>
</div>

<?php
if (isset($_SESSION['error_registro']))
    echo implode("<br>", $_SESSION['error_registro']);
else
    echo 'No hay errores<br>';
?>

<form class="w3-container" method="post" action="registrar.php" target="_blank">
    <div class="w3-section">
        <label>Nombre</label>
        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="nombre" required>
    </div>
    <div class="w3-section">
        <label>Primer apellido</label>
        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="apellido1" required>
    </div>
    <div class="w3-section">
        <label>Segundo apellido</label>
        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="apellido2">
    </div>
    <div class="w3-section">
        <label>Email</label>
        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="email" name="email" required>
    </div>
    <div class="w3-section">
        <label>Nombre de usuario</label>
        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="usuario" required>
    </div>
    <div class="w3-section">
        <label>Contraseña</label>
        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="password" name="password" required>
    </div>
    <button type="submit" name="enviar" class="w3-button w3-block w3-black">Enviar</button>
</form>


<?php
include TEMPLATES_PATH . '/index_footer.php';
?>