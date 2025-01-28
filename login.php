<?php
// Include the database connection file
include('db_connection.php');

// Initialize session
session_start();

// Security headers to prevent clickjacking, XSS, and other vulnerabilities
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('X-Frame-Options: DENY');

// Check if login is enabled
$login_enabled = true;
$setting_sql = "SELECT login_enabled FROM site_settings WHERE id = 1";
$setting_result = $conn->query($setting_sql);

if ($setting_result->num_rows > 0) {
    $row = $setting_result->fetch_assoc();
    $login_enabled = (bool) $row['login_enabled'];
}

// Redirect or show message if login is disabled
if (!$login_enabled) {
    die('<h2>Login is currently disabled by the administrator.</h2><p>Please try again later.</p>');
}

// Redirect logged-in users to home page
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Get the user's IP address and user-agent
$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $username = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password']);

    // Check if fields are empty
    if (empty($username) || empty($password)) {
        $error_message = "Both fields are required.";
    } else {
        // Prepare and execute the query to check user credentials
        $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);

                // Store user information in session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Log the successful login attempt
                $log_action = "User logged in successfully";
                $log_sql = "INSERT INTO login_attempts (user_id, username, ip_address, user_agent, success) 
                            VALUES (?, ?, ?, ?, TRUE)";
                $log_stmt = $conn->prepare($log_sql);
                $log_stmt->bind_param("isss", $user['id'], $username, $ip_address, $user_agent);
                $log_stmt->execute();

                // Redirect to the desired page or index.php
                $redirect_to = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : 'index.php';
                header("Location: $redirect_to");
                exit();
            } else {
                // Log the failed login attempt
                $log_sql = "INSERT INTO login_attempts (username, ip_address, user_agent, success) 
                            VALUES (?, ?, ?, FALSE)";
                $log_stmt = $conn->prepare($log_sql);
                $log_stmt->bind_param("sss", $username, $ip_address, $user_agent);
                $log_stmt->execute();

                $error_message = "Invalid credentials."; // Generic error message
            }
        } else {
            // Log the failed login attempt (user does not exist)
            $log_sql = "INSERT INTO login_attempts (username, ip_address, user_agent, success) 
                        VALUES (?, ?, ?, FALSE)";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bind_param("sss", $username, $ip_address, $user_agent);
            $log_stmt->execute();

            $error_message = "Invalid credentials."; // Generic error message
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Anime Archive</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <header class="showcase">
        <div class="showcase-top">
            <img src="/images/logo_size_invert.jpg" alt="Anime Archive Logo">
        </div>
    </header>

    <section>
        <h2>Login to Anime Archive</h2>

        <?php if (isset($error_message)) { echo '<p class="error">' . htmlspecialchars($error_message) . '</p>'; } ?>

        <form method="POST" action="login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </section>

    <footer>
        <p>&copy; 2025 Anime Archive. All rights reserved.</p>
    </footer>
</body>
</html>
