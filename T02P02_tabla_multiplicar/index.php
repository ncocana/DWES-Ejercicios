<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Práctica 2 | Tabla de multipicar del 1 al 10</title>
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
            const MAX_NUMBER_MULTIPLIER = 10;
            $array = range(1, MAX_NUMBER_MULTIPLIER);

            function echo_table_number_multiply() {
                global $array;

                echo "
                <tr>";
                for ($i = 1; $i <= MAX_NUMBER_MULTIPLIER; $i++) {
                    echo "
                    <th>Tabla del " . $i . "</th>
                    ";
                }
                echo "
                </tr>";

                foreach($array as $number){
                    echo "
                    <tr>";

                    for ($i = 1; $i <= MAX_NUMBER_MULTIPLIER; $i++) {
                        echo "
                        <td>" . $array[$number-1] * $i . "</td>
                        ";
                    }

                    echo "
                    </tr>";
                }
            };
        ?>
        <table>
            <caption><b>Tabla de multiplicar del 1 al <?php echo MAX_NUMBER_MULTIPLIER; ?></b></caption>
            <?php echo_table_number_multiply(); ?>
        </table>
    </body>
</html>
