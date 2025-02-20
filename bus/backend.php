<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบการยกเลิกการจอง
    if (isset($_POST['cancel'])) {
        $route = $_POST['route'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $seats = $_POST['seats'];
        $user_n = $_POST['user_n'];
        $Slip = $_POST['Slip'];

        // เชื่อมต่อฐานข้อมูล
        $con = new mysqli("localhost", "root", "", "bus");
        if ($con->connect_error) {
            die("Database connection failed: " . $con->connect_error);
        }

        // ลบการจองจากตาราง `bus`
        $deleteQuery = "DELETE FROM bus WHERE route = ? AND date = ? AND time = ? AND seats = ? AND user_n = ?";
        $stmt = $con->prepare($deleteQuery);

        if ($stmt) {
            $stmt->bind_param("sssss", $route, $date, $time, $seats, $user_n);
            if ($stmt->execute()) {
                echo "ยกเลิกการจองสำเร็จ";
            } else {
                echo "เกิดข้อผิดพลาดในการยกเลิกการจอง: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "ไม่สามารถเตรียมคำสั่ง SQL ได้: " . $con->error;
        }

        // ปิดการเชื่อมต่อฐานข้อมูล
        $con->close();
    } else if (isset($_POST['route'], $_POST['date'], $_POST['time'], $_POST['seats'], $_POST['user_n'])) {
        // ตรวจสอบการจอง
        $route = $_POST['route'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $seats = $_POST['seats'];
        $user_n = $_POST['user_n'];

        // อัปโหลดไฟล์ Slip
        if (isset($_FILES['Slip']) && $_FILES['Slip']['error'] == 0) {
            $target_dir = "uploads/";  // โฟลเดอร์ที่เก็บไฟล์
            $target_file = $target_dir . basename($_FILES["Slip"]["name"]);
            if (move_uploaded_file($_FILES["Slip"]["tmp_name"], $target_file)) {
                $Slip = $target_file;  // เก็บที่อยู่ไฟล์
            } else {
                echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์";
                exit;
            }
        } else {
            echo "กรุณาอัปโหลดไฟล์ Slip";
            exit;
        }

        // เชื่อมต่อฐานข้อมูล
        $con = new mysqli("localhost", "root", "", "bus");
        if ($con->connect_error) {
            die("Database connection failed: " . $con->connect_error);
        }

        // ตรวจสอบการจองซ้ำ
        $checkQuery = "SELECT * FROM bus WHERE route = ? AND date = ? AND time = ? AND seats = ?";
        $stmt = $con->prepare($checkQuery);

        if ($stmt) {
            $stmt->bind_param("ssss", $route, $date, $time, $seats);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row['user_n'] == $user_n) {
                    echo "คุณได้จองที่นั่งนี้ไว้แล้ว";
                } else {
                    echo "ที่นั่งนี้มีคนจองแล้ว";
                }
            } else {
                // บันทึกข้อมูลการจองใหม่
                $insertQuery = "INSERT INTO bus (route, date, time, user_n, seats) VALUES (?, ?, ?, ?, ?)";
                $insertStmt = $con->prepare($insertQuery);

                if ($insertStmt) {
                    $insertStmt->bind_param("sssss", $route, $date, $time, $user_n, $seats);
                    if ($insertStmt->execute()) {
                        // บันทึกข้อมูลลงใน booking_report
                        $insertReportQuery = "INSERT INTO booking_report (route, date, time, user_n, seats, Slip) VALUES (?, ?, ?, ?, ?, ?)";
                        $insertReportStmt = $con->prepare($insertReportQuery);

                        if ($insertReportStmt) {
                            $insertReportStmt->bind_param("ssssss", $route, $date, $time, $user_n, $seats, $Slip);  // รวม $Slip
                            if ($insertReportStmt->execute()) {
                                echo "จองสำเร็จ";
                            } else {
                                echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลใน booking_report: " . $insertReportStmt->error;
                            }
                            $insertReportStmt->close();
                        } else {
                            echo "ไม่สามารถเตรียมคำสั่ง SQL สำหรับ booking_report ได้: " . $con->error;
                        }
                        $insertStmt->close();
                    } else {
                        echo "เกิดข้อผิดพลาดในการบันทึกการจอง: " . $insertStmt->error;
                    }
                } else {
                    echo "ไม่สามารถเตรียมคำสั่ง SQL ได้: " . $con->error;
                }
            }
            $stmt->close();
        } else {
            echo "ไม่สามารถเตรียมคำสั่ง SQL ได้: " . $con->error;
        }

        // ปิดการเชื่อมต่อฐานข้อมูล
        $con->close();
    }
}
?>
