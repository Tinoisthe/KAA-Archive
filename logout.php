<?php
// Start the session
session_start();

// Destroy all session data
session_unset();  // Remove all session variables
session_destroy();  // Destroy the session

// Send a script to the parent window to reload and redirect to the login page
echo '<script type="text/javascript">
        window.top.location.href = "login.php"; // Redirect parent to login page
      </script>';
?>
