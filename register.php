<?php
// Include the database connection file
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Validate the form data
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Hash the password before storing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Generate a unique UID (UUID)
        $uid = bin2hex(random_bytes(16)); // This generates a 32-character hexadecimal string

        // Prepare the SQL query using a prepared statement
        $sql = "INSERT INTO users (uid, username, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $uid, $username, $hashed_password);

        if ($stmt->execute()) {
            // Get the new user's ID
            $new_user_id = $conn->insert_id;

            // Log the registration action
            $log_action = "New user registered";
            $log_sql = "INSERT INTO logs (user_id, action) VALUES (?, ?)";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bind_param("is", $new_user_id, $log_action);
            $log_stmt->execute();

            // Registration successful
            $success = "Registration successful! You can now log in.";
        } else {
            $error = "Error: " . $conn->error;
        }

        // Close the statements
        $stmt->close();
        if (isset($log_stmt)) {
            $log_stmt->close();
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Anime Archive</title>
    <link rel="stylesheet" href="/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <div class="showcase-top">
            <h1>Anime Archive</h1>
        </div>
    </header>

    <section>
        <h2>Register for Anime Archive</h2>

        <!-- Display any success or error messages -->
        <?php if (isset($error)) { echo '<p class="error">' . htmlspecialchars($error) . '</p>'; } ?>
        <?php if (isset($success)) { echo '<p class="success">' . htmlspecialchars($success) . '</p>'; } ?>

        <form action="register.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" required>

            <button type="submit" class="submit-btn">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </section>
</body>
</html>
