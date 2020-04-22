<!-- Sidebar -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-teal w3-hide-large" title="Close Menu">
    <i class="fa fa-remove"></i>
  </a>
  <h4 class="w3-bar-item"><b>Menu</b></h4>
  <a class="w3-bar-item w3-button w3-hover-teal" href="principal-posicion-global.php"><i class="fas fa-university fa-fw"></i> Posición global</a>
  <a class="w3-bar-item w3-button w3-hover-teal" href="principal-cuenta.php"><i class="fas fa-money-check fa-fw"></i> Cuentas</a>
  <a class="w3-bar-item w3-button w3-hover-teal" href="#"><i class="fas fa-wave-square fa-fw"></i> Movimientos</a>
  <a class="w3-bar-item w3-button w3-hover-teal" href="#"><i class="fas fa-tasks fa-fw"></i> Operaciones</a>
  <a class="w3-bar-item w3-button w3-hover-teal" href="principal-mi-perfil-form.php"><i class="fas fa-id-badge fa-fw"></i> Mi perfil</a>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}
</script>