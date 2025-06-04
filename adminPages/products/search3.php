<!DOCTYPE html><html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Choices จัดการสินค้า</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<!-- ลบ Select2 -->
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->

<!-- เพิ่ม Choices.js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<style>
    .select2-container--bootstrap5 .select2-selection--single {
      height: calc(1.5em + 0.75rem + 2px);
      padding: 0.375rem 0.75rem;
    }
    .select2-container--bootstrap5 .select2-selection__rendered {
      line-height: 1.5;
    }
    .select2-container--bootstrap5 .select2-selection__arrow {
      height: calc(1.5em + 0.75rem + 2px);
      top: 0.375rem;
    }
    .select2-container--bootstrap5 .select2-results__options {
      max-height: 200px;
      overflow-y: auto;
    }
    
  </style>
  <style>
  /* Fix border of select2 dropdown in modal */
  .select2-container--default .select2-dropdown {
    border: 1px solid #ced4da !important; /* สีขอบเหมือน input */
    z-index: 1056 !important; /* สูงกว่า modal backdrop */
  }
</style>
</head>
<body>
<div class="container my-4">
  <h2 class="mb-4">ระบบจัดการสินค้า</h2>  <div class="row g-2 mb-3">
    <div class="col-md-3">
      <input id="searchInput" type="text" class="form-control" placeholder="ค้นหาชื่อสินค้า..." />
    </div>
    <div class="col-md-3">
      <select id="filterGroup" class="form-select"><option value="">ทุกกลุ่ม</option></select>
    </div>
    <div class="col-md-3">
      <select id="filterType" class="form-select"><option value="">ทุกประเภท</option></select>
    </div>
    <div class="col-md-3 text-end">
      <button class="btn btn-primary" id="btnAdd">เพิ่มสินค้า</button>
    </div>
  </div>  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>รหัส</th>
          <th>ชื่อสินค้า</th>
          <th>ราคา</th>
          <th>กลุ่ม</th>
          <th>ประเภท</th>
          <th style="width:130px;">จัดการ</th>
        </tr>
      </thead>
      <tbody id="productTableBody"></tbody>
    </table>
  </div>  <nav>
    <ul id="pagination" class="pagination justify-content-center"></ul>
  </nav>
</div><!-- Modal เพิ่ม/แก้ไข --><div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog">
    <form id="productForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">เพิ่มสินค้า</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="productIndex" />
        <div class="mb-2">
          <label for="productName" class="form-label">ชื่อสินค้า</label>
          <input type="text" id="productName" class="form-control" required />
        </div>
        <div class="mb-2">
          <label for="productPrice" class="form-label">ราคา</label>
          <input type="number" id="productPrice" class="form-control" step="0.01" min="0" required />
        </div>
        <div class="mb-2">
          <label for="productGroup" class="form-label">กลุ่ม</label>
          <select id="productGroup" class="form-select" required><option></option></select>
        </div>
        <div class="mb-2">
          <label for="productType" class="form-label">ประเภท</label>
          <select id="productType" class="form-select" required><option></option></select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">บันทึก</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
      </div>
    </form>
  </div>
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
  <script>
const groupNames = Array.from({ length: 1000 }, (_, i) => `กลุ่มที่ ${i + 1}`);
const typeNames = Array.from({ length: 1000 }, (_, i) => `ประเภทที่ ${i + 1}`);
let products = Array.from({ length: 2000 }, (_, i) => ({
  productId: `P${(i + 1).toString().padStart(4, '0')}`,
  name: `สินค้า ${i + 1}`,
  price: (Math.random() * 1000).toFixed(2),
  group: groupNames[Math.floor(Math.random() * groupNames.length)],
  type: typeNames[Math.floor(Math.random() * typeNames.length)],
}));

let filteredProducts = [...products];
let currentPage = 1;
const itemsPerPage = 10;

let groupChoices, typeChoices, filterGroupChoices, filterTypeChoices;

$(document).ready(function () {
  // สร้าง Choices instance
  groupChoices = new Choices('#productGroup', { shouldSort: false });
  typeChoices = new Choices('#productType', { shouldSort: false });
  filterGroupChoices = new Choices('#filterGroup', { shouldSort: false });
  filterTypeChoices = new Choices('#filterType', { shouldSort: false });

  // กำหนด options
  groupChoices.setChoices(groupNames.map(g => ({ value: g, label: g })), 'value', 'label', true);
  typeChoices.setChoices(typeNames.map(t => ({ value: t, label: t })), 'value', 'label', true);

  filterGroupChoices.setChoices([{ value: '', label: 'ทุกกลุ่ม' }, ...groupNames.map(g => ({ value: g, label: g }))], 'value', 'label', true);
  filterTypeChoices.setChoices([{ value: '', label: 'ทุกประเภท' }, ...typeNames.map(t => ({ value: t, label: t }))], 'value', 'label', true);

  // ฟิลเตอร์
  $('#searchInput, #filterGroup, #filterType').on('input change', () => {
    const keyword = $('#searchInput').val().toLowerCase();
    const groupFilter = $('#filterGroup').val();
    const typeFilter = $('#filterType').val();

    filteredProducts = products.filter(p =>
      p.name.toLowerCase().includes(keyword) &&
      (groupFilter === '' || p.group === groupFilter) &&
      (typeFilter === '' || p.type === typeFilter)
    );
    currentPage = 1;
    renderTable();
  });

  // ปุ่มเพิ่มสินค้า
  $('#btnAdd').click(() => {
    $('#productIndex').val('');
    $('#modalTitle').text('เพิ่มสินค้า');
    $('#productForm')[0].reset();
    groupChoices.setChoiceByValue('');
    typeChoices.setChoiceByValue('');
    new bootstrap.Modal(document.getElementById('productModal')).show();
  });

  // บันทึกสินค้า
  $('#productForm').submit(e => {
    e.preventDefault();
    const index = $('#productIndex').val();
    const newProduct = {
      productId: index ? products[index].productId : `P${(products.length + 1).toString().padStart(4, '0')}`,
      name: $('#productName').val(),
      price: parseFloat($('#productPrice').val()).toFixed(2),
      group: $('#productGroup').val(),
      type: $('#productType').val(),
    };
    if (index) {
      products[index] = newProduct;
    } else {
      products.push(newProduct);
    }
    filteredProducts = [...products];
    $('#productModal').modal('hide');
    renderTable();
  });

  renderTable();
});
/*
$(document).ready(function () {
  $('#productGroup, #productType').select2({
    data: [],
    theme: 'bootstrap5',
    dropdownParent: $('#productModal'),
    width: '100%'
  });

  $('#filterGroup').select2({
    data: [{ id: '', text: 'ทุกกลุ่ม' }, ...groupNames.map(g => ({ id: g, text: g }))],
    theme: 'bootstrap5',
    width: '100%'
  });

  $('#filterType').select2({
    data: [{ id: '', text: 'ทุกประเภท' }, ...typeNames.map(t => ({ id: t, text: t }))],
    theme: 'bootstrap5',
    width: '100%'
  });

  $('#productGroup').select2('destroy').select2({
    data: groupNames.map(g => ({ id: g, text: g })),
    theme: 'bootstrap5',
    dropdownParent: $('#productModal'),
    width: '100%'
  });

  $('#productType').select2('destroy').select2({
    data: typeNames.map(t => ({ id: t, text: t })),
    theme: 'bootstrap5',
    dropdownParent: $('#productModal'),
    width: '100%'
  });

  $('#searchInput, #filterGroup, #filterType').on('input change', () => {
    const keyword = $('#searchInput').val().toLowerCase();
    const groupFilter = $('#filterGroup').val();
    const typeFilter = $('#filterType').val();

    filteredProducts = products.filter(p =>
      p.name.toLowerCase().includes(keyword) &&
      (groupFilter === '' || p.group === groupFilter) &&
      (typeFilter === '' || p.type === typeFilter)
    );
    currentPage = 1;
    renderTable();
  });

  $('#btnAdd').click(() => {
    $('#productIndex').val('');
    $('#modalTitle').text('เพิ่มสินค้า');
    $('#productForm')[0].reset();
    $('#productGroup').val(null).trigger('change');
    $('#productType').val(null).trigger('change');
    new bootstrap.Modal(document.getElementById('productModal')).show();
  });

  $('#productForm').submit(e => {
  e.preventDefault();
  const index = $('#productIndex').val();
  const newProduct = {
    productId: index ? products[index].productId : `P${(products.length + 1).toString().padStart(4, '0')}`,
    name: $('#productName').val(),
    price: parseFloat($('#productPrice').val()).toFixed(2),
    group: $('#productGroup').val(),
    type: $('#productType').val(),
  };
  if (index) {
    products[index] = newProduct;
  } else {
    products.push(newProduct);
  }
  filteredProducts = [...products];
  $('#productModal').modal('hide');
  renderTable();
});

  renderTable();
});
*/
function _renderTable() {
  const start = (currentPage - 1) * itemsPerPage;
  const pageItems = filteredProducts.slice(start, start + itemsPerPage);
  $('#productTableBody').html(
    pageItems.map((p, i) => `
      <tr>
        <td>${p.id}</td>
        <td>${p.name}</td>
        <td>${p.price}</td>
        <td>${p.group}</td>
        <td>${p.type}</td>
        <td>
          <button class="btn btn-sm btn-warning" onclick="editProduct(${start + i})">แก้ไข</button>
          <button class="btn btn-sm btn-danger" onclick="deleteProduct(${start + i})">ลบ</button>
        </td>
      </tr>
    `).join('')
  );
  renderPagination();
}
  
function renderTable() {
  const start = (currentPage - 1) * itemsPerPage;
  const pageItems = filteredProducts.slice(start, start + itemsPerPage);
  $('#productTableBody').html(
    pageItems.map((p, i) => `
      <tr>
        <td>${p.productId}</td>
        <td>${p.name}</td>
        <td>${p.price}</td>
        <td>${p.group}</td>
        <td>${p.type}</td>
        <td>
          <button class="btn btn-sm btn-warning" onclick="editProduct(${start + i})">แก้ไข</button>
          <button class="btn btn-sm btn-danger" onclick="deleteProduct(${start + i})">ลบ</button>
        </td>
      </tr>
    `).join('')
  );
  renderPagination();
}

function renderPagination() {
  const totalPages = Math.ceil(filteredProducts.length / itemsPerPage);
  let html = '';

  if (totalPages <= 1) {
    $('#pagination').html('');
    return;
  }

  const createBtn = (page, text = page) => `
    <li class="page-item ${currentPage === page ? 'active' : ''}">
      <button class="page-link" onclick="gotoPage(${page})">${text}</button>
    </li>`;

  if (currentPage > 1) html += createBtn(currentPage - 1, '&laquo;');

  const pageRange = 2;
  const startPage = Math.max(1, currentPage - pageRange);
  const endPage = Math.min(totalPages, currentPage + pageRange);

  if (startPage > 1) {
    html += createBtn(1);
    if (startPage > 2) html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
  }

  for (let i = startPage; i <= endPage; i++) {
    html += createBtn(i);
  }

  if (endPage < totalPages) {
    if (endPage < totalPages - 1) html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
    html += createBtn(totalPages);
  }

  if (currentPage < totalPages) html += createBtn(currentPage + 1, '&raquo;');

  $('#pagination').html(html);
}


function gotoPage(page) {
  currentPage = page;
  renderTable();
}

function _editProduct(index) {
  const p = filteredProducts[index];
  const realIndex = products.findIndex(prod => prod.id === p.id);
  $('#productIndex').val(realIndex);
  $('#productName').val(p.name);
  $('#productPrice').val(p.price);
  $('#productGroup').val(p.group).trigger('change');
  $('#productType').val(p.type).trigger('change');
  $('#modalTitle').text('แก้ไขสินค้า');
  new bootstrap.Modal(document.getElementById('productModal')).show();
}

function _deleteProduct(index) {
  const id = filteredProducts[index].id;
  products = products.filter(p => p.id !== id);
  filteredProducts = [...products];
  renderTable();
}
  
function _editProduct(index) {
  const p = filteredProducts[index];
  const realIndex = products.findIndex(prod => prod.productId === p.productId);
  $('#productIndex').val(realIndex);
  $('#productName').val(p.name);
  $('#productPrice').val(p.price);
  $('#productGroup').val(p.group).trigger('change');
  $('#productType').val(p.type).trigger('change');
  $('#modalTitle').text('แก้ไขสินค้า');
  new bootstrap.Modal(document.getElementById('productModal')).show();
}

function editProduct(index) {
  const p = filteredProducts[index];
  const realIndex = products.findIndex(prod => prod.productId === p.productId);
  $('#productIndex').val(realIndex);
  $('#productName').val(p.name);
  $('#productPrice').val(p.price);
  groupChoices.setChoiceByValue(p.group);
  typeChoices.setChoiceByValue(p.type);
  $('#modalTitle').text('แก้ไขสินค้า');
  new bootstrap.Modal(document.getElementById('productModal')).show();
}
  
function deleteProduct(index) {
  const productId = filteredProducts[index].productId;
  products = products.filter(p => p.productId !== productId);
  filteredProducts = [...products];
  renderTable();
}
  

</script></body>
</html>