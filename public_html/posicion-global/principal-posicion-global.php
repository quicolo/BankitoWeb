<?php
require_once '../../resources/config.php';
include LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';

iniciaSesionSegura();

if (!isset($_SESSION['usuario']) or $_SESSION['usuario'] == null) {
  header('Location: login-form.php');
} else {
  // Para que el header tenga el nombre de cliente para mostrarlo
  $resultCliente = buscaClientePorIdUsuario($dbConexion, $_SESSION['usuario']['id_usuario']);
  if ($resultCliente && mysqli_num_rows($resultCliente) == 1) {
    $_SESSION['cliente'] = mysqli_fetch_assoc($resultCliente);

    include TEMPLATES_PATH . '/principal-sidebar.php';
    include TEMPLATES_PATH . '/principal-header.php';
    $numCuentas = 0;
    $saldoTotal = 0;
    $numOper = 0;
    $ingresosTotal = 0;
    $gastosTotal = 0;
    $resultado = buscaCuentasPorIdUsuario($dbConexion, $_SESSION['usuario']['id_usuario']);
    if ($resultado and mysqli_num_rows($resultado) > 0) {
      while ($cuenta = mysqli_fetch_assoc($resultado)) {
        $numCuentas++;
        $saldoTotal += $cuenta['saldo'];
        $resMovim = buscaMovimientosPorIdCuenta($dbConexion, $cuenta['id_cuenta']);
        if ($resMovim and mysqli_num_rows($resMovim) > 0) {
          while ($movim = mysqli_fetch_assoc($resMovim)) {
            $numOper++;
            $resTipoMov = buscaTipoMovimientoPorIdTipoMovim($dbConexion, $movim['id_tipo_movimiento']);
            if ($resTipoMov and mysqli_num_rows($resTipoMov) == 1) {
              $tipoMovim = mysqli_fetch_assoc($resTipoMov);
              if ($tipoMovim['direccion'] == 'Entrada') {
                $ingresosTotal += $movim['importe'];
              } else {
                $gastosTotal += $movim['importe'];
              }
            }
          }
        }
      }
    }
  } else {
    header('Location: ' . PUBLIC_HTML_PATH . '/login-form.php');
  }
?>

  <div class="w3-row">
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-teal">Posición global
      </h1>
      <hr>
    </div>
    <div class="w3-third w3-container">
    </div>
  </div>

  <div class="w3-row">
    <div class="w3-twothird w3-container">
      <div class="w3-content w3-animate-zoom w3-card-4" style="max-width:400px">
        <div class="w3-cell">
          <div class="w3-display-container w3-text-white w3-hover-black" style="height:200px;width:200px;background-color:#7D16E9">
            <div class="w3-display-middle w3-center" style="text-shadow:1px 1px 0 #444">Tienes <div class="w3-jumbo"><?= $numCuentas ?></div> cuentas</div>
          </div>
        </div>
        <div class="w3-cell">
          <div class="w3-display-container w3-text-white w3-hover-black" style="height:200px;width:200px;background-color:#E91619">
            <div class="w3-display-middle w3-center" style="text-shadow:1px 1px 0 #444">El saldo en tus cuentas es <div class="w3-xlarge"><?= number_format($saldoTotal, 2) ?>€</div>
            </div>
          </div>
        </div>
      </div>
      <div class="w3-content w3-animate-zoom w3-card-4" style="max-width:400px">
        <div class="w3-cell">
          <div class="w3-display-container w3-text-white w3-hover-black" style="height:200px;width:200px;background-color:#82E916">
            <div class="w3-display-middle w3-center" style="text-shadow:1px 1px 0 #444">Ingresos <div class="w3-xlarge"><?= number_format($ingresosTotal, 2) ?>€</div>
              <div class="w3-xxlarge">VS</div>
              <div class="w3-xlarge"><?= number_format($gastosTotal, 2) ?>€</div>Gastos
            </div>
          </div>
        </div>
        <div class="w3-cell">
          <div class="w3-display-container w3-text-white w3-hover-black" style="height:200px;width:200px;background-color:#16E9E6">
            <div class="w3-display-middle w3-center" style="text-shadow:1px 1px 0 #444">Has realizado un total de <div class="w3-jumbo"><?= $numOper ?></div> operaciones</div>
          </div>
        </div>

      </div>
    </div>
    <div class="w3-third w3-container">
      <div class="w3-card-4">
        <img src="<?= IMAGES_PATH ?>/thumb3.jpg" class="w3-image w3-round w3-animate-right" alt="Foto del cliente">
      </div>
    </div>
  </div>


<?php
  include TEMPLATES_PATH . '/principal-footer.php';
}
?>