<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Práctica 3 | Ordenar arrays</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1, width=device-width">
        <style>
            
        </style>
    </head>
    <body>
        <?php
            $array = array(23, 34, 12, 103, 28, 39, 69);

            function orderArray($array){
                $number_elements_array = count($array);
                $array_is_ordered = false;

                // Mientras $array_is_ordered sea falso, se seguirá ejecutando el bucle "while".
                while(!$array_is_ordered){
                    // Se cambia el valor de $array_is_ordered a "true",
                    // para que en caso que el número de elementos en el array sea 1,
                    // no de error si el cambio se hace dentro del bucle "for" y/o el if.
                    $array_is_ordered = true;
                    
                    // Durante cada iteración del bucle, se ejecutara el bucle "for".
                    // El bucle verificará que el array esté ordenado mediante
                    // la comprobación de si el siguiente número es más grande que el actual.
                    for($i = 1; $i < $number_elements_array; $i++){
                        // Si el valor de $array[$i - 1] (número actual)
                        // es mayor al valor de $array[$i] (siguiente número),
                        // entra en el "if".
                        if($array[$i - 1] > $array[$i]){
                            // Se guardan los valores de $array[$i - 1] y $array[$i] en variables.
                            $current_number = $array[$i - 1];
                            $next_number = $array[$i];

                            // Se intercambian los valores en el array.
                            $array[$i] = $current_number;
                            $array[$i - 1] = $next_number;

                            // Como los valores ya están ordenados,
                            // se cambia el valor de $array_is_ordered a "false",
                            // para hacer que el bucle "while" siga ejecutandose hasta que todos
                            // los números del array estén ordenados.
                            $array_is_ordered = false;
                        }
                    }
                }

                return $array;
            }
        ?>

        <h1>Ordenar un array con el método Burbuja</h1>
        
        <h2>Array sin ordenar</h2>
        <?php
            foreach($array as $key => $value) {
                echo $value . "<br>";
            }
        ?>

        <h2>Array ordenado</h2>
        <?php
            foreach(orderArray($array) as $key => $value) {
                echo $value . "<br>";
            }
        ?>
        <br>
        <a href="./algoritmo_insercion.php">Ordenación por Inserción</a>
    </body>
</html>
