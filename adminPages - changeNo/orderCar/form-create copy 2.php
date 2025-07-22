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
    <title>เพิ่มการขาย | <?php echo $shopName; ?></title>

    <!-- Favicons -->
    <?php include_once('../../includes/pagesFavicons.php'); ?>

    <!-- stylesheet -->
    <?php include_once('../../includes/pagesStylesheet.php'); ?>

    <!-- Datatables -->
    <?php include_once('../../includes/pagesDatatableStylesheet.php'); ?>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="css/table.css?<?php echo time(); ?>" rel="stylesheet">

    <style>
        /* input */
        .inputStyle {
            /* background-image: url('../../assets/img/search22.png');
            background-position: 10px 12px;
            background-repeat: no-repeat; */
            width: 100%;
            /* padding: 15px 20px; */
            padding: 0.375rem 0.75rem;
            padding: 8px 20px 8px 20px;
            padding: 8px 20px;
            /* padding: 12px 20px 12px 40px; */
            box-sizing: border-box;
            /* color: var(--dark-active-list); */
            /* border: 2px solid var(--dark-border); */
            border-radius: 15px;
            box-sizing: border-box;
            /* background: var(--dark-input); */
        }

        .inputStyleFind {
            width: 85%;
        }


        .inputStyleIcon {
            background-image: url('../../assets/img/search22.png');
            background-position: 10px 8px;
            background-repeat: no-repeat;
            padding: 8px 20px 8px 40px;
        }

        .cursorHand {
            cursor: pointer;
        }

        .dark-theme {
            background-color: #212121;
        }

        .custom-control-input {
            transform: scale(2.0);
        }

        .disabled {
            pointer-events: none;
            opacity: 0.4;
        }

        fieldset {
            border: 1px solid blue;
            width: 360px;
            border-radius: 5px;
        }

        legend,
        label {
            color: blue;
            font-size: 24px;
            font-family: sans-serif;
        }

        /* input {
            font-size: 18px;
            padding: 5px;
            height: 35px;
            width: 350px;
            border: 1px solid blue;
            outline: none;
            border-radius: 5px;
            color: blue;
        } */

        datalist {
            position: absolute;
            background-color: white;
            border: 1px solid blue;
            border-radius: 0 0 5px 5px;
            border-top: none;
            font-family: sans-serif;
            width: 350px;
            padding: 5px;
            max-height: 10rem;
            overflow-y: auto
        }

        option {
            background-color: white;
            padding: 4px;
            color: blue;
            margin-bottom: 1px;
            font-size: 18px;
            cursor: pointer;
        }

        option:hover,
        .active {
            background-color: lightblue;
        }

        /* .toggle .toggle-event .toggle-group {
            font-size: 1rem !important;
            height: auto !important;
        } */

        .tableFixHead {
            overflow: auto;
            height: 400px;
            width: 95%
        }

        .tableFixHead thead th {
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .tableFixHead thead {
            background-color: lightblue;
        }

        /* Just common table stuff. Really. */
        table {
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px 16px;
        }

        th {
            background: lightblue;
        }

        /* th     { background:#eee; } */


        ​

        /*the container must be positioned relative:*/
        .autocomplete {
            position: relative;
            display: inline-block;
        }

        ​ .autocomplete input {
            border: 1px solid transparent;
            background-color: #f1f1f1;
            padding: 10px;
            font-size: 16px;
        }

        ​ .autocomplete input[type=text] {
            background-color: #f1f1f1;
            width: 100%;
        }

        ​ .autocomplete input[type=submit] {
            background-color: DodgerBlue;
            color: #fff;
            cursor: pointer;
        }

        ​ .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
        }

        ​ .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        ​

        /*when hovering an item:*/
        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

        ​

        /*when navigating through the items using the arrow keys:*/
        .autocomplete-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 5px 12px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border: none !important;
            position: relative;
            width: 1em;
            height: 1em;
            display: block;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow::after {
            content: "\f002";
            /* Unicode ของไอคอนแว่นขยาย */
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            top: 80%;
            left: 0%;
            transform: translate(-50%, -50%);
            font-size: 0.9em;
            color: gray;
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
                            <div class="m-0 text-dark">ขายสินค้า</div>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">ข้อมูลการขาย</li>
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
                                    <div class="mr-auto my-font-size" style="line-height: 2.1rem">รายการขาย</div>
                                    <!-- <div class="button btn btn-warning btn-sm" onclick="initDataFromDB();">getDatabase</div> -->
                                    <a href="index.php" class="button btn btn-warning btn-sm">กลับหน้าหลัก</a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6" id="rowUserCar">
                                            <input type="hidden" class="form-control" id="userCarID">
                                            <input type="hidden" class="form-control" id="userCarName">
                                            <label for="searchCarID">ทะเบียนรถ</label>
                                            <input class="inputStyle inputStyleIcon cursorHand" type="text" id="searchCarID" list="optionCarID" onkeyup="dataFilterCarID();" onchange="setDataCarID(this.value);" autocomplete="off" placeholder="ทะเบียนรถ/ชื่อลูกค้า">
                                            <datalist id="optionCarID" role="listbox">
                                            </datalist>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="CarID_Name">ชื่อลูกค้า</label>
                                            <input class="inputStyle" type="text" id="CarID_Name" placeholder="ชื่อลูกค้า" readonly>
                                        </div>
                                    </div>
                                    <!--
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="hidden" class="form-control" id="customerID">
                                            <input type="hidden" class="form-control" id="customerName">
                                            <div class="form-group">
                                                <label for="listCustomerName" class="col-form-label">รายชื่อ</label>
                                                <div id="showListCustomer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    -->
                                    <div class="row">
                                        <input type="hidden" class="form-control" id="txtProductSaleID">
                                        <input type="hidden" class="form-control" id="txtProductSaleName">
                                    </div>
                                    <!--
                                    <div class="row disabled" id="rowProductSale">
                                    -->
                                    <div class="row" id="rowProductSale">
                                        <div class="col-12 col-md-6">
                                            <div><label for="searchProductID">รหัสสินค้า</label></div>
                                            <input class="inputStyle inputStyleFind inputStyleIcon cursorHand" type="text" id="searchProductID" list="optionProductID" onkeyup="dataFilterProductID(event);" onchange="setDataProductID(this.value);" autocomplete="off" placeholder="รหัสสินค้า">
                                            <button id="btnViewProduct" class="button btn btn-primary" style="width: 50px; margin-left: auto; margin-right: 0;" data-toggle="modal" data-target="#viewProductModal"><i class="fa fa-search"></i></button>
                                            <datalist id="optionProductID">
                                            </datalist>
                                        </div>
                                        <!--
                                        <input class="inputStyle inputStyleFind inputStyleIcon cursorHand" type="text" id="searchProductID" list="optionProductID" onkeyup="dataFilterProductID(event);" onchange="setDataProductID(this.value);" autocomplete="off" placeholder="รหัสสินค้า">
                                        <div class="col-12 col-md-6">
                                            <label for="Product_Name">ชื่อสินค้า</label>
                                            <input class="inputStyle inputStyleIcon cursorHand" type="text" id="Product_Name" list="optionProductName" onkeyup="dataFilterProductName();" onchange="setDataProductName(this.value);" autocomplete="off" placeholder="ชื่อสินค้า">
                                            <datalist id="optionProductName">
                                            </datalist>
                                        </div>
                                        -->
                                        <div class="col-12 col-md-6">
                                            <div><label for="Product_Name">ชื่อสินค้า</label></div>
                                            <input class="inputStyle cursorHand" type="text" id="Product_Name" autocomplete="off" placeholder="ชื่อสินค้า">
                                            <datalist id="optionProductName">
                                            </datalist>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-4 col-md-3">
                                                    <label for="productQty" class="col-form-label">จำนวน</label>
                                                    <input type="text" class="inputStyle text-right" id="productQty" onclick="selectElement(this);" onchange="computePrice();" value="1" onkeyup="computePrice();" onkeypress="return isNumber(event);">
                                                </div>
                                                <div class="col-4 col-md-3">
                                                    <label for="productPrice" class="col-form-label">ราคา/หน่วย</label>
                                                    <input type="text" class="inputStyle text-right" id="productPrice" onclick="selectElement(this);" value="0" onkeyup="computePrice();" onkeypress="return isNumber(event);" onchange="computePrice();">
                                                </div>
                                                <div class="col-4 col-md-3">
                                                    <label for="productPriceTotal" class="col-form-label">ราคา</label>
                                                    <input type="number" class="inputStyle text-right" id="productPriceTotal" value="0" readonly>
                                                </div>
                                                <div class="col-12 col-md-3" style="display: flex;flex-wrap: wrap;">
                                                    <button id="btnAdd" disabled class="button btn btn-success" style="margin-left: auto; margin-right: 0;margin-top: auto; margin-bottom: 0;" onclick="addProductSale();"><i class="fa fa-plus"></i> เพิ่ม</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12" style="padding-top:16px;">
                                            <div class="row">
                                                <div class="col-5">
                                                    <label for="vatProductSale" class="col-form-label" style="padding:0px 0px;">ภาษี</label>
                                                    <input class="toggle" id="vatProductSale" data-id="" type="checkbox" name="vatProductSale" checked data-toggle="toggle" data-off="ไม่มี Vat" data-on="&nbsp;&nbsp; มี Vat &nbsp;&nbsp;" data-onstyle="warning" data-style="ios">
                                                </div>
                                                <div class="col-7" style="display: flex;flex-wrap: wrap;">
                                                    <div id="saveProductSale" class="button btn btn-primary disabled" style="margin-left: auto; margin-right: 0;" onclick="saveProductSale(1);">บันทึกการขาย</div>
                                                    <!-- <button id="saveProductSale" class="btn btn-primary" style="margin-left: auto; margin-right: 0;" onclick="saveProductSale();">บันทึกการขาย</button> -->
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-top:10px;">
                                <div class="col-12">
                                    <div id="showTableProductSale"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewProductModal" style="overflow-x: hidden;overflow-y: auto;" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content" style="height:80vh;">
                <div class="modal-header bg-warning">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between align-items-center" style="width:100%;">
                            <div><label>ชื่อสินค้า</label></div>
                            <div style="width:80%;"><input class="inputStyle inputStyleIcon cursorHand" type="text" id="Product_NameModal" onkeyup="dataFilterProductNameModal();" autocomplete="off" placeholder="ชื่อสินค้า"></div>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center" style="width:100%;">
                            <div><label>ประเภท</label></div>
                            <div style="width:80%;"><input class="inputStyle inputStyleIcon cursorHand" type="text" id="Product_TypeModal" onkeyup="dataFilterProductNameModal();" autocomplete="off" placeholder="ประเภท"></div>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center" style="width:100%;">
                            <div><label>ยี่ห้อ/รุ่น</label></div>
                            <div style="width:80%;"><input class="inputStyle inputStyleIcon cursorHand" type="text" id="Product_GroupModal" onkeyup="dataFilterProductNameModal();" autocomplete="off" placeholder="ยี่ห้อ/รุ่น"></div>
                        </div>

                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <div><label>ประเภท</label></div>
                            <div style="width:80%;">
                                <select id="filterType" class="form-select" style="min-width: 180px; width: 100%">
                                    <option value="">ทั้งหมด</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <div><label>ยี่ห้อ/รุ่น</label></div>
                            <div style="width:80%;">
                                <select id="filterGroup" class="form-select" style="min-width: 180px; width: 100%">
                                    <option value="">ทั้งหมด</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-top: 0px;">
                    <form>
                        <!-- <div class="form-group">
                                <input type="hidden" class="form-control" id="txtNo">
                            </div> -->
                        <div class="form-group">
                            <!--
                                <div class="col-12 mb-2">
                                            <label for="Product_Name">ชื่อสินค้า</label>
                                            <input class="inputStyle inputStyleIcon cursorHand" type="text" id="Product_NameModal" onkeyup="dataFilterProductNameModal();"  autocomplete="off" placeholder="ชื่อสินค้า">
                                </div>
                                -->

                            <div class="col-12 d-flex justify-content-center">
                                <!--
                                    <table class="table table-striped tableFixHead" style="height:600px;">
                                    -->
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

    <!-- OPTIONAL DataTable SCRIPTS -->
    <?php include_once('../../includes/pagesDatatableScript.php') ?>

    <script src="https://cdn.jsdelivr.net/npm/idb@3.0.2/build/idb.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- <script src="common.js?<?php echo time(); ?>"></script> -->
    <script src="startInitData.js?<?php echo time(); ?>"></script>

    <script type="text/javascript">
        var arrProductSale = [];
        var objProductSale = {};
        var amountProduct = 0;
        var vat = 0;
        var totalProduct = 0;

        var indexLabel = 0;
        var productSale = [];
        var allUserCar = [];
        var allProduct = [];
        var allTypeName = [];
        var allGroupName = [];

        var eventProcess = true;

        function isNumberPrice(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        function isNumberQty(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        function computePrice() {
            //alert(7)
            let total = Number($("#productQty").val()) * Number($("#productPrice").val());
            $("#productPriceTotal").val(total);
        }

        function _checkInputNumber(e) {
            if (!(e.key >= 0 && e.key <= 9) || (e.key !== "Backspace"))
                return;
            computePrice();
        }

        async function initDataFromDB() {

            loaderScreen("show");
            try {

                await startCheckDataExpired();
                allProduct = await readDataFromDB("product");
                allUserCar = await readDataFromDB("usercar");
                allTypeName = await readDataFromDB("typename");
                allGroupName = await readDataFromDB("groupname");
            } catch (err) {
                alert(err);
            }

            loaderScreen("hide");
        }

        function renderGroupFilterOptions() {
            const filter = document.getElementById('filterGroup');
            allGroupName.forEach(ele => {
                const option = document.createElement('option');
                option.value = ele.groupname;
                option.textContent = ele.groupname;
                filter.appendChild(option);
            });

            // const province = document.getElementById('province');
            // provinces.forEach(p => {
            //     const option = document.createElement('option');
            //     option.value = p;
            //     option.textContent = p;
            //     province.appendChild(option);
            // });
        }

        function renderTypeFilterOptions() {
            const filter = document.getElementById('filterType');
            allTypeName.forEach(ele => {
                const option = document.createElement('option');
                option.value = ele.typename;
                option.textContent = ele.typename;
                filter.appendChild(option);
            });

            // const province = document.getElementById('province');
            // provinces.forEach(p => {
            //     const option = document.createElement('option');
            //     option.value = p;
            //     option.textContent = p;
            //     province.appendChild(option);
            // });
        }



        function resetOrder() {
            $("#userCarID").val("");
            $("#userCarName").val("");
            $("#searchCarID").val("");
            $("#CarID_Name").val("");
            $("#searchCarID").focus();
            // document.getElementById('optionCarID').innerHTML = '';
            $("#optionCarID").html("");

            $("#rowUserCar").removeClass('disabled');
            $("#rowProductSale").addClass('disabled');
            $("#saveProductSale").addClass('disabled');
            arrProductSale = [];
            showTableProductSale(arrProductSale);
            $("#searchCarID").focus();

            // $("#searchProductID").val("");

        }

        function setDataCarID(element) {
            let userCar = allUserCar.filter(item => item.idcar == element);
            if (userCar.length) {
                $("#CarID_Name").val(userCar[0].name);

                $("#userCarID").val(userCar[0].idcar);
                $("#userCarName").val(userCar[0].name);

                $("#rowProductSale").removeClass('disabled');
                // alert(JSON.stringify(userCar));
            } else {
                $("#CarID_Name").val("");
                $("#rowProductSale").addClass('disabled');
            }

            // alert(element)
        }

        function setDataProductID(productid) {
            let Product = allProduct.filter(item => item.productid == productid);
            if (Product.length) {
                $("#txtProductSaleID").val(Product[0].productid);
                $("#txtProductSaleName").val(Product[0].name);

                $("#Product_Name").val(Product[0].name);
                $("#productPrice").val(Product[0].price1);

                $("#btnAdd").prop('disabled', false);
                computePrice();
                $("#productPrice").focus();
                $("#productPrice").select();

                // $("#rowProductSale").removeClass('disabled');
                // alert(JSON.stringify(userCar));
            } else {
                $("#btnAdd").prop('disabled', true);
                $("#Product_Name").val("");
                $("#productPrice").val(0);
                // $("#rowProductSale").addClass('disabled');
            }

            // alert(element)
        }

        function setDataProductEdit(element) {


            $("#txtProductSaleID").val(element.productID);
            $("#txtProductSaleName").val(element.name);

            $("#searchProductID").val(element.productID);
            $("#Product_Name").val(element.name);
            $("#productPrice").val(element.price);
            $("#productQty").val(element.qty);
            $("#btnAdd").prop('disabled', false);
            computePrice();
            $("#productPrice").focus();
            $("#productPrice").select();


        }

        function setDataProductName(productName) {
            let Product = allProduct.filter(item => item.name == productName);
            if (Product.length) {
                $("#txtProductSaleID").val(Product[0].productid);
                $("#txtProductSaleName").val(Product[0].name);

                $("#searchProductID").val(Product[0].productid);
                $("#productPrice").val(Product[0].price1);
                $("#btnAdd").prop('disabled', false);
                computePrice();
                $("#productPrice").focus();
                $("#productPrice").select();

                // $("#rowProductSale").removeClass('disabled');
                // alert(JSON.stringify(userCar));
            } else {
                $("#btnAdd").prop('disabled', true);
                $("#searchProductID").val("");
                $("#productPrice").val(0);
                // $("#rowProductSale").addClass('disabled');
            }

            // alert(element)
        }

        function dataFilterCarID() {
            // $("#CarID_Name").val("");
            // $("#rowProductSale").addClass('disabled');

            const input = document.getElementById('searchCarID');
            const datalist = document.getElementById('optionCarID');
            const filter = input.value;
            // allUserCar = ['Apple', 'Banana', 'Cherry', 'Date', 'Elderberry'];
            datalist.innerHTML = ''; // Clear existing options
            if (filter == "" || filter.length < 3) return;

            let tmpCar = allUserCar.filter(option => option.idcar.includes(filter) || option.name.includes(filter)) // Filter options
            tmpCar.forEach(option => {
                const newOption = document.createElement('option');
                newOption.value = option.idcar;
                newOption.innerText = option.name;
                datalist.appendChild(newOption);
            });
        }

        function checkEnter(event) {
            if (event.keyCode === 13) {
                // event.preventDefault(); // Ensure it is only this code that runs
                addProductSale();
                // alert("Enter was pressed was presses");
            }
        }

        function dataFilterProductID(event) {
            // $("#Product_Name").val("");
            $("#productPrice").val(0);
            $("#productPriceTotal").val(0);
            //event.preventDefault();

            const input = document.getElementById('searchProductID');
            const datalist = document.getElementById('optionProductID');
            const filter = input.value;

            datalist.innerHTML = ''; // Clear existing options
            if (filter == "" || filter.length < 3) return;

            let options = allProduct.filter(option => option.productid.includes(filter));
            options.forEach(option => {
                const newOption = document.createElement('option');
                newOption.value = option.productid;
                newOption.innerText = option.name;
                datalist.appendChild(newOption);
            });


            // createOptions(datalist, options);

            //datalist.innerHTML = createOptions(element, options);
            //eventProcess = false;
            //setTimeout(createOptions(datalist, options), 100);

            //createOptions(datalist, options);

            /*
            allProduct
                .filter(option => option.productid.includes(filter)) // Filter options
                .forEach(option => {
                    const newOption = document.createElement('option');
                    newOption.value = option.productid;
                    newOption.innerText = option.name;
                    datalist.appendChild(newOption);
                    if(!eventProcess) return;
                });
                */
        }

        function createOptions(element, options) {

            let html = "";
            for (i = 0; i < options.length; i++) {
                option = options[i];
                html += `<option value="${option.productid}">${option.name}</option>`;
            }
            element.innerHTML = html;
            //return html;
        }

        // function _createOptions(element, options) {
        //     eventProcess = true;
        //     for(i=0;i<options.length;i++) {
        //             option = options[i];
        //             const newOption = document.createElement('option');
        //             newOption.value = option.productid;
        //             newOption.innerText = option.name;
        //             element.appendChild(newOption);
        //             if(!eventProcess) break;
        //     }

        // }

        function dataFilterProductName() {
            // $("#Product_Name").val("");
            // $("#productPrice").val(0);

            const input = document.getElementById('Product_Name');
            const datalist = document.getElementById('optionProductName');
            const filter = input.value;
            // allUserCar = ['Apple', 'Banana', 'Cherry', 'Date', 'Elderberry'];
            datalist.innerHTML = ''; // Clear existing options
            if (filter == "" || filter.length < 3) return;

            let arrFilter = filter.split(" ");

            let tmpProducts = allProduct;
            arrFilter.forEach(filter => {
                tmpProducts = tmpProducts.filter(option => option.name.includes(filter));
            });

            tmpProducts.forEach(option => {
                const newOption = document.createElement('option');
                newOption.value = option.name;
                // newOption.innerText = option.name;
                datalist.appendChild(newOption);
            });
        }

        function dataFilterProductNameModal() {
            // $("#Product_Name").val("");
            // $("#productPrice").val(0);

            const input = document.getElementById('Product_NameModal');
            const datalist = document.getElementById('showProductTable');
            const filter = input.value;
            // allUserCar = ['Apple', 'Banana', 'Cherry', 'Date', 'Elderberry'];
            datalist.innerHTML = ''; // Clear existing options
            if (filter == "" || filter.length < 3) return;

            let arrFilter = filter.split(" ");

            let tmpProducts = allProduct;
            /*
            arrFilter.forEach(filter => {
                tmpProducts = tmpProducts.filter(option => option.name.toLowerCase().includes(filter.toLowerCase()));
            });
            
            arrFilter.forEach(filter => {
                tmpProducts = tmpProducts.filter(option => option.productid.toLowerCase().includes(filter.toLowerCase()));
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
                let onClick = `onclick="setProductOnSelected('${option.productid}');"`;
                let tr = `
                              <tr ${onClick}>
                                  <td>${option.name}</td>
                              </tr>
                             `;
                body += tr;
            });

            $("#showProductTable").html(body);

        }

        function dataFilterProductModal() {

            const datalist = document.getElementById('showProductTable');
            const inputType = document.getElementById('filterType');
            const filterType = inputType.value;
            const inputGroup = document.getElementById('filterGroup');
            const filterGroup = inputGroup.value;
            datalist.innerHTML = ''; // Clear existing options
            // if (filter == "" || filter.length < 3) return;
            if ((filterType == "" || filterType.length < 3) && (filterGroup == "" || filterGroup.length < 3)) return;
            // let arrFilter = filter.split(" ");

            let tmpProducts = allProduct;

            // arrFilter.forEach(filter => {
            //     tmpProducts = tmpProducts.filter(option => option.name.toLowerCase().includes(filter.toLowerCase()));
            // });
            if (filterType !== "" || filterType.length >= 3) {
                tmpProducts = tmpProducts.filter(option => option.typename==filterType);
            }
            if (filterGroup !== "" || filterGroup.length >= 3) {
                tmpProducts = tmpProducts.filter(option => option.groupname==filterGroup);
                // tmpProducts.filter(option => option.groupname.toLowerCase().includes(filterGroup.toLowerCase()));
            }

            tmpProducts = tmpProducts.sort((a, b) => {
                return a.name.localeCompare(b.name);
            });
            let body = "";
            tmpProducts.forEach(option => {
                let onClick = `onclick="setProductOnSelected('${option.productid}');"`;
                let tr = `
                              <tr ${onClick}>
                                  <td>${option.name}</td>
                              </tr>
                             `;
                body += tr;
            });

            $("#showProductTable").html(body);

        }

        function setProductOnSelected(productid) {
            //alert(productid);
            $('#viewProductModal').modal('hide');
            $("#searchProductID").val(productid);
            setDataProductID(productid);

            //setTimeout(elementFocus("productPrice"), 3000);
        }

        function elementFocus(element) {
            alert(1);
            //$(`#${element}`).focus();

            $("#productPrice").focus();
            $("#productPrice").select();
        }

        function editArrayProductSale(index) {
            //alert(index);
            //$("#searchProductID").val(productid);
            let element = arrProductSale[index];
            setDataProductEdit(element);
        }

        function checkValueUserCar() {
            if ($("#userCarID").val()) {
                return true;
            }
            return false;
        }

        function checkValueCustomer() {
            if ($("#customerID").val()) {
                return true;
            }
            return false;
        }

        function checkValueProducts() {
            if (!arrProductSale.length) {
                return false;
            }
            return true;
        }

        async function saveProductSale() {
            if (!checkValueUserCar()) {
                toastr.error('ยังไม่มีข้อมูลลูกค้า !!!.', {
                    timeOut: 2000,
                    closeOnHover: true
                });
                document.getElementById("searchCarID").click();
                return;
            }

            if (!checkValueProducts()) {
                toastr.error('ยังไม่มีข้อมูลสินค้า !!!.', {
                    timeOut: 2000,
                    closeOnHover: true
                });
                return;
            }

            vat = $("#vatProductSale")[0].checked;

            total = totalProduct.toFixed(2);

            message = `บันทึกการขาย?<br>รวมเงิน ${addCommas(totalProduct)} บาท`;

            amount = totalProduct;
            if (vat) {
                total = (totalProduct * 1.07).toFixed(2) * 1;
                vatTotal = (total - totalProduct).toFixed(2) * 1;
                message += `<br>ภาษี ${addCommas(vatTotal)} บาท<br>ยอดรวมทั้งหมด ${addCommas(total)} บาท`;
            }

            confirm = await sweetConfirmSave(message);
            if (!confirm) {
                return;
            }

            // loaderScreen("show");
            resetOrder();
            // document.getElementById("searchCarID").value = "";
            // document.getElementById("searchCarID").disabled = false;
            // loaderScreen("hide");
        }

        function addProductSale() {

            loaderScreen("show");
            if ($("#txtProductSaleID").val() != "") {
                // if (Number($("#productPrice").val()) == 0) {
                //     toastr.error('ยังไม่มีราคาสินค้า !!!', {
                //         timeOut: 2000,
                //         closeOnHover: true
                //     });
                //     loaderScreen("hide");
                //     $("#productPrice").click();
                //     return;
                // }
                if (Number($("#productQty").val()) == 0) {
                    toastr.error('ยังไม่มีจำนวนสินค้า !!!', {
                        timeOut: 2000,
                        closeOnHover: true
                    });
                    loaderScreen("hide");
                    $("#productQty").click();
                    return;
                }
                /*
                if (arrProductSale.find((element) => element.productID == $("#txtProductSaleID").val())) {
                    toastr.error('รายการสินค้านี้มีอยู่แล้ว!!!', {
                        timeOut: 5000,
                        closeOnHover: true
                    });
                    loaderScreen("hide");
                    return;
                }
                */

                let findIndex = arrProductSale.findIndex((element) => element.productID == $("#txtProductSaleID").val());

                if (findIndex == -1) {
                    arrProductSale.push({
                        productID: $("#txtProductSaleID").val(),
                        name: $("#Product_Name").val(),
                        price: $("#productPrice").val(),
                        qty: $("#productQty").val(),
                    });
                } else {
                    arrProductSale[findIndex] = {
                        productID: $("#txtProductSaleID").val(),
                        name: $("#Product_Name").val(),
                        price: $("#productPrice").val(),
                        qty: $("#productQty").val(),
                    }
                }

                $("#rowUserCar").addClass('disabled');
                $("#saveProductSale").removeClass('disabled');
                showTableProductSale(arrProductSale);
                clearObjProductSale();
                toastr.success('เพิ่มรายการเรียบร้อย.', {
                    timeOut: 2000,
                    closeOnHover: true
                });
                // document.getElementById('languages').innerHTML = ''; // Clear existing options
                $("#optionProductID").html("");
                $("#searchProductID").focus();
            } else {
                toastr.error('ยังไม่มีข้อมูลสินค้า !!!', {
                    timeOut: 2000,
                    closeOnHover: true
                });
            }
            loaderScreen("hide");
        }
        async function deleteArrayProductSale(id) {
            confirm = await sweetConfirm("คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?");
            if (confirm) {
                loaderScreen("show");
                for (index = 0; index < arrProductSale.length; index++) {
                    if (arrProductSale[index].productID == id) {
                        //alert(index);
                        arrProductSale = deleteArray(arrProductSale, index);
                        showTableProductSale(arrProductSale);
                        //sweetAlert('รายการของคุณถูกลบเรียบร้อย');
                        return;
                    }
                }
            }
        }

        async function _editArrayProductSale(id) {
            for (index = 0; index < arrProductSale.length; index++) {
                if (arrProductSale[index].productID == id) {
                    setProductSale(arrProductSale[index]);
                    // arrProductSale = deleteArray(arrProductSale, index);
                    // showTableProductSale(arrProductSale);
                }
            }
        }


        function selectElement(ele) {
            ele.select();
        }

        function deleteArray(arr, index) {
            try {
                if (index == 0) {
                    return arr.slice(1);
                } else if (index == arr.length - 1) {
                    return arr.slice(0, -1);
                } else {
                    halfBefore = arr.slice(0, index);
                    halfAfter = arr.slice(index + 1);
                    return halfBefore.concat(halfAfter);
                }
                return arr;
            } catch (ex) {
                alert(ex);
            }
        }

        function clearObjProductSale() {
            objProductSale = {};
            // $("#productID").val("");
            // $("#productName").val("");
            $("#searchProductID").val("");
            $("#Product_Name").val("");
            $("#btnAdd").prop('disabled', true);

            $("#txtProductSaleID").val("");
            $("#txtProductSaleName").val("");
            $("#productPrice").val("0");
            $("#productQty").val("1");
            $("#productPriceTotal").val("0");
            setHTMLListProductSale();
        }

        function setProductSaleOption() {
            $("#productID").val(objProductSale.productSale.id);
            $("#productName").val(objProductSale.productSale.name);
            // $("#productID").val(objProductSale.product.productID);
            // $("#productID").val(objProductSale.product.productID);
        }

        $(document).ready(function() {

        });

        let HTMLListProductSale = "";
        let HTMLListCustomer = "";

        function showTableProductSale(arrayProductSale) {

            myHTML = `<div id="table-scroll" class="table-scroll">
                        <div class="table-wrap">`;
            myHTML += `<table id="tableProductSale" class="main-table" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="fixed-side" scope="col">#</th>
                                <th class="fixed-side td-name" scope="col">รายการ</th>
                                <th scope="col">จำนวน</th>
                                <th scope="col">ราคา/หน่วย</th>
                                <th scope="col">ราคา</th>
                                <th scope="col">จัดการรายการ</th>
                            </tr>
                        </thead><tbody>`;
            count = 1;
            total = 0;
            arrayProductSale.forEach((element, index) => {
                ID = element.productID;
                total += element.price * element.qty;
                myHTML += `<tr><th class="fixed-side" scope="row">${count++}</th>`;
                myHTML += `<td class="fixed-side td-name string-clip">${element.name}</td><td class="text-right">${element.qty}</td><td class="text-right">${addCommas(element.price)}</td><td class="text-right">${addCommas(element.price*element.qty)}</td>`;
                myHTML += `<td style="vertical-align: middle;text-align:center;">
                            <button class="btn btn-warning" onclick="editArrayProductSale(${index});"><i class="far fa-edit"></i></button>
                            <button class="btn btn-danger" onclick="deleteArrayProductSale('${ID}');"><i class="far fa-trash-alt"></i></button>
                            </td></tr>`;
            });
            myHTML += `</body></table>`;
            myHTML += `</div></div>`;
            $("#showTableProductSale").html(myHTML);
            jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');
            $("#saveProductSale").text(`บันทึกการขาย ${arrayProductSale.length} รายการ ${addCommas(total)} บาท`);
            totalProduct = total;
            if (totalProduct == 0) {
                $("#saveProductSale").addClass('disabled');
            }
            loaderScreen("hide");
        }

        function selectRow(_table, element = null) {
            txtName = `#txt${_table}`;
            $(txtName).val(element);
        }

                $(document).ready(async function() {
            $("*").dblclick(function(e) {
                //e.preventDefault();
            });
            await initDataFromDB();
            showTableProductSale(arrProductSale);
            renderGroupFilterOptions();
            renderTypeFilterOptions();

            // $('#filterProvince').select2({
            //     // width: '200px'
            //     width: '100%'
            // });

            // $('#province').select2({
            //     dropdownParent: $('#memberModal'),
            //     placeholder: 'เลือกประเภท',
            //     allowClear: true,
            //     width: '100%'
            // });

            // $('#filterProvince').on('change', function() {
            //     currentPage = 1;
            //     renderTable();
            // });

            $('#filterGroup').select2({
                // width: '200px'
                width: '100%'
            });

            $('#filterGroup').on('change', function() {
                // currentPage = 1;
                // renderTable();
                dataFilterProductModal();
            });

            $('#filterType').select2({
                // width: '200px'
                width: '100%'
            });

            $('#filterType').on('change', function() {
                // currentPage = 1;
                dataFilterProductModal();
                // renderTable();
            });


            // loaderScreen("show");
            // await startCheckDataExpired();
            // allProduct = await readDataFromDB("product");
            // allUserCar = await readDataFromDB("usercar");
            // loaderScreen("hide");
            // // await list();
            // await tableProducts();

            // console.table(listProducts);

        });
    </script>
    <script>
    </script>
</body>

</html>