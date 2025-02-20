<?php 

    session_start();
    include_once "condb.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the data from the client
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare the SQL statement to find the user
        $stmt = $con->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Fetch the user
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['adminid'] = $user['id'];
            // Password matches, login success
            echo json_encode(['status' => 'success', 'message' => 'Login successful!']);
        } else {
            // Invalid credentials
            echo json_encode(['status' => 'error', 'message' => 'Invalid username or password.']);
        }
    }

?>