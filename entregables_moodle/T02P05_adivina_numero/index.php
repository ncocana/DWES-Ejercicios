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

    function addHiddenFields($numberToGuess, $numAttempts) {
        echo "<input type='hidden' id='numAttempts' name='numAttempts' value='" . $numAttempts . "'/>";
        echo "<input type='hidden' id='numberToGuess' name='numberToGuess' value='" . $numberToGuess . "'/>";
    }

    function printRemainingAttempts($numAttempts, $numberGuessed, $difference) {
        echo "<p>¡Ups! El número " . $numberGuessed . " es demasiado " . $difference . ". Te quedan " . $numAttempts . " intentos.</p>";
    }

    function displayFailure($numberToGuess) {
        ?>
        <p>¡Oh no! Te has quedado sin intentos. El número era <?php echo $numberToGuess; ?>.</p>
        <form action="" method="POST">
            <input type="submit" name="playAgain" value="Juega otra vez"/>
        </form>
        <?php
    }

    function displaySuccess($numberToGuess, $numAttempts) {
        ?>
        <p>¡Felicidades! ¡Has acertado en tu intento número <?php echo (MAX_ATTEMPTS - $numAttempts); ?>! El número era <?php echo $numberToGuess; ?>.</p>
        <form action="" method="POST">
            <input type="submit" name="playAgain" value="Juega otra vez"/>
        </form>
        <?php
    }
?>
