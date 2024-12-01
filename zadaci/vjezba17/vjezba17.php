<?php
$con = mysqli_connect("localhost", "root", "123", "my_db");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_term = mysqli_real_escape_string($con, $_POST['search_term']);
    
    $query = "
        SELECT users.firstname, users.lastname, users.email, users.username, countries.name AS country
        FROM users
        JOIN countries ON users.country_id = countries.id
        WHERE users.firstname LIKE '%$search_term%' 
        OR users.lastname LIKE '%$search_term%'
        ORDER BY users.lastname ASC
        LIMIT 10
    ";
    
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Country</th>
                </tr>";
        
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>
                    <td>" . $row['firstname'] . "</td>
                    <td>" . $row['lastname'] . "</td>
                    <td>" . $row['email'] . "</td>
                    <td>" . $row['username'] . "</td>
                    <td>" . $row['country'] . "</td>
                </tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p>No results found.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Users</title>
</head>
<body>
    <h2>Search Users</h2>
    <form method="POST" action="">
        <label for="search_term">Search by First Name or Last Name:</label>
        <input type="text" name="search_term" id="search_term" required>
        <button type="submit">Search</button>
    </form>
</body>
</html>
