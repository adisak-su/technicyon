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

    <!-- Sidebar -->
    <?php include_once("../includes/sidebar/sidebar.php"); ?>


    <div class="main main-content" id="main-content">
        <h1>Employee Add Pages</h1>
    </div>
    <!-- </div> -->

    <!-- ไฟล์ JavaScript สำหรับคลาส Order -->
    <script src="../includes/sidebar/sidebar.js"></script>

    <script src="../includes/common.js"></script>
        <script>
        // setActiveMenu('../employees/indexAdd.php');
    </script>

</body>

</html>