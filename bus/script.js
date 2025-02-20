function checkLogin(event) {
    // ตรวจสอบสถานะการล็อคอินใน sessionStorage
    let isLoggedIn = sessionStorage.getItem('loggedIn');

    if (!isLoggedIn) {
        event.preventDefault(); // ยกเลิกการดำเนินการของลิงค์
        alert("กรุณาล็อคอินก่อนจองตั๋วรถเมล์");
        window.location.href = "./login.php"; // ไปที่หน้าล็อคอิน
    }
}

document.getElementById("bookingForm").addEventListener("submit", function (event) {
    event.preventDefault(); // ป้องกันการส่งฟอร์มแบบปกติ

    // รับค่าจากฟอร์ม
    const route = document.getElementById("route").value;
    const date = document.getElementById("date").value;
    const time = document.getElementById("time").value;
    const seats = document.getElementById("seats").value;
    const user_n = document.getElementById("user_n").value;

    // ตรวจสอบว่ามีค่า time หรือไม่
    if (!time) {
        document.getElementById("confirmationMessage").innerText = "กรุณาเลือกเวลา";
        return; // หยุดการส่งข้อมูลหากไม่มีเวลา
    }

    // สร้าง FormData object
    const formData = new FormData();
    formData.append("route", route);
    formData.append("date", date);
    formData.append("time", time);  // ส่ง time
    formData.append("seats", seats);
    formData.append("user_n", user_n);
    // ส่งข้อมูลไปยัง backend.php
    fetch('backend.php', {
        method: 'POST',
        body: formData // ส่งข้อมูลด้วย FormData
    })
        .then(response => response.text())  // แปลงข้อมูลที่ตอบกลับจากเซิร์ฟเวอร์เป็นข้อความ
        .then(data => {
            // แสดงข้อความที่ได้รับจาก PHP
            document.getElementById("confirmationMessage").innerText = data;
        })
        .catch(error => {
            console.error('เกิดข้อผิดพลาด:', error);
            document.getElementById("confirmationMessage").innerText = "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง";
        });
});
document.getElementById("bookingForm").addEventListener("submit", function (event) {
    event.preventDefault();  // ป้องกันการรีเฟรชหน้าเมื่อส่งฟอร์ม

    const formData = new FormData(this);

    fetch('process_booking.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            document.getElementById("confirmationMessage").innerHTML = data; // แสดงข้อความ
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

document.getElementById('cancelBooking').addEventListener('click', function () {
    var username = document.getElementById('user_n').value;
    var route = document.getElementById('route').value;
    var time = document.getElementById('time').value;
    var date = document.getElementById('date').value;

    if (!username || !route || !time || !date) {
        alert("กรุณากรอกข้อมูลให้ครบก่อนยกเลิกการจอง");
        return;
    }

    if (!confirm("คุณแน่ใจหรือไม่ว่าต้องการยกเลิกการจองนี้?")) return;

    fetch('cancel_booking.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `user_n=${username}&route=${route}&time=${time}&date=${date}`
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === "success") {
                document.getElementById('bookingForm').reset();
                document.getElementById('confirmationMessage').innerHTML = "";
            }
        })
        .catch(error => console.error('Error:', error));
});



document.getElementById("submit_button").disabled = true; // Disable submit button
document.getElementById("bookingForm").submit(); // Submit form

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("cancelBooking").addEventListener("click", function () {
        let userName = document.getElementById("user_n").value;

        if (userName.trim() === "") {
            alert("กรุณากรอกชื่อก่อนยกเลิกการจอง");
            return;
        }

        if (confirm("คุณแน่ใจหรือไม่ว่าต้องการยกเลิกการจอง?")) {
            fetch("cancel_booking.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "user_n=" + encodeURIComponent(userName),
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        document.getElementById("bookingForm").reset();
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    });
});

