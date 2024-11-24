<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputString = $_POST["inputString"];
    $wordCount = str_word_count($inputString);
    echo "<p>ulazni niz: $inputString. sadrži $wordCount riječi.</p>";
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Zadatak str_word_count</title>
</head>
<body>
    <h1>Zadatak <span style="color: red;">str_word_count</span></h1>
    <p>U zadatku se traži da se ispiše koliko je riječi u rečenici. Koristite naredbu <span style="color: red;">str_word_count</span></p>
    <form method="post">
        <label for="inputString">Ulazni niz:</label>
        <input type="text" id="inputString" name="inputString">
        <button type="submit">ispisi broj riječi</button>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $inputString = $_POST["inputString"];
        $wordCount = str_word_count($inputString);
        echo "<p>ulazni niz: $inputString. sadrži $wordCount riječi.</p>";
    }
    ?>
</body>
</html>
