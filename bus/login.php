<!doctype html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จองที่นั่งเมล์</title>
    <!-- ลิ้ง CSS -->
    <link rel="stylesheet" href="login.css">
    <!-- boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- รวม Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

    <body>
        <!-- ส่วนของ Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand  text-white" href="#">แบรนด์</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active  text-white" aria-current="page" href="./index.html">หน้าแรก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./about.html">ผู้จัดทำ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./admin/login.php">สำหรับแอดมิน</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
        
        <div class="wrapper">
        <form id="loginForm">
            <h1>Login</h1>
            <div id="result" class="text-center" style="color: red; font-size: 14px;"></div>
            <div class="input-box">
                <input type="text" id="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" id="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register-link">
                <p>ไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
            </div>
        </form>
    </div>
        <footer>
            <!-- place footer here -->
        </footer>

        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"

            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>

        <script>
            $(document).ready(function() {
                $('#loginForm').on('submit', function(e) {
                    e.preventDefault();

                    // Gather form data
                    var username = $('#username').val();
                    var password = $('#password').val();

                    // Send AJAX request to the server
                    $.ajax({
                        url: 'login_db.php',
                        type: 'POST',
                        data: {
                            username: username,
                            password: password
                        },
                        dataType: 'json',
                        success: function (data) {
                    Swal.fire({
                        title: data.status === "success" ? "ล็อกอินสำเร็จ!" : "username หรือ Password ไม่ถูกต้อง!",
                        text: data.msg,
                        icon: data.status === "success" ? "success" : "error"
                    }).then(() => {
                        if (data.status === "success") {
                            window.location.href = "bus.php"; // Redirect ถ้าสำเร็จ
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
