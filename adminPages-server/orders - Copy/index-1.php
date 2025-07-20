<?php
require_once('../authen.php');
require_once("../../service/configData.php");
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ขายสินค้าหน้าร้าน | <?php echo $shopName; ?></title>
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.css">

    <!-- Favicons -->
    <?php include_once('../../includes/pagesFavicons.php'); ?>

    <!-- stylesheet -->
    <?php include_once('../../includes/pagesStylesheet.php'); ?>

    <link rel="stylesheet" href="../includes/headermenu.css?<?php echo time();?>">
    <style>
       
    </style>
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
                            <label class="m-0 text-dark">ขายสินค้าหน้าร้าน</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <label class="mr-auto" style="line-height: 2.1rem">รายการ</label>
                                    <a href="form-create.php" class="btn btn-primary btn-2px float-right"><i class="fa fa-plus"></i> เพิ่มขายสินค้า</a>
                                </div>
                                <div class="card-body">
                                    <!--
                                    <table id="logs" class="table table-hover table-bordered table-striped" width="100%">
                                    <table id="dataTable" class="table table-hover table-bordered table-responsive table-striped" width="100%">
                                    -->
                                    <table id="dataTable" class="table table-bordered" width="100%">

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
        $(document).ready(function() {
            loaderScreen("hide");
        });
    </script>
</body>
</html>