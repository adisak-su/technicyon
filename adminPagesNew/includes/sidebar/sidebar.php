<?php
function isActive($data)
{
    $array = explode('/', $_SERVER['REQUEST_URI']);
    $key = array_search("shopping", $array);
    $name = $array[$key + 1];
    return $name === $data ? 'active' : '';
}
function isActive2($data1, $data2)
{
    $array = explode('/', $_SERVER['REQUEST_URI']);
    $key = array_search("shopping", $array);
    $name1 = $array[$key + 1];
    $name2 = $array[$key + 2];
    return ($name1 === $data1) && ($name2 === $data2) ? 'active' : '';
}
function createSidebar()
{
    echo '
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <h4><i class="fas fa-store"></i> POS SYSTEM</h4>
            <a href="#" class="active"><i class="fas fa-cash-register"></i> ขาย</a>
            <a href="#"><i class="fas fa-chart-bar"></i> รายงานการขาย</a>
            <a href="#"><i class="fas fa-users"></i> จัดการพนักงาน</a>
            <a href="#"><i class="fas fa-boxes"></i> จัดการสต็อก</a>
            <a href="#"><i class="fas fa-university"></i> การตั้งค่าบัญชี</a>
            <a href="#" class="text-danger"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a>
        </div>
        <!-- Overlay -->
        <div class="overlay" id="overlay" onclick="closeSidebar()"></div>
    ';
}

function  creatHeader()
{
    echo '

    <!-- Main Content -->
    <div class="main" id="main-head">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <span id="sidebar-toggle" class="sidebar-toggle" onclick="toggleSidebar()">☰</span>
                <h4><i class="fas fa-shopping-cart"></i> ระบบจุดขาย POS</h4>
            </div>
            <div>
                <i class="fas fa-calendar-alt"></i> <span id="date-display">วันอาทิตย์ที่ 29 มิถุนายน 2568</span> |
                <i class="fas fa-clock"></i> <span id="time">16:43:42</span> |
                <i class="fas fa-user"></i> แคชเชียร์: Admin
            </div>
        </div>
    </div>    ';
}

?>
<!-- Sidebar -->
<!-- Sidebar with submenu -->
<div class="sidebar" id="sidebar">
    <h4><i class="fas fa-store"></i> POS SYSTEM</h4>
    <div class="current-page">
        <i class="fas fa-window-maximize"></i>
        <span>หน้าปัจจุบัน: <strong id="currentPage">/stock/adjust</strong></span>
    </div>
    <a href="#" id="salesLink" class=""><i class="fas fa-cash-register"></i> ขาย</a>
    <!-- <a href="/reports" id="reportsLink"><i class="fas fa-chart-bar"></i> รายงานการขาย</a> -->

    <a href="../orders/index.php" id="ordersLink" class="<?php echo isActive('orders'); ?>"><i class="fas fa-chart-bar"></i> การขาย</a>
    <!-- <a href="../orders/" id="ordersLink" class="active"><i class="fas fa-chart-bar"></i> การขาย</a> -->
    <!-- <a href="../customers/index.php" id="customersLink" class="<?php echo isActive('customers','index.php') ?>"><i class="fas fa-chart-bar"></i> ลูกค้า</a> -->
    <a href="../customers/index.php" id="customersLink" class="<?php echo isActive('customers') ?>"><i class="fas fa-chart-bar"></i> ลูกค้า</a>

    <!-- Data Management with Submenu -->
    <div class="has-submenu" id="employeeMenu">
        <a href="#"><i class="fas fa-users"></i> ข้อมูลเบื้องต้น</a>
        <div class="submenu">
            <a href="../groups/index.php"><i class="fas fa-user-plus"></i> ยี่ห้อ/รุ่นรถยต์</a>
            <a href="../type/index.php"><i class="fas fa-user-edit"></i> ประเภทสินค้า</a>
            <a href="../employees/index.php"><i class="fas fa-user-clock"></i> กำหนดกะงาน</a>
            <a href="../employees/performance"><i class="fas fa-chart-line"></i> ประสิทธิภาพพนักงาน</a>
        </div>
    </div>

    <!-- Employee Management with Submenu -->
    <div class="has-submenu" id="employeeMenu">
        <a href="#"><i class="fas fa-users"></i> จัดการพนักงาน</a>
        <div class="submenu">
            <a href="../employees/indexAdd.php" class="<?php echo isActive2("employees","indexAdd.php") ?>"><i class="fas fa-user-plus"></i> เพิ่มพนักงานใหม่</a>
            <a href="../employees/indexEdit.php" class="<?php echo isActive2("employees","indexEdit.php") ?>"><i class="fas fa-user-edit"></i> แก้ไขข้อมูลพนักงาน</a>
            <a href="../employees/index.php" class="<?php echo isActive2("employees","index.php") ?>"><i class="fas fa-user-clock"></i> กำหนดกะงาน</a>
            <a href="../employees/performance"><i class="fas fa-chart-line"></i> ประสิทธิภาพพนักงาน</a>
        </div>
    </div>

    <!-- Stock Management with Submenu -->
    <div class="has-submenu" id="stockMenu">
        <a href="#"><i class="fas fa-boxes"></i> จัดการสต็อก</a>
        <div class="submenu">
            <a href="/stock"><i class="fas fa-box-open"></i> ดูสินค้าทั้งหมด</a>
            <a href="/stock/add"><i class="fas fa-plus-circle"></i> เพิ่มสินค้าใหม่</a>
            <a href="/stock/edit"><i class="fas fa-edit"></i> แก้ไขสินค้า</a>
            <a href="/stock/adjust" class="active"><i class="fas fa-exchange-alt"></i> ปรับยอดสต็อก</a>
            <a href="/stock/categories"><i class="fas fa-archive"></i> จัดหมวดหมู่สินค้า</a>
        </div>
    </div>

    <a href="#"><i class="fas fa-university"></i> การตั้งค่าบัญชี</a>
    <a href="#" class="text-danger"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a>
</div>
<!-- Overlay -->
<div class="overlay" id="overlay" onclick="closeSidebar()"></div>

<!-- Main Content -->
<div class="main main-header" id="main-head">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <span id="sidebar-toggle" class="sidebar-toggle" onclick="toggleSidebar()">☰</span>
            <h4><i class="fas fa-shopping-cart"></i> ระบบจุดขาย POS</h4>
        </div>
        <div>
            <i class="fas fa-calendar-alt"></i> <span id="date-display">วันอาทิตย์ที่ 29 มิถุนายน 2568</span> |
            <i class="fas fa-clock"></i> <span id="time">16:43:42</span> |
            <i class="fas fa-user"></i> แคชเชียร์: Admin
        </div>
    </div>
</div>