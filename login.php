<?php
    require_once("service/configData.php");
    session_start(); //ประกาศ การใช้งาน session
    session_destroy(); // ลบตัวแปร session ทั้งหมด
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login || <?php echo $shopName; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicons -->
    <?php include_once('includes/favicons.php'); ?>

    <!-- Favicons -->
    <!-- <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="assets/img/favicons/site.webmanifest">
    <link rel="mask-icon" href="assets/img/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="assets/img/favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="assets/img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff"> -->

    <!-- stylesheet -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Mali" rel="stylesheet"> -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet"> -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <!-- <link rel="stylesheet" href="assets/css/style.css"> -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

    <link rel="stylesheet" href="assets/css/style.css?<?php echo time(); ?>">
    
</head>

<body>
    <div class="bg"></div>
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
                                <label for="username">ชื่อผู้ใช้งาน</label>
                                <input type="text" id="username" name="username" class="form-control" placeholder="username" value="admin">
                            </div>

                            <div class="form-group">
                                <label for="password">รหัสผ่าน</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="password" value="123">
                            </div>

                            <button name="submit" class="btn btn-primary btn-block" type="submit" name="LoginBT" id="LoginBT"> เข้าสู่ระบบ</button>
                        </form>
                    </div>
                    <footer class="text-secondary text-center">
                        <!-- คลิกเข้าสู่ระบบได้ทันที (โหมดทดสอบไม่มีฐานข้อมูล) <span class="text-pink">♥️</span> -->
                    </footer>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/toastr/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            /**
             * Form Login Ajax
             */
            $("#formData").submit(function(e) {
                e.preventDefault()
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


                        // if(resp.permission === "admin" || resp.permission === "superadmin") {
                        //     setTimeout(() => {
                        //         window.location.href = 'pages/dashboard'
                        //     }, 800);
                        // } else {
                        //     setTimeout(() => {
                        //         window.location.href = 'pos/'
                        //     }, 800);
                        // }
                    } else {
                        message = `${resp.message}`;
                        // toastr.error("มีข้อผิดพลาดเกินขึ้น โปรดติดต่อผู้ดูแลระบบ : message", {
                        toastr.error(message, {
                            timeOut: 100,
                            closeOnHover: true
                        });
                    }
                })
            })
        })
    </script>

</body>

</html>