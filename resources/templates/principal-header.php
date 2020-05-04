<!DOCTYPE html>
<html lang="en">
<title>Bankito - Invierte en tu futuro</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<script src="https://kit.fontawesome.com/4358b9453c.js" crossorigin="anonymous"></script>
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
.w3-sidebar {
  z-index: 3;
  width: 250px;
  top: 43px;
  bottom: 0;
  height: inherit;
}
</style>
<body>
<!-- Navbar -->
<div class="w3-top">
  <div class="w3-mobile w3-theme w3-top w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-left w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    <a href="logout.php" class="w3-bar-item w3-button w3-right w3-hover-teal w3-theme-l1"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
    <a href="principal-posicion-global.php" class="w3-bar-item w3-button w3-hide-small w3-hover-teal"><i class="fas fa-chart-line"></i> Bienvenid@ a Bankito<?=", ".$_SESSION['cliente']['nombre']?? ""; ?></a>
    <!--
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Values</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hover-white">News</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Contact</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hide-medium w3-hover-white">Clients</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hide-medium w3-hover-white">Partners</a>-->
  </div>
</div>

<!-- Contenedor principal, se cierra en el footer -->
<div class="w3-main" style="margin-left:250px; margin-top:64px">