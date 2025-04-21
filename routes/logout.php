<?php
session_start();
session_destroy(); // destroy all session data

// Redirect to the homepage or login page
header("Location: ../"); // change path if needed
exit();
?>
