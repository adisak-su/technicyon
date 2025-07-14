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
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.css">

    <!-- Favicons -->
    <?php include_once('../../includes/pagesFavicons.php'); ?>

    <!-- stylesheet -->
    <?php include_once('../../includes/pagesStylesheet.php'); ?>

    <!-- Font Awesome 6 (Free CDN) -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />


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
                                    <button class="btn btn-primary boxx float-right" data-bs-toggle="modal" data-bs-target="#productModal" onclick="openAddModal()"><i class="fa fa-plus"></i> เพิ่มสินค้า</a></button>
                                    <!-- <a href="form-create.php" class="btn btn-primary boxx float-right"><i class="fa fa-plus"></i> เพิ่มสินค้า</a> -->
                                </div>
                                <div class="card-body" style="font-size: 1rem;">
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-lg-2 col-xl-2 form-group">
                                            <label for="sorted" class="" style="padding:0px 0px;">จัดเรียง</label>
                                            <div class="input-icon-wrapper">
                                                <input class="toggle-event" id="sorted" data-id="" type="checkbox" name="sorted" checked data-toggle="toggle" data-off="ชื่อสินค้า" data-on="&nbsp;&nbsp; รหัสสินค้า &nbsp;&nbsp;" data-onstyle="primary" data-offstyle="success" data-style="ios">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-2 form-group">
                                            <label for="filterGroup" class="form-label">รหัส/ชื่อสินค้า</label>
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input type="text" class="form-control" id="searchInput" value="" placeholder="..." value="" autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-3 form-group">
                                            <label for="filterType" class="form-label">ประเภทสินค้า</label>
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input type="text" class="form-control" id="filterType" value="" placeholder="..." value="" onchange="searchData(this.value);" autocomplete="off" />
                                                <div id="filterTypeSuggestions" class="suggestions"></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-3 form-group">
                                            <label for="filterGroup" class="form-label">ยี่ห้อ/รุ่น</label>
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input type="text" class="form-control" id="filterGroup" value="" placeholder="..." value="" onchange="searchData(this.value);" autocomplete="off" />
                                                <div id="filterGroupSuggestions" class="suggestions"></div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-12 col-md-4 col-lg-2 col-xl-2 d-flex justify-content-between align-items-center mb-2">
                                                <label for="filterGroup" class="form-label">ยี่ห้อ/รุ่น</label>
                                                <div class="input-icon-wrapper" style="width:80%;">
                                                    <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                    <input type="text" class="form-control" id="filterGroup" value="" placeholder="..." value="" onchange="searchData(this.value);" autocomplete="off" />
                                                    <div id="filterGroupSuggestions" class="suggestions"></div>
                                                </div>
                                            </div> -->
                                        <div class="col-12 col-md-4 col-lg-2 col-xl-2 form-group align-content-end">
                                            <button class="btn secondary boxx text-white" onclick="resetFilter()">ล้างตัวกรอง</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-2">
                                        <table class="table table-bordered table-striped align-middle">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th style="min-width: 40px;">#</th>
                                                    <th style="min-width: 120px;">รหัสสินค้า</th>
                                                    <th style="min-width: 180px;">ชื่อสินค้า</th>
                                                    <th style="min-width: 120px;">ยี่ห้อ/รุ่นรถ</th>
                                                    <th style="min-width: 140px;">ประเภทสินค้า</th>
                                                    <th style="min-width: 140px;">ต้นทุน</th>
                                                    <th style="min-width: 140px;">การจัดการ</th>
                                                </tr>
                                            </thead>
                                            <tbody id="productTable"></tbody>
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
    <!-- <div class="modal fade" id="progressModal" tabindex="-1" role="dialog" aria-labelledby="progressModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="progressModalLabel">Loading Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
    </div>
    
    <div class="modal" id="computePricemodal" data-backdrop="static" tabindex="-2" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="progressModalLabel">Loading Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
    
    <div class="modal fade" id="productModal" role="dialog" style="z-index:2000;">
    
    <div id="myModal1" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-modal-parent="#myModal">
    -->

    <div class="modal" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="width:auto;max-width:800px;">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="border-radius:25px 25px 0px 0px;">
                    <h5 class="modal-title" id="productModalLabel">เพิ่ม/แก้ไข สินค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="glass-card mb-2">
                            <form id="productForm">
                                <!-- productId , productName -->
                                <div class="row">
                                    <div class="col-12 col-md-4 form-group position-relative mb-3">
                                        <label for="productId" class="form-label">รหัสสินค้า</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="productId"
                                                placeholder="รหัสสินค้า..." />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8 form-group position-relative mb-3">
                                        <label for="productName" class="form-label">ชื่อสินค้า</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon"></i>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="productName"
                                                placeholder="ชื่อสินค้า..." />
                                        </div>
                                    </div>
                                </div>
                                <!-- supplier , gruoup , type -->
                                <div class="row">
                                    <div class="col-12 col-md-4 form-group position-relative mb-3">
                                        <label for="supplierName" class="form-label">ชื่อร้านค้า</label>
                                        <div class="form-group autocomplete-container mb-4">
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="supplierName"
                                                    placeholder="ชื่อร้านค้า..." autocomplete="off" />
                                                <div id="supplierNameSuggestions" class="suggestions"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 form-group position-relative mb-3">
                                        <label for="groupName" class="form-label">ยี่ห้อ/รุ่นรถ</label>
                                        <div class="form-group autocomplete-container mb-4">
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="groupName"
                                                    placeholder="ยี่ห้อ/รุ่นรถ..."

                                                    autocomplete="off" />
                                                <div id="groupNameSuggestions" class="suggestions"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 form-group position-relative mb-3">
                                        <label for="typeName" class="form-label">ประเภทสินค้า</label>
                                        <div class="form-group autocomplete-container mb-4">
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="typeName"
                                                    placeholder="ประเภทสินค้า..."

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
                                        <label for="stockMax" class="form-label">สูงสุด</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="stockMax"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2 form-group position-relative mb-3">
                                        <label for="stockMin" class="form-label">ต่ำสุด</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="stockMin"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2 form-group position-relative mb-3">
                                        <label for="stockFront" class="form-label">หน้าร้าน</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="stockFront"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2 form-group position-relative mb-3">
                                        <label for="stockBack" class="form-label">หลังร้าน</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="stockBack"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 form-group position-relative mb-3">
                                        <label for="stockTotal" class="form-label">รวม</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="stockTotal"
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
                                        <label for="priceFront" class="form-label">หน้าร้าน</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="priceFront"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 form-group position-relative mb-3">
                                        <label for="priceBack" class="form-label">หลังร้าน</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="priceBack"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 form-group position-relative mb-3">
                                        <label for="priceShop" class="form-label">ขายส่ง</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="priceShop"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 form-group position-relative mb-3">
                                        <label for="priceInv" class="form-label">ต้นทุน</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                id="priceInv"
                                                value="0"
                                                placeholder="" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="store" class="form-label">ที่เก็บสินค้า</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="store"
                                                placeholder="ที่เก็บสินค้า..." />
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary boxx" data-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-primary boxx" data-dismiss="modal" onclick="saveProduct()">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal คำนวนราคา -->
        <div class="modal modal-child" id="computePriceModal" role="dialog" aria-labelledby="computePriceModalLabel" aria-hidden="true" data-backdrop-limit="1" tabindex="-1" data-modal-parent="#productModal">
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

        <script src="../indexedDB/indexedDB.js"></script>
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

            $('#sorted').bootstrapToggle();
            $('#sorted').off('change');

            $("#sorted").change(function() {
                sortData();
            });

            function sortData() {
                let sorted = $("#sorted")[0].checked ? "productId" : "name";
                // filtered = filtered.sort((a, b) => {
                //     return a[sorted] > b[sorted];
                // });

                // filtered.sort((a, b) => a.name.localeCompare(b.name));
                filtered.sort((a, b) => a[sorted].localeCompare(b[sorted]));
                currentPage = 1;
                renderTable();

                // if (filtered.length) {
                //     let sorted = $("#sorted")[0].checked ? "productId" : "name";
                //     //alert(sorted)
                //     filtered = filtered.sort((a, b) => {
                //         return a[sorted] > b[sorted];
                //     });
                //     currentPage = 1;
                //     //createFilterDataAndRender();
                //     renderTable();
                // }
            }

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

                if ($("#productModal #groupName").val() && $("#productModal #typeName").val()) {
                    $("#productModal #productName").val($("#productModal #typeName").val() + " " + $("#productModal #groupName").val());
                } else if ($("#productModal #groupName").val()) {
                    $("#productModal #productName").val($("#productModal #groupName").val());
                } else if ($("#productModal #typeName").val()) {
                    $("#productModal #productName").val($("#productModal #typeName").val());
                } else {
                    //$("#productModal #productName").val($("#productModal #typeName").val());
                }

                //$("#productModal #productName").val($("#productModal #groupName").val() + $("#productModal #typeName").val())


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
                let modalProduct = document.getElementById("productModal");
                let modalPrice = document.getElementById("computePriceModal");
                let ele = modalPrice.querySelector("#computePriceFront");

                let value = ele.value ? Number(ele.value) : 0;
                modalProduct.querySelector("#priceFront").value = value;
                ele = modalPrice.querySelector("#computePriceBack");
                value = ele.value ? Number(ele.value) : 0;
                modalProduct.querySelector("#priceBack").value = value;
                ele = modalPrice.querySelector("#computePriceShop");
                value = ele.value ? Number(ele.value) : 0;
                modalProduct.querySelector("#priceShop").value = value;
                ele = modalPrice.querySelector("#computePriceInv");
                value = ele.value ? ele.value : "";
                modalProduct.querySelector("#priceInv").value = value;


                //modalPrice.modal("hide");
                $('#computePriceModal').modal('hide');

            }

            async function loadAndSetData(storeName) {
                let dataStore = await loadDataFromDB(storeName);
                if (storeName == "products") {
                    products = dataStore;
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
                    createFilterDataAndRender();
                    //renderTable();
                } else if (storeName == "groupnames") {
                    groupNames = dataStore;
                    /*
                    setupAutocomplete(
                        "groupName", "groupNameSuggestions", groupNames, "groupname", ["groupname"], ["groupname"], null, setProductName);
                        */
                    setupAutocompleteOnFocus({
                        inputId: "filterGroup",
                        suggestionsId: "filterGroupSuggestions",
                        dataList: groupNames,
                        codeId: "groupname",
                        arrayShowValue: ["groupname"],
                        arrayFindValue: ["groupname"],
                        // callbackFunction: changeFilter,
                        //sortField: "groupname"
                    });
                    setupAutocompleteOnFocus({
                        inputId: "groupName",
                        suggestionsId: "groupNameSuggestions",
                        dataList: groupNames,
                        codeId: "groupname",
                        arrayShowValue: ["groupname"],
                        arrayFindValue: ["groupname"],
                        callbackFunction: setProductName,
                        //sortField: "groupname"
                    });
                } else if (storeName == "typenames") {
                    typeNames = dataStore;
                    /*
                    setupAutocomplete(
                        "typeName", "typeNameSuggestions", typeNames, "typename", ["typename"], ["typename"], null, setProductName);
                        */
                    setupAutocompleteOnFocus({
                        inputId: "filterType",
                        suggestionsId: "filterTypeSuggestions",
                        dataList: typeNames,
                        codeId: "typename",
                        arrayShowValue: ["typename"],
                        arrayFindValue: ["typename"],
                        // callbackFunction: changeFilter,
                        //sortField: "typename"
                    });
                    setupAutocompleteOnFocus({
                        inputId: "typeName",
                        suggestionsId: "typeNameSuggestions",
                        dataList: typeNames,
                        codeId: "typename",
                        arrayShowValue: ["typename"],
                        arrayFindValue: ["typename"],
                        callbackFunction: setProductName,
                        //sortField: "typename"
                    });

                } else if (storeName == "suppliers") {
                    suppliers = dataStore;
                    /*
                    setupAutocompleteOnFocus(
                        "supplierName", "supplierNameSuggestions", suppliers, "name", ["name"], ["supplierId", "name"]);
                        */
                    setupAutocompleteOnFocus({
                        inputId: "supplierName",
                        suggestionsId: "supplierNameSuggestions",
                        dataList: suppliers,
                        codeId: "name",
                        arrayShowValue: ["name"],
                        arrayFindValue: ["name"],
                        //callbackFunction: dataFilterProductModal,
                        sortField: "name"
                    });
                }
            }

            $(document).ready(async function() {
                // var events = $._data(document.getElementById('filterType'), "events");
                // var events = $._data($("#filterType")[0], "events");
                // alert(events);
                // console.log(events);

                await openDB();
                // loadAndSetData("products");
                products = await loadDataFromDB("products");
                createFilterDataAndRender();
                //renderTable();
                loadAndSetData("groupnames");
                loadAndSetData("typenames");
                loadAndSetData("suppliers");

                $('#searchInput').on('input', function() {
                    currentPage = 1;
                    createFilterDataAndRender();
                    //renderTable();
                });

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

                loaderScreen("hide");
                //alert(products.length);
                $("*").dblclick(function(e) {
                    e.preventDefault();
                });

            });



            document.addEventListener("dbclick", function(event) {
                event.preventDefault();
                event.stopPropagation();
            });

            function openAddModal() {
                editId = null;
                document.getElementById('productForm').reset();
                $('#productModal #productModalLabel').text('เพิ่มสินค้า');
                $('#productModal .modal-header').addClass("bg-primary");
                $('#productModal .modal-header').removeClass("bg-warning");
                new bootstrap.Modal(document.getElementById('productModal')).show();
            }

            function openEditModal(id) {
                const m = products.find(x => x.productId === id);
                if (m) {
                    editId = id;
                    const thisfrm = document.getElementById('productForm');
                    thisfrm.elements.namedItem("productId").value = m.productId;
                    thisfrm.elements.namedItem("productName").value = m.name;
                    thisfrm.elements.namedItem("groupName").value = m.groupname;
                    thisfrm.elements.namedItem("typeName").value = m.typename;
                    thisfrm.elements.namedItem("supplierName").value = m.suppliername;
                    thisfrm.elements.namedItem("stockMax").value = m.max;
                    thisfrm.elements.namedItem("stockMin").value = m.min;
                    thisfrm.elements.namedItem("stockFront").value = m.stock1;
                    thisfrm.elements.namedItem("stockBack").value = m.stock2;
                    thisfrm.elements.namedItem("stockTotal").value = m.stock1 + m.stock2;

                    thisfrm.elements.namedItem("priceInv").value = m.price0;
                    thisfrm.elements.namedItem("priceFront").value = m.price1;
                    thisfrm.elements.namedItem("priceBack").value = m.price2;
                    thisfrm.elements.namedItem("priceShop").value = m.price3;
                    thisfrm.elements.namedItem("store").value = m.store;

                    // let computePriceInv = m.price0;
                    // if (computePriceInv !== "") {
                    //     let stringValue = computePriceInv.split('');
                    //     computePriceInv = stringValue.map(convertInvFromString);
                    //     modal.querySelector("#computePriceInv").value = computePriceInv.join("");
                    // }

                    $('#productModal #productModalLabel').text('แก้ไขสินค้า');
                    $('#productModal .modal-header').addClass("bg-warning");
                    $('#productModal .modal-header').removeClass("bg-primary");
                    new bootstrap.Modal(document.getElementById('productModal')).show();
                }
            }

            Date.prototype.addHours = function(h) {
                this.setHours(this.getHours() + h);
                return this;
            }

            function saveProduct() {
                const thisfrm = document.getElementById('productForm');
                const productId = editId || thisfrm.elements.namedItem('productId').value.trim();
                const name = thisfrm.elements.namedItem('productName').value.trim();
                const groupname = thisfrm.elements.namedItem('groupName').value.trim();
                const typename = thisfrm.elements.namedItem('typeName').value.trim();
                const suppliername = thisfrm.elements.namedItem('supplierName').value.trim();
                const max = thisfrm.elements.namedItem('stockMax').value.trim();
                const min = thisfrm.elements.namedItem('stockMin').value.trim();
                const stock1 = thisfrm.elements.namedItem('stockFront').value.trim();
                const stock2 = thisfrm.elements.namedItem('stockBack').value.trim();
                const price0 = thisfrm.elements.namedItem('priceInv').value.trim();
                const price1 = thisfrm.elements.namedItem('priceFront').value.trim();
                const price2 = thisfrm.elements.namedItem('priceBack').value.trim();
                const price3 = thisfrm.elements.namedItem('priceShop').value.trim();
                const store = thisfrm.elements.namedItem('store').value.trim();
                const updatedAt = new Date().addHours(7).toISOString().replace("T", " ").substr(0, 19);

                // let nowSyncTime = new Date().addHours(7).toISOString().replace("T", " ").substr(0, 19);


                if (!productId || !name) {
                    alert('กรุณากรอกข้อมูลให้ครบถ้วน');
                    return;
                }

                const product = {
                    productId,
                    name,
                    groupname,
                    typename,
                    suppliername,
                    max,
                    min,
                    stock1,
                    stock2,
                    price0,
                    price1,
                    price2,
                    price3,
                    store,
                    updatedAt
                };

                if (editId) {
                    const index = products.findIndex(m => m.productId === editId);
                    if (index !== -1) products[index] = product;
                } else {
                    products.push(product);
                }

                createFilterDataAndRender();
                //renderTable();
            }

            async function prepareDelete(item) {
                let deleteId = item.productId;
                let deleteName = item.name;
                message = `${deleteName}<BR>คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?`;
                confirm = await sweetConfirmDelete(message, "ใช่! ลบเลย");
                if (confirm) {
                    loaderScreen("show");
                    //confirmDelete(deleteId);
                    $.ajax({
                        type: "POST",
                        // method: "DELETE",
                        url: "services/deleteProduct.php",
                        data: {
                            productId: "12345689456"
                        }
                    }).done(function(resp) {
                        loaderScreen("hide");
                        if (resp.status) {
                            confirmDelete(deleteId);
                        } else {
                            sweetAlertError('เกิดข้อผิดพลาด : ' + resp.message);
                        }
                    }).fail(function(err) {
                        sweetAlertError('เกิดข้อผิดพลาด : ' + err.responseText); //  JSON.stringify(err)
                        loaderScreen("hide");
                    })
                }
            }

            function confirmDelete(deleteId) {
                products = products.filter(m => m.productId !== deleteId);
                createFilterDataAndRender();
                //renderTable();
            }

            const changeFilter = (item) => {
                if (item) {
                    searchData(1);
                    //$("#filterType").change(1);
                }
            }


            function createFilterDataAndRender() {
                currentPage = 1;
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

                sortData();

                // renderTable();
            }


            function renderTable() {
                const tbody = document.getElementById('productTable');
                tbody.innerHTML = '';

                const totalPages = Math.ceil(filtered.length / perPage);
                const start = (currentPage - 1) * perPage;
                const pageItems = filtered.slice(start, start + perPage);

                for (let i = 0; i < pageItems.length; i++) {
                    const m = pageItems[i];
                    tbody.insertAdjacentHTML('beforeend', `
                    <tr>
                        <td>${start + i + 1}</td>
                        <td>${m.productId}</td>
                        <td>${m.name}</td>
                        <td>${m.groupname}</td>
                        <td>${m.typename}</td>
                        <td>${m.price0}</td>
                        <td>
                        <button class="btn btn-sm btn-warning boxx text-white" onclick="openEditModal('${m.productId}')">แก้ไข</button>
                        <button class="btn btn-sm btn-danger boxx" onclick='prepareDelete(${JSON.stringify(m)})'>ลบ</button>
                        </td>
                    </tr>
                `);
                    // <button class="btn btn-sm btn-danger boxx" onclick="prepareDelete('${m.productId}','${m.name}')">ลบ</button>
                }

                renderPagination(currentPage, totalPages);
            }

            function renderPagination(current, total) {
                const pagination = document.getElementById('pagination');
                pagination.innerHTML = '';

                const addPage = (page, label = page, active = false, disabled = false) => {
                    const li = document.createElement('li');
                    li.className = `page-item${active ? ' active' : ''}${disabled ? ' disabled' : ''}`;
                    const a = document.createElement('a');
                    a.className = 'page-link';
                    a.href = '#';
                    a.textContent = label;
                    a.onclick = (e) => {
                        e.preventDefault();
                        if (!disabled && page) {
                            currentPage = page;
                            renderTable();
                        }
                    };
                    li.appendChild(a);
                    pagination.appendChild(li);
                };

                addPage(current - 1, '«', false, current === 1);
                for (let i = 1; i <= total; i++) {
                    if (i === 1 || i === total || Math.abs(i - current) <= 2) {
                        addPage(i, i, current === i);
                    } else if (i === 2) {
                        //addPage(null, '...');
                        addPage(parseInt(current / 2), '...');
                    } else if (i === total - 1) {
                        //addPage(null, '...');
                        addPage(total - parseInt((total - current) / 2), '...');
                    }
                    /*else if (i === 2 || i === total - 1) {
                         addPage(null, '...');
                       }*/
                }
                addPage(current + 1, '»', false, current === total);
            }

            function resetFilter() {
                document.getElementById('searchInput').value = '';
                document.getElementById('filterType').value = '';
                document.getElementById('filterGroup').value = '';
                currentPage = 1;
                createFilterDataAndRender();
                //renderTable();
            }
        </script>
</body>

</html>