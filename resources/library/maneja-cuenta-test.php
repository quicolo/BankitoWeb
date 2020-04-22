<?php
// require_once '../resources/config.php';
include_once LIBRARY_PATH . '/maneja-cuenta.php';

$array = generaSiguienteNumCuenta($dbConexion, 101, 202);
var_dump($array);