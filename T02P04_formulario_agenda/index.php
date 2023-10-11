<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Práctica 4 | Formulario</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1, width=device-width">
        <style>
            table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            }

            td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            }

            tr:nth-child(even) {
            background-color: #dddddd;
            }

            .warning {
                color: red;
                display: inline-block;
                background-color: #f3f397;
                padding: 10px;
                border-color: #ff2d00;
                border: solid 2px;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <?php
            // Si el campo "agenda" existe al enviar el formulario, lo guarda en la variable $agenda.
            // Sino, crea de cero el array de "agenda" y lo asigna a $agenda.
            // print_r($_POST);
            if (isset($_POST['agenda'])) {
                $agenda = $_POST['agenda'];
            } else {
                $agenda = array();
            }

            // print_r($agenda);
            if (isset($_POST['name']) && !empty($_POST['name'])) {
                $name = filter_input(INPUT_POST, 'name');
            } elseif (isset($_POST['name']) && empty($_POST['name'])) {
                echo "<p class='warning'>¡Introduce un nombre!</p>";
            }

            if (isset($_POST['phone']) && !empty($_POST['phone'])) {
                $phone = filter_input(INPUT_POST, 'phone');
            } elseif ((isset($_POST['phone']) && empty($_POST['phone'])) && (isset($_POST['name']) && !empty($_POST['name']))) {
                if (isset($agenda[$name])) {
                    unset($agenda[$name]);
                } else {
                    echo "<p class='warning'>Este contacto no existe.</p>";
                }
            }
            // else {
            //     echo "<p style='color: red;'>Introduce un telefono!</p>";
            // }

            if (isset($name) && isset($phone)) {
                $agenda[$name] = $phone;
            }
            // print_r($agenda);
            
        ?>
        <h1>Nuevo contacto</h1>
        <form action="index.php" method="POST">
            <label for="name">Introduzca su nombre:</label>
            <input type="text" id="name" name="name" required>
            <br>
            <label for="phone">Introduzca su teléfono:</label>
            <input type="number" id="phone" name="phone">
            <?php
                foreach ($agenda as $nombre => $telefono) {
                    echo "<input type='hidden' name='agenda[" . $nombre . "]' value='" . $telefono . "'/>";
                }
            ?>
            <br>
            <input type="submit" value="Enviar">
        </form>
        <br>
        <h2>Agenda</h2>
        <?php
            if(empty($agenda)) {
                echo "No hay contactos registrados.";
            } else {
                echo "<table>
                <tr>
                    <th>Nombre</th>
                    <th>Telefono</th>
                </tr>
                ";
                foreach ($agenda as $name => $phone) {
                    echo "<tr>
                        <td>" . $name . "</td>
                        <td>" . $phone . "</td>
                    </tr>
                    ";
                }
                echo "</table>";
            }
        ?>
    </body>
</html>
