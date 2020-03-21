<?php

define("PROTOCOLO", "http");

// Constantes rutas en disco duro
define("APACHE_ROOT_PATH", $_SERVER['DOCUMENT_ROOT']);
define("APP_FOLDER", "bankito");
define("APP_ROOT_PATH", APACHE_ROOT_PATH . '/' . APP_FOLDER);

define("RESOURCES_PATH", APP_ROOT_PATH . '/resources');
define("LIBRARY_PATH", RESOURCES_PATH . '/library');
define("TEMPLATES_PATH", RESOURCES_PATH . '/templates');

define("VENDOR_PATH", APP_ROOT_PATH . '/vendor');



// Constantes de entorno
define("ENTORNO", "desarrollo"); // define("ENTORNO", "produccion");
// Configuración del intérprete de PHP
if (ENTORNO == "desarrollo") {
    ini_set("error_reporting", "true");
    error_reporting(E_ALL | E_STRICT);
} else { //Producción u otro caso no especificado (el más escricto)
    ini_set("error_reporting", "false");
}

// Variables para la construcción del array config
$dbName = "";
$username = "";
$password = "";
$host = "";

if (ENTORNO == "desarrollo") {
    $dbName = "bankito";
    $userName = "bankitoadmin";
    $password = "admin";
    $host = "localhost";
} else if (ENTORNO == "produccion") {
    $dbName = "bankito";
    $userName = "kike";
    $password = "Pavjclob.101";
    $host = "217.112.92.116";
}

define("BASE_URL", PROTOCOLO . '://' . $host . '/' . APP_FOLDER . '/');

$dbConexion = mysqli_connect($host, $userName, $password, $dbName);
mysqli_query($dbConexion, "SET NAMES 'utf8'");

// Iniciar la sesión
session_start();
?>