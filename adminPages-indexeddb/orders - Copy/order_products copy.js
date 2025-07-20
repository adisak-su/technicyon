// Setup event handlers for repair page

let productItems = [];

function setupProductItemEventHandlers() {
    // Save item button
    // MAXRowPerPage = 3;
    $("#saveItemBtn").click(function () {
        let countItems = $("#orderItemsBody tr").length;
        
        if(MAXRowPerPage == countItems) {
            sweetAlertError("รายการสินค้าไม่สามารถบันทึกเกิน " + MAXRowPerPage + " รายการ",3000);
            return;
        }
        addProductItem();
        
    });

    $("#vatSale").change(function () {
        updateTotals();
    });

    function computepartsTotal() {
        let partsTotal = 0;

        $("#orderItemsBody tr").each(function () {
            const quantity =
                parseFloat($(this).find(".item-quantity").val()) || 0;
            const price = parseFloat($(this).find(".item-price").val()) || 0;
            const total = quantity * price;
            partsTotal += total;
        });
        return partsTotal;
    }

    // Remove item button
    $(document).on("click", ".remove-item", async function () {
        let deleteName = $(this).closest("tr")[0].cells[0].childNodes[1].value;
        message = `${deleteName}<BR>คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?`;
        confirm = await sweetConfirmDelete(message, "ใช่! ลบเลย");
        if (confirm) {
            $(this).closest("tr").remove();
            countRow--;
            updateTotals();
        }
    });

    // Remove item button
    $(document).on("click", ".edit-item", async function () {
        let deleteName = $(this).closest("tr")[0].cells[0].childNodes[1].value;
        message = `${deleteName}<BR>คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?`;
        confirm = await sweetConfirmDelete(message, "ใช่! ลบเลย");
        if (confirm) {
            $(this).closest("tr").remove();
            updateTotals();
        }
    });

    async function prepareDelete(row) {
        let deleteId = item.productId;
        let deleteName = item.name;
        message = `${deleteName}<BR>คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?`;
        confirm = await sweetConfirmDelete(message, "ใช่! ลบเลย");
        if (confirm) {
            loaderScreen("show");
            //confirmDelete(deleteId);
            $.ajax({
                type: "POST",
                // method: "DELETE",
                url: "services/deleteProduct.php",
                data: {
                    productId: "12345689456",
                },
            })
                .done(function (resp) {
                    loaderScreen("hide");
                    if (resp.status) {
                        confirmDelete(deleteId);
                    } else {
                        sweetAlertError("เกิดข้อผิดพลาด : " + resp.message);
                    }
                })
                .fail(function (err) {
                    sweetAlertError("เกิดข้อผิดพลาด : " + err.responseText); //  JSON.stringify(err)
                    loaderScreen("hide");
                });
        }
    }
    function confirmDelete(deleteId) {
        products = products.filter((m) => m.productId !== deleteId);
        renderTable();
    }

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
    $("#vatCost").on("change", function () {
        updateTotals();
    });
}

// Add repair item to table
function addProductItem() {
    const partId = $("#productInput").val();
    const partName = $("#productName").val();
    const partPrice = parseFloat($("#productPrice").val()) || 0;
    const quantity = parseInt($("#productQty").val()) || 1;
    const total = partPrice * quantity;

    if (!partId) {
        alert("กรุณาเลือกอะไหล่");
        return;
    }

    // const item =  {
    //     productId: partId,
    //     name: partName,
    //     price: partPrice,
    //     qty: quantity,
    //     total: total
    // }
    // productItems.push(item);

    // Check if item already exists
    let itemExists = false;
    $("#orderItemsBody tr").each(function () {
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
        resetValueProductSale();
        updateTotals();
        return;
    }
    // Add new item row
    // const row = `
    //     <tr data-part-id="${partId}">
    //         <td>${partName}</td>
    //         <td>
    //             <div class="input-wrapper">
    //                 <input type="number" class="form-control text-center" value="${quantity}" placeholder="0">
    //             </div>
    //             <input type="number" class="form-control form-control-sm item-quantity" min="1" value="${quantity}" required>
    //         </td>
    //         <td>
    //             <input type="number" class="form-control form-control-sm item-price" min="0" step="0.01" value="${partPrice}" required>
    //         </td>
    //         <td class="item-total text-right">${total.toLocaleString(undefined, {
    //             minimumFractionDigits: 2,
    //             maximumFractionDigits: 2,
    //         })}</td>
    //         <td class="text-center">
    //             <button type="button" class="btn btn-sm btn-danger remove-item">
    //                 <i class="fas fa-trash"></i>
    //             </button>
    //         </td>
    //     </tr>
    // `;
    const row = `
        <tr data-part-id="${partId}">
            <td class="input-wrapper">
                <input type="text" class="form-control item-partName" value="${partName}" required>
            </td>>
            <td>
                <div class="input-wrapper">
                    <input type="number" class="form-control text-center item-quantity" min="1" value="${quantity}" placeholder="0">
                </div>
            </td>
            <td class="input-wrapper">
                <input type="number" class="form-control text-center item-price" min="0" value="${partPrice}" required>
            </td>
            <td class="item-total text-right">${total.toLocaleString(
                undefined,
                {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }
            )}</td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger remove-item">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `;
                //     <button type="button" class="btn btn-sm btn-warning edit-item">
                //     <i class="fas fa-edit"></i>
                // </button>


    $("#orderItemsBody").append(row);
    //$("#addItemModal").modal("hide");
    resetValueProductSale();
    // $("#form-product")[0].reset();
    // $("#form-product").reset();
    updateTotals();
}

// Update totals calculation
function updateTotals() {
    let partsTotal = 0;

    $("#orderItemsBody tr").each(function () {
        const quantity = parseFloat($(this).find(".item-quantity").val()) || 0;
        const price = parseFloat($(this).find(".item-price").val()) || 0;
        partsTotal += quantity * price;
    });

    let vat = $("#vatSale")[0].checked ? 1 : 0;
    let vatValue = partsTotal * 0.07 * vat;
    //let total = partsTotal + vatValue;

    //const vatCost = parseFloat($("#vatCost").val()) || 0;
    const orderTotal = partsTotal + vatValue;

    $("#vatValue").text(
        vatValue.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        })
    );

    $("#partsTotal").text(
        partsTotal.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        })
    );
    $("#orderTotal").text(
        orderTotal.toLocaleString(undefined, {
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
    const vatCost = parseFloat($("#vatCost").val()) || 0;

    // Get repair items
    const repairItems = [];
    let partsTotal = 0;

    $("#orderItemsBody tr").each(function () {
        const partId = $(this).data("part-id");
        // const partName = $(this).find("td:eq(0)").text();
        const partName = $(this).find(".item-partName").text();
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
    console.table(repairItems);

    /*
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
        vatCost: vatCost,
        partsTotal: partsTotal,
        total: partsTotal + vatCost,
    };

    // Add to repairs array
    repairs.push(repair);

    // Update car's repair count
    const carIndex = cars.findIndex((c) => c.id == carId);
    if (carIndex !== -1) {
        cars[carIndex].repairCount++;
    }
    */

    // Show success message
    alert("บันทึกการซ่อมเรียบร้อยแล้ว");
    // บันทึกข้อมูลการซ่อมและรถลง localStorage
    // saveToLocalStorage(STORAGE_KEYS.REPAIRS, repairs);
    // saveToLocalStorage(STORAGE_KEYS.CARS, cars);

    // Redirect to car detail page
    // window.location.href = `car-detail.html?id=${carId}`;
}

// Validate repair form
function validateRepairForm() {
    let isValid = true;
    return true;

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

    if ($("#orderItemsBody tr").length === 0) {
        alert("กรุณาเพิ่มรายการอะไหล่อย่างน้อย 1 รายการ");
        isValid = false;
    }

    return isValid;
}
