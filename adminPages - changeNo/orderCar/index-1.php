<?php
require_once('../authen.php');
require_once("../../service/configData.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>จัดการผู้ดูแลระบบ | <?php echo $shopName; ?></title>

    <!-- Favicons -->
    <?php include_once('../../includes/pagesFavicons.php'); ?>

    <!-- stylesheet -->
    <?php include_once('../../includes/pagesStylesheet.php'); ?>

    <!-- Datatables -->
    <?php include_once('../../includes/pagesDatatableStylesheet.php'); ?>

    <style>
        .dark-theme {
            background-color: #212121;
        }

        .custom-control-input {
            transform: scale(2.0);
        }

        /* .custom-switch {
            transform: scale(1.4);
        } */
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
                            <label class="m-0 text-dark">จัดการข้อมูลเบื้องต้น</label>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">ข้อมูลเบื้องต้น</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <!-- <div class="row">
                        <div class="col-12">
                            <input class="toggle-event" type="checkbox" checked data-toggle="toggle" data-on="เปิด" data-off="ปิด" data-onstyle="success" data-style="ios">
                        </div>
                    </div> -->

                    <!-- <input type="checkbox" class="custom-control-input" id="customSwitch1"> -->

                    <!-- <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label" for="customSwitch1"></label>
                    </div> -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <label class="mr-auto" style="line-height: 2.1rem">รายการขนาด</label>
                                    <button class="btn btn-primary btn-2px" data-toggle="modal" data-target="#insertModal" data-table="Size" data-name="ขนาด">เพิ่มรายการ</button>
                                    <div class="card-tools" style="padding:0 10px">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div id="showDataTableSize" class="table-responsive"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card collapsed-card">
                                <div class="card-header d-flex justify-content-between">
                                    <label class="mr-auto" style="line-height: 2.1rem">รายการความหนา</label>
                                    <button class="btn btn-primary btn-2px" data-toggle="modal" data-target="#insertModal" data-table="Gram" data-name="ความหนา">เพิ่มรายการ</button>
                                    <div class="card-tools" style="padding:0 10px">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                            <i class="fas fa-times"></i>
                                        </button> -->
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div id="showDataTableGram" class="table-responsive"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card collapsed-card">
                                <div class="card-header d-flex justify-content-between">
                                    <label class="mr-auto" style="line-height: 2.1rem">รายการสี</label>
                                    <button class="btn btn-primary btn-2px" data-toggle="modal" data-target="#insertModal" data-table="Color" data-name="สี">เพิ่มรายการ</button>
                                    <div class="card-tools" style="padding:0 10px">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                            <i class="fas fa-times"></i>
                                        </button> -->
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div id="showDataTableColor" class="table-responsive"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="insertModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <label class="modal-title" id="insertModalLabel">เพิ่มรายการ</label>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control" id="txtTable">
                            </div>
                            <div class="form-group">
                                <label for="txtName" class="col-form-label">รายการ</label>
                                <input type="text" class="form-control" id="txtName">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button id="btnSave" type="button" class="btn btn-primary" onclick="insertOption();">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <label class="modal-title" id="updateModalLabel">New message</label>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control" id="txtTable">
                                <input type="text" class="form-control" id="txtID">
                            </div>
                            <div class="form-group">
                                <label for="txtName" class="col-form-label">รายการ</label>
                                <input type="text" class="form-control" id="txtName">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button id="btnSave" type="button" class="btn btn-primary" onclick="updateOption();">บันทึก</button>
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

    <!-- OPTIONAL DataTable SCRIPTS -->
    <?php include_once('../../includes/pagesDatatableScript.php') ?>

    <script type="text/javascript">
        function setModal() {
            $('#insertModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var txtTable = button.data('table');
                var txtName = button.data('name');

                var modal = $(this)
                modal.find('.modal-title').text('เพิ่มรายการ ' + txtName)
                modal.find('.modal-body #txtTable').val(txtTable);
                modal.find('.modal-body #txtName').val("");
                //modal.find('#btnSave').attr("onClick", "insertOption(modal)");
                /*
                modal.find('#btnSave').click(function() {
                    insertOption(modal);
                });
                */
            });
            $('#updateModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var txtTable = button.data('table');
                var txtID = button.data('id');
                var txtName = button.data('name');

                var modal = $(this)
                modal.find('.modal-title').text('แก้ไขรายการ ' + txtName)
                modal.find('.modal-body #txtTable').val(txtTable);
                modal.find('.modal-body #txtID').val(txtID);
                modal.find('.modal-body #txtName').val(txtName);
                /*
                modal.find('#btnSave').click(function() {
                    updateModal(modal);
                })
                */
            });
        }

        function updateModal(modal) {
            txtTable = modal.find('.modal-body #txtTable').val();
            txtName = modal.find('.modal-body #txtName').val();
            txtID = modal.find('.modal-body #txtID').val();
            updateOption(txtTable, txtID, txtName, modal);
        }

        $(document).ready(function() {
            // getDatabase();
            readDatabase("Size");
            readDatabase("Gram");
            readDatabase("Color");
            setModal();
        });

        function postUrl(url, id) {
            var form = $(document.createElement('form'));
            $(form).attr("action", url);
            $(form).attr("method", "POST");
            $(form).css("display", "none");
            var input_id = $("<input>")
                .attr("type", "text")
                .attr("name", "id")
                .val(id);
            $(form).append($(input_id));
            form.appendTo(document.body);
            $(form).submit();
        }

        function showDataTable(_table, _dataTable) {
            tableName = "dataTable" + _table;
            myHTML = `<table id="${tableName}" class="table table-hover table-bordered table-striped" width="100%">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">รายการ</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col">จัดการรายการ</th>
                </tr>
            </thead><tbody>`;

            count = 1;

            _dataTable.forEach(element => {
                switch (_table.toLowerCase()) {
                    case "size":
                        ID = element.sizeID;
                        break;
                    case "gram":
                        ID = element.gramID;
                        break;
                    case "color":
                        ID = element.colorID;
                        break;
                }
                status = element.status;

                ele = JSON.stringify(element);
                _onclick = `selectRow('${_table}','${element.name}');`;
                myHTML += `<tr><th scope="row">${count++}</th><td onclick="${_onclick}" class="text-primary">${element.name}</td>`;
                if (status == 1) {
                    btn = "btn-success";
                } else {
                    btn = "btn-secondary";
                }

                // myHTML += `<td><input class="toggle" id="status" data-id="${ID}" type="checkbox" name="status" 
                //         ${status==1 ? 'checked': ''} data-toggle="toggle" data-on="เปิด" 
                //     data-off="ปิด" data-onstyle="success" data-style="ios"></td>`;

                // myHTML += `<td><div><input id="status_${_table}_${ID}" name="status_${_table}_${ID}" class="toggle-event" type="checkbox" checked data-toggle="toggle" data-on="เปิด" data-off="ปิด" data-onstyle="success" data-style="ios"></div></td>`;
                

                // myHTML += `<td><div class="custom-control custom-switch" width="100px">
                //         <input type="checkbox" class="custom-control-input" id="status_${_table}_${ID}" width="50%">
                //         <label class="custom-control-label" for="status_${_table}_${ID}">on/off</label>
                //     </div></td>`;
                // myHTML += `<td><div class="custom-control custom-switch">
                //     <input type="checkbox" class="custom-control-input" id="customSwitch1">
                //     <label class="custom-control-label" for="customSwitch1"></label>
                // </div></td>`;

                myHTML += `<td><div class="btn ${btn}" onclick="setStatusOption('${_table}','${ID}',${status});">${status==1 ? 'เปิด': 'ปิด'}</div></td>`;
                myHTML += `<td>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateModal" data-table="${_table}" data-id="${ID}" data-name="${element.name}">แก้ไข</button>
                <button class="btn btn-danger" onclick="deleteOption('${_table}','${ID}');">ลบ</button>
                </td></tr>`;
            });
            myHTML += `</body></table>`;
            $("#showDataTable" + _table).html(myHTML);
            tableName = "#" + tableName
            $(tableName).dataTable();
            loaderScreen("hide");
        }
        
        function insertOption() {
            loaderScreen("show");
            modal = $('#insertModal');
            _table = modal.find('#txtTable').val();
            name = modal.find('#txtName').val();
            $.ajax({
                type: "POST",
                url: "service/createOption.php",
                data: {
                    table: _table.toLowerCase(),
                    name: name
                }
            }).done(function(resp) {
                result = JSON.parse(resp.message);
                showDataTable(_table, result);
                modal.modal('hide');
            });
        }

        function deleteOption(_table, id) {
            Swal.fire({
                text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่! ลบเลย',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    loaderScreen("show");
                    $.ajax({
                        type: "POST",
                        url: "service/deleteOption.php",
                        data: {
                            table: _table.toLowerCase(),
                            id: id
                        }
                    }).done(function(resp) {
                        result = JSON.parse(resp.message);
                        showDataTable(_table, result);
                    });
                }
            });

        }

        function updateOption() {
            loaderScreen("show");
            modal = $('#updateModal');
            _table = modal.find('#txtTable').val();
            name = modal.find('#txtName').val();
            id = modal.find('#txtID').val();
            status = status == 1 ? 0 : 1;
            $.ajax({
                type: "POST",
                url: "service/updateOption.php",
                data: {
                    table: _table.toLowerCase(),
                    id: id,
                    name: name
                }
            }).done(function(resp) {
                result = JSON.parse(resp.message);
                showDataTable(_table, result);
                modal.modal('hide');
            }).fail(function(err) {

            });
        }

        function setStatusOption(_table, id, status) {
            loaderScreen("show");
            status = status == 1 ? 0 : 1;
            $.ajax({
                type: "POST",
                url: "service/setStatusOption.php",
                data: {
                    table: _table.toLowerCase(),
                    id: id,
                    status: status
                }
            }).done(function(resp) {
                result = JSON.parse(resp.message);
                showDataTable(_table, result);
            }).fail(function(err) {
                alert(err);
            });
        }

        function selectRow(_table, element = null) {
            txtName = `#txt${_table}`;
            $(txtName).val(element);
        }

        function deleteSize(id) {
            $.ajax({
                type: "POST",
                url: "service/deleteSize.php",
                data: {
                    id: id
                }
            }).done(function(resp) {
                result = JSON.parse(resp.message);
                showDataTable(result);
            });
        }

        function getDatabase() {
            //alert(1);
            $.ajax({
                type: "GET",
                url: "service/readSize.php",
                //data: { id: id }
            }).done(function(resp) {
                // alert(resp.message);
                result = JSON.parse(resp.message);
                //return result;
                showFileUploaded(result);
            });
        }

        function readDatabase(_table) {
            //alert(1);
            $.ajax({
                type: "POST",
                url: "service/readOption.php",
                data: {
                    table: _table.toLowerCase()
                }
            }).done(function(resp) {
                result = JSON.parse(resp.message);
                showDataTable(_table, result);
            });
        }


        function autoRefresh() {
            $("#dataTable").dataTable().fnDestroy();
            getDatabase();
        }

        function genTable(ajaxResponse) {
            let arrayData = []
            ajaxResponse.forEach(function(item, index) {
                arrayData.push([
                    ++index,
                    `<img src="images/${item.image}" class="img-fluid">`,
                    // `<input class="toggle-event" id="status_${item.adminID}" data-id="${item.adminID}" type="checkbox" name="status" 
                    //     ${item.status==1 ? 'checked': ''} data-toggle="toggle" data-on="เปิด" 
                    // data-off="ปิด" data-onstyle="success" data-style="ios">`,
                    `<input class="toggle-event" id="status" data-id="${item.adminID}" type="checkbox" name="status" 
                        ${item.status==1 ? 'checked': ''} data-toggle="toggle" data-on="เปิด" 
                    data-off="ปิด" data-onstyle="success" data-style="ios">`,
                    item.username,
                    item.firstName,
                    item.lastName,
                    item.email,
                    item.permission,
                    item.updated_at,
                    `<div class="" style="width: 100%;align: center;">
                        <button type="button" class="btn btn-warning" id="edit" data-id="${item.adminID}" style="float: left;">
                            <i class="far fa-edit"></i> แก้ไข
                        </button>
                        <button type="button" class="btn btn-danger" id="delete" data-id="${item.adminID}" data-dismiss="modal" style="float: right;">
                            <i class="far fa-trash-alt"></i> ลบ
                        </button>
                    </div>`
                ])
            })

            $(document).ready(function() {
                $('#dataTable').DataTable({
                    data: arrayData,
                    columns: [{
                            title: "ลำดับ",
                            className: "align-middle"
                        },
                        {
                            title: "รูป",
                            className: "align-middle"
                        },
                        {
                            title: "สถานะ",
                            className: "align-middle"
                        },
                        {
                            title: "ชื่อผู้ใช้",
                            className: "align-middle"
                        },
                        {
                            title: "ชื่อจริง",
                            className: "align-middle"
                        },
                        {
                            title: "นามสกุล",
                            className: "align-middle"
                        },
                        {
                            title: "อีเมล",
                            className: "align-middle"
                        },
                        {
                            title: "สิทธิ์เข้าใช้งาน",
                            className: "align-middle"
                        },
                        {
                            title: "ใช้งานล่าสุด",
                            className: "align-middle"
                        },
                        {
                            title: "จัดการ",
                            className: "align-middle"
                        }
                    ],
                    "initComplete": function() {
                        //$('.toggle-event').bootstrapToggle();
                        $(document).on('click', '#edit', function() {
                            let id = $(this).data('id')
                            // alert(id);
                            postUrl('form-edit.php', id);
                        });
                        $(document).on('click', '#delete', function() {
                            let id = $(this).data('id')
                            Swal.fire({
                                text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'ใช่! ลบเลย',
                                cancelButtonText: 'ยกเลิก'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    loaderScreen("show");
                                    $.ajax({
                                        type: "POST",
                                        url: "service/delete.php",
                                        data: {
                                            id: id
                                        }
                                    }).done(function(resp) {
                                        loaderScreen("hide");
                                        if (resp.status) {
                                            Swal.fire({
                                                text: 'รายการของคุณถูกลบเรียบร้อย',
                                                icon: 'success',
                                                timer: 1500,
                                                confirmButtonText: 'ตกลง',
                                            }).then((result) => {
                                                autoRefresh();
                                                // $('.dtr-bs-modal').remove();
                                                // $(".modal-backdrop").remove();
                                                //location.reload();
                                            });
                                        } else {
                                            Swal.fire({
                                                text: 'เกิดข้อผิดพลาด : ' + resp.message,
                                                icon: 'error',
                                                confirmButtonText: 'ตกลง',
                                            });
                                        }
                                    })
                                }
                            })
                        })
                    },
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data()
                                    return 'Details for ' + data[3]
                                }
                            }),
                            renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                                tableClass: 'table'
                            })
                        }
                    },
                    "language": {
                        "lengthMenu": "แสดงข้อมูล _MENU_ แถว",
                        "zeroRecords": "ไม่พบข้อมูลที่ต้องการ",
                        "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
                        "infoEmpty": "ไม่พบข้อมูลที่ต้องการ",
                        "infoFiltered": "(filtered from _MAX_ total records)",
                        "search": 'ค้นหา'
                    }
                })
                $('.toggle-event').change(function() {
                    loaderScreen("show");
                    $.ajax({
                        type: "POST",
                        url: "service/updateStatus.php",
                        data: {
                            id: this.dataset.id,
                            status: this.checked ? 1 : 0
                        }
                    }).done(function(resp) {
                        loaderScreen("hide");
                        if (resp.status) {
                            toastr.success('อัพเดทข้อมูลเสร็จเรียบร้อย.', {
                                timeOut: 2000,
                                closeOnHover: true
                            });
                        } else {
                            toastr.error('มีข้อผิดพลาดเกินขึ้น โปรดติดต่อผู้ดูแลระบบ', {
                                timeOut: 5000,
                                closeOnHover: true
                            });
                        }
                    })
                })
                loaderScreen("hide");
            })
        }
    </script>
    <script>
    </script>
</body>

</html>