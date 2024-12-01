<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pogodi broj</title>
</head>
<body>
    <div class="container">
        <h3>Igra (pogodi broj)</h3>
        <form method="post" action="">
            <label for="guess">Upiši jedan broj od 1 do 10:</label>
            <input type="number" id="guess" name="guess" min="1" max="10" required>
            <button type="submit">Pogodi!</button>
        </form>
        <div>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $guessedNumber = intval($_POST["guess"]);
                $randomNumber = rand(1, 10);

                if ($guessedNumber === $randomNumber) {
                    echo "Čestitamo! Pogodili ste broj!";
                } else {
                    echo "Pogodak, probaj ponovo! <br>Zamišljeni broj je $randomNumber.";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>