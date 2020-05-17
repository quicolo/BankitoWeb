<?php
require_once '../resources/config.php';
require LIBRARY_PATH . '/maneja-sesion.php';

cierraSesionSegura();

header('Location: '.PUBLIC_HTML_PATH.'/index.php');