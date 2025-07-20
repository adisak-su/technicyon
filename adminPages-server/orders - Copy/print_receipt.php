<?php
require_once("../../service/configData.php");
$orderId = "";
if (isset($_GET["orderId"]) && !empty($_GET["orderId"])) {
    $orderId = $_GET["orderId"];
} else {
    $orderId = "";
}

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>พิมพ์ใบซ่อมรถ</title>
    <!-- Bootstrap 4 CSS -->
    <link
        rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Calistoga&family=Itim&family=Mitr:wght@200;300;400;500;600;700&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>" />
    <link rel="stylesheet" href="css/print11.css?<?php echo time(); ?>" media="print" />

    <style>
        .sarabun-thin {
            font-family: "Sarabun", sans-serif;
            font-weight: 100;
            font-style: normal;
        }

        .sarabun-extralight {
            font-family: "Sarabun", sans-serif;
            font-weight: 200;
            font-style: normal;
        }

        .sarabun-light {
            font-family: "Sarabun", sans-serif;
            font-weight: 300;
            font-style: normal;
        }

        .sarabun-regular {
            font-family: "Sarabun", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .sarabun-medium {
            font-family: "Sarabun", sans-serif;
            font-weight: 500;
            font-style: normal;
        }

        .sarabun-semibold {
            font-family: "Sarabun", sans-serif;
            font-weight: 600;
            font-style: normal;
        }

        .sarabun-bold {
            font-family: "Sarabun", sans-serif;
            font-weight: 700;
            font-style: normal;
        }

        .sarabun-extrabold {
            font-family: "Sarabun", sans-serif;
            font-weight: 800;
            font-style: normal;
        }

        .sarabun-thin-italic {
            font-family: "Sarabun", sans-serif;
            font-weight: 100;
            font-style: italic;
        }

        .sarabun-extralight-italic {
            font-family: "Sarabun", sans-serif;
            font-weight: 200;
            font-style: italic;
        }

        .sarabun-light-italic {
            font-family: "Sarabun", sans-serif;
            font-weight: 300;
            font-style: italic;
        }

        .sarabun-regular-italic {
            font-family: "Sarabun", sans-serif;
            font-weight: 400;
            font-style: italic;
        }

        .sarabun-medium-italic {
            font-family: "Sarabun", sans-serif;
            font-weight: 500;
            font-style: italic;
        }

        .sarabun-semibold-italic {
            font-family: "Sarabun", sans-serif;
            font-weight: 600;
            font-style: italic;
        }

        .sarabun-bold-italic {
            font-family: "Sarabun", sans-serif;
            font-weight: 700;
            font-style: italic;
        }

        .sarabun-extrabold-italic {
            font-family: "Sarabun", sans-serif;
            font-weight: 800;
            font-style: italic;
        }

        .row-height {
            height: 25px;
        }

        .row-height-vat {
            height: 80px;
        }

        td {
            padding-top: 4px !important;
            padding-bottom: 4px !important;
        }

        th {
            padding-top: 4px !important;
            padding-bottom: 4px !important;
        }

        /* Print Styles */
        @page {
            /* size: A4; */
            /* width: 21cm; */
            width: 21cm;
            height: 15cm;
            margin: 0cm;
        }

        @media print {

            html,
            body {
                /* width: 210mm; */
                width: 210mm;
                height: 150mm;
                background-color: white;
                color: black;
                /* font-size: 12pt; */
            }

            .container {
                width: 100%;
                max-width: 100%;
                padding: 0;
            }

            .d-print-none {
                display: none !important;
            }

            .table {
                page-break-inside: avoid;
            }

            h3,
            h4,
            h5 {
                page-break-after: avoid;
            }

            .no-break {
                page-break-inside: avoid;
            }

            /*
    #repairInvoice {
        border: none;
        box-shadow: none;
    }

    .table td,
    .table th {
        padding: 0.3rem;
        border-top: none;
    }
    .table th {
        border-top: 1px solid #000000 !important;
        border-bottom: 1px solid #000000 !important;
    }
    */

        }

        /* Additional Print Styles */

        .table tr .border-top-bottom {
            border-top: 1px solid #000000 !important;
            border-bottom: 1px solid #000000 !important;
        }

        .table tr .border-bottom {
            border-bottom: 1px solid #000000 !important;
        }

        #repairInvoice {

            background-color: white;
            color: black;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #000000 !important;
        }

        .border-top-bottom {
            border-top: 1px solid #000000 !important;
            border-bottom: 1px solid #000000 !important;
        }

        .table,
        .table-responsive {
            border: none !important;
        }

        table {
            border: none !important;
        }

        table,
        th,
        tr,
        td {
            border: none !important;
        }
    </style>

</head>

<body class="sarabun-bold">
    <div class="container mt-4 mb-4">
        <!-- Print Header -->

        <!-- Repair Invoice -->
        <div class="card" id="repairInvoice">
            <div class="card-body pt-0 pb-0">
                <div class="table-responsive">
                    <!-- Invoice Header -->
                    <table class="table mb-0">
                        <tbody style="font-size:20px;">
                            <tr style="font-size:24px;">
                                <td colspan="5" class="text-center">
                                    <strong><?php echo $shopName; ?></strong>
                                </td>
                            </tr>
                            <tr class="row-height" style="font-size:20px;">
                                <td>
                                    <strong>วันที่ </strong> <strong id="invoiceDate"></strong>
                                </td>
                                <td colspan="3" class="text-center">
                                    <strong>ใบเสนอราคา/ใบวางบิล</strong>
                                </td>
                                <td class="text-right">
                                    <strong>เลขที่ </strong> <strong id="invoiceNo"></strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <strong>ชื่อ </strong> <span id="customerName"></span>
                                </td>
                                <td class="text-right">
                                    <strong>โทร </strong> <span id="customerTelephone"></span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <strong>ที่อยู่ </strong> <span id="customerAddress"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Repair Details -->
                <!-- <div class="mb-4">
                    <h5>รายละเอียดการซ่อม</h5>
                    <p>
                        <strong>ช่างซ่อม:</strong>
                        <span id="mechanicName"></span><br />
                        <strong>สถานะ:</strong>
                        <span id="repairStatus"></span><br />
                        <strong>หมายเหตุ:</strong>
                        <span id="repairNotes"></span>
                    </p>
                </div> -->

                <!-- Repair Items Table -->
                <div class="table-responsive">
                    <table class="table mt-1 mb-0" style="font-size:18px;">
                        <thead>

                            <tr class="border-top-bottom">
                                <th width="5%" class="text-right">
                                    จำนวน
                                <th width="75%">รายการอะไหล่</th>
                                </th>
                                <th width="10%" class="text-right">
                                    ราคาต่อหน่วย
                                </th>
                                <th width="10%" class="text-right">จำนวนเงิน</th>
                            </tr>

                        </thead>
                        <tbody id="invoiceItems" style="font-size: 18px;">
                            <!-- Items will be loaded here -->
                        </tbody>
                        <tfoot>
                            <tr class="border-top-bottom">
                                <td
                                    colspan="2"
                                    class="font-weight-bold border-top-bottom"
                                    id="thaiBathTotal">
                                </td>
                                <td

                                    class="text-right font-weight-bold border-top-bottom">
                                    รวมทั้งสิ้น
                                </td>
                                <td

                                    class="text-right font-weight-bold border-top-bottom"
                                    id="invoicePartsTotal">
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Signature Area -->
                <div class="table-responsive">
                    <table class="table mb-0" style="font-size:18px;">
                        <tr id="rowVat">
                            <td width="33%">
                                (ผู้รับของ) ___________________________
                            </td>
                            <td width="33%">
                                (ผู้รับเงิน) ___________________________
                            </td>
                            <td width="24%" class="p-0">
                                <div id="tableVat"></div>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Footer -->
                <!-- <div class="text-center">
                    <p>ขอบคุณที่ใช้บริการอู่ซ่อมรถ ดีดี โทรศัพท์: 02-123-4567 | เวลาทำการ: 08:30 - 17:30 น. (หยุดวันอาทิตย์)</p>
                </div> -->
            </div>
        </div>
    </div>

    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="../../assets/js/common.js?<?php echo time(); ?>"></script>
    <script src="../../assets/js/thai-baht-text.js?<?php echo time(); ?>"></script>
    <!-- <script src="js/print-script.js?<?php echo time(); ?>"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        let repairs = [];
        let cars = [];
        let space = "&nbsp;";
        let space2 = "&nbsp;&nbsp;";
        let space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

        const STORAGE_KEYS = {
            CARS: "carRepairSystem_cars",
            REPAIRS: "carRepairSystem_repairs",
            PARTS: "carRepairSystem_parts",
        };

        async function getDataFromServer1(orderId) {

        }

        const getDataFromServer = async (endpoint) => {
            try {
                const response = await fetch(`services/${endpoint}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                return data.data;
            } catch (error) {
                console.error(`Error fetching ${endpoint}:`, error);
                throw error;
            }
        };

        async function genDataForPrint(orderId) {
            repair = {};
            let result = null;
            if (orderId !== "") {
                result = await getDataFromServer("getOrderAxios.php?orderId=" + orderId);
                if (result) {
                    // {
                    //     "orderId": "F202500058",
                    //     "myreference": null,
                    //     "mydate": "2025-06-23 10:50:35",
                    //     "customerId": "C000000033",
                    //     "total": "1960.00",
                    //     "vatvalue": "137.20",
                    //     "discount": "0.00",
                    //     "nettotal": "2097.20",
                    //     "mystring": "สองพันเก้าสิบเจ็ดบาทยี่สิบสตางค์",
                    //     "status": "1",
                    //     "invoiceId": null,
                    //     "typesale": "1",
                    //     "details": "[{\"id\":\"MR-55555\",\"name\":\"\\u0e0a\\u0e38\\u0e14\\u0e1b\\u0e23\\u0e31\\u0e1a\\u0e23\\u0e2d\\u0e1a\\u0e40\\u0e14\\u0e34\\u0e19\\u0e40\\u0e1a\\u0e32 Missubishi E-Car\",\"price\":800,\"quantity\":2,\"total\":1600},{\"id\":\"B056115561G\",\"name\":\"\\u0e01\\u0e23\\u0e2d\\u0e07\\u0e40\\u0e04\\u0e23\\u0e37\\u0e48\\u0e2d\\u0e07\\u0e41\\u0e1a\\u0e1a\\u0e41\\u0e17\\u0e49 \\u0e42\\u0e1f\\u0e25\\u0e4c\\u0e04\",\"price\":180,\"quantity\":2,\"total\":360}]",
                    //     "updatedAt": "2025-06-23 10:50:35"
                    // }

                    repair = {
                        orderId: result.orderId,
                        orderDate: result.mydate,
                        customerId: result.customerId,
                        customerName: result.customerName,
                        customerAddress: result.customerAddress,
                        customerTelephone: result.customerTelephone,
                        status: Number(result.status),
                        vat: Number(result.vatvalue) > 0 ? 1 : 0,
                        typeSale: Number(result.typesale),
                        vatValue: Number(result.vatvalue),
                        partsTotal: Number(result.total),
                        total: Number(result.nettotal),
                        orderItems: JSON.parse(result.details),
                        thaiBahtText: result.mystring
                    };
                }
            } else {
                repair = getStorage("order");
            }
            // Fill invoice data
            $('#invoiceNo').text(repair.orderId);
            $('#invoiceDate').text(formatDate(repair.orderDate));
            $('#customerName').text(repair.customerName);
            $('#customerAddress').text(repair.customerAddress);
            $('#customerTelephone').text(repair.customerTelephone);

            // Fill repair items
            $('#invoiceItems').empty();
            repair.orderItems.forEach((item, index) => {
                const row = `
                <tr class="row-height">
                <td  class="text-right">${item.quantity+space5}</td>
                <td >${item.name}</td>
                <td class="text-right">${item.price.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,})}</td>
                <td  class="text-right">${item.total.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,})}</td>
                </tr>
                `;
                $('#invoiceItems').append(row);
            });
            for (let i = repair.orderItems.length; i < 10; i++) {
                const row = `
                <tr class="row-height">
                <td colspan="4">${space}</td>
                </tr>
                `;
                $('#invoiceItems').append(row);

            }

            if (repair.vat) {
                let vatValue = repair.partsTotal * 0.07;
                let orderTotal = repair.partsTotal + vatValue;
                const tableVat = `<div class="table-responsive p-0 m-0">
                                    <table class="table mb-0" style="font-size: 18px;">
                                        <tr>
                                            <td class="text-right font-weight-bold">vat 7%</td>
                                            <td class="border-bottom">
                                                <div class="text-right font-weight-bold"
                                                    id="vatValue">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right font-weight-bold">ยอดสุทธิ</td>
                                            <td class="border-top-bottom">
                                                <div class="text-right font-weight-bold"
                                                    id="invoiceTotal">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>`;
                $("#tableVat").append(tableVat);
                $('#vatValue').text(vatValue.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }));
                $('#invoiceTotal').text(orderTotal.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }));

            } else {
                $('#rowVat').addClass("row-height-vat");
            }
            // Fill totals
            $('#invoicePartsTotal').text(repair.partsTotal.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }));
            $('#thaiBathTotal').text("(" + ThaiBahtText(repair.total) + ")");

        }

        $(document).ready(async function() {
            // const orderId = `"<?php echo $orderId; ?>"`;
            const orderId = <?php echo '"' . $orderId . '"'; ?>;
            await genDataForPrint(orderId);
            window.print();
            // ปิดหน้าต่างหลังจากพิมพ์ (ถ้าเป็น popup)
            setTimeout(function() {
                window.close();
            }, 1000);

            // พิมพ์อัตโนมัติเมื่อโหลดหน้าเสร็จ

        });
        window.onload = function() {
            // window.print();
            // // ปิดหน้าต่างหลังจากพิมพ์ (ถ้าเป็น popup)
            // setTimeout(function() {
            //     window.close();
            // }, 1000);
        };


        // Format date to Thai format (dd/mm/yyyy)
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear() + 543; // Convert to Thai year

            return `${day}/${month}/${year}`;
        }
    </script>
</body>

</html>