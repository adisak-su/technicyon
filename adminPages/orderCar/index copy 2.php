<?php
require_once('../authen.php');
require_once("../../service/configData.php");

$startDate = date("Y-m-d");
$endDate = date("Y-m-d")

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>จัดการรายการขาย | <?php echo $shopName; ?></title>

    <!-- Favicons -->
    <?php include_once('../../includes/pagesFavicons.php'); ?>

    <!-- stylesheet -->
    <?php include_once('../../includes/pagesStylesheet.php'); ?>

    <!-- Datatables -->
    <?php include_once('../../includes/pagesDatatableStylesheet.php'); ?>

    <style>
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
                            <label class="m-0 text-dark">จัดการรายการขาย</label>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">รายการขาย</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="card collapsed-card">
                        <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
                            <div class="card-title" style="font-size: 1.5rem;padding:10px;">
                                ยอดขายช่วงวันที่
                            </div>
                            <div class="card-tools" style="padding:10px;">
                                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: none;padding-top:0px;padding-bottom:0px;">
                            <div class="row" style="font-size: 1.5rem;">
                                <div class="col-12 col-sm-6">
                                    <label>วันที่เริ่มต้น</label>
                                    <input type="date" id="startDate" class="form-control btn-25px" style="font-size: 1.5rem;text-align:center;" value='<?php echo $startDate; ?>'>
                                    <!-- <input type="date" id="startDate" class="form-control btn-25px" style="font-size: 1.5rem;text-align:center;" value='<?php echo $startDate; ?>' onchange="resetDate();"> -->
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>วันที่สิ้นสุด</label>
                                    <input type="date" id="endDate" class="form-control btn-25px" style="font-size: 1.5rem;text-align:center;" value='<?php echo $endDate; ?>'>
                                    <!-- <input type="date" id="endDate" class="form-control btn-25px" style="font-size: 1.5rem;text-align:center;" value='<?php echo $endDate; ?>' onchange="resetDate();"> -->
                                </div>
                                <div class="col-12" style="padding:10px;">
                                    <button id="btnSearch" type="button" class="btn btn-primary btn-25px" style="font-size: 1.5rem;display: block;margin-left: auto;margin-right: auto;" onclick="autoRefresh();"><i class="fa fa-search" aria-hidden="true"></i>ค้นหา</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent" style="display: none;padding-top:0px;">
                            <div class="row d-flex justify-content-around" style="padding: 0px; margin-left: 0px; margin-right: 0px; font-size: 1.5rem;">
                                <div class="col-12 d-flex justify-content-around">
                                    <div>ยอดขายรวมทั้งสิ้น</div>
                                    <div id="total">0 บาท</div>
                                </div>
                            </div>
                            <div class="row" id="divDateBetween" style="display: none;">
                                <div class="col-12">
                                    <div class="card collapsed-card">
                                        <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
                                            <div class="card-title" style="font-size: 1.5rem;padding:0px;">
                                                รายการ
                                            </div>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body" style="padding:0px;">
                                            <!-- <table id="dataTable" class="table table-hover table-bordered table-striped" width="100%">
                                            </table> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <label class="mr-auto" style="line-height: 2.1rem">รายการขาย</label>
                                    <!-- <a href="form-create.php" class="btn btn-primary btn-2px float-right">เพิ่ม</a> -->
                                </div>
                                <div class="card-body">
                                    <table id="dataTable" class="table table-hover table-bordered table-striped" width="100%">
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
            startDate = $("#startDate").val();
            endDate = $("#endDate").val();
            $.ajax({
                type: "GET",
                url: "service/readByDate.php",
                data: {
                    startDate: startDate,
                    endDate: endDate
                }
            }).done(function(resp) {
                result = JSON.parse(resp.message);
                genTable(result);
            });
        }

        function autoRefresh() {
            $("#dataTable").dataTable().fnDestroy();
            getDatabase();
        }

        function genTable(ajaxResponse) {
            let arrayData = [];
            let total = 0;
            ajaxResponse.forEach(function(item, index) {
                ID = item.orderNo;
                total +=  Number(item.total);
                arrayData.push([
                    ++index,
                    item.orderNo,
                    item.customerName,
                    item.total,
                    item.orderDateTime,
                    `<input class="toggle-event" id="status" data-id="${ID}" type="checkbox" name="status" 
                        ${item.status==1 ? 'checked': ''} data-toggle="toggle" data-on="เปิด" 
                    data-off="ปิด" data-onstyle="success" data-style="ios">`,
                    `<div class="" style="width: 100%;align: center;">
                        <button type="button" class="btn btn-warning" id="edit" data-id="${ID}" style="float: left;">
                            <i class="far fa-edit"></i> แก้ไข
                        </button>
                        <button type="button" class="btn btn-danger" id="delete" data-id="${ID}" data-dismiss="modal" style="float: right;">
                            <i class="far fa-trash-alt"></i> ลบ
                        </button>
                    </div>`
                ])
            })
            // $("#total").html
            document.getElementById("total").innerText = addCommas(total) +" บาท";

            $(document).ready(function() {
                $('#dataTable').DataTable({
                    data: arrayData,
                    columns: [{
                            title: "ลำดับ",
                            className: "align-middle text-right"
                        },
                        {
                            title: "เลขบิล",
                            className: "align-middle"
                        },
                        {
                            title: "ชื่อลูกค้า",
                            className: "align-middle"
                        },
                        {
                            title: "ยอดเงิน",
                            className: "align-middle text-right"
                        },
                        {
                            title: "วัน-เวลา",
                            className: "align-middle"
                        },
                        {
                            title: "สถานะ",
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
                                    return 'Details for ' + data[1]
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