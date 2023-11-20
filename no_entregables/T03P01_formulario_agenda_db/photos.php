<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Práctica 4 | Formulario | Fotos</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1, width=device-width">
        <link rel="stylesheet" href="./styles.css">
    </head>
    <body>
        <h1>Fotos</h1>
        <?php
            // get the ID of the image from the URL
            $id = $_GET['id'];
            // connect to the database
            include_once "./database.php";
                    
            try {
                $pdo = Database::getConnection();
            } catch (PDOException $e) {
                // Handle the exception here, you can log it or take appropriate action
                echo "<p class='warning'>Error updating contact: " . $e->getMessage() . "</p>";
                return null;
            }

            $statement = $pdo->prepare("SELECT * FROM photos where owner_id = $id");
            $statement->execute();

            if ($statement->rowCount() >= 1) {
                foreach ($statement as $row) {
                    echo "<h2>" . $row['name'] . "</h2>";
                    echo "<img src='./photos/" . $row['name'] . "'</img><br>";
                }
            } else {
                echo "Este contacto no tiene imágenes subidas.";
            }
        ?>
        <br><br>
        <a href="./index.php"><button type="button">Volver atras</button></a>
    </body>
</html>