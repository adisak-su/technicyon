<?php
require_once('../authen.php');
require_once("../../service/configData.php");

$fileName = $_REQUEST["fileName"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>จัดการรายการขาย | <?php echo $shopName; ?></title>

    <!-- Favicons -->
    <?php include_once('../../includes/pagesFavicons.php'); ?>

    <!-- stylesheet -->
    <?php include_once('../../includes/pagesStylesheet.php'); ?>

    <!-- Datatables -->
    <?php include_once('../../includes/pagesDatatableStylesheet.php'); ?>

    <style>
    </style>

</head>

<body class="hold-transition sidebar-mini dark-mode">
    <div class="wrapper">
        <!-- Menu -->
        <?php include_once('../includes/sidebar.php') ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <label class="m-0 text-dark">รายงานใบส่งสินค้า</label>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <a href="index.php" class="btn btn-warning btn-sm">กลับหน้าหลัก</a>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                <object data="<?php echo 'pdf/'.$fileName; ?>" type="application/pdf" width="100%" height="750px"></object>
                <!-- <object data="<?php echo "pdf/".$fileName; ?>" type="application/pdf" width="600px" height="850px"></object> -->
                </div>
            </div>
        </div>

        <!-- Main Footer -->
        <?php include_once('../includes/footer.php') ?>
        <!-- <?php include_once('../../includes/loading.php') ?> -->
    </div>

    <!-- SCRIPTS -->
    <?php include_once('../../includes/pagesScript.php') ?>
    <?php include_once('../../includes/myScript.php') ?>


    <script type="text/javascript">
        
    </script>
</body>

</html>