<!DOCTYPE html><html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>จัดการสินค้า</title>
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
   


/* CSS */
.button-33 {
  padding: 12px 26px;
  color: #fff;
  border: 0;
  font-weight: bold;
  font-size: 16px;
  transition: all 150ms ease-in-out;

  border-radius: 12px;
  box-shadow: rgba(255, 255, 255, 0.2) 0 1px 1px 0 inset, 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06), rgba(0, 0, 0, 0.9) 0px 0px 0px 1px;
  background: linear-gradient(180deg, #404146 0%, #272729 100%);
}

.button-33:hover {
  filter: brightness(1.1);
}

.button-33:active {
  transform: scale(.95);
}



/* CSS */
.button-24 {
  background-color: transparent;
  background-image: linear-gradient(#fff, #f5f5fa);
  border: 0 solid #003dff;
  border-radius: 9999px;
  box-shadow: rgba(37, 44, 97, .15) 0 4px 11px 0, rgba(93, 100, 148, .2) 0 1px 3px 0;
  box-sizing: border-box;
  color: #484c7a;
  cursor: pointer;
  display: inline-block;
  font-family: Hind, system-ui, BlinkMacSystemFont, -apple-system, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
  font-weight: 600;
  margin: 4px;
  padding: 16px 24px;
  text-align: center;
  text-decoration: inherit;
  text-wrap: nowrap;
  transition: all .2s ease-out;
  transition-behavior: normal;
  white-space-collapse: collapse;
  line-height: 1.15;
}

@media (min-width: 576px) {
  .button-24 {
    padding-bottom: 10px;
    padding-top: 10px;
  }
}

.button-24:after, .button-24:before, .div-flex-items-center-justify-center:after, .div-flex-items-center-justify-center:before, .span-flex-items-center-h-16-w-auto-mr-8-py-2-flex-grow-0-flex-shrink-0-fill-current:after, .span-flex-items-center-h-16-w-auto-mr-8-py-2-flex-grow-0-flex-shrink-0-fill-current:before, .svg-block-h-full:after, .svg-block-h-full:before {
  border: 0 solid #003dff;
  box-sizing: border-box;
}

.button-24:hover {
  box-shadow: rgba(37, 44, 97, .15) 0 8px 22px 0, rgba(93, 100, 148, .2) 0 4px 6px 0;
}

.button-24:disabled {
  cursor: not-allowed;
  opacity: .5;
}

/* CSS */
.button-41 {
  margin: 10px;
  padding: 12px 26px;
  border: 0;
  font-size: 16px;
  transition: all 150ms ease-in-out;

  border-radius: 14px;
  font-weight: 600;

  color: #fff;
  background-color: transparent;
  background-image: radial-gradient(50% 115% at 50% -5%, rgba(255, 255, 255, 0.11) 0%, transparent 100%);
  box-shadow: inset 0 0px 10px 0px rgba(255, 255, 255, 0.14), inset 0px 5px 10px 0px rgba(255, 255, 255, 0.11), inset 0px 2px 5px 0px rgba(255, 255, 255, 0.4), inset 0px 3px 20px 0px rgba(0, 0, 0, 0.25);
}

.button-41:hover {
  background-color: rgba(255, 255, 255, 0.05);
}

.button-41:active {
  transform: scale(.95);
}
  .input-41 {
  margin: 10px;
  padding: 12px 26px;
  border: 0;
  font-size: 16px;
  transition: all 150ms ease-in-out;

  border-radius: 14px;
  font-weight: 600;

  //color: #fff;
  background-color: transparent;
  background-image: radial-gradient(50% 115% at 50% -5%, rgba(255, 255, 255, 0.11) 0%, transparent 100%);
  box-shadow: inset 0 0px 10px 0px rgba(255, 255, 255, 0.14), inset 0px 5px 10px 0px rgba(255, 255, 255, 0.11), inset 0px 2px 5px 0px rgba(255, 255, 255, 0.4), inset 0px 3px 20px 0px rgba(0, 0, 0, 0.25);
}


.input-41:active {
  transform: scale(.95);
}
  .input-41:focus {
  outline: none;
    outline: 2px solid #000000;
}
  button:active {
    
    transform: scale(.95);
  }
  

/* CSS */
.button-53 {
  padding: 12px 26px;
  border: 0;
  font-size: 16px;
  transition: all 150ms ease-in-out;

  border-radius: 8px;
  font-weight: 600;

  color: #000;

  border-radius: 10px;
  background: linear-gradient(180deg, rgba(255, 255, 255, 0.00) 70.48%, #FFF 93.62%, rgba(255, 255, 255, 0.00) 100%), linear-gradient(180deg, rgba(30, 54, 87, 0.00) 0%, rgba(30, 54, 87, 0.01) 100%), #FAFAFA;
  border: none;
  box-shadow: rgba(0, 0, 0, 0.08) 0 0 0 1px, rgba(0, 0, 0, 0.08) 0 -2px 1px 0 inset, rgba(255, 255, 255, 0.5) 0 2px 1px 0 inset, 0 2px 5px -1px rgba(0, 0, 0, 0.05), 0 1px 3px -1px rgba(0, 0, 0, 0.3);
  text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.12);
}

.button-53:hover {
  background-color: #F5F5F5;
}

.button-53:active {
  background-color: #F1F1F1;
  box-shadow: rgba(0, 0, 0, 0.08) 0 0 0 1px, rgba(0, 0, 0, 0.08) 0 1px 1px 0 inset, rgba(255, 255, 255, 0.1) 0 2px 1px 0 inset, 0 2px 5px -1px rgba(0, 0, 0, 0.05);
}
.boxx {
  padding: 12px 26px;
  border: 0;
  font-size: 16px;
  font-weight: 600;
  border-radius: 12px;
  //box-shadow: inset 0 0px 10px 0px rgba(255, 255, 255, 0.14), inset 0px 5px 10px 0px rgba(255, 255, 255, 0.11), inset 0px 2px 5px 0px rgba(255, 255, 255, 0.4), inset 0px 3px 20px 0px rgba(0, 0, 0, 0.25);
  background-image: inset 0 0px 10px 0px rgba(255, 255, 255, 0.14), inset 0px 5px 10px 0px rgba(255, 255, 255, 0.11), inset 0px 2px 5px 0px rgba(255, 255, 255, 0.4), inset 0px 3px 20px 0px rgba(0, 0, 0, 0.25);

  background-image: radial-gradient(50% 115% at 50% -5%, rgba(255, 255, 255, 0.11) 0%, transparent 100%);
  box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
}
  
  
/* CSS */
.button-83 {
  appearance: button;
  background-color: transparent;
  //background-image: linear-gradient(to bottom, #fff, #f8eedb);
  border: 0 solid #e5e7eb;
  border-radius: .5rem;
  box-sizing: border-box;
  color: #482307;
  column-gap: 1rem;
  cursor: pointer;
  display: flex;
  font-family: ui-sans-serif,system-ui,-apple-system,system-ui,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
  font-size: 100%;
  font-weight: 700;
  line-height: 24px;
  margin: 0;
  outline: 2px solid transparent;
  padding: 1rem 1.5rem;
  text-align: center;
  text-transform: none;
  transition: all .1s cubic-bezier(.4, 0, .2, 1);
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  box-shadow: -6px 8px 10px rgba(81,41,10,0.1),0px 2px 2px rgba(81,41,10,0.2);
}

.button-83:active {
  //background-color: #f3f4f6;
  box-shadow: -1px 2px 5px rgba(81,41,10,0.15),0px 1px 1px rgba(81,41,10,0.15);
  transform: translateY(0.125rem);
}

.button-83:focus {
  box-shadow: rgba(72, 35, 7, .46) 0 0 0 4px, -6px 8px 10px rgba(81,41,10,0.1), 0px 2px 2px rgba(81,41,10,0.2);
}
  
/* CSS */
.button-71 {
  background-color: #0078d0;
  border: 0;
  border-radius: 56px;
  color: #fff;
  cursor: pointer;
  display: inline-block;
  font-family: system-ui,-apple-system,system-ui,"Segoe UI",Roboto,Ubuntu,"Helvetica Neue",sans-serif;
  font-size: 18px;
  font-weight: 600;
  outline: 0;
  padding: 16px 21px;
  position: relative;
  text-align: center;
  text-decoration: none;
  transition: all .3s;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-71:before {
  background-color: initial;
  background-image: linear-gradient(#fff 0, rgba(255, 255, 255, 0) 100%);
  border-radius: 125px;
  content: "";
  height: 50%;
  left: 4%;
  opacity: .5;
  position: absolute;
  top: 0;
  transition: all .3s;
  width: 92%;
}

.button-71:hover {
  box-shadow: rgba(255, 255, 255, .2) 0 3px 15px inset, rgba(0, 0, 0, .1) 0 3px 5px, rgba(0, 0, 0, .1) 0 10px 13px;
  transform: scale(1.05);
}

@media (min-width: 768px) {
  .button-71 {
    padding: 16px 48px;
  }
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
      <!-- HTML !-->
<button class="button-71 btn-success" role="button">Button 71</button>

      <!-- HTML !-->
<button class="button-83 btn btn-primary" role="button">Button 83</button>

<button class="button-24 bg-primary" role="button">
  <span class="text">Button 24</span>
</button>
<button class="button-33" role="button">
  <span class="text">Button 33</span>
</button>
      <!-- HTML !-->
<button class="button-41 bg-primary" role="button">
  <span class="text">Button 41</span>
</button>
      <input class="input-41" />
      <input class="boxx" />
      <button class="btn btn-primary boxx">
        <span class="text">Button boxx</span>
      </button>
      <button class="boxx btn btn-success">
        <span class="text">Button boxx</span>
      </button>
      <button class="button-41 bg-success" role="button">
  <span class="text">Button 41</span>
</button>
      <!-- HTML !-->
<button class="button-53 bg-primary" role="button">
  <span class="text">Button 53</span>
</button>
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
  <!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
  $('#productForm1').submit(e => {
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
  
  $('#productForm').submit(e => {
  e.preventDefault();
  const index = $('#productIndex').val();
  const isEdit = !!index;

  const newProduct = {
    productId: isEdit ? products[index].productId : `P${(products.length + 1).toString().padStart(4, '0')}`,
    name: $('#productName').val(),
    price: parseFloat($('#productPrice').val()).toFixed(2),
    group: $('#productGroup').val(),
    type: $('#productType').val(),
  };

  if (isEdit) {
    products[index] = newProduct;
  } else {
    products.push(newProduct);
  }

  filteredProducts = [...products];
  $('#productModal').modal('hide');
  renderTable();

  Swal.fire({
    icon: 'success',
    title: isEdit ? 'แก้ไขข้อมูลสำเร็จ' : 'เพิ่มสินค้าเรียบร้อย',
    timer: 1500,
    showConfirmButton: false
  });
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
  
function _deleteProduct(index) {
  const productId = filteredProducts[index].productId;
  products = products.filter(p => p.productId !== productId);
  filteredProducts = [...products];
  renderTable();
}
  
function deleteProduct(index) {
  const p = filteredProducts[index];
  const realIndex = products.findIndex(prod => prod.productId === p.productId);

  Swal.fire({
    title: 'ยืนยันการลบ?',
    text: `คุณต้องการลบ "${p.name}" ใช่หรือไม่?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'ลบ',
    cancelButtonText: 'ยกเลิก'
  }).then((result) => {
    if (result.isConfirmed) {
      products.splice(realIndex, 1);
      filteredProducts = [...products];
      renderTable();
      Swal.fire('ลบแล้ว!', 'สินค้าถูกลบเรียบร้อย', 'success');
    }
  });
}
  

</script></body>
</html>