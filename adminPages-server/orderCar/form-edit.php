<?php
require_once('../authen.php');
require_once("../../service/configData.php");

$orderNo = $_REQUEST["id"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>แก้ไขรายการขาย | <?php echo $shopName; ?></title>

    <!-- Favicons -->
    <?php include_once('../../includes/pagesFavicons.php'); ?>

    <!-- stylesheet -->
    <?php include_once('../../includes/pagesStylesheet.php'); ?>

    <!-- Datatables -->
    <?php include_once('../../includes/pagesDatatableStylesheet.php'); ?>

    <link href="css/table.css?<?php echo time(); ?>" rel="stylesheet">

    <style>
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
                            <!-- <input type="radio" class="btn-check" name="options-outlined" id="success-outlined" autocomplete="off" checked>
                            <label class="btn btn-outline-success" for="success-outlined">Checked success radio</label>

                            <input type="radio" class="btn-check" name="options-outlined" id="danger-outlined" autocomplete="off">
                            <label class="btn btn-outline-danger" for="danger-outlined">Danger radio</label> -->
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="mr-auto my-font-size" style="line-height: 2.1rem">รายการขาย</div>
                                    <a href="index.php" class="btn btn-warning btn-sm">ยกเลิก</a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="orderNo" class="col-form-label">เลขบิล</label>
                                                <input type="text" class="form-control" id="orderNo" value='<?php echo $orderNo; ?>' disabled>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <input type="hidden" class="form-control" id="customerID">
                                            <div class="form-group">
                                                <label for="customerName" class="col-form-label">ชื่อลูกค้า</label>
                                                <input type="text" class="form-control" id="customerName" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <input type="hidden" class="form-control" id="txtProductSaleID" onchange="setPriceCustomer();">
                                        <input type="hidden" class="form-control" id="txtProductSaleName">
                                    </div>
                                    <div class="row disabled" id="rowProductSale">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="listProductSaleName" class="col-form-label">รายชื่อสินค้า</label>
                                                <div id="showListProductSale">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="productQty" class="col-form-label">จำนวน</label>
                                                    <input type="number" class="form-control text-right" id="productQty" onclick="selectElement(this);" value="1">
                                                </div>
                                                <div class="col-4">
                                                    <label for="productPrice" class="col-form-label">ราคา</label>
                                                    <input type="number" class="form-control text-right" id="productPrice" onclick="selectElement(this);" value="0">
                                                </div>
                                                <div class="col-4" style="display: flex;flex-wrap: wrap;">
                                                    <div style="margin-left: auto; margin-right: 0;margin-top: auto; margin-bottom: 0;"><button id="btnAdd" class="btn btn-primary btn-2px" onclick="addProductSale();">เพิ่มรายการ</button></div>
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
                                                    <button id="saveProductSale" class="btn btn-success btn-2px" style="margin-left: auto; margin-right: 0;" onclick="saveProductSale();">บันทึกการขาย</button>
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

    <script type="text/javascript">
        var arrProductSale = [];
        var objProductSale = {};
        var amountProduct = 0;
        var vat = 0;
        var totalProduct = 0;

        var indexLabel = 0;
        var productSale = [];

        $(document).ready(function() {
            getOrderByOrderNo();
            readProductSale();
        });

        function getOrderByOrderNo() {
            if ($("#orderNo").val()) {
                $.ajax({
                    type: "POST",
                    url: "service/readByOrderNo.php",
                    data: {
                        orderNo: $("#orderNo").val()
                    }
                }).done(function(resp) {
                    // alert(JSON.stringify(resp.message));
                    // toastr.success('เพิ่มรายการเรียบร้อย.', {
                    //     timeOut: 2000,
                    //     closeOnHover: true
                    // });
                    // resp.message
                    // arrProductSale
                    order = JSON.parse(resp.message);
                    orderHeader = order.header;
                    orderDeatil = order.detail;
                    $("#customerID").val(orderHeader.customerID);
                    $("#customerName").val(orderHeader.customerName);
                    if (orderHeader.vat == "0") {
                        $("#vatProductSale")[0].checked = false;
                        $("#vatProductSale")[0].click();
                    }
                    $("#vatProductSale").attr("disabled","false");
                    $("#rowProductSale").removeClass('disabled');

                    arrProductSale = genArrProductSale(orderDeatil);

                    // setHTMLListCustomer();
                    setHTMLListProductSale();

                    showTableProductSale(arrProductSale);

                    // result = JSON.parse(resp.message);
                    // showDataTable(_table, result);
                }).fail(function(err) {
                    alert("Error : " + err.responseJSON.message)
                });
            } else {
                toastr.error('ยังไม่มีข้อมูลลูกค้า !!!.', {
                    timeOut: 2000,
                    closeOnHover: true
                });
            }
        }

        function genArrProductSale(orderDeatil) {
            orderDeatil.forEach(element => {
                arrProductSale.push({
                    productID: element.productSaleID,
                    name: element.productName,
                    price: element.price,
                    qty: element.qty,
                });
            });
            return arrProductSale;
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
            if (!checkValueCustomer()) {
                toastr.error('ยังไม่มีข้อมูลลูกค้า !!!.', {
                    timeOut: 2000,
                    closeOnHover: true
                });
                document.getElementById("selectListCustomer").click();
                //$("#selectListCustomer").click();
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

            message = `บันทึกการแก้ไขรายการ?<br>รวมเงิน ${addCommas(totalProduct)} บาท`;

            amount = totalProduct;
            if (vat) {
                total = (totalProduct * 1.07).toFixed(2) * 1;
                vatTotal = (total - totalProduct).toFixed(2) * 1;
                // message += `<br>ภาษี ${((total-totalProduct)).toLocaleString()} บาท<br>ยอดรวมทั้งหมด ${total.toLocaleString()} บาท`;
                message += `<br>ภาษี ${addCommas(vatTotal)} บาท<br>ยอดรวมทั้งหมด ${addCommas(total)} บาท`;
            }

            confirm = await sweetConfirmSaveWithInput(message);
            if (!confirm.result) {
                return;
            }
            // alert(confirm.message)

            loaderScreen("show");
            // vat = $("#vatProductSale")[0].checked
            // amount = 0;

            // for (index = 0; index < arrProductSale.length; index++) {
            //     amount += arrProductSale[index].price * arrProductSale[index].qty;
            // }
            // total = amount.toFixed(2);
            // if (vat) {
            //     total = (amount * 1.07).toFixed(2);
            // }
            try {
                if (arrProductSale.length) {
                    if ($("#customerID").val()) {
                        $.ajax({
                            type: "POST",
                            url: "service/updateProductSale.php",
                            data: {
                                orderNo: $("#orderNo").val(),
                                customerID: $("#customerID").val(),
                                customerName: $("#customerName").val(),
                                arrProductSale: JSON.stringify(arrProductSale),
                                amount: amount,
                                total: total,
                                vat: vat ? 1 : 0,
                                description: confirm.message
                            }
                        }).done(function(resp) {
                            // alert(JSON.stringify(resp.message));
                            toastr.success('เพิ่มรายการเรียบร้อย.', {
                                timeOut: 2000,
                                closeOnHover: true
                            });

                            window.location = "index.php";

                            setHTMLListCustomer();
                            setHTMLListProductSale();
                            arrProductSale = [];
                            showTableProductSale(arrProductSale);

                            // result = JSON.parse(resp.message);
                            // showDataTable(_table, result);
                        }).fail(function(err) {
                            alert("Error : " + err.responseJSON.message)
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
                alert("error : " + ex);

            }
            loaderScreen("hide");
        }

        function addProductSale() {

            loaderScreen("show");
            if ($("#txtProductSaleID").val() != "") {
                if (Number($("#productPrice").val()) == 0) {
                    toastr.error('ยังไม่มีราคาสินค้า !!!', {
                        timeOut: 2000,
                        closeOnHover: true
                    });
                    loaderScreen("hide");
                    $("#productPrice").click();
                    return;
                }
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

                arrProductSale.push({
                    productID: $("#txtProductSaleID").val(),
                    name: $("#txtProductSaleName").val(),
                    price: $("#productPrice").val(),
                    qty: $("#productQty").val(),
                });

                showTableProductSale(arrProductSale);
                clearObjProductSale();
                toastr.success('เพิ่มรายการเรียบร้อย.', {
                    timeOut: 2000,
                    closeOnHover: true
                });
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

                alert("error : " + ex);
            }
        }

        function clearObjProductSale() {
            objProductSale = {};
            $("#productID").val("");
            $("#productName").val("");
            $("#txtProductSaleID").val("");
            $("#txtProductSaleName").val("");
            $("#productPrice").val("0");
            $("#productQty").val("1");
            setHTMLListProductSale();
        }

        function setProductSaleOption() {
            // alert(objProductSale);
            $("#productID").val(objProductSale.productSale.id);
            $("#productName").val(objProductSale.productSale.name);
            // $("#productID").val(objProductSale.product.productID);
            // $("#productID").val(objProductSale.product.productID);
        }


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

        function setHTMLListCustomer() {
            $('#showListCustomer').html(HTMLListCustomer);
        }

        function setHTMLListProductSale() {
            if (HTMLListProductSale == "") {
                readProductSale();
            }
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
                alert("Error : " + err.responseJSON.message)
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

            // myHTML = `<div id="table-scroll" class="table-scroll">';
            //             <div class="table-wrap">
            //                 <table id="tableProductSale" class="main-table" style="width:100%;">`;

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
                                <th scope="col">ลบรายการ</th>
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
                alert("error : " + err);

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
                alert("error : " + err);
                //showDataTable(_table, result);
            });
        }
    </script>
    <script>
    </script>
</body>

</html>