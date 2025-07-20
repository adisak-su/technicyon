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
    <title>เพิ่มการขาย | <?php echo $shopName; ?></title>

    <!-- Favicons -->
    <?php include_once('../../includes/pagesFavicons.php'); ?>

    <!-- stylesheet -->
    <?php include_once('../../includes/pagesStylesheet.php'); ?>

    <!-- Datatables -->
    <?php include_once('../../includes/pagesDatatableStylesheet.php'); ?>

    <link href="css/table.css?<?php echo time(); ?>" rel="stylesheet">
    <link href="https://printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet">
    <style>
        .dark-theme {
            background-color: #212121;
        }

        .custom-control-input {
            transform: scale(2.0);
        }

        .disabled {
            pointer-events: none;
            opacity: 0.4;
        }

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* .toggle .toggle-event .toggle-group {
            font-size: 1rem !important;
            height: auto !important;
        } */
    </style>

</head>

<body class="hold-transition sidebar-mini dark-mode">
    <div class="wrapper">
        <!-- Menu -->
        <?php include_once('../includes/sidebar.php') ?>
        <div class="content-wrapper">
            <div class="content-header">
                <!-- <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <div class="m-0 text-dark">ขายสินค้า</div>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">ข้อมูลการขาย</li>
                            </ol>
                        </div>
                    </div>
                </div> -->
            </div>
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="mr-auto my-font-size" style="line-height: 2.1rem" onclick="printDocument('pdfDocument');">ใบส่งของชั่วคราว</div>
                                    <button type="button" class="btn btn-success" id="print" data-id="${ID}" style="float: left;" onclick="printDocument('pdfDocument');">
                                        <i class="fa fa-print"></i>
                                    </button>
                                    <button type="button" onclick="printJS('<?php echo $fileName; ?>')">
                                        Print PDF
                                    </button>
                                    <a href="index.php" class="btn btn-warning btn-sm">กลับ</a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 center">
                                            <object data="<?php echo $fileName; ?>" type="application/pdf" width="650px" height="850px"></object>
                                            <!-- <object data="<?php echo $fileName; ?>" type="application/pdf" width="800px" height="850px"></object> -->
                                        </div>
                                        <div class="col-12 center">
                                            <embed type="application/pdf" src="<?php echo $fileName; ?>" id="pdfDocument" width="100%" height="100%">
                                            </embed>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

    <!-- OPTIONAL DataTable SCRIPTS -->
    <?php include_once('../../includes/pagesDatatableScript.php') ?>

    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

    <script type="text/javascript">
        function printDocument(documentId) {

            //Wait until PDF is ready to print
            if (typeof document.getElementById(documentId).print == 'undefined') {
                setTimeout(function() {
                    printDocument(documentId);
                }, 1000);
            } else {
                alert("before Print");
                var x = document.getElementById(documentId);
                x.print();
                alert("after Print");
            }
        }

        function btnPrint() {

        }
    </script>
    <script>
    </script>
</body>

</html>