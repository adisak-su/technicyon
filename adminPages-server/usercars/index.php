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
    <title>ระบบจัดการทะเบียนรถ | <?php echo $shopName; ?></title>
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.css">

    <!-- Favicons -->
    <?php include_once('../../includes/pagesFavicons.php'); ?>

    <!-- stylesheet -->
    <?php include_once('../../includes/pagesStylesheet.php'); ?>

    <!-- Font Awesome 6 (Free CDN) -->
    <!-- <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
 -->
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
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <label class="m-0 text-dark">จัดการทะเบียนรถ</label>
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
                                    <label class="mr-auto" style="line-height: 2.1rem">รายการทะเบียนรถ</label>
                                    <button class="btn btn-primary boxx float-right" data-bs-toggle="modal" data-bs-target="#itemModal" onclick="openAddModal()"><i class="fa fa-plus"></i> เพิ่มรายการ</a></button>
                                    <!-- <a href="form-create.php" class="btn btn-primary boxx float-right"><i class="fa fa-plus"></i> เพิ่มสินค้า</a> -->
                                </div>
                                <div class="card-body" style="font-size: 1rem;">
                                    <div class="row">
                                        <div class="col-12 col-md-2 col-lg-2 col-xl-2 form-group d-none">
                                            <label for="sorted" class="" style="padding:0px 0px;">จัดเรียง</label>
                                            <div class="input-icon-wrapper">
                                                <input class="toggle-event" id="sorted" data-id="" type="checkbox" name="sorted" checked data-toggle="toggle" data-off="ชื่อทะเบียนรถ" data-on="ทะเบียนรถ" data-onstyle="primary" data-offstyle="success" data-style="ios">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 form-group">
                                            <label for="searchInput" class="form-label">ทะเบียนรถ</label>
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input type="text" class="form-control" id="searchInput" value="" placeholder="" value="" autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-2 col-xl-2 form-group align-content-end">
                                            <button class="btn secondary boxx text-white" onclick="resetFilter()">ล้างตัวกรอง</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-2">
                                        <table class="table table-bordered table-striped align-middle">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th style="min-width: 40px;">#</th>
                                                    <th style="min-width: 50px;" onclick="sortColumnBy('carId',this);">
                                                        <div class="d-flex justify-content-around">
                                                            <div>ทะเบียน</div>
                                                            <div id="icon"></div>
                                                        </div>
                                                    </th>
                                                    <th style="min-width: 120px;" onclick="sortColumnBy('groupname',this);">
                                                        <div class="d-flex justify-content-around">
                                                            <div>ยี่ห้อ/รุ่น</div>
                                                            <div id="icon"></div>
                                                        </div>
                                                    </th>
                                                    <th style="min-width: 120px;" onclick="sortColumnBy('colorname',this);">
                                                        <div class="d-flex justify-content-around">
                                                            <div>สี</div>
                                                            <div id="icon"></div>
                                                        </div>
                                                    </th>
                                                    <th style="min-width: 120px;" onclick="sortColumnBy('mile',this);">
                                                        <div class="d-flex justify-content-around">
                                                            <div>เลขไมล์</div>
                                                            <div id="icon"></div>
                                                        </div>
                                                    </th>
                                                    <th style="min-width: 120px;" onclick="sortColumnBy('year',this);">
                                                        <div class="d-flex justify-content-around">
                                                            <div>ปี</div>
                                                            <div id="icon"></div>
                                                        </div>
                                                    </th>
                                                    <th style="min-width: 120px;" onclick="sortColumnBy('vehicleId',this);">
                                                        <div class="d-flex justify-content-around">
                                                            <div>เลขตัวถัง</div>
                                                            <div id="icon"></div>
                                                        </div>
                                                    </th>
                                                    <th style="min-width: 120px;" onclick="sortColumnBy('name',this);">
                                                        <div class="d-flex justify-content-around">
                                                            <div>เจ้าของ</div>
                                                            <div id="icon"></div>
                                                        </div>
                                                    </th>
                                                    <th style="min-width: 120px;" onclick="sortColumnBy('address',this);">
                                                        <div class="d-flex justify-content-around">
                                                            <div>ที่อยู่</div>
                                                            <div id="icon"></div>
                                                        </div>
                                                    </th>
                                                    <th style="min-width: 120px;" onclick="sortColumnBy('telephone',this);">
                                                        <div class="d-flex justify-content-around">
                                                            <div>เบอร์โทร</div>
                                                            <div id="icon"></div>
                                                        </div>
                                                    </th>
                                                    <th style="min-width: 140px;">การจัดการ</th>
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

    <div class="modal" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width:auto;max-width:800px;">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="border-radius:25px 25px 0px 0px;">
                    <h5 class="modal-title" id="itemModalLabel">เพิ่ม/แก้ไข รายการ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="glass-card mb-2">
                            <form id="itemForm">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-3 form-group position-relative mb-3">
                                        <input
                                            type="hidden"
                                            class="form-control"
                                            id="itemId_org"
                                            placeholder="ทะเบียนรถ..." />
                                        <label for="itemId" class="form-label">ทะเบียนรถ</label>
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
                                    <div class="col-12 col-md-6 col-lg-6 form-group position-relative mb-3">
                                        <label for="itemGroupName" class="form-label">ยี่ห้อ/รุ่นรถ</label>
                                        <div class="form-group autocomplete-container mb-4">
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon"></i>
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
                                    <div class="col-12 col-md-6 col-lg-3 form-group position-relative mb-3">
                                        <label for="itemYear" class="form-label">ปี</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon"></i>
                                            <input
                                                type="text"
                                                class="form-control text-center"
                                                id="itemYear"
                                                value=""
                                                maxlength="10"
                                                placeholder=""
                                                autocomplete="off" />
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-3 form-group position-relative mb-3">
                                        <label for="itemColor" class="form-label">สีรถยนต์</label>
                                        <div class="form-group autocomplete-container mb-4">
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon"></i>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="itemColor"
                                                    value=""
                                                    maxlength="20"
                                                    placeholder=""
                                                    autocomplete="off" />
                                                <div id="colorNameSuggestions" class="suggestions"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 form-group position-relative mb-3">
                                        <label for="itemVehicleId" class="form-label">เลขตัวถัง</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon"></i>
                                            <input
                                                type="text"
                                                class="form-control text-left"
                                                id="itemVehicleId"
                                                value=""
                                                maxlength="50"
                                                placeholder=""
                                                autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3 form-group position-relative mb-3">
                                        <label for="itemMile" class="form-label">เลขไมล์</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon"></i>
                                            <input
                                                type="text"
                                                class="form-control text-center"
                                                id="itemMile"
                                                value=0
                                                maxlength="10"
                                                placeholder=""
                                                autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 form-group position-relative mb-3">
                                        <label for="itemName" class="form-label">ชื่อ</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon"></i>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="itemName"
                                                value=""
                                                maxlength="50"
                                                placeholder=""
                                                autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-12 form-group position-relative mb-3">
                                        <label for="itemAddress" class="form-label">ที่อยู่</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon"></i>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="itemAddress"
                                                value=""
                                                maxlength="100"
                                                placeholder=""
                                                autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-12 form-group position-relative mb-3">
                                        <label for="itemTelephone" class="form-label">เบอร์โทร</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon"></i>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="itemTelephone"
                                                value=""
                                                maxlength="25"
                                                placeholder=""
                                                autocomplete="off" />
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

    <!-- SCRIPTS -->
    <?php include_once('../../includes/pagesScript.php') ?>
    <?php include_once('../../includes/myScript.php') ?>
    <script src="../indexedDB/indexedDB.js?<?php echo time(); ?>"></script>

    <script src="../serviceDB/startInitData.js?<?php echo time(); ?>"></script>

    <script src="../js/renderPagination.js"></script>
    <script src="../js/sortColumnBy.js"></script>
    <script src="../js/validateInput.js?<?php echo time(); ?>"></script>
    <script src="../js/autocomplete.js?<?php echo time(); ?>"></script>
    <script type="text/javascript">
        let usercars = [];
        let colorNames = [];
        let groupNames = [];
        let filtered = [];

        let currentPage = 1;
        const perPage = 10;
        let editId = null;
        let deleteId = null;

        const STORE = "usercars";

        //สำหรับการจัดเรียงข้อมูล
        let sortColumn = [{
            colName: "carId",
            state: "ASC"
        }, {
            colName: "groupname",
            state: "ASC"
        }, {
            colName: "colorname",
            state: "ASC"
        }, {
            colName: "mile",
            state: "ASC"
        }, {
            colName: "year",
            state: "ASC"
        }, {
            colName: "vehicleId",
            state: "ASC"
        }, {
            colName: "name",
            state: "ASC"
        }, {
            colName: "address",
            state: "ASC"
        }, {
            colName: "telephone",
            state: "ASC"
        }, ];

        //ตั้งค่าสำหรับการตรวจสอบข้อมูลการ Input
        let validateInputForm = null;
        let arrayValidateInput = []

        function createValidate() {
            arrayValidateInput = [{
                    id: "itemId",
                    name: "ทะเบียนรถ",
                    type: "value"
                },
                {
                    id: "itemGroupName",
                    name: "ยี่ห้อ/รุ่นรถยนต์",
                    type: "list",
                    dataSource: groupNames,
                    key: "groupname",
                    require: true,
                },
                {
                    id: "itemColor",
                    name: "สีรถยนต์",
                    type: "list",
                    dataSource: colorNames,
                    key: "colorname",
                    require: true,
                }
            ];
            validateInputForm = new ValidateInput("itemModal", arrayValidateInput);
        }

        async function openAddModal() {
            editId = null;
            document.getElementById('itemForm').reset();
            $('#itemModal #itemModalLabel').text('เพิ่มรายการ');
            $('#itemModal .modal-header').addClass("bg-primary");
            $('#itemModal .modal-header').removeClass("bg-warning");

            $('#itemModal').modal("show");
        }

        function openEditModal(id) {
            editId = null;
            const m = usercars.find(x => x.carId == id);

            if (m) {
                editId = id;
                const thisfrm = document.getElementById('itemForm');
                thisfrm.elements.namedItem("itemId_org").value = id;
                thisfrm.elements.namedItem("itemId").value = id;
                thisfrm.elements.namedItem("itemGroupName").value = m.groupname;
                thisfrm.elements.namedItem("itemColor").value = m.colorname;
                thisfrm.elements.namedItem("itemMile").value = m.mile;
                thisfrm.elements.namedItem("itemYear").value = m.year;
                thisfrm.elements.namedItem("itemVehicleId").value = m.vehicleId;
                thisfrm.elements.namedItem("itemName").value = m.name;
                thisfrm.elements.namedItem("itemAddress").value = m.address;
                thisfrm.elements.namedItem("itemTelephone").value = m.telephone;

                $('#itemModal #itemModalLabel').text('แก้ไขรายการ');
                $('#itemModal .modal-header').addClass("bg-warning");
                $('#itemModal .modal-header').removeClass("bg-primary");

                $('#itemModal').modal("show");
            }
        }

        function saveItem() {
            // let statusValidate = validateInputForm.validateList("itemColor","colorname",colorNames);

            // if (!statusValidate.status) {
            //     let invalidStr = statusValidate.invalidString;
            //     sweetAlertError('กรุณากรอกข้อมูลให้ถูกต้อง' + invalidStr, 5000);
            //     return;
            // }

            let statusValidate = validateInputForm.validate();

            if (!statusValidate.status) {
                let invalidStr = statusValidate.invalidString;
                sweetAlertError('กรุณากรอกข้อมูลให้ครบถ้วน' + invalidStr, 5000);
                return;
            }


            const thisfrm = document.getElementById('itemForm');
            const itemId_org = editId || thisfrm.elements.namedItem('itemId_org').value.trim();
            const itemId = thisfrm.elements.namedItem('itemId').value.trim();
            // const itemGroupName = thisfrm.elements.namedItem('itemGroupName').value.trim() !== "" ? thisfrm.elements.namedItem('itemGroupName').value.trim() : "-";
            const itemGroupName = thisfrm.elements.namedItem('itemGroupName').value.trim();
            const itemColor = thisfrm.elements.namedItem('itemColor').value.trim() !== "" ? thisfrm.elements.namedItem('itemColor').value.trim() : "-";
            const itemMile = thisfrm.elements.namedItem('itemMile').value.trim() !== "" ? thisfrm.elements.namedItem('itemMile').value.trim() : "-";
            const itemYear = thisfrm.elements.namedItem('itemYear').value.trim() !== "" ? thisfrm.elements.namedItem('itemYear').value.trim() : "-";
            const itemVehicleId = thisfrm.elements.namedItem('itemVehicleId').value.trim() !== "" ? thisfrm.elements.namedItem('itemVehicleId').value.trim() : "-";
            const itemName = thisfrm.elements.namedItem('itemName').value.trim() !== "" ? thisfrm.elements.namedItem('itemName').value.trim() : "-";
            const itemAddress = thisfrm.elements.namedItem('itemAddress').value.trim() !== "" ? thisfrm.elements.namedItem('itemAddress').value.trim() : "-";
            const itemTelephone = thisfrm.elements.namedItem('itemTelephone').value.trim() !== "" ? thisfrm.elements.namedItem('itemTelephone').value.trim() : "-";
            const updatedAt = getDateTimeNow();

            const item = {
                "carId": itemId,
                "groupname": itemGroupName,
                "colorname": itemColor,
                "mile": itemMile,
                "year": itemYear,
                "vehicleId": itemVehicleId,
                "name": itemName,
                "address": itemAddress,
                "telephone": itemTelephone,
                updatedAt
            };

            let dataSend = {
                "itemId_org": itemId_org,
                "itemId": itemId,
                "itemGroupName": itemGroupName,
                "itemColor": itemColor,
                "itemMile": itemMile,
                "itemYear": itemYear,
                "itemVehicleId": itemVehicleId,
                "itemName": itemName,
                "itemAddress": itemAddress,
                "itemTelephone": itemTelephone,
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
            let deleteId = item.carId;
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
                        confirmDelete(deleteId)
                    } else {
                        sweetAlertError('เกิดข้อผิดพลาด : ' + resp.message, 3000);
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
                const index = usercars.findIndex(m => m.carId == editId);
                if (index !== -1) {
                    usercars[index] = item;
                }
            } else {
                usercars.push(item);
            }
            createFilterDataAndRender();
        }

        function confirmDelete(deleteId) {
            usercars = usercars.filter(m => m.carId != deleteId);
            filtered = filtered.filter(m => m.carId != deleteId);
            renderTable();
        }

        // function createFilterDataAndRender() {
        //     currentPage = 1;
        //     const searchText = document.getElementById('searchInput').value.trim().toLowerCase();
        //     filtered = usercars;

        //     if (searchText) {
        //         filtered = filtered.filter(m =>
        //             m.carId.toLowerCase().includes(searchText) ||
        //             m.name.toLowerCase().includes(searchText)
        //         );
        //     }
        //     renderTable();
        // }

        function createFilterDataAndRender(page=1) {
            currentPage = page;
            const searchText = document.getElementById('searchInput').value.trim().toLowerCase();
            filtered = usercars;

            if (searchText) {
                filtered = filtered.filter(m =>
                    m.carId.toLowerCase().includes(searchText) ||
                    m.name.toLowerCase().includes(searchText)
                );
            }
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
                        <td>${m.carId}</td>
                        <td>${m.groupname}</td>
                        <td>${m.colorname}</td>
                        <td>${m.mile}</td>
                        <td>${m.year}</td>
                        <td>${m.vehicleId}</td>
                        <td>${m.name}</td>
                        <td>${m.address}</td>
                        <td>${m.telephone}</td>
                        <td>
                            <div class="d-flex justify-content-around">
                                <button class="btn btn-sm btn-warning boxx text-white" onclick="openEditModal('${m.carId}')">แก้ไข</button>
                                <button class="btn btn-sm btn-danger boxx" onclick='prepareDelete(${JSON.stringify(m)})'>ลบ</button>
                            </div>
                        </td>
                    </tr>
                `);
            }

            renderPagination(currentPage, totalPages);
        }

        function resetFilter() {
            document.getElementById('searchInput').value = '';
            createFilterDataAndRender();
        }

        $(document).ready(async function() {
            try {
                loaderScreen("show");
                // await syncOnLoad();
                // usercars = await loadDataFromDB("usercars");
                // createFilterDataAndRender();
                // groupNames = await loadAndSetData("groupnames");
                // colorNames = await loadAndSetData("colornames");

                usercars = await loadDataFromServer("usercar");
                createFilterDataAndRender();
                groupNames = await loadDataFromServer("groupname");
                setDataAutocomplete("groupname", groupNames);
                colorNames = await loadDataFromServer("colorname");
                setDataAutocomplete("colorname", colorNames);

                createValidate();

                // groupNames = await loadAndSetData("groupname");
                // colorNames = await loadAndSetData("colorname");

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

            $('#searchInput').on('input', function() {
                createFilterDataAndRender();
            });


            // lastDataSyncTime = getDateTimeNow();
            // syncDataRealtimeDB(lastDataSyncTime);
            setInterval(syncDataRealtimeServer, 10000); // 10 วินาที

            // setInterval(syncDataRealtime, 10000); // 10 วินาที
        });

        async function syncDataRealtime() {
            try {
                // loaderScreen("show");
                let dataSource = await updateSyncData({
                    dataName: "usercars"
                });
                if (dataSource) {
                    usercars = dataSource;
                    createFilterDataAndRender();
                }
            } catch (error) {
                sweetAlertError("เกิดข้อผิดพลาด : " + error.message, 0);
            } finally {
                // loaderScreen("hide");
            }
        }

        async function syncDataRealtimeServer() {
            let dataExpires = [];
            try {
                // loaderScreen("show");
                dataExpires = await startCheckDataExpired(["usercar", "colorname", "groupname", "typename"]);
            } catch (error) {
                let message = error?.responseJSON?.message ?? error.responseText;
                sweetAlertError('เกิดข้อผิดพลาด : ' + message, 0);
            } finally {
                if (dataExpires.length) {
                    dataExpires.forEach((item) => {
                        if (item.statusType === "updateExpire") {
                            switch (item.tableName) {
                                case "colorname":
                                    colorNames = item.data;
                                    colorNames = colorNames.sortASC("colorname");
                                    setDataAutocomplete("colorname", colorNames);
                                    break;
                                case "groupname":
                                    groupNames = item.data;
                                    groupNames = groupNames.sortASC("groupname");
                                    setDataAutocomplete("groupname", groupNames);
                                    break;
                                case "usercar":
                                    usercars = item.data;
                                    usercars = usercars.sortASC("carId");
                                    createFilterDataAndRender(currentPage);
                                    break;
                            }
                        } else if (item.statusType === "insertExpire") {
                            switch (item.tableName) {
                                case "colorname":
                                    item.data.forEach((item) => {
                                        colorNames.push(item);
                                    });
                                    colorNames = colorNames.sortASC("colorname");
                                    setDataAutocomplete("colorname", colorNames);
                                    break;
                                case "groupname":
                                    item.data.forEach((item) => {
                                        groupNames.push(item);
                                    });
                                    groupNames = groupNames.sortASC("groupname");
                                    setDataAutocomplete("groupname", groupNames);
                                    break;
                                case "usercar":
                                    item.data.forEach((item) => {
                                        usercars.push(item);
                                    });
                                    usercars = usercars.sortASC("carId");
                                    createFilterDataAndRender(currentPage);
                                    break;
                            }
                        }
                    });
                    createValidate();
                }
            }
        }

        async function setDataAutocomplete(storeName, dataStore) {
            try {
                if (storeName == "groupname") {
                    /*
                    setupAutocomplete(
                        "groupName", "groupNameSuggestions", groupNames, "groupname", ["groupname"], ["groupname"], null, setProductName);
                        */
                    setupAutocompleteOnFocus({
                        inputId: "itemGroupName",
                        suggestionsId: "groupNameSuggestions",
                        dataList: dataStore,
                        codeId: "groupname",
                        arrayShowValue: ["groupname"],
                        arrayFindValue: ["groupname"],
                        // callbackFunction: setProductName,
                        sortField: "groupname"
                    });
                    // return dataStore;
                } else if (storeName == "colorname") {
                    setupAutocompleteOnFocus({
                        inputId: "itemColor",
                        suggestionsId: "colorNameSuggestions",
                        dataList: dataStore,
                        codeId: "colorname",
                        arrayShowValue: ["colorname"],
                        arrayFindValue: ["colorname"],
                        //callbackFunction: dataFilterProductModal,
                        sortField: "colorname"
                    });
                    // return dataStore;
                }

            } catch (error) {
                sweetAlertError("เกิดข้อผิดพลาด : " + error.message, 0);
            }
        }
    </script>
</body>

</html>