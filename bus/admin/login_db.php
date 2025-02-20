<?php 
    session_start();
    include_once "config/functions.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if both username and password are provided
        if (empty($_POST['username']) || empty($_POST['password'])) {
            echo json_encode(['status' => 'error', 'message' => 'Username and password are required.']);
            exit;
        }

        // Get the data from the client
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        try {
            // Prepare the SQL statement to find the user
            $stmt = $con->prepare("SELECT * FROM admins WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            // Fetch the user
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Simple password check (without password hashing)
            if ($user && $password === $user['password']) {
                // Password matches, login success
                $_SESSION['adminid'] = $user['id'];
                echo json_encode(['status' => 'success', 'message' => 'Login successful!']);
            } else {
                // Invalid credentials
                echo json_encode(['status' => 'error', 'message' => 'Invalid username or password.']);
            }
        } catch (PDOException $e) {
            // Handle database connection error
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
?>
