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
                            <label class="m-0 text-dark">จัดการสินค้า</label>
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
                                    <label class="mr-auto" style="line-height: 2.1rem">รายชื่อ</label>
                                    <a href="form-create.php" class="btn btn-primary boxx float-right"><i class="fa fa-plus"></i> เพิ่มสินค้า</a>
                                </div>
                                <div class="card-body" style="font-size: 1rem;">
                                    <div class="row">
                                        <div class="col-12 col-md-2">
                                            <!-- ค้นหาสินค้า -->
                                            <div class="container-input-label">
                                                <label for="productInput">สินค้า</label>
                                                <div class="form-group autocomplete-container mb-4">
                                                    <input type="text" id="productInput" class="inputStyle inputStyleIcon inputStyleFind cursorHand" placeholder="รหัสสินค้าหรือชื่อ..." autocomplete="off">
                                                    <button id="btnViewProduct" class="button btn btn-primary btn-fa" style="" data-toggle="modal" data-target="#viewProductModal"><i class="fa fa-search"></i></button>
                                                    <input type="hidden" id="productCode">
                                                    <div id="productSuggestions" class="suggestions"></div>
                                                    <!-- <div id="productDetails" class="details-box"></div> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <!-- ค้นหาสินค้า -->
                                            <div class="container-input-label">
                                                <label for="productName">สินค้า</label>
                                                <input type="text" id="productName" class="inputStyle inputStyleIcon cursorHand" placeholder="..." autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-1">
                                            <!-- ค้นหาสินค้า -->
                                            <div class="container-input-label">
                                                <label for="productQty">จำนวน</label>
                                                <input type="text" id="productQty" class="inputStyle cursorHand text-right" placeholder="0" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-1">
                                            <!-- ค้นหาสินค้า -->
                                            <div class="container-input-label">
                                                <label for="productQty">ราคา/หน่วย</label>
                                                <input type="text" id="productQty" class="inputStyle cursorHand text-right" placeholder="" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-1">
                                            <!-- ค้นหาสินค้า -->
                                            <div class="container-input-label">
                                                <label for="productQty">ราคา</label>
                                                <input type="text" id="productQty" class="inputStyle cursorHand text-right" placeholder="0" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-2 m-auto">
                                            <!-- ค้นหาสินค้า -->
                                            <button id="btn-add-product" class="btn btn-success boxx"><i class="fa fa-plus"></i> เพิ่มสินค้า</button>
                                        </div>
                                    </div>
                                    <table id="dataTable" class="table table-bordered" width="100%">

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
    <script src="../indexedDB/indexedDB.js"></script>
    <script type="text/javascript">
        let products = [];
        $(document).ready(async function() {
            await openDB();
            products = await loadDataFromDB("products");
            // เรียกใช้ autocomplete สำหรับสินค้า
            setupAutocomplete(
                "productInput", "productSuggestions", "productCode", "productName",
                products, "productId", "name", "price1"
            );

            // เรียกใช้ autocomplete สำหรับลูกค้า
            // setupAutocomplete(
            //     "customerInput", "customerSuggestions", "customerCode", "customerDetails",
            //     customers, "address", "name"
            // );
            loaderScreen("hide");
            //alert(products.length);
        });

        function setupAutocomplete(inputId, suggestionsId, hiddenId, detailsId, dataList, codeId, displayField1, displayField2) {
            const input = document.getElementById(inputId);
            const suggestionsBox = document.getElementById(suggestionsId);
            const hiddenInput = document.getElementById(hiddenId);
            const detailsBox = document.getElementById(detailsId);
            let currentFocus = -1;

            input.addEventListener("input", function() {
                const value = this.value.toLowerCase();
                suggestionsBox.innerHTML = "";
                currentFocus = -1;
                // detailsBox.textContent = "";
                hiddenInput.value = "";

                if (!value || value.length < 2) return;

                const matches = dataList.filter(item =>
                    item[codeId].toLowerCase().includes(value) || item.name.toLowerCase().includes(value)
                );

                if (matches.length) {
                    suggestionsBox.classList.add("suggestions-active");
                } else {
                    suggestionsBox.classList.remove("suggestions-active");
                }

                matches.forEach(item => {
                    const div = document.createElement("div");
                    div.textContent = `${item[codeId]} - ${item.name}`;
                    div.classList.add("suggestion-item");
                    div.addEventListener("click", () => {
                        input.value = `${item[codeId]} - ${item[displayField1]}`;
                        input.value = `${item[codeId]}`;
                        hiddenInput.value = item[codeId];
                        // detailsBox.value = `${displayField1}: ${item[displayField1]} | ${displayField2}: ${item[displayField2]}`;
                        detailsBox.value = item[displayField1];
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
                items.forEach(item => item.classList.remove("active"));
                items[currentFocus]?.classList.add("active");
                items[currentFocus]?.scrollIntoView({
                    block: "nearest"
                });
            }

            document.addEventListener("click", (e) => {
                if (!e.target.closest(`#${inputId}`)) {
                    suggestionsBox.innerHTML = "";
                    suggestionsBox.classList.remove("suggestions-active");
                }
            });
        }
    </script>
</body>

</html>