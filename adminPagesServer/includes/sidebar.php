<?php
function _isActive($data, $data2 = "")
{
    $array = explode('/', $_SERVER['REQUEST_URI']);
    $key = array_search($_SESSION['adminPages'], $array);
    $name = $array[$key + 1];
    return $name === $data ? 'active' : '';
}
function isActive($data)
{
    $array = explode('/', $_SERVER['REQUEST_URI']);
    $key = array_search($_SESSION['adminPages'], $array);
    $name = $array[$key + 1];
    foreach($data as $item) {
        if($name === $item) {
            return 'active';
        }
    }
    return "";
}
function isActive2($data1, $data2)
{
    $array = explode('/', $_SERVER['REQUEST_URI']);
    $key = array_search($_SESSION['adminPages'], $array);
    $name1 = $array[$key + 1];
    $name2 = $array[$key + 2];
    return ($name1 === $data1) && ($name2 === $data2) ? 'active' : '';
}

?>

<!-- Navbar -->
<!-- <nav class="main-header navbar navbar-expand navbar-white navbar-light"> -->
<nav class="main-header navbar navbar-white navbar-light">
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
            <!-- <a class="nav-link">เข้าสู่ระบบครั้งล่าสุด: <?php echo date("Y-m-d H:i:s"); ?> </a> -->
            <!-- <a class="nav-link">เข้าสู่ระบบครั้งล่าสุด: <?php echo getLocalDateTime('2023-2-7 3:1:4', true); ?> </a> 
        <a class="nav-link">เข้าสู่ระบบครั้งล่าสุด: <?php echo getLocalDateTime(date("Y-m-d H:i:s"), true); ?> </a>
        <a class="nav-link">เข้าสู่ระบบครั้งล่าสุด: <?php echo getLocalDateTime($_SESSION['lastSync'], true); ?> </a>
        <a class="nav-link">เหลือเวลาอีก :  <?php
                                            date_default_timezone_set("UTC");
                                            echo date("H:i:s", $_SESSION['expires'] - time());
                                            date_default_timezone_set('Asia/Bangkok');
                                            ?> </a>
        
        <a class="nav-link" id="timeExpires"><?php
                                                echo "เข้าสู่ระบบครั้งล่าสุด :  ";
                                                echo getLocalDateTime($_SESSION['lastSync'], true);
                                                echo " เหลือเวลาอีก :  ";
                                                date_default_timezone_set("UTC");
                                                echo date("H:i:s", $_SESSION['expires'] - time());
                                                date_default_timezone_set('Asia/Bangkok');
                                                ?></a>

        -->
            <a class="nav-link" id="timeExpires"><?php
                                                    echo "เข้าสู่ระบบครั้งล่าสุด :  ";
                                                    echo getLocalDateTime($_SESSION['lastSync'], true);
                                                    echo " เหลือเวลาอีก :  ";
                                                    ?></a>
        </li>

    </ul>
</nav>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand">
    <a href="index.php" class="brand-link">
        <img src="../../assets/img/AdminLogo.png?" alt="Admin Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light"><?php echo $shopName; ?></span>
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
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="ml-auto">
                <input class="toggle" id="darkMode" type="checkbox" name="status" checked data-toggle="toggle" data-on="light mode" data-off="dark mode" data-onstyle="primary" data-style="ios" onchange="changeDarkMode(this);">
            </div>
        </div> -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="../settings/index.php" class="nav-link <?php echo isActive(['settings']) ?>">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>ตั้งค่า</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../manager/index.php" class="nav-link <?php echo isActive(['manager']) ?>">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>ผู้ดูแลระบบ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../orders/index.php" class="nav-link <?php echo isActive(['orders']) ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>ขายหน้าร้าน</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../orderCar/index.php" class="nav-link <?php echo isActive(['orderCar']) ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>อู่ซ่อมรถ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../customers/index.php" class="nav-link <?php echo isActive(['customers']) ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>ลูกค้า</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../suppliers/index.php" class="nav-link <?php echo isActive(['suppliers']) ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>ร้านค้า</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link <?php echo isActive(['products','types','groups','colors','technicals']) ?>">
                        <i class="nav-icon fa fa-bars"></i>
                        <p>ข้อมูลพื้นฐาน
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="../products/index.php" class="nav-link <?php echo isActive2('products', 'index.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>รายการสินค้า</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="../productSale/index-products.php" class="nav-link <?php echo isActive2('productSale', 'index-products.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>กลุ่มสินค้า</p>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="../types/index.php" class="nav-link <?php echo isActive2('types', 'index.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ประเภทสินค้า</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../groups/index.php" class="nav-link <?php echo isActive2('groups', 'index.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ยี่ห้อ/รุ่นรถยนต์</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../colors/index.php" class="nav-link <?php echo isActive2('colors', 'index.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>สีรถยนต์</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../technicals/index.php" class="nav-link <?php echo isActive2('technicals', 'index.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ช่างซ่อม</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link <?php echo isActive2('productSale', "...") ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>...</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link <?php echo isActive(['orders']) ?>">
                        <i class="nav-icon fa fa-bars"></i>
                        <p>ใบส่งของ
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="../order/index.php" class="nav-link <?php echo isActive2('orders', 'index.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>หน้าหลัก</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../order/form-payment.php" class="nav-link <?php echo isActive2('orders', 'form-payment.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ชำระเงินตามเลขบิล</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../order/indexProduct.php" class="nav-link <?php echo isActive2('orders', 'indexProduct.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>จัดการ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../order/index.php" class="nav-link <?php echo isActive2('orders', '...') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ยอดขายสินค้าแบบ Vat</p>
                            </a>
                        </li>
                    </ul>
                </li> -->
                <li class="nav-item">
                    <a href="#" class="nav-link <?php echo isActive(['invoice']) ?>">
                        <i class="nav-icon fa fa-bars"></i>
                        <p>ใบวางบิล
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="../invoice/index.php" class="nav-link <?php echo isActive2('invoice', 'index.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>หน้าหลัก</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../invoice/form-create.php" class="nav-link <?php echo isActive2('invoice', 'form-create.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>สร้างใบวางบิล</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../invoice/form-payment.php" class="nav-link <?php echo isActive2('invoice', 'form-payment.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ชำระเงินตามเลขบิล</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../invoice/form-payment-add.php" class="nav-link <?php echo isActive2('invoice', 'form-payment-add.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ชำระเงินเพิ่มตามเลขบิล</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link <?php echo isActive(['reportSale']) ?>">
                        <i class="nav-icon fa fa-bars"></i>
                        <p>รายงานขาย
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="../reportSale/index.php" class="nav-link <?php echo isActive2('reportSale', 'index.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>รายการขาย</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../reportSale/indexProduct.php" class="nav-link <?php echo isActive2('reportSale', 'indexProduct.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ยอดขายสินค้า</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../reportSale/index.php" class="nav-link <?php echo isActive2('reportSale', '...php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>...</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- <li class="nav-item">
                    <a href="../productSale/index.php" class="nav-link <?php echo isActive(['productSale']) ?>">
                        <i class="nav-icon fas fa-store"></i>
                        <p>จัดการรายการสินค้า</p>
                    </a>
                </li> -->
                <!-- <li class="nav-item">
                    <a href="../customerSale/index.php" class="nav-link <?php echo isActive(['customerSale']) ?>">
                        <i class="nav-icon fas fa-store"></i>
                        <p>ขายสินค้า</p>
                    </a>
                </li> -->
                <!-- <li class="nav-item">
                    <a href="../products/index.php" class="nav-link <?php echo isActive(['products']) ?>">
                        <i class="nav-icon fas fa-store"></i>
                        <p>จัดการกลุ่มสินค้า</p>
                    </a>
                </li> -->
                <!-- <li class="nav-item">
                    <a href="../options/index.php" class="nav-link <?php echo isActive(['options']) ?>">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Option</p>
                    </a>
                </li> -->
                <!-- <li class="nav-item">
                    <a href="../orderSale/index.php" class="nav-link <?php echo isActive(['orderSale']) ?>">
                        <i class="nav-icon fas fa-store"></i>
                        <p>รายงานขาย</p>
                    </a>
                </li> -->
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link <?php echo isActive(['orderSale']) ?>">
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
                    <a href="../orderSale/index.php" class="nav-link <?php echo isActive(['orderSale']) ?>">
                        <i class="nav-icon fas fa-store"></i>
                        <p>รายงาน</p>
                    </a>
                </li> -->
                <!-- <li class="nav-item">
                    <a id="hrefProductsSort" href="../productsSort/indexXXX.php" class="nav-link <?php echo isActive(['productsSort']) ?>">
                        <i class="nav-icon fas fa-store"></i>
                        <p>จัดเรียงสินค้า</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../../shop/index.php" class="nav-link <?php echo isActive(['shop']) ?>">
                        <i class="nav-icon fas fa-store"></i>
                        <p>ขายสินค้า</p>
                    </a>
                </li>
                <li class="nav-item user-panel">
                    <a href="../blogs/index.php" class="nav-link <?php echo isActive(['blogs']) ?>">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>บทความ</p>
                    </a>
                </li> -->

                <!-- <li class="nav-header">บัญชีของเรา</li>
                <li class="nav-item">
                    <a href="" id="changePassword" class="nav-link <?php echo isActive(['password']) ?>">
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
                    <a href="" id="changePassword" class="nav-link <?php echo isActive(['password']) ?>">
                        <i class="nav-icon fas fa-key"></i>
                        <p>เปลี่ยนรหัสผ่าน</p>
                    </a>
                </li> -->

                <div class="user-panel">
                    <li class="nav-header">บัญชีของเรา</li>
                    <li class="nav-item">
                        <a href="" id="changePassword" class="nav-link <?php echo isActive(['password']) ?>">
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
                        <a href="" id="logout" class="nav-link" onclick="confirmDeleteIndexeddb();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>ลบข้อมูลที่เก็บในเครื่อง</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" id="logout" class="nav-link" onclick="confirmSetTimeSyncData();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>ตั้งเวลาในการ Sync ข้อมูล</p>
                        </a>
                    </li>
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
<script>
    let timeExpires = "";
    let sessionExpiresTime = "<?php echo $_SESSION['expires']; ?>";
    window.addEventListener("DOMContentLoaded", function() {
        timeExpires = $("#timeExpires").text();
        setInterval(function() {
            let expiresTime = Number(sessionExpiresTime) * 1000 - Date.now();
            expiresTime = new Date(expiresTime).toISOString();
            expiresTime = expiresTime.substr(11, 8);
            $("#timeExpires").text(timeExpires + expiresTime);
        }, 1000);
        $(".content-wrapper").click(function(e) {
            if ($("body").hasClass("sidebar-open")) {
                $("body").removeClass("sidebar-open");
                $("body").addClass("sidebar-closed");
                $("body").addClass("sidebar-collapse");
            }
        });
    });

    function setExpiresTime(newValue) {}
</script>