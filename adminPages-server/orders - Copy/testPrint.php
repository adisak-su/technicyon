<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>พิมพ์ใบเสร็จ</title>
    <style>
        body {
            font-family: 'TH Sarabun New', 'Sarabun', sans-serif;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .btn-print {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
        }
        
        .btn-print:hover {
            background-color: #45a049;
        }
        
        @media print {
            body * {
                visibility: hidden;
            }
            .receipt, .receipt * {
                visibility: visible;
            }
            .receipt {
                position: absolute;
                left: 0;
                top: 0;
                width: 9in;
                height: 5.5in;
                padding: 10px;
                box-sizing: border-box;
                font-size: 14pt;
            }
            .no-print {
                display: none;
            }
        }
        
        .receipt {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            width: 9in;
            height: 5.5in;
            box-sizing: border-box;
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
        
        .items-table th {
            background-color: #f2f2f2;
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
</head>
<body>
    <div class="container">
        <button class="btn-print no-print" onclick="window.print()">พิมพ์ใบเสร็จ</button>
        
        <div class="receipt">
            <div class="header">
                <h2>ใบเสร็จรับเงิน</h2>
                <p>ร้านจำหน่ายอะไหล่รถยนต์</p>
            </div>
            
            <div class="order-info">
                <div>
                    <strong>เลขที่ใบเสร็จ:</strong> <span id="orderId"></span>
                </div>
                <div>
                    <strong>วันที่:</strong> <span id="orderDate"></span>
                </div>
            </div>
            
            <div class="customer-info">
                <p><strong>ชื่อลูกค้า:</strong> <span id="customerName"></span></p>
                <p><strong>ที่อยู่:</strong> <span id="customerAddress"></span></p>
                <p><strong>โทรศัพท์:</strong> <span id="customerTelephone"></span></p>
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
                <tbody id="orderItems">
                    
                </tbody>
            </table>
            
            <div class="total-section">
                <p>รวมทั้งหมด: <span id="partsTotal"></span> บาท</p>
                <p>ภาษีมูลค่าเพิ่ม (7%): <span id="vatValue"></span> บาท</p>
                <p>รวมสุทธิ: <span id="total"></span> บาท</p>
            </div>
            
            <div class="footer">
                <p>ขอบคุณที่ใช้บริการ</p>
                <p>โทร: 02-123-4567 | อีเมล: contact@example.com</p>
            </div>
        </div>
    </div>

    <script>
        // ข้อมูลจาก JSON
        const orderData = {
            "data": {
                "orderId": "F202524855",
                "orderDate": "2025-06-19",
                "customerId": "C000000033",
                "customerName": "บริษัทคม ฐาน ๙ รถยนต์ จำกัด # 0105551095117_สนญ.",
                "customerAddress": "6/3,6/4 ถ.กาญจนาภิเษก แขวงรามอินทรา เขตคันนายาว กทม.10230 # 0105551095117",
                "customerTelephone": "0897991784",
                "status": 0,
                "vat": 1,
                "typeSale": 1,
                "vatValue": 363.3,
                "partsTotal": 5190,
                "total": 5553.3,
                "orderItems": [
                    {
                        "id": "B55544M426",
                        "name": "AIR-BAG Nissan - นีโอ # B55544M426",
                        "price": 4830,
                        "quantity": 1,
                        "total": 4830
                    },
                    {
                        "id": "B056115561G",
                        "name": "กรองเครื่องแบบแท้ โฟล์ค",
                        "price": 180,
                        "quantity": 2,
                        "total": 360
                    }
                ]
            }
        };

        // จัดรูปแบบตัวเลขให้มีทศนิยม 2 ตำแหน่งและมี comma
        function formatNumber(num) {
            return num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        // แสดงข้อมูลในใบเสร็จ
        document.addEventListener('DOMContentLoaded', function() {
            // ข้อมูลทั่วไป
            document.getElementById('orderId').textContent = orderData.data.orderId;
            document.getElementById('orderDate').textContent = orderData.data.orderDate;
            document.getElementById('customerName').textContent = orderData.data.customerName;
            document.getElementById('customerAddress').textContent = orderData.data.customerAddress;
            document.getElementById('customerTelephone').textContent = orderData.data.customerTelephone;
            
            // ข้อมูลสินค้า
            const itemsTable = document.getElementById('orderItems');
            itemsTable.innerHTML = '';
            
            orderData.data.orderItems.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${item.name}</td>
                    <td>${formatNumber(item.price)}</td>
                    <td>${item.quantity}</td>
                    <td>${formatNumber(item.total)}</td>
                `;
                itemsTable.appendChild(row);
            });
            
            // ข้อมูลรวม
            document.getElementById('partsTotal').textContent = formatNumber(orderData.data.partsTotal);
            document.getElementById('vatValue').textContent = formatNumber(orderData.data.vatValue);
            document.getElementById('total').textContent = formatNumber(orderData.data.total);
        });
    </script>
</body>
</html>