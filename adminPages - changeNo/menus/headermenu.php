<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการสินค้า</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"> -->
    <!-- <link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.css">
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
            border-radius: 16px;
            min-width: 100px;
        }

        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
            background-color: white;
        }

        .icon-container {
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 8px;
        }

        .menu-text {
            font-size: 1.1rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }
    </style>
</head>

<body>
    <div class="container-fluid text-center my-2 ml-5">
        <div class="row d-flex justify-content-start" style="gap: 10px">
            <!-- เมนูที่ 1 -->
            <div class="">
                <a href="#" class="text-decoration-none">
                    <div class="menu-item shadow-sm">
                        <div class="icon-container">
                            <i class="fa fa-home fa-2x text-primary"></i>
                        </div>
                        <div class="menu-text">หน้าหลัก</div>
                    </div>
                </a>
            </div>

            <!-- เมนูที่ 2 -->
            <div class="">
                <a href="#" class="text-decoration-none">
                    <div class="menu-item shadow-sm">
                        <div class="icon-container">
                            <i class="fa fa-home fa-2x text-success"></i>
                        </div>
                        <div class="menu-text">สินค้า</div>
                    </div>
                </a>
            </div>

            <!-- เมนูที่ 3 -->
            <div class="">
                <a href="#" class="text-decoration-none">
                    <div class="menu-item shadow-sm">
                        <div class="icon-container">
                            <i class="fa fa-home fa-2x text-info"></i>
                        </div>
                        <div class="menu-text">รายงาน</div>
                    </div>
                </a>
            </div>

            <!-- เมนูที่ 4 -->
            <div class="">
                <a href="#" class="text-decoration-none">
                    <div class="menu-item shadow-sm">
                        <div class="icon-container">
                            <i class="fa fa-home fa-2x text-warning"></i>
                        </div>
                        <div class="menu-text">ตั้งค่า</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>