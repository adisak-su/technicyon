<?php
// การตั้งค่าฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

// ตัวอย่างข้อมูลที่จะเพิ่ม (มีอักขระพิเศษ)
$products = [
    
    ['Laptop 15"', `Dell XPS 13333' screen`, 1599.99],
    ['Laptop 15"', 'Dell XPS 13\' screen', 1599.99],
    ['Smartphone', 'Samsung Galaxy S24"', 899.50],
    ['Headphones', 'Sony WH-1000XM5\'s', 349.99],
    ['Keyboard', 'Logitech MX Keys "Premium"', 129.95],
    ['Monitor', 'LG 27" 4K UHD\'s', 449.00]
];

// สร้างการเชื่อมต่อ
try {
    // $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn = new PDO("mysql:host=" . "localhost" . ";dbname=" . "technicyonnew", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // สร้างตารางถ้ายังไม่มี (สำหรับการทดสอบ)
    $conn->exec("CREATE TABLE IF NOT EXISTS productss (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL
    )");
    
    // เตรียมคำสั่ง SQL
    $sql = "INSERT INTO productss (name, description, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // เริ่ม transaction สำหรับประสิทธิภาพ
    $conn->beginTransaction();
    
    // เพิ่มข้อมูลทีละรายการ
    foreach ($products as $product) {
        $stmt->execute($product);
    }
    
    // ยืนยันการเพิ่มข้อมูล
    $conn->commit();
    
    echo "<div class='success'>เพิ่มข้อมูลสำเร็จ: " . count($products) . " รายการ</div>";
    
} catch(PDOException $e) {
    // ยกเลิก transaction หากเกิดข้อผิดพลาด
    $conn->rollBack();
    echo "<div class='error'>ข้อผิดพลาด: " . $e->getMessage() . "</div>";
}

// ปิดการเชื่อมต่อ
$conn = null;
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลหลายรายการใน MySQL</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f7fa;
        }
        
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 30px;
        }
        
        h1 {
            color: #2c3e50;
            text-align: center;
            border-bottom: 2px solid #3498db;
            padding-bottom: 15px;
        }
        
        .code-block {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            margin: 20px 0;
            font-family: 'Consolas', monospace;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
        }
        
        .explanation {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        
        .key-points {
            background: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        
        h2 {
            color: #2980b9;
            margin-top: 25px;
        }
        
        .note {
            background: #fff8e1;
            padding: 10px;
            border-left: 4px solid #ffc107;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>เพิ่มข้อมูลหลายรายการใน MySQL ด้วย PHP</h1>
        
        <div class="explanation">
            <h2>คำอธิบายหลักการ</h2>
            <p>โค้ดด้านบนสาธิตวิธีการเพิ่มข้อมูลหลายรายการพร้อมกันใน MySQL โดยใช้ PDO และ Prepared Statements ซึ่งเป็นวิธีที่ปลอดภัยและมีประสิทธิภาพ</p>
        </div>
        
        <div class="key-points">
            <h2>เหตุผลที่ใช้ Prepared Statements</h2>
            <ul>
                <li><strong>ป้องกัน SQL Injection</strong>: ป้องกันการโจมตีฐานข้อมูล</li>
                <li><strong>จัดการอักขระพิเศษอัตโนมัติ</strong>: ตัวแปรที่มี `'`, `"` จะถูกจัดการโดยอัตโนมัติ</li>
                <li><strong>ประสิทธิภาพสูงกว่า</strong>: โดยเฉพาะเมื่อเพิ่มข้อมูลหลายรายการ</li>
                <li><strong>ลดข้อผิดพลาด</strong>: ไม่ต้องกังวลกับการ escape อักขระด้วยตนเอง</li>
            </ul>
        </div>
        
        <h2>ส่วนสำคัญของโค้ด</h2>
        
        <div class="code-block">
// เตรียมคำสั่ง SQL (ใช้ placeholders ?)<br>
$sql = "INSERT INTO products (name, description, price) VALUES (?, ?, ?)";<br>
$stmt = $conn->prepare($sql);<br><br>

// เริ่ม transaction<br>
$conn->beginTransaction();<br><br>

// เพิ่มข้อมูลทีละรายการ<br>
foreach ($products as $product) {<br>
&nbsp;&nbsp;&nbsp;&nbsp;$stmt->execute($product);<br>
}<br><br>

// ยืนยันการเพิ่มข้อมูล<br>
$conn->commit();
        </div>
        
        <div class="note">
            <strong>คำแนะนำ:</strong> การใช้ Transaction ช่วยเพิ่มประสิทธิภาพเมื่อเพิ่มข้อมูลหลายรายการ และทำให้สามารถยกเลิกการเพิ่มทั้งหมดได้หากเกิดข้อผิดพลาด
        </div>
        
        <h2>ข้อมูลตัวอย่างที่เพิ่ม</h2>
        <ul>
            <li>Laptop 15" - Dell XPS 13' screen</li>
            <li>Smartphone - Samsung Galaxy S24"</li>
            <li>Headphones - Sony WH-1000XM5's</li>
            <li>Keyboard - Logitech MX Keys "Premium"</li>
            <li>Monitor - LG 27" 4K UHD's</li>
        </ul>
    </div>
</body>
</html>