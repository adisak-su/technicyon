<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>การเรียกใช้หลาย API พร้อมกันด้วย Axios</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        :root {
            --primary: #3498db;
            --secondary: #2ecc71;
            --accent: #e74c3c;
            --dark: #2c3e50;
            --light: #ecf0f1;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #1a2a6c);
            color: var(--light);
            min-height: 100vh;
            padding: 20px;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            text-align: center;
            padding: 40px 0;
            margin-bottom: 30px;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        h1 {
            font-size: 2.8rem;
            margin-bottom: 15px;
            color: #fff;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .subtitle {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto;
            color: #ddd;
        }
        
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        }
        
        .card h2 {
            color: var(--secondary);
            margin-bottom: 15px;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .card h2 i {
            font-size: 1.5rem;
        }
        
        .api-list {
            margin-top: 20px;
        }
        
        .api-item {
            background: rgba(0, 0, 0, 0.2);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        
        .api-item h3 {
            color: var(--primary);
            margin-bottom: 8px;
            font-size: 1.2rem;
        }
        
        .code-block {
            background: rgba(0, 0, 0, 0.4);
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
            font-size: 0.95rem;
        }
        
        .btn {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .btn:hover {
            background: #2980b9;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }
        
        .btn-run {
            background: var(--secondary);
            width: 100%;
            text-align: center;
            padding: 15px;
            font-size: 1.2rem;
        }
        
        .btn-run:hover {
            background: #27ae60;
        }
        
        .result-container {
            margin-top: 30px;
        }
        
        .result-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }
        
        .result-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            min-height: 250px;
        }
        
        .result-card h3 {
            color: var(--secondary);
            margin-bottom: 15px;
            font-size: 1.4rem;
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .result-content {
            max-height: 200px;
            overflow-y: auto;
            padding-right: 10px;
        }
        
        .result-content pre {
            white-space: pre-wrap;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            color: #ddd;
        }
        
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .status-loading {
            background: #f39c12;
            animation: pulse 1.5s infinite;
        }
        
        .status-success {
            background: #2ecc71;
        }
        
        .status-error {
            background: #e74c3c;
        }
        
        @keyframes pulse {
            0% { opacity: 0.5; }
            50% { opacity: 1; }
            100% { opacity: 0.5; }
        }
        
        .response-info {
            margin-top: 15px;
            padding: 10px;
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.2);
        }
        
        footer {
            text-align: center;
            margin-top: 50px;
            padding: 20px;
            color: #aaa;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .card-container {
                grid-template-columns: 1fr;
            }
            
            h1 {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>การเรียกใช้หลาย API พร้อมกันด้วย Axios</h1>
            <p class="subtitle">ตัวอย่างการเรียกใช้หลาย API จากเซิร์ฟเวอร์ PHP พร้อมกันด้วย Axios.all() และ Promise.all() ใน JavaScript</p>
        </header>
        
        <div class="card-container">
            <div class="card">
                <h2><i>📚</i> แนวคิด</h2>
                <p>เมื่อเราต้องการเรียกใช้หลาย API พร้อมกันเพื่อประสิทธิภาพสูงสุด เราสามารถใช้:</p>
                <ul>
                    <li><strong>axios.all()</strong> - ฟังก์ชันพิเศษจาก Axios (แต่ถูก deprecated แล้ว)</li>
                    <li><strong>Promise.all()</strong> - วิธีมาตรฐานใน JavaScript</li>
                </ul>
                <p>โดยเราจะส่งอาร์เรย์ของ Promise ไปยัง Promise.all() และจะได้ผลลัพธ์เป็นอาร์เรย์ของ response เมื่อทุก request เสร็จสิ้น</p>
            </div>
            
            <div class="card">
                <h2><i>⚙️</i> API ตัวอย่าง</h2>
                <p>เราจะเรียกใช้ 3 API พร้อมกันจากเซิร์ฟเวอร์ PHP:</p>
                <div class="api-list">
                    <div class="api-item">
                        <h3>1. ข้อมูลผู้ใช้</h3>
                        <p><strong>Endpoint:</strong> /api/users.php</p>
                        <p>ส่งคืนข้อมูลผู้ใช้ตัวอย่าง</p>
                    </div>
                    <div class="api-item">
                        <h3>2. ข้อมูลสินค้า</h3>
                        <p><strong>Endpoint:</strong> /api/products.php</p>
                        <p>ส่งคืนรายการสินค้า</p>
                    </div>
                    <div class="api-item">
                        <h3>3. ข้อมูลคำสั่งซื้อ</h3>
                        <p><strong>Endpoint:</strong> /api/orders.php</p>
                        <p>ส่งคืนประวัติคำสั่งซื้อ</p>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <h2><i>💻</i> โค้ด JavaScript</h2>
                <p>ใช้ Axios กับ Promise.all()</p>
                <div class="code-block">
// สร้าง array ของ Promise สำหรับแต่ละ API
const requests = [
    axios.get('/api/users.php'),
    axios.get('/api/products.php'),
    axios.get('/api/orders.php')
];

// เรียกใช้ทุก API พร้อมกัน
Promise.all(requests)
    .then(responses => {
        // responses[0] = ข้อมูลผู้ใช้
        // responses[1] = ข้อมูลสินค้า
        // responses[2] = ข้อมูลคำสั่งซื้อ
        
        console.log('ข้อมูลผู้ใช้:', responses[0].data);
        console.log('ข้อมูลสินค้า:', responses[1].data);
        console.log('ข้อมูลคำสั่งซื้อ:', responses[2].data);
    })
    .catch(error => {
        console.error('เกิดข้อผิดพลาด:', error);
    });
                </div>
            </div>
        </div>
        
        <div class="btn btn-run" id="runButton">เรียกใช้ API พร้อมกัน</div>
        
        <div class="result-container">
            <h2 style="text-align: center; margin: 30px 0; color: var(--secondary);">ผลลัพธ์การเรียกใช้ API</h2>
            <div class="result-grid">
                <div class="result-card">
                    <h3>ข้อมูลผู้ใช้ <span class="status-indicator" id="userStatus"></span><span id="userCount"></span></h3>
                    <div class="result-content" id="userResult">
                        <p>กดปุ่ม "เรียกใช้ API พร้อมกัน" เพื่อเริ่ม</p>
                    </div>
                </div>
                <div class="result-card">
                    <h3>ข้อมูลสินค้า <span class="status-indicator" id="productStatus"></span><span id="productCount"></span></h3>
                    <div class="result-content" id="productResult">
                        <p>กดปุ่ม "เรียกใช้ API พร้อมกัน" เพื่อเริ่ม</p>
                    </div>
                </div>
                <div class="result-card">
                    <h3>ข้อมูลคำสั่งซื้อ <span class="status-indicator" id="orderStatus"></span><span id="orderCount"></span></h3>
                    <div class="result-content" id="orderResult">
                        <p>กดปุ่ม "เรียกใช้ API พร้อมกัน" เพื่อเริ่ม</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        <p>ตัวอย่างการใช้งาน Axios กับ PHP | พัฒนาด้วย HTML, CSS, JavaScript และ Axios</p>
    </footer>

    <script>
        document.getElementById('runButton').addEventListener('click', async function() {
            const btn = this;
            btn.textContent = 'กำลังเรียกใช้ API...';
            btn.disabled = true;
            
            // รีเซ็ตสถานะ
            document.getElementById('userStatus').className = 'status-indicator status-loading';
            document.getElementById('productStatus').className = 'status-indicator status-loading';
            document.getElementById('orderStatus').className = 'status-indicator status-loading';
            
            // รีเซ็ตผลลัพธ์
            document.getElementById('userResult').innerHTML = '<p>กำลังโหลดข้อมูล...</p>';
            document.getElementById('productResult').innerHTML = '<p>กำลังโหลดข้อมูล...</p>';
            document.getElementById('orderResult').innerHTML = '<p>กำลังโหลดข้อมูล...</p>';
            
            try {
                // สร้าง array ของ Promise สำหรับแต่ละ API
                const requests = [
                    axios.get('api/products.php'),
                    axios.get('api/usercars.php'),
                    axios.get('api/typenames.php'),
                    axios.get('api/groupnames.php'),
                    axios.get('api/customers.php'),
                    axios.get('api/suppliers.php'),
                ];
                
                // เรียกใช้ทุก API พร้อมกัน
                const responses = await Promise.all(requests);
                
                // ข้อมูลผู้ใช้
                document.getElementById('userStatus').className = 'status-indicator status-success';
                const users = responses[0].data;
                document.getElementById('userCount').innerHTML = users.length;
                let userHtml = '';
                users.forEach(item => {
                    userHtml += `<div class="response-info">
                        <p><strong>${item.groupname}</strong></p>
                    </div>`;
                });
                document.getElementById('userResult').innerHTML = userHtml;
                
                // ข้อมูลสินค้า
                document.getElementById('productStatus').className = 'status-indicator status-success';
                const products = responses[1].data;
                document.getElementById('productCount').innerHTML = products.length;
                let productHtml = '';
                products.forEach(item => {
                    productHtml += `<div class="response-info">
                        <p><strong>${item.typename}</strong></p>
                    </div>`;
                });
                document.getElementById('productResult').innerHTML = productHtml;
                
                // ข้อมูลคำสั่งซื้อ
                document.getElementById('orderStatus').className = 'status-indicator status-success';
                const orders = responses[2].data;
                document.getElementById('orderCount').innerHTML = orders.length;
                let orderHtml = '';
                orders.forEach(item => {
                    orderHtml += `<div class="response-info">
                        <p><strong>${item.productId}</strong></p>
                    </div>`;
                });
                document.getElementById('orderResult').innerHTML = orderHtml;
                

                btn.textContent = 'เรียกใช้ API พร้อมกันสำเร็จ!';
                setTimeout(() => {
                    btn.textContent = 'เรียกใช้ API พร้อมกัน';
                    btn.disabled = false;
                }, 2000);
            } catch (error) {
                console.error('เกิดข้อผิดพลาด:', error);
                
                document.getElementById('userStatus').className = 'status-indicator status-error';
                document.getElementById('productStatus').className = 'status-indicator status-error';
                document.getElementById('orderStatus').className = 'status-indicator status-error';
                
                document.getElementById('userResult').innerHTML = `<p class="error">เกิดข้อผิดพลาด: ${error.message}</p>`;
                document.getElementById('productResult').innerHTML = `<p class="error">เกิดข้อผิดพลาด: ${error.message}</p>`;
                document.getElementById('orderResult').innerHTML = `<p class="error">เกิดข้อผิดพลาด: ${error.message}</p>`;
                
                btn.textContent = 'เกิดข้อผิดพลาด - ลองอีกครั้ง';
                btn.disabled = false;
            }
        });
    </script>
</body>
</html>