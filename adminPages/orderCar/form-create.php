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

        /* .toggle .toggle-event .toggle-group {
            font-size: 1rem !important;
            height: auto !important;
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
                                    <a href="index.php" class="button btn btn-warning btn-sm">กลับหน้าหลัก</a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label for="searchCarID">ทะเบียนรถ</label>
                                            <input class="inputStyle inputStyleIcon cursorHand" type="text" id="searchCarID" list="optionCarID" onkeyup="dataFilterCarID();" onchange="setDataCarID(this.value);" autocomplete="off" placeholder="ทะเบียนรถ">
                                            <datalist id="optionCarID">
                                            </datalist>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="CarID_Name">ชื่อลูกค้า</label>
                                            <input class="inputStyle" type="text" id="CarID_Name" placeholder="ชื่อลูกค้า" readonly>
                                        </div>
                                    </div>
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
                                    <div class="row">
                                        <input type="hidden" class="form-control" id="txtProductSaleID" onchange="setPriceCustomer();">
                                        <input type="hidden" class="form-control" id="txtProductSaleName">
                                    </div>
                                    <div class="row disabled" id="rowProductSale">
                                        <div class="col-12 col-md-6">
                                            <label for="searchProductID">รหัสสินค้า</label>
                                            <input class="inputStyle inputStyleIcon cursorHand" type="text" id="searchProductID" list="optionProductID" onkeyup="dataFilterProductID();" onchange="setDataProductID(this.value);" autocomplete="off" placeholder="รหัสสินค้า/ชื่อสินค้า">
                                            <datalist id="optionProductID">
                                            </datalist>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="Product_Name">ชื่อสินค้า</label>
                                            <input class="inputStyle" type="text" id="Product_Name" placeholder="ชื่อสินค้า">
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="productQty" class="col-form-label">จำนวน</label>
                                                    <input type="number" class="form-control text-right" id="productQty" onclick="selectElement(this);" value="1">
                                                </div>
                                                <div class="col-4">
                                                    <label for="productPrice" class="col-form-label">ราคา</label>
                                                    <input type="number" class="form-control text-right" id="productPrice" onclick="selectElement(this);" value="0" onkeypress="checkEnter(event);">
                                                </div>
                                                <div class="col-4" style="display: flex;flex-wrap: wrap;">
                                                    <!-- <label for="btnAdd" class="col-form-label">&nbsp;&nbsp;</label> -->
                                                    <button id="btnAdd" disabled class="button btn btn-success" style="margin-left: auto; margin-right: 0;margin-top: auto; margin-bottom: 0;" onclick="addProductSale();"><i class="fa fa-plus"></i> เพิ่มรายการ</button>
                                                    <!-- <div style="margin-left: auto; margin-right: 0;margin-top: auto; margin-bottom: 0;">
                                                        <button id="btnAdd" class="btn btn-success btn-2px" onclick="addProductSale();">เพิ่มรายการ</button>
                                                    </div> -->
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
                                                    <div id="saveProductSale" class="button btn btn-primary" style="margin-left: auto; margin-right: 0;" onclick="saveProductSale(1);">บันทึกการขาย</div>
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

        // const input = document.getElementById('search');
        // const datalist = document.getElementById('options');
        // const allOptions = ['Apple', 'Banana', 'Cherry', 'Date', 'Elderberry'];

        // input.addEventListener('input', () => {
        //     const filter = input.value.toLowerCase();
        //     datalist.innerHTML = ''; // Clear existing options

        //     allOptions
        //         .filter(option => option.toLowerCase().includes(filter)) // Filter options
        //         .forEach(option => {
        //             const newOption = document.createElement('option');
        //             newOption.value = option;
        //             datalist.appendChild(newOption);
        //         });
        // });


        $(document).ready(async function() {
            $("*").dblclick(function(e) {
                //e.preventDefault();
            });
            loaderScreen("show");
            await startCheckDataExpired();
            allProduct = await readDataFromDB("product");
            allUserCar = await readDataFromDB("usercar");
            loaderScreen("hide");
            // // await list();
            // await tableProducts();

            // console.table(listProducts);

        });

        function setDataCarID(element) {
            let userCar = allUserCar.filter(item => item.idcar == element);
            if (userCar.length) {
                $("#CarID_Name").val(userCar[0].name);
                $("#rowProductSale").removeClass('disabled');
                // alert(JSON.stringify(userCar));
            } else {
                $("#CarID_Name").val("");
                $("#rowProductSale").addClass('disabled');
            }

            // alert(element)
        }

        function setDataProductID(element) {
            let Product = allProduct.filter(item => item.productid == element);
            if (Product.length) {
                $("#txtProductSaleID").val(Product[0].productid);
                $("#txtProductSaleName").val(Product[0].name);

                $("#Product_Name").val(Product[0].name);
                $("#productPrice").val(Product[0].price1);
                $("#btnAdd").prop('disabled', false);
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
        /*
                function dataFilterCarIDDropdown() {
                    const input = document.getElementById('language');
                    const datalist = document.getElementById('languages');
                    const filter = input.value.toLowerCase();
                    // allUserCar = ['Apple', 'Banana', 'Cherry', 'Date', 'Elderberry'];
                    datalist.innerHTML = ''; // Clear existing options
                    if (filter == "") return;

                    let tmpCar = allUserCar.filter(option => option.idcar.toLowerCase().includes(filter)) // Filter options

                    allUserCar
                        .filter(option => option.idcar.toLowerCase().includes(filter)) // Filter options
                        .forEach(option => {
                            const newOption = document.createElement('span');
                            newOption.innerText = option.idcar;
                            newOption.addEventListener("click", (e) => {
                                let val = e.target.innerHTML;
                                // Update value of search input to chosen span
                                input.value = val;
                            });
                            datalist.appendChild(newOption);
                        });
                }
        */
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

            // allUserCar
            //     .filter(option => option.idcar.includes(filter) || option.name.includes(filter)) // Filter options
            //     .forEach(option => {
            //         const newOption = document.createElement('option');
            //         newOption.value = option.idcar;
            //         datalist.appendChild(newOption);
            //     });
        }

        function checkEnter(event) {
            if (event.keyCode === 13) {
                event.preventDefault(); // Ensure it is only this code that runs
                addProductSale();
                // alert("Enter was pressed was presses");
            }
        }

        function dataFilterProductID() {
            // $("#Product_Name").val("");
            // $("#productPrice").val(0);

            const input = document.getElementById('searchProductID');
            const datalist = document.getElementById('optionProductID');
            const filter = input.value;
            // allUserCar = ['Apple', 'Banana', 'Cherry', 'Date', 'Elderberry'];
            datalist.innerHTML = ''; // Clear existing options
            if (filter == "" || filter.length < 3) return;

            allProduct
                .filter(option => option.productid.includes(filter) || option.name.includes(filter)) // Filter options
                .forEach(option => {
                    const newOption = document.createElement('option');
                    newOption.value = option.productid;
                    newOption.innerText = option.name;
                    datalist.appendChild(newOption);
                });
        }

        showTableProductSale(arrProductSale);

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
            if (!checkValueCustomer()) {
                toastr.error('ยังไม่มีข้อมูลลูกค้า !!!.', {
                    timeOut: 2000,
                    closeOnHover: true
                });
                document.getElementById("selectListCustomer").click();
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

            loaderScreen("show");
            try {
                if (arrProductSale.length) {
                    if ($("#customerID").val()) {
                        $.ajax({
                            type: "POST",
                            url: "service/saveProductSale.php",
                            data: {
                                customerID: $("#customerID").val(),
                                customerName: $("#customerName").val(),
                                arrProductSale: JSON.stringify(arrProductSale),
                                amount: amount,
                                total: total,
                                vat: vat ? 1 : 0,
                            }
                        }).done(function(resp) {
                            // alert(JSON.stringify(resp.message));
                            toastr.success('เพิ่มรายการเรียบร้อย.', {
                                timeOut: 2000,
                                closeOnHover: true
                            });

                            window.location = "index.php";
                            // setHTMLListCustomer();
                            // setHTMLListProductSale();
                            // arrProductSale = [];
                            // showTableProductSale(arrProductSale);

                            // result = JSON.parse(resp.message);
                            // showDataTable(_table, result);
                        }).fail(function(err) {
                            alert(err.responseJSON.message)
                        });
                    } else {
                        toastr.error('ยังไม่มีข้อมูลลูกค้า !!!.', {
                            timeOut: 2000,
                            closeOnHover: true
                        });
                    }
                } else {
                    toastr.error('ยังไม่มีรายการสินค้า !!!.', {
                        timeOut: 2000,
                        closeOnHover: true
                    });
                }
            } catch (ex) {
                alert(ex);
            }
            loaderScreen("hide");
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
                if (arrProductSale.find((element) => element.productID == $("#txtProductSaleID").val())) {
                    toastr.error('รายการสินค้านี้มีอยู่แล้ว!!!', {
                        timeOut: 5000,
                        closeOnHover: true
                    });
                    loaderScreen("hide");
                    return;
                }

                // arrProductSale.push({
                //     productID: $("#txtProductSaleID").val(),
                //     name: $("#txtProductSaleName").val(),
                //     price: $("#productPrice").val(),
                //     qty: $("#productQty").val(),
                // });

                arrProductSale.push({
                    productID: $("#txtProductSaleID").val(),
                    name: $("#Product_Name").val(),
                    price: $("#productPrice").val(),
                    qty: $("#productQty").val(),
                });


                // element = document.getElementById("selectListCustomer");
                // element.disabled = true;
                element = document.getElementById("searchCarID");
                element.disabled = true;

                showTableProductSale(arrProductSale);
                clearObjProductSale();
                toastr.success('เพิ่มรายการเรียบร้อย.', {
                    timeOut: 2000,
                    closeOnHover: true
                });
                // document.getElementById('languages').innerHTML = ''; // Clear existing options
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
                        sweetAlert('รายการของคุณถูกลบเรียบร้อย');
                        return;
                    }
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
            setHTMLListProductSale();
        }

        function setProductSaleOption() {
            $("#productID").val(objProductSale.productSale.id);
            $("#productName").val(objProductSale.productSale.name);
            // $("#productID").val(objProductSale.product.productID);
            // $("#productID").val(objProductSale.product.productID);
        }



        $(document).ready(function() {
            // getDatabase();
            // readCustomer();
            // readUserCar();
            // readProduct();
            // readProductSale();
            // dropdown();
            // readProduct();
            // readOption();
            //readDatabase("Size");
            // readDatabase("Gram");
            // readDatabase("Color");
            // setModal();
            // showTableProductSale();
        });

        let HTMLListProductSale = "";
        let HTMLListCustomer = "";

        function setListCustomer(result) {

            myHTML = `<select id="selectListCustomer" class="form-control form-select" aria-label="Default select example" onchange="customerSelected(this);">
        	<option disabled selected>เลือกรายชื่อลูกค้า</option>`;
            result.forEach(element => {
                ID = element.customerID;
                value = element.name;
                myHTML += `<option value="${ID}">${value}</option>`;
            });
            myHTML += `</select>`;
            HTMLListCustomer = myHTML;
            setHTMLListCustomer();
        }

        function setListUserCar(result) {
            myHTML = `<select id="selectListCustomer" class="form-control form-select" aria-label="Default select example" onchange="idCarSelected(this);">
        	<option disabled selected>เลือกรายชื่อลูกค้า</option>`;
            result.forEach(element => {
                ID = element.idcar;
                value = element.name;
                // myHTML += `<option value="${ID}">${value}</option>`;
                myHTML += `<option value="${ID}">${ID}</option>`;
            });
            myHTML += `</select>`;
            HTMLListCustomer = myHTML;
            setHTMLListCustomer();
        }

        function setHTMLListCustomer() {
            $('#showListCustomer').html(HTMLListCustomer);
        }

        function setHTMLListProductSale() {
            $('#showListProductSale').html(HTMLListProductSale);
        }

        function setListProductSale(result) {
            myHTML = `<select id="selectListProductSale" class="form-control form-select" aria-label="Default select example" onchange="productSaleSelected(this);">
<option disabled selected>เลือกรายการสินค้า</option>`;
            result.forEach(element => {
                ID = element.product_saleID;
                value = element.name;
                myHTML += `<option value="${ID}">${value}</option>`;
            });
            myHTML += `</select>`;
            HTMLListProductSale = myHTML;
            setHTMLListProductSale();
        }

        function customerSelected(_this) {
            element = _this;
            ID = element.value;
            name = element.options[element.selectedIndex].text;
            $("#customerID").val(ID);
            $("#customerName").val(name);
            // $("#selectListProductSale").removeAttr('disabled');
            $("#rowProductSale").removeClass('disabled');

        }

        function productSaleSelected(_this) {
            element = _this;
            ID = element.value;
            name = element.options[element.selectedIndex].text;
            // $("#productID").val(ID);
            // $("#productName").val(name);

            $("#txtProductSaleID").val(ID);
            $("#txtProductSaleName").val(name);
            setPriceCustomer();
            // $("#txtProductSaleID").change();
            // changeOption(this)
        }

        function setPriceCustomer() {
            productSaleID = $("#txtProductSaleID").val();
            customerID = $("#customerID").val();
            $.ajax({
                type: "POST",
                url: "service/readPriceByCustomer.php",
                data: {
                    customerID: $("#customerID").val(),
                    productSaleID: $("#txtProductSaleID").val(),
                }
            }).done(function(resp) {
                // alert(JSON.stringify(resp.message));
                result = JSON.parse(resp.message);
                if (result.length) {
                    $("#productPrice").val(result[0].price);
                } else {
                    $("#productPrice").val(0);
                }
                // result = JSON.parse(resp.message);
                // $("#productPrice").val(123);
                // result = JSON.parse(resp.message);
                // showDataTable(_table, result);
            }).fail(function(err) {
                alert(err.responseJSON.message)
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
            arrayProductSale.forEach(element => {
                ID = element.productID;
                total += element.price * element.qty;
                myHTML += `<tr><th class="fixed-side" scope="row">${count++}</th>`;
                myHTML += `<td class="fixed-side td-name string-clip">${element.name}</td><td class="text-right">${element.qty}</td><td class="text-right">${addCommas(element.price)}</td><td class="text-right">${addCommas(element.price*element.qty)}</td>`;
                myHTML += `<td style="vertical-align: middle;text-align:center;">
                            <button class="btn btn-danger" onclick="deleteArrayProductSale('${ID}');"><i class="far fa-trash-alt"></i></button>
                            </td></tr>`;
            });
            myHTML += `</body></table>`;
            myHTML += `</div></div>`;
            $("#showTableProductSale").html(myHTML);
            jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');
            $("#saveProductSale").text(`บันทึกการขาย ${arrayProductSale.length} รายการ ${addCommas(total)} บาท`);
            totalProduct = total;
            loaderScreen("hide");
        }

        function selectRow(_table, element = null) {
            txtName = `#txt${_table}`;
            $(txtName).val(element);
        }

        function readUserCar() {
            $.ajax({
                type: "POST",
                url: "service/readUserCar.php"
            }).done(function(resp) {
                //alert(resp);
                result = JSON.parse(resp.message);
                allUserCar = result;
                // setListUserCar(result);
                //showDataTable(_table, result);
            }).fail(function(err) {
                alert(err);
                //showDataTable(_table, result);
            });
        }

        function readProduct() {
            $.ajax({
                type: "POST",
                url: "service/readProduct.php"
            }).done(function(resp) {
                //alert(resp);
                result = JSON.parse(resp.message);
                allProduct = result;
                // setListUserCar(result);
                //showDataTable(_table, result);
            }).fail(function(err) {
                alert(err);
                //showDataTable(_table, result);
            });
        }

        function readCustomer() {
            $.ajax({
                type: "POST",
                url: "service/readCustomer.php"
            }).done(function(resp) {
                //alert(resp);
                result = JSON.parse(resp.message);
                setListCustomer(result)
                //showDataTable(_table, result);
            }).fail(function(err) {
                alert(err);
                //showDataTable(_table, result);
            });
        }

        function readProductSale() {
            $.ajax({
                type: "POST",
                url: "service/readProductSale.php"
            }).done(function(resp) {
                //alert(resp);
                result = JSON.parse(resp.message);
                setListProductSale(result)
                //showDataTable(_table, result);
            }).fail(function(err) {
                alert(err);
                //showDataTable(_table, result);
            });
        }
    </script>
    <script>
    </script>
</body>

</html>