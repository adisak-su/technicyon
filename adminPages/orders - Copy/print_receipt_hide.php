<?php
// รับ orderId จาก URL
$orderId = $_GET['orderId'] ?? '';

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
                'quantity' => 1,
                'total' => 4830
            ],
            [
                'id' => 'B056115561G',
                'name' => 'กรองเครื่องแบบแท้ โฟล์ค',
                'price' => 180,
                'quantity' => 2,
                'total' => 360
            ]
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
            size: 9in 5.5in;
            margin: 0;
        }
        body {
            font-family: 'TH Sarabun New', sans-serif;
            width: 9in;
            height: 5.5in;
            padding: 0.5in;
            box-sizing: border-box;
            margin: 0;
            font-size: 14pt;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        .customer-info {
            margin-bottom: 15px;
        }
        .order-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }
        .total-section {
            text-align: right;
            margin-top: 10px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            border-top: 1px dashed #000;
            padding-top: 10px;
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
    <div class="header">
        <h2>ใบเสร็จรับเงิน</h2>
        <p>ร้านจำหน่ายอะไหล่รถยนต์</p>
    </div>
    
    <div class="order-info">
        <div>
            <strong>เลขที่ใบเสร็จ:</strong> <?php echo $orderData['data']['orderId']; ?>
        </div>
        <div>
            <strong>วันที่:</strong> <?php echo $orderData['data']['orderDate']; ?>
        </div>
    </div>
    
    <div class="customer-info">
        <p><strong>ชื่อลูกค้า:</strong> <?php echo $orderData['data']['customerName']; ?></p>
        <p><strong>ที่อยู่:</strong> <?php echo $orderData['data']['customerAddress']; ?></p>
        <p><strong>โทรศัพท์:</strong> <?php echo $orderData['data']['customerTelephone']; ?></p>
    </div>
    
    <table class="items-table">
        <thead>
            <tr>
                <th width="10%">ลำดับ</th>
                <th width="40%">รายการ</th>
                <th width="15%">ราคา</th>
                <th width="15%">จำนวน</th>
                <th width="20%">รวม</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orderData['data']['orderItems'] as $index => $item): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo number_format($item['price'], 2); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo number_format($item['total'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="total-section">
        <p>รวมทั้งหมด: <?php echo number_format($orderData['data']['partsTotal'], 2); ?> บาท</p>
        <p>ภาษีมูลค่าเพิ่ม (7%): <?php echo number_format($orderData['data']['vatValue'], 2); ?> บาท</p>
        <p>รวมสุทธิ: <?php echo number_format($orderData['data']['total'], 2); ?> บาท</p>
    </div>
    
    <div class="footer">
        <p>ขอบคุณที่ใช้บริการ</p>
        <p>โทร: 02-123-4567 | อีเมล: contact@example.com</p>
    </div>
</body>
</html>