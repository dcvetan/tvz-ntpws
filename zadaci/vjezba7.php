<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konačna Ocjena</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        }

        .container {
            width: 300px;
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #ccc;
        }

        input, button {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Izračun Prosjeka i Konačne Ocjene</h3>
        <form method="post" action="">
            <label for="kolokvij1">Unos ocjene I. kolokvija (1-5):</label>
            <input type="number" id="kolokvij1" name="kolokvij1" min="1" max="5" required><br>

            <label for="kolokvij2">Unos ocjene II. kolokvija (1-5):</label>
            <input type="number" id="kolokvij2" name="kolokvij2" min="1" max="5" required><br>

            <button type="submit">Izračunaj</button>
        </form>

        <div class="result">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $kolokvij1 = intval($_POST["kolokvij1"]);
                $kolokvij2 = intval($_POST["kolokvij2"]);

                if ($kolokvij1 < 1 || $kolokvij1 > 5 || $kolokvij2 < 1 || $kolokvij2 > 5) {
                    echo "Greška: Ocjene moraju biti između 1 i 5!";
                } else {
                    $prosjek = ($kolokvij1 + $kolokvij2) / 2;
                    if ($kolokvij1 == 1 || $kolokvij2 == 1) {
                        echo "Konačna ocjena: Negativna (1)<br>";
                    } else {
                        echo "Prosjek ocjena: " . round($prosjek, 2) . "<br>";
                        echo "Konačna ocjena: " . round($prosjek) . "<br>";
                    }
                }
            }
            ?>
        </div>
    </div>
</body>
</html>