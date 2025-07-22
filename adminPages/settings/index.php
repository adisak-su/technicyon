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
    <title>ระบบจัดการ | <?php echo $shopName; ?></title>
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
    <style>
        .container-input-label {
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        /* .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        } */

        .modal-header,
        .modal-footer {
            /* background-color: #f8f9fa; */
        }

        .modal-footer {
            /* background-color: #f8f9fa; */
            border: none;
        }

        .modal-header {
            border-radius: 25px 25px 0px 0px;
        }

        .modal-content {
            border-radius: 25px;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }

        .pagination .page-link {
            color: #0d6efd;
        }
    </style>
</head>

<body class="sidebar-collapse">
    <div class="wrapper">
        <!-- Menu -->
        <?php include_once('../includes/sidebar.php') ?>
        <div class="content-wrapper">
            <div class="content-header">
                <?php include_once("../menus/menuheader.php"); ?>
            </div>
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <label class="mr-auto" style="line-height: 2.1rem">รายการตั้งค่า</label>
                                </div>
                                <div class="card-body" style="font-size: 1rem;">
                                    <div class="container-fluid">
                                        <div class="glass-card mb-2">
                                            <form id="itemForm">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 col-lg-3 form-group position-relative mb-3">
                                                        <label for="itemTimeSync" class="form-label">เวลาในการ Sync ข้อมูล (วินาที)</label>
                                                        <div class="input-icon-wrapper" style="width:150px;">
                                                            <i class="fa fa-keyboard input-icon"></i>
                                                            <input
                                                                type="numner"
                                                                class="form-control"
                                                                id="itemTimeSync"
                                                                value="5"
                                                                placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                    <button type="button" class="btn btn-primary boxx" onclick="saveItem()">บันทึก</button>
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
        function saveItem() {
            try {
                const thisfrm = document.getElementById('itemForm');
                const itemTimeSync = thisfrm.elements.namedItem('itemTimeSync').value.trim();
                setStorage("itemTimeSync", {
                    itemTimeSync: itemTimeSync
                });
                sweetAlert(`ข้อมูลการตั้งค่าเวลาในการ Sync ข้อมูลเรียบร้อย`, 1500);
            } catch (error) {
                sweetAlertError(`ข้อมูลการตั้งค่าเวลาในการ Sync ข้อมูลเรียบร้อยผิดพลาด ${error.message}`,0);
            }

            // const thisfrm = document.getElementById('itemForm');
            // const itemTimeSync = thisfrm.elements.namedItem('itemTimeSync').value.trim();
            // setStorage("itemTimeSync", {
            //     itemTimeSync: itemTimeSync
            // });
        }

        $(document).ready(async function() {
            try {
                loaderScreen("show");
                let itemTimeSync = getStorage("itemTimeSync");
                let timeSync = 10; // 10 วินาที
                if (itemTimeSync) {
                    timeSync = itemTimeSync.itemTimeSync;
                }
                document.getElementById('itemTimeSync').value = timeSync
            } catch (error) {
                sweetAlertError("เกิดข้อผิดพลาด : " + error.message, 0);
            } finally {
                loaderScreen("hide");
            }

            $(function() {
                var focusedElement;
                $(document).on('focus', 'input', function() {
                    if (focusedElement == this) return;
                    focusedElement = this;
                    setTimeout(function() {
                        focusedElement.select();
                    }, 100);
                });
            });
        });
    </script>
</body>

</html>