
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <title>ระบบจัดการรายชื่อ</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
  <style>
    body { font-family: "Segoe UI", sans-serif; padding: 30px; background-color: #f4f4f4; }
    h2 { text-align: center; }
    #search, #addBtn { display: block; margin: 10px auto; }
    #search { padding: 10px; width: 300px; font-size: 16px; }
    #addBtn {
      padding: 10px 20px;
      background-color: #28a745;
      color: white;
      border: none;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      background: white;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    th { background-color: #f0f0f0; }
    .pagination { text-align: center; margin-top: 20px; }
    .pagination button {
      margin: 0 5px;
      padding: 8px 12px;
      font-size: 14px;
      border: none;
      background-color: #007bff;
      color: white;
      border-radius: 4px;
      cursor: pointer;
    }
    .pagination button:disabled { background-color: #ccc; }
    .action-btn {
      padding: 5px 10px;
      font-size: 14px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .edit-btn { background-color: #ffc107; color: #000; }
    .delete-btn { background-color: #dc3545; color: white; }
    .save-btn { background-color: #007bff; color: white; }
    .cancel-btn { background-color: #6c757d; color: white; }
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.4);
    }
    .modal-content {
      background-color: #fff;
      margin: 10% auto;
      padding: 20px;
      width: 320px;
      border-radius: 8px;
    }
    .modal-content input, .modal-content select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      margin-bottom: 15px;
      font-size: 14px;
    }
    .modal-buttons { text-align: center; }
    .modal-buttons button { margin: 0 5px; }
  </style>
</head>
<body>

  <h2>ตารางรายชื่อ (100 รายการ)</h2>
  <input type="text" id="search" placeholder="ค้นหาชื่อหรืออาชีพ...">
  <button id="addBtn">เพิ่มรายการ</button>
  <div id="table-container"></div>
  <div class="pagination" id="pagination"></div>

  <!-- Add Modal -->
  <div id="addModal" class="modal">
    <div class="modal-content">
      <h3>เพิ่มข้อมูลใหม่</h3>
      <input type="text" id="newName" placeholder="ชื่อ">
      <input type="number" id="newAge" placeholder="อายุ" min="0" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
      <select id="newOccupation"></select>
      <div class="modal-buttons">
        <button class="save-btn" id="saveNewBtn">บันทึก</button>
        <button class="cancel-btn" id="cancelNewBtn">ยกเลิก</button>
      </div>
    </div>
  </div>

  <!-- Edit Modal -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <h3>แก้ไขข้อมูล</h3>
      <input type="text" id="editName" placeholder="ชื่อ">
      <input type="number" id="editAge" placeholder="อายุ" min="0" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
      <select id="editOccupation"></select>
      <div class="modal-buttons">
        <button class="save-btn" id="saveEditBtn">บันทึก</button>
        <button class="cancel-btn" id="cancelEditBtn">ยกเลิก</button>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
  <script>
    const sampleNames = ['สมชาย', 'สมหญิง', 'สมปอง', 'สมฤดี', 'สมใจ', 'สมพร', 'สมศรี', 'สมทรง'];
    const occupationList = ['วิศวกร', 'นักออกแบบ', 'นักบัญชี', 'แพทย์', 'ครู', 'นักการตลาด', 'พนักงานบริษัท', 'ช่างเทคนิค', 'พยาบาล', 'ผู้จัดการ'];
    let data = Array.from({ length: 100 }, () => ({
      ชื่อ: sampleNames[Math.floor(Math.random() * sampleNames.length)],
      อายุ: Math.floor(Math.random() * 30) + 20,
      อาชีพ: occupationList[Math.floor(Math.random() * occupationList.length)]
    }));
    let rowsPerPage = 10, currentPage = 1, filteredData = [...data], editingIndex = null;
    let occupationChoices = null;

    const addModal = document.getElementById('addModal');
    const editModal = document.getElementById('editModal');
    const saveNewBtn = document.getElementById('saveNewBtn');
    const cancelNewBtn = document.getElementById('cancelNewBtn');
    const saveEditBtn = document.getElementById('saveEditBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn');

    function populateOccupationOptions() {
      const select = document.getElementById('newOccupation');
      select.innerHTML = '';
      occupationList.forEach(job => {
        const option = document.createElement('option');
        option.value = job; option.textContent = job;
        select.appendChild(option);
      });
      if (occupationChoices) occupationChoices.destroy();
      occupationChoices = new Choices(select, { searchEnabled: true, itemSelectText: '', shouldSort: false });
    }

    function populateOccupationOptionsEdit(selectedValue) {
      const select = document.getElementById('editOccupation');
      select.innerHTML = '';
      occupationList.forEach(job => {
        const option = document.createElement('option');
        option.value = job; option.textContent = job;
        if (job === selectedValue) option.selected = true;
        select.appendChild(option);
      });
      if (occupationChoices) occupationChoices.destroy();
      occupationChoices = new Choices(select, { searchEnabled: true, itemSelectText: '', shouldSort: false });
    }

    function renderTable(pageData) {
      const table = document.createElement('table');
      table.innerHTML = '<thead><tr><th>ชื่อ</th><th>อายุ</th><th>อาชีพ</th><th>จัดการ</th></tr></thead>';
      const tbody = document.createElement('tbody');
      pageData.forEach((row, index) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.ชื่อ}</td><td>${row.อายุ}</td><td>${row.อาชีพ}</td>`;
        const td = document.createElement('td');
        const editBtn = document.createElement('button');
        editBtn.textContent = 'แก้ไข';
        editBtn.className = 'action-btn edit-btn';
        editBtn.onclick = () => openEditModal(index);
        const deleteBtn = document.createElement('button');
        deleteBtn.textContent = 'ลบ';
        deleteBtn.className = 'action-btn delete-btn';
        deleteBtn.onclick = () => {
          if (confirm('ต้องการลบรายการนี้หรือไม่?')) {
            const globalIndex = (currentPage - 1) * rowsPerPage + index;
            data.splice(globalIndex, 1);
            filteredData = applyFilter();
            if ((currentPage - 1) * rowsPerPage >= filteredData.length && currentPage > 1) currentPage--;
            updateTable();
          }
        };
        td.appendChild(editBtn);
        td.appendChild(deleteBtn);
        tr.appendChild(td);
        tbody.appendChild(tr);
      });
      table.appendChild(tbody);
      document.getElementById('table-container').innerHTML = '';
      document.getElementById('table-container').appendChild(table);
    }

    function renderPagination() {
      const totalPages = Math.ceil(filteredData.length / rowsPerPage);
      const pagination = document.getElementById('pagination');
      pagination.innerHTML = '';
      const createBtn = (text, disabled = false, page = null) => {
        const btn = document.createElement('button');
        btn.textContent = text; btn.disabled = disabled;
        if (page) btn.onclick = () => { currentPage = page; updateTable(); };
        return btn;
      };
      if (totalPages <= 1) return;
      pagination.appendChild(createBtn('ย้อนกลับ', currentPage === 1, currentPage - 1));

      const range = 2;
      const pages = [];
      for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - range && i <= currentPage + range)) {
          pages.push(i);
        } else if (pages[pages.length - 1] !== '...') {
          pages.push('...');
        }
      }

      pages.forEach(p => {
        if (p === '...') {
          const span = document.createElement('span');
          span.textContent = '...';
          pagination.appendChild(span);
        } else {
          const btn = createBtn(p, p === currentPage, p);
          if (p === currentPage) btn.style.backgroundColor = '#555';
          pagination.appendChild(btn);
        }
      });

      pagination.appendChild(createBtn('ถัดไป', currentPage === totalPages, currentPage + 1));
    }

    function applyFilter() {
      const keyword = document.getElementById('search').value.toLowerCase();
      return data.filter(item => item.ชื่อ.toLowerCase().includes(keyword) || item.อาชีพ.toLowerCase().includes(keyword));
    }

    function updateTable() {
      filteredData = applyFilter();
      const start = (currentPage - 1) * rowsPerPage;
      renderTable(filteredData.slice(start, start + rowsPerPage));
      renderPagination();
    }

    document.getElementById('search').addEventListener('input', () => { currentPage = 1; updateTable(); });
    document.getElementById('addBtn').onclick = () => {
      document.getElementById('newName').value = '';
      document.getElementById('newAge').value = '';
      populateOccupationOptions();
      addModal.style.display = 'block';
    };
    cancelNewBtn.onclick = () => addModal.style.display = 'none';
    saveNewBtn.onclick = () => {
      const name = document.getElementById('newName').value.trim();
      const age = parseInt(document.getElementById('newAge').value.trim());
      const occupation = document.getElementById('newOccupation').value;
      if (name && !isNaN(age) && occupation) {
        data.unshift({ ชื่อ: name, อายุ: age, อาชีพ: occupation });
        currentPage = 1;
        addModal.style.display = 'none';
        updateTable();
      } else {
        alert("กรุณากรอกข้อมูลให้ครบถ้วน");
      }
    };

    function openEditModal(index) {
      editingIndex = index;
      const globalIndex = (currentPage - 1) * rowsPerPage + index;
      const person = data[globalIndex];
      document.getElementById('editName').value = person.ชื่อ;
      document.getElementById('editAge').value = person.อายุ;
      populateOccupationOptionsEdit(person.อาชีพ);
      editModal.style.display = 'block';
    }
    cancelEditBtn.onclick = () => editModal.style.display = 'none';
    saveEditBtn.onclick = () => {
      const name = document.getElementById('editName').value.trim();
      const age = parseInt(document.getElementById('editAge').value.trim());
      const occupation = document.getElementById('editOccupation').value;
      if (name && !isNaN(age) && occupation) {
        const globalIndex = (currentPage - 1) * rowsPerPage + editingIndex;
        data[globalIndex] = { ชื่อ: name, อายุ: age, อาชีพ: occupation };
        editModal.style.display = 'none';
        updateTable();
      } else {
        alert("กรุณากรอกข้อมูลให้ครบถ้วน");
      }
    };

    window.onclick = (e) => {
      if (e.target === addModal) addModal.style.display = 'none';
      if (e.target === editModal) editModal.style.display = 'none';
    };

    updateTable();
  </script>
</body>
</html>
