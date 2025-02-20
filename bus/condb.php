<?php
$host = 'localhost';  // ชื่อโฮสต์
$username = 'root';   // ชื่อผู้ใช้ฐานข้อมูล
$password = '';       // รหัสผ่าน
$dbname = 'bus';      // ชื่อฐานข้อมูล

try {
    // เชื่อมต่อฐานข้อมูลด้วย PDO
    $con = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // แสดงข้อความสำเร็จ (หากต้องการ)
    // echo "เชื่อมต่อฐานข้อมูลสำเร็จ!";
} catch (PDOException $e) {
    // แสดงข้อผิดพลาดเมื่อเชื่อมต่อไม่ได้
    die("ไม่สามารถเชื่อมต่อกับฐานข้อมูล: " . $e->getMessage());
}
?>
