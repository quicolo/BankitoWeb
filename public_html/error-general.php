<?php
require_once '../resources/config.php';
include TEMPLATES_PATH . '/index-header.php';
require LIBRARY_PATH . '/maneja-sesion.php';
?>
<h2>Houston, tenemos un problema...</h2>
<h1 class="w3-center w3-card w3-black">
    <?php 
        echo $_SESSION['error'] ?? "ERROR INDEFINIDO";
        echo $_SESSION['errores'] ?? "ERROR INDEFINIDO";
        cierraSesionSegura();
    ?>
</H1>
<?php
include TEMPLATES_PATH . '/index-footer.php';
?>