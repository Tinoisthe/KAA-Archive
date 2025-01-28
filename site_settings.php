<?php
session_start();

include('db_connection.php'); // Include your database connection file

// Redirect to login if the user is not logged in or not an admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

// Fetch current site settings from the database
$sql = "SELECT * FROM site_settings WHERE id = 1"; // Assume site_settings table has an ID column
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $settings = $result->fetch_assoc();
} else {
    $error_message = "No site settings found.";
}

// Handle updating site settings
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save_settings'])) {
        $site_name = $_POST['site_name'];
        $site_theme = $_POST['site_theme'];

        // Update settings in the database
        $update_sql = "UPDATE site_settings SET site_name = ?, site_theme = ? WHERE id = 1";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ss", $site_name, $site_theme);
        
        if (!$update_stmt->execute()) {
            $error_message = "Failed to update site settings: " . $update_stmt->error;
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

        .form-container {
            margin: 20px;
        }

        input[type="text"], select {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            border: 1px solid #333;
            background-color: #222;
            color: #fff;
        }

        button {
            background-color: #00bfff;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 1em;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0099cc;
        }

        .error-message {
            color: #ff4d4d;
        }
    </style>
</head>
<body>
    <h1>Site Settings</h1>

    <?php if (isset($error_message)) { echo '<p class="error-message">' . $error_message . '</p>'; } ?>

    <div class="form-container">
        <form method="POST">
            <label for="site_name">Site Name:</label>
            <input type="text" name="site_name" id="site_name" value="<?php echo htmlspecialchars($settings['site_name']); ?>" required>

            <label for="site_theme">Site Theme:</label>
            <select name="site_theme" id="site_theme">
                <option value="light" <?php echo ($settings['site_theme'] == 'light') ? 'selected' : ''; ?>>Light</option>
                <option value="dark" <?php echo ($settings['site_theme'] == 'dark') ? 'selected' : ''; ?>>Dark</option>
            </select>

            <button type="submit" name="save_settings">Save Settings</button>
        </form>
    </div>

    <a href="profile.php" class="button">Back to Profile</a>
</body>
</html>
