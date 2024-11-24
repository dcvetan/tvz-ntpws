<?php
$con = mysqli_connect("localhost", "root", "123", "my_db");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_term = mysqli_real_escape_string($con, $_POST['search_term']);
    $query = "SELECT firstname, lastname FROM users WHERE firstname LIKE '%$search_term%' OR lastname LIKE '%$search_term%' ORDER BY lastname ASC LIMIT 10";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<p>" . $row['firstname'] . " " . $row['lastname'] . "</p>";
        }
    } else {
        echo "<p>No results found.</p>";
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Users</title>
</head>
<body>
    <h1>Search for Users</h1>
    <form method="POST" action="">
        <label for="search_term">Enter Firstname or Lastname:</label>
        <input type="text" name="search_term" id="search_term" required>
        <button type="submit">Search</button>
    </form>
</body>
</html>
