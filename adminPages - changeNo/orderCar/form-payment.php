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
        .sweetRow {
            display: flex;
            flex-wrap: wrap;
        }
        .sweetRow item {
            width: 100%;
            text-align: center;
        }
        input[type=checkbox] {
            /* Double-sized Checkboxes */
            -ms-transform: scale(2);
            /* IE */
            -moz-transform: scale(2);
            /* FF */
            -webkit-transform: scale(2);
            /* Safari and Chrome */
            -o-transform: scale(2);
            /* Opera */
            transform: scale(2);
            padding: 10px;
        }
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
                    <div class="card">
                        <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
                            <div class="card-title" style="font-size: 1.5rem;padding:10px;">
                                ยอดขายช่วงวันที่
                            </div>
                            <div class="card-tools" style="padding:10px;">
                            <a href="index.php" class="btn btn-warning btn-sm">หน้าหลัก</a>
                            </div>
                        </div>
                        <div class="card-body" style="padding-top:0px;padding-bottom:0px;">
                            <div class="row" style="font-size: 1.5rem;">
                                <div class="col-12 col-sm-6">
                                    <input type="checkbox" id="checkStartDate" checked onchange="autoRefresh();">
                                    <label style="padding-left:20px;">วันที่เริ่มต้น</label>
                                    <!-- <div class="row">
                                        <div class="col-3" style="display: flex;flex-wrap: wrap;align-content: center;"><input type="checkbox" id="checkStartDate" class="form-control btn-25px" style="font-size: 1.5rem;" checked onchange="autoRefresh();"></div>
                                        <div class="col-9"><input type="date" id="startDate" class="form-control btn-25px" style="font-size: 1.5rem;text-align:center;" value='<?php echo $startDate; ?>' onchange="autoRefresh();"></div>
                                    </div> -->
                                    <input type="date" id="startDate" class="form-control btn-25px" style="font-size: 1.5rem;text-align:center;" value='<?php echo $startDate; ?>' onchange="autoRefresh();">
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>วันที่สิ้นสุด</label>
                                    <input type="date" id="endDate" class="form-control btn-25px" style="font-size: 1.5rem;text-align:center;" value='<?php echo $endDate; ?>' onchange="autoRefresh();">
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

        function printPDF(id) {
            // loaderScreen("show");
            $.ajax({
                type: "POST",
                url: "form-print.php",
                data: {
                    id: id
                }
            }).done(function(resp) {
                // loaderScreen("hide");
                if (resp.status) {
                    window.location = "viewPDF.php?fileName="+resp.message;
                } else {
                    sweetAlert(resp.message, 5000);
                }
            }).fail(function(err) {
                // loaderScreen("hide");
                sweetAlertError('เกิดข้อผิดพลาด : ' + err.responseText, 5000);
            });
        }

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

        async function payment(id, message) {
            divMessage = `<div class="sweetRow">
                        <item>คุณแน่ใจหรือไม่...ที่จะชำระเงินรายการนี้?</item>
                        <item>${message}</item>
                    </div>`;
            confirm = await sweetConfirm(divMessage,"ใช่! รายการนี้");
            if (confirm) {
                // alert(id);
                paymentOrderNo(id);
            }
        }

        function paymentOrderNo(orderNo) {
            $.ajax({
                type: "POST",
                url: "service/paymentOrderNo.php",
                data: {
                    orderNo: orderNo
                }
            }).done(function(resp) {
                if(resp.status) {
                    autoRefresh()
                }
                else {
                    alert(resp.message);
                }
            }).fail(function(err) {
                sweetAlertError('เกิดข้อผิดพลาด : ' + err.responseText, 5000);
            });
        }

        function getDatabase() {
            loaderScreen("show");
            checkStartDate = $("#checkStartDate")[0].checked;
            $("#startDate").attr("disabled", !checkStartDate);
            startDate = $("#startDate").val();
            endDate = $("#endDate").val();
            $.ajax({
                type: "GET",
                url: "service/readPaymentByDate.php",
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    checkStartDate: checkStartDate
                }
            }).done(function(resp) {
                result = JSON.parse(resp.message);
                genTable(result);
                loaderScreen("hide");
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
            let arrayData = [];
            let total = 0;
            ajaxResponse.forEach(function(item, index) {
                ID = item.orderNo;
                total +=  Number(item.total);
                msgTotal = addCommas(item.total)
                message = `เลขบิล : ${item.orderNo} ยอดเงิน ${msgTotal} บาท`;
                arrayData.push([
                    ++index,
                    item.orderNo,
                    item.customerName,
                    msgTotal,
                    // item.orderDateTime,
                    getLocalDateTime(item.orderDateTime),
                    `<div class="" style="width: 100%;align: center;">
                        <button type="button" class="btn btn-success" id="print" data-id="${ID}" style="float: left;">
                            <i class="fa fa-print"></i>
                        </button>
                    </div>`,
                    `<div class="" style="width: 100%;align: center;">
                        <button type="button" class="btn btn-warning" id="payment" data-dismiss="modal" data-id="${ID}" data-message="${message}" style="float: left;">
                            <i class="far fa-edit"></i> ชำระเงิน
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
                            title: "พิมพ์",
                            className: "align-middle"
                        },
                        {
                            title: "จัดการ",
                            className: "align-middle"
                        }
                    ],
                    "initComplete": function() {
                        $('.toggle-event').bootstrapToggle();
                        $(document).on('click', '#print', function() {
                            let id = $(this).data('id');
                            printPDF(id);
                            // postUrl('form-print.php', id);
                        });
                        $(document).on('click', '#payment', function() {
                            let id = $(this).data('id');
                            let message = $(this).data('message');
                            payment(id,message);
                            // postUrl('form-edit.php', id);
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