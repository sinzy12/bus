<?php 
session_start();
include_once "config/functions.php";

// ตรวจสอบการเข้าสู่ระบบของ admin
if (!isset($_SESSION['adminid'])) {
    header("Location: login.php");
    exit();
}

// เชื่อมต่อฐานข้อมูลด้วย PDO (เพิ่มความปลอดภัย)
try {
    $dsn = 'mysql:host=localhost;dbname=bus;charset=utf8';
    $username = 'root';
    $password = '';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $con = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// โค้ดจัดการการยกเลิกการจอง
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_id'])) {
    $cancelId = $_POST['cancel_id'];  // รับค่า cancel_id จากฟอร์ม

    try {
        // ลบการจองจากฐานข้อมูล
        $cancelSql = "DELETE FROM booking_report WHERE report_id = :id";
        $stmtCancel = $con->prepare($cancelSql);
        $stmtCancel->execute(['id' => $cancelId]);

        // แสดงข้อความเมื่อการยกเลิกสำเร็จ
        echo "<script>alert('ยกเลิกการจองสำเร็จ!'); window.location.href = 'index.php';</script>";
    } catch (PDOException $e) {
        // หากเกิดข้อผิดพลาด
        echo "<script>alert('เกิดข้อผิดพลาด: " . $e->getMessage() . "');</script>";
    }
}

// ดึงข้อมูลการจองจากฐานข้อมูล
$sql = "SELECT * FROM booking_report"; 
$stmt = $con->prepare($sql);
$stmt->execute();
$bookings = $stmt->fetchAll();

// ดึงข้อมูล admin จากฐานข้อมูล
$adminId = $_SESSION['adminid'];
$sqlAdmin = "SELECT * FROM admins WHERE id = :adminId";
$stmtAdmin = $con->prepare($sqlAdmin);
$stmtAdmin->execute(['adminId' => $adminId]);
$adminData = $stmtAdmin->fetch();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard - Bus Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">Bus Booking</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user fa-fw"></i> <?php echo htmlspecialchars($adminData['username']); ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="login.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as: <?php echo htmlspecialchars($adminData['username']); ?></div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">ตารางการจอง</h1>
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                <div>
        <i class="fas fa-table me-1"></i>
        Booking Report
    </div>
    <input type="text" id="searchInput" class="form-control w-25" placeholder="ค้นหาชื่อ...">
</div>
                        <div class="card-body">
                            <?php if (!empty($bookings)): ?>
                                <table id="datatablesSimple" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Report ID</th>
                                            <th>รอบรถ</th>
                                            <th>วัน</th>
                                            <th>เวลา</th>
                                            <th>ที่นั่ง</th>
                                            <th>ชื่อ</th>
                                            <th>เวลาที่กดจอง</th>
                                            <th>สลิปการโอนเงิน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
    <?php foreach ($bookings as $booking): ?>
        <tr>
            <td><?php echo htmlspecialchars($booking['report_id']); ?></td>
            <td><?php echo htmlspecialchars($booking['route']); ?></td>
            <td><?php echo htmlspecialchars($booking['date']); ?></td>
            <td><?php echo htmlspecialchars($booking['time']); ?></td>
            <td><?php echo htmlspecialchars($booking['seats']); ?></td>
            <td><?php echo htmlspecialchars($booking['user_n']); ?></td>
            <td><?php echo htmlspecialchars($booking['booking_time']); ?></td>
             <td>
                <?php if (!empty($booking['Slip'])): ?>
            <form action="/bus/<?php echo htmlspecialchars($booking['Slip']); ?>" method="get" target="_blank" style="display: inline;">
        <button type="submit" class="btn  btn-success btn-sm">ดูสลิป</button>
            </form>
        <?php else: ?>
            <button type="button" class="btn btn-secondary btn-sm" disabled>ไม่มีสลิป</button>
        <?php endif; ?>

            </td>
            <td>
                <!-- ปุ่มยกเลิก -->
                <form method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการยกเลิกการจองนี้?');">
                    <input type="hidden" name="cancel_id" value="<?php echo htmlspecialchars($booking['report_id']); ?>">
                    <button type="submit" class="btn btn-danger btn-sm">ยกเลิก</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

                                </table>
                            <?php else: ?>
                                <p>No bookings found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Bus Booking 2024</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script>
    document.getElementById("searchInput").addEventListener("keyup", function () {
        var value = this.value.toLowerCase();
        var rows = document.querySelectorAll("#datatablesSimple tbody tr");

        rows.forEach(function (row) {
            var name = row.cells[5].textContent.toLowerCase(); // ช่องที่ 6 (index 5) คือชื่อผู้จอง
            if (name.includes(value)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>

</body>
</html>
