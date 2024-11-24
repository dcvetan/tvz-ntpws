<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator (Switch naredba)</title>
</head>
<body>
    <div class="container">
        <h3>Kalkulator (Switch naredba)</h3>
        <form method="post" action="">
            <label for="num1">Upiši prvi broj *</label><br>
            <input type="number" id="num1" name="num1" required><br><br>

            <label for="num2">Upiši drugi broj *</label><br>
            <input type="number" id="num2" name="num2" required><br><br>

            <label>Rezultat:</label><br>
            <button type="submit" name="operation" value="add">+</button>
            <button type="submit" name="operation" value="subtract">-</button>
            <button type="submit" name="operation" value="multiply">*</button>
            <button type="submit" name="operation" value="divide">/</button>
        </form>
        <div>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $num1 = floatval($_POST["num1"]);
                $num2 = floatval($_POST["num2"]);
                $operation = $_POST["operation"];
                $result = "";

                switch ($operation) {
                    case "add":
                        $result = $num1 + $num2;
                        echo "Rezultat: $num1 + $num2 = $result";
                        break;
                    case "subtract":
                        $result = $num1 - $num2;
                        echo "Rezultat: $num1 - $num2 = $result";
                        break;
                    case "multiply":
                        $result = $num1 * $num2;
                        echo "Rezultat: $num1 * $num2 = $result";
                        break;
                    case "divide":
                        if ($num2 != 0) {
                            $result = $num1 / $num2;
                            echo "Rezultat: $num1 / $num2 = $result";
                        } else {
                            echo "Greška: Dijeljenje s nulom nije dozvoljeno!";
                        }
                        break;
                    default:
                        echo "Greška: Nepoznata operacija!";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>