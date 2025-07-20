<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ระบบจัดการสินค้า (Offline-First)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <!-- เพิ่มภายใน <body> ก่อน container -->
<!-- สถานะ + ซิงค์ -->
<!--
<div id="statusBar" class="bg-secondary text-white py-2 text-center position-relative">
  <span id="statusIcon">🔄</span> <span id="statusText">กำลังเชื่อมต่อ...</span>
  <div class="progress">
  <div id="syncProgressBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
</div>
<div id="syncMessage" class="small text-white mt-1"></div>
</div>

<div id="statusBar" class="bg-secondary text-white py-2 text-center position-relative">
  <span id="statusIcon">🔄</span> <span id="statusText">กำลังเชื่อมต่อ...</span>
  <div class="progress position-absolute bottom-0 start-0 w-100" style="height: 4px;">
    <div id="syncProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
  </div>
  <div id="syncMessage" class="small text-white mt-1"></div>
</div>
-->

<div id="statusBar" class="bg-secondary text-white py-2 text-center position-relative">
  <span id="statusIcon">🔄</span> <span id="statusText">กำลังเชื่อมต่อ...</span>
  <div class="progress position-absolute bottom-0 start-0 w-100" style="width: 80vw;height: 4px;">
    <div id="syncProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
  </div>
  <div id="syncMessage" class="small text-white mt-1"></div>
</div>

<!-- เสียงเตือน -->
<audio id="onlineSound" preload="auto">
  <source src="../../assets/audio/beep-warning.mp3" type="audio/mpeg">
</audio>
  
<div class="container mt-4">
  <h3>จัดการสินค้า</h3>
  <p id="lastSyncTime">กำลังโหลดข้อมูลการซิงค์...</p>
  <div class="d-flex justify-content-between mb-3">
    <input type="text" id="searchInput" class="form-control w-50" placeholder="ค้นหาสินค้า">
    <button class="btn btn-primary" onclick="openAddModal()" data-bs-toggle="modal" data-bs-target="#productModal">เพิ่มสินค้า</button>
  </div>
  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>ชื่อสินค้า</th>
        <th>ราคา</th>
        <th>อัปเดตเมื่อ</th>
        <th>การจัดการ</th>
      </tr>
    </thead>
    <tbody id="productTableBody"></tbody>
  </table>
  <ul class="pagination" id="pagination"></ul>
</div>

<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" onsubmit="saveProduct(event)">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">เพิ่มสินค้า</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="productId">
        <div class="mb-2">
          <label>ชื่อสินค้า</label>
          <input type="text" class="form-control" id="productName" required>
        </div>
        <div class="mb-2">
          <label>ราคา</label>
          <input type="number" class="form-control" id="productPrice" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">บันทึก</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
      </div>
    </form>
  </div>
</div>

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/idb@3.0.2/build/idb.min.js"></script>

<script>
const dbName = "LocalDB", storeName = "products", metaStore = "meta", pendingStore = "pending";
let allProducts = [], currentPage = 1, pageSize = 5;
const modal = new bootstrap.Modal(document.getElementById("productModal"));

function openIndexedDB() {
  return new Promise((resolve, reject) => {
    const req = indexedDB.open(dbName, 1);
    req.onupgradeneeded = e => {
      const db = e.target.result;
      if (!db.objectStoreNames.contains(storeName)) db.createObjectStore(storeName, { keyPath: "id" });
      if (!db.objectStoreNames.contains(metaStore)) db.createObjectStore(metaStore, { keyPath: "key" });
      if (!db.objectStoreNames.contains(pendingStore)) db.createObjectStore(pendingStore, { keyPath: "id" });
    };
    req.onsuccess = e => resolve(e.target.result);
    req.onerror = e => reject(e.target.error);
  });
}

async function _syncFromAPI() {
  if (!navigator.onLine) return;

  try {
    updateOnlineStatus();
    setSyncProgress(10);

    const res = await fetch("/services/products");
    const products = await res.json();

    setSyncProgress(30);
    const db = await openIndexedDB();
    const tx = db.transaction([storeName, metaStore], "readwrite");
    const store = tx.objectStore(storeName);
    const meta = tx.objectStore(metaStore);

    products.forEach(p => store.put(p));
    setSyncProgress(60);

    meta.put({ key: "lastSyncTime", value: new Date().toISOString() });

    tx.oncomplete = () => {
      setSyncProgress(100);
      setTimeout(() => setSyncProgress(0), 500);
      loadProducts();
      displayLastSyncTime();
      updateOnlineStatus();
    };
  } catch (err) {
    console.error("Sync error:", err);
    setSyncProgress(0);
  }
}

async function __syncFromAPI() {
  if (!navigator.onLine) return;

  try {
    updateOnlineStatus();
    const start = Date.now();
    setSyncProgress(5, "เริ่มดึงข้อมูล...");

    const res = await fetch("/services/products");
    const products = await res.json();
    setSyncProgress(20, `โหลดข้อมูล ${products.length} รายการ`);

    const db = await openIndexedDB();
    const tx = db.transaction([storeName, metaStore], "readwrite");
    const store = tx.objectStore(storeName);
    const meta = tx.objectStore(metaStore);

    let count = 0;
    for (const p of products) {
      store.put(p);
      count++;
      const percent = 20 + (count / products.length) * 60;
      setSyncProgress(percent, `ซิงค์ ${count}/${products.length} | ${estimateTime(start)}`);
    }

    meta.put({ key: "lastSyncTime", value: new Date().toISOString() });

    tx.oncomplete = () => {
      setSyncProgress(100, `ซิงค์เสร็จใน ${estimateTime(start)}`);
      setTimeout(() => setSyncProgress(0, ""), 800);
      loadProducts();
      displayLastSyncTime();
      updateOnlineStatus();
    };
  } catch (err) {
    console.error("Sync error:", err);
    setSyncProgress(0, "เกิดข้อผิดพลาด");
  }
}
  
async function syncFromAPI() {
  if (!navigator.onLine) return;

  try {
    const start = Date.now();
    setSyncProgress(5, "เริ่มโหลดข้อมูลจากเซิร์ฟเวอร์...", "bg-info");

    const res = await fetch("/services/products");
    const products = await res.json();

    const db = await openIndexedDB();
    const tx = db.transaction([storeName, metaStore], "readwrite");
    const store = tx.objectStore(storeName);
    const meta = tx.objectStore(metaStore);

    let count = 0;
    for (const p of products) {
      store.put(p);
      count++;
      const percent = 5 + (count / products.length) * 60;
      setSyncProgress(percent, `โหลด ${count}/${products.length} รายการ | ${estimateTime(start)}`, "bg-info");
    }

    const now = new Date().toISOString();
    meta.put({ key: "lastSyncTime", value: now });
    meta.put({ key: "lastApiSyncTime", value: now });

    tx.oncomplete = () => {
      setSyncProgress(70, "โหลดข้อมูลเสร็จ", "bg-info");
      setTimeout(() => setSyncProgress(0, ""), 800);
      loadProducts();
      displayLastSyncTime();
    };
  } catch (err) {
    alert(err);
    console.error("API Sync Error:", err);
    setSyncProgress(100, "โหลดข้อมูลล้มเหลว", "bg-danger");
  }
}
  
async function saveProductToAPI(product) {
  if (navigator.onLine) {
    try {
      await fetch("/services/product", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(product)
      });
    } catch (err) {
      console.error("API Error, saving to pending:", err);
      await savePending(product);
    }
  } else {
    await savePending(product);
  }
}

async function savePending(item) {
  const db = await openIndexedDB();
  const tx = db.transaction(pendingStore, "readwrite");
  tx.objectStore(pendingStore).put({ ...item, _action: "save" });
}

function openAddModal() {
  document.getElementById("modalTitle").innerText = "เพิ่มสินค้า";
  document.getElementById("productId").value = "";
  document.getElementById("productName").value = "";
  document.getElementById("productPrice").value = "";
}

function openEditModal(product) {
  document.getElementById("modalTitle").innerText = "แก้ไขสินค้า";
  document.getElementById("productId").value = product.id;
  document.getElementById("productName").value = product.name;
  document.getElementById("productPrice").value = product.price;
  modal.show();
}

async function saveProduct(e) {
  e.preventDefault();
  const id = document.getElementById("productId").value;
  const name = document.getElementById("productName").value;
  const price = parseFloat(document.getElementById("productPrice").value);
  const updatedAt = new Date().toISOString();
  const product = { id: id ? parseInt(id) : Date.now(), name, price, updatedAt };
  const db = await openIndexedDB();
  const tx = db.transaction(storeName, "readwrite");
  tx.objectStore(storeName).put(product);
  tx.oncomplete = () => { modal.hide(); loadProducts(); };
  await saveProductToAPI(product);
}

function _setSyncProgress(percent, message = "") {
  const bar = document.getElementById("syncProgressBar");
  const msg = document.getElementById("syncMessage");
  bar.style.width = percent + "%";
  msg.innerText = message;
}
  
function setSyncProgress(percent, message = "", color = "bg-info") {
  const bar = document.getElementById("syncProgressBar");
  const msg = document.getElementById("syncMessage");
  bar.className = `progress-bar ${color}`;
  bar.style.width = percent + "%";
  msg.innerText = message;
}
  
function estimateTime(startTime) {
  const elapsed = (Date.now() - startTime) / 1000;
  return `${elapsed.toFixed(1)} วินาที`;
}
  
function confirmDelete(id) {
  Swal.fire({
    title: "ลบข้อมูล?", text: "คุณแน่ใจหรือไม่?", icon: "warning",
    showCancelButton: true, confirmButtonText: "ใช่, ลบเลย!", cancelButtonText: "ยกเลิก"
  }).then(async result => {
    if (result.isConfirmed) {
      await deleteProduct(id);
      Swal.fire("ลบแล้ว", "ข้อมูลถูกลบแล้ว", "success");
    }
  });
}

async function deleteProduct(id) {
  const db = await openIndexedDB();
  const tx = db.transaction([storeName, pendingStore], "readwrite");
  tx.objectStore(storeName).delete(id);
  if (navigator.onLine) {
    try {
      await fetch(`/services/product/${id}`, { method: "DELETE" });
    } catch (err) {
      console.error("Delete API Error, saving to pending");
      tx.objectStore(pendingStore).put({ id, _action: "delete" });
    }
  } else {
    tx.objectStore(pendingStore).put({ id, _action: "delete" });
  }
  tx.oncomplete = () => loadProducts();
}

function renderTable(data) {
  const body = document.getElementById("productTableBody");
  body.innerHTML = "";
  data.forEach(p => {
    body.innerHTML += `<tr>
      <td>${p.id}</td><td>${p.name}</td><td>${p.price}</td>
      <td>${new Date(p.updatedAt).toLocaleString()}</td>
      <td>
        <button class='btn btn-sm btn-warning' onclick='openEditModal(${JSON.stringify(p)})'>แก้ไข</button>
        <button class='btn btn-sm btn-danger' onclick='confirmDelete(${p.id})'>ลบ</button>
      </td></tr>`;
  });
}

function renderPagination(total) {
  const pageCount = Math.ceil(total / pageSize);
  const pag = document.getElementById("pagination");
  pag.innerHTML = "";
  for (let i = 1; i <= pageCount; i++) {
    pag.innerHTML += `<li class='page-item ${i === currentPage ? "active" : ""}'><a class='page-link' href='#' onclick='goToPage(${i})'>${i}</a></li>`;
  }
}

function goToPage(page) {
  currentPage = page;
  filterAndRender();
}

function filterAndRender() {
  const q = document.getElementById("searchInput").value.toLowerCase();
  const filtered = allProducts.filter(p => p.name.toLowerCase().includes(q));
  const pageData = filtered.slice((currentPage - 1) * pageSize, currentPage * pageSize);
  renderTable(pageData);
  renderPagination(filtered.length);
}

async function loadProducts() {
  const db = await openIndexedDB();
  const tx = db.transaction(storeName, "readonly");
  const req = tx.objectStore(storeName).getAll();
  req.onsuccess = () => { allProducts = req.result; filterAndRender(); };
}

async function displayLastSyncTime() {
  const db = await openIndexedDB();
  const req = db.transaction(metaStore).objectStore(metaStore).get("lastSyncTime");
  req.onsuccess = () => {
    const val = req.result?.value;
    document.getElementById("lastSyncTime").innerText = val ? `ซิงค์ล่าสุด: ${new Date(val).toLocaleString()}` : "ยังไม่เคยซิงค์ข้อมูล";
  };
}

async function _syncPending() {
  const db = await openIndexedDB();
  const tx = db.transaction(pendingStore, "readwrite");
  const store = tx.objectStore(pendingStore);
  const getAll = store.getAll();

  getAll.onsuccess = async () => {
    for (const item of getAll.result) {
      try {
        if (item._action === "save") {
          await fetch("/services/product", {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(item)
          });
        } else if (item._action === "delete") {
          await fetch(`/services/product/${item.id}`, { method: "DELETE" });
        }
        store.delete(item.id);
      } catch (err) {
        console.error("Sync pending item failed:", err);
      }
    }
  };
}

async function __syncPending() {
  const db = await openIndexedDB();
  const tx = db.transaction("pending", "readwrite");
  const store = tx.objectStore("pending");

  const req = store.getAll();
  req.onsuccess = async () => {
    const items = req.result;
    if (items.length === 0) return;

    const start = Date.now();
    let completed = 0;

    for (const item of items) {
      try {
        if (item.type === "PUT") {
          await fetch("/services/product", {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(item.data)
          });
        } else if (item.type === "DELETE") {
          await fetch(`/services/product/${item.id}`, { method: "DELETE" });
        }

        store.delete(item.id);
        completed++;
        const percent = 20 + (completed / items.length) * 80; // ต่อจาก API sync
        setSyncProgress(percent, `ส่งข้อมูลค้าง ${completed}/${items.length} | ${estimateTime(start)}`);
      } catch (err) {
        console.warn("Sync failed:", item, err);
      }
    }

    setSyncProgress(100, `ส่งค้างเสร็จใน ${estimateTime(start)}`);
    setTimeout(() => setSyncProgress(0, ""), 800);
  };
}
  
async function syncPending() {
  if (!navigator.onLine) return;

  const db = await openIndexedDB();
  const tx = db.transaction(["pending", metaStore], "readwrite");
  const store = tx.objectStore("pending");
  const meta = tx.objectStore(metaStore);

  const req = store.getAll();
  req.onsuccess = async () => {
    const items = req.result;
    if (items.length === 0) return;

    const start = Date.now();
    let completed = 0;
    let errorCount = 0;

    for (const item of items) {
      try {
        if (item.type === "PUT") {
          await fetch("/services/product", {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(item.data)
          });
        } else if (item.type === "DELETE") {
          await fetch(`/services/product/${item.id}`, { method: "DELETE" });
        }

        store.delete(item.id);
        completed++;
      } catch (err) {
        errorCount++;
        console.warn("Sync failed:", item, err);
      }

      const percent = 70 + (completed / items.length) * 30;
      const color = errorCount > 0 ? "bg-danger" : "bg-warning";
      const msg = `ส่งข้อมูลค้าง ${completed}/${items.length} | ${estimateTime(start)}`;
      setSyncProgress(percent, msg, color);
    }

    const now = new Date().toISOString();
    meta.put({ key: "lastPendingSyncTime", value: now });

    setTimeout(() => setSyncProgress(0, ""), 1000);

    if (errorCount > 0) {
      setSyncProgress(100, `ล้มเหลว ${errorCount} รายการ`, "bg-danger");
    }
  };
}

async function displayLastSyncTime() {
  const db = await openIndexedDB();
  const tx = db.transaction(metaStore);
  const meta = tx.objectStore(metaStore);

  const syncTimeReq = meta.get("lastSyncTime");
  const apiSyncTimeReq = meta.get("lastApiSyncTime");
  const pendingSyncTimeReq = meta.get("lastPendingSyncTime");

  syncTimeReq.onsuccess = () => {
    const val = syncTimeReq.result?.value;
    document.getElementById("lastSyncTime").innerText = val ? `ซิงค์ล่าสุด: ${new Date(val).toLocaleString()}` : "ยังไม่เคยซิงค์";
  };

  apiSyncTimeReq.onsuccess = () => {
    const val = apiSyncTimeReq.result?.value;
    console.log("GET ล่าสุด:", val ? new Date(val).toLocaleString() : "N/A");
  };

  pendingSyncTimeReq.onsuccess = () => {
    const val = pendingSyncTimeReq.result?.value;
    console.log("PUT/DELETE ล่าสุด:", val ? new Date(val).toLocaleString() : "N/A");
  };
}
  
document.getElementById("searchInput").addEventListener("input", () => {
  currentPage = 1;
  filterAndRender();
});

window.addEventListener("online", () => {
  syncFromAPI();
  syncPending();
});

window.onload = () => {
  syncFromAPI();
  displayLastSyncTime();
};
  
function updateOnlineStatus() {
  const statusBar = document.getElementById("statusBar");
  const icon = document.getElementById("statusIcon");
  const text = document.getElementById("statusText");
  if (navigator.onLine) {
    statusBar.className = "bg-success text-white py-2 text-center";
    icon.innerText = "✅";
    text.innerText = "ออนไลน์";
  } else {
    statusBar.className = "bg-danger text-white py-2 text-center";
    icon.innerText = "❌";
    text.innerText = "ออฟไลน์";
  }
}
  
function playOnlineSound() {
  document.getElementById("onlineSound").play().catch(() => {}); // บาง browser อาจ block ถ้าไม่มี interaction
}

let wasOffline = !navigator.onLine;

function updateOnlineStatus() {
  const statusBar = document.getElementById("statusBar");
  const icon = document.getElementById("statusIcon");
  const text = document.getElementById("statusText");

  if (navigator.onLine) {
    if (wasOffline) {
      playOnlineSound();
    }
    statusBar.className = "bg-success text-white py-2 text-center position-relative";
    icon.innerHTML = `<span class="spinner-border spinner-border-sm text-light me-1" role="status"></span>`;
    text.innerText = "ออนไลน์ (กำลังซิงค์...)";
  } else {
    statusBar.className = "bg-danger text-white py-2 text-center position-relative";
    icon.innerText = "❌";
    text.innerText = "ออฟไลน์";
  }

  wasOffline = !navigator.onLine;
}
  
function setSyncProgress(percent) {
  const bar = document.getElementById("syncProgressBar");
  bar.style.width = percent + "%";
}

// อัปเดตสถานะทุกครั้งที่เปลี่ยนการเชื่อมต่อ
window.addEventListener("online", () => {
  updateOnlineStatus();
  syncFromAPI();
  syncPending();
});
window.addEventListener("offline", updateOnlineStatus);

// เรียกเมื่อโหลดหน้า
window.onload = () => {
  updateOnlineStatus();
  syncFromAPI();
  displayLastSyncTime();

  setInterval(() => {
    updateOnlineStatus();
    syncFromAPI();
    syncPending();
  }, 60000);
};
</script>
</body>
</html>