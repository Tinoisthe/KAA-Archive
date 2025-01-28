<?php
include('db_connection.php'); // Include the database connection

// Fetch anime data from the database
$sql = "SELECT * FROM anime";
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Output the data for each row
    while ($row = $result->fetch_assoc()) {
        echo '<div class="anime">';
        echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
        echo '<img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['title']) . '">';
        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        echo '</div>';
    }
} else {
    echo "No anime found.";
}

// Close the database connection
$conn->close();
?>
