<?php
// require_once("sidebar.php");
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ระบบขาย POS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- <link rel="stylesheet" href="sidebar.css" /> -->
    <link rel="stylesheet" href="../includes/sidebar/sidebar.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* สไตล์หลัก */
        body {
            background: #f0f3ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .btn-background {
            background: linear-gradient(to right, #6a82fb, #fc5c7d);
        }

        .btn-background-primary {
            background: #6a82fb;
            color: white;
        }


        .product-card {
            background: white;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .badge-category {
            border-radius: 20px;
            padding: 6px 15px;
            margin: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .badge-category:hover {
            transform: scale(1.05);
        }

        .product-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .product-name {
            font-weight: bold;
        }

        .product-price {
            color: #dc3545;
            font-weight: bold;
        }

        .product-id {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .category-section {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        @media (max-width: 767.98px) {
            .main h4 {
                font-size: 1.2rem;
            }

            .category-section {
                justify-content: center;
            }
        }

        /* สไตล์สำหรับส่วน Order */
        .order-container {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .order-header {
            background: linear-gradient(to right, #6a82fb, #fc5c7d);
            color: white;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 15px;
        }

        .order-item {
            transition: background-color 0.3s;
            padding: 10px 15px;
        }

        .order-item:hover {
            background-color: #f8f9fa;
        }

        .order-list {
            flex-grow: 1;
            overflow-y: auto;
            max-height: 300px;
            margin-bottom: 15px;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .order-summary {
            border-top: 2px dashed #eee;
            padding-top: 15px;
            margin-top: auto;
        }

        .btn-pay {
            background: #00c896;
            color: white;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s;
            padding: 10px;
            border-radius: 8px;
            border: none;
            margin-top: 15px;
        }

        .btn-pay:hover {
            background: #00a87c;
            transform: scale(1.02);
        }

        .order-meta {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
        }

        .order-empty {
            text-align: center;
            padding: 30px 15px;
            color: #6c757d;
        }

        .order-empty i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.3;
        }

        .order-controls {
            display: flex;
            gap: 5px;
            margin-top: 8px;
        }

        .order-controls button {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .discount-input-group {
            margin-bottom: 15px;
        }

        .grand-total {
            font-size: 1.3rem;
            font-weight: bold;
            color: #28a745;
        }

        .api-status {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 10px 15px;
            border-radius: 5px;
            z-index: 2000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 767.98px) {
            .order-container {
                margin-top: 15px;
            }
        }
    </style>
</head>

<body>

    <!-- สถานะ API -->
    <div id="api-status" class="api-status d-none"></div>

    <!-- Sidebar -->
    <!-- <?php //include_once("sidebar.php"); ?> -->
    <?php include_once("../includes/sidebar/sidebar.php"); ?>

    <div class="main main-content" id="main-content">
        <div class="row">
            <!-- สินค้า -->
            <div class="col-md-8">
                <input type="text" id="search-input" class="form-control mb-2" placeholder="ค้นหาสินค้า..." oninput="filterProducts()">
                <div class="category-section" id="category-list">
                    <!-- หมวดหมู่จะถูกสร้างโดย JavaScript -->
                </div>

                <div class="row mt-3" id="product-list"></div>
            </div>

            <!-- ตะกร้า -->
            <div class="col-md-4">
                <!-- กล่องรายการสั่งซื้อ -->
                <div id="order-container" class="order-container">
                    <!-- ส่วนนี้จะถูกสร้างโดย Order UI -->
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->

    <!-- ไฟล์ JavaScript สำหรับคลาส Order -->
    <script src="../includes/sidebar/sidebar.js"></script>
    <script src="../includes/common.js"></script>
    <script src="orderComponent.js"></script>

    <script>
        // ฟังก์ชันช่วยสำหรับวันที่

        function updateThaiDate() {
            const inputDate = document.getElementById('order-date').value;
            document.getElementById('thai-date').value = getThaiDate(inputDate);
            // if (!inputDate) return;
            // document.getElementById('thai-date').value = getThaiDate(inputDate);
        }
        // ตั้งค่าเริ่มต้น - หน้าปรับยอดสต็อก
        // setActiveMenu('stock/adjust');
        // setActiveMenu('orders');

    </script>

    <!-- ไฟล์ JavaScript หลัก -->
    <script>
        // ข้อมูลหมวดหมู่สินค้า
        const categories = [{
                id: 1,
                name: 'ทั้งหมด',
                icon: '📦'
            },
            {
                id: 2,
                name: 'อาหาร',
                icon: '🍔'
            },
            {
                id: 3,
                name: 'เครื่องดื่ม',
                icon: '🥤'
            },
            {
                id: 4,
                name: 'ขนม',
                icon: '🍰'
            },
            {
                id: 5,
                name: 'ของใช้',
                icon: '🧴'
            }
        ];

        // ข้อมูลสินค้า
        const products = [{
                id: 101,
                name: 'ชาเขียว',
                price: 18,
                categoryId: 3,
                icon: '🍵',
                stock: 50
            },
            {
                id: 102,
                name: 'ไก่ทอด',
                price: 40,
                categoryId: 2,
                icon: '🍗',
                stock: 30
            },
            {
                id: 103,
                name: 'ป๊อปคอร์น',
                price: 25,
                categoryId: 4,
                icon: '🍿',
                stock: 40
            },
            {
                id: 104,
                name: 'ชานมไข่มุก',
                price: 35,
                categoryId: 3,
                icon: '🧋',
                stock: 45
            },
            {
                id: 105,
                name: 'กาแฟ',
                price: 30,
                categoryId: 3,
                icon: '☕',
                stock: 60
            },
            {
                id: 106,
                name: 'พิซซ่า',
                price: 120,
                categoryId: 2,
                icon: '🍕',
                stock: 25
            },
            {
                id: 107,
                name: 'ส้มตำ',
                price: 50,
                categoryId: 2,
                icon: '🥗',
                stock: 35
            },
            {
                id: 108,
                name: 'โดนัท',
                price: 20,
                categoryId: 4,
                icon: '🍩',
                stock: 55
            },
            {
                id: 109,
                name: 'น้ำเปล่า',
                price: 10,
                categoryId: 3,
                icon: '💧',
                stock: 100
            },
            {
                id: 110,
                name: 'สบู่',
                price: 10,
                categoryId: 5,
                icon: '🧼',
                stock: 70
            }
        ];

        // ตัวแปร global
        let currentOrder;
        let selectedCategoryId = 1; // เริ่มต้นด้วยหมวดหมู่ "ทั้งหมด"

        // ฟังก์ชันแสดงสถานะ API
        function showApiStatus(message, type) {
            const statusEl = document.getElementById('api-status');
            statusEl.textContent = message;
            statusEl.className = `api-status alert alert-${type}`;
            statusEl.classList.remove('d-none');

            // ซ่อนสถานะหลังจาก 3 วินาที
            setTimeout(() => {
                statusEl.classList.add('d-none');
            }, 3000);
        }

        // ฟังก์ชันจำลอง API สำหรับดึงข้อมูล order
        function mockOrderAPI() {
            return new Promise((resolve) => {
                // จำลองเวลาโหลดข้อมูล
                setTimeout(() => {
                    // สร้างข้อมูล order ตัวอย่าง
                    const orderData = {
                        orderNumber: "#API-20240515-001",
                        items: [{
                                id: 102,
                                quantity: 2
                            }, // ไก่ทอด 2 ชิ้น
                            {
                                id: 104,
                                quantity: 1
                            } // ชานมไข่มุก 1 แก้ว
                        ],
                        discountAmount: 5.00,
                        taxRate: 0.07
                    };
                    resolve(orderData);
                }, 1500);
            });
        }

        // ฟังก์ชันชำระเงิน (อยู่ที่หน้าหลัก)
        // function payOrder() {
        const payOrder = () => {
            if (!currentOrder.hasItems()) {
                Swal.fire('ไม่มีรายการ', 'กรุณาเลือกรายการก่อนชำระเงิน', 'warning');
                return;
            }

            Swal.fire({
                title: 'ยืนยันชำระเงิน?',
                html: `<p>ยอดชำระทั้งหมด: <b>฿${currentOrder.getGrandTotal().toFixed(2)}</b></p>
             <p>บิลเลขที่: <b>${currentOrder.orderNumber}</b></p>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00c896'
            }).then((result) => {
                if (result.isConfirmed) {
                    // สร้าง order ใหม่หลังชำระเงินเสร็จ
                    currentOrder.createNewOrder();

                    Swal.fire({
                        title: 'ชำระเงินสำเร็จ!',
                        text: `บิลเลขที่ ${currentOrder.orderNumber} ชำระเงินเรียบร้อย`,
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                        confirmButtonColor: '#00c896'
                    });
                }
            });
        }

        // ฟังก์ชันสำหรับแสดง/ซ่อนรายการสั่งซื้อบนมือถือ
        function toggleOrderBox() {
            const orderBox = document.getElementById('order-box');
            if (orderBox) orderBox.classList.toggle('show');
        }

        // ตั้งค่าประเภทสินค้าโดยใช้ ID
        function setCategory(categoryId) {
            selectedCategoryId = categoryId;
            renderCategories();
            filterProducts();
        }

        // แสดงหมวดหมู่สินค้า
        function renderCategories() {
            const container = document.getElementById('category-list');
            container.innerHTML = '';

            categories.forEach(category => {
                const isActive = category.id === selectedCategoryId;
                const badge = document.createElement('span');
                badge.className = `badge badge-${isActive ? 'primary' : 'light'} badge-category ${isActive ? 'active' : ''}`;
                badge.innerHTML = `${category.icon} ${category.name}`;
                badge.onclick = () => setCategory(category.id);
                container.appendChild(badge);
            });
        }

        // กรองสินค้า
        function filterProducts() {
            const search = document.getElementById('search-input').value.toLowerCase();
            const list = document.getElementById('product-list');
            list.innerHTML = '';

            const filtered = products.filter(p => {
                const matchCategory = selectedCategoryId === 1 || p.categoryId === selectedCategoryId;
                const matchSearch = p.name.toLowerCase().includes(search);
                return matchCategory && matchSearch;
            });

            if (filtered.length === 0) {
                list.innerHTML = `<div class="col-12 text-center text-muted py-4">
                          <i class="fas fa-search fa-2x mb-2"></i>
                          <p>ไม่พบสินค้าที่ค้นหา</p>
                        </div>`;
                return;
            }

            filtered.forEach(p => {
                const col = document.createElement('div');
                col.className = 'col-sm-4 col-6 mb-3';
                col.innerHTML = `
                    <div class="product-card" onclick="addToCart(${p.id})">
                    <div class="product-icon">${p.icon || '🛒'}</div>
                    <div class="product-name">${p.name}</div>
                    <div class="product-id">ID: ${p.id}</div>
                    <div class="product-price">฿${p.price.toFixed(2)}</div>
                    <small class="text-muted">${categories.find(c => c.id === p.categoryId)?.name || 'อื่นๆ'}</small>
                    </div>`;
                list.appendChild(col);
            });
        }

        // เพิ่มสินค้าในตะกร้าโดยใช้ productId
        function addToCart(productId) {
            currentOrder.addItem(productId);

            // แสดงแอนิเมชันเมื่อเพิ่มสินค้า
            const productCard = event.currentTarget;
            productCard.classList.add('animate__animated', 'animate__pulse');
            setTimeout(() => {
                productCard.classList.remove('animate__animated', 'animate__pulse');
            }, 500);
        }

        // อัพเดทเวลา
        function updateTime() {
            const now = new Date();
            document.getElementById('time').textContent = now.toLocaleTimeString();
        }

        // อัพเดทวันที่
        function updateDate() {
            const days = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'];
            const months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
                'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
            ];

            const now = new Date();
            const dayName = days[now.getDay()];
            const date = now.getDate();
            const monthName = months[now.getMonth()];
            const year = now.getFullYear() + 543;

            document.getElementById('date-display').textContent =
                `วัน${dayName}ที่ ${date} ${monthName} ${year}`;
        }

        // เริ่มต้นระบบ
        async function initialize() {
            // สร้าง order ใหม่
            // currentOrder = new Order();
            currentOrder = new Order(payOrder);

            // แสดงสถานะกำลังโหลด
            showApiStatus('กำลังโหลดข้อมูล order จาก API...', 'info');

            // โหลดข้อมูล order จาก API
            try {
                // ในระบบจริง: const orderData = await fetch('/api/current-order').then(res => res.json());
                const orderData = await mockOrderAPI();

                // โหลดข้อมูลลงใน order
                currentOrder.loadFromData(orderData);

                // แสดงสถานะสำเร็จ
                showApiStatus('โหลดข้อมูล order จาก API สำเร็จ!', 'success');
            } catch (error) {
                console.error('Failed to load order data:', error);
                showApiStatus('โหลดข้อมูล order ไม่สำเร็จ', 'danger');
            }

            // อัพเดทเวลาและวันที่
            updateTime();
            updateDate();
            setInterval(updateTime, 1000);

            // แสดงหมวดหมู่ สินค้า
            renderCategories();
            filterProducts();

            // ตั้งค่า container สำหรับ order
            const orderContainer = document.getElementById('order-container');
            currentOrder.setContainer(orderContainer);

            // ปิด sidebar เมื่อคลิกเนื้อหาหลัก
            document.getElementById('main-content').addEventListener('click', function() {
                if (document.getElementById('sidebar').classList.contains('show')) {
                    closeSidebar();
                }
            });
        }

        // เริ่มต้นระบบเมื่อหน้าเว็บโหลดเสร็จ
        window.addEventListener('DOMContentLoaded', initialize);
        
    </script>
    <!-- <script>
        setActiveMenu('../orders/index.php');
    </script> -->
</body>

</html>