<?php
$query = "SELECT * FROM countries ORDER BY name ASC";
$countriesResult = mysqli_query($db, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $countryId = mysqli_real_escape_string($db, $_POST['country_id']);
    $city = mysqli_real_escape_string($db, $_POST['city']);
    $dateOfBirth = mysqli_real_escape_string($db, $_POST['date_of_birth']);

    // Check if username exists
    $query = "SELECT id FROM users WHERE username = '$username'";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "Username already exists. Please choose another.";
        header('Location: index.php?menu=register');
        exit();
    }

    // Generate random password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password, firstname, lastname, email, country_id, city, date_of_birth) 
              VALUES ('$username', '$hashed_password', '$firstname', '$lastname', '$email', '$countryId', '$city', '$dateOfBirth')";

    if (mysqli_query($db, $query)) {
        $_SESSION['success'] = "Registration successful! Please login with your credentials.";
        header('Location: index.php?menu=login');
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($db);
        header('Location: index.php?menu=register');
    }
    exit();
}
?>

<main>
    <div class="auth-container">
        <form action="" method="post" class="auth-form">
            <h2>Register</h2>
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="country">Country:</label>
                <select id="country" name="country_id" required>
                    <option value="">Select a country</option>
                    <?php while($row = mysqli_fetch_assoc($countriesResult)): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>
            </div>
            <div class="form-group">
                <label for="street">Street:</label>
                <input type="text" id="street" name="street" required>
            </div>
            <div class="form-group">
                <label for="birthdate">Birth Date:</label>
                <input type="date" id="birthdate" name="date_of_birth" required>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</main>