// Sample data for parts
// const parts = [
//     { id: 1, name: 'น้ำมันเครื่อง', price: 350 },
//     { id: 2, name: 'ไส้กรองอากาศ', price: 450 },
//     { id: 3, name: 'ผ้าเบรก', price: 1200 },
//     { id: 4, name: 'ยางรถยนต์', price: 2500 },
//     { id: 5, name: 'แบตเตอรี่', price: 2800 },
//     { id: 6, name: 'หลอดไฟหน้า', price: 350 },
//     { id: 7, name: 'น้ำยาหล่อเย็น', price: 250 },
//     { id: 8, name: 'ไส้กรองน้ำมัน', price: 150 },
//     { id: 9, name: 'ลูกปืนล้อ', price: 800 },
//     { id: 10, name: 'โช้คอัพ', price: 3200 }
// ];

let parts = [];

// DOM Ready
$(document).ready(function () {
    // โหลดข้อมูลอะไหล่จาก localStorage
    const partsData = localStorage.getItem(STORAGE_KEYS.PARTS);
    parts = partsData ? JSON.parse(partsData) : [];

    // โหลดรถสำหรับเลือก
    const carsData = localStorage.getItem(STORAGE_KEYS.CARS);
    cars = carsData ? JSON.parse(carsData) : [];

    // โหลดข้อมูลการซ่อม
    const repairsData = localStorage.getItem(STORAGE_KEYS.REPAIRS);
    repairs = repairsData ? JSON.parse(repairsData) : [];

    // Load cars into select dropdown
    loadCarsForSelection();

    // Load parts into select dropdown
    loadPartsForSelection();

    // Setup event handlers
    setupRepairEventHandlers();

    // Initialize totals
    updateTotals();

    // ในส่วน DOM Ready
    if (window.location.pathname.includes("add-repair.html")) {
        const urlParams = new URLSearchParams(window.location.search);
        const carId = urlParams.get("id");

        if (carId) {
            $("#selectCar").val(carId).trigger("change");
            $("#selectCar").prop("disabled", true);
        }
    }
});

// Load cars into select dropdown
function loadCarsForSelection() {
    const $selectCar = $("#selectCar");
    $selectCar.empty();
    $selectCar.append('<option value="">-- เลือกรถ --</option>');

    cars.forEach((car) => {
        $selectCar.append(
            `<option value="${car.id}">${car.licensePlate} - ${car.brand} ${car.model} (${car.owner})</option>`
        );
    });
}

// Load parts into select dropdown
function _loadPartsForSelection() {
    const $selectPart = $("#selectPart");
    $selectPart.empty();
    $selectPart.append('<option value="">-- เลือกอะไหล่ --</option>');

    parts.forEach((part) => {
        $selectPart.append(
            `<option value="${part.id}" data-price="${part.price}">${
                part.name
            } (${part.price.toLocaleString()} บาท)</option>`
        );
    });
}

// แก้ไขฟังก์ชัน loadPartsForSelection
function loadPartsForSelection() {
    const $selectPart = $("#selectPart");
    $selectPart.empty();
    $selectPart.append('<option value="">-- เลือกอะไหล่ --</option>');

    parts.forEach((part) => {
        $selectPart.append(
            `<option value="${part.id}" data-price="${part.price}">${
                part.name
            } (${part.price.toLocaleString()} บาท)</option>`
        );
    });
}

// Setup event handlers for repair page
function setupRepairEventHandlers() {

    $("#addNewPartBtn").click(function () {
        $("#addPartModal").modal("show");
    });

    $("#savePartBtn").click(function () {
        const partName = $("#partName").val().trim();
        const partPrice = parseFloat($("#partPrice").val());

        if (!partName || isNaN(partPrice)) {
            alert("กรุณากรอกชื่ออะไหล่และราคาให้ถูกต้อง");
            return;
        }

        addNewPart(partName, partPrice);
        $("#addPartModal").modal("hide");
        $("#partForm")[0].reset();
    });

    // Add item button
    $("#addItemBtn").click(function () {
        $("#addItemModal").modal("show");
    });

    // Save item button
    $("#saveItemBtn").click(function () {
        addRepairItem();
    });

    // Remove item button
    $(document).on("click", ".remove-item", function () {
        $(this).closest("tr").remove();
        updateTotals();
    });

    // Quantity or price change
    $(document).on("change", ".item-quantity, .item-price", function () {
        const $row = $(this).closest("tr");
        const quantity = parseFloat($row.find(".item-quantity").val()) || 0;
        const price = parseFloat($row.find(".item-price").val()) || 0;
        const total = quantity * price;

        $row.find(".item-total").text(
            total.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            })
        );
        updateTotals();
    });

    // Labor cost change
    $("#laborCost").on("change", function () {
        updateTotals();
    });

    // Form submission
    $("#repairForm").submit(function (e) {
        e.preventDefault();
        saveRepair();
    });

    // Car selection change
    $("#selectCar").change(function () {
        $("#carId").val($(this).val());
    });
}

// เพิ่มฟังก์ชันจัดการอะไหล่
function addNewPart(partName, partPrice) {
    const newPart = {
        id: parts.length > 0 ? Math.max(...parts.map((p) => p.id)) + 1 : 1,
        name: partName,
        price: partPrice,
    };

    parts.push(newPart);
    saveToLocalStorage(STORAGE_KEYS.PARTS, parts);
    loadPartsForSelection();
    return newPart;
}

// Add repair item to table
function addRepairItem() {
    const partId = $("#selectPart").val();
    const partName = $("#selectPart option:selected").text().split(" (")[0];
    const partPrice =
        parseFloat($("#selectPart option:selected").data("price")) || 0;
    const quantity = parseInt($("#partQuantity").val()) || 1;
    const total = partPrice * quantity;

    if (!partId) {
        alert("กรุณาเลือกอะไหล่");
        return;
    }

    // Check if item already exists
    let itemExists = false;
    $("#repairItemsBody tr").each(function () {
        if ($(this).data("part-id") == partId) {
            itemExists = true;
            const currentQty =
                parseInt($(this).find(".item-quantity").val()) || 0;
            $(this)
                .find(".item-quantity")
                .val(currentQty + quantity);
            $(this).find(".item-quantity").trigger("change");
            return false; // break loop
        }
    });

    if (itemExists) {
        $("#addItemModal").modal("hide");
        $("#itemForm")[0].reset();
        return;
    }

    // Add new item row
    const row = `
        <tr data-part-id="${partId}">
            <td>${partName}</td>
            <td>
                <input type="number" class="form-control form-control-sm item-quantity" min="1" value="${quantity}" required>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm item-price" min="0" step="0.01" value="${partPrice}" required>
            </td>
            <td class="item-total">${total.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            })}</td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger remove-item">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `;

    $("#repairItemsBody").append(row);
    $("#addItemModal").modal("hide");
    $("#itemForm")[0].reset();
    updateTotals();
}

// Update totals calculation
function updateTotals() {
    let partsTotal = 0;

    $("#repairItemsBody tr").each(function () {
        const quantity = parseFloat($(this).find(".item-quantity").val()) || 0;
        const price = parseFloat($(this).find(".item-price").val()) || 0;
        partsTotal += quantity * price;
    });

    const laborCost = parseFloat($("#laborCost").val()) || 0;
    const repairTotal = partsTotal + laborCost;

    $("#partsTotal").text(
        partsTotal.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        })
    );
    $("#repairTotal").text(
        repairTotal.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        })
    );
}

// Save repair to database
function saveRepair() {
    // Validate form
    if (!validateRepairForm()) {
        return;
    }

    // Get basic repair info
    const carId = $("#carId").val();
    const repairDate = $("#repairDate").val();
    const mechanic = $("#mechanic").val();
    const status = $("#repairStatus").val();
    const notes = $("#repairNotes").val();
    const laborCost = parseFloat($("#laborCost").val()) || 0;

    // Get repair items
    const repairItems = [];
    let partsTotal = 0;

    $("#repairItemsBody tr").each(function () {
        const partId = $(this).data("part-id");
        const partName = $(this).find("td:eq(0)").text();
        const quantity = parseFloat($(this).find(".item-quantity").val()) || 0;
        const price = parseFloat($(this).find(".item-price").val()) || 0;
        const total = quantity * price;

        repairItems.push({
            id: partId,
            name: partName,
            price: price,
            quantity: quantity,
            total: total,
        });

        partsTotal += total;
    });

    // Create repair object
    const repair = {
        id: repairIdCounter++,
        carId: parseInt(carId),
        billNo: `REP${new Date().getFullYear()}${String(
            repairIdCounter
        ).padStart(4, "0")}`,
        date: repairDate,
        mechanic: mechanic,
        status: status,
        notes: notes,
        items: repairItems,
        laborCost: laborCost,
        partsTotal: partsTotal,
        total: partsTotal + laborCost,
    };

    // Add to repairs array
    repairs.push(repair);

    // Update car's repair count
    const carIndex = cars.findIndex((c) => c.id == carId);
    if (carIndex !== -1) {
        cars[carIndex].repairCount++;
    }

    // Show success message
    alert("บันทึกการซ่อมเรียบร้อยแล้ว");
    // บันทึกข้อมูลการซ่อมและรถลง localStorage
    saveToLocalStorage(STORAGE_KEYS.REPAIRS, repairs);
    saveToLocalStorage(STORAGE_KEYS.CARS, cars);

    // Redirect to car detail page
    window.location.href = `car-detail.html?id=${carId}`;
}

// Validate repair form
function validateRepairForm() {
    let isValid = true;

    if (!$("#selectCar").val()) {
        $("#selectCar").addClass("is-invalid");
        isValid = false;
    } else {
        $("#selectCar").removeClass("is-invalid");
    }

    if (!$("#repairDate").val()) {
        $("#repairDate").addClass("is-invalid");
        isValid = false;
    } else {
        $("#repairDate").removeClass("is-invalid");
    }

    if (!$("#mechanic").val()) {
        $("#mechanic").addClass("is-invalid");
        isValid = false;
    } else {
        $("#mechanic").removeClass("is-invalid");
    }

    if ($("#repairItemsBody tr").length === 0) {
        alert("กรุณาเพิ่มรายการอะไหล่อย่างน้อย 1 รายการ");
        isValid = false;
    }

    return isValid;
}
