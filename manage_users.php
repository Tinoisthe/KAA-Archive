<?php
session_start();

include('db_connection.php'); // Include your database connection file

// Check if the session is properly set and user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    // Log this issue to the server's error log for debugging
    error_log('Session not set or user is not an admin. Redirecting to login.');

    header("Location: login.php");
    exit();
}

// Fetch all users from the database
$sql = "SELECT id, username, uid, created_at, is_admin FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $error_message = "No users found.";
}

// Function to log actions
function log_action($user_id, $action) {
    global $conn;
    $log_sql = "INSERT INTO logs (user_id, action) VALUES (?, ?)";
    $log_stmt = $conn->prepare($log_sql);
    $log_stmt->bind_param("is", $user_id, $action);
    $log_stmt->execute();
}

// Handle delete, status change, username update, and password reset requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_user'])) {
        $user_id_to_delete = $_POST['user_id'];

        // Start a transaction to ensure both operations (deleting login attempts and deleting user) are atomic
        $conn->begin_transaction();

        try {
            // Step 1: Delete associated login attempts
            $delete_attempts_sql = "DELETE FROM login_attempts WHERE user_id = ?";
            $stmt = $conn->prepare($delete_attempts_sql);
            $stmt->bind_param("i", $user_id_to_delete);
            $stmt->execute();

            // Step 2: Delete the user
            $delete_sql = "DELETE FROM users WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $user_id_to_delete);
            $delete_stmt->execute();

            // Commit the transaction
            $conn->commit();

            // Log the action
            log_action($_SESSION['user_id'], "Deleted user ID: $user_id_to_delete at " . date('Y-m-d H:i:s'));

            // Redirect after successful deletion
            header("Location: manage_users.php");
            exit();
        } catch (mysqli_sql_exception $e) {
            // If an error occurs, roll back the transaction
            $conn->rollback();
            $error_message = "Error deleting user: " . $e->getMessage();
        }
    } elseif (isset($_POST['toggle_admin'])) {
        $user_id_to_toggle = $_POST['user_id'];
        $toggle_admin_sql = "UPDATE users SET is_admin = NOT is_admin WHERE id = ?";
        $toggle_admin_stmt = $conn->prepare($toggle_admin_sql);
        $toggle_admin_stmt->bind_param("i", $user_id_to_toggle);
        if (!$toggle_admin_stmt->execute()) {
            $error_message = "Failed to update user status: " . $toggle_admin_stmt->error;
        } else {
            // Log the action
            log_action($_SESSION['user_id'], "Toggled admin status for user ID: $user_id_to_toggle at " . date('Y-m-d H:i:s'));
            // Redirect after successful update
            header("Location: manage_users.php");
            exit();
        }
    } elseif (isset($_POST['update_username'])) {
        // Update the username
        $new_username = $_POST['new_username'];
        $user_id_to_update = $_POST['user_id'];

        // Ensure the new username is not empty and valid
        if (empty($new_username)) {
            $error_message = "Username cannot be empty.";
        } else {
            // Check if the new username already exists
            $check_username_sql = "SELECT id FROM users WHERE username = ? AND id != ?";
            $check_username_stmt = $conn->prepare($check_username_sql);
            $check_username_stmt->bind_param("si", $new_username, $user_id_to_update);
            $check_username_stmt->execute();
            $check_username_stmt->store_result();

            if ($check_username_stmt->num_rows > 0) {
                $error_message = "The username is already taken.";
            } else {
                $update_username_sql = "UPDATE users SET username = ? WHERE id = ?";
                $update_username_stmt = $conn->prepare($update_username_sql);
                $update_username_stmt->bind_param("si", $new_username, $user_id_to_update);
                if (!$update_username_stmt->execute()) {
                    $error_message = "Failed to update username: " . $update_username_stmt->error;
                } else {
                    // Log the action
                    log_action($_SESSION['user_id'], "Updated username for user ID: $user_id_to_update to $new_username at " . date('Y-m-d H:i:s'));
                    // Redirect after successful update
                    header("Location: manage_users.php");
                    exit();
                }
            }
        }
    } elseif (isset($_POST['reset_password'])) {
        // Reset the password
        $new_password = $_POST['new_password'];
        $user_id_to_reset = $_POST['user_id'];

        // Validate password (ensure it's not empty and meets certain criteria)
        if (empty($new_password) || strlen($new_password) < 8 || !preg_match('/[0-9]/', $new_password) || !preg_match('/[\W_]/', $new_password)) {
            $error_message = "Password must be at least 8 characters long, and include at least one number and one special character.";
        } else {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password in the database
            $reset_password_sql = "UPDATE users SET password = ? WHERE id = ?";
            $reset_password_stmt = $conn->prepare($reset_password_sql);
            $reset_password_stmt->bind_param("si", $hashed_password, $user_id_to_reset);
            if (!$reset_password_stmt->execute()) {
                $error_message = "Failed to reset password: " . $reset_password_stmt->error;
            } else {
                // Log the action
                log_action($_SESSION['user_id'], "Reset password for user ID: $user_id_to_reset at " . date('Y-m-d H:i:s'));
                // Redirect after successful password reset
                header("Location: manage_users.php");
                exit();
            }
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
    <title>Manage Users</title>
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

        .user-table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }

        .user-table th, .user-table td {
            border: 1px solid #fff;
            padding: 10px;
            text-align: center;
        }

        .user-table th {
            background-color: #333;
        }

        .user-table tr:nth-child(even) {
            background-color: #444;
        }

        .button {
            background-color: #00bfff;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1em;
        }

        .button:hover {
            background-color: #0099cc;
        }

        .error-message {
            color: #ff4d4d;
        }

        .form-container {
            margin: 20px;
        }

        input[type="text"], input[type="password"] {
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
    </style>
</head>
<body>
    <h1>Manage Users</h1>

    <?php if (isset($error_message)) { echo '<p class="error-message">' . $error_message . '</p>'; } ?>

    <table class="user-table">
        <thead>
            <tr>
                <th>Username</th>
                <th>User ID (UID)</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['uid']); ?></td>
                <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                <td><?php echo $user['is_admin'] ? 'Admin' : 'User'; ?></td>
                <td>
                    <!-- Toggle Admin Status -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <button type="submit" name="toggle_admin" class="button">
                            <?php echo $user['is_admin'] ? 'Revoke Admin' : 'Make Admin'; ?>
                        </button>
                    </form>
                    
                    <!-- Delete User -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <button type="submit" name="delete_user" class="button">Delete</button>
                    </form>

                    <!-- Update Username -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <input type="text" name="new_username" placeholder="New Username" required>
                        <button type="submit" name="update_username" class="button">Update Username</button>
                    </form>

                    <!-- Reset Password -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <input type="password" name="new_password" placeholder="New Password" required>
                        <button type="submit" name="reset_password" class="button">Reset Password</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <form action="profile.php" method="GET" style="margin-top: 20px;">
        <button type="submit" class="button">Go back to Profile</button>
    </form>
</body>
</html>
