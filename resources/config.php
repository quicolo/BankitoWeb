<?php
include 'entorno.php';

define("PROTOCOLO", "http");

// Constantes rutas en disco duro
define("APACHE_ROOT_PATH", $_SERVER['DOCUMENT_ROOT']);
define("ALIAS_FOLDER", "/bankitoweb");
define("APP_ROOT_PATH", APACHE_ROOT_PATH .ALIAS_FOLDER);

define("RESOURCES_PATH", APP_ROOT_PATH . '/resources');
define("LIBRARY_PATH", RESOURCES_PATH . '/library');
define("TEMPLATES_PATH", RESOURCES_PATH . '/templates');
define("IMAGES_PATH", ALIAS_FOLDER . '/images');

define("PUBLIC_HTML_PATH", ALIAS_FOLDER);
define("POS_GLOBAL_PATH", ALIAS_FOLDER);
define("CUENTAS_PATH", ALIAS_FOLDER.'/cuenta');
define("OPERACIONES_PATH", ALIAS_FOLDER.'/operacion');
define("MI_PERFIL_PATH", ALIAS_FOLDER.'/perfil');

define("VENDOR_PATH", APP_ROOT_PATH . '/vendor');

// Constantes de comportamiento de la aplicación
define("COD_ENTIDAD", 101);
define("COD_SUCURSAL", 202);
define("MINUTOS_CADUCA_TOKEN", 30);
define("MINUTOS_CADUCA_SESION", 30);
define("NUM_MAX_CUENTAS_POR_USUARIO", 3);

// Configuración del intérprete de PHP según en nivel de errores
if (ERROR_LEVEL == "DEPURACION") {
    ini_set("error_reporting", "true");
    error_reporting(E_ALL | E_STRICT);
} else { //Producción u otro caso no especificado (el más escricto)
    ini_set("error_reporting", "false");
}

$dbName = "";
$username = "";
$password = "";
$host = "";

if (ENTORNO == "DESARROLLO") {
    $dbName = "bankito";
    $userName = "bankitoadmin";
    $password = "admin";
    $host = "localhost";
} else if (ENTORNO == "PRODUCCION") {
    $dbName = "bankito";
    $userName = "kike";
    $password = "Pavjclob.101";
    $host = "localhost";
}

define("BASE_URL", PROTOCOLO . '://' . $host . '/' . ALIAS_FOLDER . '/');

$dbConexion = mysqli_connect($host, $userName, $password, $dbName);
mysqli_query($dbConexion, "SET NAMES 'utf8'");

?>