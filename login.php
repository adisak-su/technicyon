<?php
require_once("service/configData.php");
// //ประกาศ การใช้งาน session
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
// session_destroy(); // ลบตัวแปร session ทั้งหมด
// define('HTTP_COOKIE_NAME', 'technicyon_auth_token');
// setcookie(HTTP_COOKIE_NAME, '', time() - 3600, '/');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login || <?php echo $shopName; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicons -->
    <?php include_once('includes/favicons.php'); ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css?<?php echo time(); ?>">
    <style>
        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #7f8c8d;
            z-index: 2;
        }
    </style>
</head>

<body>
    <div class="bg">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-6">
                    <div class="card shadow p-3">
                        <div class="card-header">
                            <h3 class="text-center font-weight-bold"><?php echo $shopName; ?></h3>
                        </div>
                        <div class="card-body">
                            <form id="formData">
                                <div class="form-group">
                                    <label for="username"><i class="fas fa-user"></i> ชื่อผู้ใช้งาน</label>
                                    <input type="text" id="username" name="username" class="form-control" placeholder="username" value="admin">
                                </div>

                                <div class="form-group">
                                    <label for="password"><i class="fas fa-key"></i> รหัสผ่าน</label>
                                    <div class="password-container">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="password" value="123">
                                        <span class="toggle-password" onclick="togglePassword()">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <button name="submit" class="btn btn-primary btn-block boxx" type="submit" name="LoginBT" id="LoginBT"> เข้าสู่ระบบ</button>
                            </form>
                        </div>
                        <footer class="text-secondary text-center">
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SCRIPTS -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/toastr/toastr.min.js"></script>
    <script src="plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            checkAuth();
            /**
             * Form Login Ajax
             */
            $("#formData").submit(function(e) {
                e.preventDefault()
                const waitingPopup = Swal.fire({
                    title: "Signing in...",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });
                $.ajax({
                    type: "POST",
                    url: "service/login.php",
                    data: $('#formData').serialize()
                }).done(function(resp) {
                    /**
                     * Authentication...
                     */
                    if (resp.status) {
                        toastr.success('เข้าสู่ระบบเรียบร้อย');
                        setTimeout(() => {
                            window.location.href = 'index.php'
                        }, 800);
                    } else {
                        message = `${resp.message}`;
                        toastr.error(message, {
                            timeOut: 100,
                            closeOnHover: true
                        });
                        Swal.fire({
                            icon: "error",
                            title: "Login Failed",
                            text: message,
                            timer: 3000,
                        });
                    }
                }).fail(function(xhr) {
                    let error = "An error occurred";
                    try {
                        const res = JSON.parse(xhr.responseText);
                        error = res.message || error;
                    } catch (e) {}

                    Swal.fire({
                        icon: "error",
                        title: "Login Failed",
                        text: error,
                    });
                }).always(function() {
                    waitingPopup.close();
                });
            })
        });

        // ฟังก์ชันแสดง/ซ่อนรหัสผ่าน
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('.toggle-password i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        function checkAuth() {
            $.ajax({
                url: "service/checkAuth.php",
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.redirect;
                    }
                },
                error: function(xhr) {
                    let error = "An error occurred";
                    try {
                        const res = JSON.parse(xhr.responseText);
                        error = res.error || error;
                    } catch (e) {}

                    Swal.fire({
                        icon: "error",
                        title: "Login Failed",
                        text: error,
                    });
                },
            });
        }


        function checkEnter(event) {
            //alert(event.keyCode);
            if (event.key === 'Enter' || event.keyCode === 13 || event.which === 13) {
                // Your code here - what you want to happen when Enter is pressed
                alert("Enter key was pressed");
            }
        }
    </script>

</body>

</html>