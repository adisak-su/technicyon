<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการสินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .table-responsive {
            margin-top: 20px;
        }
        .price-column {
            text-align: right;
        }
        .action-column {
            width: 120px;
            text-align: center;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .filter-section {
            margin-bottom: 15px;
        }
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
    </style>
    <style>
    .menu-item {
        transition: all 0.3s ease;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
    }
    .menu-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        background-color: white;
    }
    .icon-container {
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .menu-text {
        font-size: 1.1rem;
        font-weight: 500;
        color: #333;
    }
</style>
<style>
    @media (max-width: 768px) {
        .menu-text {
            font-size: 0.9rem;
        }
        .icon-container i {
            font-size: 1.5rem !important;
        }
    }
</style>
</head>
<body>
<div class="container text-center my-5">
    <div class="row">
        <!-- เมนูที่ 1 -->
        <div class="col-md-3 mb-4">
            <a href="#" class="text-decoration-none">
                <div class="menu-item rounded-3 shadow-sm">
                    <div class="icon-container">
                        <i class="bi bi-house-door-fill fs-1 text-primary"></i>
                    </div>
                    <div class="menu-text">หน้าหลัก</div>
                </div>
            </a>
        </div>
        
        <!-- เมนูที่ 2 -->
        <div class="col-md-3 mb-4">
            <a href="#" class="text-decoration-none">
                <div class="menu-item p-3 rounded-3 shadow-sm">
                    <div class="icon-container mb-2">
                        <i class="bi bi-box-seam-fill fs-1 text-success"></i>
                    </div>
                    <div class="menu-text">สินค้า</div>
                </div>
            </a>
        </div>
        
        <!-- เมนูที่ 3 -->
        <div class="col-md-3 mb-4">
            <a href="#" class="text-decoration-none">
                <div class="menu-item p-3 rounded-3 shadow-sm">
                    <div class="icon-container mb-2">
                        <i class="bi bi-graph-up-arrow fs-1 text-info"></i>
                    </div>
                    <div class="menu-text">รายงาน</div>
                </div>
            </a>
        </div>
        
        <!-- เมนูที่ 4 -->
        <div class="col-md-3 mb-4">
            <a href="#" class="text-decoration-none">
                <div class="menu-item p-3 rounded-3 shadow-sm">
                    <div class="icon-container mb-2">
                        <i class="bi bi-gear-fill fs-1 text-warning"></i>
                    </div>
                    <div class="menu-text">ตั้งค่า</div>
                </div>
            </a>
        </div>
    </div>
</div>



<div class="container my-5">
    <div class="row">
        <div class="col-md-3">
            <div class="d-flex flex-column gap-3">
                <!-- เมนูที่ 1 -->
                <a href="#" class="text-decoration-none">
                    <div class="menu-item p-3 rounded-3 shadow-sm text-center">
                        <div class="icon-container mb-2">
                            <i class="bi bi-house-door-fill fs-1 text-primary"></i>
                        </div>
                        <div class="menu-text">หน้าหลัก</div>
                    </div>
                </a>
                
                <!-- เมนูที่ 2 -->
                <a href="#" class="text-decoration-none">
                    <div class="menu-item p-3 rounded-3 shadow-sm text-center">
                        <div class="icon-container mb-2">
                            <i class="bi bi-box-seam-fill fs-1 text-success"></i>
                        </div>
                        <div class="menu-text">สินค้า</div>
                    </div>
                </a>
                
                <!-- เมนูที่ 3 -->
                <a href="#" class="text-decoration-none">
                    <div class="menu-item p-3 rounded-3 shadow-sm text-center">
                        <div class="icon-container mb-2">
                            <i class="bi bi-graph-up-arrow fs-1 text-info"></i>
                        </div>
                        <div class="menu-text">รายงาน</div>
                    </div>
                </a>
                
                <!-- เมนูที่ 4 -->
                <a href="#" class="text-decoration-none">
                    <div class="menu-item p-3 rounded-3 shadow-sm text-center">
                        <div class="icon-container mb-2">
                            <i class="bi bi-gear-fill fs-1 text-warning"></i>
                        </div>
                        <div class="menu-text">ตั้งค่า</div>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="container my-5">
    <div class="row row-cols-2 row-cols-md-4 g-4">
        <!-- เมนูที่ 1 -->
        <div class="col">
            <a href="#" class="text-decoration-none">
                <div class="menu-item p-3 rounded-3 shadow-sm text-center h-100">
                    <div class="icon-container mb-2">
                        <i class="bi bi-house-door-fill fs-1 text-primary"></i>
                    </div>
                    <div class="menu-text">หน้าหลัก</div>
                </div>
            </a>
        </div>
        
        <!-- เมนูที่ 2 -->
        <div class="col">
            <a href="#" class="text-decoration-none">
                <div class="menu-item p-3 rounded-3 shadow-sm text-center h-100">
                    <div class="icon-container mb-2">
                        <i class="bi bi-box-seam-fill fs-1 text-success"></i>
                    </div>
                    <div class="menu-text">สินค้า</div>
                </div>
            </a>
        </div>
        
        <!-- เมนูที่ 3 -->
        <div class="col">
            <a href="#" class="text-decoration-none">
                <div class="menu-item p-3 rounded-3 shadow-sm text-center h-100">
                    <div class="icon-container mb-2">
                        <i class="bi bi-graph-up-arrow fs-1 text-info"></i>
                    </div>
                    <div class="menu-text">รายงาน</div>
                    <div class="badge bg-danger rounded-pill">ใหม่</div>
                </div>
            </a>
        </div>
        
        <!-- เมนูที่ 4 -->
        <div class="col">
            <a href="#" class="text-decoration-none">
                <div class="menu-item p-3 rounded-3 shadow-sm text-center h-100">
                    <div class="icon-container mb-2">
                        <i class="bi bi-gear-fill fs-1 text-warning"></i>
                    </div>
                    <div class="menu-text">ตั้งค่า</div>
                </div>
            </a>
        </div>
    </div>
</div>


        
        <div class="col-md-9">
            <!-- เนื้อหาหลัก -->
            <div class="p-4 bg-light rounded-3">
                <h2>เนื้อหาหลัก</h2>
                <p>ส่วนนี้คือพื้นที่แสดงเนื้อหาหลักของหน้าเว็บ</p>
            </div>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="bi bi-shop"></i> ระบบจัดการสินค้า
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="bi bi-house-door"></i> หน้าหลัก
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-box-seam"></i> จัดการสินค้า
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-graph-up"></i> รายงาน
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-gear"></i> ตั้งค่าระบบ
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <div class="container mt-4">
        <div class="header-container">
            <h1><i class="bi bi-box-seam"></i> ระบบจัดการสินค้า</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal" onclick="openAddModal()">
                <i class="bi bi-plus-circle"></i> เพิ่มสินค้าใหม่
            </button>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row filter-section">
                    <div class="col-md-3">
                        <label for="typeFilter" class="form-label">ประเภทสินค้า</label>
                        <select id="typeFilter" class="form-select">
                            <option value="">ทั้งหมด</option>
                            <option value="อิเล็กทรอนิกส์">อิเล็กทรอนิกส์</option>
                            <option value="เครื่องใช้ในบ้าน">เครื่องใช้ในบ้าน</option>
                            <option value="เสื้อผ้า">เสื้อผ้า</option>
                            <option value="ของเล่น">ของเล่น</option>
                            <option value="อาหาร">อาหาร</option>
                            <option value="เครื่องดื่ม">เครื่องดื่ม</option>
                            <option value="เครื่องสำอาง">เครื่องสำอาง</option>
                            <option value="หนังสือ">หนังสือ</option>
                            <option value="กีฬา">กีฬา</option>
                            <option value="สัตว์เลี้ยง">สัตว์เลี้ยง</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="priceRange" class="form-label">ช่วงราคา</label>
                        <select id="priceRange" class="form-select">
                            <option value="">ทั้งหมด</option>
                            <option value="0-500">0 - 500 บาท</option>
                            <option value="501-1000">501 - 1,000 บาท</option>
                            <option value="1001-2000">1,001 - 2,000 บาท</option>
                            <option value="2001-5000">2,001 - 5,000 บาท</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="searchInput" class="form-label">ค้นหา</label>
                        <input type="text" id="searchInput" class="form-control" placeholder="ค้นหาด้วยชื่อหรือรหัสสินค้า...">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button id="resetFilter" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-counterclockwise"></i> ล้างฟิลเตอร์
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="productsTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>รหัสสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th class="price-column">ราคา (บาท)</th>
                                <th>ประเภท</th>
                                <th>กลุ่มสินค้า</th>
                                <th>แก้ไขล่าสุด</th>
                                <th class="action-column">การดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- ข้อมูลจะถูกโหลดผ่าน JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal สำหรับเพิ่ม/แก้ไขสินค้า -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">เพิ่มสินค้าใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm">
                        <input type="hidden" id="editMode" value="add">
                        <input type="hidden" id="originalProductId">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="productId" class="form-label">รหัสสินค้า</label>
                                <input type="text" class="form-control" id="productId" required>
                                <div class="invalid-feedback">กรุณากรอกรหัสสินค้า</div>
                            </div>
                            <div class="col-md-6">
                                <label for="productName" class="form-label">ชื่อสินค้า</label>
                                <input type="text" class="form-control" id="productName" required>
                                <div class="invalid-feedback">กรุณากรอกชื่อสินค้า</div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="price" class="form-label">ราคา (บาท)</label>
                                <input type="number" step="0.01" class="form-control" id="price" required>
                                <div class="invalid-feedback">กรุณากรอกราคาที่ถูกต้อง</div>
                            </div>
                            <div class="col-md-6">
                                <label for="typeName" class="form-label">ประเภทสินค้า</label>
                                <select class="form-select" id="typeName" required>
                                    <option value="">เลือกประเภทสินค้า</option>
                                    <option value="อิเล็กทรอนิกส์">อิเล็กทรอนิกส์</option>
                                    <option value="เครื่องใช้ในบ้าน">เครื่องใช้ในบ้าน</option>
                                    <option value="เสื้อผ้า">เสื้อผ้า</option>
                                    <option value="ของเล่น">ของเล่น</option>
                                    <option value="อาหาร">อาหาร</option>
                                    <option value="เครื่องดื่ม">เครื่องดื่ม</option>
                                    <option value="เครื่องสำอาง">เครื่องสำอาง</option>
                                    <option value="หนังสือ">หนังสือ</option>
                                    <option value="กีฬา">กีฬา</option>
                                    <option value="สัตว์เลี้ยง">สัตว์เลี้ยง</option>
                                </select>
                                <div class="invalid-feedback">กรุณาเลือกประเภทสินค้า</div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="groupName" class="form-label">กลุ่มสินค้า</label>
                                <input type="text" class="form-control" id="groupName" required>
                                <div class="invalid-feedback">กรุณากรอกกลุ่มสินค้า</div>
                            </div>
                            <div class="col-md-6">
                                <label for="updatedAt" class="form-label">เวลาที่แก้ไข</label>
                                <input type="datetime-local" class="form-control" id="updatedAt" required>
                                <div class="invalid-feedback">กรุณากรอกเวลาที่แก้ไข</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary" id="saveProductBtn">บันทึกข้อมูล</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal สำหรับยืนยันการลบ -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">ยืนยันการลบสินค้า</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>คุณแน่ใจว่าต้องการลบสินค้า <strong id="productToDelete"></strong> ใช่หรือไม่?</p>
                    <p class="text-danger">การดำเนินการนี้ไม่สามารถยกเลิกได้!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">ลบสินค้า</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!--
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    -->
    <script>
           // ข้อมูลสินค้า
        let products = [];
        
        // ฟังก์ชันสร้างข้อมูลสินค้า
        function generateProducts() {
            const productTypes = ["อิเล็กทรอนิกส์", "เครื่องใช้ในบ้าน", "เสื้อผ้า", "ของเล่น", "อาหาร", "เครื่องดื่ม", "เครื่องสำอาง", "หนังสือ", "กีฬา", "สัตว์เลี้ยง"];
            
            const productGroups = {
                "อิเล็กทรอนิกส์": ["โทรศัพท์", "คอมพิวเตอร์", "ทีวี", "เครื่องเสียง", "อุปกรณ์เชื่อมต่อ"],
                "เครื่องใช้ในบ้าน": ["เฟอร์นิเจอร์", "เครื่องครัว", "เครื่องซักผ้า", "เครื่องทำความสะอาด"],
                "เสื้อผ้า": ["เสื้อ", "กางเกง", "รองเท้า", "กระเป๋า", "เครื่องประดับ"],
                "ของเล่น": ["ของเล่นเด็ก", "บอร์ดเกม", "ของสะสม", "ของเล่นการศึกษา"],
                "อาหาร": ["ขนม", "อาหารกระป๋อง", "อาหารแห้ง", "อาหารแช่แข็ง"],
                "เครื่องดื่ม": ["น้ำอัดลม", "น้ำผลไม้", "ชา", "กาแฟ", "เครื่องดื่มชูกำลัง"],
                "เครื่องสำอาง": ["สกินแคร์", "เครื่องสำอางหน้า", "เครื่องสำอางตา", "ผลิตภัณฑ์อาบน้ำ"],
                "หนังสือ": ["นวนิยาย", "หนังสือเรียน", "นิตยสาร", "การ์ตูน"],
                "กีฬา": ["อุปกรณ์ฟิตเนส", "อุปกรณ์กีฬา", "ชุดกีฬา", "รองเท้ากีฬา"],
                "สัตว์เลี้ยง": ["อาหารสัตว์", "ของเล่นสัตว์", "อุปกรณ์เลี้ยงสัตว์", "ผลิตภัณฑ์ทำความสะอาด"]
            };

            const newProducts = [];
            const now = new Date();
            
            for (let i = 1; i <= 1000; i++) {
                const productId = `PD${i.toString().padStart(5, '0')}`;
                const typeName = productTypes[Math.floor(Math.random() * productTypes.length)];
                const groupName = productGroups[typeName][Math.floor(Math.random() * productGroups[typeName].length)];
                const productName = `${groupName} ${['Premium', 'Deluxe', 'Standard', 'Basic'][Math.floor(Math.random() * 4)]} ${Math.floor(Math.random() * 1000) + 1}`;
                const price = parseFloat((Math.random() * 5000 + 50).toFixed(2));
                
                // สุ่มวันที่ในช่วง 2 ปีที่ผ่านมา
                const randomDays = Math.floor(Math.random() * 730);
                const updatedAt = new Date(now - randomDays * 24 * 60 * 60 * 1000);
                const formattedDate = updatedAt.toISOString().replace('T', ' ').substring(0, 19);
                
                newProducts.push({
                    productId,
                    productName,
                    price,
                    typeName,
                    groupName,
                    updatedAt: formattedDate
                });
            }
            
            return newProducts;
        }
        // Initialize DataTable
        let table;
        $(document).ready(function() {
            
            // สร้างข้อมูลสินค้า
            //alert(products.length);
            products = generateProducts();
            //alert(products.length);
            
            // Initialize DataTable
            table = $('#productsTable').DataTable({
                data: products,
                columns: [
                    { data: 'productId' },
                    { data: 'productName' },
                    { 
                        data: 'price',
                        render: function(data, type, row) {
                            return data.toLocaleString('th-TH', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        },
                        className: 'price-column'
                    },
                    { data: 'typeName' },
                    { data: 'groupName' },
                    { data: 'updatedAt' },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" onclick="openEditModal('${row.productId}')">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" onclick="openDeleteModal('${row.productId}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                        },
                        orderable: false,
                        className: 'action-column'
                    }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/th.json'
                },
                pageLength: 25,
                responsive: true
            });

            // ฟังก์ชันค้นหา
            $('#searchInput').keyup(function() {
                table.search(this.value).draw();
            });

            // ฟังก์ชันกรองประเภทสินค้า
            $('#typeFilter').change(function() {
                table.column(3).search(this.value).draw();
            });

            // ฟังก์ชันกรองช่วงราคา
            $('#priceRange').change(function() {
                const range = this.value;
                if (range === '') {
                    table.column(2).search('').draw();
                    return;
                }
                
                const [min, max] = range.split('-').map(Number);
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        const price = parseFloat(data[2].replace(/,/g, ''));
                        return price >= min && price <= max;
                    }
                );
                table.draw();
                $.fn.dataTable.ext.search.pop();
            });

            // ฟังก์ชันรีเซ็ตฟิลเตอร์
            $('#resetFilter').click(function() {
                $('#typeFilter').val('');
                $('#priceRange').val('');
                $('#searchInput').val('');
                table.search('').columns().search('').draw();
            });

            // ฟังก์ชันบันทึกสินค้า
            $('#saveProductBtn').click(saveProduct);

            // ฟังก์ชันลบสินค้า
            $('#confirmDeleteBtn').click(function() {
                deleteProduct($(this).data('productId'));
            });
        });
    /*
        // ข้อมูลสินค้า
        let products = [];
        alert(1);
        // ฟังก์ชันสร้างข้อมูลสินค้า
        function generateProducts() {
            const productTypes = ["อิเล็กทรอนิกส์", "เครื่องใช้ในบ้าน", "เสื้อผ้า", "ของเล่น", "อาหาร", "เครื่องดื่ม", "เครื่องสำอาง", "หนังสือ", "กีฬา", "สัตว์เลี้ยง"];
            
            const productGroups = {
                "อิเล็กทรอนิกส์": ["โทรศัพท์", "คอมพิวเตอร์", "ทีวี", "เครื่องเสียง", "อุปกรณ์เชื่อมต่อ"],
                "เครื่องใช้ในบ้าน": ["เฟอร์นิเจอร์", "เครื่องครัว", "เครื่องซักผ้า", "เครื่องทำความสะอาด"],
                "เสื้อผ้า": ["เสื้อ", "กางเกง", "รองเท้า", "กระเป๋า", "เครื่องประดับ"],
                "ของเล่น": ["ของเล่นเด็ก", "บอร์ดเกม", "ของสะสม", "ของเล่นการศึกษา"],
                "อาหาร": ["ขนม", "อาหารกระป๋อง", "อาหารแห้ง", "อาหารแช่แข็ง"],
                "เครื่องดื่ม": ["น้ำอัดลม", "น้ำผลไม้", "ชา", "กาแฟ", "เครื่องดื่มชูกำลัง"],
                "เครื่องสำอาง": ["สกินแคร์", "เครื่องสำอางหน้า", "เครื่องสำอางตา", "ผลิตภัณฑ์อาบน้ำ"],
                "หนังสือ": ["นวนิยาย", "หนังสือเรียน", "นิตยสาร", "การ์ตูน"],
                "กีฬา": ["อุปกรณ์ฟิตเนส", "อุปกรณ์กีฬา", "ชุดกีฬา", "รองเท้ากีฬา"],
                "สัตว์เลี้ยง": ["อาหารสัตว์", "ของเล่นสัตว์", "อุปกรณ์เลี้ยงสัตว์", "ผลิตภัณฑ์ทำความสะอาด"]
            };

            const newProducts = [];
            const now = new Date();
            
            for (let i = 1; i <= 1000; i++) {
                const productId = `PD${i.toString().padStart(5, '0')}`;
                const typeName = productTypes[Math.floor(Math.random() * productTypes.length)];
                const groupName = productGroups[typeName][Math.floor(Math.random() * productGroups[typeName].length)];
                const productName = `${groupName} ${['Premium', 'Deluxe', 'Standard', 'Basic'][Math.floor(Math.random() * 4)]} ${Math.floor(Math.random() * 1000) + 1}`;
                const price = parseFloat((Math.random() * 5000 + 50).toFixed(2));
                
                // สุ่มวันที่ในช่วง 2 ปีที่ผ่านมา
                const randomDays = Math.floor(Math.random() * 730);
                const updatedAt = new Date(now - randomDays * 24 * 60 * 60 * 1000);
                const formattedDate = updatedAt.toISOString().replace('T', ' ').substring(0, 19);
                
                newProducts.push({
                    productId,
                    productName,
                    price,
                    typeName,
                    groupName,
                    updatedAt: formattedDate
                });
            }
            
            return newProducts;
        }

        // ฟังก์ชันเปิด Modal เพิ่มสินค้า
        function openAddModal() {
            $('#editMode').val('add');
            $('#productForm')[0].reset();
            $('#productModalLabel').text('เพิ่มสินค้าใหม่');
            $('#productId').prop('disabled', false);
            
            // สร้างรหัสสินค้าอัตโนมัติถ้าเป็นโหมดเพิ่ม
            if ($('#editMode').val() === 'add') {
                const nextId = products.length > 0 ? 
                    Math.max(...products.map(p => parseInt(p.productId.substring(2))) + 1 : 1;
                $('#productId').val(`PD${nextId.toString().padStart(5, '0')}`);
            }
            
            // ตั้งค่าวันที่ปัจจุบัน
            const now = new Date();
            const formattedDate = now.toISOString().slice(0, 16);
            $('#updatedAt').val(formattedDate);
        }

        // ฟังก์ชันเปิด Modal แก้ไขสินค้า
        function openEditModal(productId) {
            const product = products.find(p => p.productId === productId);
            if (!product) return;
            
            $('#editMode').val('edit');
            $('#productModalLabel').text('แก้ไขสินค้า');
            $('#originalProductId').val(product.productId);
            
            // กรอกข้อมูลในฟอร์ม
            $('#productId').val(product.productId);
            $('#productName').val(product.productName);
            $('#price').val(product.price);
            $('#typeName').val(product.typeName);
            $('#groupName').val(product.groupName);
            
            // แปลงรูปแบบวันที่ให้ตรงกับ input datetime-local
            const date = new Date(product.updatedAt);
            const formattedDate = date.toISOString().slice(0, 16);
            $('#updatedAt').val(formattedDate);
            
            // ปิดการแก้ไขรหัสสินค้า
            $('#productId').prop('disabled', true);
            
            // แสดง Modal
            const modal = new bootstrap.Modal(document.getElementById('productModal'));
            modal.show();
        }

        // ฟังก์ชันเปิด Modal ยืนยันการลบ
        function openDeleteModal(productId) {
            const product = products.find(p => p.productId === productId);
            if (!product) return;
            
            $('#productToDelete').text(`${product.productId} - ${product.productName}`);
            $('#confirmDeleteBtn').data('productId', productId);
            
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        }

        // ฟังก์ชันบันทึกสินค้า
        function saveProduct() {
            const form = $('#productForm')[0];
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }
            
            const productData = {
                productId: $('#productId').val(),
                productName: $('#productName').val(),
                price: parseFloat($('#price').val()),
                typeName: $('#typeName').val(),
                groupName: $('#groupName').val(),
                updatedAt: $('#updatedAt').val().replace('T', ' ') + ':00'
            };
            
            if ($('#editMode').val() === 'add') {
                // เพิ่มสินค้าใหม่
                products.push(productData);
            } else {
                // แก้ไขสินค้า
                const index = products.findIndex(p => p.productId === $('#originalProductId').val());
                if (index !== -1) {
                    products[index] = productData;
                }
            }
            
            // รีเฟรชตาราง
            table.ajax.reload();
            
            // ปิด Modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
            modal.hide();
        }

        // ฟังก์ชันลบสินค้า
        function deleteProduct(productId) {
            products = products.filter(p => p.productId !== productId);
            table.ajax.reload();
            
            // ปิด Modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal'));
            modal.hide();
        }

        // Initialize DataTable
        let table;
        $(document).ready(function() {
            
            // สร้างข้อมูลสินค้า
            alert(products.length);
            products = generateProducts();
            alert(products.length);
            
            // Initialize DataTable
            table = $('#productsTable').DataTable({
                data: products,
                columns: [
                    { data: 'productId' },
                    { data: 'productName' },
                    { 
                        data: 'price',
                        render: function(data, type, row) {
                            return data.toLocaleString('th-TH', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        },
                        className: 'price-column'
                    },
                    { data: 'typeName' },
                    { data: 'groupName' },
                    { data: 'updatedAt' },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" onclick="openEditModal('${row.productId}')">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" onclick="openDeleteModal('${row.productId}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                        },
                        orderable: false,
                        className: 'action-column'
                    }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/th.json'
                },
                pageLength: 25,
                responsive: true
            });

            // ฟังก์ชันค้นหา
            $('#searchInput').keyup(function() {
                table.search(this.value).draw();
            });

            // ฟังก์ชันกรองประเภทสินค้า
            $('#typeFilter').change(function() {
                table.column(3).search(this.value).draw();
            });

            // ฟังก์ชันกรองช่วงราคา
            $('#priceRange').change(function() {
                const range = this.value;
                if (range === '') {
                    table.column(2).search('').draw();
                    return;
                }
                
                const [min, max] = range.split('-').map(Number);
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        const price = parseFloat(data[2].replace(/,/g, ''));
                        return price >= min && price <= max;
                    }
                );
                table.draw();
                $.fn.dataTable.ext.search.pop();
            });

            // ฟังก์ชันรีเซ็ตฟิลเตอร์
            $('#resetFilter').click(function() {
                $('#typeFilter').val('');
                $('#priceRange').val('');
                $('#searchInput').val('');
                table.search('').columns().search('').draw();
            });

            // ฟังก์ชันบันทึกสินค้า
            $('#saveProductBtn').click(saveProduct);

            // ฟังก์ชันลบสินค้า
            $('#confirmDeleteBtn').click(function() {
                deleteProduct($(this).data('productId'));
            });
        });
        */
    </script>
</body>
</html>