<?php
// เชื่อมต่อฐานข้อมูล
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'bus'; // เปลี่ยนชื่อฐานข้อมูลตามจริง

$conn = new mysqli($host, $user, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'เชื่อมต่อฐานข้อมูลล้มเหลว']));
}

// รับข้อมูลจาก AJAX
$username = $_POST['username'] ;
$password = $_POST['password'] ;
$email = $_POST['email'];
$tel = $_POST['tel'] ;

// ตรวจสอบข้อมูลที่ส่งมา
if (!$username || empty($password) || empty($email) || empty($tel)) {
    echo json_encode(['status' => 'error', 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
    exit;
}

// ตรวจสอบว่ามี username ซ้ำหรือไม่
$sql_check = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Username นี้มีอยู่แล้ว']);
    exit;
}

// บันทึกข้อมูลลงฐานข้อมูล
$sql_insert = "INSERT INTO users (username, password, email, tel) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert);
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$stmt->bind_param("ssss", $username, $hashed_password, $email, $tel);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'ลงทะเบียนสำเร็จ']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถลงทะเบียนได้']);
}

$conn->close();
?>
