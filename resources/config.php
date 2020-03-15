<?php

if (!defined("INICIALIZADO")) {

    // Constantes 
    define("INICIALIZADO", true);
    
    define("RESOURCES_PATH", realpath(dirname(__FILE__)));
    define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));
    define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));
    
    define("ENTORNO", "desarrollo");
    // defined("ENTORNO") or define("ENTORNO", "produccion");
    
    // Configuración del intérprete de PHP
    if (ENTORNO == "desarrollo") {
        ini_set("error_reporting", "true");
        error_reporting(E_ALL | E_STRCT);
    } else { //Producción u otro caso no especificado (el más escricto)
        ini_set("error_reporting", "false");
    }

    // Variables para la construcción del array config
    $_dbname = "";
    $_username = "";
    $_password = "";
    $_host = "";

    if (ENTORNO == "desarrollo") {
        $_dbname = "bankito";
        $_username = "bankitoadmin";
        $_password = "admin";
        $_host = "localhost";
    } else if (ENTORNO == "produccion") {
        $_dbname = "bankito";
        $_username = "kike";
        $_password = "Pavjclob.101";
        $_host = "217.112.92.116";
    }


    $config = array(
        "db" => array(
            "dbname" => $_dbname,
            "username" => $_username,
            "password" => $_password,
            "host" => $_host
        ),
        "urls" => array(
            "baseUrl" => "http://bankito.com"
        ),
        "paths" => array(
            "resources" => $_SERVER["DOCUMENT_ROOT"] . "/resources",
            "images" => $_SERVER["DOCUMENT_ROOT"] . "/public_html/images"
        )
    );

    $dbConexion = mysqli_connect($config['db']['host'], $config['db']['username'], 
                                 $config['db']['password'], $config['db']['dbname']);
    mysqli_query($dbConexion, "SET NAMES 'utf8'");

    // Iniciar la sesión
    session_start();

}
?>