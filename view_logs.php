<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php'); // Include your database connection file

// Fetch user details to check admin privileges
$user_id = $_SESSION['user_id'];
$sql = "SELECT is_admin FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (!$user['is_admin']) {
        echo "Access denied. You do not have permission to view this page.";
        exit();
    }
} else {
    echo "User not found.";
    exit();
}

// Handle log deletion
if (isset($_POST['delete_log'])) {
    $log_id_to_delete = $_POST['log_id'];

    // Delete the log from the database
    $delete_log_sql = "DELETE FROM logs WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_log_sql);
    $delete_stmt->bind_param("i", $log_id_to_delete);
    if ($delete_stmt->execute()) {
        echo "<p>Log deleted successfully.</p>";
    } else {
        echo "<p>Error deleting log.</p>";
    }
}

// Handle login attempt deletion
if (isset($_POST['delete_login_attempt'])) {
    $login_attempt_id_to_delete = $_POST['login_attempt_id'];

    // Delete the login attempt from the database
    $delete_login_attempt_sql = "DELETE FROM login_attempts WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_login_attempt_sql);
    $delete_stmt->bind_param("i", $login_attempt_id_to_delete);
    if ($delete_stmt->execute()) {
        echo "<p>Login attempt deleted successfully.</p>";
    } else {
        echo "<p>Error deleting login attempt.</p>";
    }
}

// Handle clearing all logs and login attempts
if (isset($_POST['clear_all'])) {
    // Delete all logs
    $clear_logs_sql = "DELETE FROM logs";
    $clear_logs_stmt = $conn->prepare($clear_logs_sql);
    $clear_logs_stmt->execute();

    // Delete all login attempts
    $clear_login_attempts_sql = "DELETE FROM login_attempts";
    $clear_login_attempts_stmt = $conn->prepare($clear_login_attempts_sql);
    $clear_login_attempts_stmt->execute();

    echo "<p>All logs and login attempts have been cleared.</p>";
}

// Pagination settings
$logs_per_page = 20;  // Number of logs per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $logs_per_page;

// Fetch system logs with pagination
$logs_sql = "SELECT logs.id, users.username, logs.action, logs.created_at 
             FROM logs 
             LEFT JOIN users ON logs.user_id = users.id 
             ORDER BY logs.created_at DESC
             LIMIT ? OFFSET ?";
$stmt = $conn->prepare($logs_sql);
$stmt->bind_param("ii", $logs_per_page, $offset);
$stmt->execute();
$logs_result = $stmt->get_result();

// Fetch login attempts with pagination
$login_attempts_sql = "SELECT login_attempts.id, login_attempts.username, login_attempts.ip_address, login_attempts.user_agent, login_attempts.success, login_attempts.attempt_time 
                       FROM login_attempts
                       ORDER BY login_attempts.attempt_time DESC
                       LIMIT ? OFFSET ?";
$stmt = $conn->prepare($login_attempts_sql);
$stmt->bind_param("ii", $logs_per_page, $offset);
$stmt->execute();
$login_attempts_result = $stmt->get_result();

// Fetch logout logs with pagination
$logout_logs_sql = "SELECT logs.id, users.username, logs.action, logs.created_at 
                    FROM logs
                    LEFT JOIN users ON logs.user_id = users.id
                    WHERE logs.action = 'Logged out'
                    ORDER BY logs.created_at DESC
                    LIMIT ? OFFSET ?";
$stmt = $conn->prepare($logout_logs_sql);
$stmt->bind_param("ii", $logs_per_page, $offset);
$stmt->execute();
$logout_logs_result = $stmt->get_result();

// Get total number of logs for pagination
$total_logs_sql = "SELECT COUNT(*) AS total FROM logs";
$total_logs_result = $conn->query($total_logs_sql);
$total_logs = $total_logs_result->fetch_assoc();
$total_pages = ceil($total_logs['total'] / $logs_per_page);

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Logs</title>
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #fff;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
        }

        tr:nth-child(even) {
            background-color: #222;
        }

        a {
            color: #00bfff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .back-btn {
            background-color: #00bfff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.2em;
            display: inline-block;
        }

        .back-btn:hover {
            background-color: #0099cc;
        }

        .pagination a {
            margin: 0 5px;
            color: #00bfff;
        }

        .delete-btn {
            background-color: #ff4d4d;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 1em;
            border: none;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #cc0000;
        }

        .clear-all-btn {
            background-color: #ff9a00;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1.2em;
            margin-top: 20px;
            display: inline-block;
            border: none;
            cursor: pointer;
        }

        .clear-all-btn:hover {
            background-color: #e68a00;
        }
    </style>
</head>
<body>
    <h1>System Logs</h1>

    <!-- Display System Logs -->
    <?php if ($logs_result->num_rows > 0) { ?>
        <h2>System Actions</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Action</th>
                    <th>Timestamp</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($log = $logs_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($log['id']); ?></td>
                        <td><?php echo htmlspecialchars($log['username'] ?? 'Unknown'); ?></td>
                        <td><?php echo htmlspecialchars($log['action']); ?></td>
                        <td><?php echo htmlspecialchars($log['created_at']); ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="log_id" value="<?php echo $log['id']; ?>">
                                <button type="submit" name="delete_log" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No system logs found.</p>
    <?php } ?>

    <!-- Display Login Attempt Logs -->
    <?php if ($login_attempts_result->num_rows > 0) { ?>
        <h2>Login Attempts</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>IP Address</th>
                    <th>User-Agent</th>
                    <th>Success</th>
                    <th>Attempt Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($attempt = $login_attempts_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($attempt['id']); ?></td>
                        <td><?php echo htmlspecialchars($attempt['username']); ?></td>
                        <td><?php echo htmlspecialchars($attempt['ip_address']); ?></td>
                        <td><?php echo htmlspecialchars($attempt['user_agent']); ?></td>
                        <td><?php echo $attempt['success'] ? 'Successful' : 'Failed'; ?></td>
                        <td><?php echo htmlspecialchars($attempt['attempt_time']); ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="login_attempt_id" value="<?php echo $attempt['id']; ?>">
                                <button type="submit" name="delete_login_attempt" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No login attempts found.</p>
    <?php } ?>

    <!-- Display Logout Logs -->
    <?php if ($logout_logs_result->num_rows > 0) { ?>
        <h2>Logout Logs</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Action</th>
                    <th>Timestamp</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($logout = $logout_logs_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($logout['id']); ?></td>
                        <td><?php echo htmlspecialchars($logout['username']); ?></td>
                        <td><?php echo htmlspecialchars($logout['action']); ?></td>
                        <td><?php echo htmlspecialchars($logout['created_at']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No logout logs found.</p>
    <?php } ?>

    <!-- Clear All Button -->
    <form method="POST" style="display:inline;">
        <button type="submit" name="clear_all" class="clear-all-btn">Clear All Logs & Login Attempts</button>
    </form>

    <!-- Pagination Controls -->
    <?php if ($total_pages > 1) { ?>
        <div class="pagination">
            <?php if ($page > 1) { ?>
                <a href="view_logs.php?page=<?php echo $page - 1; ?>">Previous</a>
            <?php } ?>
            <?php if ($page < $total_pages) { ?>
                <a href="view_logs.php?page=<?php echo $page + 1; ?>">Next</a>
            <?php } ?>
        </div>
    <?php } ?>

    <a href="profile.php" class="back-btn">Back to Profile</a>
</body>
</html>
