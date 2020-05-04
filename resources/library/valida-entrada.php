<?php

// Esta función limpia la entrada de cualquier formulario de usuario
function saneaEntrada($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Extraído de: https://blog.educacionit.com/2016/12/19/las-expresiones-regulares-mas-usadas-en-php/
// 
// Solo admite nombres que empiecen por letra, le siga de 6 a 22 letras o 
// dígitos (\d) o guiones bajos _ o guión -.
function validaUsuario($nombre) {
    return preg_match("#^[A-Za-z][A-Za-z_\d-]{2,22}$#", $nombre)  == 1;
}

// La expresión debe empezar y acabar utilizando exclusivamente letras
// espacios o guiones.
function validaNomApe($nombre) {
    return preg_match('#^[A-Za-z ÁÉÍÓÚáéíóú-]{1,25}$#', $nombre) == 1;
}

// Obliga al formato blah@blah.blah
function validaEmail($email) {
    return preg_match("#([\w\-]+\@[\w\-]+\.[\w\-]+)#", $email) == 1;
}

// Obliga al formato dd/mm/aaaa
function validaFecha($fecha) {
    $sep = "[\/\-\.]";
    $reg = "#^(((0?[1-9]|1\d|2[0-8]){$sep}(0?[1-9]|1[012])|(29|30){$sep}(0?[13456789]|1[012])|31{$sep}(0?[13578]|1[02])){$sep}(19|[2-9]\d)\d{2}|29{$sep}0?2{$sep}((19|[2-9]\d)(0[48]|[2468][048]|[13579][26])|(([2468][048]|[3579][26])00)))$#";
    return preg_match($reg, $fecha) == 1;
}

// Obliga al formato 190.210.132.55 donde cada octeto debe estar entre 0 y 255
function validaIP($ip) {
    $val_0_to_255 = "(25[012345]|2[01234]\d|[01]?\d\d?)";
    $reg = "#^($val_0_to_255\.$val_0_to_255\.$val_0_to_255\.$val_0_to_255)$#";
    return preg_match($reg, $ip, $matches) == 1;
}

// Obliga al formato (11)-4328-0457
function validaTelefono($numero) {
    $reg = "#^\(?\d{2}\)?[\s\.-]?\d{4}[\s\.-]?\d{4}$#";
    return preg_match($reg, $numero) == 1;
}

function validaNif($nif) {
    $letra = substr($nif, -1);
    $numeros = substr($nif, 0, -1);
    if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros % 23, 1) == $letra && strlen($letra) == 1 && strlen($numeros) == 8) {
        return true;
    } else {
        return false;
    }
}

function validaImporte($importe) {
    $reg = "#([0-9]{1,8})|([0-9]{1,8}\.[0-9]{2})#";
    return preg_match($reg, $importe) == 1;
}

function validaFormatoCuenta($cadena) {
    $reg = "#[0-9]{4}\-[0-9]{4}\-[0-9]{2}\-[0-9]{10}#";
    return preg_match($reg, $cadena) == 1;
}

// Se exige que la clave tiene al menos 6 caracteres
// Que el password tiene como máximo 16 caracteres
// Que tiene al menos 1 letra minúscula
// Que al menos tiene 1 letra mayúscula
// Que tiene al menos un carácter numérico
function validaPassword($password) {
    return errorPassword($password) === "";
}

function errorPassword($clave) {
    if (strlen($clave) < 6 || strlen($clave) > 16) {
        $error_clave[] = "La clave debe tener entre 6 y 16 caracteres";
    }
    if (!(preg_match('#[a-z]#', $clave) == 1)) {
        $error_clave[] = "La clave debe tener al menos una letra minúscula";
    }
    if (!(preg_match('#[A-Z]#', $clave) == 1)) {
        $error_clave[] = "La clave debe tener al menos una letra mayúscula";
    }
    if (!(preg_match('#[0-9]#', $clave) == 1)) {
        $error_clave[] = "La clave debe tener al menos un caracter numérico";
    }
    if (isset($error_clave))
        return implode("<br>", $error_clave);
    else
        return "";
}
