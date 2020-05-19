<?php
require_once '../../resources/config.php';
include LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';
include LIBRARY_PATH . '/maneja-cuenta.php';


iniciaSesionSegura();

if (!isset($_SESSION['usuario']) or $_SESSION['usuario'] == null) {
  cierraSesionSegura();
  header('Location: login-form.php');
} else {
  include TEMPLATES_PATH . '/principal-sidebar.php';
  include TEMPLATES_PATH . '/principal-header.php';

  //Rescatamos los datos de cliente y de usuario
  $idUsuario = $_SESSION['usuario']['id_usuario'];
  $result = buscaCuentasPorIdUsuario($dbConexion, $idUsuario);
?>
  <div class="w3-row">
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-teal">Operaciones
      </h1>
      <hr>
    </div>
    <div class="w3-third w3-container">
    </div>
  </div>

  <div class="w3-row">
    <div class="w3-twothird w3-container">
      <?php
      $numCuentasActual = 0;
      if ($result && mysqli_num_rows($result) > 0) {
        $indice = 0;
        $numCuentasActual = mysqli_num_rows($result);
        while ($cuenta = mysqli_fetch_assoc($result)) {
          $_SESSION['cuentas'][$indice] = $cuenta;
          muestraCuentaOperac($cuenta, $indice);
          $indice++;
        }
      } else {
      ?>
        <div class="w3-container">
          <h3>Todavía no has creado ninguna cuenta. Necesitas una cuenta para poder realizar operaciones. </h3>
        </div>
      <?php
      }

      ?>
    </div>
    <div class="w3-third w3-container">
      <div class="w3-card-4">
        <img src="<?= IMAGES_PATH ?>/operaciones.jpg" class="w3-image w3-round w3-animate-right" alt="Operaciones">
      </div>
    </div>
  </div>


<?php
  include TEMPLATES_PATH . '/principal-footer.php';
}

function muestraCuentaOperac($cuenta, $indice)
{
?>
  <div class="w3-card w3-hover-shadow w3-margin w3-animate-zoom">
    <div class="w3-display-container w3-text-white">
      <!-- Tamaño de la imagen 730x120 -->
      <img src="<?= IMAGES_PATH ?>/Banner-cuenta-<?= $indice ?>.png" style="width:100%">
      <div class="w3-display-left w3-padding">
        <h4 style="text-shadow:1px 1px 0 #444">Cuenta <?= $cuenta['alias'] ?>: <?= number_format($cuenta['saldo'], 2) ?> €</h4>
      </div>
    </div>

    <div class="w3-row w3-teal">
      <div class="w3-col m4 l4 w3-center">
        <button class="w3-button w3-teal w3-block" onclick="window.location.assign('principal-opera-ingresa-form.php?indice=<?= $indice ?>')" style="text-decoration:none">
          Ingresar
        </button>
      </div>
      <div class="w3-col m4 l4 w3-center">
        <button class="w3-button w3-teal w3-block" onclick="window.location.assign('principal-opera-retira-form.php?indice=<?= $indice ?>')" style="text-decoration:none">
          Retirar/Pagar
        </button>
      </div>
      <div class="w3-col m4 l4 w3-center">
        <button class="w3-button w3-teal w3-block" onclick="window.location.assign('principal-opera-transfe-form.php?indice=<?= $indice ?>')" style="text-decoration:none">
          Transferir
        </button>
      </div>
    </div>
  </div>
<?php
}
