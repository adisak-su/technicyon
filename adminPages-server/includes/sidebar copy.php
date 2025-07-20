<?php
function isActive($data, $data2 = "")
{
    $array = explode('/', $_SERVER['REQUEST_URI']);
    $key = array_search("adminPages", $array);
    $name = $array[$key + 1];
    return $name === $data ? 'active' : '';
}
function isActive2($data1, $data2)
{
    $array = explode('/', $_SERVER['REQUEST_URI']);
   $key = array_search("adminPages", $array);
    $name1 = $array[$key + 1];
    $name2 = $array[$key + 2];
    return ($name1 === $data1) && ($name2 === $data2) ? 'active' : '';
    // $name = $array[$key + 1];
    // return $name === $data ? 'active' : '';
}

?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- <input class="toggle-event" id="status_${item.adminID}" data-id="${item.adminID}" type="checkbox" name="status" 
                        ${item.status==1 ? 'checked': ''} data-toggle="toggle" data-on="เปิด" 
                    data-off="ปิด" data-onstyle="success" data-style="ios"> -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link">เข้าสู่ระบบครั้งล่าสุด: 11/10/2020 14:07:45 </a>
        </li>

    </ul>
</nav>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand">
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
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="ml-auto">
                <!-- <input class="toggle-event" type="checkbox" name="status" checked data-toggle="toggle" data-on="light mode" data-off="dark mode" data-onstyle="primary" data-style="ios" onclick="changeDarkMode(this);"> -->
                <input class="toggle" id="darkMode" type="checkbox" name="status" checked data-toggle="toggle" data-on="light mode" data-off="dark mode" data-onstyle="primary" data-style="ios" onchange="changeDarkMode(this);">
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
                    <a href="../customers/index.php" class="nav-link <?php echo isActive('customers') ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>จัดการลูกค้า</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link <?php echo isActive('productSale') ?>">
                        <i class="nav-icon fa fa-bars"></i>
                        <p>จัดการรายการสินค้า
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="../productSale/index.php" class="nav-link <?php echo isActive2('productSale','index.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>รายการสินค้า</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../productSale/index-products.php" class="nav-link <?php echo isActive2('productSale', 'index-products.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>กลุ่มสินค้า</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../productSale/index-options.php" class="nav-link <?php echo isActive2('productSale', 'index-options.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>รายละเอียด</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link <?php echo isActive2('productSale',"...") ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>...</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link <?php echo isActive('order') ?>">
                        <i class="nav-icon fa fa-bars"></i>
                        <p>จัดการการขายสินค้า
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="../order/index.php" class="nav-link <?php echo isActive2('order','index.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>หน้าหลัก</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../order/form-payment.php" class="nav-link <?php echo isActive2('order','form-payment.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ชำระเงินตามเลขบิล</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../order/indexProduct.php" class="nav-link <?php echo isActive2('order','indexProduct.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>จัดการ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../order/index.php" class="nav-link <?php echo isActive2('order','...') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ยอดขายสินค้าแบบ Vat</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link <?php echo isActive('invoice') ?>">
                        <i class="nav-icon fa fa-bars"></i>
                        <p>บัญชี
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="../invoice/index.php" class="nav-link <?php echo isActive2('invoice','index.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>หน้าหลัก</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../invoice/form-create.php" class="nav-link <?php echo isActive2('invoice','form-create.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>สร้างใบวางบิล</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../invoice/form-payment.php" class="nav-link <?php echo isActive2('invoice','form-payment.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ชำระเงินตามเลขบิล</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../invoice/form-payment-add.php" class="nav-link <?php echo isActive2('invoice','form-payment-add.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ชำระเงินเพิ่มตามเลขบิล</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link <?php echo isActive('reportSale') ?>">
                        <i class="nav-icon fa fa-bars"></i>
                        <p>รายงานขาย
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="../reportSale/index.php" class="nav-link <?php echo isActive2('reportSale','index.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>รายการขาย</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../reportSale/indexProduct.php" class="nav-link <?php echo isActive2('reportSale','indexProduct.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ยอดขายสินค้า</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../reportSale/index.php" class="nav-link <?php echo isActive2('reportSale','...php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>...</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- <li class="nav-item">

                    <a href="../productSale/index.php" class="nav-link <?php echo isActive('productSale') ?>">

                        <i class="nav-icon fas fa-store"></i>

                        <p>จัดการรายการสินค้า</p>

                    </a>

                </li> -->

                <!-- <li class="nav-item">

                    <a href="../customerSale/index.php" class="nav-link <?php echo isActive('customerSale') ?>">

                        <i class="nav-icon fas fa-store"></i>

                        <p>ขายสินค้า</p>

                    </a>

                </li> -->

                <!-- <li class="nav-item">

                    <a href="../products/index.php" class="nav-link <?php echo isActive('products') ?>">

                        <i class="nav-icon fas fa-store"></i>

                        <p>จัดการกลุ่มสินค้า</p>

                    </a>

                </li> -->

                <!-- <li class="nav-item">

                    <a href="../options/index.php" class="nav-link <?php echo isActive('options') ?>">

                        <i class="nav-icon fas fa-user-cog"></i>

                        <p>Option</p>

                    </a>

                </li> -->

                <!-- <li class="nav-item">

                    <a href="../orderSale/index.php" class="nav-link <?php echo isActive('orderSale') ?>">

                        <i class="nav-icon fas fa-store"></i>

                        <p>รายงานขาย</p>

                    </a>

                </li> -->

                <!-- <li class="nav-item">

                    <a href="#" class="nav-link <?php echo isActive('orderSale') ?>">

                        <i class="nav-icon far fa-envelope"></i>

                        <p>รายงานขาย

                            <i class="fas fa-angle-left right"></i>

                        </p>

                    </a>

                    <ul class="nav nav-treeview" style="display: none;">

                        <li class="nav-item">

                            <a href="pages/mailbox/mailbox.html" class="nav-link">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Inbox</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="pages/mailbox/compose.html" class="nav-link">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Compose</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="pages/mailbox/read-mail.html" class="nav-link">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Read</p>

                            </a>

                        </li>

                    </ul>

                </li> -->

                <!-- <li class="nav-item">

                    <a href="../orderSale/index.php" class="nav-link <?php echo isActive('orderSale') ?>">

                        <i class="nav-icon fas fa-store"></i>

                        <p>รายงาน</p>

                    </a>

                </li> -->

                <!-- <li class="nav-item">

                    <a id="hrefProductsSort" href="../productsSort/indexXXX.php" class="nav-link <?php echo isActive('productsSort') ?>">

                        <i class="nav-icon fas fa-store"></i>

                        <p>จัดเรียงสินค้า</p>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="../../shop/index.php" class="nav-link <?php echo isActive('shop') ?>">

                        <i class="nav-icon fas fa-store"></i>

                        <p>ขายสินค้า</p>

                    </a>

                </li>

                <li class="nav-item user-panel">

                    <a href="../blogs/index.php" class="nav-link <?php echo isActive('blogs') ?>">

                        <i class="nav-icon fas fa-newspaper"></i>

                        <p>บทความ</p>

                    </a>

                </li> -->



                <!-- <li class="nav-header">บัญชีของเรา</li>

                <li class="nav-item">

                    <a href="" id="changePassword" class="nav-link <?php echo isActive('password') ?>">

                        <i class="nav-icon fas fa-key"></i>

                        <p>เปลี่ยนรหัสผ่าน</p>

                    </a>

                </li>

                <li class="nav-item">

                    <a id="logout" href="" class="nav-link" onclick="confirmLogout();" style="text-decoration:none !important; color:red;">

                        <i class="nav-icon fas fa-sign-out-alt"></i>

                        <p>ออกจากระบบ</p>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="" id="changePassword" class="nav-link <?php echo isActive('password') ?>">

                        <i class="nav-icon fas fa-key"></i>

                        <p>เปลี่ยนรหัสผ่าน</p>

                    </a>

                </li> -->



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

                        <a href="" id="logout" class="nav-link" onclick="confirmLogout();">

                            <i class="nav-icon fas fa-sign-out-alt"></i>

                            <p>ออกจากระบบ</p>

                        </a>

                    </li>

                </div>

            </ul>

        </nav>

    </div>

</aside>