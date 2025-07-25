<?php
// check login token in page php
require_once('../authen.php');

require_once("../../assets/php/common.php");
require_once("../../service/configData.php");
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการยี่ห้อ/รุ่นรถยนต์ | <?php echo $shopName; ?></title>
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.css">

    <!-- Favicons -->
    <?php include_once('../../includes/pagesFavicons.php'); ?>

    <!-- stylesheet -->
    <?php include_once('../../includes/pagesStylesheet.php'); ?>

    <!-- Font Awesome 6 (Free CDN) -->
    <!-- <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" /> -->

    <!-- <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css"> -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/6.5.0.all.min.css">
    <link rel="stylesheet" href="../menus/menuheader.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">
    <!-- <link rel="stylesheet" href="styleExport.css?<?php echo time(); ?>"> -->
    <style>

    </style>

</head>

<body class="sidebar-collapse">
    <div class="wrapper">
        <!-- Menu -->
        <?php include_once('../includes/sidebar.php') ?>
        <div class="content-wrapper">
            <div class="content-header">
                <?php include_once("../menus/menuheader.php"); ?>
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <label class="m-0 text-dark">จัดการยี่ห้อ/รุ่นรถยนต์</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h2><i class="fas fa-file-excel me-2"></i>ระบบ Export หลายตารางเป็น Excel</h2>
                                    <p class="mb-0">เลือกตารางที่ต้องการ export (สามารถเลือกได้หลายตาราง)</p>
                                </div>

                                <div class="card-body p-4">
                                    <div id="error-message" class="alert alert-danger d-none"></div>

                                    <!-- ตัวกรองตาราง -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                <input type="text" id="search-table" class="form-control" placeholder="ค้นหาตาราง...">
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="select-all">
                                                <label class="form-check-label" for="select-all">เลือกทั้งหมด</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- รายการตาราง -->
                                    <div class="mb-4">
                                        <h4 class="mb-3"><i class="fas fa-table-list me-2"></i>รายการตาราง</h4>

                                        <div id="loading" class="text-center">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p class="mt-2">กำลังโหลดข้อมูล...</p>
                                        </div>

                                        <div id="tables-container" class="tables-container">
                                            <div id="tables-list" class="row gy-3"></div>

                                            <div id="no-tables-message" class="text-center d-none">
                                                <div class="alert alert-warning py-4">
                                                    <i class="fas fa-database fa-2x mb-3"></i>
                                                    <h4>ไม่พบตารางในฐานข้อมูล</h4>
                                                    <p class="mb-0">โปรดตรวจสอบการเชื่อมต่อฐานข้อมูล</p>
                                                </div>
                                            </div>

                                            <div id="no-results-message" class="text-center d-none">
                                                <div class="alert alert-info py-4">
                                                    <i class="fas fa-search fa-2x mb-3"></i>
                                                    <h4>ไม่พบตารางที่ตรงกับคำค้นหา</h4>
                                                    <p class="mb-0">ลองเปลี่ยนคำค้นหาหรือลบคีย์เวิร์ด</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div id="selected-count">เลือกแล้ว: <span>0</span> ตาราง</div>
                                            <button id="clear-selection" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-times me-1"></i>ล้างการเลือก
                                            </button>
                                        </div>
                                    </div>

                                    <!-- ปุ่ม Export -->
                                    <div class="d-grid mt-4">
                                        <button id="export-btn" class="btn btn-export btn-lg" disabled>
                                            <i class="fas fa-file-export me-2"></i>Export ตารางที่เลือกเป็น Excel
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- แถบสถานะ -->
                            <div class="mt-4">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>สถานะการทำงาน</h5>
                                        <span id="status-indicator" class="badge bg-secondary">รอการเลือกตาราง</span>
                                    </div>
                                    <div class="card-body">
                                        <ul class="mb-0" id="status-list">
                                            <li>โปรดเลือกตารางที่ต้องการ export อย่างน้อย 1 ตาราง</li>
                                            <li>ระบบจะสร้างไฟล์ Excel ที่มีหลายชีต โดยแต่ละชีตคือข้อมูลของแต่ละตาราง</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Footer -->
        <?php include_once('../includes/footer.php') ?>
        <?php include_once('../../includes/loading.php') ?>
    </div>


    <!-- SCRIPTS -->
    <?php include_once('../../includes/pagesScript.php') ?>
    <?php include_once('../../includes/myScript.php') ?>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const tablesList = document.getElementById('tables-list');
            const loading = document.getElementById('loading');
            const exportBtn = document.getElementById('export-btn');
            const errorMessage = document.getElementById('error-message');
            const searchInput = document.getElementById('search-table');
            const selectAll = document.getElementById('select-all');
            const clearSelection = document.getElementById('clear-selection');
            const selectedCount = document.getElementById('selected-count').querySelector('span');
            const noTablesMessage = document.getElementById('no-tables-message');
            const noResultsMessage = document.getElementById('no-results-message');
            const statusList = document.getElementById('status-list');
            const statusIndicator = document.getElementById('status-indicator');

            let allTables = [];
            let selectedTables = [];

            // ตั้งค่าปีปัจจุบันใน footer
            // document.getElementById('current-year').textContent = new Date().getFullYear();

            // ฟังก์ชันแสดงข้อผิดพลาด
            function showError(message) {
                errorMessage.textContent = message;
                errorMessage.classList.remove('d-none');
                statusIndicator.className = 'badge bg-danger';
                statusIndicator.textContent = 'เกิดข้อผิดพลาด';

                // อัพเดทสถานะ
                updateStatusList([
                    `<span class="text-danger">${message}</span>`,
                    'โปรดตรวจสอบการเชื่อมต่อหรือลองใหม่ในภายหลัง'
                ]);
            }

            // ฟังก์ชันซ่อนข้อผิดพลาด
            function hideError() {
                errorMessage.classList.add('d-none');
            }

            // ฟังก์ชันอัพเดทรายการสถานะ
            function updateStatusList(messages) {
                statusList.innerHTML = '';
                messages.forEach(msg => {
                    const li = document.createElement('li');
                    li.innerHTML = msg;
                    statusList.appendChild(li);
                });
            }

            // ฟังก์ชันดึงรายชื่อตาราง
            function fetchTables() {
                fetch('services/api.php?action=get_tables')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('ไม่สามารถดึงข้อมูลตารางได้');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status) {
                            allTables = data.tables;
                            renderTables(allTables);

                            // อัพเดทสถานะ
                            statusIndicator.className = 'badge bg-success';
                            statusIndicator.textContent = 'พร้อมใช้งาน';
                            updateStatusList([
                                `พบตารางทั้งหมด: ${allTables.length} ตาราง`,
                                'เลือกตารางที่ต้องการ export อย่างน้อย 1 ตาราง',
                                'ระบบจะสร้างไฟล์ Excel ที่มีหลายชีต โดยแต่ละชีตคือข้อมูลของแต่ละตาราง'
                            ]);
                        } else {
                            showError(data.message || 'เกิดข้อผิดพลาดในการดึงข้อมูล');
                        }
                    })
                    .catch(error => {
                        showError(error.message);
                    })
                    .finally(() => {
                        loading.style.display = 'none';
                    });
            }

            // ฟังก์ชันแสดงรายการตาราง
            function renderTables(tables) {
                if (tables.length === 0) {
                    tablesList.innerHTML = '';
                    noTablesMessage.classList.remove('d-none');
                    noResultsMessage.classList.add('d-none');
                    return;
                }

                tablesList.innerHTML = '';
                noTablesMessage.classList.add('d-none');
                noResultsMessage.classList.add('d-none');

                tables.forEach(item => {
                    table = item.Tables_in_technicyon;

                    const isSelected = selectedTables.includes(table);

                    const tableItem = document.createElement('div');
                    tableItem.className = 'col-md-4';
                    tableItem.innerHTML = `
                <div class="table-card ${isSelected ? 'selected' : ''}">
                    <div class="form-check">
                        <input class="form-check-input table-checkbox" type="checkbox" 
                               id="table-${table}" value="${table}"
                               ${isSelected ? 'checked' : ''}>
                        <label class="form-check-label" for="table-${table}">
                            <div class="table-icon">
                                <i class="fas fa-table"></i>
                            </div>
                            <div class="table-info">
                                <div class="table-name">${table}</div>
                                <div class="table-status">${isSelected ? 'เลือกแล้ว' : 'ยังไม่ได้เลือก'}</div>
                            </div>
                        </label>
                    </div>
                </div>
            `;

                    tablesList.appendChild(tableItem);
                });

                // อัพเดทจำนวนตารางที่เลือก
                updateSelectedCount();

                // เพิ่ม event listeners
                document.querySelectorAll('.table-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', handleTableSelection);
                });
            }

            // จัดการการเลือกตาราง
            function handleTableSelection(e) {
                const table = e.target.value;
                const isSelected = e.target.checked;

                if (isSelected && !selectedTables.includes(table)) {
                    selectedTables.push(table);
                } else if (!isSelected && selectedTables.includes(table)) {
                    selectedTables = selectedTables.filter(t => t !== table);
                }

                // อัพเดท UI
                const card = e.target.closest('.table-card');
                if (card) {
                    card.classList.toggle('selected', isSelected);
                    const status = card.querySelector('.table-status');
                    if (status) {
                        status.textContent = isSelected ? 'เลือกแล้ว' : 'ยังไม่ได้เลือก';
                    }
                }

                // อัพเดทปุ่ม
                exportBtn.disabled = selectedTables.length === 0;

                // อัพเดทจำนวน
                updateSelectedCount();

                // อัพเดท select all
                updateSelectAllState();
            }

            // อัพเดทจำนวนตารางที่เลือก
            function updateSelectedCount() {
                selectedCount.textContent = selectedTables.length;

                // อัพเดทสถานะ
                if (selectedTables.length > 0) {
                    statusIndicator.className = 'badge bg-primary';
                    statusIndicator.textContent = 'พร้อม export';
                    updateStatusList([
                        `เลือกตารางแล้ว: ${selectedTables.length} ตาราง`,
                        `ตาราง: ${selectedTables.join(', ')}`,
                        'กดปุ่ม "Export ตารางที่เลือกเป็น Excel" เพื่อสร้างไฟล์'
                    ]);
                } else {
                    statusIndicator.className = 'badge bg-secondary';
                    statusIndicator.textContent = 'รอการเลือกตาราง';
                    updateStatusList([
                        'โปรดเลือกตารางที่ต้องการ export อย่างน้อย 1 ตาราง',
                        'ระบบจะสร้างไฟล์ Excel ที่มีหลายชีต โดยแต่ละชีตคือข้อมูลของแต่ละตาราง'
                    ]);
                }
            }

            // อัพเดทสถานะ "เลือกทั้งหมด"
            function updateSelectAllState() {
                selectAll.checked = selectedTables.length > 0 && selectedTables.length === allTables.length;
            }

            // เมื่อกดปุ่ม Export
            // ในส่วนของการเรียก API Export ให้เปลี่ยนข้อความแสดงสถานะ
            exportBtn.addEventListener('click', function() {
                if (selectedTables.length === 0) {
                    showError('กรุณาเลือกตารางที่ต้องการ export อย่างน้อย 1 ตาราง');
                    return;
                }

                hideError();

                // แสดงสถานะกำลังโหลด
                exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>กำลังสร้างไฟล์ CSV...';
                exportBtn.disabled = true;

                // อัพเดทสถานะ
                statusIndicator.className = 'badge bg-warning';
                statusIndicator.textContent = 'กำลังสร้างไฟล์';
                updateStatusList([
                    'กำลังสร้างไฟล์ CSV...',
                    `จำนวนตาราง: ${selectedTables.length} ตาราง`,
                    `ตาราง: ${selectedTables.join(', ')}`,
                    'กรุณารอสักครู่'
                ]);

                // เรียก API export
                fetch('services/export.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            tables: selectedTables
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.error || 'Export failed');
                            });
                        }

                        // ดึงชื่อไฟล์จาก header
                        const contentDisposition = response.headers.get('Content-Disposition');
                        const filenameMatch = contentDisposition && contentDisposition.match(/filename="(.+)"/);
                        const filename = filenameMatch ? filenameMatch[1] : `tables_export_${new Date().toISOString().slice(0,10)}.zip`;

                        return response.blob().then(blob => {
                            // สร้างลิงก์สำหรับดาวน์โหลด
                            const url = window.URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = filename;
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(url);

                            // อัพเดทสถานะ
                            statusIndicator.className = 'badge bg-success';
                            statusIndicator.textContent = 'ส่งออกสำเร็จ';
                            updateStatusList([
                                '<span class="text-success">ส่งออกไฟล์ CSV สำเร็จ!</span>',
                                `ชื่อไฟล์: ${filename}`,
                                `จำนวนตารางที่ส่งออก: ${selectedTables.length} ตาราง`,
                                'ไฟล์ที่ดาวน์โหลดเป็นรูปแบบ ZIP ที่มีไฟล์ CSV ภายใน',
                                'คุณสามารถเลือกตารางอื่นเพิ่มแล้วส่งออกใหม่ได้'
                            ]);
                        });
                    })
                    .catch(error => {
                        showError(error.message);
                    })
                    .finally(() => {
                        // คืนสถานะปุ่มเป็นปกติ
                        exportBtn.innerHTML = '<i class="fas fa-file-export me-2"></i>Export ตารางที่เลือกเป็น CSV';
                        exportBtn.disabled = false;
                    });
            });
            exportBtn.addEventListener('_click', function() {
                if (selectedTables.length === 0) {
                    showError('กรุณาเลือกตารางที่ต้องการ export อย่างน้อย 1 ตาราง');
                    return;
                }

                hideError();

                // แสดงสถานะกำลังโหลด
                exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>กำลังสร้างไฟล์...';
                exportBtn.disabled = true;

                // อัพเดทสถานะ
                statusIndicator.className = 'badge bg-warning';
                statusIndicator.textContent = 'กำลังสร้างไฟล์';
                updateStatusList([
                    'กำลังสร้างไฟล์ Excel...',
                    `จำนวนตาราง: ${selectedTables.length} ตาราง`,
                    `ตาราง: ${selectedTables.join(', ')}`,
                    'กรุณารอสักครู่'
                ]);

                // เรียก API export
                fetch('services/export.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            tables: selectedTables
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.error || 'Export failed');
                            });
                        }

                        // ดึงชื่อไฟล์จาก header
                        const contentDisposition = response.headers.get('Content-Disposition');
                        const filenameMatch = contentDisposition && contentDisposition.match(/filename="(.+)"/);
                        const filename = filenameMatch ? filenameMatch[1] : `tables_export_${new Date().toISOString().slice(0,10)}.xlsx`;

                        return response.blob().then(blob => {
                            // สร้างลิงก์สำหรับดาวน์โหลด
                            const url = window.URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = filename;
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(url);

                            // อัพเดทสถานะ
                            statusIndicator.className = 'badge bg-success';
                            statusIndicator.textContent = 'ส่งออกสำเร็จ';
                            updateStatusList([
                                '<span class="text-success">ส่งออกไฟล์ Excel สำเร็จ!</span>',
                                `ชื่อไฟล์: ${filename}`,
                                `จำนวนตารางที่ส่งออก: ${selectedTables.length} ตาราง`,
                                'คุณสามารถเลือกตารางอื่นเพิ่มแล้วส่งออกใหม่ได้'
                            ]);
                        });
                    })
                    .catch(error => {
                        showError(error.message);
                    })
                    .finally(() => {
                        // คืนสถานะปุ่มเป็นปกติ
                        exportBtn.innerHTML = '<i class="fas fa-file-export me-2"></i>Export ตารางที่เลือกเป็น Excel';
                        exportBtn.disabled = false;
                    });
            });

            // การเลือกทั้งหมด
            selectAll.addEventListener('change', function() {
                if (this.checked) {
                    // เลือกทุกตาราง
                    selectedTables = [...allTables];
                } else {
                    // ยกเลิกเลือกทั้งหมด
                    selectedTables = [];
                }

                // อัพเดท UI
                renderTables(allTables);

                // อัพเดทปุ่ม
                exportBtn.disabled = selectedTables.length === 0;

                // อัพเดทจำนวน
                updateSelectedCount();
            });

            // ล้างการเลือก
            clearSelection.addEventListener('click', function() {
                selectedTables = [];
                renderTables(allTables);
                exportBtn.disabled = true;
                selectAll.checked = false;
                updateSelectedCount();
            });

            // ค้นหาตาราง
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();

                if (!searchTerm) {
                    renderTables(allTables);
                    return;
                }

                const filteredTables = allTables.filter(table =>
                    table.toLowerCase().includes(searchTerm)
                );

                if (filteredTables.length === 0) {
                    tablesList.innerHTML = '';
                    noTablesMessage.classList.add('d-none');
                    noResultsMessage.classList.remove('d-none');
                } else {
                    renderTables(filteredTables);
                }
            });

            // เริ่มต้นดึงรายการตาราง
            fetchTables();
        });

        $(document).ready(async function() {
            try {
                loaderScreen("show");
            } catch (error) {
                sweetAlertError("เกิดข้อผิดพลาด : " + error.message, 0);
            } finally {
                loaderScreen("hide");
            }

        });
    </script>
</body>

</html>