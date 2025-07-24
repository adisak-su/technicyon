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
                                                    <th style="min-width: 50px;" onclick="sortColumnBy('usercarId',this);">
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
    <!-- <script src="../indexedDB/indexedDB.js?<?php echo time(); ?>"></script> -->
    <script src="../serviceDataServer/startInitData.js?<?php echo time(); ?>"></script>
    <script src="../js/renderPagination.js"></script>
    <script src="../js/sortColumnBy.js?<?php echo time(); ?>"></script>
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

        // use for another update data
        // let lastDataSyncTime = getDateTimeNow();
        // alert(lastDataSyncTime)

        const STORE = "usercars";

        //สำหรับการจัดเรียงข้อมูล
        let sortColumn = [{
            colName: "usercarId",
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
            const m = usercars.find(x => x.usercarId == id);

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
            const itemGroupName = thisfrm.elements.namedItem('itemGroupName').value.trim();
            const itemColor = thisfrm.elements.namedItem('itemColor').value.trim();
            const itemMile = thisfrm.elements.namedItem('itemMile').value.trim();
            const itemYear = thisfrm.elements.namedItem('itemYear').value.trim();
            const itemVehicleId = thisfrm.elements.namedItem('itemVehicleId').value.trim();
            const itemName = thisfrm.elements.namedItem('itemName').value.trim();
            const itemAddress = thisfrm.elements.namedItem('itemAddress').value.trim();
            const itemTelephone = thisfrm.elements.namedItem('itemTelephone').value.trim();
            const updatedAt = getDateTimeNow();

            const item = {
                "usercarId": itemId,
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
                // item.usercarId = itemId;
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
            let deleteId = item.usercarId;
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
                const index = usercars.findIndex(m => m.usercarId == editId);
                if (index !== -1) {
                    usercars[index] = item;
                }
            } else {
                usercars.push(item);
            }
            createFilterDataAndRender(currentPage);
        }

        function confirmDelete(deleteId) {
            usercars = usercars.filter(m => m.usercarId != deleteId);
            createFilterDataAndRender(currentPage);
        }

        function createFilterDataAndRender(page = 1) {
            currentPage = page;
            const searchText = document.getElementById('searchInput').value.trim().toLowerCase();
            filtered = usercars;

            if (searchText) {
                filtered = filtered.filter(m =>
                    m.usercarId.toLowerCase().includes(searchText) ||
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
                        <td>${m.usercarId}</td>
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
                                <button class="btn btn-sm btn-warning boxx text-white" onclick="openEditModal('${m.usercarId}')">แก้ไข</button>
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

        const ajaxFetchData = async (endpoint, lastSyncTime, statusType) => {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: `../serviceDB/${endpoint}s.php`,
                    type: "POST",
                    data: {
                        lastSyncTime: lastSyncTime,
                        statusType: statusType
                    },
                    success: function(data) {
                        if (data.status) {
                            resolve(data);
                        } else {
                            sweetAlertError("เกิดข้อผิดพลาด : " + data.message, 0);
                            resolve(null);
                        }
                    },
                    error: function(error) {
                        // let message = error?.responseJSON?.message ?? error.responseText;
                        // sweetAlertError('เกิดข้อผิดพลาด : ' + message, 0);
                        reject(error);
                    },
                });
            });
        };

        $(document).ready(async function() {
            try {
                loaderScreen("show");
                // await syncOnLoad();
                // usercars = await loadDataFromDB("usercars","usercarId");
                // createFilterDataAndRender();
                // groupNames = await loadAndSetData("groupnames");
                // colorNames = await loadAndSetData("colornames");
                
                usercars = await loadDataFromServer("usercar");
                createFilterDataAndRender();

                groupNames = await loadDataFromServer("groupname");
                setData(groupNames,"groupname");
                colorNames = await loadDataFromServer("colorname");
                setData(colorNames,"colorname");

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

            createValidate();

            // setInterval(syncDataRealtime, timeSync);
            setInterval(syncDataRealtimeServer, timeSync);
        });

        async function syncDataRealtimeServer() {
            let dataExpires = [];
            try {
                dataExpires = await updateSyncData(["usercar","groupname","colorname"]);
            } catch (error) {
                let message = error?.responseJSON?.message ?? error.responseText;
                if (!message) {
                    message = error;
                }
                sweetAlertError('เกิดข้อผิดพลาด : ' + message, 0);
            } finally {
                if (dataExpires.length) {
                    console.table(dataExpires);
                    dataExpires.forEach((item) => {
                        switch (item.tableName) {
                            case "usercar":
                                usercars = sortColumnData(item.data);
                                createFilterDataAndRender(currentPage);
                                break;
                            case "groupname":
                                groupNames = item.data;
                                setData(groupNames,"groupname");
                                break;
                            case "typename":
                                typeNames = item.data;
                                setData(typeNames,"typename");
                                break;
                            case "supplier":
                                suppliers = item.data;
                                setData(suppliers,"supplier");
                                break;
                            case "color":
                                colorNames = item.data;
                                setData(colorNames,"color");
                                break;
                        }
                    });
                }
            }
        }

        async function syncDataRealtime() {
            let tableNames = await updateSyncData();
            if (tableNames) {
                if (tableNames.find((item) => item == "usercars")) {
                    let dataSource = await loadDataFromDB("usercars");
                    usercars = sortColumnData(dataSource);
                    createFilterDataAndRender(currentPage);
                }
                if (tableNames.find((item) => item == "groupnames")) {
                    groupNames = await loadAndSetData("groupnames");
                }
                if (tableNames.find((item) => item == "colornames")) {
                    colorNames = await loadAndSetData("colornames");
                }
                createValidate();
            }
        }

        async function _syncDataRealtime() {
            try {
                // loaderScreen("show");
                let dataSource = await updateSyncData({
                    dataName: "usercars"
                });
                if (dataSource) {
                    usercars = dataSource;
                    createFilterDataAndRender(currentPage);
                }
            } catch (error) {
                sweetAlertError("เกิดข้อผิดพลาด : " + error.message, 0);
            } finally {
                // loaderScreen("hide");
            }
        }

        async function syncDataRealtimeDB(lastDataSyncTime) {
            let dataExpires = [];
            try {
                // loaderScreen("show");
                // let dataSource = await startCheckDataExpired(["usercar", "colorname", "groupname", "typename"],lastDataSyncTime);
                let dataSource = await startCheckDataExpired(["colorname"], lastDataSyncTime);
                if (dataSource) {
                    for (i = 0; i < dataSource.length; i++) {
                        tableExpire = dataSource[i];
                        let dataExpire = await ajaxFetchData(tableExpire.tableName, lastDataSyncTime, tableExpire.statusType)
                        if (dataExpire) {
                            dataExpires.push({
                                tableName: tableExpire.tableName,
                                statusType: tableExpire.statusType,
                                data: dataExpire
                            });
                        }
                    }

                    // dataSource.forEach(tableExpire => {
                    //     let dataExpire = await fetchData(endpoint,lastSyncTime,lastDataSyncTime)
                    // });
                    // usercars = dataSource;
                    // createFilterDataAndRender();
                }
            } catch (error) {
                let message = error?.responseJSON?.message ?? error.responseText;
                sweetAlertError('เกิดข้อผิดพลาด : ' + message, 0);
            } finally {
                // alert(dataExpires)
            }
        }

        async function setData(dataStore,storeName) {
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
                }
            } catch (error) {
                sweetAlertError("เกิดข้อผิดพลาด : " + error.message, 0);
            }
        }

        async function loadAndSetData(storeName) {
            try {
                let dataStore = await loadDataFromDB(storeName);
                if (storeName == "groupnames") {
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
                } else if (storeName == "colornames") {
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
                }
                return dataStore;

            } catch (error) {
                sweetAlertError("เกิดข้อผิดพลาด : " + error.message, 0);
            }
        }

        let localTableStatus = [];
        // let localTableStatus = getStorage("tableStatus");

        async function startCheckDataExpired(dataSource = [], lastDataSyncTime = null) {
            let result = await getTableStatus();
            if (result) {
                setStorage("tableStatus", result);
                return await checkExpired(dataSource, result);
            }
            return [];
        }

        async function checkExpired(dataSource, tableStatus) {
            let tableExpires = [];
            lastDataSyncTime = getDateTimeNow();
            console.table(tableStatus);
            dataSource.forEach((item) => {
                if (tableStatus) {
                    // console.log(localTableStatus);
                    // let insertTime = findInsertTime(tableStatus, item.tableName, lastDataSyncTime);
                    // let updateTime = findUpdateTime(tableStatus, item.tableName, lastDataSyncTime);
                    // let expiredStatus = findUpdateTime(tableStatus, item.tableName, lastDataSyncTime);
                    let expiredStatus = tableStatus.find(
                        (element) => element.tableName === item && (element.insertTime >= lastDataSyncTime || element.updateTime >= lastDataSyncTime)
                    );

                    let expiredStatusInsert = tableStatus.find(
                        (element) => element.tableName === item && element.insertTime >= lastDataSyncTime
                    );

                    let expiredStatusUpdate = tableStatus.find(
                        (element) => element.tableName === item && element.updateTime >= lastDataSyncTime
                    );

                    if (expiredStatusInsert || expiredStatusUpdate) {
                        if (expiredStatusInsert && !expiredStatusUpdate) {
                            tableExpires.push({
                                tableName: item,
                                statusType: "insertExpire"
                            });
                        } else {
                            tableExpires.push({
                                tableName: item,
                                statusType: "updateExpire"
                            });
                        }
                    }

                    // if (expiredStatus) {
                    //     tableExpires.push(expiredStatus);
                    // }
                    // alert(insertTime + " : " + element.insertTime)
                    // if (insertTime || updateTime) {
                    //     if (
                    //         insertTime != element.insertTime ||
                    //         updateTime != element.updateTime
                    //     ) {
                    //         return true;
                    //     }
                    // }
                    //     return false;
                    // } else {
                    //     return true;
                }

            });
            return tableExpires
        }

        function _checkExpired(element) {
            if (localTableStatus) {
                // console.log(localTableStatus);
                let insertTime = findInsertTime(localTableStatus, element.tableName);
                let updateTime = findUpdateTime(localTableStatus, element.tableName);
                // alert(insertTime + " : " + element.insertTime)
                if (
                    insertTime != element.insertTime ||
                    updateTime != element.updateTime
                ) {
                    return true;
                }
                return false;
            } else {
                return true;
            }
        }

        function findInsertTime(tableStatus, tableName, lastDataSyncTime) {
            let index = tableStatus.findIndex(
                (element) => element.tableName === tableName
            );
            if (index != -1) {
                return tableStatus[index].insertTime;
            }
            return null;
        }

        function findUpdateTime(tableStatus, tableName, lastDataSyncTime) {
            let index = tableStatus.findIndex(
                (element) => element.tableName === tableName
            );
            if (index != -1) {
                return tableStatus[index].updateTime;
            }
            return null;
        }

        async function getTableStatus() {
            // localTableStatus = getStorage("tableStatus");
            return new Promise((resolve, reject) => {
                $.ajax({
                        type: "GET",
                        url: "../serviceDB/readTableStatus.php",
                    })
                    .done(function(resp) {
                        let tableNameExpire = [];
                        let urls = [];
                        result = resp.message;
                        if (result) {
                            setStorage("tableStatus", result);
                            resolve(result);
                        } else {
                            resolve(null);
                        }
                    })
                    .fail(function(error) {
                        alert("Error get : " + JSON.stringify(error));
                        reject(null);
                    });
            });
        }

        async function _getTableStatus() {
            localTableStatus = getStorage("tableStatus");
            return new Promise((resolve, reject) => {
                $.ajax({
                        type: "GET",
                        url: "service/readTableStatus.php",
                    })
                    .done(function(resp) {
                        let tableNameExpire = [];
                        let urls = [];
                        result = JSON.parse(resp.message);
                        versionConfigServerData = resp.versionData;
                        versionStatusConfigServerData = resp.statusData;

                        if (result) {
                            setStorage("tableStatus", result);
                            let lastIndex = result.length - 1;
                            result.forEach((element, index) => {
                                tableName = element.tableName;
                                let expired = checkExpired(element);
                                if (expired) {
                                    if (tableName === "autowords") {
                                        tableNameExpire.push(tableName);
                                        urls.push("service/getAutoWord.php");
                                    } else if (
                                        !(
                                            tableName == "sales" ||
                                            tableName == "test_sales"
                                        )
                                    ) {
                                        tableNameExpire.push(tableName);
                                        urls.push(
                                            "service/readTable.php?status=1&tableName=" +
                                            tableName
                                        );
                                    }
                                }
                            });
                            if (tableNameExpire) {
                                const fetchNames = async () => {
                                    try {
                                        // var arrayFetch = urls.map(function (url) {
                                        //     return fetch(url);
                                        // });
                                        // const requests = await Promise.all(arrayFetch);

                                        // const results = await Promise.all(
                                        //     requests.map((r) => r.json())
                                        // );
                                        // tableNameExpire.forEach((tableName, index) => {
                                        //     setStorage(
                                        //         tableName,
                                        //         JSON.parse(results[index].message)
                                        //     );
                                        // });
                                        return true;
                                    } catch {
                                        return false;
                                    }
                                };
                                resolve(fetchNames());
                            } else {
                                resolve(true);
                            }
                        }
                    })
                    .fail(function(error) {
                        alert("Error get : " + JSON.stringify(error));
                        reject(false);
                    });
            });
        }
    </script>
</body>

</html>