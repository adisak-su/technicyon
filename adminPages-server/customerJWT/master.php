<?php
    require_once "../masterPage/sidebar.php";
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการข้อมูลลูกค้าและประวัติการซื้อ</title>
    <!-- Bootstrap v4 -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../../plugins/sweetalert2/dist/sweetalert2.min.css"> 

    <link rel="stylesheet" href="../masterPage/root.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../masterPage/sidebar.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../menus/menuheader.css?<?php echo time(); ?>">
    <style>

    </style>
</head>

<body>
    <!-- Slide Menu -->
     <?php slideMenu(); ?>

    <!-- Page Content -->
    <div id="content">
        <!-- Top Navbar -->
        <?php topNavbar(); ?>
        <!-- Main Content -->
        <div class="main-content">
            <?php include_once("../menus/menuheader.php"); ?>
            <div class="dashboard-header">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1><i class="fas fa-user-tag"></i> ข้อมูลลูกค้าและประวัติการซื้อ</h1>
                            <p>จัดการข้อมูลลูกค้าและดูประวัติการสั่งซื้อทั้งหมด</p>
                        </div>
                        <div>
                            <button id="refreshBtn" class="btn btn-light">
                                <i class="fas fa-sync-alt"></i> โหลดข้อมูลใหม่
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ส่วนข้อมูลลูกค้า -->
            <div class="customer-card">
                <div class="customer-header">
                    <div class="customer-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="customer-info">
                        <div class="customer-name">นางสาวสมหญิง ใจดี</div>
                        <div class="customer-id">รหัสลูกค้า: CUST-2023-00125</div>
                    </div>
                </div>

                <div class="tabs-container">
                    <!-- แท็บเมนู -->
                    <ul class="nav nav-tabs" id="customerTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab">
                                <i class="fas fa-info-circle mr-2"></i>ข้อมูลลูกค้า
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="purchases-tab" data-toggle="tab" href="#purchases" role="tab">
                                <i class="fas fa-shopping-cart mr-2"></i>ประวัติการซื้อ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes" role="tab">
                                <i class="fas fa-sticky-note mr-2"></i>บันทึกเพิ่มเติม
                            </a>
                        </li>
                    </ul>

                    <!-- เนื้อหาแท็บ -->
                    <div class="tab-content" id="customerTabsContent">
                        <!-- แท็บข้อมูลลูกค้า -->
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <i class="fas fa-user-circle mr-2"></i>ข้อมูลส่วนตัว
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-sm-4 font-weight-bold">ชื่อ-สกุล:</div>
                                                <div class="col-sm-8">สมหญิง ใจดี</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-4 font-weight-bold">เพศ:</div>
                                                <div class="col-sm-8">หญิง</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-4 font-weight-bold">วันเกิด:</div>
                                                <div class="col-sm-8">15 พฤษภาคม 1990 (33 ปี)</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-4 font-weight-bold">ที่อยู่:</div>
                                                <div class="col-sm-8">123/456 ถนนสุขุมวิท แขวงคลองเตย เขตคลองเตย กรุงเทพมหานคร 10110</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <i class="fas fa-address-book mr-2"></i>ข้อมูลติดต่อ
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-sm-4 font-weight-bold">อีเมล:</div>
                                                <div class="col-sm-8">somying@example.com</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-4 font-weight-bold">โทรศัพท์:</div>
                                                <div class="col-sm-8">081-234-5678</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-4 font-weight-bold">Line ID:</div>
                                                <div class="col-sm-8">@somying</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-4 font-weight-bold">Facebook:</div>
                                                <div class="col-sm-8">/somying.jaidee</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-light">
                                    <i class="fas fa-chart-line mr-2"></i>สถิติลูกค้า
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-3 mb-3">
                                            <div class="display-4 font-weight-bold">24</div>
                                            <div class="text-muted">จำนวนการซื้อ</div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="display-4 font-weight-bold">฿125,800</div>
                                            <div class="text-muted">ยอดซื้อทั้งหมด</div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="display-4 font-weight-bold">28 ตุลาคม</div>
                                            <div class="text-muted">ซื้อล่าสุด</div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="display-4 font-weight-bold">12,500</div>
                                            <div class="text-muted">คะแนนสะสม</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- แท็บประวัติการซื้อ -->
                        <div class="tab-pane fade" id="purchases" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>รหัสคำสั่งซื้อ</th>
                                            <th>วันที่</th>
                                            <th>จำนวน</th>
                                            <th>ยอดรวม</th>
                                            <th>ช่องทางการชำระ</th>
                                            <th>สถานะ</th>
                                            <th>การดำเนินการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>ORD-2023-00158</td>
                                            <td>28 ตุลาคม 2023</td>
                                            <td>3 รายการ</td>
                                            <td>฿8,450</td>
                                            <td>บัตรเครดิต</td>
                                            <td><span class="badge badge-success">สำเร็จ</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> ดูรายละเอียด
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ORD-2023-00142</td>
                                            <td>15 ตุลาคม 2023</td>
                                            <td>5 รายการ</td>
                                            <td>฿6,250</td>
                                            <td>โอนผ่านธนาคาร</td>
                                            <td><span class="badge badge-success">สำเร็จ</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> ดูรายละเอียด
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ORD-2023-00135</td>
                                            <td>5 ตุลาคม 2023</td>
                                            <td>2 รายการ</td>
                                            <td>฿18,500</td>
                                            <td>บัตรเครดิต</td>
                                            <td><span class="badge badge-success">สำเร็จ</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> ดูรายละเอียด
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ORD-2023-00167</td>
                                            <td>2 พฤศจิกายน 2023</td>
                                            <td>4 รายการ</td>
                                            <td>฿7,200</td>
                                            <td>พร้อมเพย์</td>
                                            <td><span class="badge badge-warning">รอดำเนินการ</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> ดูรายละเอียด
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <nav>
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled"><a class="page-link" href="#">ก่อนหน้า</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">ถัดไป</a></li>
                                </ul>
                            </nav>
                        </div>

                        <!-- แท็บบันทึกเพิ่มเติม -->
                        <div class="tab-pane fade" id="notes" role="tabpanel">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <i class="fas fa-plus-circle mr-2"></i>เพิ่มบันทึกใหม่
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>หัวข้อบันทึก</label>
                                        <input type="text" class="form-control" placeholder="ระบุหัวข้อบันทึก">
                                    </div>
                                    <div class="form-group">
                                        <label>รายละเอียด</label>
                                        <textarea class="form-control" rows="4" placeholder="รายละเอียดบันทึก"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>ประเภท</label>
                                        <select class="form-control">
                                            <option>ทั่วไป</option>
                                            <option>การติดต่อ</option>
                                            <option>ปัญหา/ข้อร้องเรียน</option>
                                            <option>ข้อเสนอแนะ</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary">
                                        <i class="fas fa-save mr-2"></i>บันทึกข้อมูล
                                    </button>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-light">
                                    <i class="fas fa-sticky-note mr-2"></i>บันทึกที่มีอยู่
                                </div>
                                <div class="card-body">
                                    <div class="media mb-4">
                                        <div class="media-body">
                                            <h5 class="mt-0">ลูกค้าสนใจโปรโมชั่นใหม่</h5>
                                            <div class="text-muted small mb-2">บันทึกเมื่อ: 15 ตุลาคม 2023 โดย ผู้ดูแลระบบ</div>
                                            <p>ลูกค้าสอบถามเกี่ยวกับโปรโมชั่นสินค้าใหม่ที่กำลังจะมาถึง และสนใจที่จะสั่งซื้อล่วงหน้า</p>
                                            <div>
                                                <span class="badge badge-info">การติดต่อ</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="media mb-4">
                                        <div class="media-body">
                                            <h5 class="mt-0">ปัญหาการจัดส่ง</h5>
                                            <div class="text-muted small mb-2">บันทึกเมื่อ: 10 กันยายน 2023 โดย ผู้ดูแลระบบ</div>
                                            <p>ลูกค้าแจ้งว่าสินค้าจัดส่งล่าช้ากว่ากำหนด 1 วัน ทางเราจัดการชดเชยด้วยส่วนลด 10% สำหรับการซื้อครั้งต่อไป</p>
                                            <div>
                                                <span class="badge badge-warning">ปัญหา/ข้อร้องเรียน</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="media">
                                        <div class="media-body">
                                            <h5 class="mt-0">ข้อเสนอแนะการใช้งานเว็บ</h5>
                                            <div class="text-muted small mb-2">บันทึกเมื่อ: 25 สิงหาคม 2023 โดย ผู้ดูแลระบบ</div>
                                            <p>ลูกค้าเสนอแนะให้เพิ่มฟังก์ชั่นการเปรียบเทียบสินค้า และปรับปรุงระบบการค้นหาให้ดียิ่งขึ้น</p>
                                            <div>
                                                <span class="badge badge-success">ข้อเสนอแนะ</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
    <!-- jQuery and Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Slide Menu Toggle
        $(document).ready(function() {
            $('#sidebarToggle').click(function(e) {
                e.stopPropagation();
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
            });

            // Close sidebar when clicking on content (except when clicking on sidebar)
            /*
                        $('#content').click(function(e) {
                            if ($(window).width() < 768) {
                                if ($('#sidebar').hasClass('active')) {
                                    $('#sidebar').removeClass('active');
                                    $('#content').removeClass('active');
                                }
                            }
                        });
            */
            $('#content').click(function(e) {
                if ($('#sidebar').hasClass('active')) {
                    $('#sidebar').removeClass('active');
                    $('#content').removeClass('active');
                }
            });


            // Prevent closing when clicking inside sidebar
            $('#sidebar').click(function(e) {
                e.stopPropagation();
            });


            // ตั้งค่าขนาดเริ่มต้นสำหรับหน้าจอมือถือ
            /*
                        if ($(window).width() < 768) {
                            $('#sidebar').addClass('active');
                            $('#content').addClass('active');
                        }
                        */
            // ปรับเมนูเมื่อหน้าจอเปลี่ยนขนาด
            /*
                        $(window).resize(function() {
                            if ($(window).width() < 768) {
                                $('#sidebar').addClass('active');
                                $('#content').addClass('active');
                            } else {
                                $('#sidebar').removeClass('active');
                                $('#content').removeClass('active');
                            }
                        });
                        */
            // ออกจากระบบ
            $('#logoutBtn').click(function() {
                Swal.fire({
                    title: 'ออกจากระบบ?',
                    text: 'คุณแน่ใจว่าต้องการออกจากระบบหรือไม่?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'ออกจากระบบ',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ลบ token
                        localStorage.removeItem('jwtToken');
                        // ไปหน้า login
                        window.location.href = '../../login.html';
                    }
                });
            });

            // ปุ่มโหลดข้อมูลใหม่
            $('#refreshBtn').click(function() {
                Swal.fire({
                    title: 'กำลังโหลดข้อมูล...',
                    html: 'กรุณารอสักครู่',
                    allowOutsideClick: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });
        });
    </script>
</body>

</html>