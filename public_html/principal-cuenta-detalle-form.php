<?php
require_once '../resources/config.php';
include LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';
include LIBRARY_PATH . '/maneja-cuenta.php';
include LIBRARY_PATH . '/maneja-mensajes-form.php';

iniciaSesionSegura();

// Validamos la sesión y la entrada del GET
if (!isset($_SESSION['usuario']) or $_SESSION['usuario'] == null or
    !isset($_GET['indice']) or $_GET['indice'] == null or
    !is_numeric($_GET['indice'])) {
  cierraSesionSegura();
  header('Location: login-form.php');
}
else {
  include TEMPLATES_PATH . '/principal-sidebar.php';
  include TEMPLATES_PATH . '/principal-header.php';

  //Rescatamos los datos de cliente y de usuario
  $indice = intval($_GET['indice']);
  $numCuentas = count($_SESSION['cuentas']);

  if ($indice < 0 or $indice >= $numCuentas) {
    $_SESSION['resultado'] = 'error';
    $_SESSION['errores'] = "La cuenta referida no existe";
  }
  else {
    $cuenta = $_SESSION['cuentas'][$indice];
    $cuentaFormateada = formateaCuenta($cuenta['num_entidad'], 
                                        $cuenta['num_sucursal'], 
                                        $cuenta['num_digito_control'], 
                                        $cuenta['num_cuenta']);
    ?>
    <div class="w3-row">
        <?php
            muestraMensajes();
        ?>
        <div class="w3-twothird w3-container">
        <h1 class="w3-text-teal">Detalle de la cuenta <?=$cuenta['alias']?>
        </h1>
        <hr>
        </div>
        <div class="w3-third w3-container">
        </div>
    </div>

    <div class="w3-row">
        <div class="w3-twothird w3-container">
            <form class="w3-container" method="post" action="principal-cuenta-valida-detalle-form.php">
                <input type="text" name="indice" hidden value="<?=$indice?>">
                <div class="w3-row-padding w3-padding">
                    <div class="w3-col m6 l6">
                        <label>Alias de la cuenta</label>
                        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="alias" required value="<?=$cuenta['alias']?>">
                    </div>
                    <div class="w3-col m6 l6">
                        <label>Saldo actual</label>
                        <input class="w3-input w3-border w3-right-align w3-hover-border-black" style="width:100%;" type="text" name="saldo" disabled value="<?=number_format($cuenta['saldo'], 2)?> €">
                    </div>
                </div>
                <div class="w3-row-padding w3-padding">
                    <div class="w3-col m6 l6">
                        <label>Numeración de la cuenta</label>
                        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="numCuenta" disabled value="<?=$cuentaFormateada?>">
                    </div>
                    <div class="w3-col m6 l6">
                        <label>Fecha de creación de la cuenta</label>
                        <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="alias" disabled value="<?=date("d-m-Y", strtotime($cuenta['fecha_creacion']))?>">
                    </div>
                </div>
                <div class="w3-row-padding w3-margin">
                    <button type="submit" name="actualizar" class="w3-button w3-block w3-black w3-hover-teal">Actualizar</button>
                </div>
            </form>    
        </div> 
        <div class="w3-third w3-container">
            <div class="w3-card-4">
                <img src="images/detalle-cuenta.jpg" class="w3-image w3-round w3-animate-right" alt="Foto del cliente">
            </div>
        </div>
    </div>

    <?php
    }
}
?>
