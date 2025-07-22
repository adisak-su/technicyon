<?php
function isActive($data)
{
    $array = explode('/', $_SERVER['REQUEST_URI']);
    $key = array_search("adminPages", $array);
    $name = $array[$key + 1];
    return $name === $data ? 'active' : '';
}
?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link">เข้าสู่ระบบครั้งล่าสุด: 11/10/2020 14:07:45 </a>
        </li>
    </ul>
</nav>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.php" class="brand-link">
        <img src="../../assets/img/AdminLogo.png?" alt="Admin Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">Admin || <?php echo $shopName; ?></span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../manager/images/<?php echo $_SESSION['image']; ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $_SESSION['adminName']; ?></a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="../dashboard/index.php" class="nav-link <?php echo isActive('dashboard') ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>หน้าหลัก</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../manager/index.php" class="nav-link <?php echo isActive('manager') ?>">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>ผู้ดูแลระบบ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../products/index.php" class="nav-link <?php echo isActive('products') ?>">
                        <i class="nav-icon fas fa-store"></i>
                        <p>จัดการสินค้า</p>
                    </a>
                </li>
                <li class="nav-item user-panel">
                    <a href="../blogs/index.php" class="nav-link <?php echo isActive('blogs') ?>">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>บทความ</p>
                    </a>
                </li>
                <div class="user-panel">
                    <li class="nav-header">บัญชีของเรา</li>
                    <li class="nav-item">
                        <a href="" id="changePassword" class="nav-link <?php echo isActive('password') ?>">
                            <i class="nav-icon fas fa-key"></i>
                            <p>เปลี่ยนรหัสผ่าน</p>
                        </a>
                    </li>
                    <!--
                <li class="nav-item">
                    <a href="../logout.php" id="logout" class="nav-link" onclick="confirmLogout();">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>ออกจากระบบ</p>
                    </a>
                </li>
                -->
                    <li class="nav-item">
                        <a id="logout" class="nav-link" onclick="confirmLogout();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>ออกจากระบบ</p>
                        </a>
                    </li>
                </div>
            </ul>
        </nav>
    </div>
</aside>