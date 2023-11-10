<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Práctica 1 | Autoload</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1, width=device-width">
    </head>
    <body>
        <?php
            require_once __DIR__.'/autoload/autoload.php';

            $obj = new Class1();
            $obj->echoS();
            $obj2 = new Class2();
            $obj2->echoS();
            $obj3 = new Class3();
            $obj3->echoS();
        ?>
    </body>
</html>
