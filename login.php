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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/adminlte.min.css">
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
                    } else {
                        message = `${resp.message}`;
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