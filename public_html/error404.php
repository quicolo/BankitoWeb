<?php
require_once '../resources/config.php';
require LIBRARY_PATH . '/maneja_sesion.php';

cierraSesionSegura();

include TEMPLATES_PATH . '/error_404.php';