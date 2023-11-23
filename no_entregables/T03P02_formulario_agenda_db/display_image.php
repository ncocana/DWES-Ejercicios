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

    $result = $pdo->prepare("SELECT photo FROM contacts where id = $id");
    if ($result->execute()) {
        $row=$result->fetch();
        // header("Content-Type: image/jpeg");
        echo fpassthru($row['photo']); //this prints the image data, transforming the image.php to an image
    }
?>