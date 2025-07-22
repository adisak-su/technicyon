<?php
require_once('../authen.php');
require_once("../../service/configData.php");
require_once("../../assets/php/common.php");
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
    </style>

</head>

<body class="sidebar-collapse">
    <div class="wrapper">
        <!-- Menu -->
        <?php include_once('../includes/sidebar.php') ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <label class="m-0 text-dark">จัดการผู้ดูแลระบบ</label>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">ผู้ดูแลระบบ</li>
                            </ol>
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
                                    <label class="mr-auto" style="line-height: 2.1rem">รายชื่อ</label>
                                    <a href="form-create.php" class="btn btn-primary btn-2px float-right"><i class="fa fa-plus"></i> เพิ่มผู้ดูแล</a>
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

    <!-- OPTIONAL DataTable SCRIPTS -->
    <?php include_once('../../includes/pagesDatatableScript.php') ?>

    <script type="text/javascript">
        $(document).ready(function() {
            // loadDark();
            getDatabase();
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

        function getDatabase() {
            loaderScreen("show");
            $.ajax({
                type: "GET",
                url: "service/read.php",
                //data: { id: id }
            }).done(function(resp) {
                // alert(resp.message);
                result = JSON.parse(resp.message);
                //return result;
                genTable(result);
            }).done(function(resp) {
                loaderScreen("hide");
                if(resp.status) {
                    result = JSON.parse(resp.message);
                }
                else {
                    sweetAlert(resp.message, 5000);
                }                
            }).fail(function(err) {
                loaderScreen("hide");
                sweetAlertError('เกิดข้อผิดพลาด : ' + err.responseText, 5000);
            });
        }

        function autoRefresh() {
            $("#dataTable").dataTable().fnDestroy();
            getDatabase();
        }

        function genTable(ajaxResponse) {
            let arrayData = []
            ajaxResponse.forEach(function(item, index) {
                id = item.adminID;
                divManage = `<div class="groupBtnIcon" style="width: 100%;align: center;">
                                <div class="item">
                                    <div class="btn btn-warning btnIcon" id="edit" data-id="${id}" data-dismiss="modal">
                                        <div><i class="far fa-edit"></i></div>
                                        <div class="btnText">แก้ไข</div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="btn btn-danger btnIcon" id="delete" data-id="${id}" data-dismiss="modal">
                                        <div><i class="far fa-trash-alt"></i></div>
                                        <div class="btnText">ลบ</div>
                                    </div>
                                </div>
                            </div>`;
                arrayData.push([
                    ++index,
                    `<img src="images/${item.image}" class="img-fluid" style="max-width:100px;">`,
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
                    getLocalDateTime(item.updated_at),
                    divManage,
                    // `<div class="" style="width: 100%;align: center;">
                    //     <button type="button" class="btn btn-warning" id="edit" data-id="${item.adminID}" style="float: left;">
                    //         <i class="far fa-edit"></i> แก้ไข
                    //     </button>
                    //     <button type="button" class="btn btn-danger" id="delete" data-id="${item.adminID}" data-dismiss="modal" style="float: right;">
                    //         <i class="far fa-trash-alt"></i> ลบ
                    //     </button>
                    // </div>`
                ])
            })

            $(document).ready(function() {
                $('#dataTable').DataTable({
                    scrollX: true,
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
                        $('.toggle-event').bootstrapToggle();
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
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#8a8a8a',
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
                    // responsive: {
                    //     details: {
                    //         display: $.fn.dataTable.Responsive.display.modal({
                    //             header: function(row) {
                    //                 var data = row.data()
                    //                 return 'Details for ' + data[3]
                    //             }
                    //         }),
                    //         renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                    //             tableClass: 'table'
                    //         })
                    //     }
                    // },
                    "language": {
                        "paginate": {
                            "next": '>>',
                            "previous": '<<'
                        },
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
            });
            setTimeout(function() {$('#dataTable').DataTable().draw();}, 100);
        }
    </script>
    <script>
    </script>
</body>

</html>