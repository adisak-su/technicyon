<?php
require_once('../authen.php');
require_once("../../assets/php/common.php");
require_once("../../service/configData.php");
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการสินค้า | <?php echo $shopName; ?></title>

    <!-- Favicons -->
    <?php include_once('../../includes/pagesFavicons.php'); ?>

    <!-- stylesheet -->
    <?php // include_once('../../includes/pagesStylesheet.php'); 
    ?>
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="../../plugins/bootstrap-toggle/bootstrap-toggle.min.css">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/6.5.0.all.min.css">

    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="../../assets/css/loading.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../../assets/css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../../plugins/datetimeFlatpicker/flatpickr.min.css">

    <link rel="stylesheet" href="../menus/menuheader.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">

    <style>

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
                        <div class="card-body" style="font-size: 1rem;" id="itemModal">
                            <div class="row">
                                <div class="col-12 col-lg-2 rounded bg-white p-4 order-1 order-lg-2">
                                    <div class="row form-group position-relative d-flex justify-content-between">
                                        <button id="resetProductSale" class="btn btn-warning boxx text-white" style="max-width:200px;" onclick="resetValueSale();"><i class="fa fa-trash"></i> ล้างหน้าจอ</button>
                                        <button id="saveProductSale" class="btn btn-primary boxx" style="max-width:200px;" onclick="saveProductSale();"><i class="fa fa-save"></i> บันทึกการขาย</button>
                                        <!-- <button id="printProductSale" class="btn btn-primary boxx w-25" style="max-width:200px;" onclick="window.location.href='print-repair.php';"><i class="fa fa-print"></i> Print</button> -->
                                    </div>
                                    <div class="row form-group position-relative d-flex justify-content-between">
                                        <div class="">
                                            <label for="vatSale" class="col-form-label" style="padding:0px 0px;">ภาษี</label>
                                            <div class="input-icon-wrapper">
                                                <input class="toggle-event" id="vatSale" data-id="" type="checkbox" name="vatSale" data-toggle="toggle" data-off="ไม่มี Vat" data-on="&nbsp;&nbsp; มี Vat &nbsp;&nbsp;" data-onstyle="warning" data-offstyle="secondary" data-style="ios">
                                            </div>
                                        </div>
                                        <div class="">
                                            <label for="typeSale" class="col-form-label" style="padding:0px 0px;">ประเภทการชำระ</label>
                                            <div>
                                                <input class="toggle-event" id="typeSale" data-id="" type="checkbox" name="typeSale" checked data-toggle="toggle" data-off="ค้างชำระ" data-on="ชำระเงินสด" data-onstyle="success" data-offstyle="secondary" data-style="ios">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 form-group d-flex justify-content-between">
                                            <label for="partsTotal" class="">ค่าอะไหล่รวม</label>
                                            <div class="font-weight-bold text-right"
                                                id="partsTotal">
                                                0.00
                                            </div>
                                        </div>
                                        <div class="col-12 form-group d-flex justify-content-between">
                                            <label for="vatValue" class="">ภาษี</label>
                                            <div class="font-weight-bold text-right"
                                                id="vatValue">
                                                0.00
                                            </div>
                                        </div>
                                        <div class="col-12 form-group d-flex justify-content-between">
                                            <label for="orderTotal" class="">ยอดรวมสุทธิ</label>
                                            <div class="font-weight-bold text-right"
                                                id="orderTotal">
                                                0.00
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-10 p-4 order-2 order-lg-1">
                                    <div class="row align-items-end">
                                        <div class="col-12 col-md-6 col-lg-3 col-xl-2 form-group position-relative">
                                            <input type="hidden" id="orderCode">
                                            <label for="orderInput">เลขบิล</label>
                                            <div class="d-flex flex-row justify-content-between">
                                                <div class="input-icon-wrapper" style="width: calc(100% - 50px);">
                                                    <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                    <input type="text" class="form-control" id="orderInput" value="" placeholder="เลขบิล..." value="" onkeydown="checkEnter(event,this.value);" autocomplete="off" />
                                                    <div id="orderSuggestions" class="suggestions"></div>
                                                </div>
                                                <button id="btnViewOrder" class="btn btn-primary boxx" style="width: 40px;" data-toggle="modal" data-target="#viewOrderModal"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-2 col-xl-2 form-group position-relative">
                                            <label for="customerInput" class="form-label">รหัสลูกค้า</label>
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input type="text" id="customerInput" class="form-control" value="" placeholder="รหัส/ชื่อลูกค้า..." value="" onkeydown="checkEnter(event,this.value);" autocomplete="off" />
                                            </div>
                                            <div id="customerSuggestions" class="suggestions"></div>
                                            <input type="hidden" id="customerCode">
                                        </div>
                                        <div class="col-12 col-md-8 col-lg-4 col-xl-4 form-group position-relative">
                                            <label for="customerName">ชื่อ</label>
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input type="text" id="customerName" class="form-control" value="" placeholder="..." autocomplete="off">
                                            </div>
                                            <input type="hidden" id="customerAddress" class="form-control" value="" placeholder="..." autocomplete="off">
                                            <input type="hidden" id="customerTelephone" class="form-control" value="" placeholder="..." autocomplete="off">
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-3 col-xl-2 form-group position-relative">
                                            <label for="orderDate" class="d-block">วันที่</label>
                                            <div class="d-flex justify-content-start" style="gap: 10px;">
                                                <div class="input-icon-wrapper-after" style="width:180px; min-width:180px;">
                                                    <div class="input-icon">📅</div>
                                                    <input type="text" id="orderDate" class="form-control" style="cursor:pointer;" value="" placeholder="..." readonly autocomplete="off">
                                                </div>
                                                <!-- <button type="button" class="btn btn-outline-danger" id="reset-btn"><i class="fa fa-clock"></i></button> -->
                                                <button id="reset-btn" class="btn btn-primary boxx" style="width: 40px;"><i class="fa fa-clock"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-end">
                                        <div class="col-12 col-md-5 col-lg-2 col-xl-2 form-group position-relative">
                                            <!-- ค้นหาสินค้า -->
                                            <input type="hidden" id="productCode">
                                            <label for="productInput">รหัสสินค้า</label>
                                            <div class="d-flex flex-row justify-content-between">
                                                <div class="input-icon-wrapper" style="width: calc(100% - 50px);">
                                                    <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                    <input type="text" class="form-control" id="productInput" value="" placeholder="รหัส/ชื่อสินค้า..." value="" onkeydown="checkEnter(event,this.value);" autocomplete="off" />
                                                    <div id="productSuggestions" class="suggestions"></div>
                                                </div>
                                                <button id="btnViewProduct" class="btn btn-primary boxx" style="width: 40px;" data-toggle="modal" data-target="#viewProductModal"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-4 col-xl-4 form-group position-relative">
                                            <label for="productName">สินค้า</label>
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input type="text" id="productName" class="form-control" value="" placeholder="..." autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2 col-lg-1 col-xl-1 form-group position-relative">
                                            <label for="productQty" class="w-100 text-center">จำนวน</label>
                                            <div class="input-wrapper">
                                                <!-- <i class="fa fa-keyboard input-icon" aria-hidden="true"></i> -->
                                                <input type="number" id="productQty" class="form-control text-center" value="1" placeholder="0" autocomplete="off" onkeypress="return isNumber(event);" onkeyup="computePrice();" onchange="computePrice();">
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2 col-lg-1 col-xl-1 form-group position-relative">
                                            <label for="productPrice" class="w-100 text-center">ราคา/หน่วย</label>
                                            <div class="input-wrapper">
                                                <!-- <i class="fa fa-keyboard input-icon" aria-hidden="true"></i> -->
                                                <input type="number" id="productPrice" class="form-control text-center" value="0" placeholder="0" autocomplete="off" onkeypress="return isNumber(event);" onkeyup="computePrice();" onchange="computePrice();">
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2 col-lg-1 col-xl-1 form-group position-relative">
                                            <label for="productTotal" class="w-100 text-center">ราคา</label>
                                            <div class="input-wrapper">
                                                <!-- <i class="fa fa-keyboard input-icon" aria-hidden="true"></i> -->
                                                <input type="text" readonly id="productTotal" class="form-control text-center" style="background-color: #fff;" value="0" placeholder="0">
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2 col-lg-1 col-xl-1 form-group position-relative">
                                            <label for="productInv" class="w-100 text-center">ราคาทุน</label>
                                            <div class="input-wrapper">
                                                <!-- <i class="fa fa-keyboard input-icon" aria-hidden="true"></i> -->
                                                <input type="text" readonly id="productInv" class="form-control text-center" style="background-color: #fff;" value="" placeholder="0" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-2 col-xl-2 form-group position-relative">
                                            <!-- ค้นหาสินค้า -->
                                            <button id="saveItemBtn" class="btn btn-success btn-block boxx"><i class="fa fa-plus"></i> เพิ่มรายการ</button>
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
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <table id="dataTable" class="table table-bordered" width="100%">
                            </table> -->
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
                                <input type="text" class="form-control" id="filterType" value="" placeholder="..." value="" onkeydown="checkEnterTypeFilter(event,this.value);" autocomplete="off" />
                                <div id="filterTypeSuggestions" class="suggestions"></div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                            <label for="filterGroup" class="form-label">ยี่ห้อ/รุ่น</label>
                            <div class="input-icon-wrapper" style="width:80%;">
                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                <input type="text" class="form-control" id="filterGroup" value="" placeholder="..." value="" onkeydown="checkEnterTypeFilter(event,this.value);" autocomplete="off" />
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

    <!-- Modal find bill no -->
    <div class="modal fade" id="viewOrderModal" style="overflow-x: hidden;overflow-y: auto;" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="width:auto;max-width:700px;">>
            <div class="modal-content" style="height:80vh;border-radius: 20px;">
                <div class="modal-header bg-warning">
                    <div class="row w-100">
                        <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                            <label for="filterCustomerModal" class="form-label">รหัส/ชื่อลูกค้า</label>
                            <div class="input-icon-wrapper" style="width:80%;">
                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                <input type="text" class="form-control" id="filterCustomerModal" value="" placeholder="รหัส/ชื่อลูกค้า..." onkeyup="dataFilterProductNameModal();" placeholder="รหัส/ชื่อสินค้า..." value="" autocomplete="off" />
                                <div id="filterCustomerModalSuggestions" class="suggestions"></div>
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
                                            <th scope="col">รายการ</th>
                                        </tr>
                                    </thead>
                                    <tbody id="showOrderTable">
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
    <script src="../indexedDB/indexedDB.js?<?php echo time(); ?>"></script>
    <script src="../js/validateInput.js?<?php echo time(); ?>"></script>
    <script src="../js/autocomplete.js?<?php echo time(); ?>"></script>

    <script src="order_products.js?<?php echo time(); ?>"></script>

    <script src="../../assets/js/thai-baht-text.js?<?php echo time(); ?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="../../plugins/datetimeFlatpicker/flatpickr.js"></script>
    <script src="../js/initDateTimePicker.js?<?php echo time(); ?>"></script>

    <!-- <link rel="stylesheet" href="../../plugins/datetimeFlatpicker/flatpickr.js"> -->

    <script type="text/javascript">
        let products = [];
        let customers = [];
        let typeNames = [];
        let groupNames = [];
        let MAXRowPerPage = <?php echo $MAXRowPerPage_Front; ?>;
        let countRow = 0;
        let editMode = false;
        let editOrder = null;
        // let orderDateFlatpickr = null;
        // alert(MAXRowPerPage);

        //ตั้งค่าสำหรับการตรวจสอบข้อมูลการ Input
        let arrayValidateInput = [{
                id: "customerInput",
                name: "รหัสลูกค้า"
            },
            {
                id: "customerName",
                name: "ชื่อลูกค้า"
            },
            {
                id: "orderDate",
                name: "วันที่"
            }
        ];
        let validateInputForm = new ValidateInput("itemModal", arrayValidateInput);


        $('#vatSale').bootstrapToggle();
        $('#vatSale').off('change');

        $('#typeSale').bootstrapToggle();
        $('#typeSale').off('change');

        // สร้าง
        const orderDateFlatpickr = initDateTimePicker({
            displaySelector: "orderDate",
            resetBtn: "reset-btn",
            initialValue: null // หรือ null ถ้าไม่มีก็ไม่ต้องใส่
            //initialValue: "2025-06-27 15:30:35" // หรือ null ถ้าไม่มีก็ไม่ต้องใส่
        });

        // Fetch data from API
        const fetchData = async (endpoint) => {
            try {
                const response = await fetch(`services/${endpoint}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                if (data.status) {
                    return data.message;
                } else {
                    return null;
                }
            } catch (error) {
                console.error(`Error fetching ${endpoint}:`, error);
                throw error;
            }
        };

        async function saveProductSale() {
            $("#customerInput").val()

            // Validate form
            let statusValidate = validateInputForm.validate();

            if (!statusValidate.status) {
                let invalidStr = statusValidate.invalidString;
                sweetAlertError('กรุณากรอกข้อมูลให้ครบถ้วน' + invalidStr, 5000);
                return;
            }

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
            // if (!validateRepairForm()) {
            //     sweetAlertError("กรุณาตรวจสอบข้อมูล!!!", 3000);
            //     return;
            // }



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

            orderDate = orderDateFlatpickr.getFormatted();

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
                // orderDate: orderDate,
                orderDate: orderDateFlatpickr.getFormatted(),
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
                let orderId = dataAwait.message.orderId;
                let orderDate = dataAwait.message.mydate;
                order.orderId = orderId; // ในกรณี Insert
                order.orderDate = orderDate; // ในกรณี Insert
                saveOrderToOrders(order);

                confirm = await sweetConfirmSave(`ต้องการพิมพ์ใบเสร็จ?`, "ใช่! พิมพ์เลย");
                if (confirm) {
                    // window.open('print_receipt.php?orderId=' + orderId, '_blank');
                    window.open('print_receive.php?orderId=' + orderId, '_blank');
                    // resetValueSale();
                }
                resetValueSale();
            } else {
                sweetAlertError('เกิดข้อผิดพลาดในการบันทึกข้อมูล !!!', 0);
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

        const getDataOrderApiAxios = async (endpoint, orderId) => {
            try {
                const response = await axios.post(`services/${endpoint}`, {
                    orderId: orderId
                });

                const data = response.data; // ⬅️ ข้อมูลจาก server
                if (data.status) {
                    // return data.message;
                    return {
                        status: true,
                        data: data.message
                    };
                } else {
                    sweetAlertError(`Error fetching ${endpoint} : ${result.message}`);
                }
                return {
                    status: false,
                    error: result.message
                };
            } catch (error) {
                let msg = error.response.data.message ?? error.response.data;
                sweetAlertError(`Error fetching ${endpoint}: ${msg}`, 0);
                return {
                    status: false,
                    error: msg
                };
            }
        };

        function saveOrderToOrders(order) {
            let resultIndex = orders.findIndex((item) => {
                return item.orderId == order.orderId
            });

            if (resultIndex >= 0) {
                orders[resultIndex].mydate = order.orderDate;
                orders[resultIndex].nettotal = order.total;
            } else {
                orders.push({
                    orderId: order.orderId,
                    customerId: order.customerId,
                    mydate: order.orderDate,
                    nettotal: order.total
                });
            }
            orders.sort(function(a, b) {
                return b.mydate.localeCompare(a.mydate);
            });
        }

        $(document).ready(async function() {
            loaderScreen("show");
            orders = await fetchData("getOrder_head.php");
            await openDB();
            loadAndSetData("products");
            loadAndSetData("customers");
            loadAndSetData("groupnames");
            loadAndSetData("typenames");
            setupProductItemEventHandlers();
            resetValueSale();
            loaderScreen("hide");
        });

        function setSelectedDate(selectedDate, displaySelector) {
            // alert(selectedDate);
            let date = new Date(selectedDate);
            // alert(date);
            const dd = ("0" + date.getDate()).slice(-2);
            const mm = ("0" + (date.getMonth() + 1)).slice(-2);
            const yyyy = date.getFullYear() - 543;
            const hh = ("0" + date.getHours()).slice(-2);
            const mi = ("0" + date.getMinutes()).slice(-2);
            let result = `${yyyy}-${mm}-${dd} ${hh}:${mi}`;
            // orderDateFlatpickr.setDate(result);
            return result;
        }

        function updateDisplayDate(selectedDate, displaySelector) {
            // alert(selectedDate)
            updateDisplay(selectedDate);

            function updateDisplay(date) {
                if (!date) {
                    document.getElementById(displaySelector).value = "";
                    return;
                }
                const dd = ("0" + date.getDate()).slice(-2);
                const mm = ("0" + (date.getMonth() + 1)).slice(-2);
                const yyyy = date.getFullYear() + 543;
                const hh = ("0" + date.getHours()).slice(-2);
                const mi = ("0" + date.getMinutes()).slice(-2);
                document.getElementById(
                    displaySelector
                ).value = `${dd}/${mm}/${yyyy} ${hh}:${mi}`;
            }
        }

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
            let price = item?.priceFront ?? 0;
            let qty = Number($("#productQty").val());
            let total = price * qty;

            $("#productName").val(item?.name ?? "");
            $("#productPrice").val(item?.priceFront ?? 0);
            $("#productInv").val(item?.priceInv ?? "");
            $("#productTotal").val(total);
            if (item) {
                setFocusInput("#productPrice");
            }
        }

        function setFocusInput(element) {
            $(element).select();
            $(element).focus();
        }

        function setReadOnly() {
            if (editMode) {
                setReadOnly
                $("#saveProductSale").removeClass("btn-primary");
                $("#saveProductSale").addClass("btn-warning");
                $("#saveProductSale").html('<i class="fa fa-save"></i> บันทึกการแก้ไข');
                $("#orderInput").attr("readonly", true);
                $("#customerInput").attr("readonly", true);
                $("#customerName").attr("readonly", true);
                // $("#orderDate").attr("disabled", true);
            } else {
                $("#saveProductSale").removeClass("btn-warning");
                $("#saveProductSale").addClass("btn-primary");
                $("#saveProductSale").html('<i class="fa fa-save"></i> บันทึกการขาย');
                $("#orderInput").attr("readonly", false);
                $("#customerInput").attr("readonly", false);
                $("#customerName").attr("readonly", false);
                // $("#orderDate").attr("disabled", false);
            }
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
            editMode = false;
            countRow = 0;
            $("#orderInput").val("");
            $("#customerInput").val("");
            $("#customerName").val("");

            if ($("#vatSale")[0].checked) {
                $("#vatSale")[0].checked = false;
                $("#vatSale")[0].click();
            }

            if (!$("#typeSale")[0].checked) {
                $("#typeSale")[0].checked = true;
                $("#typeSale")[0].click();
            }

            // orderDateFlatpickr.setDate(new Date());
            let myDateNow = new Date().toLocaleDateString("en-GB") + " " + new Date().toLocaleTimeString("en-GB");
            // orderDateFlatpickr.setDate(myDateNow);
            orderDateFlatpickr.setDateNow();

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
            setReadOnly();

            $("#orderItemsBody").html("");
            setFocusInput("#customerInput");
        }

        async function loadAndSetData(storeName) {
            // setupAutocompleteOnFocus({
            //     inputId:inputId ,
            //     suggestionsId: ,
            //     dataList: ,
            //     codeId: ,
            //     arrayShowValue: ,
            //     arrayFindValue ,
            //     sizeFind = 0,
            //     sortField = null,
            //     callbackFunction = null
            // })
            let dataStore = await loadDataFromDB(storeName);
            if (storeName == "products") {
                products = dataStore;
                setupAutocompleteProducts(
                    "productInput", "productSuggestions", products, "productId", ["productId", "name"], ["productId", "name"], setValueProductSale);
            } else if (storeName == "groupnames") {
                groupNames = dataStore;
                // setupAutocomplete(
                //     "filterGroup", "filterGroupSuggestions", groupNames, "groupname", ["groupname"], ["groupname"], dataFilterProductModal);
                setupAutocompleteOnFocus({
                    inputId: "filterGroup",
                    suggestionsId: "filterGroupSuggestions",
                    dataList: groupNames,
                    codeId: "groupname",
                    arrayShowValue: ["groupname"],
                    arrayFindValue: ["groupname"],
                    callbackFunction: dataFilterProductModal,
                    sortField: "groupname"
                });
            } else if (storeName == "typenames") {
                typeNames = dataStore;
                // setupAutocomplete(
                //     "filterType", "filterTypeSuggestions", typeNames, "typename", ["typename"], ["typename"], dataFilterProductModal);
                setupAutocompleteOnFocus({
                    inputId: "filterType",
                    suggestionsId: "filterTypeSuggestions",
                    dataList: typeNames,
                    codeId: "typename",
                    arrayShowValue: ["typename"],
                    arrayFindValue: ["typename"],
                    callbackFunction: dataFilterProductModal,
                    sortField: "typename"
                });
            } else if (storeName == "suppliers") {
                suppliers = dataStore;
                // setupAutocomplete(
                //     "supplierName", "supplierNameSuggestions", suppliers, "name", ["name"], ["supplierId", "name"]);
                setupAutocompleteOnFocus({
                    inputId: "customerInput",
                    suggestionsId: "customerSuggestions",
                    dataList: customers,
                    codeId: "customerId",
                    arrayShowValue: ["customerId", "name"],
                    arrayFindValue: ["customerId", "name"],
                    callbackFunction: setValueCustomerSale,
                    sortField: "customerId"
                });
            } else if (storeName == "customers") {
                customers = dataStore;
                setupAutocompleteOnFocus({
                    inputId: "customerInput",
                    suggestionsId: "customerSuggestions",
                    dataList: customers,
                    codeId: "customerId",
                    arrayShowValue: ["customerId", "name"],
                    arrayFindValue: ["customerId", "name"],
                    callbackFunction: setValueCustomerSale,
                    sortField: "customerId"
                });

                setupAutocompleteOnFocus({
                    inputId: "filterCustomerModal",
                    suggestionsId: "filterCustomerModalSuggestions",
                    dataList: customers,
                    codeId: "customerId",
                    arrayShowValue: ["customerId", "name"],
                    arrayFindValue: ["customerId", "name"],
                    callbackFunction: dataFilterOrderModal,
                    sortField: "customerId"
                });

                // setupAutocompleteOnFocus(
                //     "customerInput", "customerSuggestions", customers, "customerId", ["customerId", "name"], ["customerId", "name"], setValueCustomerSale);
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

        function dataFilterOrderModal(item) {

            const datalist = document.getElementById('showOrderTable');
            const inputType = document.getElementById('filterCustomerModal');
            const filterType = inputType.value;

            datalist.innerHTML = ''; // Clear existing options
            if ((filterType == "")) return;

            let tmpProducts = orders;
            tmpProducts = tmpProducts.filter(option => option.customerId == filterType);

            // tmpProducts = tmpProducts.sort((a, b) => {
            //     return a.name.localeCompare(b.name);
            // });
            let body = "";
            tmpProducts.forEach(option => {
                let onClick = `onclick="setOrderOnSelected('${option.orderId}','${option.customerId}','${option.mydate}');"`;
                let tr = `
                              <tr ${onClick}>
                                  <td>${option.orderId}</td>
                                  <td>${getLocalDateTime(option.mydate)}</td>
                                  <td class="text-right">${formatNumber(option.nettotal)}</td>
                              </tr>
                             `;
                body += tr;
            });

            $("#showOrderTable").html(body);
        }

        function setDataProductID(productid) {
            let Product = products.filter(item => item.productId == productid);
            if (Product.length) {
                $("#productInput").val(Product[0].productId);
                $("#productName").val(Product[0].name);

                $("#productName").val(Product[0].name);
                $("#productPrice").val(Product[0].priceFront); // ราคาขายหน้าร้าน

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

        async function setOrderOnSelected(orderId, customerId, orderDate) {
            editMode = true;
            $('#viewOrderModal').modal('hide');
            $("#orderInput").val(orderId);
            $("#customerInput").val(customerId);



            let date = new Date(orderDate).toLocaleDateString("en-GB");
            //alert(orderDate)
            //alert(date);
            // $("#orderDate").val(date);
            // $("#orderDate").val(new Date().toLocaleDateString("en-GB"));
            //orderDateFlatpickr.setDate(date);
            //orderDateFlatpickr.setDate(date + " 15:35");

            //let myDateNow = new Date(orderDate).toLocaleDateString("en-GB") + " " + orderDate.sustr(11,5);

            let orderMyDate = new Date(orderDate);
            let myDateNow = orderMyDate.toLocaleDateString("en-GB") + " " + orderMyDate.toLocaleTimeString("en-GB");


            // orderDateFlatpickr.setDate(myDateNow);
            orderDateFlatpickr.setDateFromString(orderDate);


            let customerName = customers.find((item) => item.customerId == customerId);
            if (customerName) {
                $("#customerName").val(customerName.name);
            }
            editOrder = await getDataOrderApiAxios("getOrderAxios.php", orderId);
            console.log(editOrder)
            setReadOnly();
            if (editOrder.status) {
                editOrder = editOrder.data;
                let orderItems = editOrder.details;
                if (orderItems) {
                    orderItems = JSON.parse(orderItems);
                }
                if (Number(editOrder.vatvalue) == 0) {
                    if ($("#vatSale")[0].checked) {
                        $("#vatSale")[0].checked = false;
                        $("#vatSale")[0].click();
                    }
                } else {
                    if (!$("#vatSale")[0].checked) {
                        $("#vatSale")[0].checked = true;
                        $("#vatSale")[0].click();
                    }
                }
                addProductItemFromJSON(orderItems)
            } else {
                sweetAlertError('เกิดข้อผิดพลาดในการอ่านข้อมูล !!!' + editOrder.error, 0);
                editOrder = null;
            }
        }

        $(function() {
            var focusedElement;
            $(document).on('focus', 'input', function() {
                if (focusedElement == this) return;
                if (this.readOnly) return;
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