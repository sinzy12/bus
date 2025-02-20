<?php
session_start();

// Destroy all session data (log out the user)
session_unset();
session_destroy();

// Send a success response to the client
echo json_encode(['status' => 'success', 'message' => 'Logged out successfully!']);

?>
