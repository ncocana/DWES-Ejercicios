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
     * Procesa los datos del formulario enviado y actualiza la base de datos en consecuencia.
     *
     * Esta función es responsable de manejar el envío del formulario, validar el input,
     * y realizar acciones como insertar, actualizar, o eliminar contactos en la base de datos.
     *
     * @param PDO $pdo Conexión PDO a la base de datos.
     *
     * @return void
     */
    function processForm($pdo) {
        if (isset($_POST['submit'])) {
            // Sanitiza los valores de los campos y los guarda en variables.
            $name = processField('name', '¡Introduce un nombre!');
            $surname = processField('surname', '¡Introduce un apellido!');
            $phone = processField('phone', '', true);
    
            if ($name !== null && $surname !== null) {
                // Si $phone no es null y no está vacío...
                if ($phone !== null && !empty($phone)) {
                    // ...si el contacto existe, lo actualiza.
                    if (contactExists($pdo, $name, $surname)) {
                        updateContact($pdo, $name, $surname, $phone);
                    }
                    // ...si el contacto no existe, lo inserta.
                    else {
                        insertContact($pdo, $name, $surname, $phone);
                    }
                } else {
                    // Si $phone es null, borra el contacto si existe.
                    if (contactExists($pdo, $name, $surname)) {
                        deleteContact($pdo, $name, $surname);
                    } else {
                        echo "<p class='warning'>Este contacto no existe.</p>";
                    }
                }
            }
        }
    }

    /**
     * Procesa un campo del formulario, valida su valor, y lo devuelve el valor sanitizado.
     *
     * Esta función se utiliza para campos individuales del formulario
     * con el fin de garantizar una validación y sanitización adecuadas.
     *
     * @param string $fieldName     El nombre del campo del formulario.
     * @param string $emptyMessage  El mensaje de error que se mostrará si el campo está vacío.
     * @param bool   $allowEmpty    Si se permite un valor vacío (el valor predeterminado es false).
     *
     * @return mixed|null El valor sanitizado del campo de formulario, o null si la validación falla.
     */
    function processField($fieldName, $emptyMessage, $allowEmpty = false) {
        // Si el campo se envía en la petición POST, lo devuelve sanitizado.
        if (isset($_POST[$fieldName])) {
            $value = filter_input(INPUT_POST, $fieldName);

            // Si el campo es obligatorio y está vacío, muestra un mensaje de advertencia al usuario.
            if (!$allowEmpty && empty($value)) {
                echo "<p class='warning'>$emptyMessage</p>";
                return null;
            }

            return $value;
        }

        // Si el campo no se envía en la petición POST, devuelve null.
        return null;
    }
    
    /**
     * Establece una conexión a la base de datos.
     *
     * Esta función usa la clase Database para crear una conexión PDO a la base de datos.
     *
     * @return PDO Conexión PDO a la base de datos.
     */
    function getConnection() {
        include_once "./database.php";
        
        try {
            $database = new Database();
            return $database->getConnection();
        } catch (PDOException $e) {
            // Handle the exception here, you can log it or take appropriate action
            echo "<p class='warning'>Error updating contact: " . $e->getMessage() . "</p>";
        }
    }

    /**
     * Devuelve todos los contactos de la base de datos.
     *
     * @param PDO $pdo Conexión PDO a la base de datos.
     *
     * @return PDOStatement|false Devuelve un PDOStatement que representa el conjunto de resultados de la consulta,
     *                              o falso en caso de error.
     */
    function getContacts($pdo) {
        try {
            return $pdo->query('SELECT * FROM contacts');
        } catch (PDOException $e) {
            // Handle the exception here, you can log it or take appropriate action
            echo "<p class='warning'>Error updating contact: " . $e->getMessage() . "</p>";
        }
    }

    /**
     * Comprueba si existe un contacto con el nombre y apellido especificados en la base de datos.
     *
     * @param PDO $pdo        Conexión PDO a la base de datos.
     * @param string $name    El nombre del contacto.
     * @param string $surname El apellido del contacto.
     *
     * @return bool Verdadero si el contacto existe, falso en caso contrario.
     */
    function contactExists($pdo, $name, $surname) {
        try {
            $statement = $pdo->prepare('SELECT * FROM contacts
                                WHERE name = :name AND surname = :surname');
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':surname', $surname, PDO::PARAM_STR);
            $statement->execute();

            return $statement->rowCount() >= 1;
        } catch (PDOException $e) {
            // Handle the exception here, you can log it or take appropriate action
            echo "<p class='warning'>Error updating contact: " . $e->getMessage() . "</p>";
        }
    }

    /**
     * Inserta un nuevo contacto en la base de datos.
     *
     * @param PDO $pdo              Conexión PDO a la base de datos.
     * @param string $name          El nombre del contacto.
     * @param string $surname       El apellido del contacto.
     * @param string $phone_number  El número de telefono del contacto.
     *
     * @return void
     */
    function insertContact($pdo, $name, $surname, $phone_number) {
        try {
            $sql = 'INSERT INTO contacts(name, surname, phone_number)
                    values(:name, :surname, :phone_number)';
            $statement = $pdo->prepare($sql);
            $statement->execute(['name' => $name, 'surname' => $surname, 'phone_number' => $phone_number]);
        } catch (PDOException $e) {
            // Handle the exception here, you can log it or take appropriate action
            echo "<p class='warning'>Error inserting contact: " . $e->getMessage() . "</p>";
        }
    }
    
    /**
     * Actualiza el número de teléfono de un contacto existente en la base de datos.
     *
     * @param PDO $pdo              Conexión PDO a la base de datos.
     * @param string $name          El nombre del contacto.
     * @param string $surname       El apellido del contacto.
     * @param string $phone_number  El nuevo número de telefono del contacto.
     *
     * @return void
     */
    function updateContact($pdo, $name, $surname, $phone_number) {
        try {
            $sql = 'UPDATE contacts
                    SET phone_number = :phone_number
                    WHERE name = :name AND surname = :surname';
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':phone_number', $phone_number, PDO::PARAM_INT);
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':surname', $surname, PDO::PARAM_STR);
            $statement->execute();
        } catch (PDOException $e) {
            // Handle the exception here, you can log it or take appropriate action
            echo "<p class='warning'>Error updating contact: " . $e->getMessage() . "</p>";
        }
    }
    
    /**
     * Borra un contacto de la base de datos.
     *
     * @param PDO $pdo              Conexión PDO a la base de datos.
     * @param string $name          El nombre del contacto.
     * @param string $surname       El apellido del contacto.
     *
     * @return void
     */
    function deleteContact($pdo, $name, $surname) {
        try {
            $sql = 'DELETE FROM contacts
                    WHERE name = :name AND surname = :surname';
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':surname', $surname, PDO::PARAM_STR);
            $statement->execute();

            if ($statement->rowCount() == 0) {
                echo "<p class='warning'>Este contacto no existe.</p>";
            }
        } catch (PDOException $e) {
            // Handle the exception here, you can log it or take appropriate action
            echo "<p class='warning'>Error deleting contact: " . $e->getMessage() . "</p>";
        }
    }
    
    /**
     * Imprime una agenda en formato tabular.
     *
     * Esta función imprime una tabla HTML que muestra los contactos de la agenda.
     * La tabla contiene tres columnas, una para el nombre, otra para el apellido, y otra para el número de teléfono.
     * Si la agenda está vacía, se mostrará un mensaje indicando que no hay contactos registrados.
     *
     * @param PDO $pdo Conexión PDO a la base de datos.
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
                <th>Apellido</th>
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
