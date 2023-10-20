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
            // Ejecuta la función para hacer funcionar el formulario
            // y la guarda en una variable para luego pasarla al resto de funciones.
            $agenda = processForm();
        ?>
        <h1>Nuevo contacto</h1>
        <form action="agenda_session.php" method="POST">
            <label for="name">Introduzca su nombre:</label>
            <input type="text" id="name" name="name" required>
            <br>
            <label for="phone">Introduzca su teléfono:</label>
            <input type="number" id="phone" name="phone">
            <?php
                // Añade uno o varios campos ocultos llamados "agenda[name]" con los datos de cada contacto.
                // addFieldAgenda($agenda);
            ?>
            <br>
            <input type="submit" name="submit" value="Enviar">
        </form>
        <br>
        <h2>Agenda</h2>
        <?php
            // Muestra los contactos existentes en la agenda.
            printAgenda($agenda);
        ?>
    </body>
</html>

<?php
    /**
     * Procesa un formulario para gestionar una agenda de contactos.
     *
     * Esta función procesa los datos enviados a través de un formulario web para gestionar una agenda de contactos.
     * Puede realizar las siguientes acciones:
     *
     * 1. Guarda los datos de la agenda si el campo "agenda" se encuentra en la solicitud POST.
     * 2. Valida y guarda el nombre del contacto si el campo "name" está presente y no está vacío.
     *    Si el campo "name" está vacío, se mostrará un aviso al usuario.
     * 3. Valida y guarda el número de teléfono del contacto si el campo "phone" está presente y no está vacío.
     * 4. Si el campo "phone" está vacío pero el campo "name" no, verifica si el contacto con el nombre especificado
     *    existe en la agenda y, en ese caso, lo elimina.
     * 5. Si tanto el nombre como el número de teléfono se proporcionan, agrega o actualiza el contacto en la agenda.
     *
     * @return array Un array asociativo que representa la agenda de contactos después de procesar el formulario.
     */
    function processForm() {
        // Si el campo "agenda" existe al enviar el formulario, lo guarda en la variable $agenda.
        // Sino, crea de cero el array de "agenda" y lo asigna a $agenda.
        session_start(["cookie_lifetime" => 3600]);  // 24 horas.
        if (!isset($_SESSION['agenda'])) {
            $_SESSION['agenda'] = array();
        }

        if (isset($_REQUEST['submit'])) {
            // Si el campo "name" existe y no está vacío, guardar su valor en $name.
            // De lo contrario, dar un aviso al usuario para que introduzca su nombre.
            if (isset($_REQUEST['name']) && !empty($_REQUEST['name'])) {
                $name = trim($_REQUEST['name']);
            } elseif (isset($_REQUEST['name']) && empty($_REQUEST['name'])) {
                echo "<p class='warning'>¡Introduce un nombre!</p>";
            }

            // Si el campo "phone" existe y no está vacío, guardar su valor en $name.
            // Si el campo "phone" está vacío, pero el campo "name" no:
            //      Si el campo "agenda" existe, borrar el contacto que coincida con el valor del campo "name".
            //      De lo contrario, dar un aviso al usuario diciendo que el contacto no existe.
            if (isset($_REQUEST['phone']) && !empty($_REQUEST['phone'])) {
                $phone = $_REQUEST['phone'];
            } elseif ((isset($_REQUEST['phone']) && empty($_REQUEST['phone'])) &&
                        (isset($_REQUEST['name']) && !empty($_REQUEST['name']))) {
                if (isset($_SESSION['agenda'][$name])) {
                    unset($_SESSION['agenda'][$name]);
                } else {
                    echo "<p class='warning'>Este contacto no existe.</p>";
                }
            }

            // Si ambos campos existen al enviar el formulario, añadir los datos a $agenda.
            if (isset($name) && isset($phone)) {
                $_SESSION['agenda'][$name] = $phone;
            }
        }

        return $_SESSION['agenda'];
    }
    
    /**
     * Agrega campos ocultos a un formulario para una agenda.
     *
     * Esta función genera campos de entrada ocultos para cada entrada en la agenda
     * proporcionada como un array asociativo, donde la clave es el nombre de la
     * entrada y el valor es el número de teléfono de la entrada.
     *
     * @param array $agenda Un array asociativo que contiene las entradas de la agenda,
     *                      donde las claves son los nombres y los valores son los números de teléfono.
     *
     * @return void
     */
    // function addFieldAgenda($agenda){
    //     foreach ($agenda as $nombre => $telefono) {
    //         echo "<input type='hidden' name='agenda[" . $nombre . "]' value='" . $telefono . "'/>";
    //     }
    // }
    
    /**
     * Imprime una agenda en formato tabular.
     *
     * Esta función imprime una tabla HTML que muestra los contactos de la agenda.
     * La tabla contiene dos columnas, una para el nombre y otra para el número de teléfono.
     * Si la agenda está vacía, se mostrará un mensaje indicando que no hay contactos registrados.
     *
     * @param array $agenda Un array asociativo que contiene los contactos de la agenda,
     *                      donde las claves son los nombres y los valores son los números de teléfono.
     *
     * @return void
     */
    function printAgenda($agenda) {
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
    }
?>
