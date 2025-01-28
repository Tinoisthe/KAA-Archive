<?php
session_start();

include('db_connection.php'); // Include your database connection file

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user ID from the session

// Fetch user details from the database
$sql = "SELECT username, password, uid, created_at, is_admin FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // Bind the user_id parameter
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch user data
    $user = $result->fetch_assoc();
    // Update session is_admin to reflect the current user’s admin status
    $_SESSION['is_admin'] = $user['is_admin']; // Store the admin status in the session
} else {
    // Handle the case if user data is not found (error or deleted account)
    echo "User not found.";
    exit();
}

// Handle the form submission for updating the profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = trim($_POST['username']);
    $new_password = trim($_POST['password']);

    // If password is provided, hash it
    if ($new_password) {
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT); // Hash new password
    }

    // Update the database with the new username and password if provided
    $update_sql = "UPDATE users SET username = ?, password = ? WHERE id = ?";
    if ($new_password) {
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssi", $new_username, $new_password_hash, $user_id);
    } else {
        $update_sql = "UPDATE users SET username = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $new_username, $user_id);
    }

    if ($update_stmt->execute()) {
        // Log the profile update action after successful update
        $log_action = "Updated profile information";
        $log_sql = "INSERT INTO logs (user_id, action) VALUES (?, ?)";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->bind_param("is", $user_id, $log_action);
        $log_stmt->execute();

        // Redirect to profile page
        header("Location: profile.php");
        exit();
    } else {
        $error_message = "Failed to update profile.";
    }
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1, h2, p {
            margin: 20px;
        }

        h1 {
            font-size: 2em;
        }

        h2 {
            font-size: 1.5em;
        }

        p {
            font-size: 1.2em;
        }

        a {
            color: #00bfff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .password {
            word-wrap: break-word;
            white-space: pre-wrap;
            font-family: monospace;
        }

        .logout-btn {
            background-color: #ff4d4d;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.2em;
            margin-top: 20px;
            display: inline-block;
        }

        .logout-btn:hover {
            background-color: #e04343;
        }

        .home-btn {
            background-color: #00bfff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.2em;
            margin-top: 20px;
            display: inline-block;
        }

        .home-btn:hover {
            background-color: #0099cc;
        }

        .edit-form {
            margin-top: 20px;
            padding: 20px;
            background-color: #333;
            border-radius: 8px;
        }

        .edit-form input {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #fff;
            width: 100%;
            font-size: 1.2em;
            color: #000;
        }

        .edit-form button {
            background-color: #00bfff;
            color: white;
            padding: 10px 20px;
            font-size: 1.2em;
            border: none;
            border-radius: 5px;
        }

        .edit-form button:hover {
            background-color: #0099cc;
        }

        .error-message {
            color: #ff4d4d;
        }

        .admin-panel {
            margin-top: 30px;
            padding: 20px;
            background-color: #222;
            border-radius: 8px;
        }

        .admin-panel h3 {
            color: #ffcc00;
        }

        .admin-panel a {
            display: block;
            margin: 10px 0;
            padding: 10px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .admin-panel a:hover {
            background-color: #444;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
    
    <h2>Your Profile</h2>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
    <p><strong>User ID (UID):</strong> <?php echo htmlspecialchars($user['uid']); ?></p>
    <p><strong>Account Created At:</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>

    <?php
    // Display admin status
    if ($_SESSION['is_admin']) {  // Using session directly here to display admin tools
        echo "<p><strong>Status:</strong> Admin</p>";
    } else {
        echo "<p><strong>Status:</strong> Regular User</p>";
    }
    ?>

    <p><strong>Password:</strong> (hidden for security reasons)</p>

    <div class="edit-form">
        <h3>Edit Your Profile</h3>
        <?php if (isset($error_message)) { echo '<p class="error-message">' . $error_message . '</p>'; } ?>
        
        <form method="POST" action="profile.php">
            <label for="username">New Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password">
            
            <button type="submit">Save Changes</button>
        </form>
    </div>

    <?php if ($_SESSION['is_admin']) { // Check if the session indicates admin status ?>
    <div class="admin-panel">
        <h3>Admin Panel</h3>
        <p>Welcome, Admin! Here are your administrative tools:</p>
        <a href="manage_users.php" target="_top">Manage Users</a>
        <a href="view_logs.php" target="_top">View Logs</a>
        <a href="site_settings.php" target="_top">Site Settings</a>
    </div>
    <?php } ?>

    <!-- Home Button -->
    <a href="index.php" class="home-btn">Go to Home</a>

    <!-- Logout Button -->
    <a href="logout.php" class="logout-btn">Logout</a>
</body>
</html>
