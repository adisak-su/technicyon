<?php
require_once("../../service/configData.php");
require_once("../../service/connect.php");
require_once("bath_thai.php");
require_once("../../assets/php/common.php");


// รับ orderId จาก URL
$orderId = "";
if (isset($_GET["orderId"]) && !empty($_GET["orderId"])) {
    $orderId = $_GET["orderId"];
} else {
    $orderId = "";
}

$DB = new Database();
$conn = $DB->connect();

$params = array(
    'orderId' => $orderId,
);

$sql = "SELECT * FROM order_head WHERE orderId=:orderId";
$sql = "SELECT *,name AS customerName,address AS customerAddress,telephone AS customerTelephone FROM (SELECT * FROM order_head WHERE orderId=:orderId) AS tmpOrder INNER JOIN customer ON (tmpOrder.customerId = customer.customerId)";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$vat = 0;
$netTotal = 0;
if (count($result) > 0) {
    $orderData = $result[0];
    // print_r($orderData);
    if ($orderData['vatvalue'] > 0) {
        $vat = 1;
    }
} else {
    $orderData = [];
    exit;
}

$MAXRowPerPage = $MAXRowPerPage_Front;
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ใบเสร็จรับเงิน</title>
    <style>
        /* @page {
            width: 9in;
            height: 5.5in;
            margin: 0;
            margin-top: 0.2in;
            margin-left: 0.1in;
            margin-right: 0.1in;
            margin-bottom: 0.1in;
        } */

        @media print {
            @page {
                width: 9in;
                height: 5.5in;
                margin-top: 0;
                margin-bottom: 0;
                margin-left: 0.1in;
                margin-right: 0.1in;
            }
            body {
                padding-top: 0.2in;
                /* padding-bottom: 0.1in ; */
                padding-bottom: 0in ;
            }
        }
/* 
        @page :footer {
            display: none
        }

        @page :header {
            display: none
        } 
*/

        /* @page {
            size: 9in 5.5in;
            margin: 0;
            margin-top: 0.2in;
            margin-left: 0.05in;
            margin-right: 0.1in;
            margin-bottom: 0.2in;
        } */

        body {
            font-family: 'TH Sarabun New', sans-serif;
            width: 9in;
            height: 5.5in;
            box-sizing: border-box;
            margin: 0;
            font-size: 16pt;
        }

        .header {
            text-align: center;
            /* margin-bottom: 15px; */
            /* border-bottom: 1px dashed #000; */
            /* padding-bottom: 10px; */
        }

        .customer-info {
            margin-top: -5px;
        }

        .order-info {
            display: flex;
            justify-content: space-between;
            margin-top: -10px;
            /* margin-bottom: 10px; */
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table tbody tr {
            line-height: 18pt;
        }

        .row-big {
            line-height: 20pt !important;
        }

        .row-small {
            line-height: 14pt !important;
        }

        .items-table th,
        .items-table td {
            /* border: 1px solid #ddd; */
            /* padding: 5px; */
            padding: 0px 5px;
            padding-top: 4px;
            text-align: left;
        }

        .items-table th {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .border-top-bottom {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .border-bottom {
            border-bottom: 2px solid #000;
        }

        .total-section {
            text-align: right;
            /* margin-top: 10px; */
            font-weight: bold;
        }

        .footer {
            text-align: center;
            /* margin-top: 20px; */
            /* border-top: 1px dashed #000; */
            /* padding-top: 10px; */
        }

        .font-big {
            font-size: 20pt;
            font-weight: 700;
        }

        .font-info {
            font-size: 18pt;
            font-weight: 700;
        }

        .font-body {
            font-size: 16pt;
            font-weight: 700;
        }

        .font-small {
            font-size: 16pt;
            font-weight: 700;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .flex-item {
            flex-grow: 1;
            flex-shrink: 1;
            flex-basis: 0;
        }
    </style>

</head>

<body>
    <div style="width:99%;">
        <div class="header">
            <div class="font-big"><?php echo $shopName; ?></div>
        </div>

        <div class="order-info font-info">
            <div class="flex-item">
                <strong>เลขที่ <?php echo $orderData['orderId']; ?></strong>
            </div>
            <div class="flex-item font-big center">ใบเสนอราคา</div>
            <div class="flex-item right">
                <strong>วันที่ <?php echo getLocalDateTime($orderData['mydate'],true); ?></strong>
            </div>
        </div>

        <div class="customer-info font-info">
            <div class="order-info">
                <div><strong>ชื่อลูกค้า <?php echo $orderData['customerName']; ?></strong></div>
                <div><strong>โทร <?php echo $orderData['customerTelephone']; ?></strong></div>
            </div>
        </div>

        <div class="customer-info font-info">
            <div><strong>ที่อยู่ <?php echo $orderData['customerAddress']; ?></strong></div>
        </div>

        <table class="items-table ">
            <thead>
                <tr class="font-info">
                    <th width="5%" style="text-align: right;">จำนวน</th>
                    <th width="70%">รายการ</th>
                    <th width="12%" style="text-align: right;">ราคา/หน่วย</th>
                    <th width="13%" style="text-align: right;">จำนวนเงิน</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $orderItems = json_decode($orderData['details']);
                foreach ($orderItems as $index => $item): ?>
                    <tr class="font-info">
                        <td style="text-align: right;padding-right:16px;"><?php echo $item->quantity; ?></td>
                        <td><?php echo $item->name; ?></td>
                        <td style="text-align: right;"><?php echo number_format($item->price, 2); ?></td>
                        <td style="text-align: right;"><?php echo number_format($item->total, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php 
                    //$MAXRowPerPage = 10;
                    for ($i = count($orderItems); $i < $MAXRowPerPage; $i++) { ?>
                    <tr class="font-info">
                        <td colspan="4">&nbsp;</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php if ($vat) { ?>
            <div class="total-section">
                <table class="items-table ">
                    <tr class="font-big border-top-bottom row-big">
                        <td width="75%">
                            <div>( <?php echo baht_text($orderData['nettotal'] * 1); ?> )</div>
                        </td>
                        <td width="12%" style="text-align: right;">
                            <div>ยอดสินค้า</div>
                        </td>
                        <td width="13%" style="text-align: right;">
                            <div><?php echo number_format($orderData['total'], 2); ?></div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                <table class="items-table ">
                    <tr class="font-info">
                        <td width="5%">
                            &nbsp;
                        </td>
                        <td width="30%" class="border-bottom">
                            &nbsp;
                        </td>
                        <td width="5%">
                            &nbsp;
                        </td>
                        <td width="30%" class="border-bottom">
                            &nbsp;
                        </td>
                        <td width="5%">
                            &nbsp;
                        </td>
                        <td width="12%" class="font-big" style="text-align: right;">
                            <div>ภาษี 7%</div>
                        </td>
                        <td width="13%" class="font-big" style="text-align: right;">
                            <div><?php echo number_format($orderData['vatvalue'], 2); ?></div>
                        </td>
                    </tr>
                    <tr class="font-small">
                        <td width="5%">
                            &nbsp;
                        </td>
                        <td style="text-align: center;">
                            (ผู้รับของ)
                        </td>
                        <td width="5%">
                            &nbsp;
                        </td>
                        <td style="text-align: center;">
                            (ผู้รับเงิน)
                        </td>
                        <td width="5%">
                            &nbsp;
                        </td>
                        <td width="12%" class="font-big border-top-bottom" style="text-align: right;">
                            <div>ยอดสุทธิ</div>
                        </td>
                        <td width="13%" class="font-big border-top-bottom" style="text-align: right;">
                            <div><?php echo number_format($orderData['nettotal'], 2); ?></div>
                        </td>
                    </tr>
                    <tr class="row-small font-small">
                        <td colspan="7" style="text-align: center;">
                            **** หมายเหตุ 1.อะไหล่ไฟทุกชนิด ซื้อแล้วไม่รับเปลี่ยน-ไม่รับคืน ****
                        </td>
                    </tr>
                    <tr class="row-small font-small">
                        <td colspan="7" style="text-align: center;">
                            **** 2.อะไหล่ที่ซื้อสามารถเปลี่ยน-คืน ได้ภายใน 7 วันเท่านั้น ****
                        </td>
                    </tr>
                </table>
            </div>
        <?php } else { ?>
            <div class="total-section">
                <table class="items-table ">
                    <tr class="font-big border-top-bottom row-big">
                        <td width="75%">
                            <div>( <?php echo baht_text($orderData['nettotal'] * 1); ?> )</div>
                        </td>
                        <td width="12%" style="text-align: right;">
                            <div>ยอดสุทธิ</div>
                        </td>
                        <td width="13%" style="text-align: right;">
                            <div><?php echo number_format($orderData['total'], 2); ?></div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                <table class="items-table ">
                    <tr class="font-info">
                        <td width="5%">
                            &nbsp;
                        </td>
                        <td width="30%" class="border-bottom">
                            &nbsp;
                        </td>
                        <td width="5%">
                            &nbsp;
                        </td>
                        <td width="30%" class="border-bottom">
                            &nbsp;
                        </td>
                        <td width="5%">
                            &nbsp;
                        </td>
                        <td width="12%">
                        </td>
                        <td width="13%">
                        </td>
                    </tr>
                    <tr class="font-small">
                        <td>
                            &nbsp;
                        </td>
                        <td style="text-align: center;">
                            (ผู้รับของ)
                        </td>
                        <td>
                            &nbsp;
                        </td>
                        <td style="text-align: center;">
                            (ผู้รับเงิน)
                        </td>
                        <td colspsn="3">
                            &nbsp;
                        </td>
                    </tr>
                    <tr class="row-small font-small">
                        <td colspan="7" style="text-align: center;">
                            **** หมายเหตุ 1.อะไหล่ไฟทุกชนิด ซื้อแล้วไม่รับเปลี่ยน-ไม่รับคืน ****
                        </td>
                    </tr>
                    <tr class="row-small font-small">
                        <td colspan="7" style="text-align: center;">
                            **** 2.อะไหล่ที่ซื้อสามารถเปลี่ยน-คืน ได้ภายใน 7 วันเท่านั้น ****
                        </td>
                    </tr>
                </table>
            </div>
        <?php } ?>
    </div>
    <script>
        
        // พิมพ์อัตโนมัติเมื่อโหลดหน้าเสร็จ
        window.onload = function() {
            
            window.print();

            // ปิดหน้าต่างหลังจากพิมพ์ (ถ้าเป็น popup)
            setTimeout(function() {
                window.close();
            }, 1000);
            
        };
        
    </script>
</body>

</html>