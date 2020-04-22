<?php
require_once '../resources/config.php';
include LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';

iniciaSesionSegura();

if (!isset($_SESSION['usuario']) or $_SESSION['usuario'] == null) {
    cierraSesionSegura();
    header('Location: login-form.php');
}
else {
    include TEMPLATES_PATH . '/principal-sidebar.php';
    include TEMPLATES_PATH . '/principal-header.php';
    

    //Rescatamos los datos de cliente y de usuario
    $nomUsuario = $_SESSION['usuario']['nombre'];
    $nomCliente = $_SESSION['cliente']['nombre'];
    $apellido1 = $_SESSION['cliente']['apellido1'];
    $apellido2 = $_SESSION['cliente']['apellido2'];
    $nif = $_SESSION['cliente']['nif'];
    $direccion = $_SESSION['cliente']['direccion_completa'];
    $email = $_SESSION['cliente']['email'];
    $fechaAlta = $_SESSION['cliente']['fecha_creacion'];
?>




  <!-- Fila con los datos del cliente y la imagen -->
  <div class="w3-row">
    <?php
    if (isset($_SESSION['actualiza_ok'])) {
        unset($_SESSION['actualiza_ok']);
        ?>
        <div class="w3-container">
            <div class="w3-card w3-green w3-padding">
                <h1>Datos actualizados correctamente</H1>
            </div>
            <br>
        </div>  
        <?php
    }
    ?>

    <?php
    if (isset($_SESSION['errores'])) {
        ?>
        <div class="w3-container">
            <div class="w3-card w3-black w3-padding">
                <h1>¡UOPS!</H1>
                <?php
                echo implode("<br>", $_SESSION['errores']);
                unset($_SESSION['errores']);
                ?>
            </div>
        </div>  
        <?php
    }
    ?>
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-teal">Mi perfil
      </h1>
      <hr>
    </div>
    <div class="w3-third w3-container">
    </div>
  </div>
  <div class="w3-row">
    <div class="w3-twothird w3-container">
      <form class="w3-container" method="post" action="principal-mi-perfil-valida-cliente-form.php">
        <div class="w3-row-padding w3-padding">
          <div class="w3-col m6 l6">
              <label>Nombre</label>
              <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="nombre" disabled value="<?= $nomCliente ?>">
          </div>
          <div class="w3-col m6 l6">
              <label>Primer apellido</label>
              <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="apellido1" disabled value="<?= $apellido1 ?>" >
          </div>
        </div>
        <div class="w3-row-padding w3-padding">
         <div class="w3-col m6 l6">
            <label>Segundo apellido</label>
            <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="apellido2" disabled value="<?= $apellido2 ?>" >
          </div>
          <div class="w3-col m6 l6">
            <label>Fecha de alta</label>
            <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" disabled name="fecha" value="<?= date("d-m-Y", strtotime($fechaAlta)) ?>"> 
          </div>
        </div>
        <div class="w3-row-padding w3-padding">
          <div class="w3-col m6 l6">
            <label>NIF/NIE</label>
            <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="nif" disabled value="<?= $nif ?>" >
          </div>
          <div class="w3-col m6 l6">
            <label>Nombre de usuario</label>
            <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="usuario" disabled value="<?= $nomUsuario ?>">
          </div>
        </div>
        <div class="w3-row-padding w3-padding">
          <div class="w3-col m6 l6">
            <label>Email</label>
            <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="email" name="email" required value="<?= $email ?>" >
          </div>
          <div class="w3-col m6 l6">
            <label>Dirección postal</label>
            <input class="w3-input w3-border w3-hover-border-black" style="width:100%;" type="text" name="direccion" value="<?= $direccion ?>">
          </div>
        </div>
        <div class="w3-row-padding w3-margin">
          <button type="submit" name="actualizar" class="w3-button w3-block w3-black w3-hover-teal">Actualizar</button>
        </div>
      </form>
    </div>
    <div class="w3-third w3-container">
      <div class="w3-card-4">
        <img src="images/img_avatar4.png" class="w3-image w3-round w3-animate-right" alt="Foto del cliente">
      </div>
    </div>
  </div>
<?php
    include TEMPLATES_PATH . '/principal-footer.php';
}
?>
