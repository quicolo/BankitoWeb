<?php
require_once '../resources/config.php';
if (!isset($_SESSION['usuario'])) {
    header('Location: iniciarsesion.php');
}
else {
    include TEMPLATES_PATH . '/principal_header.php';
    include TEMPLATES_PATH . '/principal_sidebar.php';
    include TEMPLATES_PATH . '/principal_contenido.php';
}
?>
 <?php 
if (isset($_SESSION['usuario']))
    include TEMPLATES_PATH . '/principal_footer.php';
?>