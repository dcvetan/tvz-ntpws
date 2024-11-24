<?php
$title = "Da Vincijev kod";
$link = "hr.wikipedia.org/Da_Vincijev_kod";
$linkText = "Pročitajte više na Wikipediji";
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Informacije o knjizi Da Vincijev kod autora Dana Browna.">
    <meta name="keywords" content="Da Vincijev kod, Dan Brown, kriminalistički triler, knjige">
    <title><?php echo $title; ?></title>
</head>
<body>
    <h1>Da Vincijev kod</h1>
    <p>Da Vincijev kod je kriminalistički triler američkog pisca Dana Browna.</p>
    <p>
        <?php echo "<a href='https://" . $link . "' target='_blank'>" . $linkText . "</a>"; ?>
    </p>
</body>
</html>