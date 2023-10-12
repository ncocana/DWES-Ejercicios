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

                // Recorre cada elemento del array.
                for ($i = 1; $i < $number_elements_array; $i++) {
                    $next_number = $array[$i];
                    $current_number_position = $i-1;
                
                    // Mientras $current_number_position sea igual o mayor a 0,
                    // y el número actúal en el array sea mayor al siguiente,
                    // moverá el número actúal una posición hacía adelante en el array.
                    while ($current_number_position >= 0 && $array[$current_number_position] > $next_number)
                    {
                        $array[$current_number_position + 1] = $array[$current_number_position];
                        $current_number_position--;
                    }
                    
                    // Inserta $next_number en la posición que le corresponde.
                    $array[$current_number_position + 1] = $next_number;
                }

                return $array;
            }
        ?>

        <h1>Ordenar un array con el método Inserción</h1>
        
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
        <a href="./index.php">Ordenación con el método Burbuja</a>
    </body>
</html>
