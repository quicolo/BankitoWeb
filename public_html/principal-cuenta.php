<?php
require_once '../resources/config.php';
include LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';
include LIBRARY_PATH . '/maneja-cuenta.php';

function muestraCuenta($cuenta, $indice)
{
?>
  <div class="w3-card w3-hover-shadow w3-margin w3-animate-zoom">
    <div class="w3-display-container w3-text-white">
      <!-- Tamaño de la imagen 730x120 -->
      <img src="images/Banner-cuenta-<?= $indice ?>.png" style="width:100%">
      <div class="w3-display-topleft w3-padding">
        <h4>Cuenta <?= $cuenta['alias'] ?></h4>
        <p>Saldo: <?= number_format($cuenta['saldo'], 2) ?> euros</p>
      </div>
    </div>

    <div class="w3-row w3-teal">
      <div class="w3-half w3-center">
        <button class="w3-button w3-teal w3-block" 
                onclick="window.location.assign('principal-cuenta-detalle-form.php?indice=<?= $indice ?>')" 
                style="text-decoration:none">
          Detalles/Modificar/Eliminar
        </button>
      </div>
      <div class="w3-half w3-center">
        <button class="w3-button w3-teal w3-block" 
                onclick="window.location.assign('principal-cuenta-movim.php?indice=<?= $indice ?>')" 
                style="text-decoration:none">
                Ver movimientos
        </button>
      </div>
    </div>
  </div>
<?php
}


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
      <h1 class="w3-text-teal">Mis cuentas
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
          muestraCuenta($cuenta, $indice);
          $indice++;
        }
      } else {
        ?>
        <div class="w3-container">
          <h3>Todavía no has creado ninguna cuenta. 
              Puedes crear un máximo de <?=NUM_MAX_CUENTAS_POR_USUARIO?> cuentas.</h3>
        </div>
        <?php
      }


      // Si no ha llegado al máximo de cuentas, pinta el botón de nueva cuenta
      if ($numCuentasActual < NUM_MAX_CUENTAS_POR_USUARIO) {
      ?>
        <div class="w3-container">

          <button class="w3-button w3-teal w3-block" 
                onclick="window.location.assign('principal-crea-cuenta-form.php')" 
                style="text-decoration:none">
                Nueva cuenta
        </button>
        </div>
      <?php
      }
      ?>
    </div>
    <div class="w3-third w3-container">
      <div class="w3-card-4">
        <img src="images/cuentas-lateral.png" class="w3-image w3-round w3-animate-right" alt="Foto del cliente">
      </div>
    </div>
  </div>


<?php
  include TEMPLATES_PATH . '/principal-footer.php';
}
?>