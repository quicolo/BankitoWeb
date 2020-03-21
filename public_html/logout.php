<?php
require_once '../resources/config.php';
require LIBRARY_PATH . '/maneja_sesion.php';

cierraSesionSegura();

header('Location: index.php');