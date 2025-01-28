
<?php
// Database connection settings
$servername = "localhost";  // Hostname, typically 'localhost' for local databases
$username = "anime";        // Your database username
$password = "1Maxwoof";      // Your database password
$dbname = "anime";          // Your database name (updated to 'anime')

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if logged-in user is admin
function isAdmin($userId) {
    global $conn;
    $sql = "SELECT is_admin FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($isAdmin);
    $stmt->fetch();
    $stmt->close();
    return $isAdmin == 1;
}
?>
