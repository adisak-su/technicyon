<?php
require_once('../authen.php');
require_once("../../assets/php/common.php");
require_once("../../service/configData.php");

$endDateTh = dateThai(date("Y-m-d"));
function dateThai($str)
{
    $year = intval(substr($str, 0, 4)) + 543;
    $month = substr($str, 5, 2);
    $day = substr($str, 8, 2);
    $dateSaleTH = "" . $day . "/" . $month . "/" . $year;
    return $dateSaleTH;
}

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

    <!-- <link rel="stylesheet" type="text/css" href="../../plugins/daterangepicker/jquery.datetimepicker.css" />

    <link rel="stylesheet" type="text/css" href="../../plugins/bootstrap-datepicker/css/datepicker.css" /> -->

    <link rel="stylesheet" href="../menus/menuheader.css?<?php echo time(); ?>">

    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>

    </style>
    <style>
        .container-input-label {
            width: 100%;
            display: flex;
            flex-direction: column;
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
                            <label class="m-0 text-dark">เพิ่มรายการขายสินค้าหน้าร้าน</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="card pt-0 pb-0">
                        <div class="card-body" style="font-size: 1rem;">
                            <div class="row d-flex justify-content-around">
                                <button id="resetProductSale" class="btn btn-secondary boxx w-25" style="max-width:200px;" onclick="resetValueSale();"><i class="fa fa-trash"></i> ล้างหน้าจอ</button>
                                <button id="saveProductSale" class="btn btn-primary boxx w-25" style="max-width:200px;" onclick="saveProductSale(1);"><i class="fa fa-save"></i> บันทึกการขาย</button>
                                <!-- <button id="saveProductSale" class="btn btn-primary boxx w-25" style="max-width:200px;" onclick="_saveProductSale(1);"><i class="fa fa-save"></i> บันทึกการขายTest</button> -->
                                <button id="printProductSale" class="btn btn-primary boxx w-25" style="max-width:200px;" onclick="window.location.href='print-repair.php';"><i class="fa fa-print"></i> Print</button>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-12 col-md-2 form-group position-relative">
                                    <input type="hidden" id="customerCode">
                                    <label for="customerInput" class="form-label">รหัสลูกค้า</label>
                                    <div class="d-flex flex-row justify-content-between">
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input type="text" class="form-control" id="customerInput" value="" placeholder="รหัส/ชื่อลูกค้า..." value="" onkeydown="checkEnter(event,this.value);" autocomplete="off" />
                                            <div id="customerSuggestions" class="suggestions"></div>
                                        </div>
                                    </div>
                                    <!-- <div class="invalid-feedback">กรุณาเลือกรถ</div> -->
                                </div>
                                <div class="col-12 col-md-4 form-group position-relative">
                                    <label for="customerName">ชื่อ</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                        <input type="text" id="customerName" class="form-control" value="" placeholder="" autocomplete="off">
                                    </div>
                                    <input type="hidden" id="customerAddress" class="form-control" value="" placeholder="" autocomplete="off">
                                    <input type="hidden" id="customerTelephone" class="form-control" value="" placeholder="" autocomplete="off">
                                </div>
                                <div class="col-md-3 form-group position-relative">
                                </div>
                                <div class="col-12 col-md-2 form-group position-relative">
                                    <label for="orderDate">วันที่</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                        <input type="date" id="orderDate" class="form-control" value="" placeholder="" autocomplete="off">
                                    </div>
                                </div>
                                <!-- <div class="col-12 col-md-2 form-group position-relative">
                                    <label>วันที่</label>
                                    <div class="input-group">
                                        <input id="endDateTh" class="form-control btn-25px text-center" style="font-size: 1.5rem;height: auto;" value='<?php echo $endDateTh; ?>'>
                                        <span class="input-group-text btn-right-25px" onclick="$('#endDateTh').click();"><i class="far fa-2x fa-calendar-alt"></i></span>
                                    </div>
                                </div>

                                <div class="col-12 col-md-2 form-group position-relative">
                                    <label>วันที่</label>
                                    <input type="text" class="form-control" id="datetimepicker">
                                </div> -->
                            </div>
                            <div class="row align-items-end">
                                <div class="col-4 col-md-2 form-group position-relative">
                                    <!-- ค้นหาสินค้า -->
                                    <input type="hidden" id="productCode">
                                    <label for="productInput">รหัสสินค้า</label>
                                    <div class="d-flex flex-row justify-content-between">
                                        <div class="input-icon-wrapper">
                                            <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                            <input type="text" class="form-control" id="productInput" value="" placeholder="รหัส/ชื่อสินค้า..." value="" onkeydown="checkEnter(event,this.value);" autocomplete="off" />
                                            <div id="productSuggestions" class="suggestions"></div>
                                        </div>
                                        <button id="btnViewProduct" class="btn btn-primary boxx" style="width: 40px;" data-toggle="modal" data-target="#viewProductModal"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-8 col-md-4 form-group position-relative">
                                    <label for="productName">สินค้า</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                        <input type="text" id="productName" class="form-control" value="" placeholder="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-12 col-md-1 form-group position-relative">
                                    <label for="productQty" class="w-100 text-center">จำนวน</label>
                                    <div class="input-wrapper">
                                        <!-- <i class="fa fa-keyboard input-icon" aria-hidden="true"></i> -->
                                        <input type="number" id="productQty" class="form-control text-center" value="1" placeholder="0" autocomplete="off" onkeypress="return isNumber(event);" onkeyup="computePrice();" onchange="computePrice();">
                                    </div>
                                </div>
                                <div class="col-12 col-md-1 form-group position-relative">
                                    <label for="productPrice" class="w-100 text-center">ราคา/หน่วย</label>
                                    <div class="input-wrapper">
                                        <!-- <i class="fa fa-keyboard input-icon" aria-hidden="true"></i> -->
                                        <input type="number" id="productPrice" class="form-control text-center" value="0" placeholder="0" autocomplete="off" onkeypress="return isNumber(event);" onkeyup="computePrice();" onchange="computePrice();">
                                    </div>
                                </div>
                                <div class="col-12 col-md-1 form-group position-relative">
                                    <label for="productTotal" class="w-100 text-center">ราคา</label>
                                    <div class="input-wrapper">
                                        <!-- <i class="fa fa-keyboard input-icon" aria-hidden="true"></i> -->
                                        <input type="text" readonly id="productTotal" class="form-control text-center" style="background-color: #fff;" value="0" placeholder="0">
                                    </div>
                                </div>
                                <div class="col-12 col-md-1 form-group position-relative">
                                    <label for="productInv" class="w-100 text-center">ราคาทุน</label>
                                    <div class="input-wrapper">
                                        <!-- <i class="fa fa-keyboard input-icon" aria-hidden="true"></i> -->
                                        <input type="text" readonly id="productInv" class="form-control text-center" style="background-color: #fff;" value="" placeholder="0" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-12 col-md-2 form-group position-relative">
                                    <!-- ค้นหาสินค้า -->
                                    <button id="saveItemBtn" class="btn btn-success boxx"><i class="fa fa-plus"></i> เพิ่มรายการ</button>
                                </div>
                            </div>
                            <!-- Repair Items -->
                            <div class="form-group row">
                                <label>รายการอะไหล่</label>
                                <div class="table-responsive">
                                    <table
                                        class="table table-bordered"
                                        id="repairItemsTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="40%">ชื่ออะไหล่</th>
                                                <th width="15%" class="text-center">จำนวน</th>
                                                <th width="20%" class="text-center">ราคาต่อหน่วย</th>
                                                <th width="20%" class="text-right">รวม</th>
                                                <th width="5%"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="orderItemsBody">
                                            <!-- Repair items will be added here -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5">
                                                    <div class="row">
                                                        <div class="col-6 col-md-3 form-group position-relative">
                                                            <label for="vatSale" class="col-form-label" style="padding:0px 0px;">ภาษี</label>
                                                            <div class="input-icon-wrapper">
                                                                <input class="toggle-event" id="vatSale" data-id="" type="checkbox" name="vatSale" data-toggle="toggle" data-off="ไม่มี Vat" data-on="&nbsp;&nbsp; มี Vat &nbsp;&nbsp;" data-onstyle="warning" data-style="ios">
                                                            </div>
                                                            <!-- <div id="vatValue" class="d-none">
                                                                0.00
                                                            </div> -->
                                                        </div>
                                                        <div class="col-6 col-md-3 form-group position-relative">
                                                            <label for="typeSale" class="col-form-label" style="padding:0px 0px;">ประเภทการชำระ</label>
                                                            <div>
                                                                <input class="toggle-event" id="typeSale" data-id="" type="checkbox" name="typeSale" checked data-toggle="toggle" data-off="ค้างชำระ" data-on="ชำระเงินสด" data-onstyle="success" data-style="ios">
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-2 form-group position-relative">
                                                            <label for="vatValue" class="w-100 text-right">ภาษี</label>
                                                            <div class="font-weight-bold text-right"
                                                                id="vatValue">
                                                                0.00
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-2 form-group position-relative">
                                                            <label for="orderTotal" class="w-100 text-right">ยอดรวมสุทธิ</label>
                                                            <div class="font-weight-bold text-right"
                                                                id="orderTotal">
                                                                0.00
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-2 form-group position-relative">
                                                            <label for="partsTotal" class="w-100 text-right">ค่าอะไหล่รวม</label>
                                                            <div class="font-weight-bold text-right"
                                                                id="partsTotal">
                                                                0.00
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <table id="dataTable" class="table table-bordered" width="100%">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="viewProductModal" style="overflow-x: hidden;overflow-y: auto;" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="width:auto;max-width:700px;">>
                <div class="modal-content" style="height:80vh;border-radius: 20px;">
                    <div class="modal-header bg-warning">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                                <label for="Product_NameModal" class="form-label">รหัส/ชื่อสินค้า</label>
                                <div class="input-icon-wrapper" style="width:80%;">
                                    <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                    <input type="text" class="form-control" id="Product_NameModal" value="" onkeyup="dataFilterProductNameModal();" placeholder="รหัส/ชื่อสินค้า..." value="" autocomplete="off" />
                                    <div id="productSuggestions" class="suggestions"></div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                                <label for="filterType" class="form-label">ประเภทสินค้า</label>
                                <div class="input-icon-wrapper" style="width:80%;">
                                    <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                    <input type="text" class="form-control" id="filterType" value="" placeholder="" value="" onkeydown="checkEnterTypeFilter(event,this.value);" autocomplete="off" />
                                    <div id="filterTypeSuggestions" class="suggestions"></div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                                <label for="filterGroup" class="form-label">ยี่ห้อ/รุ่น</label>
                                <div class="input-icon-wrapper" style="width:80%;">
                                    <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                    <input type="text" class="form-control" id="filterGroup" value="" placeholder="" value="" onkeydown="checkEnterTypeFilter(event,this.value);" autocomplete="off" />
                                    <div id="filterGroupSuggestions" class="suggestions"></div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding-top: 0px;">
                        <form>
                            <div class="form-group">
                                <div class="col-12 d-flex justify-content-center">
                                    <table class="table table-striped tableFixHead">
                                        <thead>
                                            <tr>
                                                <th scope="col">รายการสินค้า</th>
                                            </tr>
                                        </thead>
                                        <tbody id="showProductTable">
                                        </tbody>
                                    </table>
                                </div>
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
    <script src="../indexedDB/indexedDB.js"></script>
    <script src="../js/autocomplete.js?<?php echo time(); ?>"></script>

    <script src="order_products.js?<?php echo time(); ?>"></script>

    <script src="../../assets/js/thai-baht-text.js?<?php echo time(); ?>"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> -->
    <!-- <script type="text/javascript" src="../../plugins/bootstrap4-datetimepicker/moment.min.js"></script> -->
    <!-- <script type="text/javascript" src="../../plugins/bootstrap4-datetimepicker/bootstrap-datetimepicker.min.js"></script> -->

    <!-- <script type="text/javascript" src="../../plugins/daterangepicker/jquery.datetimepicker.js"></script> -->

    <!-- <script type="text/javascript" src="../../plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> -->
    <!-- thai extension -->
    <!-- <script type="text/javascript" src="../../plugins/bootstrap-datepicker/js/bootstrap-datepicker-thai.js"></script>
    <script type="text/javascript" src="../../plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.th.js"></script> -->
    <!-- <script src="../../assets/js/picker_date_modal.js?<?php echo time(); ?>"></script> -->

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script type="text/javascript">
        let products = [];
        let customers = [];
        let typeNames = [];
        let groupNames = [];
        let MAXRowPerPage = <?php echo $MAXRowPerPage_Front; ?>;
        let countRow = 0;
        let editMode = false;
        let editOrder = null;
        // alert(MAXRowPerPage);

        $('#vatSale').bootstrapToggle();
        $('#vatSale').off('change');

        $('#typeSale').bootstrapToggle();
        $('#typeSale').off('change');

        flatpickr("#orderDate", {
            dateFormat: "d/m/Y",
            allowInput: true
        });


        function setupAutocompleteLess(
            inputId,
            suggestionsId,
            dataList,
            codeId,
            arrayShowValue,
            arrayFindValue,
            sizeValue,
            callbackFunction
        ) {
            const input = document.getElementById(inputId);
            const suggestionsBox = document.getElementById(suggestionsId);

            let currentFocus = -1;
            let eventInput = false;
            let eventFocus = false;
            let old_value = "";
            let suggestionClick = false;
            let suggestionValue = "";

            input.addEventListener("focus", function(event) {
                // event.preventDefault();

                this.select();

                console.log("eventFocus : " + eventFocus);
                console.log("eventInput : " + eventInput);
                console.log("suggestionClick : " + suggestionClick);
                console.log("this.value : " + this.value);

                if (eventFocus) {
                    eventFocus = false;
                    eventInput = false;
                    return;
                }
                eventFocus = true;
                // eventInput = false;
                // console.log("eventFocus" + eventFocus);
                // console.log("Focus");
                if (this.value || this.value !== "") {
                    if (!suggestionClick) {
                        suggestionsBox.classList.remove("d-none");
                        suggestionClick = false;
                        return;
                    }
                    old_value = this.value;
                    createsuggestionsBox(suggestionValue);
                } else {
                    old_value = "";
                    createsuggestionsBox(this.value??"");
                }
                // alert("focus");
            });

            input.addEventListener("focusout", function() {
                eventInput = false;
                eventFocus = false;
                console.log("Focusout");
            });

            input.addEventListener("input", function(event) {
                eventInput = true;
                eventFocus = false;
                suggestionClick = false;
                // const value = this.value.toLowerCase();
                createsuggestionsBox(this.value);
            });

/*
            input.addEventListener("input", function(event) {
                // event.preventDefault();
                eventInput = true;
                suggestionClick = false;
                // eventFocus = true;
                const value = this.value.toLowerCase();
                suggestionsBox.classList.remove("d-none");
                suggestionsBox.innerHTML = "";
                currentFocus = -1;
                if (callbackFunction) {
                    callbackFunction(null);
                }

                if (!value || value.length < sizeValue) return;

                let tmpMatches = [];

                let matches = [];

                arrayFindValue.forEach((findItem) => {
                    let tmp = dataList.filter((item) =>
                        item[findItem].toLowerCase().includes(value)
                    );
                    matches.push(...tmp);
                });

                matches = Array.from(new Set(matches));
                // matches.sort(function(a, b) {
                //     return a.name.localeCompare(b.name);
                // });
                if (matches.length) {
                    suggestionsBox.classList.add("suggestions-active");
                } else {
                    suggestionsBox.classList.remove("suggestions-active");
                }

                matches.forEach((item) => {
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
                    div.textContent = strShowValue;
                    div.classList.add("suggestion-item");
                    div.addEventListener("click", () => {
                        input.value = `${item[codeId]}`;
                        if (callbackFunction) {
                            callbackFunction(item);
                        }
                        suggestionClick = true;
                        suggestionsBox.innerHTML = "";
                    });
                    suggestionsBox.appendChild(div);
                });
            });
*/
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

            function createsuggestionsBox(value) {
                // event.preventDefault();
                // eventInput = true;
                // eventFocus = true;
                // const value = this.value.toLowerCase();
                // if (value) {
                //     console.log("Value");
                //     suggestionsBox.classList.remove("d-none");
                //     suggestionsBox.classList.add("suggestions-active");
                //     // return;
                // }
                value = value.toLowerCase();
                suggestionsBox.classList.remove("d-none");
                suggestionsBox.innerHTML = "";
                // suggestionValue = "";
                currentFocus = -1;
                if (callbackFunction) {
                    callbackFunction(null);
                }

                let tmpMatches = [];

                let matches = [];

                arrayFindValue.forEach((findItem) => {
                    let tmp = dataList.filter((item) =>
                        item[findItem].toLowerCase().includes(value)
                    );
                    matches.push(...tmp);
                });

                matches = Array.from(new Set(matches));
                // matches.sort(function(a, b) {
                //     return a.name.localeCompare(b.name);
                // });


                if (matches.length) {
                    suggestionsBox.classList.add("suggestions-active");
                } else {
                    suggestionsBox.classList.remove("suggestions-active");
                }

                matches.forEach((item) => {
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
                    div.textContent = strShowValue;
                    div.classList.add("suggestion-item");
                    div.addEventListener("click", () => {
                        input.value = `${item[codeId]}`;
                        if (callbackFunction) {
                            callbackFunction(item);
                        }
                        suggestionValue = `${item[codeId]}`;
                        suggestionClick = true;
                        suggestionsBox.classList.add("d-none");
                        // suggestionsBox.innerHTML = "";
                    });
                    suggestionsBox.appendChild(div);
                });
            }

            function setActive(items) {
                if (!items.length) return;
                items.forEach((item) => item.classList.remove("active"));
                items[currentFocus]?.classList.add("active");
                items[currentFocus]?.scrollIntoView({
                    block: "nearest",
                });
            }

            document.addEventListener("click", (e) => {
                if (!e.target.closest(`#${inputId}`)) {
                    // suggestionsBox.innerHTML = "";
                    suggestionsBox.classList.add("d-none");
                    suggestionsBox.classList.remove("suggestions-active");
                }
            });
        }

        // picker_date(document.getElementById("endDateTh"), {
        //     year_range: "-10:+10",
        //     onchange: "setEndDate"
        // });

        // $(function() {
        //     $('#datetimepicker1').datetimepicker({
        //         locale: 'th',
        //         format: 'L'
        //     });
        // });
        // $('.datepicker').datepicker({
        //     language: 'th-th',
        //     format: 'dd/mm/yyyy',
        //     todayBtn: 'linked',
        //     yearOffset: 543
        // })

        // $(function() {
        //     var thaiYear = function(ct) {
        //         var leap = 3;
        //         var dayWeek = ["พฤ.", "ศ.", "ส.", "อา.", "จ.", "อ.", "พ."];
        //         if (ct) {
        //             var yearL = new Date(ct).getFullYear() - 543;
        //             leap = (((yearL % 4 == 0) && (yearL % 100 != 0)) || (yearL % 400 == 0)) ? 2 : 3;
        //             if (leap == 2) {
        //                 dayWeek = ["ศ.", "ส.", "อา.", "จ.", "อ.", "พ.", "พฤ."];
        //             }

        //         }
        //         this.setOptions({
        //             i18n: {
        //                 th: {
        //                     dayOfWeek: dayWeek
        //                 }
        //             },
        //             dayOfWeekStart: leap,
        //         })
        //     };
        //     $("#datetimepicker").datetimepicker({
        //         // timepicker: false,
        //         format: 'd-m-Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000            
        //         // lang: 'th', // แสดงภาษาไทย
        //         onChangeMonth: thaiYear,
        //         onShow: thaiYear,
        //         yearOffset: 543, // ใช้ปี พ.ศ. บวก 543 เพิ่มเข้าไปในปี ค.ศ
        //         closeOnDateSelect: true,
        //     });
        //         $('#datetimepicker').datetimepicker({
        //             format: 'DD-MM-YYYY',
        //             timepicker:false,
        //             // locale: 'th',
        //             // yearOffset:543,
        //             icons: {
        // //                 timepicker:false,
        // // lang:'th',  // แสดงภาษาไทย
        // // yearOffset:543,  // ใช้ปี พ.ศ. บวก 543 เพิ่มเข้าไปในปี ค.ศ
        // // inline:true,
        //                 // locale: 'th',
        //                 time: 'fa fa-clock',
        //                 date: 'fa fa-calendar',
        //                 up: 'fa fa-chevron-up',
        //                 down: 'fa fa-chevron-down',
        //                 previous: 'fa fa-chevron-left',
        //                 next: 'fa fa-chevron-right',
        //                 today: 'fa fa-check',
        //                 clear: 'fa fa-trash',
        //                 close: 'fa fa-times'
        //             }
        //         })
        // });

        // Fetch data from API
        const fetchData = async (endpoint) => {
            try {
                const response = await fetch(`services/${endpoint}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                return data.orderId;
            } catch (error) {
                console.error(`Error fetching ${endpoint}:`, error);
                throw error;
            }
        };

        function validateRepairForm() {
            let isValid = true;
            // return true;

            if (!$("#customerInput").val()) {
                $("#customerInput").addClass("is-invalid");
                isValid = false;
            } else {
                $("#customerInput").removeClass("is-invalid");
            }

            if (!$("#customerName").val()) {
                $("#customerName").addClass("is-invalid");
                isValid = false;
            } else {
                $("#customerName").removeClass("is-invalid");
            }

            if (!$("#orderDate").val()) {
                $("#orderDate").addClass("is-invalid");
                isValid = false;
            } else {
                $("#orderDate").removeClass("is-invalid");
            }

            if ($("#orderItemsBody tr").length === 0) {
                sweetAlertError("กรุณาเพิ่มรายการอะไหล่อย่างน้อย 1 รายการ");
                // alert("กรุณาเพิ่มรายการอะไหล่อย่างน้อย 1 รายการ");
                isValid = false;
            }

            return isValid;
        }

        async function saveProductSale() {
            if ($("#orderItemsBody tr").length === 0) {
                sweetAlertError("กรุณาเพิ่มรายการอะไหล่อย่างน้อย 1 รายการ", 3000);
                return;
            }

            let message = `บันทึกรายการขาย?`;
            confirm = await sweetConfirmSave(message, "ใช่! บันทึกเลย");
            if (!confirm) {
                return;
            }

            // Validate form
            if (!validateRepairForm()) {
                sweetAlertError("กรุณาตรวจสอบข้อมูล!!!", 3000);
                return;
            }

            const orderItems = [];
            let partsTotal = 0;

            $("#orderItemsBody tr").each(function() {
                const partId = $(this).data("part-id");
                // const partName = $(this).find("td:eq(0)").text();
                const partName = $(this).find(".item-partName").val();
                const quantity = parseFloat($(this).find(".item-quantity").val()) || 0;
                const price = parseFloat($(this).find(".item-price").val()) || 0;
                const total = quantity * price;

                orderItems.push({
                    id: partId,
                    name: partName,
                    price: price,
                    quantity: quantity,
                    total: total,
                });
                partsTotal += total;
            });
            let typeSale = $("#typeSale")[0].checked ? 1 : 0
            let vat = $("#vatSale")[0].checked ? 1 : 0;
            let vatValue = partsTotal * 0.07 * vat;
            let total = partsTotal + vatValue;

            let orderId = "";
            let orderDate = $("#orderDate").val();
            let customerId = $("#customerInput").val();
            orderDate = orderDate.substr(6, 4) + "-" + orderDate.substr(3, 2) + "-" + orderDate.substr(0, 2);

            if (editMode) {
                orderId = editOrder.orderId;
                orderDate = editOrder.mydate;
                customerId = editOrder.customerId;
            }

            // let orderDate = $("#orderDate").val();
            // Create repair object
            const order = {
                editMode: editMode,
                orderId: orderId,
                orderDate: orderDate,
                customerId: $("#customerInput").val(),
                customerName: $("#customerName").val(),
                customerAddress: $("#customerAddress").val(),
                customerTelephone: $("#customerTelephone").val(),
                status: 0,
                vat: vat,
                typeSale: typeSale,
                vatValue: vatValue,
                partsTotal: partsTotal,
                total: total,
                orderItems: orderItems,
                thaiBahtText: ThaiBahtText(total)
            };

            console.table(order);

            setStorage("order", order);
            let dataAwait = await saveDataOrderApiAxios("saveOrderAxios.php", order);
            if (dataAwait) {
                let orderId = dataAwait.orderId;
                confirm = await sweetConfirmSave(`ต้องการพิมพ์ใบเสร็จ?`, "ใช่! พิมพ์เลย");
                if (confirm) {
                    // window.open('print_receipt.php?orderId=' + orderId, '_blank');
                    window.open('print_receive_seng.php?orderId=' + orderId, '_blank');
                    // resetValueSale();
                }
            } else {
                sweetAlertError('เกิดข้อผิดพลาดในการบันทึกข้อมูล !!!', 0);
            }
        }

        async function _saveProductSale() {
            const order = await getStorage("order");

            // console.table(order);

            // saveDataOrderApi("saveOrder.php", order);
            let dataAwait = await saveDataOrderApiAxios("saveOrderAxios.php", order);
            if (dataAwait) {
                let orderId = dataAwait.orderId;
                confirm = await sweetConfirmSave(`ต้องการพิมพ์ใบเสร็จ?`, "ใช่! พิมพ์เลย");
                if (confirm) {
                    window.open('print_receipt.php?orderId=' + orderId, '_blank');
                }
                // resetValueSale();
            } else {
                sweetAlertError('เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' + data.message, 0);
            }
        }

        const saveDataOrderApi = async (endpoint, data) => {
            try {

                // const lastSyncTime = await getLastSyncTime(progressKey);
                const response = await fetch(`services/${endpoint}`, {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer my-secret-token',
                        'Custom-Header': 'HelloWorld'
                    },
                    body: JSON.stringify({
                        data: data
                    })
                });
                if (!response.ok) {
                    let resultError = await response.json();
                    throw new Error(`${resultError.message}`);
                }
                let result = await response.json();
                if (result.status) {
                    sweetAlert(`Data fetching ${endpoint} : ${result.message}`, 0);
                    // confirm = await sweetConfirmSave(`ต้องการพิมพ์ใบเสร็จ?`, "ใช่! พิมพ์เลย");
                    // if (confirm) {
                    //     window.open('print_receipt.php?orderId=' + order.orderId, '_blank');
                    // }
                } else {
                    sweetAlertError(`Error fetching ${endpoint} : ${result.message}`);
                }
                return data;
            } catch (error) {
                sweetAlertError(`Error fetching ${endpoint}: ${error}`, 0);
                console.error(`Error fetching ${endpoint}:`, error);
                throw error;
            }
        };

        const saveDataOrderApiAxios = async (endpoint, dataSend) => {
            try {
                const response = await axios.post(`services/${endpoint}`, {
                    data: dataSend
                });

                const data = response.data; // ⬅️ ข้อมูลจาก server
                if (data.status) {
                    sweetAlert(`Data fetching ${endpoint} : ${data.message}`, 0);
                } else {
                    sweetAlertError(`Error fetching ${endpoint} : ${result.message}`);
                }
                return data;
            } catch (error) {
                let msg = error.response.data.message;
                sweetAlertError(`Error fetching ${endpoint}: ${msg}`, 0);
                // sweetAlertError(`Error fetching ${endpoint}: ${error}`, 0);
                return null;
            }
        };

        $(document).ready(async function() {
            loaderScreen("show");
            await openDB();
            loadAndSetData("products");
            loadAndSetData("customers");
            loadAndSetData("groupnames");
            loadAndSetData("typenames");
            // loadAndSetData("suppliers");
            setupProductItemEventHandlers();
            resetValueSale();
            loaderScreen("hide");
        });

        function _isNumber(evt) {
            try {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt?.keyCode ?? evt?.key;
                // let charCode = evt.keyCode;
                // alert(charCode)
                /*
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                */
                if (charCode >= 48 && charCode <= 57) {
                    return true;
                }
                evt.preventDefault();
                return false;

            } catch (ex) {
                alert("AAA")

                evt.preventDefault();
                return false;

            }

        }

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode >= 48 && charCode <= 57) {
                return true;
            }
            return false;
        }

        function computePrice() {
            let total = Number($("#productQty").val()) * Number($("#productPrice").val());
            $("#productTotal").val(total);
        }

        function checkEnter(event, value) {
            // alert(event.key)
            if (event.key === "Enter") {
                findProductId(value);
            }
        }

        function checkEnterTypeFilter(event, value) {
            // alert(event.key)
            if (event.key === "Enter") {
                dataFilterProductModal();
                // document.getElementById("filterTypeSuggestions").innerHTML = "";
                // document.getElementById("filterTypeSuggestions").classList.remove("suggestions-active");
            }
        }

        function findProductId(id) {
            if (id !== "") {
                let item = products.find((element) => element.productId == id);
                if (item) {
                    // alert(item.name);
                    setValueProductSale(item);
                    // setFocusInput("#productPrice");
                    document.getElementById("productSuggestions").innerHTML = "";
                }
            }
        }

        // callback function
        const setValueCustomerSale = (item) => {
            $("#customerName").val(item?.name ?? "");
            $("#customerAddress").val(item?.address ?? "");
            $("#customerTelephone").val(item?.telephone ?? "");
            // if (item) {
            //     setFocusInput("#productPrice");
            // }
        }

        // callback function
        const setValueProductSale = (item) => {
            /*
                let price = item?.price1 ?? 0;
                let qty = $("#productQty").val()=>1?$("#productQty").val():1;
                let total = price * qty;
                $("#productName").val(item?.name ?? "");
                $("#productPrice").val(item?.price1 ?? 0);
                $("#productInv").val(item?.price0 ?? "");

                $("#productPrice").val(price);
                $("#productQty").val(qty);
                $("#productInv").val(item?.price0 ?? "");
                $("#productTotal").val(total);
                */
            let price = item?.price1 ?? 0;
            let qty = Number($("#productQty").val());
            let total = price * qty;

            $("#productName").val(item?.name ?? "");
            $("#productPrice").val(item?.price1 ?? 0);
            $("#productInv").val(item?.price0 ?? "");
            $("#productTotal").val(total);
            if (item) {
                setFocusInput("#productPrice");
            }
        }

        function setFocusInput(element) {
            $(element).select();
            $(element).focus();
        }

        function resetValueProductSale() {
            $("#productInput").val("");
            $("#productName").val("");
            $("#productPrice").val(0);
            $("#productQty").val(1);
            $("#productInv").val(0);
            setFocusInput("#productInput");
        }

        function resetValueSale() {
            countRow = 0;
            $("#customerInput").val("");
            $("#customerName").val("");
            $("#orderDate").val(new Date().toISOString().slice(0, 10));

            $("#orderDate").val(new Date().toLocaleDateString("en-GB"));

            $("#orderTotal").text(
                Number(0).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                })
            );
            $("#vatCost").text(
                Number(0).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                })
            );
            $("#partsTotal").text(
                Number(0).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                })
            );

            $("#customerInput").removeClass("is-invalid");
            $("#customerName").removeClass("is-invalid");

            resetValueProductSale();
            $("#orderItemsBody").html("");
            setFocusInput("#customerInput");
        }

        async function loadAndSetData(storeName) {
            let dataStore = await loadDataFromDB(storeName);
            if (storeName == "products") {
                products = dataStore;
                setupAutocompleteProducts(
                    "productInput", "productSuggestions", products, "productId", ["productId", "name"], ["productId", "name"], setValueProductSale);
            } else if (storeName == "groupnames") {
                groupNames = dataStore;
                setupAutocomplete(
                    "filterGroup", "filterGroupSuggestions", groupNames, "groupname", ["groupname"], ["groupname"], dataFilterProductModal);
            } else if (storeName == "typenames") {
                typeNames = dataStore;
                setupAutocomplete(
                    "filterType", "filterTypeSuggestions", typeNames, "typename", ["typename"], ["typename"], dataFilterProductModal);
            } else if (storeName == "suppliers") {
                suppliers = dataStore;
                setupAutocomplete(
                    "supplierName", "supplierNameSuggestions", suppliers, "name", ["name"], ["supplierId", "name"]);
            } else if (storeName == "customers") {
                customers = dataStore;
                setupAutocompleteOnFocus(
                    "customerInput", "customerSuggestions", customers, "customerId", ["customerId", "name"], ["customerId", "name"], setValueCustomerSale);
            }
        }

        function dataFilterProductNameModal() {
            const input = document.getElementById('Product_NameModal');
            const datalist = document.getElementById('showProductTable');
            const filter = input.value;
            datalist.innerHTML = ''; // Clear existing options
            if (filter == "" || filter.length < 3) return;

            let arrFilter = filter.split(" ");
            let tmpProducts = products;
            arrFilter.forEach(filter => {
                tmpProducts = tmpProducts.filter(option => option.name.toLowerCase().includes(filter.toLowerCase()));
            });

            tmpProducts = tmpProducts.sort((a, b) => {
                return a.name.localeCompare(b.name);
            });
            let body = "";
            tmpProducts.forEach(option => {
                let onClick = `onclick="setProductOnSelected('${option.productId}');"`;
                let tr = `
                              <tr ${onClick}>
                                  <td>${option.productId} : ${option.name}</td>
                              </tr>
                             `;
                body += tr;
            });

            $("#showProductTable").html(body);

        }

        function dataFilterProductModal(item) {

            const datalist = document.getElementById('showProductTable');
            const inputType = document.getElementById('filterType');
            const filterType = inputType.value;
            const inputGroup = document.getElementById('filterGroup');
            const filterGroup = inputGroup.value;
            datalist.innerHTML = ''; // Clear existing options
            if ((filterType == "" || filterType.length < 3) && (filterGroup == "" || filterGroup.length < 3)) return;

            let tmpProducts = products;
            tmpProducts = tmpProducts.filter(option => option.typename.includes(filterType));
            tmpProducts = tmpProducts.filter(option => option.groupname.includes(filterGroup));

            tmpProducts = tmpProducts.sort((a, b) => {
                return a.name.localeCompare(b.name);
            });
            let body = "";
            tmpProducts.forEach(option => {
                let onClick = `onclick="setProductOnSelected('${option.productId}');"`;
                let tr = `
                              <tr ${onClick}>
                                  <td>${option.productId} : ${option.name}</td>
                              </tr>
                             `;
                body += tr;
            });

            $("#showProductTable").html(body);

        }

        function setDataProductID(productid) {
            let Product = products.filter(item => item.productId == productid);
            if (Product.length) {
                $("#productInput").val(Product[0].productId);
                $("#productName").val(Product[0].name);

                $("#productName").val(Product[0].name);
                $("#productPrice").val(Product[0].price1); // ราคาขายหน้าร้าน

                $("#btnAdd").prop('disabled', false);
                computePrice();
                $("#productPrice").focus();
                $("#productPrice").select();
            } else {
                $("#btnAdd").prop('disabled', true);
                $("#productName").val("");
                $("#productPrice").val(0);
            }
        }

        function setProductOnSelected(productId) {
            productIdSelected = productId;
            $('#viewProductModal').modal('hide');
            $("#searchProductID").val(productId);
            setTimeout(setDataProductID, 500, productIdSelected);
        }

        $(function() {
            var focusedElement;
            $(document).on('focus', 'input', function() {
                if (focusedElement == this) return;
                if ("customerInput" == this.id) return;
                focusedElement = this;
                setTimeout(function() {
                    focusedElement.select();
                }, 100);
            });
        });
    </script>
</body>

</html>