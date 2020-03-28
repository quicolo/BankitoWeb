<?php
require_once '../resources/config.php';
/*
if (!isset($_SESSION['usuario']) or $_SESSION['usuario'] == null) {
    header('Location: login-form.php');
}
else {
 */   
    include TEMPLATES_PATH . '/principal-header.php';
    include TEMPLATES_PATH . '/principal-sidebar.php';
    include TEMPLATES_PATH . '/principal-contenido.php';
    include TEMPLATES_PATH . '/principal-footer.php';
/*
}
*/