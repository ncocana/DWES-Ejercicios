<!DOCTYPE html>
<!-- Fuente: "Fundamentos PHP práctico" cap.9 pág. 299 a 304 -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Subiendo una foto</title>
        <link rel="stylesheet" type="text/css" href="common.css" />
        <style>
            .icono {
                width: 30%;
                margin: 10px auto;
                align: center;
            }
        </style>
        </head>
    <body>
        <?php
        if (isset($_POST["subirFoto"]))
        {
            processForm();
        }
        else
        {
            displayForm();
        }

        function processForm()
        {
            foreach($_FILES["photos"]["tmp_name"] as $key=>$tmp_name) {
                if (isset($_FILES["photos"]) && ( $_FILES["photos"]["error"][$key] == UPLOAD_ERR_OK))
                {
                    if ($_FILES["photos"]["type"][$key] != "image/jpeg")
                    {
                        echo "<p>Solo fotos JPEG, Gracias!</p>";
                    }
                    // A folder called "photos" needs to exist in order to upload the photos,
                    // otherwise it will give an error.
                    elseif (!move_uploaded_file($_FILES["photos"]["tmp_name"][$key], "photos/" . basename($_FILES["photos"]["name"][$key])))
                    {
                        echo "<p>Lo siento. Ha habido un problema subiendo esta fofo.</p>" . $_FILES["photos"]["error"][$key];
                    }
                    else
                    {
                        displayThanks();
                        break;
                    }
                }
                else
                {
                    switch ($_FILES["photos"]["error"][$key])
                    {
                        case UPLOAD_ERR_INI_SIZE:
                            $message = "La foto es de un tamaño mayor de lo que permite el servidor.";
                            break;
                        case UPLOAD_ERR_FORM_SIZE:
                            $message = "La foto es de un tamaño mayor de lo que permite el script.";
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            $message = "No se ha subido ningun archivo. Asegúrese de que ha elegido un archvivo para subir.";
                            break;
                        default:
                            $message = "Por favor, contacte con el administrador del servidor para ayuda." . var_dump($_FILES);
                    }
                    echo "<p>Lo siento, ha habido un problema subiendo esta foto. $message</p>";
                }
            }
        }

        function displayForm()
        {
            ?>
            <h1>Subiendo multiples fotos</h1>

            <p>Por favor entra tu nombre y elije una o varias fotos para subir, luego haz click en Subir fotos.</p>

            <form action="" method="post" enctype="multipart/form-data">
                <div style="width: 30em;">
                    <!--<input type="hidden" name="MAX_FILE_SIZE" value="5000" /> -->

                    <label for="visitorName">Tu nombre</label>
                    <input type="text" name="visitorName" id="visitorName" value="" />
                    <br>
                    <label for="photos">Tus fotos</label>
                    <input type="file" name="photos[]" id="photos" value="" multiple/>
                    <br><br>
                    <div style="clear: both;">
                        <input type="submit" name="subirFoto" value="Subir fotos" />
                    </div>

                </div>
            </form>
            <br>
            <a href="./index.php">Subir una sola foto</a>
            <?php
        }

        function displayThanks()
        {
            ?>
            <h1>Enhorabuena</h1>
            <p>¡Gracias por subir tus fotos<?php if ($_POST["visitorName"]) {
                echo ", " . $_POST["visitorName"];
            } ?>!</p>
            <p>Estas son tus fotos:</p>
            <?php
            foreach($_FILES["photos"]["tmp_name"] as $key=>$tmp_name) {
                ?>
                <p><img class='icono' src="photos/<?php echo $_FILES["photos"]["name"][$key] ?>" alt="Photo" /></p>
            <?php
            }
        }
        ?>
    </body>
</html>