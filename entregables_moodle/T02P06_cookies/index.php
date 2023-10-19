<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Práctica 6 | Cookies</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1, width=device-width">
    </head>
    <body>
        <?php
            if (!isset($_COOKIE['timesVisited'])) {
                $cookie = 1;
                setcookie("timesVisited", $cookie);
                echo "<p>¡Bienvenido! Esta es la primera vez que ves esta página.</p>";
            } else {
                $cookie = ++$_COOKIE['timesVisited'];
                setcookie("timesVisited", $cookie);
                echo "<p>Has visitado esta página " . $_COOKIE['timesVisited'] . " veces.</p>";
            }
        ?>
    </body>
</html>
