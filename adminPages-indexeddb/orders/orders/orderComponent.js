// order.js - คลาสสำหรับจัดการรายการสั่งซื้อ
class Order {
    static callbackFunction = null;
    constructor(callbackFun) {
        this.items = []; // รายการสินค้าใน order
        this.orderNumber = this.generateOrderNumber();
        this.discountAmount = 0; // ส่วนลด
        this.taxRate = 0.07; // อัตราภาษี
        this.container = null; // DOM container สำหรับแสดงผล
        Order.callbackFunction = callbackFun ?? null;
    }

    // สร้างเลขที่บิลใหม่
    generateOrderNumber() {
        const now = new Date();
        const randomNum = Math.floor(Math.random() * 1000);
        return `#${now.getDate()}${
            now.getMonth() + 1
        }${now.getFullYear()}-${randomNum}`;
    }

    // เพิ่มสินค้าใน order โดยใช้ productId
    addItem(productId, quantity = 1) {
        const product = products.find((p) => p.id === productId);
        if (!product) return;

        const existingItem = this.items.find((item) => item.id === productId);

        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            this.items.push({
                id: product.id,
                name: product.name,
                price: product.price,
                quantity: quantity,
                icon: product.icon || "🛒",
            });
        }

        // อัพเดท UI
        this.render();
    }

    // เปลี่ยนจำนวนสินค้า
    changeQuantity(itemIndex, delta) {
        if (this.items[itemIndex]) {
            this.items[itemIndex].quantity += delta;

            // ถ้าจำนวนน้อยกว่า 1 ให้ลบรายการออก
            if (this.items[itemIndex].quantity < 1) {
                this.items.splice(itemIndex, 1);
            }

            // อัพเดท UI
            this.render();
        }
    }

    // ลบสินค้าออกจาก order
    removeItem(itemIndex) {
        if (this.items[itemIndex]) {
            this.items.splice(itemIndex, 1);

            // อัพเดท UI
            this.render();
        }
    }

    // คำนวณยอดรวมก่อนหักส่วนลดและภาษี
    getSubtotal() {
        return this.items.reduce(
            (total, item) => total + item.price * item.quantity,
            0
        );
    }

    // คำนวณภาษี
    getTax() {
        return this.getSubtotal() * this.taxRate;
    }

    // คำนวณยอดรวมทั้งหมด
    getGrandTotal() {
        return this.getSubtotal() + this.getTax() - this.discountAmount;
    }

    // ใช้ส่วนลด
    applyDiscount(discountCode) {
        // ในระบบจริงควรตรวจสอบกับฐานข้อมูลส่วนลด
        if (discountCode === "DISCOUNT10") {
            this.discountAmount = this.getSubtotal() * 0.1; // ส่วนลด 10%
            this.render();
            return true;
        } else if (discountCode) {
            return false; // ส่วนลดไม่ถูกต้อง
        }
        return true; // ไม่มีส่วนลด
    }

    // สร้าง order ใหม่
    createNewOrder() {
        this.items = [];
        this.orderNumber = this.generateOrderNumber();
        this.discountAmount = 0;
        this.render();
    }

    // ตรวจสอบว่ามีรายการหรือไม่
    hasItems() {
        return this.items.length > 0;
    }

    // ตั้งค่า DOM container
    setContainer(container) {
        this.container = container;
        this.render();
    }

    // โหลดข้อมูล order จาก API
    async loadFromAPI(apiUrl) {
        try {
            const response = await fetch(apiUrl);
            if (!response.ok) {
                throw new Error(`API error: ${response.status}`);
            }

            const orderData = await response.json();
            this.loadFromData(orderData);
            showApiStatus("โหลดข้อมูล order จาก API สำเร็จ", "success");
        } catch (error) {
            console.error("Failed to load order data:", error);
            showApiStatus(`เกิดข้อผิดพลาด: ${error.message}`, "danger");
        }
    }

    // โหลดข้อมูล order จาก object
    loadFromData(orderData) {
        // ตั้งค่าข้อมูลพื้นฐาน
        this.orderNumber = orderData.orderNumber || this.generateOrderNumber();
        this.discountAmount = orderData.discountAmount || 0;
        this.taxRate = orderData.taxRate || 0.07;

        // ล้างรายการสินค้าเดิม
        this.items = [];

        // เพิ่มสินค้าจากข้อมูลที่โหลดมา
        if (orderData.items && Array.isArray(orderData.items)) {
            orderData.items.forEach((item) => {
                // ค้นหาข้อมูลสินค้าเต็มจากฐานข้อมูล
                const product = products.find((p) => p.id === item.id);

                if (product) {
                    this.items.push({
                        id: item.id,
                        name: product.name,
                        price: product.price,
                        quantity: item.quantity || 1,
                        icon: product.icon || "🛒",
                    });
                }
            });
        }

        // อัพเดท UI
        this.render();
    }

    static payOrderSubmit() {
        if (Order.callbackFunction) {
            Order.callbackFunction();
        }
    }

    // แสดงผล UI ของ order
    render() {
        if (!this.container) return;

        // สร้าง HTML สำหรับ order UI
        this.container.innerHTML = `
      <div class="order-header">
        <h5>🧾 รายการสั่งซื้อ<br><small>บิลเลขที่: <span id="order-number">${
            this.orderNumber
        }</span></small></h5>
      </div>
      
      <div class="order-meta">
        <div class="form-group">
          <label>วันที่:</label>
          <input type="date" class="form-control" id="order-date" value="${getTodayDate()}" onchange="updateThaiDate()" />
        </div>

        <div class="form-group">
          <label>เวลา:</label>
          <input type="time" class="form-control" id="order-time" value="${getCurrentTime()}" />
        </div>

        <div class="form-group">
          <label>วันที่ (พ.ศ.):</label>
          <input type="text" class="form-control" id="thai-date" value="${getThaiDate()}" disabled />
        </div>
      </div>
      
      <div class="order-list" id="order-list">
        ${this.renderOrderItems()}
      </div>
      
      <div class="discount-input-group">
        <label>ใส่รหัสส่วนลด:</label>
        <div class="input-group">
          <input type="text" class="form-control" id="discount-code" placeholder="DISCOUNT10">
          <div class="input-group-append">
            <button class="btn btn-secondary" onclick="currentOrder.applyDiscount(document.getElementById('discount-code').value)">ใช้</button>
          </div>
        </div>
      </div>
      
      <div class="order-summary">
        <div class="d-flex justify-content-between">
          <span>ยอดรวม:</span>
          <span id="total">฿${this.getSubtotal().toFixed(2)}</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>ส่วนลด:</span>
          <span id="discount">฿${this.discountAmount.toFixed(2)}</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>ภาษี (7%):</span>
          <span id="tax">฿${this.getTax().toFixed(2)}</span>
        </div>
        <div class="d-flex justify-content-between mt-2 font-weight-bold">
          <span>ยอดชำระ:</span>
          <span id="grand-total" class="grand-total">฿${this.getGrandTotal().toFixed(
              2
          )}</span>
        </div>
      </div>
      
      <button class="btn btn-pay" onclick="Order.payOrderSubmit();">
        <i class="fas fa-money-bill-wave mr-2"></i>💰 ชำระเงิน
      </button>
    `;
    }

    // แสดงรายการสินค้าใน order
    renderOrderItems() {
        if (this.items.length === 0) {
            return `
        <div class="order-empty">
          <i class="fas fa-shopping-cart"></i>
          <p>ไม่มีรายการสินค้า</p>
        </div>
      `;
        }

        return `
      <ul class="list-group">
        ${this.items
            .map(
                (item, i) => `
          <li class="list-group-item order-item">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <div><strong>${item.name}</strong></div>
                <div class="order-controls">
                  <button class="btn btn-sm btn-outline-primary rounded-circle" 
                          onclick="currentOrder.changeQuantity(${i}, -1)">
                    <i class="fas fa-minus"></i>
                  </button>
                  <span class="mx-2">${item.quantity}</span>
                  <button class="btn btn-sm btn-outline-primary rounded-circle" 
                          onclick="currentOrder.changeQuantity(${i}, 1)">
                    <i class="fas fa-plus"></i>
                  </button>
                  <button class="btn btn-sm btn-outline-danger ml-2" 
                          onclick="currentOrder.removeItem(${i})">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
              <div class="text-right">
                <div><strong>฿${(item.price * item.quantity).toFixed(
                    2
                )}</strong></div>
                <small class="text-muted">฿${item.price.toFixed(2)}/ชิ้น</small>
              </div>
            </div>
          </li>
        `
            )
            .join("")}
      </ul>
    `;
    }
}
