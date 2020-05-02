<?php
include_once LIBRARY_PATH . '/maneja-consola.php';

function muestraMensajes($ocultarMsg = true) {
  if (isset($_SESSION['resultado']) && $_SESSION['resultado'] == 'ok') {
    unset($_SESSION['resultado']);
    ?>
    <div id="ok" class="w3-container">
        <div class="w3-card w3-green w3-padding">
            <h1>Datos actualizados correctamente</H1>
        </div>
        <br>
    </div>
    <?php
    if ($ocultarMsg) {
      ?>
      <script>
        function ocultarMsgOk() {
          document.getElementById('ok').style.display = 'none';
        } 
        setInterval(ocultarMsgOk, 5000);
      </script>
    <?php
    } 
  } 
  
  if (isset($_SESSION['resultado']) && $_SESSION['resultado'] == 'error') {
    unset($_SESSION['resultado']);
    ?>
    <div id="errores" class="w3-container">
        <div class="w3-card w3-black w3-padding">
            <h1>¡UOPS!</H1>
            <?php
            echo implode("<br>", $_SESSION['errores']);
            ?>
        </div>
    </div>
    <?php
    if ($ocultarMsg) {
    ?>
      <script>
        function ocultarMsgError(){
          document.getElementById('errores').style.display = 'none';
        } 
        setInterval(ocultarMsgError, 5000);
      </script>
    <?php
    }
  }
}
?>