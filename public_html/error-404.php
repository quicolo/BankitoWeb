<?php
require_once '../resources/config.php';
require LIBRARY_PATH . '/maneja-sesion.php';

cierraSesionSegura();

include TEMPLATES_PATH . '/error-404.php';