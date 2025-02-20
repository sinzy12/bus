<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['Slip']) && $_FILES['Slip']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // โฟลเดอร์ที่ใช้เก็บสลิป
        $fileName = basename($_FILES['Slip']['name']);
        $fileTmpPath = $_FILES['Slip']['tmp_name'];
        $fileSize = $_FILES['Slip']['size'];
        $fileType = $_FILES['Slip']['type'];
        
        // กำหนดประเภทไฟล์ที่อนุญาต
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        
        if (in_array($fileType, $allowedTypes)) {
            $newFileName = uniqid('slip_', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destination)) {
                echo json_encode(['status' => 'success', 'message' => 'อัปโหลดสลิปสำเร็จ!', 'file' => $newFileName]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกไฟล์']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ไฟล์ที่อัปโหลดไม่ได้รับอนุญาต']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไม่มีไฟล์ที่ถูกอัปโหลด']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ไม่รองรับการเข้าถึง']);
}
?>
