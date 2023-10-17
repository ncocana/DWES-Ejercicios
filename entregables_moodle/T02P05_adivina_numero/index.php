<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Práctica 5 | Adivina el número</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1, width=device-width">
    </head>
    <body>
        <?php
            const MIN_NUM = 1;
            const MAX_NUM = 50;
            const MAX_ATTEMPTS = 6;

            processForm();
        ?>
    </body>
</html>

<?php
    /**
     * Procesa el formulario de adivinanza de números y controla el juego.
     *
     * Esta función procesa los datos del formulario, gestiona el juego,
     * y muestra los mensajes correspondientes.
     * Si $submitButton existe y $numberToGuess no es nulo:
     *      Si $numberGuessed es igual a $numberToGuess, muestra el mensaje de éxito.
     *      Si $numAttempts es 0, muestra el mensaje de fracaso.
     *      Si $numberGuessed no es nulo:
     *          Si el valor $numberGuessed es menor o mayor a el valor de $numberToGuess,
     *          muestra el formulario y un mensaje con los intentos restantes
     *          y si el número adivinado es mayor o menor al número a adivinar.
     * De lo contrario, muestra el formulario del juego.
     *
     * @return void
     */
    function processForm() {
        $submitButton = isset($_POST["submitButton"]);
        $numberToGuess = isset($_POST["numberToGuess"])? filter_input(INPUT_POST, 'numberToGuess') : null;
        $numAttempts = isset($_POST['numAttempts'])? (int) filter_input(INPUT_POST, 'numAttempts') - 1 : null;
        $numberGuessed = isset($_POST['numberGuessed'])? filter_input(INPUT_POST, 'numberGuessed') : null;

        if ($submitButton && $numberToGuess !== null) {
            if ($numberGuessed == $numberToGuess) {
                displaySuccess($numberToGuess, $numAttempts);
            } elseif ($numAttempts === 0) {
                displayFailure($numberToGuess);
            } elseif ($numberGuessed !== null) {
                if ($numberGuessed < $numberToGuess) {
                    displayForm($numberToGuess, $numAttempts);
                    printRemainingAttempts($numAttempts, $numberGuessed, "bajo");
                } elseif ($numberGuessed > $numberToGuess) {
                    displayForm($numberToGuess, $numAttempts);
                    printRemainingAttempts($numAttempts, $numberGuessed, "alto");
                }
            }
        } else {
            displayForm(rand(MIN_NUM, MAX_NUM));
        }
    }

    /**
     * Muestra el formulario para adivinar el número.
     *
     * Esta función muestra el formulario para que el usuario
     * adivine el número, y establece las reglas del juego.
     *
     * @param int $numberToGuess El número que el usuario debe adivinar.
     * @param int $numAttempts El número de intentos disponibles (por defecto es el máximo permitido).
     *
     * @return void
     */
    function displayForm($numberToGuess, $numAttempts = MAX_ATTEMPTS) {
        ?>
        <h1>¡Adivina el número!</h1>
        <p>Reglas:</p>
        <p>1. El número a adivinar está entre el <?php echo MIN_NUM; ?> y el <?php echo MAX_NUM; ?>.</p>
        <p>2. Tienes un máximo de <?php echo MAX_ATTEMPTS; ?> intentos.</p>
        <form method="POST">
            <label for="number">Creo que es el número...</label>
            <input type="number" id="numberGuessed" name="numberGuessed" required min="<?php echo MIN_NUM; ?>" max="<?php echo MAX_NUM; ?>" style="width: 3em;" />
            <?php
                // Añade los campos ocultos "numAttempts" y "numberToGuess".
                addHiddenFields($numberToGuess, $numAttempts);
            ?>
            <input type="submit" name="submitButton" value="Intentar"/>
        </form>
        <?php
    }

    /**
     * Agrega los campos ocultos llamados "numAttempts" y "numberToGuess" al formulario.
     *
     * Esta función agrega campos ocultos al formulario para almacenar el número a adivinar
     * y el número de intentos restantes.
     *
     * @param int $numberToGuess El número que el usuario debe adivinar.
     * @param int $numAttempts El número de intentos disponibles.
     *
     * @return void
     */
    function addHiddenFields($numberToGuess, $numAttempts) {
        echo "<input type='hidden' id='numAttempts' name='numAttempts' value='" . $numAttempts . "'/>";
        echo "<input type='hidden' id='numberToGuess' name='numberToGuess' value='" . $numberToGuess . "'/>";
    }

    /**
     * Muestra un mensaje que indica el número de intentos restantes.
     *
     * Esta función muestra un mensaje que informa al usuario sobre el número de intentos restantes
     * y si su suposición fue demasiado alta o baja.
     *
     * @param int $numAttempts El número de intentos restantes.
     * @param int $numberGuessed El número adivinado por el usuario.
     * @param string $difference Indica si el número adivinado es más "alto" o "bajo" que el número correcto.
     *
     * @return void
     */
    function printRemainingAttempts($numAttempts, $numberGuessed, $difference) {
        echo "<p>¡Ups! El número " . $numberGuessed . " es demasiado " . $difference . ". Te quedan " . $numAttempts . " intentos.</p>";
    }

    /**
     * Muestra un mensaje de fracaso en el juego.
     *
     * Esta función muestra un mensaje cuando el usuario se queda sin intentos y no adivina el número,
     * mostrando el número correcto, y permite iniciar otra partida.
     *
     * @param int $numberToGuess El número que el usuario debía adivinar.
     *
     * @return void
     */
    function displayFailure($numberToGuess) {
        ?>
        <p>¡Oh no! Te has quedado sin intentos. El número era <?php echo $numberToGuess; ?>.</p>
        <form action="" method="POST">
            <input type="submit" name="playAgain" value="Juega otra vez"/>
        </form>
        <?php
    }

    /**
     * Muestra un mensaje de éxito en el juego.
     *
     * Esta función muestra un mensaje cuando el usuario adivina el número con éxito,
     * junto al número de intentos que tardó en adivinarlo,
     * y permite iniciar otra partida.
     *
     * @param int $numberToGuess El número que el usuario debía adivinar.
     * @param int $numAttempts El número de intentos utilizados.
     *
     * @return void
     */
    function displaySuccess($numberToGuess, $numAttempts) {
        ?>
        <p>¡Felicidades! ¡Has acertado en tu intento número <?php echo (MAX_ATTEMPTS - $numAttempts); ?>! El número era <?php echo $numberToGuess; ?>.</p>
        <form action="" method="POST">
            <input type="submit" name="playAgain" value="Juega otra vez"/>
        </form>
        <?php
    }
?>
