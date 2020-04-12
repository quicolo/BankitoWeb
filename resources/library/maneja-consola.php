<?php
function imprimePorConsola( $data ){
  if (defined("LOG_CONSOLA") and LOG_CONSOLA=="ON") {
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }
}