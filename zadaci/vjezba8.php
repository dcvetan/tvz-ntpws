<?php
$cars = array("Audi", "BMW", "Renault", "Citroen");
$selected_car = isset($_POST['car']) ? $_POST['car'] : null;
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odabir vozila</title>
</head>
<body>

    <p>Odaberite vozilo:</p>
    <form method="POST">
        <?php
        foreach ($cars as $car) {
            echo "<label><input type=\"checkbox\" name=\"car[]\" value=\"$car\" " . (is_array($selected_car) && in_array($car, $selected_car) ? "checked" : "") . "> $car</label><br>";
        }
        ?>
        <button type="submit">Odaberi</button>
    </form>

    <?php $selected_car ?>

</body>
</html>