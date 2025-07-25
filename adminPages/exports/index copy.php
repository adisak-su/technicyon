<?php
// check login token in page php
require_once('../authen.php');

require_once("../../assets/php/common.php");
require_once("../../service/configData.php");
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการยี่ห้อ/รุ่นรถยนต์ | <?php echo $shopName; ?></title>
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.css">

    <!-- Favicons -->
    <?php include_once('../../includes/pagesFavicons.php'); ?>

    <!-- stylesheet -->
    <?php include_once('../../includes/pagesStylesheet.php'); ?>

    <!-- Font Awesome 6 (Free CDN) -->
    <!-- <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" /> -->

    <!-- <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css"> -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/6.5.0.all.min.css">
    <link rel="stylesheet" href="../menus/menuheader.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">
    <style>

    </style>

</head>

<body class="sidebar-collapse">
    <div class="wrapper">
        <!-- Menu -->
        <?php include_once('../includes/sidebar.php') ?>
        <div class="content-wrapper">
            <div class="content-header">
                <?php include_once("../menus/menuheader.php"); ?>
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <label class="m-0 text-dark">จัดการยี่ห้อ/รุ่นรถยนต์</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">

                </div>
            </div>
        </div>
        <!-- Main Footer -->
        <?php include_once('../includes/footer.php') ?>
        <?php include_once('../../includes/loading.php') ?>
    </div>


    <!-- SCRIPTS -->
    <?php include_once('../../includes/pagesScript.php') ?>
    <?php include_once('../../includes/myScript.php') ?>

    <script type="text/javascript">
        $(document).ready(async function() {
            try {
                loaderScreen("show");
            } catch (error) {
                sweetAlertError("เกิดข้อผิดพลาด : " + error.message, 0);
            } finally {
                loaderScreen("hide");
            }

        });
    </script>
</body>

</html>