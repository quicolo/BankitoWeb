<?php
require_once '../resources/config.php';
include LIBRARY_PATH . '/maneja-base-datos.php';
include LIBRARY_PATH . '/maneja-sesion.php';
include LIBRARY_PATH . '/maneja-cuenta.php';
include LIBRARY_PATH . '/maneja-mensajes-form.php';

iniciaSesionSegura();

// Validamos la sesión y la entrada del GET
if (
    !isset($_SESSION['usuario']) or $_SESSION['usuario'] == null or
    !isset($_GET['indice']) or $_GET['indice'] == null or
    !is_numeric($_GET['indice'])
) {
    cierraSesionSegura();
    header('Location: login-form.php');
} else {
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
    } else {
        $cuenta = $_SESSION['cuentas'][$indice];
        $result = buscaMovimientosPorIdCuenta($dbConexion, $cuenta['id_cuenta']);
        ?>
        <div class="w3-row">
            <?php
            muestraMensajes();
            ?>
            <div class="w3-twothird w3-container">
                <h1 class="w3-text-teal">Movimientos de la cuenta <?= $cuenta['alias'] ?>
                </h1>
                <hr>
            </div>
            <div class="w3-third w3-container">
            </div>
        </div>
        <div class="w3-row">
            <div class="w3-twothird w3-container">
                <?php
                if ($result and mysqli_num_rows($result) > 0) {
                ?>
                <table class="w3-table-all w3-hoverable">
                    <tr class="w3-black">
                        <th class="w3-center">Fecha</th>
                        <th class="w3-center">Concepto</th>
                        <th class="w3-center">Importe</th>
                        <th class="w3-center">Saldo</th>
                    </tr>
                    <?php
                    $saldo = $cuenta['saldo'];
                    while ($movim = mysqli_fetch_assoc($result)) {
                        muestraMovimiento($dbConexion, $movim, $saldo);                        
                    }
                    muestraMovimientoInicial($cuenta['fecha_creacion']);
                    ?>
                </table>
                <?php
                } else {
                    echo "<h3>Esta cuenta todavía no tiene movimientos. Haz alguna operación primero.</h3>";
                }
                ?>
            </div>
            <div class="w3-third w3-container">
                <div class="w3-card-4">
                    <img src="images/movimientos-cuenta.jpg" class="w3-image w3-round w3-animate-right" alt="Detalle cuenta">
                </div>
            </div>
        </div>
<?php
    }
}
include TEMPLATES_PATH . '/principal-footer.php';

function muestraMovimiento($dbConexion, $movim, &$saldo) {
?>
    <tr>
        <td class="w3-center"><?=date("d-m-Y", strtotime($movim['fecha_creacion']))?></td>
        <td><?=$movim['concepto']?></td>
        <?php
            $celdaSaldo = "<td class='w3-right-align'>".number_format($saldo, 2)." €</td>";
            $registroTipo = buscaTipoMovimientoPorIdTipoMovim($dbConexion, $movim['id_tipo_movimiento']);
            if ($registroTipo and mysqli_num_rows($registroTipo)==1) {
                $resultTipo = mysqli_fetch_assoc($registroTipo);
                
                if ($resultTipo['direccion'] == 'Salida') {
                    $celdaImporte = "<td class='w3-text-red w3-right-align'>-".number_format($movim['importe'], 2) ." €</td>";
                    $saldo = $saldo + $movim['importe'];
                }
                else {
                    $celdaImporte = "<td class='w3-right-align'>".number_format($movim['importe'], 2)." €</td>";
                    $saldo = $saldo - $movim['importe'];
                }
                echo $celdaImporte;
                echo $celdaSaldo;
            }
            else {
                echo "<td>Error</td>";
                echo "<td>Error</td>";
            }
        ?>
    </tr>
<?php
}

function muestraMovimientoInicial($fechaCreacionCuenta) {
    ?>
    <tr class="w3-teal">
        <td class="w3-center"><i><?=date("d-m-Y", strtotime($fechaCreacionCuenta))?></i></td>
        <td><i>Apertura de la cuenta</i></td>
        <td class='w3-right-align'><i>0.00 €</i></td>
        <td class='w3-right-align'><i>0.00 €</i></td>
    </tr>
<?php
}
