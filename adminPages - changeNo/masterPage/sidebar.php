<?php
function slideMenu() {
    echo '
    <!-- Slide Menu -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-store"></i> ระบบขายสินค้า</h3>
        </div>

        <ul class="list-unstyled components">
            <li>
                <a href="#"><i class="fas fa-tachometer-alt"></i> ภาพรวมระบบ</a>
            </li>
            <li class="active">
                <a href="#"><i class="fas fa-user-tag"></i> ข้อมูลลูกค้า</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-shopping-cart"></i> การสั่งซื้อ</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-box"></i> สินค้า</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-chart-bar"></i> รายงาน</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-users"></i> ผู้ใช้งาน</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-cog"></i> การตั้งค่า</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a>
            </li>
        </ul>

        <div class="sidebar-footer">
            ระบบจัดการข้อมูลลูกค้า<br>เวอร์ชั่น 2.0
        </div>
    </nav>
    ';
}

function  _topNavbar() {
    echo '
        <!-- Top Navbar -->
        <nav class="top-navbar backgrond-gradient d-flex justify-content-between">
            <div>
                <button class="menu-toggle-btn" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div>
                <div class="dashboard-header">
                    <div class="container">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                ข้อมูลลูกค้าและประวัติการซื้อ
                            </div>
                            <div>
                                <button id="refreshBtn" class="btn btn-light">
                                    <i class="fas fa-sync-alt"></i> โหลดข้อมูลใหม่
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="user-controls">
                    <div class="user-info">
                        <div class="user-avatar">AD</div>
                        <div>
                            <div>ผู้ดูแลระบบ</div>
                            <small>Admin</small>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-outline-danger" id="logoutBtn">
                        <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
                    </button>
                </div>
            </div>
        </nav>
    ';
}

function  topNavbar() {
    echo '
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div>
                <button class="menu-toggle-btn" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <span id="titlePage" style="margin-left: 20px; font-size: 20pt; font-weight: 500; color:white;">ข้อมูลลูกค้าและประวัติการซื้อ</span>
            </div>

            <div class="user-controls">
                <div class="user-info">
                    <div class="user-avatar" id="userName">Adisak supatanaseinkasem</div>
                    <div>
                        <div id="userPermission">ผู้ดูแลระบบ</div>
                   </div>
                </div>
                <button class="btn btn-sm btn-outline-danger" id="logoutBtn">
                    <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
                </button>
            </div>
        </nav>
    ';
}
?>