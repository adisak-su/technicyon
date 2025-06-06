<?php
require_once('../authen.php');
require_once("../../service/configData.php");
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                                    <div class="container" style="max-width:90%;">
                                        <div class="row">
                                            <div class="col-9 col-lg-6 col-xl-3">
                                                <input type="text" id="searchInput" class="inputStyle inputStyleIcon inputStyleFind cursorHand" placeholder="รหัสสินค้าหรือชื่อ..." autocomplete="off">
                                            </div>
                                            <div class="col-3 col-lg-6 col-xl-9">
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

                                    <div class="row align-items-end">
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <!-- ค้นหาสินค้า -->
                                            <div class="container-input-label">
                                                <label for="productInput">สินค้า</label>
                                                <div class="autocomplete-container">
                                                    <input type="text" id="productInput" class="inputStyle inputStyleIcon inputStyleFind cursorHand" placeholder="รหัสสินค้าหรือชื่อ..." autocomplete="off">
                                                    <button id="btnViewProduct" class="button btn btn-primary btn-fa" style="" data-toggle="modal" data-target="#viewProductModal"><i class="fa fa-search"></i></button>
                                                    <input type="hidden" id="productCode">
                                                    <div id="productSuggestions" class="suggestions"></div>
                                                    <!-- <div id="productDetails" class="details-box"></div> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <!-- ค้นหาสินค้า -->
                                            <div class="container-input-label">
                                                <label for="productName">สินค้า</label>
                                                <input type="text" id="productName" class="inputStyle inputStyleIcon cursorHand" placeholder="..." autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-4 col-md-3 col-lg-1">
                                            <!-- ค้นหาสินค้า -->
                                            <div class="container-input-label">
                                                <label for="productQty">จำนวน</label>
                                                <input type="text" id="productQty" class="inputStyle cursorHand text-right" placeholder="0" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-4 col-md-3 col-lg-1">
                                            <!-- ค้นหาสินค้า -->
                                            <div class="container-input-label">
                                                <label for="productPrice">ราคา/หน่วย</label>
                                                <input type="text" id="productPrice" class="inputStyle cursorHand text-right" placeholder="" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-4 col-md-3 col-lg-1">
                                            <!-- ค้นหาสินค้า -->
                                            <div class="container-input-label">
                                                <label for="productTotal">ราคา</label>
                                                <input type="text" id="productTotal" class="inputStyle cursorHand text-right" placeholder="0" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 col-lg-2 mb-0">
                                            <!-- ค้นหาสินค้า -->
                                            <button id="btn-add-product" class="btn btn-success boxx"><i class="fa fa-plus"></i> เพิ่มสินค้า</button>
                                        </div>
                                    </div>
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
                </div> -->

    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:auto;max-width:800px;">
            <div class="modal-content">
                <div class="modal-header bg-primary">
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
                                                    placeholder="ยี่ห้อ/รุ่นรถ..." autocomplete="off" />

                                                <!-- <input type="text" id="supplierName" class="inputStyle inputStyleIcon cursorHand" placeholder="ชื่อร้านค้า..." autocomplete="off"> -->
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
                                                    placeholder="ประเภทสินค้า..." autocomplete="off" />

                                                <!-- <input type="text" id="supplierName" class="inputStyle inputStyleIcon cursorHand" placeholder="ชื่อร้านค้า..." autocomplete="off"> -->
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

        <!-- SCRIPTS -->
        <?php include_once('../../includes/pagesScript.php') ?>
        <?php include_once('../../includes/myScript.php') ?>
        <script src="../indexedDB/indexedDB.js"></script>
        <script type="text/javascript">
            let products = [];
            let groupNames = [];
            let typeNames = [];
            let suppliers = [];

            let currentPage = 1;
            const perPage = 10;
            let editId = null;
            let deleteId = null;

            async function loadAndSetData(storeName) {
                let dataStore = await loadDataFromDB(storeName);
                if (storeName == "products") {
                    products = dataStore;
                    setupAutocomplete(
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
                    renderTable();
                } else if (storeName == "groupnames") {
                    groupNames = dataStore;
                    setupAutocomplete(
                        "groupName", "groupNameSuggestions", groupNames, "groupname", ["groupname"], ["groupname"]);
                } else if (storeName == "typenames") {
                    typeNames = dataStore;
                    setupAutocomplete(
                        "typeName", "typeNameSuggestions", typeNames, "typename", ["typename"], ["typename"]);
                } else if (storeName == "suppliers") {
                    suppliers = dataStore;
                    setupAutocomplete(
                        "supplierName", "supplierNameSuggestions", suppliers, "name", ["name"], ["supplierId", "name"]);
                }
            }

            $(document).ready(async function() {
                await openDB();
                loadAndSetData("products");
                loadAndSetData("groupnames");
                loadAndSetData("typenames");
                loadAndSetData("suppliers");

                $('#searchInput').on('input', function() {
                    currentPage = 1;
                    renderTable();
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
            });

            function openAddModal() {
                editId = null;
                document.getElementById('productForm').reset();
                $('#productModalLabel').text('เพิ่มสินค้า');
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
                    thisfrm.elements.namedItem("stockTotal").value = 100;

                    thisfrm.elements.namedItem("priceInv").value = m.price0;
                    thisfrm.elements.namedItem("priceFront").value = m.price1;
                    thisfrm.elements.namedItem("priceBack").value = m.price2;
                    thisfrm.elements.namedItem("priceShop").value = m.price3;
                    thisfrm.elements.namedItem("store").value = m.store;

                    // document.getElementById('productId').value = m.productId;
                    // document.getElementById('productName').value = m.name;
                    // document.getElementById('groupName').value = m.groupname;
                    // document.getElementById('typeName').value = m.typename;
                    // document.getElementById('supplierName').value = m.suppliername;
                    // document.getElementById('stockMax').value = m.max;
                    // document.getElementById('stockMin').value = m.min;
                    // document.getElementById('stockFront').value = m.stock1;
                    // document.getElementById('stockBack').value = m.stock2;
                    // document.getElementById('stockTotal').value = 100;

                    // document.getElementById('priceInv').value = m.price0;
                    // document.getElementById('priceFront').value = m.price1;
                    // document.getElementById('priceBack').value = m.price2;
                    // document.getElementById('priceShop').value = m.price3;
                    // document.getElementById('store').value = m.store;
                    $('#productModalLabel').text('แก้ไขสินค้า');
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

                renderTable();
            }

            async function prepareDelete(deleteId, deleteName) {
                message = `${deleteName}<BR>คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?`;
                confirm = await sweetConfirmDelete(message, "ใช่! เลิกเลย");
                if (confirm) {
                    loaderScreen("show");
                    confirmDelete(deleteId);
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
                renderTable();
            }

            function renderTable() {
                const tbody = document.getElementById('productTable');
                tbody.innerHTML = '';
                // const filter = document.getElementById('filterProvince').value;
                const searchText = document.getElementById('searchInput').value.trim().toLowerCase();

                let filtered = products;

                // if (filter !== 'all') {
                //     filtered = filtered.filter(m => m.province === filter);
                // }

                if (searchText) {
                    filtered = filtered.filter(m =>
                        m.productId.toLowerCase().includes(searchText) ||
                        m.name.toLowerCase().includes(searchText)
                    );
                }

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
                        <td>
                        <button class="btn btn-sm btn-warning boxx text-white" onclick="openEditModal('${m.productId}')">แก้ไข</button>
                        <button class="btn btn-sm btn-danger boxx" onclick="prepareDelete('${m.productId}','${m.name}')">ลบ</button>
                        </td>
                    </tr>
                `);
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
                currentPage = 1;
                renderTable();
            }
            // function setupAutocomplete(inputId, suggestionsId, dataList, codeId, arraySetValue, hiddenId, displayField1 , detailsId, displayField2) {


            function setupAutocomplete(inputId, suggestionsId, dataList, codeId, arrayShowValue, arrayFindValue, arraySetValue = null) {
                const input = document.getElementById(inputId);
                const suggestionsBox = document.getElementById(suggestionsId);
                // if (arraySetValue.length) {

                // }
                // const hiddenInput = document.getElementById(hiddenId);
                // const detailsBox = document.getElementById(detailsId);
                let currentFocus = -1;

                input.addEventListener("input", function() {
                    const value = this.value.toLowerCase();
                    suggestionsBox.innerHTML = "";
                    currentFocus = -1;
                    // detailsBox.textContent = "";
                    if (arraySetValue) {
                        arraySetValue.forEach((item) => {
                            document.getElementById(item.elementId).value = "";
                        });
                    }

                    // hiddenInput.value = "";

                    if (!value || value.length < 2) return;

                    // const matches = dataList.filter(item =>
                    //     item[codeId].toLowerCase().includes(value) || item.name.toLowerCase().includes(value)
                    // );

                    // let matches = dataList.filter(item =>
                    //     item[codeId].toLowerCase().includes(value) || item.name.toLowerCase().includes(value)
                    // );
                    let matches = dataList;

                    arrayFindValue.forEach((findItem) => {
                        matches = dataList.filter(item =>
                            item[findItem].toLowerCase().includes(value)
                        );
                    });

                    if (matches.length) {
                        suggestionsBox.classList.add("suggestions-active");
                    } else {
                        suggestionsBox.classList.remove("suggestions-active");
                    }

                    matches.forEach(item => {
                        const div = document.createElement("div");
                        let strShowValue = "";
                        if (arrayShowValue.length) {
                            strShowValue += item[arrayShowValue[0]];
                        }
                        arrayShowValue.forEach((show, index) => {
                            if (index !== 0) {
                                strShowValue += " : " + item[show];
                            }
                        });
                        // let valueCodeName = codeName ? item[codeName] : "";
                        // div.textContent =  `${item[codeId]} - ${valueCodeName}`;
                        div.textContent = strShowValue;
                        div.classList.add("suggestion-item");
                        div.addEventListener("click", () => {
                            // input.value = `${item[codeId]} - ${item[displayField1]}`;
                            input.value = `${item[codeId]}`;
                            if (arraySetValue) {
                                arraySetValue.forEach((element) => {
                                    document.getElementById(element.elementId).value = item[element.elementValue];
                                });
                            }
                            // hiddenInput.value = item[codeId];
                            // detailsBox.value = `${displayField1}: ${item[displayField1]} | ${displayField2}: ${item[displayField2]}`;
                            // detailsBox.value = item[displayField1];
                            suggestionsBox.innerHTML = "";
                        });
                        suggestionsBox.appendChild(div);
                    });
                });

                input.addEventListener("keydown", function(e) {
                    const items = suggestionsBox.querySelectorAll(".suggestion-item");

                    if (e.key === "ArrowDown") {
                        currentFocus++;
                        if (currentFocus >= items.length) currentFocus = 0;
                        setActive(items);
                        e.preventDefault();
                    } else if (e.key === "ArrowUp") {
                        currentFocus--;
                        if (currentFocus < 0) currentFocus = items.length - 1;
                        setActive(items);
                        e.preventDefault();
                    } else if (e.key === "Enter") {
                        if (currentFocus > -1 && items[currentFocus]) {
                            items[currentFocus].click();
                        }
                        e.preventDefault();
                    }
                });

                function setActive(items) {
                    if (!items.length) return;
                    items.forEach(item => item.classList.remove("active"));
                    items[currentFocus]?.classList.add("active");
                    items[currentFocus]?.scrollIntoView({
                        block: "nearest"
                    });
                }

                document.addEventListener("click", (e) => {
                    if (!e.target.closest(`#${inputId}`)) {
                        suggestionsBox.innerHTML = "";
                        suggestionsBox.classList.remove("suggestions-active");
                    }
                });
            }

            function setupAutocompleteProducts(inputId, suggestionsId, dataList, codeId, arrayShowValue, arrayFindValue, arraySetValue = null) {
                const input = document.getElementById(inputId);
                const suggestionsBox = document.getElementById(suggestionsId);

                let currentFocus = -1;

                input.addEventListener("input", function() {
                    const value = this.value.toLowerCase();
                    suggestionsBox.innerHTML = "";
                    currentFocus = -1;
                    // detailsBox.textContent = "";
                    if (arraySetValue) {
                        arraySetValue.forEach((item) => {
                            document.getElementById(item.elementId).value = "";
                        });
                    }

                    // hiddenInput.value = "";

                    if (!value || value.length < 2) return;

                    // const matches = dataList.filter(item =>
                    //     item[codeId].toLowerCase().includes(value) || item.name.toLowerCase().includes(value)
                    // );

                    // let matches = dataList.filter(item =>
                    //     item[codeId].toLowerCase().includes(value) || item.name.toLowerCase().includes(value)
                    // );
                    let matches = dataList;

                    arrayFindValue.forEach((findItem) => {
                        matches = dataList.filter(item =>
                            item[findItem].toLowerCase().includes(value)
                        );
                    });

                    if (matches.length) {
                        suggestionsBox.classList.add("suggestions-active");
                    } else {
                        suggestionsBox.classList.remove("suggestions-active");
                    }

                    matches.forEach(item => {
                        const div = document.createElement("div");
                        let strShowValue = "";
                        if (arrayShowValue.length) {
                            strShowValue += item[arrayShowValue[0]];
                        }
                        arrayShowValue.forEach((show, index) => {
                            if (index !== 0) {
                                strShowValue += " : " + item[show];
                            }
                        });
                        // let valueCodeName = codeName ? item[codeName] : "";
                        // div.textContent =  `${item[codeId]} - ${valueCodeName}`;
                        div.textContent = strShowValue;
                        div.classList.add("suggestion-item");
                        div.addEventListener("click", () => {
                            // input.value = `${item[codeId]} - ${item[displayField1]}`;
                            input.value = `${item[codeId]}`;
                            if (arraySetValue) {
                                arraySetValue.forEach((element) => {
                                    document.getElementById(element.elementId).value = item[element.elementValue];
                                });
                            }
                            // hiddenInput.value = item[codeId];
                            // detailsBox.value = `${displayField1}: ${item[displayField1]} | ${displayField2}: ${item[displayField2]}`;
                            // detailsBox.value = item[displayField1];
                            suggestionsBox.innerHTML = "";
                        });
                        suggestionsBox.appendChild(div);
                    });
                });

                input.addEventListener("keydown", function(e) {
                    const items = suggestionsBox.querySelectorAll(".suggestion-item");

                    if (e.key === "ArrowDown") {
                        currentFocus++;
                        if (currentFocus >= items.length) currentFocus = 0;
                        setActive(items);
                        e.preventDefault();
                    } else if (e.key === "ArrowUp") {
                        currentFocus--;
                        if (currentFocus < 0) currentFocus = items.length - 1;
                        setActive(items);
                        e.preventDefault();
                    } else if (e.key === "Enter") {
                        if (currentFocus > -1 && items[currentFocus]) {
                            items[currentFocus].click();
                        }
                        e.preventDefault();
                    }
                });

                function setActive(items) {
                    if (!items.length) return;
                    items.forEach(item => item.classList.remove("active"));
                    items[currentFocus]?.classList.add("active");
                    items[currentFocus]?.scrollIntoView({
                        block: "nearest"
                    });
                }

                document.addEventListener("click", (e) => {
                    if (!e.target.closest(`#${inputId}`)) {
                        suggestionsBox.innerHTML = "";
                        suggestionsBox.classList.remove("suggestions-active");
                    }
                });
            }

            function _setupAutocomplete(inputId, suggestionsId, hiddenId, detailsId, dataList, codeId, displayField1, displayField2) {
                const input = document.getElementById(inputId);
                const suggestionsBox = document.getElementById(suggestionsId);
                const hiddenInput = document.getElementById(hiddenId);
                const detailsBox = document.getElementById(detailsId);
                let currentFocus = -1;

                input.addEventListener("input", function() {
                    const value = this.value.toLowerCase();
                    suggestionsBox.innerHTML = "";
                    currentFocus = -1;
                    // detailsBox.textContent = "";
                    hiddenInput.value = "";

                    if (!value || value.length < 2) return;

                    const matches = dataList.filter(item =>
                        item[codeId].toLowerCase().includes(value) || item.name.toLowerCase().includes(value)
                    );

                    if (matches.length) {
                        suggestionsBox.classList.add("suggestions-active");
                    } else {
                        suggestionsBox.classList.remove("suggestions-active");
                    }

                    matches.forEach(item => {
                        const div = document.createElement("div");
                        div.textContent = `${item[codeId]} - ${item.name}`;
                        div.classList.add("suggestion-item");
                        div.addEventListener("click", () => {
                            input.value = `${item[codeId]} - ${item[displayField1]}`;
                            input.value = `${item[codeId]}`;
                            hiddenInput.value = item[codeId];
                            // detailsBox.value = `${displayField1}: ${item[displayField1]} | ${displayField2}: ${item[displayField2]}`;
                            detailsBox.value = item[displayField1];
                            suggestionsBox.innerHTML = "";
                        });
                        suggestionsBox.appendChild(div);
                    });
                });

                input.addEventListener("keydown", function(e) {
                    const items = suggestionsBox.querySelectorAll(".suggestion-item");

                    if (e.key === "ArrowDown") {
                        currentFocus++;
                        if (currentFocus >= items.length) currentFocus = 0;
                        setActive(items);
                        e.preventDefault();
                    } else if (e.key === "ArrowUp") {
                        currentFocus--;
                        if (currentFocus < 0) currentFocus = items.length - 1;
                        setActive(items);
                        e.preventDefault();
                    } else if (e.key === "Enter") {
                        if (currentFocus > -1 && items[currentFocus]) {
                            items[currentFocus].click();
                        }
                        e.preventDefault();
                    }
                });

                function setActive(items) {
                    if (!items.length) return;
                    items.forEach(item => item.classList.remove("active"));
                    items[currentFocus]?.classList.add("active");
                    items[currentFocus]?.scrollIntoView({
                        block: "nearest"
                    });
                }

                document.addEventListener("click", (e) => {
                    if (!e.target.closest(`#${inputId}`)) {
                        suggestionsBox.innerHTML = "";
                        suggestionsBox.classList.remove("suggestions-active");
                    }
                });
            }
        </script>
</body>

</html>