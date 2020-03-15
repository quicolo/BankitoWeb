<?php
require_once '../resources/config.php';

if(isset($_SESSION['usuario'])) {
    unset($_SESSION['usuario']);
}
session_destroy();

include TEMPLATES_PATH . '/error_404.php';