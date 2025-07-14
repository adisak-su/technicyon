<?php
require_once('../authen.php');
require_once("../../service/configData.php");
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
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <!-- <div class="card-header d-flex justify-content-between">
                                    <label class="mr-auto" style="line-height: 2.1rem">รายชื่อ</label>
                                    <a href="form-create.php" class="btn btn-primary boxx float-right"><i class="fa fa-plus"></i> เพิ่มสินค้า</a>
                                </div> -->
                                <div class="card-body" style="font-size: 1rem;">
                                    <div class="row d-flex justify-content-around">
                                        <button id="saveProductSale" class="btn btn-secondary boxx w-25" onclick="resetValueSale();"><i class="fa fa-trash"></i> ล้างหน้าจอ</button>
                                        <button id="saveProductSale" class="btn btn-primary boxx w-25" onclick="saveProductSale(1);"><i class="fa fa-save"></i> บันทึกการขาย</button>
                                    </div>

                                    <div class="row align-items-end">
                                        <div class="col-4 col-md-2 form-group position-relative">
                                            <input type="hidden" id="customerCode">
                                            <label for="customerInput" class="form-label">รหัสลูกค้า</label>
                                            <div class="d-flex flex-row justify-content-between">
                                                <div class="input-icon-wrapper">
                                                    <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                    <input type="text" class="form-control" id="customerInput" value="" placeholder="รหัส/ชื่อลูกค้า..." value="" onkeydown="checkEnter(event,this.value);" autocomplete="off" />
                                                    <div id="customerSuggestions" class="suggestions"></div>
                                                </div>
                                                <!-- <button id="btnViewCustomer" class="btn btn-primary boxx" style="width: 40px;" data-toggle="modal" data-target="#viewSustomerModal"><i class="fa fa-search"></i></button> -->
                                            </div>
                                        </div>
                                        <div class="col-8 col-md-4 form-group position-relative">
                                            <label for="customerName">ชื่อ</label>
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input type="text" id="customerName" class="form-control" value="" placeholder="..." autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-8 col-md-2 form-group position-relative">
                                            <label for="customerDate">วันที่</label>
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input type="date" id="orderDate" class="form-control" value="" placeholder="..." autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-end">
                                        <div class="col-4 col-md-2 form-group position-relative">
                                            <!-- ค้นหาสินค้า -->
                                            <input type="hidden" id="productCode">
                                            <label for="productInput" class="form-label">รหัสสินค้า</label>
                                            <div class="d-flex flex-row justify-content-between">
                                                <div class="input-icon-wrapper">
                                                    <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                    <input type="text" class="form-control" id="productInput" value="" placeholder="รหัสสินค้า..." value="" onkeydown="checkEnter(event,this.value);" autocomplete="off" />
                                                    <div id="productSuggestions" class="suggestions"></div>
                                                </div>
                                                <button id="btnViewProduct" class="btn btn-primary boxx" style="width: 40px;" data-toggle="modal" data-target="#viewProductModal"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-8 col-md-4 form-group position-relative">
                                            <label for="productName">สินค้า</label>
                                            <div class="input-icon-wrapper">
                                                <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                                <input type="text" id="productName" class="form-control" value="" placeholder="..." autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-1 form-group position-relative">
                                            <label for="productQty">จำนวน</label>
                                            <div class="input-wrapper">
                                                <!-- <i class="fa fa-keyboard input-icon" aria-hidden="true"></i> -->
                                                <input type="text" id="productQty" class="form-control text-center" value="1" placeholder="0" autocomplete="off" onkeypress="return isNumber(event);" onkeyup="computePrice();" onchange="computePrice();">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-1 form-group position-relative">
                                            <label for="productPrice">ราคา/หน่วย</label>
                                            <div class="input-wrapper">
                                                <!-- <i class="fa fa-keyboard input-icon" aria-hidden="true"></i> -->
                                                <input type="text" id="productPrice" class="form-control text-center" value="0" placeholder="0" autocomplete="off" onkeypress="return isNumber(event);" onkeyup="computePrice();" onchange="computePrice();">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-1 form-group position-relative">
                                            <label for="productTotal">ราคา</label>
                                            <div class="input-wrapper">
                                                <!-- <i class="fa fa-keyboard input-icon" aria-hidden="true"></i> -->
                                                <input type="text" readonly id="productTotal" class="form-control text-center" style="background-color: #fff;" value="0" placeholder="0" autocomplete="off" onkeypress="return isNumber(event);" onkeyup="computePrice();">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-1 form-group position-relative">
                                            <label for="productInv">ราคาทุน</label>
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
                                                        <th width="15%">จำนวน</th>
                                                        <th width="20%">ราคาต่อหน่วย</th>
                                                        <th width="20%">รวม</th>
                                                        <th width="5%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="repairItemsBody">
                                                    <!-- Repair items will be added here -->
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5">
                                                            <div class="row">
                                                                <div class="col-6 col-md-3 form-group position-relative">
                                                                    <label for="vatProductSale" class="col-form-label" style="padding:0px 0px;">ภาษี</label>
                                                                    <div class="input-icon-wrapper">
                                                                        <input class="toggle-event" id="vatProductSale" data-id="" type="checkbox" name="vatProductSale" data-toggle="toggle" data-off="ไม่มี Vat" data-on="&nbsp;&nbsp; มี Vat &nbsp;&nbsp;" data-onstyle="warning" data-style="ios">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6 col-md-3 form-group position-relative">
                                                                    <label for="typeSale" class="col-form-label" style="padding:0px 0px;">ประเภทการชำระ</label>
                                                                    <div>
                                                                        <input class="toggle-event" id="typeSale" data-id="" type="checkbox" name="typeSale" checked data-toggle="toggle" data-off="ค้างชำระ" data-on="ชำระเงินสด" data-onstyle="success" data-style="ios">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6 col-md-3 form-group position-relative">
                                                                    <label for="repairTotal">ยอดรวมสุทธิ</label>
                                                                    <div class="font-weight-bold text-right"
                                                                        id="repairTotal">
                                                                        0.00
                                                                    </div>
                                                                </div>
                                                                <div class="col-6 col-md-3 form-group position-relative">
                                                                    <label for="partsTotal">ค่าอะไหล่รวม</label>
                                                                    <div class="font-weight-bold text-right"
                                                                        id="partsTotal">
                                                                        0.00
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="row d-flex justify-content-around">
                                                                <button id="saveProductSale" class="btn btn-secondary boxx w-25" onclick="resetValueSale();"><i class="fa fa-trash"></i> ล้างหน้าจอ</button>
                                                                <button id="saveProductSale" class="btn btn-primary boxx w-25" onclick="saveProductSale(1);"><i class="fa fa-save"></i> บันทึกการขาย</button>
                                                            </div> -->
                                                        </td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <td
                                                            colspan="3"
                                                            class="text-right font-weight-bold">
                                                            ค่าอะไหล่รวม
                                                        </td>
                                                        <td
                                                            class="font-weight-bold text-right"
                                                            id="partsTotal">
                                                            0.00
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            colspan="3"
                                                            class="text-right font-weight-bold">
                                                            Vat
                                                        </td>
                                                        <td
                                                            class="font-weight-bold text-right"
                                                            id="vatCost">
                                                            0.00
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr class="table-active">
                                                        <td
                                                            colspan="3"
                                                            class="text-right font-weight-bold">
                                                            รวมทั้งสิ้น
                                                        </td>
                                                        <td
                                                            class="font-weight-bold text-right"
                                                            id="repairTotal">
                                                            0.00
                                                        </td>
                                                        <td></td>
                                                    </tr> -->
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
                                        <div class="col-4">
                                            <label for="vatProductSale" class="col-form-label" style="padding:0px 0px;">ภาษี</label>
                                            <input class="toggle-event" id="vatProductSale" data-id="" type="checkbox" name="vatProductSale" data-toggle="toggle" data-off="ไม่มี Vat" data-on="&nbsp;&nbsp; มี Vat &nbsp;&nbsp;" data-onstyle="warning" data-style="ios">
                                        </div>
                                        <div class="col-4">
                                            <input class="toggle-event" id="typeSale" data-id="" type="checkbox" name="typeSale" checked data-toggle="toggle" data-off="ค้างชำระ" data-on="ชำระเงินสด" data-onstyle="success" data-style="ios">
                                        </div>
                                        <div class="col-4" style="display: flex;flex-wrap: wrap;">
                                            <button id="saveProductSale" class="btn btn-primary boxx" onclick="saveProductSale(1);"><i class="fa fa-save"></i> บันทึกการขาย</button>
                                        </div>
                                    </div> -->

                                    <table id="dataTable" class="table table-bordered" width="100%">

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="viewProductModal" style="overflow-x: hidden;overflow-y: auto;" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="width:auto;max-width:700px;">>
                <div class="modal-content" style="height:80vh;">
                    <div class="modal-header bg-warning">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                                <label for="Product_NameModal" class="form-label">รหัส/ชื่อสินค้า</label>
                                <div class="input-icon-wrapper" style="width:80%;">
                                    <i class="fa fa-keyboard input-icon" aria-hidden="true"></i>
                                    <input type="text" class="form-control" id="Product_NameModal" value="" onkeyup="dataFilterProductNameModal();" placeholder="รหัสสินค้า..." value="" autocomplete="off" />
                                    <div id="productSuggestions" class="suggestions"></div>
                                </div>
                            </div>
                            </ฝdiv>
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
    <script type="text/javascript">
        let products = [];
        let customers = [];
        let typeNames = [];
        let groupNames = [];

        $('#vatProductSale').bootstrapToggle();
        $('#vatProductSale').off('change');

        $('#typeSale').bootstrapToggle();
        $('#typeSale').off('change');

        // $('.toggle-event').bootstrapToggle();
        // $('.toggle-event').off('change');

        async function genOrderId(table) {
            let orderId = await fetchData(table);
            alert(orderId);

        }



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

        async function saveProductSale() {
            // alert($('#typeSale')[0].checked ? 1 : 0);
            // Get repair items

            let orderId = await fetchData("genOrderId.php");
            alert(orderId);
            const repairItems = [];
            let partsTotal = 0;

            $("#repairItemsBody tr").each(function() {
                const partId = $(this).data("part-id");
                // const partName = $(this).find("td:eq(0)").text();
                const partName = $(this).find(".item-partName").val();
                const quantity = parseFloat($(this).find(".item-quantity").val()) || 0;
                const price = parseFloat($(this).find(".item-price").val()) || 0;
                const total = quantity * price;

                repairItems.push({
                    id: partId,
                    name: partName,
                    price: price,
                    quantity: quantity,
                    total: total,
                });

                partsTotal += total;
            });
            console.table(repairItems);
            alert($("#orderDate").val());
            resetValueSale();
            // alert("บันทึกการซ่อมเรียบร้อยแล้ว");
        }

        function _setupAutocomplete(
            inputId,
            suggestionsId,
            dataList,
            codeId,
            arrayShowValue,
            arrayFindValue,
            arraySetValue = null,
            callbackFunction = null
        ) {
            const input = document.getElementById(inputId);
            const suggestionsBox = document.getElementById(suggestionsId);
            // if (arraySetValue.length) {

            // }
            // const hiddenInput = document.getElementById(hiddenId);
            // const detailsBox = document.getElementById(detailsId);
            let currentFocus = -1;

            input.addEventListener("input", function() {
                const value = this.value.toLowerCase();
                suggestionsBox.innerHTML = "";
                currentFocus = -1;
                if (callbackFunction) {
                    callbackFunction(null);
                }

                if (!value || value.length < 1) return;

                let matches = dataList;

                arrayFindValue.forEach((findItem) => {
                    matches = dataList.filter((item) =>
                        item[findItem].toLowerCase().includes(value)
                    );
                });

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
                        suggestionsBox.innerHTML = "";
                    });
                    suggestionsBox.appendChild(div);
                });
            });

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
                    suggestionsBox.innerHTML = "";
                    suggestionsBox.classList.remove("suggestions-active");
                }
            });
        }

        $(document).ready(async function() {
            loaderScreen("show");
            await openDB();
            loadAndSetData("products");
            loadAndSetData("customers");
            loadAndSetData("groupnames");
            loadAndSetData("typenames");
            // loadAndSetData("suppliers");
            setupRepairEventHandlers();
            resetValueSale();
            loaderScreen("hide");
        });

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
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
            // if (item) {
            //     setFocusInput("#productPrice");
            // }
        }

        // callback function
        const setValueProductSale = (item) => {
            $("#productName").val(item?.name ?? "");
            $("#productPrice").val(item?.price1 ?? 0);
            $("#productInv").val(item?.price0 ?? "");
            if (item) {
                setFocusInput("#productPrice");
            }
        }

        function setFocusInput(element) {
            $(element).select();
            $(element).focus();
        }


        function _setValueProductSale(item) {
            $("#productName").val(item.name);
            $("#productPrice").val(item.price1);
            $("#productInv").val(item.price);
            // setFocusInput("#productPrice");
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
            $("#customerInput").val("");
            $("#customerName").val("");
            $("#orderDate").val(new Date().toISOString().slice(0, 10));
            $("#repairTotal").text(
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
            $("#repairTotal").text(
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

            // $("#customerDate").val("");

            resetValueProductSale();
            $("#repairItemsBody").html("");
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
                    "filterGroup", "filterGroupSuggestions", groupNames, "groupname", ["groupname"], ["groupname"], null, dataFilterProductModal);
            } else if (storeName == "typenames") {
                typeNames = dataStore;
                setupAutocomplete(
                    "filterType", "filterTypeSuggestions", typeNames, "typename", ["typename"], ["typename"], null, dataFilterProductModal);
            } else if (storeName == "suppliers") {
                suppliers = dataStore;
                setupAutocomplete(
                    "supplierName", "supplierNameSuggestions", suppliers, "name", ["name"], ["supplierId", "name"]);
            } else if (storeName == "customers") {
                customers = dataStore;
                setupAutocomplete(
                    "customerInput", "customerSuggestions", customers, "customerId", ["customerId", "name"], ["customerId", "name"], null, setValueCustomerSale);
            }
        }

        function dataFilterProductNameModal() {
            const input = document.getElementById('Product_NameModal');
            const datalist = document.getElementById('showProductTable');
            const filter = input.value;
            datalist.innerHTML = ''; // Clear existing options
            if (filter == "" || filter.length < 3) return;

            let arrFilter = filter.split(" ");

            // let tmpProducts = allProduct;
            let tmpProducts = products;
            /*
            arrFilter.forEach(filter => {
                tmpProducts = tmpProducts.filter(option => option.name.toLowerCase().includes(filter.toLowerCase()));
            });
            
            arrFilter.forEach(filter => {
                tmpProducts = tmpProducts.filter(option => option.productId.toLowerCase().includes(filter.toLowerCase()));
            });
            */

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
            // if (filter == "" || filter.length < 3) return;
            if ((filterType == "" || filterType.length < 3) && (filterGroup == "" || filterGroup.length < 3)) return;
            // let arrFilter = filter.split(" ");

            let tmpProducts = products;

            // if (filterType !== "" || filterType.length >= 3) {
            //     tmpProducts = tmpProducts.filter(option => option.typename == filterType);
            // }
            // if (filterGroup !== "" || filterGroup.length >= 3) {
            //     tmpProducts = tmpProducts.filter(option => option.groupname == filterGroup);
            // }
            tmpProducts = tmpProducts.filter(option => option.typename.includes(filterType));
            tmpProducts = tmpProducts.filter(option => option.groupname.includes(filterGroup));
            // if (filterType !== "" || filterType.length >= 3) {
            //     tmpProducts = tmpProducts.filter(option => option.typename == filterType);
            // }
            // if (filterGroup !== "" || filterGroup.length >= 3) {
            //     tmpProducts = tmpProducts.filter(option => option.groupname == filterGroup);
            // }

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

                // $("#rowProductSale").removeClass('disabled');
                // alert(JSON.stringify(userCar));
            } else {
                $("#btnAdd").prop('disabled', true);
                $("#productName").val("");
                $("#productPrice").val(0);
                // $("#rowProductSale").addClass('disabled');
            }

            // alert(element)
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
                if (focusedElement == this) return; //already focused, return so user can now place cursor at specific point in input.
                focusedElement = this;
                setTimeout(function() {
                    focusedElement.select();
                }, 100); //select all text in any field on focus for easy re-entry. Delay sightly to allow focus to "stick" before selecting.
            });
        });
    </script>
</body>

</html>