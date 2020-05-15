<?php
include_once LIBRARY_PATH . '/maneja-consola.php';

function muestraMensajes($ocultarMsg = true)
{
  muestraMensajesDefineMensajeOK("Los datos se actualizaron correctamente", $ocultarMsg);
}

function muestraMensajesOperacion($ocultarMsg = true)
{
  muestraMensajesDefineMensajeOK("La operación se realizó correctamente", $ocultarMsg);
}

function muestraMensajesDefineMensajeOK($mensajeOK, $ocultarMsg = true)
{
  if (isset($_SESSION['resultado']) && $_SESSION['resultado'] == 'ok') {
    unset($_SESSION['resultado']);
?>
    <div id="ok" class="w3-container">
      <div class="w3-card w3-padding w3-theme-l5">
        <div class="w3-cell w3-cell-middle" style="width:80px">
          <img src="<?= IMAGES_PATH ?>/tick-ok.png" class="w3-image w3-animate-zoom w3-border w3-round-large w3-border-white" style="height:100%; max-height:60px">
        </div>
        <div class="w3-cell">
            <h3><?= $mensajeOK ?></H3>
        </div>
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
      <div class="w3-card w3-padding w3-theme-l5">
        <div class="w3-cell w3-cell-middle" style="width:80px">
          <img src="<?= IMAGES_PATH ?>/cross-wrong.png" class="w3-image w3-animate-zoom w3-border w3-round-large w3-border-white" style="height:100%;max-height:60px">
        </div>
        <div class="w3-cell">
          <h3>¡OUPS!</H3>
          <?php
          echo implode("<br>", $_SESSION['errores']);
          ?>
        </div>

      </div>
    </div>
    <?php
    if ($ocultarMsg) {
    ?>
      <script>
        function ocultarMsgError() {
          document.getElementById('errores').style.display = 'none';
        }
        setInterval(ocultarMsgError, 5000);
      </script>
<?php
    }
  }
}
?>