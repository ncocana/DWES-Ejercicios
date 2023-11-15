<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Práctica 4 | Formulario</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1, width=device-width">
        <link rel="stylesheet" href="./styles.css">
    </head>
    <body>
        <?php
            // Establece la conexión con la base de datos.
            $connection = getConnection();

            // Ejecuta la función para hacer funcionar el formulario.
            processForm($connection);
        ?>
        <h1>Nuevo contacto</h1>
        <ul>
            <li><b>Añadir contacto:</b> Introduce los datos requeridos.</li>
            <li><b>Actualizar contacto:</b>  Introduce el nombre y apellido correspondiente con un número de telefono diferente.</li>
            <li><b>Borrar contacto:</b>  Introduce el nombre y apellido correspondiente sin el número de telefono.</li>
        </ul>
        <form method="POST">
            <label for="name">Introduzca su nombre:</label>
            <input type="text" id="name" name="name" required>
            <br>
            <label for="surname">Introduzca su apellido:</label>
            <input type="text" id="surname" name="surname" required>
            <br>
            <label for="phone">Introduzca su teléfono:</label>
            <input type="number" id="phone" name="phone">
            <br>
            <input type="submit" name="submit" value="Enviar">
        </form>
        <br>
        <h2>Agenda</h2>
        <?php
            // Muestra los contactos existentes en la agenda.
            printAgenda($connection);
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
    function processForm($pdo) {
        // Si el campo "agenda" existe al enviar el formulario, lo guarda en la variable $agenda.
        // Sino, crea de cero el array de "agenda" y lo asigna a $agenda.
        // if (!isset($_POST['agenda'])) {
        //     $_POST['agenda'] = array();
        // }

        if (isset($_POST['submit'])) {
            // Si el campo "name" existe y no está vacío, guardar su valor en $name.
            // De lo contrario, dar un aviso al usuario para que introduzca su nombre.
            if (isset($_POST['name']) && !empty($_POST['name'])) {
                $name = filter_input(INPUT_POST, 'name');
            } elseif (isset($_POST['name']) && empty($_POST['name'])) {
                echo "<p class='warning'>¡Introduce un nombre!</p>";
            }

            if (isset($_POST['surname']) && !empty($_POST['surname'])) {
                $surname = filter_input(INPUT_POST, 'surname');
            } elseif (isset($_POST['surname']) && empty($_POST['surname'])) {
                echo "<p class='warning'>¡Introduce un apellido!</p>";
            }

            // Si el campo "phone" existe y no está vacío, guardar su valor en $phone.
            // Si el campo "phone" está vacío, pero el campo "name" y "surname" no:
            //      Si el campo "agenda" existe, borrar el contacto que coincida con el valor del campo "name".
            //      De lo contrario, da un aviso al usuario diciendo que el contacto no existe.
            if (isset($_POST['phone']) && !empty($_POST['phone'])) {
                $phone = filter_input(INPUT_POST, 'phone');
            } elseif ((isset($_POST['phone']) && empty($_POST['phone'])) &&
                        (isset($_POST['name']) && !empty($_POST['name']))) {
                if (isset($_POST['name']) && isset($_POST['surname'])) {
                    deleteContact($pdo, $name, $surname);
                }
            }

            // Si ambos campos existen al enviar el formulario, añadir los datos a $agenda.
            if (isset($name) && isset($surname) && isset($phone)) {
                if (contactExists($pdo, $name, $surname)) {
                    updateContact($pdo, $name, $surname, $phone);
                } else {
                    insertContact($pdo, $name, $surname, $phone);
                }
            }
        }
    }
    
    function getConnection() {
        include_once "./database.php";
        $database = new Database();
        return $database->getConnection();
    }

    function getContacts($pdo) {
        return $pdo->query('SELECT * FROM contacts');
        // return $statement->fetch();
    }

    function contactExists($pdo, $name, $surname) {
        $statement = $pdo->prepare('SELECT * FROM contacts
                            WHERE name = :name AND surname = :surname');
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':surname', $surname, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() >= 1) {
            return true;
        }
        
        return false;
    }

    function insertContact($pdo, $name, $surname, $phone_number) {
        $sql = 'INSERT INTO contacts(name, surname, phone_number)
                values(:name, :surname, :phone_number)';
        $statement = $pdo->prepare($sql);
        $statement->execute(['name' => $name, 'surname' => $surname, 'phone_number' => $phone_number]);
    }
    
    function updateContact($pdo, $name, $surname, $phone_number) {
        $sql = 'UPDATE contacts
                SET phone_number = :phone_number
                WHERE name = :name AND surname = :surname';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':phone_number', $phone_number, PDO::PARAM_INT);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':surname', $surname, PDO::PARAM_STR);
        $statement->execute();
    }
    
    function deleteContact($pdo, $name, $surname) {
        $sql = 'DELETE FROM contacts
                WHERE name = :name AND surname = :surname';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':surname', $surname, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            echo "<p class='warning'>Este contacto no existe.</p>";
        }
    }
    
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
    function printAgenda($pdo) {
        $contacts = getContacts($pdo);
        if(empty($contacts)) {
            echo "No hay contactos registrados.";
        } else {
            echo "<table>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Telefono</th>
            </tr>
            ";
            foreach ($contacts as $row) {
                echo "<tr>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['surname'] . "</td>
                    <td>" . $row['phone_number'] . "</td>
                </tr>
                ";
            }
            echo "</table>";
        }
    }
?>
