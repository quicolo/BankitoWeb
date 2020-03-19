<?php
require_once '../resources/config.php';
include TEMPLATES_PATH . '/index_header.php';
?>

<!-- Registro -->
<div class="w3-center w3-padding-64" id="registro">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">Regístrate en Bankito</span>
</div>


<?php
$nombre = "";
$apellido1 = "";
$apellido2 = "";
$dni = "";
$email = "";
$usuario = "";

if (isset($_SESSION['error_registro'])) {
    ?>
    <div class="w3-container">
        <div class="w3-card w3-black w3-padding">
            <h1>¡UOPS!</H1>
            <?php
            echo implode("<br>", $_SESSION['error_registro']);
            $nombre = $_SESSION['nombre'];
            $apellido1 = $_SESSION['apellido1'];
            $apellido2 = $_SESSION['apellido2'];
            $dni = $_SESSION['dni'];
            $email = $_SESSION['email'];
            $usuario = $_SESSION['usuario'];
            ?>
        </div>
    </div>  
    <?php
}
?>


<form class="w3-container" method="post" action="registrar.php" target="_blank">
    <div class="w3-section">
        <label>Nombre</label>
        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="nombre" required value="<?= $nombre ?>">
    </div>
    <div class="w3-section">
        <label>Primer apellido</label>
        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="apellido1" required value="<?= $apellido1 ?>" >
    </div>
    <div class="w3-section">
        <label>Segundo apellido</label>
        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="apellido2" value="<?= $apellido2 ?>" >
    </div>
    <div class="w3-section">
        <label>DNI</label>
        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="dni" placeholder="Formato 00000000A" value="<?= $dni ?>" required>
    </div>
    <div class="w3-section">
        <label>Email</label>
        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="email" name="email" value="<?= $email ?>" required>
    </div>
    <div class="w3-section">
        <label>Nombre de usuario</label>
        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="usuario" value="<?= $usuario ?>" required>
    </div>
    <div class="w3-section">
        <label>Contraseña</label>
        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="password" name="password" required>
    </div>
    <button type="submit" name="enviar" class="w3-button w3-block w3-black">Enviar</button>
</form>

<?php
if (isset($_SESSION['error_registro'])) {
    unset($_SESSION['error_registro']);
    unset($_SESSION['nombre']);
    unset($_SESSION['apellido1']);
    unset($_SESSION['apellido2']);
    unset($_SESSION['dni']);
    unset($_SESSION['email']);
    unset($_SESSION['usuario']);
}
?>

<?php
include TEMPLATES_PATH . '/index_footer.php';
?>