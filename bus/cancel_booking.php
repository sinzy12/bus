<?php
include "condb.php"; // เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["user_n"])) {
    $user_n = $_POST["user_n"];

    // ตรวจสอบว่ามีข้อมูลในตาราง bus หรือ booking_report
    $check_sql = "SELECT COUNT(*) FROM bus WHERE user_n = :user_n";
    $check_stmt = $con->prepare($check_sql);
    $check_stmt->bindParam(":user_n", $user_n, PDO::PARAM_STR);
    $check_stmt->execute();
    $count_bus = $check_stmt->fetchColumn();

    $check_sql_report = "SELECT COUNT(*) FROM booking_report WHERE user_n = :user_n";
    $check_stmt_report = $con->prepare($check_sql_report);
    $check_stmt_report->bindParam(":user_n", $user_n, PDO::PARAM_STR);
    $check_stmt_report->execute();
    $count_report = $check_stmt_report->fetchColumn();

    if ($count_bus > 0 || $count_report > 0) {
        // ถ้ามีข้อมูลในตาราง bus หรือ booking_report ให้ลบข้อมูล
        if ($count_bus > 0) {
            $sql_bus = "DELETE FROM bus WHERE user_n = :user_n";
            $stmt_bus = $con->prepare($sql_bus);
            $stmt_bus->bindParam(":user_n", $user_n, PDO::PARAM_STR);
            $stmt_bus->execute();
        }

        if ($count_report > 0) {
            $sql_report = "DELETE FROM booking_report WHERE user_n = :user_n";
            $stmt_report = $con->prepare($sql_report);
            $stmt_report->bindParam(":user_n", $user_n, PDO::PARAM_STR);
            $stmt_report->execute();
        }

        echo json_encode(["success" => true, "message" => "ยกเลิกการจองสำเร็จ"]);
    } else {
        echo json_encode(["success" => false, "message" => "ไม่พบข้อมูลการจอง"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "กรุณากรอกชื่อก่อนยกเลิก"]);
}
?>
