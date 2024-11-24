<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $user_id = $_POST['user_id'];
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $country_id = $_POST['country_id'];

    $update_query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', country_id = '$country_id' WHERE id = '$user_id'";
    if (mysqli_query($con, $update_query)) {
        echo "<p>User updated successfully.</p>";
    } else {
        echo "<p>Error updating user: " . mysqli_error($con) . "</p>";
    }
}

$query = "
    SELECT users.id, users.firstname, users.lastname, users.email, users.username, countries.name AS country, countries.id AS country_id
    FROM users
    JOIN countries ON users.country_id = countries.id
    ORDER BY users.lastname ASC
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
                <th>Action</th>
            </tr>";

    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['firstname']) . "</td>
                <td>" . htmlspecialchars($row['lastname']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['username']) . "</td>
                <td>" . htmlspecialchars($row['country']) . "</td>
                <td>
                    <form method='POST' action=''>
                        <input type='hidden' name='user_id' value='" . $row['id'] . "'>
                        <input type='submit' name='edit' value='Edit'>
                    </form>
                </td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No users found.</p>";
}

if (isset($_POST['edit'])) {
    $user_id = $_POST['user_id'];
    $edit_query = "SELECT * FROM users WHERE id = '$user_id'";
    $edit_result = mysqli_query($con, $edit_query);
    $edit_user = mysqli_fetch_array($edit_result);

    $countries_query = "SELECT * FROM countries";
    $countries_result = mysqli_query($con, $countries_query);

    echo "<h2>Edit User</h2>
        <form method='POST' action=''>
            <input type='hidden' name='user_id' value='" . $edit_user['id'] . "'>
            <label for='firstname'>First Name:</label>
            <input type='text' name='firstname' value='" . htmlspecialchars($edit_user['firstname']) . "' required><br>
            <label for='lastname'>Last Name:</label>
            <input type='text' name='lastname' value='" . htmlspecialchars($edit_user['lastname']) . "' required><br>
            <label for='country_id'>Country:</label>
            <select name='country_id' required>";

    while ($country = mysqli_fetch_array($countries_result)) {
        $selected = ($edit_user['country_id'] == $country['id']) ? "selected" : "";
        echo "<option value='" . $country['id'] . "' $selected>" . htmlspecialchars($country['name']) . "</option>";
    }

    echo "</select><br>
            <button type='submit'>Update</button>
        </form>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List and Edit</title>
</head>
<body>
    <h2>User List</h2>
</body>
</html>
