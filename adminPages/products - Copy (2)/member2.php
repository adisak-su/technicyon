<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ระบบจัดการสมาชิก</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: "Sarabun", sans-serif;
    }
    .table-responsive {
      max-height: 500px;
      overflow-y: auto;
    }
    .modal-header, .modal-footer {
      background-color: #f8f9fa;
    }
    .pagination-container {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }
    .pagination .page-item.active .page-link {
      background-color: #0d6efd;
      border-color: #0d6efd;
      color: white;
    }
    .pagination .page-link {
      color: #0d6efd;
    }
    .select2-container--default .select2-selection--single {
      height: 38px;
      padding: 5px 12px;
    }
  </style>
  <style>
  @media (max-width: 576px) {
    .select2-container--default .select2-selection--single {
      height: 45px;
      font-size: 1rem;
    }
    .modal-dialog {
      margin: 1rem auto;
    }
  }
</style>
  <!--
<style>
/* เปลี่ยนไอคอน dropdown ของ select2 เป็นไอคอนแว่นขยาย */
.select2-container--default .select2-selection--single .select2-selection__arrow b {
  border: none !important;
  background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="gray" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>') no-repeat center center;
  width: 14px;
  height: 14px;
  display: block;
}
  -->
</style>
<style>
/* ใช้ Font Awesome แทนลูกศร ▼ ใน select2 */
/*
.select2-container--default .select2-selection--single .select2-selection__arrow b {
  border: none !important;
  position: relative;
  width: 1em;
  height: 1em;
  display: block;
}

.select2-container--default .select2-selection--single .select2-selection__arrow::after {
  content: "\f002";
  font-family: "Font Awesome 6 Free";
  font-weight: 900;
  position: absolute;
  top: 80%;
  left: 0%;
  transform: translate(-50%, -50%);
  font-size: 0.9em;
  color: gray;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
  display: none;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
  position: absolute;
  top: 0;
  bottom: 0;
  right: 10px;
  width: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  pointer-events: none;
}

.select2-container--default .select2-selection--single .select2-selection__arrow::after {
  content: "\f002";
  font-family: "Font Awesome 6 Free";
  font-weight: 900;
  font-size: 0.9em;
  color: gray;
}
  
  .select2-container--default .select2-selection--single .select2-selection__arrow {
  position: absolute;
  top: 0;
  right: 10px;
  bottom: 0;
  width: 30px;
  display: flex;
  align-items: center; // จัดแนวตั้งกลาง
  justify-content: center; // จัดแนวนอนกลาง
  pointer-events: none;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
  display: none;
}

.select2-container--default .select2-selection--single .select2-selection__arrow::after {
  content: "\f002";
  font-family: "Font Awesome 6 Free";
  font-weight: 900;
  font-size: 0.9em;
  color: gray;
  display: block;
  line-height: 1;
}
*/

.select2-container--default .select2-selection--single .select2-selection__arrow {
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  width: 20px;
  height: 20px;
  pointer-events: none;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
  display: none; /* ซ่อนไอคอนลูกศรเดิม */
}

.select2-container--default .select2-selection--single .select2-selection__arrow::after {
  content: "\f002"; /* Unicode แว่นขยาย */
  font-family: "Font Awesome 6 Free";
  font-weight: 900;
  font-size: 1rem;
  color: #888;
  display: block;
  text-align: center;
  width: 100%;
  height: 100%;
  line-height: 20px;
}
</style>
</head>
<!-- ส่วนที่เปลี่ยนคือ container และ filter/header layout -->
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ระบบจัดการสมาชิก</a>
  </div>
</nav>

<div class="container-fluid mt-4">
  <div class="row gy-2 gx-3 align-items-center mb-3">
    <!-- ฟิลเตอร์ -->
    <div class="col-12 col-md-6 col-lg-4 d-flex flex-wrap gap-2 align-items-center">
      <select id="filterProvince" class="form-select" style="min-width: 180px; width: 100%">
        <option value="all">ทุกจังหวัด</option>
      </select>
      <input type="text" id="searchInput" class="form-control" placeholder="ค้นหาชื่อหรืออีเมล" style="min-width: 180px; width: 100%" />
      <button class="btn btn-outline-secondary" onclick="resetFilter()">ล้างตัวกรอง</button>
    </div>

    <!-- ปุ่มเพิ่มสมาชิก -->
    <div class="col-12 col-md-6 col-lg-8 text-md-end text-start">
      <button class="btn btn-success w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#memberModal" onclick="openAddModal()">
        + เพิ่มสมาชิก
      </button>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-light">
        <tr>
          <th style="min-width: 40px;">#</th>
          <th style="min-width: 120px;">ชื่อ-นามสกุล</th>
          <th style="min-width: 180px;">อีเมล</th>
          <th style="min-width: 120px;">จังหวัด</th>
          <th style="min-width: 140px;">การจัดการ</th>
        </tr>
      </thead>
      <tbody id="memberTable"></tbody>
    </table>
  </div>

  <div class="pagination-container mt-3">
    <nav>
      <ul class="pagination justify-content-center" id="pagination"></ul>
    </nav>
  </div>
</div>

<!-- Modal และ Script ต่าง ๆ เหมือนเดิม ใช้ของเดิมได้เลย -->

<!-- Modal เพิ่ม/แก้ไข -->
<div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="memberModalLabel">เพิ่ม/แก้ไข สมาชิก</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="memberForm">
          <input type="hidden" id="memberId">
          <div class="mb-3">
            <label for="fullName" class="form-label">ชื่อ-นามสกุล</label>
            <input type="text" class="form-control" id="fullName" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">อีเมล</label>
            <input type="email" class="form-control" id="email" required>
          </div>
          <div class="mb-3">
            <label for="province" class="form-label">จังหวัด</label>
            <select id="province" class="form-select" required style="width: 100%"></select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        <button type="button" class="btn btn-primary" onclick="saveMember()">บันทึก</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal ยืนยันลบ -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel">ยืนยันการลบ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        คุณต้องการลบสมาชิกนี้หรือไม่?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        <button type="button" class="btn btn-danger" onclick="confirmDelete()">ลบ</button>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
const provinces = ["กรุงเทพมหานคร", "เชียงใหม่", "ภูเก็ต", "ขอนแก่น", "ชลบุรี", "ระยอง", "นครราชสีมา", "เชียงราย", "อุบลราชธานี", "สุราษฎร์ธานี", "สงขลา", "นครศรีธรรมราช", "ปทุมธานี", "นนทบุรี", "สมุทรปราการ", "ลำปาง", "ลำพูน", "สุโขทัย", "พิษณุโลก", "เพชรบูรณ์", "นครสวรรค์", "ชัยภูมิ", "เลย", "หนองคาย", "อุดรธานี", "มหาสารคาม", "ร้อยเอ็ด", "สกลนคร", "นครพนม", "มุกดาหาร", "ศรีสะเกษ", "บุรีรัมย์", "สุรินทร์", "กาฬสินธุ์", "อำนาจเจริญ", "ยโสธร", "นครนายก", "สมุทรสาคร", "สมุทรสงคราม", "เพชรบุรี", "ประจวบคีรีขันธ์", "ราชบุรี", "กาญจนบุรี", "สุพรรณบุรี", "นครปฐม", "สระบุรี", "พระนครศรีอยุธยา", "อ่างทอง", "ลพบุรี", "สิงห์บุรี", "ชัยนาท", "อุทัยธานี", "ตาก", "กำแพงเพชร", "พิจิตร", "พะเยา", "แพร่", "น่าน", "แม่ฮ่องสอน", "ตรัง", "สตูล", "พัทลุง", "ปัตตานี", "ยะลา", "นราธิวาส", "ตราด", "จันทบุรี", "ปราจีนบุรี", "สระแก้ว", "ฉะเชิงเทรา", "ระนอง", "ชุมพร"];

let members = [];
let currentPage = 1;
const perPage = 10;
let editId = null;
let deleteId = null;

function generateMockData() {
  for (let i = 1; i <= 1000; i++) {
    members.push({
      id: i,
      fullName: `สมาชิก ${i}`,
      email: `user${i}@example.com`,
      province: provinces[Math.floor(Math.random() * provinces.length)]
    });
  }
}

function renderFilterOptions() {
  const filter = document.getElementById('filterProvince');
  provinces.forEach(p => {
    const option = document.createElement('option');
    option.value = p;
    option.textContent = p;
    filter.appendChild(option);
  });

  const province = document.getElementById('province');
  provinces.forEach(p => {
    const option = document.createElement('option');
    option.value = p;
    option.textContent = p;
    province.appendChild(option);
  });
}

function renderTable() {
  const tbody = document.getElementById('memberTable');
  tbody.innerHTML = '';
  const filter = document.getElementById('filterProvince').value;
  const searchText = document.getElementById('searchInput').value.trim().toLowerCase();

  let filtered = members;

  if (filter !== 'all') {
    filtered = filtered.filter(m => m.province === filter);
  }

  if (searchText) {
    filtered = filtered.filter(m =>
      m.fullName.toLowerCase().includes(searchText) ||
      m.email.toLowerCase().includes(searchText)
    );
  }

  const totalPages = Math.ceil(filtered.length / perPage);
  const start = (currentPage - 1) * perPage;
  const pageItems = filtered.slice(start, start + perPage);

  for (let i = 0; i < pageItems.length; i++) {
    const m = pageItems[i];
    tbody.insertAdjacentHTML('beforeend', `
      <tr>
        <td>${start + i + 1}</td>
        <td>${m.fullName}</td>
        <td>${m.email}</td>
        <td>${m.province}</td>
        <td>
          <button class="btn btn-sm btn-warning" onclick="openEditModal(${m.id})">แก้ไข</button>
          <button class="btn btn-sm btn-danger" onclick="prepareDelete(${m.id})">ลบ</button>
        </td>
      </tr>
    `);
  }

  renderPagination(currentPage, totalPages);
}

function renderPagination(current, total) {
  const pagination = document.getElementById('pagination');
  pagination.innerHTML = '';

  const addPage = (page, label = page, active = false, disabled = false) => {
    const li = document.createElement('li');
    li.className = `page-item${active ? ' active' : ''}${disabled ? ' disabled' : ''}`;
    const a = document.createElement('a');
    a.className = 'page-link';
    a.href = '#';
    a.textContent = label;
    a.onclick = (e) => {
      e.preventDefault();
      if (!disabled && page) {
        currentPage = page;
        renderTable();
      }
    };
    li.appendChild(a);
    pagination.appendChild(li);
  };

  addPage(current - 1, '«', false, current === 1);
  for (let i = 1; i <= total; i++) {
    if (i === 1 || i === total || Math.abs(i - current) <= 2) {
      addPage(i, i, current === i);
    } else if (i === 2) {
      //addPage(null, '...');
      addPage(parseInt(current/2), '...');
    } else if (i === total - 1) {
      //addPage(null, '...');
      addPage(total-parseInt((total-current)/2), '...');
    } /*else if (i === 2 || i === total - 1) {
      addPage(null, '...');
    }*/
  }
  addPage(current + 1, '»', false, current === total);
}

function openAddModal() {
  editId = null;
  document.getElementById('memberForm').reset();
  $('#province').val('').trigger('change');
  $('#memberModalLabel').text('เพิ่มสมาชิก');
}

function openEditModal(id) {
  const m = members.find(x => x.id === id);
  if (m) {
    editId = id;
    document.getElementById('memberId').value = m.id;
    document.getElementById('fullName').value = m.fullName;
    document.getElementById('email').value = m.email;
    $('#province').val(m.province).trigger('change');
    $('#memberModalLabel').text('แก้ไขสมาชิก');
    new bootstrap.Modal(document.getElementById('memberModal')).show();
  }
}

function saveMember() {
  const id = editId || members.length + 1;
  const fullName = document.getElementById('fullName').value.trim();
  const email = document.getElementById('email').value.trim();
  const province = document.getElementById('province').value;

  if (!fullName || !email || !province) {
    alert('กรุณากรอกข้อมูลให้ครบถ้วน');
    return;
  }

  const member = { id, fullName, email, province };
  if (editId) {
    const index = members.findIndex(m => m.id === editId);
    if (index !== -1) members[index] = member;
  } else {
    members.push(member);
  }

  bootstrap.Modal.getInstance(document.getElementById('memberModal')).hide();
  renderTable();
}

function prepareDelete(id) {
  deleteId = id;
  new bootstrap.Modal(document.getElementById('confirmDeleteModal')).show();
}

function confirmDelete() {
  members = members.filter(m => m.id !== deleteId);
  bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal')).hide();
  renderTable();
}

function resetFilter() {
  $('#filterProvince').val('all').trigger('change');
  document.getElementById('searchInput').value = '';
  currentPage = 1;
  renderTable();
}

$(document).ready(function () {
  generateMockData();
  renderFilterOptions();

  $('#filterProvince').select2({ width: '200px' });

  $('#province').select2({
    dropdownParent: $('#memberModal'),
    placeholder: 'เลือกจังหวัด',
    allowClear: true,
    width: '100%'
  });

  $('#filterProvince').on('change', function () {
    currentPage = 1;
    renderTable();
  });

  $('#searchInput').on('input', function () {
    currentPage = 1;
    renderTable();
  });

  renderTable();
});
</script>
</body>
</html>