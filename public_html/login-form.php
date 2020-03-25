<?php
require_once '../resources/config.php';
include TEMPLATES_PATH . '/index-header.php';
?>

<!-- Inicia Sesión -->
<div class="w3-center w3-padding-64" id="registro">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">Inicia sesión en Bankito</span>
</div>

<!-- Ventana Login Emergente -->
<div id="loginEmergente" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:400px">

        <div class="w3-center"><br>
            <span onclick="document.getElementById('loginEmergente').style.display = 'none'" class="w3-button w3-xlarge w3-transparent w3-display-topright" title="Cerrar">×</span>
            <img src="images/img_avatar4.png" alt="Avatar" style="width:30%" class="w3-circle w3-margin-top">
        </div>

        <form class="w3-container" method="post" action="login-valida-form.php">
            <div class="w3-section">
                <?php if (isset($_SESSION['error_login'])) { ?>
                    <script>
                        document.getElementById('loginEmergente').style.display = 'block';
                    </script>
                    <h3>
                    <?php
                        echo $_SESSION['error_login'];
                        unset($_SESSION['error_login']);
                    }
                    ?>
                </h3>
                <label><b>Usuario</b></label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Nombre de usuario" name="usuario" required>
                <label><b>Contraseña</b></label>
                <input class="w3-input w3-border" type="password" placeholder="Contraseña" name="password" required>
                <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">Login</button>
            </div>
        </form>

        <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
            <a href="registro-form.php" class="w3-button w3-blue">No tengo usuario</a>
            <a href="olvido-form.php" class="w3-button w3-right w3-red">Olvidé mi contraseña</a>
        </div>

    </div>
</div>

<script>
document.getElementById('loginEmergente').style.display = 'block';
</script>

<?php
if (isset($_SESSION['error_login'])) {
    ?>
    <script>
        document.getElementById('loginEmergente').style.display = 'block';
    </script>
<?php } 
include TEMPLATES_PATH . '/index-footer.php';
?>    