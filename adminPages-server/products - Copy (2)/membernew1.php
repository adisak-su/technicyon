<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ระบบจัดการสมาชิก</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar bg-dark navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">ระบบจัดการสมาชิก</a>
    </div>
  </nav>

  <!-- Main Container -->
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <select id="filterProvince" class="form-select" style="width: 200px">
        <option value="">ทุกจังหวัด</option>
      </select>
      <button class="btn btn-primary" onclick="openModal()">➕ เพิ่มสมาชิก</button>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th>ชื่อ</th>
            <th>นามสกุล</th>
            <th>อีเมล</th>
            <th>จังหวัด</th>
            <th>การจัดการ</th>
          </tr>
        </thead>
        <tbody id="memberTable"></tbody>
      </table>
    </div>

    <nav>
      <ul class="pagination justify-content-center" id="pagination"></ul>
    </nav>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="memberModal" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" onsubmit="saveMember(event)">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">เพิ่มสมาชิก</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="memberId">
          <div class="mb-2">
            <label>ชื่อ</label>
            <input type="text" class="form-control" id="firstName" required>
          </div>
          <div class="mb-2">
            <label>นามสกุล</label>
            <input type="text" class="form-control" id="lastName" required>
          </div>
          <div class="mb-2">
            <label>อีเมล</label>
            <input type="email" class="form-control" id="email" required>
          </div>
          <div class="mb-2">
            <label>จังหวัด</label>
            <select id="province" class="form-select" required style="width: 100%"></select>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
          <button type="submit" class="btn btn-primary">บันทึก</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    const provinces = [
      "กรุงเทพมหานคร", "กระบี่", "กาญจนบุรี", "กาฬสินธุ์", "กำแพงเพชร", "ขอนแก่น", "จันทบุรี", "ฉะเชิงเทรา",
      "ชลบุรี", "ชัยนาท", "ชัยภูมิ", "ชุมพร", "เชียงราย", "เชียงใหม่", "ตรัง", "ตราด", "ตาก", "นครนายก",
      "นครปฐม", "นครพนม", "นครราชสีมา", "นครศรีธรรมราช", "นครสวรรค์", "นนทบุรี", "นราธิวาส", "น่าน",
      "บึงกาฬ", "บุรีรัมย์", "ปทุมธานี", "ประจวบคีรีขันธ์", "ปราจีนบุรี", "ปัตตานี", "พระนครศรีอยุธยา",
      "พะเยา", "พังงา", "พัทลุง", "พิจิตร", "พิษณุโลก", "เพชรบุรี", "เพชรบูรณ์", "แพร่", "พรรณานิคม",
      "ภูเก็ต", "มหาสารคาม", "มุกดาหาร", "แม่ฮ่องสอน", "ยโสธร", "ยะลา", "ร้อยเอ็ด", "ระนอง", "ระยอง",
      "ราชบุรี", "ลพบุรี", "ลำปาง", "ลำพูน", "เลย", "ศรีสะเกษ", "สกลนคร", "สงขลา", "สตูล", "สมุทรปราการ",
      "สมุทรสงคราม", "สมุทรสาคร", "สระแก้ว", "สระบุรี", "สิงห์บุรี", "สุโขทัย", "สุพรรณบุรี", "สุราษฎร์ธานี",
      "สุรินทร์", "หนองคาย", "หนองบัวลำภู", "อ่างทอง", "อุดรธานี", "อุทัยธานี", "อุตรดิตถ์", "อุบลราชธานี", "อำนาจเจริญ"
    ];

    let members = [], filtered = [], currentPage = 1, pageSize = 10, editId = null;

    document.addEventListener("DOMContentLoaded", () => {
      generateMembers();
      initProvinceDropdowns();
      renderTable();
      renderPagination();
    });

    function generateMembers() {
      const fn = ["สมชาย", "สมศรี", "อนันต์", "วิไล", "นิคม", "จิตรา", "เอกชัย", "พรทิพย์"];
      const ln = ["ใจดี", "วงศ์สุข", "สุนทร", "ชัยมงคล", "วัฒนธรรม", "ศรีทอง", "เกษมสุข", "รัตนพงศ์"];
      members = Array.from({ length: 1000 }, (_, i) => ({
        id: i + 1,
        firstName: fn[Math.floor(Math.random() * fn.length)],
        lastName: ln[Math.floor(Math.random() * ln.length)],
        email: `user${i + 1}@example.com`,
        province: provinces[Math.floor(Math.random() * provinces.length)]
      }));
      filtered = [...members];
    }

    function initProvinceDropdowns() {
      const filter = document.getElementById("filterProvince");
      const select = document.getElementById("province");
      provinces.forEach(p => {
        filter.add(new Option(p, p));
        select.add(new Option(p, p));
      });
      $('#province').select2({ dropdownParent: $('#memberModal') });
      $('#filterProvince').select2().on('change', () => {
        const val = filter.value;
        filtered = val ? members.filter(m => m.province === val) : [...members];
        currentPage = 1;
        renderTable();
        renderPagination();
      });
    }

    function renderTable() {
      const tbody = document.getElementById("memberTable");
      tbody.innerHTML = "";
      const start = (currentPage - 1) * pageSize;
      filtered.slice(start, start + pageSize).forEach(m => {
        tbody.innerHTML += `
          <tr>
            <td>${m.firstName}</td>
            <td>${m.lastName}</td>
            <td>${m.email}</td>
            <td>${m.province}</td>
            <td>
              <button class="btn btn-warning btn-sm me-1" onclick="editMember(${m.id})">แก้ไข</button>
              <button class="btn btn-danger btn-sm" onclick="confirmDelete(${m.id})">ลบ</button>
            </td>
          </tr>`;
      });
    }

    function renderPagination() {
      const ul = document.getElementById("pagination");
      ul.innerHTML = "";
      const totalPages = Math.ceil(filtered.length / pageSize);
      for (let i = 1; i <= totalPages; i++) {
        ul.innerHTML += `<li class="page-item ${i === currentPage ? 'active' : ''}">
          <a class="page-link" href="#" onclick="goToPage(${i})">${i}</a></li>`;
      }
    }

    function goToPage(p) {
      currentPage = p;
      renderTable();
      renderPagination();
    }

    function openModal() {
      editId = null;
      document.getElementById("memberId").value = "";
      document.getElementById("firstName").value = "";
      document.getElementById("lastName").value = "";
      document.getElementById("email").value = "";
      $('#province').val("").trigger("change");
      document.getElementById("modalTitle").innerText = "เพิ่มสมาชิก";
      new bootstrap.Modal(document.getElementById("memberModal")).show();
    }

    function editMember(id) {
      const m = members.find(m => m.id === id);
      if (!m) return;
      editId = id;
      document.getElementById("memberId").value = m.id;
      document.getElementById("firstName").value = m.firstName;
      document.getElementById("lastName").value = m.lastName;
      document.getElementById("email").value = m.email;
      $('#province').val(m.province).trigger("change");
      document.getElementById("modalTitle").innerText = "แก้ไขสมาชิก";
      new bootstrap.Modal(document.getElementById("memberModal")).show();
    }

    function saveMember(e) {
      e.preventDefault();
      const id = editId;
      const fn = document.getElementById("firstName").value.trim();
      const ln = document.getElementById("lastName").value.trim();
      const email = document.getElementById("email").value.trim();
      const province = document.getElementById("province").value;
      if (!fn || !ln || !email || !province) return alert("กรุณากรอกข้อมูลให้ครบ");

      if (id) {
        const idx = members.findIndex(m => m.id === id);
        members[idx] = { id, firstName: fn, lastName: ln, email, province };
      } else {
        const newId = members.length ? Math.max(...members.map(m => m.id)) + 1 : 1;
        members.push({ id: newId, firstName: fn, lastName: ln, email, province });
      }

      filtered = [...members];
      $('#filterProvince').val('').trigger("change");
      bootstrap.Modal.getInstance(document.getElementById("memberModal")).hide();
      renderTable();
      renderPagination();
    }

    function confirmDelete(id) {
      const m = members.find(m => m.id === id);
      Swal.fire({
        title: `ลบ ${m.firstName} ${m.lastName}?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "ลบ",
        cancelButtonText: "ยกเลิก"
      }).then(res => {
        if (res.isConfirmed) {
          members = members.filter(m => m.id !== id);
          filtered = [...members];
          renderTable();
          renderPagination();
        }
      });
    }
  </script>
</body>
</html>