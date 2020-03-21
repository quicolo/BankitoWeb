<?php
require_once '../resources/config.php';
include TEMPLATES_PATH . '/index_header.php';
?>
<h1 class="w3-center w3-card w3-black">
    <?php echo $_SESSION['error'] ?? "ERROR INDEFINIDO";
    ?>
</H1>
<?php
include TEMPLATES_PATH . '/index_footer.php';
?>