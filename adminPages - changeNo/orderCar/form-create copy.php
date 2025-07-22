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
        :root {
            --dark-body-bg: #232429;
            --light-body-bg: #F5F7FB;

            --dark-input: #323741;
            --light-input: #ffffff;

            --dark-border: #484D5A;
            --light-border: #B8BCCB;

            --dark-inactive-list: #A2AABE;
            --light-inactive-list: #7C8294;

            --dark-active-list: #ffffff;
            --light-active-list: #1C5EFF;

            --dark-list-hover: #2A2E34;
            --light-list-hover: #E9EFFF;

            --dark-toggle-bg: #1B1D22;
            --light-toggle-bg: #ffffff;

            --dark-toggle-moon: #C4C4C4;
            --dark-toggle-sun: #656B77;

            --light-toggle-moon: #7A849B;
            --light-toggle-sun: #ffffff;
        }

        body {
            height: 100vh;
            font-family: Helvetica, sans-serif;
            background: var(--dark-body-bg);
        }

        body.light {
            background: var(--light-body-bg);
        }

        form {
            width: 300px;
            margin: 0 auto;
            position: relative;
            top: 25%;
            /*   background: pink; */
        }

        label {
            display: block;
            color: #8A8F9F;
            font-size: 1.2rem;
            font-weight: 300;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 15px 20px;
            box-sizing: border-box;
            color: var(--dark-active-list);
        }

        body.light input {
            color: var(--light-active-list);
        }

        /* Common styles to keep DRY */
        input,
        #languages span {
            font-size: 1.2rem;
        }

        input,
        .languages_wrapper {
            border: 2px solid var(--dark-border);
            border-radius: 15px;
            box-sizing: border-box;
            background: var(--dark-input);
        }

        body.light input,
        body.light .languages_wrapper {
            border: 2px solid var(--light-border);
            background: var(--light-input);
        }

        /* ***** */

        input::placeholder {
            color: var(--dark-inactive-list);
            opacity: .7;
            letter-spacing: .05rem;
        }

        body.light input::placeholder {
            color: var(--light-inactive-list);
        }

        /* input::-webkit-calendar-picker-indicator {
  display:none !important;
} */

        .dropdown {
            position: relative;
            /*   background: salmon; */
        }

        .dropdown:after {
            content: "▾";
            padding: 12px 15px;
            position: absolute;
            right: 5px;
            top: 8px;
            color: var(--dark-active-list);
        }

        body.light .dropdown:after {
            color: var(--light-active-list);
        }

        .dropdown.active:after {
            transform: rotate(180deg);
        }

        /* 
* Dropdown list custom design 
*/

        .dropdown_wrapper {
            /*   background: pink; */
            padding-top: 8px;
            /* height: 250px; */
            max-height: 250px;
            display: none;
        }

        .dropdown_wrapper.active {
            display: block;
        }

        .languages_wrapper {
            overflow-y: hidden;
            height: 100%;
            padding: 8px;
            padding-right: 0;
            background: var(--dark-input);
        }

        body.light .languages_wrapper {
            background: var(--light-input);
        }

        #languages {
            overflow-y: auto;
            height: inherit;
        }


        #languages span {
            display: block;
            padding: 12px;
            border-radius: 15px;
            letter-spacing: .025rem;
            color: var(--dark-inactive-list);
        }

        #languages span:hover {
            background: var(--dark-list-hover);
            color: var(--dark-active-list);
            cursor: pointer;
        }

        body.light #languages span {
            color: var(--light-inactive-list);
        }

        body.light #languages span:hover {
            background: var(--light-list-hover);
            color: var(--light-active-list);
        }

        /* 
* 
* Switch styles
* W3Schools => https://www.w3schools.com/howto/howto_css_switch.asp
* 
*/

        /* The switch - the box around the slider */
        .switch {
            position: relative;
            top: 15%;
            left: 60%;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--dark-toggle-bg);
            border: 2px solid var(--dark-border);
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 2px;
            bottom: 2px;
            background: var(--dark-input);
            -webkit-transition: .4s;
            transition: .4s;
        }

        body.light .slider {
            background-color: var(--light-toggle-bg);
            border: 2px solid var(--light-border);
        }

        body.light .slider:before {
            background: var(--light-active-list);
        }

        /* input:checked + .slider {
  background-color: white;
} */

        /* input:checked + .slider:before {
  background-color: #2196F3;
} */

        /* input:checked + .slider .fa-moon {
  visibility: hidden;
}

input:checked + .slider .fa-sun {
  visibility: visible;
} */

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .fa-solid {
            font-size: 18px;
            position: absolute;
            top: 21.6%;
            /*   color: white; */
        }

        .fa-moon {
            left: 15.6%;
            color: var(--dark-toggle-moon);
        }

        .fa-sun {
            left: 58%;
            color: var(--dark-toggle-sun);
        }

        body.light .fa-moon {
            color: var(--light-toggle-moon);
        }

        body.light .fa-sun {
            color: var(--light-toggle-sun);
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
            font-size: 2rem !important;
            cursor: pointer;
        }

        option:hover,
        .active {
            background-color: lightblue;
        }


        datalist {
            position: absolute;
            max-height: 20em;
            border: 0 none;
            overflow-x: hidden;
            overflow-y: auto;
        }

        datalist option {
            font-size: 0.8em;
            padding: 0.3em 1em;
            background-color: #ccc;
            cursor: pointer;
        }

        /* option active styles */
        datalist option:hover,
        datalist option:focus {
            color: #fff;
            background-color: #036;
            outline: 0 none;
        }

        #browserdata option {
            font-size: 1.8em;
            padding: 0.3em 1em;
            background-color: #ccc;
            cursor: pointer;
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
                                    <a href="index.php" class="btn btn-warning btn-sm">กลับหน้าหลัก</a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="browser">browser:</label>

                                            <input
                                                list="browserdata"
                                                id="browser"
                                                name="browser"
                                                size="50"
                                                autocomplete="off" />

                                            <datalist id="browserdata">
                                                <option>Brave</option>
                                                <option>Chrome</option>
                                                <option>Edge</option>
                                                <option>Firefox</option>
                                                <option>Internet Explorer</option>
                                                <option>Opera</option>
                                                <option>Safari</option>
                                                <option>Vivaldi</option>
                                                <option>other</option>
                                            </datalist>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <form>
                                                <label>Coding Languages</label>
                                                <div class="dropdown">
                                                    <input type="text" placeholder="Search..." id="language" onkeyup="dataFilterCarIDDropdown();" onchange="setDataCarID(this.value);" autocomplete='off' />
                                                </div>

                                                <div class="dropdown_wrapper">
                                                    <div class="languages_wrapper">
                                                        <div id="languages">
                                                            <!-- <span>Haskell</span>
                                                            <span>Shell</span>
                                                            <span>Perl</span>
                                                            <span>Kotlin</span>
                                                            <span>Delphi</span>
                                                            <span>Groovy</span>
                                                            <span>Lua</span> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <label for="searchCarID">ทะเบียนรถ</label>
                                            <input type="text" id="searchCarID" list="optionCarID" onkeyup="dataFilterCarID();" onchange="setDataCarID(this.value);" autocomplete="off">
                                            <datalist id="optionCarID">
                                            </datalist>
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
                                            <!-- <form> -->
                                            <div class="form-group">
                                                <label for="listProductSaleName" class="col-form-label">รายชื่อสินค้า</label>
                                                <div id="showListProductSale">
                                                </div>
                                            </div>
                                            <!-- </form> -->
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
                                                    <!-- <label for="btnAdd" class="col-form-label">&nbsp;&nbsp;</label> -->
                                                    <div id="btnAdd" class="button btn btn-success" style="margin-left: auto; margin-right: 0;margin-top: auto; margin-bottom: 0;" onclick="addProductSale();"><i class="fa fa-plus"></i> เพิ่มรายการ</div>
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
                                    <!-- <div class="row">
                                        <div class="col-12">
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
                                                    <input type="number" class="form-control text-right" id="productQty" onclick="selectElement(this);" value=2>
                                                </div>
                                                <div class="col-4">
                                                    <label for="productPrice" class="col-form-label">ราคา</label>
                                                    <input type="number" class="form-control text-right" id="productPrice" onclick="selectElement(this);" value=234>
                                                </div>
                                                <div class="col-4" style="display: flex;flex-wrap: wrap;">
                                                    <div style="margin-left: auto; margin-right: 0;margin-top: auto; margin-bottom: 0;"><button id="btnAdd" class="btn btn-primary btn-2px" onclick="addProductSale();">เพิ่มรายการ</button></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="showListProduct" class="col-form-label">รายการสินค้า</label>
                                                <input type="text" class="form-control" id="productID">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label for="productName" class="col-form-label">รายการ</label>
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <input type="text" class="form-control" id="productName">
                                                            </div>
                                                            <div class="col-2" style="display: flex;flex-wrap: wrap;">
                                                                <button class="btn btn-primary btn-2px" data-toggle="modal" data-target="#optionModal"><i class="fa fa-search"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <label for="productQty" class="col-form-label">จำนวน</label>
                                                                <input type="number" class="form-control text-right" id="productQty" onclick="selectElement(this);" value=2>
                                                            </div>
                                                            <div class="col-4">
                                                                <label for="productPrice" class="col-form-label">ราคา</label>
                                                                <input type="number" class="form-control text-right" id="productPrice" onclick="selectElement(this);" value=234>
                                                            </div>
                                                            <div class="col-4" style="display: flex;flex-wrap: wrap;">
                                                                <div style="margin-left: auto; margin-right: 0;margin-top: auto; margin-bottom: 0;"><button id="btnAdd" class="btn btn-primary btn-2px" onclick="addProductSale();">เพิ่มรายการ</button></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- <div class="row">
                                        <div class="col-5">
                                            <label for="vatProductSale" class="col-form-label" style="padding:0px 0px;">ภาษี</label>
                                            <input class="toggle" id="vatProductSale" data-id="" type="checkbox" name="vatProductSale" checked data-toggle="toggle" data-off="ไม่มี Vat" data-on="&nbsp;&nbsp; มี Vat &nbsp;&nbsp;" data-onstyle="warning" data-style="ios">
                                        </div>
                                        <div class="col-7" style="display: flex;flex-wrap: wrap;">
                                            <button id="saveProductSale" class="btn btn-success btn-2px" onclick="saveProductSale();">บันทึกการขาย</button>
                                        </div>
                                    </div> -->
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
    <!--
    <div class="modal fade" id="productSaleModal" tabindex="-1" role="dialog" aria-labelledby="productSaleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <label class="modal-title" id="productSaleModalLabel">เพิ่มรายการ</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <input type="text" class="form-control" id="txtTable">
                        </div>
                        <div class="form-group">
                            <label for="txtName" class="col-form-label">รายการ</label>
                            <input type="text" class="form-control" id="txtName">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button id="btnSave" type="button" class="btn btn-primary" onclick="insertOption();">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="optionModal" tabindex="-1" role="dialog" aria-labelledby="optionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <label class="modal-title" id="optionModalLabel">รายละเอียดสินค้า</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="txtTable">
                            <input type="text" class="form-control" id="txtProductSaleID">
                            <input type="text" class="form-control" id="txtProductSaleName">
                        </div>
                        <div class="form-group">
                            <label for="showProductSaleName" class="col-form-label">รายการ</label>
                            <input type="text" class="form-control" id="showProductSaleName">
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="showListProduct"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="showDataTableSize"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="showDataTableGram"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="showDataTableColor"></div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button id="btnSave" type="button" class="btn btn-primary" data-dismiss="modal" onclick="setProductSaleOption();">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="insertModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <label class="modal-title" id="insertModalLabel">เพิ่มรายการ</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <input type="text" class="form-control" id="txtTable">
                        </div>
                        <div class="form-group">
                            <label for="txtName" class="col-form-label">รายการ</label>
                            <input type="text" class="form-control" id="txtName">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button id="btnSave" type="button" class="btn btn-primary" onclick="insertOption();">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <label class="modal-title" id="updateModalLabel">New message</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <input type="text" class="form-control" id="txtTable">
                            <input type="text" class="form-control" id="txtID">
                        </div>
                        <div class="form-group">
                            <label for="txtName" class="col-form-label">รายการ</label>
                            <input type="text" class="form-control" id="txtName">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button id="btnSave" type="button" class="btn btn-primary" onclick="updateOption();">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    -->
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
        var allUserCar = [];

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

        function dropdown() {
            // variables
            const body = document.querySelector("body"),
                input = document.querySelector("#language"),
                dropdown = document.querySelector(".dropdown"),
                dropdownList = document.querySelector(".dropdown_wrapper"),
                listItems = document.querySelectorAll("#languages span");
            // themeSwitch = document.querySelector(".switch input");
            body.classList.remove("dark");
            body.classList.add("light");
            // functions
            const addActiveClass = (e) => {
                // Adds active class to dropdown
                dropdown.classList.toggle("active");
                dropdownList.classList.toggle("active");



                // Reset search input value
                // e.target.value !== "" ? (e.target.value = "") : null;
            };

            const rmvActiveClass = () => {
                // Removes active class
                dropdown.classList.remove("active");
                dropdownList.classList.remove("active");
                dataFilterCarIDDropdown();
            };

            // const filterList = () => {
            //     let filter = input.value.toLowerCase().trim();

            //     for (let i = 0; i < listItems.length; i++) {
            //         let txtVal = listItems[i].innerText.toLowerCase();
            //         // console.log(txtVal.includes(filter), filter, txtVal)
            //         if (txtVal.includes(filter) && filter !== "") {
            //             listItems[i].style.background = "#E9EFFF";
            //             listItems[i].style.color = "#5B6278";

            //             // extra functionality on key val
            //             document.addEventListener('keydown', e => {
            //                 if (e.key === 'Enter') {
            //                     input.value = txtVal;
            //                     rmvActiveClass();
            //                 }
            //                 if (e.key === 'Backspace') {
            //                     // Adds active class (no toggle)
            //                     dropdown.classList.add("active");
            //                     dropdownList.classList.add("active");
            //                 }
            //             });
            //         } else {
            //             listItems[i].style.background = "";
            //             listItems[i].style.color = "";
            //         }
            //     }
            // };

            // actions
            // themeSwitch.addEventListener("click", () => {
            //     if (themeSwitch.checked) {
            //         // console.log(themeSwitch.checked);
            //         body.classList.remove("dark");
            //         body.classList.add("light");
            //     } else {
            //         // console.log(themeSwitch.checked);
            //         body.classList.remove("light");
            //         body.classList.add("dark");
            //     }
            // });

            // prevent form submission
            document.querySelector('form').addEventListener('submit', e => e.preventDefault());

            input.addEventListener("click", addActiveClass);
            input.addEventListener("input", () => {
                dropdown.classList.add("active");
                dropdownList.classList.add("active");
            });
            document.addEventListener("click", (e) => {
                console.log(e.target)
                // Check clicked outside of input
                e.target.id !== "language" &&
                    e.target.classList.contains("dropdown_wrapper") === false &&
                    e.target.classList.contains("languages_wrapper") === false ?
                    rmvActiveClass() :
                    null;
            });
            // listItems.forEach((item) => {
            //     item.addEventListener("click", (e) => {
            //         let val = e.target.innerHTML;
            //         // Update value of search input to chosen span
            //         input.value = val;
            //     });
            // });
            // input.addEventListener("keyup", filterList);
        }

        function setDataCarID(element) {
            let userCar = allUserCar.filter(item => item.idcar.toLowerCase() == element);
            if (userCar.length) {
                alert(JSON.stringify(userCar));
            }

            // alert(element)
        }

        function dataFilterCarIDDropdown() {
            const input = document.getElementById('language');
            const datalist = document.getElementById('languages');
            const filter = input.value.toLowerCase();
            // allUserCar = ['Apple', 'Banana', 'Cherry', 'Date', 'Elderberry'];
            datalist.innerHTML = ''; // Clear existing options
            if (filter == "") return;

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

        function dataFilterCarID() {
            const input = document.getElementById('searchCarID');
            const datalist = document.getElementById('optionCarID');
            const filter = input.value.toLowerCase();
            // allUserCar = ['Apple', 'Banana', 'Cherry', 'Date', 'Elderberry'];
            datalist.innerHTML = ''; // Clear existing options
            if (filter == "") return;

            allUserCar
                .filter(option => option.idcar.toLowerCase().includes(filter)) // Filter options
                .forEach(option => {
                    const newOption = document.createElement('option');
                    newOption.value = option.idcar;
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

                element = document.getElementById("selectListCustomer");
                element.disabled = true;

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
                alert(ex);
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
            $("#productID").val(objProductSale.productSale.id);
            $("#productName").val(objProductSale.productSale.name);
            // $("#productID").val(objProductSale.product.productID);
            // $("#productID").val(objProductSale.product.productID);
        }

        $(document).ready(function() {
            // getDatabase();
            // readCustomer();
            readUserCar();
            readProductSale();
            dropdown();
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
                setListUserCar(result);
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