<?php
require_once '../../resources/config.php';
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

  //Salvamos el índice en la sesión
  $_SESSION['indice'] = $indice;

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
                    <button type="submit" name="actualizar" class="w3-button w3-block w3-teal">Actualizar alias</button>
                </div>                
            </form>   
            <div class="w3-container">
                <div class="w3-row-padding w3-margin">
                    <button onclick="document.getElementById('id01').style.display='block'" name="eliminar" class="w3-button w3-block w3-teal">Eliminar cuenta</button>
                </div> 
            </div>
        </div> 
        <div class="w3-third w3-container">
            <div class="w3-card-4">
                <img src="<?=IMAGES_PATH?>/detalle-cuenta.jpg" class="w3-image w3-round w3-animate-right" alt="Detalle cuenta">
            </div>
        </div>
    </div>

    <?php
    }
}
include TEMPLATES_PATH . '/principal-footer.php';
?>

<!-- Ventana modal para confirmar la eliminación de la cuenta -->
<div id="id01" class="w3-modal w3-animate-opacity">
  <div class="w3-modal-content">

    <header class="w3-container w3-black">
      <span onclick="document.getElementById('id01').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <h2>Los datos de la cuenta se borrarán ¿estás seguro?</h2>
    </header>

    <div class="w3-row w3-center w3-padding-16">
        <div class="w3-half">
            <button class="w3-button w3-teal" 
                    onclick="window.location.assign('principal-cuenta-eliminar.php')" 
                    style="text-decoration:none">
                Aceptar
            </button>
        </div>
        <div class="w3-half">
            <button class="w3-button w3-teal" onclick="document.getElementById('id01').style.display='none'">Cancelar</button>
        </div>
    </div>
  </div>
</div>
