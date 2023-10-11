<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Práctica 1 | Conversión entre tipos de datos en PHP</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1, width=device-width">
        <style>
            table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            }

            td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            }

            tr:nth-child(even) {
            background-color: #dddddd;
            }
        </style>
    </head>
    <body>
        <?php
            // $null = null;
            // $true = true;
            // $false = false;
            // $zero = 0;
            // $float = 3.8;
            // $zero_string = "0";
            // $not_zero_string = "10";
            // $string_with_number = "6 metros";
            // $string = "hola";

            $array = array(null, true, false, 0, 3.8, "0", "10", "6 metros", "hola");

            function echo_var_conversion() {
                global $array;
                foreach($array as $var){
                    echo "
                    <tr>
                        <td>" . var_export($var, true) . "</td>
                        <td>" . intval($var) . "</td>
                        <td>" . (boolval($var) ? 'true' : 'false') . "</td>
                        <td>" . var_export(strval($var), true) . "</td>
                        <td>" . floatval($var) . "</td>
                    </tr>
                    ";
                }
            };
        ?>
        <table>
            <caption><b>Tabla</b></caption>
            <tr>
                <th>Valor de $var</th>
                <th>(int) $var</th>
                <th>(bool) $var</th>
                <th>(string) $var</th>
                <th>(float) $var</th>
            </tr>
            <?php echo_var_conversion(); ?>
        </table>
    </body>
</html>

<!-- null 0 false "" 0
true 1 true "1" 1
false 0 false "" 0
0 0 false "0" 0
3.8 3 true "3.8" 3.8
"0" 0 false "0" 0
"10" 10 true "10" 10
"6 metros" 6 true "6 metros" 6
"hola" 0 true "hola" 0-->
