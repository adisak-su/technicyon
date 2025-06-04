// Sample Data - In a real app, this would come from an API or database
let cars = [];
let repairs = [];
let currentPage = 1;
const itemsPerPage = 10;
let carIdCounter = 1000;
let repairIdCounter = 10000;

// เก็บชื่อ key สำหรับ localStorage
const STORAGE_KEYS = {
    CARS: "carRepairSystem_cars",
    REPAIRS: "carRepairSystem_repairs",
    PARTS: "carRepairSystem_parts",
};

// DOM Ready
$(document).ready(function () {
    // Initialize data
    // initializeData();
    // โหลดข้อมูลจาก localStorage
    loadFromLocalStorage();

    // Check if we're on the index page or car detail page
    if ($("#carTable").length) {
        // Index page functionality
        loadCars();
        setupEventHandlers();
    } else if ($("#carDetailTabs").length) {
        // Car detail page functionality
        loadCarDetail();
        setupDetailEventHandlers();
    }

});

// ฟังก์ชันสำหรับโหลดข้อมูลจาก localStorage
function loadFromLocalStorage() {
    // โหลดข้อมูลรถ
    const carsData = localStorage.getItem(STORAGE_KEYS.CARS);
    if (carsData) {
        cars = JSON.parse(carsData);
        carIdCounter =
            cars.length > 0 ? Math.max(...cars.map((c) => c.id)) + 1 : 1000;
    } else {
        initializeSampleCars();
        saveToLocalStorage(STORAGE_KEYS.CARS, cars);
    }

    // โหลดข้อมูลการซ่อม
    const repairsData = localStorage.getItem(STORAGE_KEYS.REPAIRS);
    if (repairsData) {
        repairs = JSON.parse(repairsData);
        repairIdCounter =
            repairs.length > 0
                ? Math.max(...repairs.map((r) => r.id)) + 1
                : 10000;
    } else {
        initializeSampleRepairs();
        saveToLocalStorage(STORAGE_KEYS.REPAIRS, repairs);
        saveToLocalStorage(STORAGE_KEYS.CARS, cars);
    }

    // โหลดข้อมูลอะไหล่
    const partsData = localStorage.getItem(STORAGE_KEYS.PARTS);
    if (partsData) {
        parts = JSON.parse(partsData);
    } else {
        initializeSampleParts();
        saveToLocalStorage(STORAGE_KEYS.PARTS, parts);
    }
}

// ฟังก์ชันสำหรับบันทึกข้อมูลลง localStorage
function saveToLocalStorage(key, data) {
    localStorage.setItem(key, JSON.stringify(data));
}

// Initialize sample data
// ฟังก์ชันสำหรับสร้างข้อมูลตัวอย่างการซ่อม
function initializeSampleRepairs() {
    repairs = [];
    // Generate repairs for some cars
    const repairItems = [
        { id: 1, name: "น้ำมันเครื่อง", price: 350 },
        { id: 2, name: "ไส้กรองอากาศ", price: 450 },
        { id: 3, name: "ผ้าเบรก", price: 1200 },
        { id: 4, name: "ยางรถยนต์", price: 2500 },
        { id: 5, name: "แบตเตอรี่", price: 2800 },
        { id: 6, name: "หลอดไฟหน้า", price: 350 },
        { id: 7, name: "น้ำยาหล่อเย็น", price: 250 },
        { id: 8, name: "ไส้กรองน้ำมัน", price: 150 },
        { id: 9, name: "ลูกปืนล้อ", price: 800 },
        { id: 10, name: "โช้คอัพ", price: 3200 },
    ];

    // Generate repairs for about 30% of cars
    const carsWithRepairs = Math.floor(cars.length * 0.3);
    for (let i = 0; i < carsWithRepairs; i++) {
        const carIndex = Math.floor(Math.random() * cars.length);
        const car = cars[carIndex];
        car.repairCount = 0;
        const repairCount = 1 + Math.floor(Math.random() * 5); // 1-5 repairs per car

        for (let j = 0; j < repairCount; j++) {
            const repairDate = new Date();
            repairDate.setDate(
                repairDate.getDate() - Math.floor(Math.random() * 365)
            ); // Up to 1 year ago

            const itemCount = 1 + Math.floor(Math.random() * 5); // 1-5 items per repair
            const repairItemsList = [];
            let partsTotal = 0;

            for (let k = 0; k < itemCount; k++) {
                const item =
                    repairItems[Math.floor(Math.random() * repairItems.length)];
                const quantity = 1 + Math.floor(Math.random() * 3); // 1-3 quantity
                const total = item.price * quantity;

                repairItemsList.push({
                    name: item.name,
                    price: item.price,
                    quantity: quantity,
                    total: total,
                });

                partsTotal += total;
            }

            const laborCost = 500 + Math.floor(Math.random() * 1500); // 500-2000 labor cost
            const totalCost = partsTotal + laborCost;

            const repair = {
                id: repairIdCounter++,
                carId: car.id,
                billNo: `REP${repairIdCounter}`,
                date: repairDate.toISOString().split("T")[0],
                mechanic: ["ช่างสมชาย", "ช่างสมหมาย", "ช่างสมศรี", "ช่างสมปอง"][
                    Math.floor(Math.random() * 4)
                ],
                status: ["เสร็จสิ้น", "รออะไหล่", "กำลังซ่อม"][
                    Math.floor(Math.random() * 3)
                ],
                notes: ["เปลี่ยนตามปกติ", "ตรวจเช็คตามระยะ", "ซ่อมตามที่แจ้ง"][
                    Math.floor(Math.random() * 3)
                ],
                items: repairItemsList,
                laborCost: laborCost,
                partsTotal: partsTotal,
                total: totalCost,
            };

            repairs.push(repair);
            car.repairCount++;
        }
    }
    // ... รหัสการสร้างการซ่อมตัวอย่างเหมือนเดิม ...
    repairIdCounter =
        repairs.length > 0 ? Math.max(...repairs.map((r) => r.id)) + 1 : 10000;
}

// ฟังก์ชันสำหรับสร้างข้อมูลตัวอย่างอะไหล่
function initializeSampleParts() {
    parts = [
        { id: 1, name: "น้ำมันเครื่อง", price: 350 },
        { id: 2, name: "ไส้กรองอากาศ", price: 450 },
        { id: 3, name: "ผ้าเบรก", price: 1200 },
        { id: 4, name: "ยางรถยนต์", price: 2500 },
        { id: 5, name: "แบตเตอรี่", price: 2800 },
        { id: 6, name: "หลอดไฟหน้า", price: 350 },
        { id: 7, name: "น้ำยาหล่อเย็น", price: 250 },
        { id: 8, name: "ไส้กรองน้ำมัน", price: 150 },
        { id: 9, name: "ลูกปืนล้อ", price: 800 },
        { id: 10, name: "โช้คอัพ", price: 3200 },
        // ... รายการอะไหล่อื่นๆ ...
    ];
}
// function initializeData() {
function initializeSampleCars() {
    cars = [];
    // Generate 1000 sample cars
    const brands = [
        "Toyota",
        "Honda",
        "Isuzu",
        "Mitsubishi",
        "Nissan",
        "Ford",
        "Mazda",
        "BMW",
        "Mercedes",
        "Audi",
    ];
    const models = {
        Toyota: ["Camry", "Corolla", "Fortuner", "Hilux", "Yaris"],
        Honda: ["Civic", "Accord", "CR-V", "City", "Jazz"],
        Isuzu: ["D-Max", "MU-X", "Hi-Lander"],
        Mitsubishi: ["Triton", "Pajero", "Attrage"],
        Nissan: ["Almera", "Navara", "Terra", "Kicks"],
        Ford: ["Ranger", "Everest", "Focus"],
        Mazda: ["2", "3", "CX-5", "CX-30"],
        BMW: ["3 Series", "5 Series", "X1", "X3"],
        Mercedes: ["C-Class", "E-Class", "GLA", "GLC"],
        Audi: ["A3", "A4", "Q3", "Q5"],
    };

    const firstNames = [
        "สมชาย",
        "สมหญิง",
        "กฤษณะ",
        "สุธี",
        "นฤมล",
        "พัชรา",
        "อภิชาติ",
        "วิไล",
        "ธนวัฒน์",
        "จันทร์เพ็ญ",
    ];
    const lastNames = [
        "ดีมาก",
        "ศรีสุข",
        "วัฒนา",
        "ทองคำ",
        "ใจดี",
        "สุขสันต์",
        "รักชาติ",
        "เจริญสุข",
        "มั่นคง",
        "ประเสริฐ",
    ];

    for (let i = 1; i <= 1000; i++) {
        const brand = brands[Math.floor(Math.random() * brands.length)];
        const model =
            models[brand][Math.floor(Math.random() * models[brand].length)];

        cars.push({
            id: i,
            licensePlate: generateLicensePlate(),
            brand: brand,
            model: model,
            year: 2010 + Math.floor(Math.random() * 11),
            owner: `${
                firstNames[Math.floor(Math.random() * firstNames.length)]
            } ${lastNames[Math.floor(Math.random() * lastNames.length)]}`,
            phone: `08${Math.floor(10000000 + Math.random() * 90000000)}`,
            repairCount: 0,
        });
    }

    // carIdCounter = 1000 + cars.length;
    carIdCounter =
        cars.length > 0 ? Math.max(...cars.map((c) => c.id)) + 1 : 1000;
}

// Generate random Thai license plate
function generateLicensePlate() {
    const provinces = [
        "กท",
        "นน",
        "ปท",
        "ชบ",
        "นฐ",
        "กจ",
        "สข",
        "พท",
        "อบ",
        "ภก",
    ];
    const numbers = Math.floor(1000 + Math.random() * 9000);
    const chars =
        String.fromCharCode(65 + Math.floor(Math.random() * 26)) +
        String.fromCharCode(65 + Math.floor(Math.random() * 26));

    return `${
        provinces[Math.floor(Math.random() * provinces.length)]
    } ${numbers} ${chars}`;
}

// Load cars into table with pagination
function loadCars(page = 1) {
    currentPage = page;
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const paginatedCars = cars.slice(startIndex, endIndex);

    $("#carTableBody").empty();

    if (paginatedCars.length === 0) {
        $("#carTableBody").append(
            '<tr><td colspan="9" class="text-center">ไม่พบข้อมูลรถ</td></tr>'
        );
    } else {
        paginatedCars.forEach((car, index) => {
            const row = `
                <tr class="fade-in">
                    <td>${startIndex + index + 1}</td>
                    <td>${car.licensePlate}</td>
                    <td>${car.brand}</td>
                    <td>${car.model}</td>
                    <td>${car.year}</td>
                    <td>${car.owner}</td>
                    <td>${car.phone}</td>
                    <td class="text-center">
                        <span class="badge badge-pill ${
                            car.repairCount > 0
                                ? "badge-primary"
                                : "badge-secondary"
                        } badge-repair">
                            ${car.repairCount}
                        </span>
                    </td>
                    <td class="action-buttons">
                        <a href="car-detail.html?id=${
                            car.id
                        }" class="btn btn-sm btn-info" title="ดูรายละเอียด">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="btn btn-sm btn-warning edit-car" data-id="${
                            car.id
                        }" title="แก้ไข">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-car" data-id="${
                            car.id
                        }" data-plate="${car.licensePlate}" title="ลบ">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $("#carTableBody").append(row);
        });
    }

    // Update pagination
    updatePagination();
}

// Update pagination controls
function updatePagination() {
    const totalPages = Math.ceil(cars.length / itemsPerPage);
    $("#pagination").empty();

    if (totalPages <= 1) return;

    // Previous button
    $("#pagination").append(`
        <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
            <a class="page-link" href="#" data-page="${
                currentPage - 1
            }">ก่อนหน้า</a>
        </li>
    `);

    // Page numbers
    const maxVisiblePages = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

    if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }

    if (startPage > 1) {
        $("#pagination").append(`
            <li class="page-item">
                <a class="page-link" href="#" data-page="1">1</a>
            </li>
            ${
                startPage > 2
                    ? '<li class="page-item disabled"><span class="page-link">...</span></li>'
                    : ""
            }
        `);
    }

    for (let i = startPage; i <= endPage; i++) {
        $("#pagination").append(`
            <li class="page-item ${i === currentPage ? "active" : ""}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
        `);
    }

    if (endPage < totalPages) {
        $("#pagination").append(`
            ${
                endPage < totalPages - 1
                    ? '<li class="page-item disabled"><span class="page-link">...</span></li>'
                    : ""
            }
            <li class="page-item">
                <a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>
            </li>
        `);
    }

    // Next button
    $("#pagination").append(`
        <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
            <a class="page-link" href="#" data-page="${
                currentPage + 1
            }">ถัดไป</a>
        </li>
    `);
}

// Setup event handlers for index page
function setupEventHandlers() {
    // Pagination click
    $(document).on("click", ".page-link", function (e) {
        e.preventDefault();
        const page = $(this).data("page");
        if (page && page !== currentPage) {
            loadCars(page);
        }
    });

    // Add car button
    $("#addCarBtn").click(function () {
        $("#carModalLabel").text("เพิ่มรถใหม่");
        $("#carForm")[0].reset();
        $("#carId").val("");
        $("#carModal").modal("show");
    });

    // Edit car button
    $(document).on("click", ".edit-car", function () {
        const carId = $(this).data("id");
        const car = cars.find((c) => c.id == carId);

        if (car) {
            $("#carModalLabel").text("แก้ไขข้อมูลรถ");
            $("#carId").val(car.id);
            $("#licensePlate").val(car.licensePlate);
            $("#brand").val(car.brand);
            $("#model").val(car.model);
            $("#year").val(car.year);
            $("#owner").val(car.owner);
            $("#phone").val(car.phone);
            $("#carModal").modal("show");
        }
    });

    // Delete car button
    $(document).on("click", ".delete-car", function () {
        const carId = $(this).data("id");
        const licensePlate = $(this).data("plate");

        $("#deleteCarPlate").text(licensePlate);
        $("#confirmDeleteBtn").data("id", carId);
        $("#deleteModal").modal("show");
    });

    // Confirm delete
    $("#confirmDeleteBtn").click(function () {
        const carId = $(this).data("id");
        deleteCar(carId);
        $("#deleteModal").modal("hide");
    });

    // Save car (add/edit)
    $("#saveCarBtn").click(function () {
        if (validateCarForm()) {
            saveCar();
            $("#carModal").modal("hide");
        }
    });

    // Search functionality
    $("#searchBtn").click(searchCars);
    $("#searchInput").keypress(function (e) {
        if (e.which === 13) {
            searchCars();
        }
    });

    $("#exportDataBtn").click(exportData);
    $("#importDataBtn").click(function () {
        $("#importDataModal").modal("show");
    });
    $("#resetDataBtn").click(resetData);
    $("#confirmImportBtn").click(importData);
}

// ฟังก์ชันสำหรับ Export Data
function exportData() {
    const data = {
        cars: cars,
        repairs: repairs,
        parts: parts,
        metadata: {
            exportedAt: new Date().toISOString(),
            version: "1.0",
        },
    };

    const dataStr = JSON.stringify(data, null, 2);
    const dataUri =
        "data:application/json;charset=utf-8," + encodeURIComponent(dataStr);

    const exportFileDefaultName = `car-repair-backup-${new Date()
        .toISOString()
        .slice(0, 10)}.json`;

    const linkElement = document.createElement("a");
    linkElement.setAttribute("href", dataUri);
    linkElement.setAttribute("download", exportFileDefaultName);
    linkElement.click();

    showAlert("success", "สำรองข้อมูลเรียบร้อยแล้ว");
}

// ฟังก์ชันสำหรับ Import Data
function importData() {
    const fileInput = document.getElementById("backupFile");
    const file = fileInput.files[0];

    if (!file) {
        alert("กรุณาเลือกไฟล์ข้อมูล");
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        try {
            const data = JSON.parse(e.target.result);

            if (!data.cars || !data.repairs || !data.parts) {
                throw new Error("รูปแบบไฟล์ไม่ถูกต้อง");
            }

            // บันทึกข้อมูลใหม่
            localStorage.setItem(STORAGE_KEYS.CARS, JSON.stringify(data.cars));
            localStorage.setItem(
                STORAGE_KEYS.REPAIRS,
                JSON.stringify(data.repairs)
            );
            localStorage.setItem(
                STORAGE_KEYS.PARTS,
                JSON.stringify(data.parts)
            );

            // โหลดข้อมูลใหม่
            loadFromLocalStorage();
            loadCars(currentPage);

            $("#importDataModal").modal("hide");
            showAlert("success", "นำเข้าข้อมูลเรียบร้อยแล้ว");
        } catch (error) {
            console.error(error);
            alert("เกิดข้อผิดพลาดในการนำเข้าข้อมูล: " + error.message);
        }
    };
    reader.readAsText(file);
}

// ฟังก์ชันสำหรับ Reset Data
function resetData() {
    if (
        confirm(
            "คุณแน่ใจหรือไม่ว่าต้องการรีเซ็ตข้อมูลทั้งหมด?\nการดำเนินการนี้ไม่สามารถยกเลิกได้!"
        )
    ) {
        localStorage.removeItem(STORAGE_KEYS.CARS);
        localStorage.removeItem(STORAGE_KEYS.REPAIRS);
        localStorage.removeItem(STORAGE_KEYS.PARTS);

        // โหลดข้อมูลตัวอย่างใหม่
        loadFromLocalStorage();
        loadCars(1);

        showAlert("success", "รีเซ็ตข้อมูลเรียบร้อยแล้ว ระบบใช้ข้อมูลตัวอย่าง");
    }
}

// Validate car form
function validateCarForm() {
    let isValid = true;
    const form = $("#carForm")[0];

    if (!form.licensePlate.value.trim()) {
        $("#licensePlate").addClass("is-invalid");
        isValid = false;
    } else {
        $("#licensePlate").removeClass("is-invalid");
    }

    if (!form.brand.value.trim()) {
        $("#brand").addClass("is-invalid");
        isValid = false;
    } else {
        $("#brand").removeClass("is-invalid");
    }

    if (!form.model.value.trim()) {
        $("#model").addClass("is-invalid");
        isValid = false;
    } else {
        $("#model").removeClass("is-invalid");
    }

    if (!form.year.value || form.year.value < 1900 || form.year.value > 2099) {
        $("#year").addClass("is-invalid");
        isValid = false;
    } else {
        $("#year").removeClass("is-invalid");
    }

    if (!form.owner.value.trim()) {
        $("#owner").addClass("is-invalid");
        isValid = false;
    } else {
        $("#owner").removeClass("is-invalid");
    }

    if (!form.phone.value.trim()) {
        $("#phone").addClass("is-invalid");
        isValid = false;
    } else {
        $("#phone").removeClass("is-invalid");
    }

    return isValid;
}

// Save car (add or update)
function saveCar() {
    const form = $("#carForm")[0];
    const carId = $("#carId").val();

    const carData = {
        licensePlate: form.licensePlate.value.trim(),
        brand: form.brand.value.trim(),
        model: form.model.value.trim(),
        year: parseInt(form.year.value),
        owner: form.owner.value.trim(),
        phone: form.phone.value.trim(),
        repairCount: 0,
    };

    if (carId) {
        // Update existing car
        const index = cars.findIndex((c) => c.id == carId);
        if (index !== -1) {
            carData.repairCount = cars[index].repairCount;
            cars[index] = { ...cars[index], ...carData };
            showAlert("success", "อัปเดตข้อมูลรถเรียบร้อยแล้ว");
        }
    } else {
        // Add new car
        const newCar = {
            id: carIdCounter++,
            ...carData,
        };
        cars.push(newCar);
        showAlert("success", "เพิ่มรถใหม่เรียบร้อยแล้ว");
    }
    // บันทึกข้อมูลรถลง localStorage
    saveToLocalStorage(STORAGE_KEYS.CARS, cars);
    loadCars(currentPage);
}

// Delete car
function deleteCar(carId) {
    const index = cars.findIndex((c) => c.id == carId);
    if (index !== -1) {
        cars.splice(index, 1);
        showAlert("success", "ลบรถเรียบร้อยแล้ว");
        // บันทึกข้อมูลรถลง localStorage
        saveToLocalStorage(STORAGE_KEYS.CARS, cars);
        loadCars(currentPage);
    }
}

// Search cars
function searchCars() {
    const searchTerm = $("#searchInput").val().trim().toLowerCase();

    if (searchTerm === "") {
        loadCars(1);
        return;
    }

    const filteredCars = cars.filter(
        (car) =>
            car.licensePlate.toLowerCase().includes(searchTerm) ||
            car.owner.toLowerCase().includes(searchTerm) ||
            car.phone.includes(searchTerm)
    );

    if (filteredCars.length === 0) {
        $("#carTableBody").html(
            '<tr><td colspan="9" class="text-center">ไม่พบข้อมูลที่ตรงกับคำค้นหา</td></tr>'
        );
        $("#pagination").empty();
    } else {
        displaySearchResults(filteredCars);
    }
}

// Display search results
function displaySearchResults(results) {
    $("#carTableBody").empty();

    results.forEach((car, index) => {
        const row = `
            <tr class="fade-in">
                <td>${index + 1}</td>
                <td>${car.licensePlate}</td>
                <td>${car.brand}</td>
                <td>${car.model}</td>
                <td>${car.year}</td>
                <td>${car.owner}</td>
                <td>${car.phone}</td>
                <td class="text-center">
                    <span class="badge badge-pill ${
                        car.repairCount > 0
                            ? "badge-primary"
                            : "badge-secondary"
                    } badge-repair">
                        ${car.repairCount}
                    </span>
                </td>
                <td class="action-buttons">
                    <a href="car-detail.html?id=${
                        car.id
                    }" class="btn btn-sm btn-info" title="ดูรายละเอียด">
                        <i class="fas fa-eye"></i>
                    </a>
                    <button class="btn btn-sm btn-warning edit-car" data-id="${
                        car.id
                    }" title="แก้ไข">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger delete-car" data-id="${
                        car.id
                    }" data-plate="${car.licensePlate}" title="ลบ">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        $("#carTableBody").append(row);
    });

    $("#pagination").empty();
}

// Show alert message
function showAlert(type, message) {
    const alert = $(`
        <div class="alert alert-${type} alert-dismissible fade show fixed-top mx-auto mt-3" style="max-width: 500px;">
            ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    `);

    $("body").append(alert);

    setTimeout(() => {
        alert.alert("close");
    }, 3000);
}

// Car Detail Page Functions
function loadCarDetail() {
    const urlParams = new URLSearchParams(window.location.search);
    const carId = urlParams.get("id");

    if (!carId) {
        window.location.href = "index.html";
        return;
    }

    const car = cars.find((c) => c.id == carId);

    if (!car) {
        window.location.href = "index.html";
        return;
    }

    // Display car info
    $("#carDetailTitle").text(`รายละเอียดรถ - ${car.licensePlate}`);
    $("#detail-licensePlate").text(car.licensePlate);
    $("#detail-brand").text(car.brand);
    $("#detail-model").text(car.model);
    $("#detail-year").text(car.year);
    $("#detail-owner").text(car.owner);
    $("#detail-phone").text(car.phone);
    $("#detail-repairCount").text(car.repairCount);

    // Load repair history
    loadRepairHistory(carId);
}

function loadRepairHistory(carId) {
    const carRepairs = repairs.filter((r) => r.carId == carId);

    $("#repairHistoryBody").empty();

    if (carRepairs.length === 0) {
        $("#repairHistoryBody").append(`
            <tr>
                <td colspan="7" class="text-center">ไม่พบประวัติการซ่อม</td>
            </tr>
        `);
    } else {
        carRepairs.forEach((repair) => {
            // แก้ไขปุ่ม "ดูรายละเอียด" ให้แสดงปุ่มพิมพ์ด้วย
            const row = `
                <tr>
                    <td>${repair.billNo}</td>
                    <td>${repair.date}</td>
                    <td>${repair.items.map((item) => item.name).join(", ")}</td>
                    <td class="text-right">${repair.laborCost.toLocaleString()}</td>
                    <td class="text-right">${repair.partsTotal.toLocaleString()}</td>
                    <td class="text-right">${repair.total.toLocaleString()}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary view-repair" data-id="${repair.id}">
                                 <i class="fas fa-search"></i> ดู
                        </button>

                        <a href="print-repair.html?id=${
                            repair.id
                        }" class="btn btn-sm btn-info" target="_blank">
                            <i class="fas fa-print"></i> พิมพ์
                        </a>
                    </td>
                </tr>
            `;
            /*
            const row = `
                <tr>
                    <td>${repair.billNo}</td>
                    <td>${repair.date}</td>
                    <td>${repair.items.map((item) => item.name).join(", ")}</td>
                    <td class="text-right">${repair.laborCost.toLocaleString()}</td>
                    <td class="text-right">${repair.partsTotal.toLocaleString()}</td>
                    <td class="text-right">${repair.total.toLocaleString()}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary view-repair" data-id="${repair.id}">
                                 <i class="fas fa-search"></i> ดู
                        </button>

                        <a href="print-repair.html?id=${
                            repair.id
                        }" class="btn btn-sm btn-info" target="_blank">
                            <i class="fas fa-print"></i> พิมพ์
                        </a>
                        <button onclick="print_repair_html(${
                            repair.id
                        });" class="btn btn-sm btn-info" target="_blank">
                            <i class="fas fa-print"></i> พิมพ์
                        </button>
                    </td>
                </tr>
            `;
            */
            // const row = `
            //     <tr>
            //         <td>${repair.billNo}</td>
            //         <td>${repair.date}</td>
            //         <td>${repair.items.map((item) => item.name).join(", ")}</td>
            //         <td class="text-right">${repair.laborCost.toLocaleString()}</td>
            //         <td class="text-right">${repair.partsTotal.toLocaleString()}</td>
            //         <td class="text-right">${repair.total.toLocaleString()}</td>
            //         <td class="text-center">
            // <button class="btn btn-sm btn-primary view-repair" data-id="${
            //     repair.id
            // }">
            //     <i class="fas fa-search"></i> ดู
            // </button>

            //             <button class="btn btn-sm btn-primary view-repair" data-id="${
            //                 repair.id
            //             }">
            //                 <i class="fas fa-search"></i> ดูรายละเอียด
            //             </button>
            //         </td>
            //     </tr>
            // `;
            $("#repairHistoryBody").append(row);
        });
    }
}
function print_repair_html(repairId) {
    window.location.href = "print-repair.html?id=" + repairId;
}

function add_repair_html(carId) {
    window.location.href = "add-repair.html?id=" + carId;
}

function setupDetailEventHandlers() {
    let currentCarID = null;
    // Edit car button
    $("#editCarBtn").click(function () {
        const urlParams = new URLSearchParams(window.location.search);
        const carId = urlParams.get("id");
        const car = cars.find((c) => c.id == carId);

        if (car) {
            $("#carModalLabel").text("แก้ไขข้อมูลรถ");
            $("#carId").val(car.id);
            $("#licensePlate").val(car.licensePlate);
            $("#brand").val(car.brand);
            $("#model").val(car.model);
            $("#year").val(car.year);
            $("#owner").val(car.owner);
            $("#phone").val(car.phone);
            $("#carModal").modal("show");
        }
    });

    $("#add_repair").click(function () {
        const urlParams = new URLSearchParams(window.location.search);
        const carId = urlParams.get("id");
        window.location.href = "add-repair.html?id=" + carId;
    })

    // Save car (same as in index page)
    $("#saveCarBtn").click(function () {
        if (validateCarForm()) {
            saveCar();

            // Reload the page to show updated info
            const carId = $("#carId").val();
            window.location.href = `car-detail.html?id=${carId}`;

            $("#carModal").modal("hide");
        }
    });

    // View repair details
    $(document).on("click", ".view-repair", function () {
        const repairId = $(this).data("id");
        const repair = repairs.find((r) => r.id == repairId);

        $("#print-repair").click(() => {
            print_repair_html(repairId);
        });


        if (repair) {
            // Enable and show the repair details tab
            $("#repair-details-tab").removeClass("disabled").tab("show");

            // Fill repair details
            $("#repair-billNo").text(repair.billNo);
            $("#repair-date").text(repair.date);
            $("#repair-mechanic").text(repair.mechanic);
            $("#repair-status").text(repair.status);
            $("#repair-notes").text(repair.notes || "-");

            // Fill repair items
            $("#repairPartsBody").empty();
            repair.items.forEach((item, index) => {
                const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.name}</td>
                        <td class="text-right">${item.quantity}</td>
                        <td class="text-right">${item.price.toLocaleString()}</td>
                        <td class="text-right">${item.total.toLocaleString()}</td>
                    </tr>
                `;
                $("#repairPartsBody").append(row);
            });

            // Update totals
            $("#partsTotal").text(repair.partsTotal.toLocaleString());
            $("#laborCost").text(repair.laborCost.toLocaleString());
            $("#repairTotal").text(repair.total.toLocaleString());
        }
    });
}
