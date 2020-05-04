<?php
include_once LIBRARY_PATH . '/maneja-base-datos.php';

function generaSiguienteNumCuenta($dbConexion, $entidad, $sucursal)
{
    $arrayCuenta['entidad'] = $entidad;
    $arrayCuenta['sucursal'] = $sucursal;
    $arrayCuenta['cuenta'] = 0;

    $resultado = buscaCuentaPorEntidadSucursal($dbConexion, $entidad, $sucursal);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $arrayRegistro = mysqli_fetch_assoc($resultado);
        $arrayCuenta['cuenta'] = $arrayRegistro['num_cuenta'] + 1;
    }

    $arrayCuenta['dc'] = calculaDc($entidad, $sucursal, $arrayCuenta['cuenta']);

    return $arrayCuenta;
}


function calculaDc($entidad, $sucursal, $cuenta)
{
    $cadEntidad = str_pad($entidad, 4, "0", STR_PAD_LEFT);
    $cadSucursal = str_pad($sucursal, 4, "0", STR_PAD_LEFT);
    $cadCuenta = str_pad($cuenta, 10, "0", STR_PAD_LEFT);
    $dc = calculaDcPorCadenas($entidad, $sucursal, $cuenta);
    return (int) $dc;
}


/**
 * Calcula el dígito de control de un número de cuenta CCC (código cuenta cliente)
 * Extraído de: https://borrame.com/recortes/php/digito-control-ccc.html
 * Nota: el DC calculado sólo es correcto si los parámetros son cadenas numéricas válidas
 *
 * @param string $entidad Cadena de 4 dígitos
 * @param string $sucursal Cadena de 4 dígitos
 * @param string $cuenta Cadena de 10 dígitos
 * @return string Cadena de 2 dígitos (el primero para entidad-sucursal, el segundo para cuenta)
 *
 * @version v2013-01-04
 */
function calculaDcPorCadenas($entidad, $sucursal, $cuenta)
{
    $dc = "";
    $pesos = array(6, 3, 7, 9, 10, 5, 8, 4, 2, 1);

    foreach (array($entidad . $sucursal, $cuenta) as $cadena) {
        $suma = 0;
        for ($i = 0, $len = strlen($cadena); $i < $len; $i++) {
            $suma += $pesos[$i] * substr($cadena, $len - $i - 1, 1);
        }
        $digito = 11 - $suma % 11;
        if ($digito == 11) {
            $digito = 0;
        } elseif ($digito == 10) {
            $digito = 1;
        }
        $dc .= $digito;
    }

    return $dc;
}

function formateaCuenta($entidad, $sucursal, $dc, $cuenta, $separador = '-')
{
    $cadEntidad = str_pad($entidad, 4, "0", STR_PAD_LEFT);
    $cadSucursal = str_pad($sucursal, 4, "0", STR_PAD_LEFT);
    $cadDc = str_pad($dc, 2, "0", STR_PAD_LEFT);
    $cadCuenta = str_pad($cuenta, 10, "0", STR_PAD_LEFT);

    return $cadEntidad . $separador . $cadSucursal . $separador . $cadDc . $separador . $cadCuenta;
}

function muestraCuentaOrigen($cuenta)
{
    muestraCuentaRadioButton($cuenta, "origen");
}
function muestraCuentaDestino($cuenta)
{
    muestraCuentaRadioButton($cuenta, "destino");
}
function muestraCuentaRadioButton($cuenta, $nombreRadioButton)
{
    $cuentaFormateada = formateaCuenta(
        $cuenta['num_entidad'],
        $cuenta['num_sucursal'],
        $cuenta['num_digito_control'],
        $cuenta['num_cuenta']
    );
    $saldoFormateado = number_format($cuenta['saldo'], 2);
    ?>
    <div class="w3-row">
        <div class="w3-col w3-container" style="width:30px">
            <input class="w3-radio" type="radio" name="<?= $nombreRadioButton ?>" value="<?= $cuenta['id_cuenta'] ?>" checked>
        </div>
        <div class="w3-rest w3-container">
            <label>
                <table class="w3-table-all">
                    <tr>
                        <th class="w3-center">Cuenta</th>
                        <th class="w3-center">Saldo</th>
                        <th class="w3-center">Numeración</th>
                    </tr>
                    <tr>
                        <td class="w3-center"><?= $cuenta['alias'] ?></td>
                        <td class="w3-center"><?= $saldoFormateado ?> €</td>
                        <td class="w3-center"><?= $cuentaFormateada ?></td>
                    </tr>
                </table>
            </label>
        </div>
    </div>
<?php
}