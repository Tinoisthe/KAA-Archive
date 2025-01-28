<?php
session_start();

include('db_connection.php'); // Include your database connection file

// Redirect to login if the user is not logged in or not an admin
if (!isset($_SESSION['user_id']) || (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] != 1)) {
    header("Location: login.php");
    exit();
}

// Fetch current site settings from the database
$sql = "SELECT * FROM site_settings WHERE id = 1";
$stmt = $conn->prepare($sql);

if (!$stmt->execute()) {
    die("Error fetching site settings: " . $conn->error);
}

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $settings = $result->fetch_assoc();
} else {
    $error_message = "No site settings found.";
}

// Handle updating the login toggle
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save_settings'])) {
        $login_enabled = isset($_POST['login_enabled']) ? 1 : 0; // Convert checkbox to boolean value

        // Update settings in the database
        $update_sql = "UPDATE site_settings SET login_enabled = ? WHERE id = 1";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $login_enabled);

        if (!$update_stmt->execute()) {
            $error_message = "Failed to update site settings: " . htmlspecialchars($update_stmt->error);
        } else {
            // Redirect after saving
            header("Location: site_settings.php");
            exit();
        }
    }
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Settings</title>
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 2em;
            margin: 20px;
        }

        .form-container {
            margin: 20px;
        }

        /* Toggle switch style */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            border-radius: 50%;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
        }

        input:checked + .slider {
            background-color: #00bfff;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        button {
            background-color: #00bfff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
        }

        button:hover {
            background-color: #007acc;
        }

        .error-message {
            color: #ff4d4d;
            margin: 20px;
        }

        a {
            color: #00bfff;
            text-decoration: none;
            margin: 20px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Site Settings</h1>

    <?php if (isset($error_message)) { ?>
        <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
    <?php } ?>

    <div class="form-container">
        <form method="POST">
            <label for="login_enabled" style="font-size: 1.2em;">Enable Login:</label>
            <label class="switch">
                <input type="checkbox" name="login_enabled" <?php echo ($settings['login_enabled'] == 1) ? 'checked' : ''; ?>>
                <span class="slider"></span>
            </label>

            <button type="submit" name="save_settings">Save Settings</button>
        </form>
    </div>

    <a href="profile.php">Back to Profile</a>
</body>
</html>
