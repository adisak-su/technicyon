<?php
// รับ orderId จาก URL
$orderId = $_GET['orderId'] ?? '';
$MAXROWPERPAGE = 6;

// เชื่อมต่อฐานข้อมูลและดึงข้อมูล (ตัวอย่างเท่านั้น)
// ในที่นี้จะใช้ข้อมูลตัวอย่างเหมือนที่คุณให้มา
$orderData = [
    'data' => [
        'orderId' => $orderId,
        'orderDate' => date('Y-m-d'),
        'customerId' => 'C000000033',
        'customerName' => 'บริษัทคม ฐาน ๙ รถยนต์ จำกัด # 0105551095117_สนญ.',
        'customerAddress' => '6/3,6/4 ถ.กาญจนาภิเษก แขวงรามอินทรา เขตคันนายาว กทม.10230 # 0105551095117',
        'customerTelephone' => '0897991784',
        'status' => 0,
        'vat' => 1,
        'typeSale' => 1,
        'vatValue' => 363.3,
        'partsTotal' => 5190,
        'total' => 5553.3,
        'orderItems' => [
            [
                'id' => 'B55544M426',
                'name' => 'AIR-BAG Nissan - นีโอ # B55544M426',
                'price' => 4830,
                'quantity' => 10,
                'total' => 14830
            ],
                        [
                'id' => 'B55544M426',
                'name' => 'AIR-BAG Nissan - นีโอ # B55544M426',
                'price' => 4830,
                'quantity' => 1,
                'total' => 4830
            ],
            //             [
            //     'id' => 'B55544M426',
            //     'name' => 'AIR-BAG Nissan - นีโอ # B55544M426',
            //     'price' => 4830,
            //     'quantity' => 1,
            //     'total' => 4830
            // ]

        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ใบเสร็จรับเงิน</title>
    <style>
        @page {
            /* size: 9in 5.5in; */
            width: 9in;
            height: 5.5in;
            margin: 0;
            margin-top: 0.2in;
            margin-left: 0.1in;
            margin-right: 0.1px;
            margin-bottom: 0.2in;
        }

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
            border-bottom: 1px dashed #000;
            /* padding-bottom: 10px; */
        }
        .customer-info {
            /* margin-bottom: 15px; */
        }
        .order-info {
            display: flex;
            justify-content: space-between;
            /* margin-bottom: 10px; */
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            /* margin-bottom: 15px; */
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 5px;
            padding: 0px 5px;
            text-align: left;
        }
        .total-section {
            text-align: right;
            /* margin-top: 10px; */
            font-weight: bold;
        }
        .footer {
            text-align: center;
            /* margin-top: 20px; */
            border-top: 1px dashed #000;
            padding-top: 10px;
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
    </style>
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
</head>
<body>
    <div style="width:99%;">
    <div class="header">
        <div class="font-big">ร้านจำหน่ายอะไหล่รถยนต์</div>
    </div>
    
    <div class="order-info font-info">
        <div>
            <strong>เลขที่ใบเสร็จ <?php echo $orderData['data']['orderId']; ?></strong>
        </div>
        <div class="font-big">ใบเสร็จรับเงิน</div>
        <div>
            <strong>วันที่ <?php echo $orderData['data']['orderDate']; ?></strong>
        </div>
    </div>
    
    <div class="customer-info font-info">
        <div class="order-info">
            <div><strong>ชื่อลูกค้า <?php echo $orderData['data']['customerName']; ?></strong></div>
            <div><strong>โทร <?php echo $orderData['data']['customerTelephone']; ?></strong></div>
        </div>
    </div>

    <div class="customer-info font-info">
        <div><strong>ที่อยู่ <?php echo $orderData['data']['customerAddress']; ?></strong></div>
    </div>
    
    <table class="items-table ">
        <thead>
            <tr class="font-info">
                <th width="5%" style="text-align: right;">จำนวน</th>
                <th width="70%">รายการ</th>
                <th width="12%" style="text-align: right;">ราคา/หน่วย</th>
                <th width="13%" style="text-align: right;">รวม</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach($orderData['data']['orderItems'] as $index => $item): ?>
            <tr class="font-info">
                <td style="text-align: right;"><?php echo $item['quantity']; ?></td>
                <td><?php echo $item['name']; ?></td>
                <td style="text-align: right;"><?php echo number_format($item['price'], 2); ?></td>
                <td style="text-align: right;"><?php echo number_format($item['total'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php for($i=count($orderData['data']['orderItems']);$i<$MAXROWPERPAGE;$i++) { ?>
            <tr class="font-info">
                <td colspan="4">&nbsp;</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    
    <div class="total-section font-big">
        <div>รวมทั้งหมด: <?php echo number_format($orderData['data']['partsTotal'], 2); ?> บาท</div>
    </div>
    
    <div class="footer font-small">
        <div class="table-responsive">
                    <table class="table mb-0 font-info">
                        <tr id="rowVat">
                            <td>
                                ___________________________
                            </td>
                            <td>
                                ___________________________
                            </td>
                            <td>
                                Vat    140.00
                            </td>

                        </tr>
                        <tr id="rowVat">
                            <td>
                                (ผู้รับของ)
                            </td>
                            <td>
                                (ผู้รับเงิน)
                            </td>
                            <td>
                                ยอดสุทธิ   10000.00
                            </td>
                        </tr>
                        <tr id="rowVat" class="font-small">
                            <td colspan="3">
                                หมายเหตุ 1.อะไหล่ไฟทุกชนิด ชื่อแล้วไม่รับเปลี่ยน-ไม่รับคืน
                            </td>
                        </tr>
                        <tr id="rowVat" class="font-small">
                            <td colspan="3">
                                2.อะไหล่ที่ซื้อสามารถเปลี่ยน-คืน ได้ภายใน 7 วันเท่านั้น
                            </td>
                        </tr>
                    </table>
                </div>
        <!-- <div>ขอบคุณที่ใช้บริการ</div>
        <div>โทร: 02-123-4567 | อีเมล: contact@example.com</div> -->
    </div>
    </div>

   
</body>
</html>