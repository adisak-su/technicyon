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

    <link href="https://printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet">

    <!-- <link rel="stylesheet" type="text/css" media="all" href="../../assets/daterangepicker/daterangepicker.css"> -->
    <!-- <link rel="stylesheet" type="text/css" media="all" href="../../plugins/bootstrap-datepicker/bootstrap-datepicker.css"> -->
    <!-- <link rel="stylesheet" type="text/css" media="all" href="../../plugins/daterangepicker/daterangepicker.css"> -->

    <style>
        input[type=checkbox1] {
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
                                <a href="form-create.php" class="button btn btn-primary btn-sm"><i class="fas fa-plus"> เพิ่มรายการขาย</i></a>
                                <!-- <button type="button" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"> เพิ่มรายการขาย</i>
                                </button> -->
                            </div>
                        </div>
                        <div class="card-body" style="padding-top:0px;padding-bottom:0px;">
                            <div class="row">
                                <div class="col-12 col-sm-6" style="padding-bottom:10px;">
                                    <!--
                                    <input type="checkbox" id="checkStartDateold" checked onchange="autoRefresh();"> -->
                                    <label class="toggle-switch"><input type="checkbox" id="checkStartDate" checked onclick="autoRefresh();"><span class="slider round"></span></label>
                                    <label style="padding-left:20px;">วันที่เริ่มต้น</label>
                                    <!-- <div class="row">
                                        <div class="col-2" style="display: flex;flex-wrap: wrap;align-content: center;"><input type="checkbox" id="checkStartDate" class="form-control btn-25px" style="font-size: 1.5rem;" checked onchange="autoRefresh();"></div>
                                        <div class="col-10"><input type="date" id="startDate" class="form-control btn-25px" style="font-size: 1.5rem;text-align:center;" value='<?php echo $startDate; ?>' onchange="autoRefresh();"></div>
                                    </div> -->
                                    <input type="date" id="startDate" class="form-control btn-25px" style="font-size: 1.5rem;text-align:center;" value='<?php echo $startDate; ?>' onchange="autoRefresh();">
                                </div>
                                <div class="col-12 col-sm-6" style="padding-bottom:10px;">
                                
                                    <label class="toggle-switch"><input type="checkbox" id="checkEndDate" checked onclick="autoRefresh();"><span class="slider round"></span></label>
                                    <label style="padding-left:20px;">วันที่สิ้นสุด</label>
                                    <input type="date" id="endDate" class="form-control btn-25px" style="font-size: 1.5rem;text-align:center;" value='<?php echo $endDate; ?>' onchange="autoRefresh();">
                                    <!-- <input type="date" id="endDate" class="form-control btn-25px" style="font-size: 1.5rem;text-align:center;" value='<?php echo $endDate; ?>' onchange="resetDate();"> -->
                                </div>
                                <div class="col-12" style="padding:10px;">
                                    <div id="showBtnStatus"></div>
                                </div>
                                <!--
                                <div class="col-12" style="padding:10px;">
                                    <button id="btnSearch" type="button" class="btn btn-primary btn-25px" style="font-size: 1.5rem;display: block;margin-left: auto;margin-right: auto;" onclick="autoRefresh();"><i class="fa fa-search" aria-hidden="true"></i>ค้นหา</button>
                                </div>
                                -->
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

                    <!-- <div class="row">
                        <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="row">
                        <div class="form-group">
                            <label>Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <ul class="myTimeline">
                                <li class="active"></li>
                                <li class="primary" data-text="2014"></li>
                            </ul>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <label class="mr-auto" style="line-height: 2.1rem">รายการขาย</label>
                                    <button id="btntnPrintInvoice" class="btn btn-success" onclick="print();" disabled><i class="fa fa-print"></i> พิมพ์</button>
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
        <div class="modal fade" id="viewModal" style="overflow-x: hidden;overflow-y: auto;" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <label class="modal-title" id="viewModalLabel"></label>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <!-- <div class="form-group">
                                <input type="hidden" class="form-control" id="txtNo">
                            </div> -->
                            <div class="form-group">
                                <!-- <label class="col-form-label">รายการ</label> -->
                                <div id="showLogTable"></div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <input type="hidden" class="form-control" id="txtNo">
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

    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

    <!-- <script src="../../assets/daterangepicker/bootstrap-datetimepicker.min.js"></script>
    <script src="../../assets/daterangepicker/daterangepicker.js"></script> -->

    <!-- <script src="../../plugins/daterangepicker/daterangepicker.js"></script> -->
    <!-- <script src="../../plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script> -->
    <!-- <script src="../../assets/daterangepicker/daterangepicker.js"></script> -->


    <script type="text/javascript">
        // $('#reservationtime').daterangepicker({
        //     timePicker: true,
        //     timePickerIncrement: 30,
        //     locale: {
        //         format: 'MM/DD/YYYY hh:mm A'
        //     }
        // })
        // $('#reservationdate').datetimepicker({
        //     format: 'L'
        // });

        function genElementFrom(element) {
            var input = $("<input>")
                .attr("type", "text")
                .attr("name", element.name)
                .val(element.value);
            return input;
        }

        function print() {
            loaderScreen("show");
            checkStartDate = $("#checkStartDate")[0].checked;
            $("#startDate").attr("disabled", !checkStartDate);
            checkEndDate = $("#checkEndDate")[0].checked;
            $("#endDate").attr("disabled", !checkEndDate);
            startDate = $("#startDate").val();
            endDate = $("#endDate").val();
            status = $("input:radio[name ='optionStatus']:checked").val();
            $.ajax({
                type: "GET",
                url: "form-printOrder.php",
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    status: status,
                    checkStartDate: checkStartDate,
                    checkEndDate: checkEndDate,
                }
            }).done(function(resp) {
                // result = JSON.parse(resp.message);
                if (resp.status) {
                    window.location = "viewPDF.php?fileName=" + resp.message;
                } else {
                    sweetAlert(resp.message, 5000);
                }
                loaderScreen("hide");
            }).fail(function(err) {
                loaderScreen("hide");
                sweetAlertError('เกิดข้อผิดพลาด : ' + err.responseText, 5000);
            });
            // $.ajax({
            //     type: "POST",
            //     url: "form-print.php",
            //     data: {
            //         id: id
            //     }
            // }).done(function(resp) {
            //     loaderScreen("hide");
            //     if (resp.status) {
            //         // sweetAlert(resp.message, 5000);
            //         window.location = "viewPDF.php?fileName="+resp.message;
            //         // printJS(resp.message);
            //     } else {
            //         sweetAlert(resp.message, 5000);
            //     }
            //     // return result;
            // }).fail(function(err) {
            //     loaderScreen("hide");
            //     sweetAlertError('เกิดข้อผิดพลาด : ' + err.responseText, 5000);
            // });
        }

        function print_old() {
            var form = $(document.createElement('form'));
            $(form).attr("target", "_blank");
            $(form).attr("action", "form-printOrder.php");
            $(form).attr("method", "POST");
            $(form).css("display", "none");

            checkStartDate = $("#checkStartDate")[0].checked;
            $("#startDate").attr("disabled", !checkStartDate);
            startDate = $("#startDate").val();
            endDate = $("#endDate").val();
            status = $("input:radio[name ='optionStatus']:checked").val();
            arrElement = [{
                    name: "startDate",
                    value: startDate
                },
                {
                    name: "endDate",
                    value: endDate
                },
                {
                    name: "status",
                    value: status
                },
                {
                    name: "checkStartDate",
                    value: checkStartDate
                },
            ];

            arrElement.forEach(element => {
                var input_id = genElementFrom(element);
                $(form).append($(input_id));
            });

            form.appendTo(document.body);
            $(form).submit();
        }

        function setModal() {
            $('#viewModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var txtTable = button.data('table');
                // var txtName = button.data('name');
                var txtName = button.data('id');

                var modal = $(this)
                modal.find('.modal-title').text('ประวัติการแก้ไขรายการ ' + txtName)
                modal.find('.modal-body #txtNo').val(txtName);
                getLog(txtName);
                modal.find('.modal-body #txtName').val("");
            });
        }

        function getLog(id) {
            loaderScreen("show");
            $.ajax({
                type: "GET",
                url: "service/readLogByNo.php",
                data: {
                    orderNo: id
                }
            }).done(function(resp) {
                result = JSON.parse(resp.message);
                divHTML = genLogTable(result);
                var modal = $("#viewModal");
                modal.find('.modal-body #showLogTable').html(divHTML);
                loaderScreen("hide");
                // return result;
            }).fail(function(err) {
                loaderScreen("hide");
                sweetAlertError('เกิดข้อผิดพลาด : ' + err.responseText, 5000);
            });
        }

        function genLogTable(result) {
            divHTML = '<label class="col-form-label">ข้อมูลการแก้ไข</label>';
            divHTML += `<table class="table table-sm">
                        <thead>
                            <tr>
                            <th scope="col">เหตุผลการปรับแก้ไข</th>
                            <th scope="col">วัน-เวลา</th>
                            <th scope="col">ผู้แก้ไข</th>
                            </tr>
                        </thead>
                        <tbody>`;

            result.forEach(element => {
                dateChange = element.dateTimeChange
                divHTML += `<tr>
                            <td>${element.description}</td>
                            <td>${getLocalDateTime(element.dateTimeChange)}</td>
                            <td>${element.firstName}</td>
                            </tr>`;

            });
            divHTML += `</tbody></table>`;
            return divHTML;
        }

        $(document).ready(function() {
            // $("#optionStatus_1").click();
            // $("#label_optionStatus_1").addClass("btn-success");
            // $("#label_optionStatus_1").addClass("text-white");
            setModal();
            genOptionStatus();
            getDatabase();
            // autoRefresh()
        });

        function genOptionStatus() {
            arrayStatus = [{
                    name: "ทั้งหมด",
                    value: "All",
                    checked: "checked"
                },
                {
                    name: "ยังไม่ได้ทำบิล",
                    value: "1",
                    checked: ""
                },
                {
                    name: "ทำบิลแล้ว",
                    value: "2",
                    checked: ""
                },
                {
                    name: "ชำระเงินแล้ว",
                    value: "4",
                    checked: ""
                },
                {
                    name: "ยกเลิกแล้ว",
                    value: "0",
                    checked: ""
                },
            ];
            let divHTML = '<div class="nav nav-pills d-inline-flex text-center mb-0" style="padding-top:10px;">';
            arrayStatus.forEach((element, index) => {
                divHTML += `<div class="nav-item d-flex m-2">
                    <!--
                                <div class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                <span class="text-dark" style="width: 130px;">All Products</span>
                                            </div>
                                            <div class="d-flex m-2">
                            <input type="radio" class="d-flex btn-success btn-check" id="optionStatus_${index}" name="optionStatus" ${element.checked} value="${element.value}" onchange="changeOption(this);" style="display: none;">
                            <label id="label_optionStatus_${index}" class="rounded-pill myoutline btn btn-outline-success" for="optionStatus_${index}" style="font-size: 1rem;width: 130px;">${element.name}</label>
                            </div>
                            <div class="d-flex m-2"> -->
                            <input type="radio" class="btn-success btn-check" id="optionStatus_${index}" name="optionStatus" ${element.checked} value="${element.value}" onchange="changeOption(this);" style="display: none;">
                            <label id="label_optionStatus_${index}" class="rounded-pill myoutline btn btn-outline-success" for="optionStatus_${index}" style="font-size: 1rem;width: 150px;">${element.name}</label>
                            
                        </div>`;
            });

            $("#showBtnStatus").html(divHTML);
            $("#label_optionStatus_0").addClass("btn-success");
            $("#label_optionStatus_0").addClass("text-white");
        }
        function genOptionStatus_old() {
            arrayStatus = [{
                    name: "ทั้งหมด",
                    value: "All",
                    checked: "checked"
                },
                {
                    name: "ยังไม่ได้ทำบิล",
                    value: "1",
                    checked: ""
                },
                {
                    name: "ทำบิลแล้ว",
                    value: "2",
                    checked: ""
                },
                {
                    name: "ชำระเงินแล้ว",
                    value: "4",
                    checked: ""
                },
                {
                    name: "ยกเลิกแล้ว",
                    value: "0",
                    checked: ""
                },
            ];
            let divHTML = '<div class="row" style="padding-top:10px;display: grid;grid-template-columns: auto auto auto auto auto;">';
            arrayStatus.forEach((element, index) => {
                divHTML += `<div>
                            <input type="radio" class="btn-success btn-check" id="optionStatus_${index}" name="optionStatus" ${element.checked} value="${element.value}" onchange="changeOption(this);" style="display: none;">
                            <label id="label_optionStatus_${index}" class="myoutline btn btn-outline-success" for="optionStatus_${index}" style="font-size: 1rem;">${element.name}</label>
                        </div>`;
            });

            $("#showBtnStatus").html(divHTML);
            $("#label_optionStatus_0").addClass("btn-success");
            $("#label_optionStatus_0").addClass("text-white");
        }

        function postUrl(url, id) {
            var form = $(document.createElement('form'));
            // url.includes("print") ? $(form).attr("target", "_blank") : '';
            if (url.includes("print")) {
                $(form).attr("target", "_blank");
            }
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

        function printPDF(id) {
            // loaderScreen("show");
            $.ajax({
                type: "POST",
                url: "form-print.php",
                data: {
                    id: id
                }
            }).done(function(resp) {
                if (resp.status) {
                    window.location = "viewPDF.php?fileName=" + resp.message;
                } else {
                    sweetAlert(resp.message, 5000);
                }
            }).fail(function(err) {
                sweetAlertError('เกิดข้อผิดพลาด : ' + err.responseText, 5000);
            });
        }

        function printPDF2(id) {
            loaderScreen("show");
            $.ajax({
                type: "POST",
                url: "form-print.php",
                data: {
                    id: id
                }
            }).done(function(resp) {
                loaderScreen("hide");
                if (resp.status) {
                    // sweetAlert(resp.message, 5000);
                    printJS(resp.message);
                } else {
                    sweetAlert(resp.message, 5000);
                }
                // return result;
            }).fail(function(err) {
                loaderScreen("hide");
                sweetAlertError('เกิดข้อผิดพลาด : ' + err.responseText, 5000);
            });
        }

        function changeOption(element) {
            $(".myoutline").removeClass("btn-success");
            $(".myoutline").removeClass("text-white");
            $("#label_" + element.id).addClass("btn-success");
            $("#label_" + element.id).addClass("text-white");
            autoRefresh();
        }

        function getDatabase() {
            loaderScreen("show");
            checkStartDate = $("#checkStartDate")[0].checked;
            checkEndDate = $("#checkEndDate")[0].checked;
            $("#startDate").attr("disabled", !checkStartDate);
            $("#endDate").attr("disabled", !checkEndDate);
            
            startDate = $("#startDate").val();
            endDate = $("#endDate").val();
            status = $("input:radio[name ='optionStatus']:checked").val();
            $.ajax({
                type: "GET",
                url: "service/readByDate.php",
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    status: status,
                    checkStartDate: checkStartDate,
                    checkEndDate: checkEndDate,
                }
            }).done(function(resp) {
                result = JSON.parse(resp.message);
                if (result.length) {
                    $("#btntnPrintInvoice").attr("disabled", false);
                } else {
                    $("#btntnPrintInvoice").attr("disabled", true);
                }
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
                total += Number(item.total);
                divManage = "";
                divLog = "";
                divTimeline = `<div style="width: 100%;align: center;">
                                <ul class="myTimeline" style="width: 100%;">
                                <li class="active"></li>
                                <li class="primary" data-text="2014"></li>
                                </ul>
                                </div>`;

                // data-toggle="modal" data-target="#viewModal" data-id="${ID}"

                if (item.statusChange == "1") {
                    divLog = `<div class="" style="width: 100%;align: center;">
                        <button type="button" class="btn btn-warinig" id="log" data-dismiss="modal" data-toggle="modal" data-target="#viewModal" data-id="${ID}" style="float: left;">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>`;
                }
                if (item.status == "0") {
                    divManage = `<div class="" style="width: 100%;align: center;">
                        <label>ยกเลิกแล้ว</label>
                    </div>`;
                } else if (item.status == "1") {
                    divManage = `<div class="" style="width: 100%;align: center;">
                        <button type="button" class="btn btn-warning" id="edit" data-id="${ID}" data-dismiss="modal" style="float: left;">
                            <i class="far fa-edit"></i> แก้ไข
                        </button>
                        <button type="button" class="btn btn-danger" id="delete" data-id="${ID}" data-dismiss="modal" style="float: right;">
                            <i class="far fa-trash-alt"></i> ยกเลิก
                        </button>
                    </div>`;
                } else if (item.status == "2") {
                    divManage = `<div class="" style="width: 100%;align: center;">
                        <label>ออกใบวางบิลแล้ว</label>
                    </div>`;
                } else if (item.status == "3") {
                    divManage = `<div class="" style="width: 100%;align: center;">
                        <button type="button" class="btn btn-danger" id="deletePayment" data-id="${ID}" data-dismiss="modal" style="float: right;">
                            <i class="far fa-trash-alt"></i> ...
                        </button>
                    </div>`;
                } else if (item.status == "4") {
                    divManage = `<div class="" style="width: 100%;align: center;">
                        <button type="button" class="btn btn-danger" id="deletePayment" data-id="${ID}" data-dismiss="modal" style="float: right;">
                            <i class="far fa-trash-alt"></i> ยกเลิกการชำระเงิน
                        </button>
                    </div>`;
                }
                divPrint = `<div class="" style="width: 100%;display: inline-flex;justify-content: center;">
                        <button type="button" class="btn btn-success" id="print" data-id="${ID}" data-dismiss="modal" style="float: left;">
                            <i class="fa fa-print"></i>
                        </button>
                    </div>`;
                divID = item.orderNo;
                if (item.statusChange == "1" || item.status == "0") {
                    divID = `<div class="" style="width: 100%;display: inline-flex;justify-content: space-between;">
                        ${item.orderNo}
                        <button type="button" class="btn btn-warinig" id="log" data-dismiss="modal" data-toggle="modal" data-target="#viewModal" data-id="${ID}" style="float: right;padding:0px;">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>`;
                }
                // let isMobile = window.screen.width <= 1024 ? true : false; // for mobile
                arrayData.push([
                    ++index,
                    // item.orderNo,
                    divID,
                    item.customerName,
                    addCommas(item.total),
                    // divTimeline,
                    // item.orderDateTime,
                    getLocalDateTime(item.orderDateTime),
                    //     `<input class="toggle-event" id="status" data-id="${ID}" type="checkbox" name="status" 
                    //     ${item.status==1 ? 'checked': ''} data-toggle="toggle" data-on="เปิด" 
                    // data-off="ปิด" data-onstyle="success" data-style="ios">`,
                    divPrint,
                    divManage
                ]);

                // if (isMobile) {
                //     arrayData.push([
                //         ++index,
                //         item.orderNo,
                //         item.customerName,
                //         addCommas(item.total),
                //         // divTimeline,
                //         // item.orderDateTime,
                //         getLocalDate(item.orderDateTime, "iPhone"),
                //         //     `<input class="toggle-event" id="status" data-id="${ID}" type="checkbox" name="status" 
                //         //     ${item.status==1 ? 'checked': ''} data-toggle="toggle" data-on="เปิด" 
                //         // data-off="ปิด" data-onstyle="success" data-style="ios">`,
                //         `<div class="" style="width: 100%;align: center;">
                //         <button type="button" class="btn btn-success" id="print" data-id="${ID}" data-dismiss="modal" style="float: left;">
                //             <i class="fa fa-print"></i>
                //         </button>
                //     </div>` + divLog,
                //         divManage
                //     ]);
                // } else {
                //     arrayData.push([
                //         ++index,
                //         item.orderNo,
                //         item.customerName,
                //         addCommas(item.total),
                //         // divTimeline,
                //         getLocalDateTime(item.orderDateTime),

                //         // new Date(item.orderDateTime).toLocaleDateString('th-TH'),
                //         //     `<input class="toggle-event" id="status" data-id="${ID}" type="checkbox" name="status" 
                //         //     ${item.status==1 ? 'checked': ''} data-toggle="toggle" data-on="เปิด" 
                //         // data-off="ปิด" data-onstyle="success" data-style="ios">`,
                //         `<div class="" style="width: 100%;align: center;">
                //         <button type="button" class="btn btn-success" id="print" data-id="${ID}" data-dismiss="modal" style="float: left;">
                //             <i class="fa fa-print"></i>
                //         </button>
                //     </div>` + divLog,
                //         divManage
                //     ]);

                // }

                // arrayData.push([
                //     ++index,
                //     item.orderNo,
                //     item.customerName,
                //     addCommas(item.total),
                //     item.orderDateTime,
                //     `<input class="toggle-event" id="status" data-id="${ID}" type="checkbox" name="status" 
                //         ${item.status==1 ? 'checked': ''} data-toggle="toggle" data-on="เปิด" 
                //     data-off="ปิด" data-onstyle="success" data-style="ios">`,
                //     `<div class="" style="width: 100%;align: center;">
                //         <button type="button" class="btn btn-success" id="print" data-id="${ID}" data-dismiss="modal" style="float: left;">
                //             <i class="fa fa-print"></i>
                //         </button>
                //     </div>` + divLog,
                //     divManage
                // ]);
            })
            // $("#total").html
            document.getElementById("total").innerText = addCommas(total) + " บาท";

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
                            let id = $(this).data('id')
                            printPDF(id);
                            // postUrl('form-print.php', id);
                        });
                        $(document).on('click', '#edit', function() {
                            let id = $(this).data('id')
                            postUrl('form-edit.php', id);
                        });
                        $(document).on('click', '#delete', function() {
                            let id = $(this).data('id')
                            deleteOrder(id);
                        });
                        $(document).on('click', '#deletePayment', function() {
                            let id = $(this).data('id')
                            deletePayment(id);
                        });
                    },
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data()
                                    return 'รายละเอียด ' + data[1]
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

        async function deleteOrder(orderNo) {
            message = "คุณแน่ใจหรือไม่...ที่จะยกเลิกรายการนี้?";
            confirm = await sweetConfirmDeleteWithInput(message, "ใช่! ยกเลิกเลย");
            if (confirm.result) {
                loaderScreen("show");
                $.ajax({
                    type: "POST",
                    url: "service/deleteOrder.php",
                    data: {
                        orderNo: orderNo,
                        message: confirm.message
                    }
                }).done(function(resp) {
                    loaderScreen("hide");
                    if (resp.status) {
                        sweetAlertSuccess('รายการของคุณถูกยกเลิกเรียบร้อย');
                        autoRefresh();
                    } else {
                        sweetAlertError('เกิดข้อผิดพลาด : ' + resp.message);
                        loaderScreen("hide");
                    }
                }).fail(function(err) {
                    sweetAlertError('เกิดข้อผิดพลาด : ' + err.responseText); //  JSON.stringify(err)
                    loaderScreen("hide");
                })
            }
        }

        async function deletePayment(orderNo) {
            message = "คุณแน่ใจหรือไม่...ที่จะยกเลิกการชำระเงินรายการนี้?";
            confirm = await sweetConfirmDeleteWithInput(message, "ใช่! ยกเลิกเลย");
            if (confirm.result) {
                loaderScreen("show");
                $.ajax({
                    type: "POST",
                    url: "service/deletePayment.php",
                    data: {
                        orderNo: orderNo,
                        message: confirm.message
                    }
                }).done(function(resp) {
                    loaderScreen("hide");
                    if (resp.status) {
                        sweetAlertSuccess('รายการของคุณถูกยกเลิกเรียบร้อย');
                        autoRefresh();
                    } else {
                        sweetAlertError('เกิดข้อผิดพลาด : ' + resp.message);
                        loaderScreen("hide");
                    }
                }).fail(function(err) {
                    sweetAlertError('เกิดข้อผิดพลาด : ' + err.responseText); //  JSON.stringify(err)
                    loaderScreen("hide");
                })
            }
        }
    </script>
    <script>
        // function getLocalDate(val) {
        //     const d = new Date(val);
        //     let str = d.toLocaleDateString('th-TH');
        //     return str;
        // }

        // function getLocalDateTime(val) {
        //     const d = new Date(val);
        //     let str = d.toLocaleDateString('th-TH');
        //     return str + " " + new Intl.DateTimeFormat('th-TH', {timeStyle: 'short'}).format(d)
        // }
    </script>
    <!--
    <div class="daterangepicker ltr show-calendar opensright">
        <div class="ranges"></div>
        <div class="drp-calendar left">
            <div class="calendar-table"></div>
            <div class="calendar-time" style="display: none;"></div>
        </div>
        <div class="drp-calendar right">
            <div class="calendar-table"></div>
            <div class="calendar-time" style="display: none;"></div>
        </div>
        <div class="drp-buttons"><span class="drp-selected"></span><button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button><button class="applyBtn btn btn-sm btn-primary" disabled="disabled" type="button">Apply</button> </div>
    </div>


    <div class="daterangepicker ltr show-calendar opensright">
        <div class="ranges"></div>
        <div class="drp-calendar left">
            <div class="calendar-table"></div>
            <div class="calendar-time" style="display: none;"></div>
        </div>
        <div class="drp-calendar right">
            <div class="calendar-table"></div>
            <div class="calendar-time" style="display: none;"></div>
        </div>
        <div class="drp-buttons"><span class="drp-selected"></span><button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button><button class="applyBtn btn btn-sm btn-primary" disabled="disabled" type="button">Apply</button> </div>
    </div>

    <div class="daterangepicker ltr show-ranges opensright" style="display: none; top: 1788.21px; left: 1206.39px; right: auto;">
        <div class="ranges">
            <ul>
                <li data-range-key="Today">Today</li>
                <li data-range-key="Yesterday">Yesterday</li>
                <li data-range-key="Last 7 Days">Last 7 Days</li>
                <li data-range-key="Last 30 Days" class="active">Last 30 Days</li>
                <li data-range-key="This Month">This Month</li>
                <li data-range-key="Last Month">Last Month</li>
                <li data-range-key="Custom Range">Custom Range</li>
            </ul>
        </div>
        <div class="drp-calendar left">
            <div class="calendar-table">
                <table class="table-condensed">
                    <thead>
                        <tr>
                            <th class="prev available"><span></span></th>
                            <th colspan="5" class="month">Nov 2023</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>Su</th>
                            <th>Mo</th>
                            <th>Tu</th>
                            <th>We</th>
                            <th>Th</th>
                            <th>Fr</th>
                            <th>Sa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="weekend off ends available" data-title="r0c0">29</td>
                            <td class="off ends available" data-title="r0c1">30</td>
                            <td class="off ends available" data-title="r0c2">31</td>
                            <td class="available" data-title="r0c3">1</td>
                            <td class="available" data-title="r0c4">2</td>
                            <td class="available" data-title="r0c5">3</td>
                            <td class="weekend available" data-title="r0c6">4</td>
                        </tr>
                        <tr>
                            <td class="weekend available" data-title="r1c0">5</td>
                            <td class="available" data-title="r1c1">6</td>
                            <td class="available" data-title="r1c2">7</td>
                            <td class="available" data-title="r1c3">8</td>
                            <td class="available" data-title="r1c4">9</td>
                            <td class="available" data-title="r1c5">10</td>
                            <td class="weekend available" data-title="r1c6">11</td>
                        </tr>
                        <tr>
                            <td class="weekend available" data-title="r2c0">12</td>
                            <td class="available" data-title="r2c1">13</td>
                            <td class="available" data-title="r2c2">14</td>
                            <td class="available" data-title="r2c3">15</td>
                            <td class="available" data-title="r2c4">16</td>
                            <td class="available" data-title="r2c5">17</td>
                            <td class="weekend available" data-title="r2c6">18</td>
                        </tr>
                        <tr>
                            <td class="weekend available" data-title="r3c0">19</td>
                            <td class="available" data-title="r3c1">20</td>
                            <td class="available" data-title="r3c2">21</td>
                            <td class="available" data-title="r3c3">22</td>
                            <td class="available" data-title="r3c4">23</td>
                            <td class="available" data-title="r3c5">24</td>
                            <td class="weekend available" data-title="r3c6">25</td>
                        </tr>
                        <tr>
                            <td class="weekend available" data-title="r4c0">26</td>
                            <td class="available" data-title="r4c1">27</td>
                            <td class="active start-date available" data-title="r4c2">28</td>
                            <td class="in-range available" data-title="r4c3">29</td>
                            <td class="in-range available" data-title="r4c4">30</td>
                            <td class="off ends in-range available" data-title="r4c5">1</td>
                            <td class="weekend off ends in-range available" data-title="r4c6">2</td>
                        </tr>
                        <tr>
                            <td class="weekend off ends in-range available" data-title="r5c0">3</td>
                            <td class="off ends in-range available" data-title="r5c1">4</td>
                            <td class="off ends in-range available" data-title="r5c2">5</td>
                            <td class="off ends in-range available" data-title="r5c3">6</td>
                            <td class="off ends in-range available" data-title="r5c4">7</td>
                            <td class="off ends in-range available" data-title="r5c5">8</td>
                            <td class="weekend off ends in-range available" data-title="r5c6">9</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="calendar-time" style="display: none;"></div>
        </div>
        <div class="drp-calendar right">
            <div class="calendar-table">
                <table class="table-condensed">
                    <thead>
                        <tr>
                            <th></th>
                            <th colspan="5" class="month">Dec 2023</th>
                            <th class="next available"><span></span></th>
                        </tr>
                        <tr>
                            <th>Su</th>
                            <th>Mo</th>
                            <th>Tu</th>
                            <th>We</th>
                            <th>Th</th>
                            <th>Fr</th>
                            <th>Sa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="weekend off ends available" data-title="r0c0">26</td>
                            <td class="off ends available" data-title="r0c1">27</td>
                            <td class="off ends active start-date available" data-title="r0c2">28</td>
                            <td class="off ends in-range available" data-title="r0c3">29</td>
                            <td class="off ends in-range available" data-title="r0c4">30</td>
                            <td class="in-range available" data-title="r0c5">1</td>
                            <td class="weekend in-range available" data-title="r0c6">2</td>
                        </tr>
                        <tr>
                            <td class="weekend in-range available" data-title="r1c0">3</td>
                            <td class="in-range available" data-title="r1c1">4</td>
                            <td class="in-range available" data-title="r1c2">5</td>
                            <td class="in-range available" data-title="r1c3">6</td>
                            <td class="in-range available" data-title="r1c4">7</td>
                            <td class="in-range available" data-title="r1c5">8</td>
                            <td class="weekend in-range available" data-title="r1c6">9</td>
                        </tr>
                        <tr>
                            <td class="weekend in-range available" data-title="r2c0">10</td>
                            <td class="in-range available" data-title="r2c1">11</td>
                            <td class="in-range available" data-title="r2c2">12</td>
                            <td class="in-range available" data-title="r2c3">13</td>
                            <td class="in-range available" data-title="r2c4">14</td>
                            <td class="in-range available" data-title="r2c5">15</td>
                            <td class="weekend in-range available" data-title="r2c6">16</td>
                        </tr>
                        <tr>
                            <td class="weekend in-range available" data-title="r3c0">17</td>
                            <td class="in-range available" data-title="r3c1">18</td>
                            <td class="in-range available" data-title="r3c2">19</td>
                            <td class="in-range available" data-title="r3c3">20</td>
                            <td class="in-range available" data-title="r3c4">21</td>
                            <td class="in-range available" data-title="r3c5">22</td>
                            <td class="weekend in-range available" data-title="r3c6">23</td>
                        </tr>
                        <tr>
                            <td class="weekend in-range available" data-title="r4c0">24</td>
                            <td class="in-range available" data-title="r4c1">25</td>
                            <td class="in-range available" data-title="r4c2">26</td>
                            <td class="today active end-date in-range available" data-title="r4c3">27</td>
                            <td class="available" data-title="r4c4">28</td>
                            <td class="available" data-title="r4c5">29</td>
                            <td class="weekend available" data-title="r4c6">30</td>
                        </tr>
                        <tr>
                            <td class="weekend available" data-title="r5c0">31</td>
                            <td class="off ends available" data-title="r5c1">1</td>
                            <td class="off ends available" data-title="r5c2">2</td>
                            <td class="off ends available" data-title="r5c3">3</td>
                            <td class="off ends available" data-title="r5c4">4</td>
                            <td class="off ends available" data-title="r5c5">5</td>
                            <td class="weekend off ends available" data-title="r5c6">6</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="calendar-time" style="display: none;"></div>
        </div>
        <div class="drp-buttons"><span class="drp-selected">11/28/2023 - 12/27/2023</span><button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button><button class="applyBtn btn btn-sm btn-primary" type="button">Apply</button> </div>
    </div>
        -->
</body>

</html>