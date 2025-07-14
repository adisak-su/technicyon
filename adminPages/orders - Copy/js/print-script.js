let repairs = [];
let cars = [];

const STORAGE_KEYS = {
    CARS: "carRepairSystem_cars",
    REPAIRS: "carRepairSystem_repairs",
    PARTS: "carRepairSystem_parts",
};
$(document).ready(function() {
    let repair = getStorage("order");

    
    // Fill invoice data
    $('#invoiceNo').text(repair.billNo);
    $('#invoiceDate').text(formatDate(repair.date));
    $('#customerName').text(car.owner);
    $('#customerPhone').text(car.phone);
    $('#carLicense').text(car.licensePlate);
    $('#carModel').text(`${car.brand} ${car.model}`);
    $('#carYear').text(car.year);
    $('#mechanicName').text(repair.mechanic);
    $('#mechanicNameFooter').text(repair.mechanic);
    $('#repairStatus').text(repair.status);
    $('#repairNotes').text(repair.notes || '-');
    
    // Fill repair items
    $('#invoiceItems').empty();
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
        $('#invoiceItems').append(row);
    });
    
    // Fill totals
    $('#invoicePartsTotal').text(repair.partsTotal.toLocaleString());
    $('#invoiceLaborCost').text(repair.laborCost.toLocaleString());
    $('#invoiceTotal').text(repair.total.toLocaleString());
    
    // Back button
    $('#backButton').click(function(e) {
        e.preventDefault();
        window.history.back();
    });
});


// Format date to Thai format (dd/mm/yyyy)
function formatDate(dateString) {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear() + 543; // Convert to Thai year
    
    return `${day}/${month}/${year}`;
}

/*
$(document).ready(function() {
    // Get repair ID from URL
    const urlParams = new URLSearchParams(window.location.search);
    const repairId = urlParams.get('id');

    // โหลดข้อมูลการซ่อม
    const repairsData = localStorage.getItem(STORAGE_KEYS.REPAIRS);
    if (repairsData) {
        repairs = JSON.parse(repairsData);
    }
    
    if (!repairId) {
        alert('ไม่พบข้อมูลการซ่อม');
        // window.location.href = '../index.html';
        return;
    }
    
    const carsData = localStorage.getItem(STORAGE_KEYS.CARS);
    if (carsData) {
        cars = JSON.parse(carsData);
        carIdCounter =
            cars.length > 0 ? Math.max(...cars.map((c) => c.id)) + 1 : 1000;
    }

    // Find repair data
    const repair = repairs.find(r => r.id == repairId);
    
    if (!repair) {
        alert('ไม่พบข้อมูลการซ่อม');
        // window.location.href = '../index.html';
        return;
    }
    
    // Find car data
    const car = cars.find(c => c.id == repair.carId);
    
    if (!car) {
        alert('ไม่พบข้อมูลรถ');
        window.location.href = '../index.html';
        return;
    }
    
    // Fill invoice data
    $('#invoiceNo').text(repair.billNo);
    $('#invoiceDate').text(formatDate(repair.date));
    $('#customerName').text(car.owner);
    $('#customerPhone').text(car.phone);
    $('#carLicense').text(car.licensePlate);
    $('#carModel').text(`${car.brand} ${car.model}`);
    $('#carYear').text(car.year);
    $('#mechanicName').text(repair.mechanic);
    $('#mechanicNameFooter').text(repair.mechanic);
    $('#repairStatus').text(repair.status);
    $('#repairNotes').text(repair.notes || '-');
    
    // Fill repair items
    $('#invoiceItems').empty();
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
        $('#invoiceItems').append(row);
    });
    
    // Fill totals
    $('#invoicePartsTotal').text(repair.partsTotal.toLocaleString());
    $('#invoiceLaborCost').text(repair.laborCost.toLocaleString());
    $('#invoiceTotal').text(repair.total.toLocaleString());
    
    // Back button
    $('#backButton').click(function(e) {
        e.preventDefault();
        window.history.back();
    });
});
*/
