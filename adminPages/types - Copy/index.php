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
                            <label class="m-0 text-dark">จัดการประเภทสินค้า</label>
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
                                    <label class="mr-auto" style="line-height: 2.1rem">รายการประเภทสินค้า</label>
                                    <button class="btn btn-primary boxx float-right" data-bs-toggle="modal" data-bs-target="#itemModal" onclick="openAddModal()"><i class="fa fa-plus"></i> เพิ่มรายการ</a></button>
                                    <!-- <a href="form-create.php" class="btn btn-primary boxx float-right"><i class="fa fa-plus"></i> เพิ่มสินค้า</a> -->
                                </div>
                                <div class="card-body" style="font-size: 1rem;">
                                    <!-- <div class="container" style="max-width:90%;"> -->
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-4 form-group">
                                            <label for="searchInput" class="form-label">ประเภทสินค้า</label>
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input type="text" class="form-control" id="searchInput" value="" placeholder="..." value="" autocomplete="off" />
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
                                                    <th style="min-width: 120px;" onclick="sortColumnBy('typename',this);">
                                                        <div class="d-flex justify-content-around">
                                                            <div>ประเภทสินค้า</div>
                                                            <div id="icon"></div>
                                                        </div>
                                                    </th>
                                                    <th style="min-width: 140px;">สถานะ</th>
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
        <div class="modal-dialog modal-dialog-centered" style="width:auto;max-width:500px;">
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
                                    <div class="col-12 form-group position-relative mb-3">
                                        <input
                                            type="hidden"
                                            class="form-control"
                                            id="itemId"
                                            placeholder="รหัส..." />

                                        <label for="itemName" class="form-label">ชื่อรายการ</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon"></i>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="itemName"
                                                placeholder="ชื่อรายการ..." />
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
    <script src="../indexedDB/indexedDB.js"></script>
    <script src="../js/sortColumnBy.js"></script>

    <script type="text/javascript">
        let typeNames = [];
        let filtered = [];

        let currentPage = 1;
        const perPage = 10;
        let editId = null;
        let deleteId = null;

        const STORE = "typenames";
        let sortColumn = [{
            colName: "typename",
            state: "ASC"
        }, ];

        async function loadAndSetData(storeName) {
            let dataStore = await loadDataFromDB(storeName);
            typeNames = dataStore;
        }

        $(document).ready(async function() {
            await openDB();
            await loadAndSetData(STORE);
            createFilterDataAndRender();
            loaderScreen("hide");
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
        });

        function openAddModal() {
            editId = null;
            document.getElementById('itemForm').reset();
            $('#itemModal #itemModalLabel').text('เพิ่มรายการ');
            $('#itemModal .modal-header').addClass("bg-primary");
            $('#itemModal .modal-header').removeClass("bg-warning");

            $('#itemModal').modal("show");
        }

        function openEditModal(id) {
            editId = null;
            const m = typeNames.find(x => x.typeId == id);

            if (m) {
                editId = id;
                const thisfrm = document.getElementById('itemForm');
                thisfrm.elements.namedItem("itemId").value = id;
                thisfrm.elements.namedItem("itemName").value = m.typename;

                $('#itemModal #itemModalLabel').text('แก้ไขรายการ');
                $('#itemModal .modal-header').addClass("bg-warning");
                $('#itemModal .modal-header').removeClass("bg-primary");

                $('#itemModal').modal("show");
            }
        }

        function getUpdatedAt() {
            Date.prototype.addHours = function(h) {
                this.setHours(this.getHours() + h);
                return this;
            }
            return new Date().addHours(7).toISOString().replace("T", " ").substr(0, 19);
        }

        function saveItem() {
            const thisfrm = document.getElementById('itemForm');
            const itemId = editId || thisfrm.elements.namedItem('itemId').value.trim();
            const itemName = thisfrm.elements.namedItem('itemName').value.trim();

            const updatedAt = getUpdatedAt();

            // if (!itemId || !groupname) {
            //     alert('กรุณากรอกข้อมูลให้ครบถ้วน');
            //     return;
            // }

            if (!itemName) {
                alert('กรุณากรอกข้อมูลให้ครบถ้วน');
                return;
            }

            const item = {
                "typeId": 0,
                "typename": itemName,
                updatedAt
            };

            if (editId) {
                item.typeId = parseInt(editId);
                $.ajax({
                    type: "POST",
                    url: "services/updateItem.php",
                    data: {
                        "itemId": editId,
                        "itemName": itemName,
                        "itemUpdatedAt": updatedAt,
                    }
                }).done(function(resp) {
                    loaderScreen("hide");
                    if (resp.status) {
                        const index = typeNames.findIndex(m => m.typeId == editId);
                        if (index !== -1) {
                            typeNames[index] = item;
                        }
                        updateDataToDB(STORE, item);
                        $('#itemModal').modal("hide");
                        renderTable();
                    } else {
                        sweetAlertError('เกิดข้อผิดพลาด : ' + resp.message, 3000);
                    }
                }).fail(function(err) {
                    sweetAlertError('เกิดข้อผิดพลาด : ' + err.responseText, 3000);
                    loaderScreen("hide");
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: "services/insertItem.php",
                    data: {
                        "itemName": itemName,
                        "itemUpdatedAt": updatedAt,
                    }
                }).done(function(resp) {
                    loaderScreen("hide");
                    if (resp.status) {
                        const insertedId = resp.insertedId;
                        item.typeId = parseInt(insertedId);
                        updateDataToDB(STORE, item);
                        typeNames.push(item);
                        renderTable();
                    } else {
                        sweetAlertError('เกิดข้อผิดพลาด : ' + resp.message, 3000);
                    }
                    $('#itemModal').modal("hide");
                }).fail(function(err) {
                    sweetAlertError('เกิดข้อผิดพลาด : ' + err.responseText, 3000);
                    loaderScreen("hide");
                });
            }
        }

        async function prepareDelete(item) {
            // alert(item)
            let deleteId = item.typeId;
            let deleteName = item.typename;
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
                    loaderScreen("hide");
                    if (resp.status) {
                        deleteDataFromDB(STORE, deleteId);
                        confirmDelete(deleteId)
                    } else {
                        sweetAlertError('เกิดข้อผิดพลาด : ' + resp.message);
                    }
                }).fail(function(err) {
                    sweetAlertError('เกิดข้อผิดพลาด : ' + err.responseText);
                    loaderScreen("hide");
                })
            }
        }

        function confirmDelete(deleteId) {
            typeNames = typeNames.filter(m => m.typeId != deleteId);
            renderTable();
        }
        
        function createFilterDataAndRender() {
            currentPage = 1;
            const searchText = document.getElementById('searchInput').value.trim().toLowerCase();
            filtered = typeNames;

            if (searchText) {
                filtered = filtered.filter(m =>
                    m.typename.toLowerCase().includes(searchText)
                );
            }

            renderTable();
        }

        function renderTable() {
            const tbody = document.getElementById('itemTable');
            tbody.innerHTML = '';
            const searchText = document.getElementById('searchInput').value.trim().toLowerCase();
            const totalPages = Math.ceil(filtered.length / perPage);
            const start = (currentPage - 1) * perPage;
            const pageItems = filtered.slice(start, start + perPage);

            for (let i = 0; i < pageItems.length; i++) {
                const m = pageItems[i];
                tbody.insertAdjacentHTML('beforeend', `
                    <tr>
                        <td>${start + i + 1}</td>
                        <td>${m.typename}</td>
                        <td></td>
                        <td>
                            <div class="d-flex justify-content-around">
                                <button class="btn btn-sm btn-warning boxx text-white" onclick="openEditModal(${m.typeId})">แก้ไข</button>
                                <button class="btn btn-sm btn-danger boxx" onclick='prepareDelete(${JSON.stringify(m)})'>ลบ</button>
                            </div>
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
            createFilterDataAndRender();
            // currentPage = 1;
            // renderTable();
        }
    </script>
</body>

</html>