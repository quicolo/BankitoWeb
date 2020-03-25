<?php
function cargaFichero($fichero) {
    $manejador = fopen($fichero, "r");
    $contenido = fread($manejador, filesize($fichero));
    fclose($manejador);
    return $contenido ?? "No se pudo abrir la plantilla de correo";
}