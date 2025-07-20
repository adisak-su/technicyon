<?php
require_once('../authen.php');
require_once("../../service/configData.php");
require_once("../../assets/php/common.php");
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>ระบบจัดการสินค้า | <?php echo $shopName; ?></title>
    <!-- <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.css"> -->

    <!-- Favicons -->
    <?php include_once('../../includes/pagesFavicons.php'); ?>

    <!-- stylesheet -->
    <!-- <?php //include_once('../../includes/pagesStylesheet.php'); 
            ?> -->

    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="../../plugins/bootstrap-toggle/bootstrap-toggle.min.css">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/6.5.0.all.min.css">

    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="../../assets/css/loading.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../../assets/css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../../plugins/datetimeFlatpicker/flatpickr.min.css">

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

        th .typename,
        td .typename {
            width: 100px;
            min-width: 100px;
            max-width: 100px;
            display: inline-block;
            border: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        table td {
            border: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        table th:first-child,
        table tr:first-child {
            width: 80px;
        }

        table th:nth-child(2),
        table tr:nth-child(2) {
            width: 150px;
        }

        table th:nth-child(3),
        table tr:nth-child(3) {
            width: 250px;
        }

        table th:nth-child(4),
        table tr:nth-child(4) {
            width: 200px;
        }

        table th:nth-child(5),
        table tr:nth-child(5) {
            width: 200px;
        }

        table th:nth-child(6),
        table tr:nth-child(6) {
            width: 100px;
        }

        table th:nth-child(7),
        table tr:nth-child(7) {
            width: 150px;
            /* overflow:auto;
            white-space: wordwrap; */
        }

        table tr:last-child {
            /* 4th element */
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
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <label class="m-0 text-dark">จัดการสินค้า</label>
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
                                    <label class="mr-auto" style="line-height: 2.1rem">รายการสินค้า</label>
                                    <button class="btn btn-primary boxx float-right" data-bs-toggle="modal" data-bs-target="#itemModal" onclick="openAddModal()"><i class="fa fa-plus"></i> เพิ่มสินค้า</a></button>
                                    <!-- <a href="form-create.php" class="btn btn-primary boxx float-right"><i class="fa fa-plus"></i> เพิ่มสินค้า</a> -->
                                </div>
                                <div class="card-body" style="font-size: 1rem;">
                                    <div class="container" style="max-width:90%;">
                                        <div class="row">
                                            <div class="col-12 col-md-4 col-lg-2 col-xl-2 form-group position-relative d-none">
                                                <label for="sorted" class="" style="padding:0px 0px;">จัดเรียง</label>
                                                <div class="input-icon-wrapper">
                                                    <input class="toggle-event" id="sorted" data-id="" type="checkbox" name="sorted" checked data-toggle="toggle" data-off="ชื่อสินค้า" data-on="&nbsp;&nbsp; รหัสสินค้า &nbsp;&nbsp;" data-onstyle="primary" data-offstyle="success" data-style="ios">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-2">
                                                <label for="filterGroup" class="form-label">รหัส/ชื่อสินค้า</label>
                                                <div class="input-icon-wrapper">
                                                    <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                    <input type="text" class="form-control" id="searchInput" value="" placeholder="" value="" autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-3">
                                                <label for="filterType" class="form-label">ประเภทสินค้า</label>
                                                <div class="input-icon-wrapper">
                                                    <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                    <input type="text" class="form-control" id="filterType" value="" placeholder="" value="" onchange="searchData(this.value);" autocomplete="off" />
                                                    <div id="filterTypeSuggestions" class="suggestions"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-3">
                                                <label for="filterGroup" class="form-label">ยี่ห้อ/รุ่น</label>
                                                <div class="input-icon-wrapper">
                                                    <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                    <input type="text" class="form-control" id="filterGroup" value="" placeholder="" value="" onchange="searchData(this.value);" autocomplete="off" />
                                                    <div id="filterGroupSuggestions" class="suggestions"></div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-12 col-md-4 col-lg-2 col-xl-2 d-flex justify-content-between align-items-center mb-2">
                                                <label for="filterGroup" class="form-label">ยี่ห้อ/รุ่น</label>
                                                <div class="input-icon-wrapper" style="width:80%;">
                                                    <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                    <input type="text" class="form-control" id="filterGroup" value="" placeholder="" value="" onchange="searchData(this.value);" autocomplete="off" />
                                                    <div id="filterGroupSuggestions" class="suggestions"></div>
                                                </div>
                                            </div> -->
                                            <div class="col-12 col-md-4 col-lg-2 col-xl-2 align-content-center">
                                                <button class="btn secondary boxx text-white" onclick="resetFilter()">ล้างตัวกรอง</button>
                                            </div>
                                        </div>
                                        <div class="table-responsive mt-2">
                                            <table class="table table-bordered table-striped align-middle" style="table-layout: fixed;">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <!-- <th style="width: 40px;">#</th>
                                                        <th style="width: 120px; min-width:120px; max-width: 120px;" onclick="sortBy('productId',this);">รหัสสินค้า</th>
                                                        <th style="width: 20%; min-width:180px; max-width: 180px;" onclick="sortBy('name',this);">ชื่อสินค้า</th>
                                                        <th style="width: 20%;" onclick="sortBy('groupname',this);">ยี่ห้อ/รุ่นรถ</th>
                                                        <th style="width: 20%;" onclick="sortBy('typename',this);">ประเภทสินค้า</th>
                                                        <th style="width: 10%;">ต้นทุน</th>
                                                        <th style="width: 15%;">การจัดการ</th> -->
                                                        <th>#</th>
                                                        <th onclick="sortColumnBy('productId',this);">
                                                            <div class="d-flex justify-content-around">
                                                                <div>รหัสสินค้า</div>
                                                                <div id="icon"></div>
                                                            </div>
                                                        </th>
                                                        <th onclick="sortColumnBy('name',this);">
                                                            <div class="d-flex justify-content-around">
                                                                <div>ชื่อสินค้า</div>
                                                                <div id="icon"></div>
                                                            </div>
                                                        </th>
                                                        <th onclick="sortColumnBy('groupname',this);">
                                                            <div class="d-flex justify-content-around">
                                                                <div>ยี่ห้อ/รุ่นรถ</div>
                                                                <div id="icon"></div>
                                                            </div>
                                                        </th>
                                                        <th onclick="sortColumnBy('typename',this);">
                                                            <div class="d-flex justify-content-around">
                                                                <div>ประเภทสินค้า</div>
                                                                <div id="icon"></div>
                                                            </div>
                                                        </th>
                                                        <th>ต้นทุน</th>
                                                        <th>การจัดการ</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="itemTable"></tbody>
                                            </table>
                                        </div>

                                        <div class="pagination-container mt-3">
                                            <nav>
                                                <ul class="pagination justify-content-center" id="pagination"></ul>
                                            </nav>
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
        <?php include_once('../../includes/loading.php') ?>
    </div>

    <!-- Modal ยืนยันลบ -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">ยืนยันการลบ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    คุณต้องการลบข้อมูลนี้หรือไม่?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary boxx" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-danger boxx" onclick="confirmDelete()">ลบ</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal เพิ่ม/แก้ไข -->
    <div class="modal" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="width:auto;max-width:800px;">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="border-radius:25px 25px 0px 0px;">
                    <h5 class="modal-title" id="productModalLabel">เพิ่ม/แก้ไข สินค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="glass-card mb-2">
                            <form id="itemForm">
                                <!-- productId , productName -->
                                <div class="row">
                                    <div class="col-12 col-md-4 form-group position-relative mb-3">
                                        <input
                                            type="hidden"
                                            class="form-control"
                                            id="itemId_org"
                                            placeholder="" />
                                        <label for="itemId" class="form-label">รหัสสินค้า</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="itemId"
                                                value=""
                                                maxlength="20"
                                                placeholder="" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8 form-group position-relative mb-3">
                                        <label for="itemName" class="form-label">ชื่อสินค้า</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon"></i>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="itemName"
                                                value=""
                                                maxlength="50"
                                                placeholder="" />
                                        </div>
                                    </div>
                                </div>
                                <!-- supplier , gruoup , type -->
                                <div class="row">
                                    <div class="col-12 col-md-4 form-group position-relative mb-3">
                                        <label for="itemSupplierName" class="form-label">ชื่อร้านค้า</label>
                                        <div class="form-group autocomplete-container mb-4">
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="itemSupplierName"
                                                    value=""
                                                    maxlength="50"
                                                    placeholder="" autocomplete="off" />
                                                <div id="supplierNameSuggestions" class="suggestions"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 form-group position-relative mb-3">
                                        <label for="itemGroupName" class="form-label">ยี่ห้อ/รุ่นรถ</label>
                                        <div class="form-group autocomplete-container mb-4">
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="itemGroupName"
                                                    value=""
                                                    maxlength="50"
                                                    placeholder=""
                                                    autocomplete="off" />
                                                <div id="groupNameSuggestions" class="suggestions"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 form-group position-relative mb-3">
                                        <label for="itemTypeName" class="form-label">ประเภทสินค้า</label>
                                        <div class="form-group autocomplete-container mb-4">
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="itemTypeName"
                                                    value=""
                                                    maxlength="50"
                                                    placeholder=""
                                                    autocomplete="off" />
                                                <!--
                                                onchange="setProductName();"
                                                 <input type="text" id="supplierName" class="inputStyle inputStyleIcon cursorHand" placeholder="ชื่อร้านค้า..." autocomplete="off"> -->
                                                <div id="typeNameSuggestions" class="suggestions"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- จำนวนสินค้า -->
                                <div class="row">
                                    <div class="col-12">
                                        <label>จำนวน</label>
                                    </div>
                                    <div class="col-6 col-md-2 form-group position-relative mb-3">
                                        <label for="itemStoreMax" class="form-label">สูงสุด</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="itemStoreMax"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2 form-group position-relative mb-3">
                                        <label for="itemStoreMin" class="form-label">ต่ำสุด</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="itemStoreMin"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2 form-group position-relative mb-3">
                                        <label for="itemStoreFront" class="form-label">หน้าร้าน</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="itemStoreFront"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2 form-group position-relative mb-3">
                                        <label for="itemStoreBack" class="form-label">หลังร้าน</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="itemStoreBack"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 form-group position-relative mb-3">
                                        <label for="itemStoreTotal" class="form-label">รวม</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="itemStoreTotal"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <!-- ราคาสินค้า -->
                                <div class="row">
                                    <div class="col-12">
                                        <label>ราคาสินค้า</label>
                                        <button type="button" class="btn btn-secondary boxx" data-toggle="modal" data-target="#computePriceModal">คำนวนราคาขาย</button>
                                    </div>
                                    <div class="col-6 col-md-3 form-group position-relative mb-3">
                                        <label for="itemPriceFront" class="form-label">หน้าร้าน</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="itemPriceFront"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 form-group position-relative mb-3">
                                        <label for="itemPriceBack" class="form-label">หลังร้าน</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="itemPriceBack"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 form-group position-relative mb-3">
                                        <label for="itemPriceShop" class="form-label">ขายส่ง</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="itemPriceShop"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 form-group position-relative mb-3">
                                        <label for="itemPriceInv" class="form-label">ต้นทุน</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="itemPriceInv"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="itemLocation" class="form-label">ที่เก็บสินค้า</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="itemLocation"
                                                placeholder="" />
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary boxx" data-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-primary boxx" onclick="saveItem()">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal คำนวนราคา -->
    <div class="modal modal-child" id="computePriceModal" role="dialog" aria-labelledby="computePriceModalLabel" aria-hidden="true" data-backdrop-limit="1" tabindex="-1" data-modal-parent="#itemModal">
        <div class="modal-dialog modal-dialog-centered" style="width:auto;max-width:800px;">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">คำนวนราคาสินค้า</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="glass-card mb-2">
                            <!-- ราคาสินค้า -->
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <label>ตั้งค่าคิดกำไรสินค้า (%)</label>
                                </div>

                                <div class="col-6 col-md-3 form-group position-relative mb-3">
                                    <label for="initPriceFront" class="form-label">หน้าร้าน</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                        <input
                                            type="text"
                                            class="form-control text-right"
                                            id="initPriceFront"
                                            value="20"
                                            placeholder="" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 form-group position-relative mb-3">
                                    <label for="initPriceBack" class="form-label">หลังร้าน</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                        <input
                                            type="text"
                                            class="form-control text-right"
                                            id="initPriceBack"
                                            value="30"
                                            placeholder="" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 form-group position-relative mb-3">
                                    <label for="initPriceShop" class="form-label">ขายส่ง</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                        <input
                                            type="text"
                                            class="form-control text-right"
                                            id="initPriceShop"
                                            value="15"
                                            placeholder="" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 form-group position-relative mb-3">
                                    <button type="button" class="btn btn-primary boxx" onclick="saveInitPrice();">บันทึก</button>
                                </div>

                                <div class="col-6 form-group position-relative mb-3">
                                    <label for="priceInput" class="form-label">ราคาต้นทุน</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                        <input
                                            type="text"
                                            class="form-control text-right"
                                            id="priceInput"
                                            value="0"
                                            placeholder="" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-6 form-group position-relative mb-3">
                                    <button type="button" class="btn btn-secondary boxx" onclick="computePriceForProduct();">คำนวน</button>
                                </div>

                                <div class="col-6 col-md-3 form-group position-relative mb-3">
                                    <label for="computePriceFront" class="form-label">หน้าร้าน</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                        <input
                                            type="text"
                                            class="form-control text-right"
                                            id="computePriceFront"
                                            value="0"
                                            placeholder="" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 form-group position-relative mb-3">
                                    <label for="computePriceBack" class="form-label">หลังร้าน</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                        <input
                                            type="text"
                                            class="form-control text-right"
                                            id="computePriceBack"
                                            value="0"
                                            placeholder="" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 form-group position-relative mb-3">
                                    <label for="computePriceShop" class="form-label">ขายส่ง</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                        <input
                                            type="text"
                                            class="form-control text-right"
                                            id="computePriceShop"
                                            value="0"
                                            placeholder="" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 form-group position-relative mb-3">
                                    <label for="computePriceInv" class="form-label">ต้นทุน</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                        <input
                                            type="text"
                                            class="form-control text-right"
                                            id="computePriceInv"
                                            value=""
                                            placeholder="" autocomplete="off" />
                                    </div>
                                </div>

                                <div class="col-12 form-group position-relative mt-3 d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary boxx m-2" onclick="modalHide('computePriceModal');">ยกเลิก</button>
                                    <button type="button" class="btn btn-success boxx m-2" onclick="setPriceForProduct();">นำค่าไปใช้งาน</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <?php include_once('../../includes/pagesScript.php') ?>
    <?php include_once('../../includes/myScript.php') ?>

    <script src="../indexedDB/indexedDB.js?<?php echo time(); ?>"></script>
    <script src="../js/renderPagination.js"></script>
    <script src="../js/sortColumnBy.js"></script>
    <script src="../js/validateInput.js"></script>
    <script src="../js/autocomplete.js?<?php echo time(); ?>"></script>
    <script src="computePriceInv.js?<?php echo time(); ?>"></script>
    <script type="text/javascript">
        let products = [];
        let groupNames = [];
        let typeNames = [];
        let suppliers = [];
        let filtered = [];

        let currentPage = 1;
        const perPage = 10;
        let editId = null;
        let deleteId = null;

        //ตั้งค่าสำหรับการตรวจสอบข้อมูลการ Input
        let arrayValidateInput = [{
                id: "itemId",
                name: "รหัสสินค้า"
            },
            {
                id: "itemName",
                name: "ชื่อสินค้า"
            }
        ];
        let validateInputForm = new ValidateInput("itemModal", arrayValidateInput);
        const STORE = "products";

        //สำหรับการจัดเรียงข้อมูล
        let sortColumn = [{
                colName: "productId",
                state: "ASC"
            },
            {
                colName: "name",
                state: "ASC"
            },
            {
                colName: "groupname",
                state: "ASC"
            },
            {
                colName: "typename",
                state: "ASC"
            },
        ];

        // $('#sorted').bootstrapToggle();
        // $('#sorted').off('change');

        // $("#sorted").change(function() {
        //     sortData();
        // });

        // function sortData() {
        //     let sorted = $("#sorted")[0].checked ? "productId" : "name";
        //     // filtered = filtered.sort((a, b) => {
        //     //     return a[sorted] > b[sorted];
        //     // });

        //     // filtered.sort((a, b) => a.name.localeCompare(b.name));
        //     filtered.sort((a, b) => a[sorted].localeCompare(b[sorted]));
        //     currentPage = 1;
        //     renderTable();

        //     // if (filtered.length) {
        //     //     let sorted = $("#sorted")[0].checked ? "productId" : "name";
        //     //     //alert(sorted)
        //     //     filtered = filtered.sort((a, b) => {
        //     //         return a[sorted] > b[sorted];
        //     //     });
        //     //     currentPage = 1;
        //     //     //createFilterDataAndRender();
        //     //     renderTable();
        //     // }
        // }

        const searchData = (item) => {
            currentPage = 1;
            createFilterDataAndRender();

            // if (item) {
            //     currentPage = 1;
            //     createFilterDataAndRender();
            //     //renderTable();
            // } else {
            //     //alert("null");
            // }
        }

        const setProductName = () => {
            if ($("#itemModal #itemGroupName").val() && $("#itemModal #itemTypeName").val()) {
                $("#itemModal #itemName").val($("#itemModal #itemTypeName").val() + " " + $("#itemModal #itemGroupName").val());
            } else if ($("#itemModal #itemGroupName").val()) {
                $("#itemModal #itemName").val($("#itemModal #itemGroupName").val());
            } else if ($("#itemModal #itemTypeName").val()) {
                $("#itemModal #itemName").val($("#itemModal #itemTypeName").val());
            } else {
                //$("#itemModal #productName").val($("#itemModal #typeName").val());
            }
            //$("#itemModal #productName").val($("#itemModal #groupName").val() + $("#itemModal #typeName").val())
        };

        function modalHide(modal) {
            $('#' + modal).modal('hide');
        }

        function computePriceForProduct() {

            let modal = document.getElementById("computePriceModal");
            let ele = modal.querySelector("#priceInput");

            let value = ele.value ? Number(ele.value) : 0;
            let stringValue = value.toString().split('');

            let initPriceFront = Number(modal.querySelector("#initPriceFront").value);
            let initPriceBack = Number(modal.querySelector("#initPriceBack").value);
            let initPriceShop = Number(modal.querySelector("#initPriceShop").value);

            let computePrice = parseInt(value + value * initPriceFront / 100 + 0.5);
            modal.querySelector("#computePriceFront").value = computePrice;

            computePrice = parseInt(value + value * initPriceBack / 100 + 0.5);
            modal.querySelector("#computePriceBack").value = computePrice;

            computePrice = parseInt(value + value * initPriceShop / 100 + 0.5);
            modal.querySelector("#computePriceShop").value = computePrice;

            let computePriceInv = [];
            if (value !== 0) {
                computePriceInv = stringValue.map(convertInvFromValue);
            }

            modal.querySelector("#computePriceInv").value = computePriceInv.join("");
        }

        function setPriceForProduct() {
            let modalProduct = document.getElementById("itemModal");
            let modalPrice = document.getElementById("computePriceModal");
            let ele = modalPrice.querySelector("#computePriceFront");

            let value = ele.value ? Number(ele.value) : 0;
            modalProduct.querySelector("#itemPriceFront").value = value;
            ele = modalPrice.querySelector("#computePriceBack");
            value = ele.value ? Number(ele.value) : 0;
            modalProduct.querySelector("#itemPriceBack").value = value;
            ele = modalPrice.querySelector("#computePriceShop");
            value = ele.value ? Number(ele.value) : 0;
            modalProduct.querySelector("#itemPriceShop").value = value;
            ele = modalPrice.querySelector("#computePriceInv");
            value = ele.value ? ele.value : "";
            modalProduct.querySelector("#itemPriceInv").value = value;


            //modalPrice.modal("hide");
            $('#computePriceModal').modal('hide');

        }

        function openAddModal() {
            editId = null;
            document.getElementById('itemForm').reset();
            $('#itemForm #productModalLabel').text('เพิ่มสินค้า');
            $('#itemForm .modal-header').addClass("bg-primary");
            $('#itemForm .modal-header').removeClass("bg-warning");

            $('#itemModal').modal("show");
            // new bootstrap.Modal(document.getElementById('productModal')).show();
        }

        function openEditModal(id) {
            const m = products.find(x => x.productId === id);
            if (m) {
                editId = id;
                const thisfrm = document.getElementById('itemForm');
                thisfrm.elements.namedItem("itemId_org").value = id;
                thisfrm.elements.namedItem("itemId").value = id;
                thisfrm.elements.namedItem("itemName").value = m.name;
                thisfrm.elements.namedItem("itemGroupName").value = m.groupname;
                thisfrm.elements.namedItem("itemTypeName").value = m.typename;
                thisfrm.elements.namedItem("itemSupplierName").value = m.suppliername;
                thisfrm.elements.namedItem("itemStoreMax").value = m.storeMax;
                thisfrm.elements.namedItem("itemStoreMin").value = m.storeMin;
                thisfrm.elements.namedItem("itemStoreFront").value = m.storeFront;
                thisfrm.elements.namedItem("itemStoreBack").value = m.storeBack;
                thisfrm.elements.namedItem("itemStoreTotal").value = m.storeFront + m.storeBack;
                thisfrm.elements.namedItem("itemPriceInv").value = m.priceInv;
                thisfrm.elements.namedItem("itemPriceFront").value = m.priceFront;
                thisfrm.elements.namedItem("itemPriceBack").value = m.priceBack;
                thisfrm.elements.namedItem("itemPriceShop").value = m.priceShop;
                thisfrm.elements.namedItem("itemLocation").value = m.location;

                $('#itemModal #productModalLabel').text('แก้ไขสินค้า');
                $('#itemModal .modal-header').addClass("bg-warning");
                $('#itemModal .modal-header').removeClass("bg-primary");
                $('#itemModal').modal("show");
                // new bootstrap.Modal(document.getElementById('productModal')).show();
            }
        }

        function saveItem() {
            const thisfrm = document.getElementById('itemForm');
            const itemId_org = thisfrm.elements.namedItem('itemId_org').value.trim();
            const itemId = thisfrm.elements.namedItem('itemId').value.trim();
            const itemName = thisfrm.elements.namedItem('itemName').value.trim();
            const itemGroupName = thisfrm.elements.namedItem('itemGroupName').value.trim();
            const itemTypeName = thisfrm.elements.namedItem('itemTypeName').value.trim();
            const itemSupplierName = thisfrm.elements.namedItem('itemSupplierName').value.trim();
            const itemStoreMax = thisfrm.elements.namedItem('itemStoreMax').value.trim();
            const itemStoreMin = thisfrm.elements.namedItem('itemStoreMin').value.trim();
            const itemStoreFront = thisfrm.elements.namedItem('itemStoreFront').value.trim();
            const itemStoreBack = thisfrm.elements.namedItem('itemStoreBack').value.trim();
            const itemPriceInv = thisfrm.elements.namedItem('itemPriceInv').value.trim();
            const itemPriceFront = thisfrm.elements.namedItem('itemPriceFront').value.trim();
            const itemPriceBack = thisfrm.elements.namedItem('itemPriceBack').value.trim();
            const itemPriceShop = thisfrm.elements.namedItem('itemPriceShop').value.trim();
            const itemLocation = thisfrm.elements.namedItem('itemLocation').value.trim();
            const updatedAt = getDateTimeNow();
            // const updatedAt = new Date().addHours(7).toISOString().replace("T", " ").substr(0, 19);

            // let nowSyncTime = new Date().addHours(7).toISOString().replace("T", " ").substr(0, 19);

            // if (!productId || !name) {
            //     alert('กรุณากรอกข้อมูลให้ครบถ้วน');
            //     return;
            // }

            let statusValidate = validateInputForm.validate();

            if (!statusValidate.status) {
                let invalidStr = statusValidate.invalidString;
                sweetAlertError('กรุณากรอกข้อมูลให้ครบถ้วน' + invalidStr, 5000);
                return;
            }

            const item = {
                "productId": itemId,
                "name": itemName,
                "groupname": itemGroupName,
                "typename": itemTypeName,
                "suppliername": itemSupplierName,
                "storeMax": itemStoreMax,
                "storeMin": itemStoreMin,
                "storeFront": itemStoreFront,
                "storeBack": itemStoreBack,
                "priceInv": itemPriceInv,
                "priceFront": itemPriceFront,
                "priceBack": itemPriceBack,
                "priceShop": itemPriceShop,
                "location": itemLocation,
                "updatedAt": updatedAt,
            };

            let dataSend = {
                "itemId_org": itemId_org,
                "itemId": itemId,
                "itemName": itemName,
                "itemGroupName": itemGroupName,
                "itemTypeName": itemTypeName,
                "itemSupplierName": itemSupplierName,
                "itemStoreMax": itemStoreMax,
                "itemStoreMin": itemStoreMin,
                "itemStoreFront": itemStoreFront,
                "itemStoreBack": itemStoreBack,
                "itemPriceInv": itemPriceInv,
                "itemPriceFront": itemPriceFront,
                "itemPriceBack": itemPriceBack,
                "itemPriceShop": itemPriceShop,
                "itemLocation": itemLocation,
                "itemUpdatedAt": updatedAt,
            }

            if (editId) {
                // item.carId = itemId;
                $.ajax({
                    type: "POST",
                    url: "services/updateItem.php",
                    data: dataSend
                }).done(function(resp) {
                    if (resp.status) {
                        $('#itemModal').modal("hide");
                        toastr.success(resp.message);
                        confirmSave(item);
                    } else {
                        sweetAlertError('เกิดข้อผิดพลาด : ' + resp.message, 3000);
                    }
                }).fail(function(err) {
                    let message = err?.responseJSON?.message ?? err.responseText;
                    sweetAlertError('เกิดข้อผิดพลาด : ' + message, 0);
                }).always(function() {
                    loaderScreen("hide");
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: "services/insertItem.php",
                    data: dataSend
                }).done(function(resp) {
                    if (resp.status) {
                        $('#itemModal').modal("hide");
                        toastr.success(resp.message);
                        confirmSave(item)
                    } else {
                        sweetAlertError('เกิดข้อผิดพลาด : ' + resp.message, 3000);
                    }
                }).fail(function(err) {
                    let message = err?.responseJSON?.message ?? err.responseText;
                    sweetAlertError('เกิดข้อผิดพลาด : ' + message, 0);
                }).always(function() {
                    loaderScreen("hide");
                });
            }
        }

        async function prepareDelete(item) {
            let deleteId = item.productId;
            let deleteName = item.name;
            message = `${deleteName}<BR>คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?`;
            confirm = await sweetConfirmDelete(message, "ใช่! ลบเลย");
            if (confirm) {
                loaderScreen("show");
                $.ajax({
                    type: "POST",
                    url: "services/deleteItem.php",
                    data: {
                        itemId: deleteId
                    }
                }).done(function(resp) {
                    if (resp.status) {
                        toastr.success(resp.message);
                        confirmDelete(deleteId);
                    } else {
                        sweetAlertError('เกิดข้อผิดพลาด : ' + resp.message);
                    }
                }).fail(function(err) {
                    let message = err?.responseJSON?.message ?? err.responseText;
                    sweetAlertError('เกิดข้อผิดพลาด : ' + message, 0);
                }).always(function() {
                    loaderScreen("hide");
                })
            }
        }

        function confirmSave(item) {
            if (editId) {
                const index = products.findIndex(m => m.productId == editId);
                if (index !== -1) {
                    products[index] = item;
                }
            } else {
                products.push(item);
            }
            createFilterDataAndRender();
        }

        function confirmDelete(deleteId) {
            products = products.filter(m => m.productId !== deleteId);
            filtered = filtered.filter(m => m.productId != deleteId);
            renderTable();
        }

        const changeFilter = (item) => {
            if (item) {
                searchData();
                //$("#filterType").change(1);
            }
        }


        function createFilterDataAndRender(page=1) {
            currentPage = page;
            const searchText = document.getElementById('searchInput').value.trim().toLowerCase();
            const searchType = document.getElementById('filterType').value.trim().toLowerCase();
            const searchGroup = document.getElementById('filterGroup').value.trim().toLowerCase();

            filtered = products;
            if (searchText) {
                filtered = filtered.filter(m =>
                    m.productId.toLowerCase().includes(searchText) ||
                    m.name.toLowerCase().includes(searchText)
                );
            }

            if (searchType) {
                filtered = filtered.filter(m =>
                    m.typename.toLowerCase().includes(searchType)
                );
            }

            if (searchGroup) {
                filtered = filtered.filter(m =>
                    m.groupname.toLowerCase().includes(searchGroup)
                );
            }

            // sortData();

            renderTable();
        }

        function renderTable() {
            const tbody = document.getElementById('itemTable');
            const totalPages = Math.ceil(filtered.length / perPage);
            const start = (currentPage - 1) * perPage;
            const pageItems = filtered.slice(start, start + perPage);

            tbody.innerHTML = '';
            for (let i = 0; i < pageItems.length; i++) {
                const m = pageItems[i];
                tbody.insertAdjacentHTML('beforeend', `
                    <tr>
                        <td>${start + i + 1}</td>
                        <td>${m.productId}</td>
                        <td>${m.name}</td>
                        <td>${m.groupname}</td>
                        <td>${m.typename}</td>
                        <td>${m.priceInv}</td>
                        <td>
                            <div class="d-flex justify-content-around">
                                <button class="btn btn-sm btn-warning boxx text-white" onclick="openEditModal('${m.productId}')">แก้ไข</button>
                                <button class="btn btn-sm btn-danger boxx" onclick='prepareDelete(${JSON.stringify(m)})'>ลบ</button>
                            </div>
                        </td>
                    </tr>
                `);
                // <button class="btn btn-sm btn-danger boxx" onclick="prepareDelete('${m.productId}','${m.name}')">ลบ</button>
            }

            renderPagination(currentPage, totalPages);
        }

        function resetFilter() {
            document.getElementById('searchInput').value = '';
            document.getElementById('filterType').value = '';
            document.getElementById('filterGroup').value = '';
            createFilterDataAndRender();
        }

        $(document).ready(async function() {
            try {
                loaderScreen("show");
                // await openDB();
                await syncOnLoad();
                products = await loadDataFromDB("products");
                createFilterDataAndRender();
                groupNames = await loadAndSetData("groupnames");
                typeNames = await loadAndSetData("typenames");
                suppliers = await loadAndSetData("suppliers");
            } catch (error) {
                sweetAlertError("เกิดข้อผิดพลาด : " + error.message, 0);
            } finally {
                loaderScreen("hide");
            }

            $(function() {
                var focusedElement;
                $(document).on('focus', 'input', function() {
                    if (focusedElement == this) return; //already focused, return so user can now place cursor at specific point in input.
                    focusedElement = this;
                    setTimeout(function() {
                        focusedElement.select();
                    }, 100); //select all text in any field on focus for easy re-entry. Delay sightly to allow focus to "stick" before selecting.
                });
            });

            $('#searchInput').on('input', function() {
                createFilterDataAndRender();
            });

            // $("*").dblclick(function(e) {
            //     e.preventDefault();
            //     event.stopPropagation();
            // });

            // setInterval(syncDataRealtime,10000); // 10 วินาที
            // setInterval(function() {
            //     updateSyncData({dataSource:colorNames,dataName:"colornames"}); 
            // },5000); // 10 วินาที
        });

        async function syncDataRealtime() {
            let dataSource = await updateSyncData({
                dataName: "products"
            });
            if (dataSource) {
                products = dataSource;
                createFilterDataAndRender();
            }
        }

        // document.addEventListener("dbclick", function(event) {
        //     event.preventDefault();
        //     event.stopPropagation();
        // });

        async function loadAndSetData(storeName) {
            let dataStore = await loadDataFromDB(storeName);
            if (storeName == "products") {
                // products = dataStore;
                setupAutocompleteProducts(
                    "productInput", "productSuggestions", products, "productId", ["productId", "name"], ["productId", "name"], [{
                        elementId: "productCode",
                        elementValue: "productName"
                    }, {
                        elementId: "productName",
                        elementValue: "name"
                    }, {
                        elementId: "productPrice",
                        elementValue: "price1"
                    }]
                );
                return dataStore;
                // createFilterDataAndRender();
                //renderTable();
            } else if (storeName == "groupnames") {
                // groupNames = dataStore;
                /*
                setupAutocomplete(
                    "groupName", "groupNameSuggestions", groupNames, "groupname", ["groupname"], ["groupname"], null, setProductName);
                    */
                setupAutocompleteOnFocus({
                    inputId: "filterGroup",
                    suggestionsId: "filterGroupSuggestions",
                    dataList: dataStore,
                    codeId: "groupname",
                    arrayShowValue: ["groupname"],
                    arrayFindValue: ["groupname"],
                    // callbackFunction: changeFilter,
                    sortField: "groupname"
                });
                setupAutocompleteOnFocus({
                    inputId: "itemGroupName",
                    suggestionsId: "groupNameSuggestions",
                    dataList: dataStore,
                    codeId: "groupname",
                    arrayShowValue: ["groupname"],
                    arrayFindValue: ["groupname"],
                    callbackFunction: setProductName,
                    sortField: "groupname"
                });
                return dataStore;
            } else if (storeName == "typenames") {
                setupAutocompleteOnFocus({
                    inputId: "filterType",
                    suggestionsId: "filterTypeSuggestions",
                    dataList: dataStore,
                    codeId: "typename",
                    arrayShowValue: ["typename"],
                    arrayFindValue: ["typename"],
                    // callbackFunction: changeFilter,
                    sortField: "typename"
                });
                setupAutocompleteOnFocus({
                    inputId: "itemTypeName",
                    suggestionsId: "typeNameSuggestions",
                    dataList: dataStore,
                    codeId: "typename",
                    arrayShowValue: ["typename"],
                    arrayFindValue: ["typename"],
                    callbackFunction: setProductName,
                    sortField: "typename"
                });
                return dataStore;
            } else if (storeName == "suppliers") {
                suppliers = dataStore;
                setupAutocompleteOnFocus({
                    inputId: "itemSupplierName",
                    suggestionsId: "supplierNameSuggestions",
                    dataList: suppliers,
                    codeId: "name",
                    arrayShowValue: ["name"],
                    arrayFindValue: ["name"],
                    //callbackFunction: dataFilterProductModal,
                    sortField: "name"
                });
            } else if (storeName == "colors") {
                setupAutocompleteOnFocus({
                    inputId: "itemColorName",
                    suggestionsId: "colorNameSuggestions",
                    dataList: dataStore,
                    codeId: "colorname",
                    arrayShowValue: ["colorname"],
                    arrayFindValue: ["colorname"],
                    //callbackFunction: dataFilterProductModal,
                    sortField: "colorname"
                });
                return dataStore;
            }
        }
    </script>
</body>

</html>