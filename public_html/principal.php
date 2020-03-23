<?php
require_once '../resources/config.php';
if (!isset($_SESSION['usuario'])) {
    header('Location: iniciar-sesion.php');
}
else {
    include TEMPLATES_PATH . '/principal-header.php';
    include TEMPLATES_PATH . '/principal-sidebar.php';
    include TEMPLATES_PATH . '/principal-contenido.php';
}
?>
 <?php 
if (isset($_SESSION['usuario']))
    include TEMPLATES_PATH . '/principal-footer.php';
?>