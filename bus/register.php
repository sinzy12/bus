<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียน</title>
    <link rel="stylesheet" href="register.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">แบรนด์</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active text-white" href="./index.html">หน้าแรก</a></li>
                    <li class="nav-item"><a class="nav-link" href="./about.html">ผู้จัดทำ</a></li>
                    <li class="nav-item"><a class="nav-link" href="./admin/login.php">สำหรับแอดมิน</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Registration Form -->
    <div class="wrapper">
        <form id="registerForm">
            <h1>ลงทะเบียน</h1>
            <div id="result" class="text-center" style="color: red; font-size: 14px;"></div>
            
            <div class="input-box">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            
            <div class="input-box">
                <input type="email" id="email" name="email" placeholder="Email" required>
                <i class='bx bxs-envelope'></i>
            </div>

            <div class="input-box">
                <input type="tel" id="tel" name="tel" placeholder="Phone Number" required>
                <i class='bx bxs-phone'></i>
            </div>

            <button type="submit" class="btn">ลงทะเบียน</button>
            <div class="register-link">
                <p> <a href="login.php">กลับสู่หน้า Login</a></p>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
    $(document).ready(function () {
        $('#registerForm').on('submit', function (e) {
            e.preventDefault(); // ป้องกันการรีเฟรชหน้า

            var username = $('#username').val().trim();
            var password = $('#password').val().trim();
            var email = $('#email').val().trim();
            var tel = $('#tel').val().trim();

            // ตรวจสอบว่าฟิลด์ทั้งหมดไม่ว่าง
            if (username === "" || password === "" || email === "" || tel === "") {
                Swal.fire({
                    title: "โปรดกรอกข้อมูลให้ครบ!",
                    text: "กรุณากรอกทุกช่องก่อนลงทะเบียน",
                    icon: "warning"
                });
                return;
            }

            $.ajax({
                url: 'register_db.php',
                type: 'POST',
                data: { username: username, password: password, email: email, tel: tel },
                dataType: 'json',
                success: function (data) {
                    Swal.fire({
                        title: data.status === "success" ? "สำเร็จ!" : "ล้มเหลว!",
                        text: data.msg,
                        icon: data.status === "success" ? "success" : "error"
                    }).then(() => {
                        if (data.status === "success") {
                            window.location.href = "login.php"; // Redirect ถ้าสำเร็จ
                        }
                    });
                },
                error: function () {
                    Swal.fire({
                        title: "เกิดข้อผิดพลาด!",
                        text: "ไม่สามารถลงทะเบียนได้ กรุณาลองใหม่",
                        icon: "error"
                    });
                }
            });
        });
    });
</script>

</body>
</html>
