<?php
require_once '../resources/config.php';
include TEMPLATES_PATH . '/index-header.php';
include LIBRARY_PATH . '/maneja-sesion.php';

iniciaSesionSegura();
?>

<!-- Registro OK -->
<div class="w3-center w3-padding-64" id="registro">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">Ya casi hemos terminado</span>
</div>

<h3 class="w3-center w3-card w3-green"><b>Te hemos enviado un correo electrónico para que puedas restaurar tu contraseña. </b><br>
    Para ello sigue las instrucciones del mensaje que recibirás en unos instantes. <br>Muchas Gracias.</H3>

<?php
include TEMPLATES_PATH . '/index-footer.php';
?>