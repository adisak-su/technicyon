// Setup event handlers for repair page

let productItems = [];

function setupProductItemEventHandlers() {
    // Save item button
    // MAXRowPerPage = 3;
    $("#saveItemBtn").click(function () {
        let countItems = $("#orderItemsBody tr").length;

        if (MAXRowPerPage == countItems) {
            sweetAlertError(
                "รายการสินค้าไม่สามารถบันทึกเกิน " + MAXRowPerPage + " รายการ",
                3000
            );
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

    // Quantity or price change
    $(document).on("keyup change", ".item-quantity, .item-price", function () {
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
    const row = `
        <tr data-part-id="${partId}">
            <td class="input-wrapper">
                <input type="text" class="form-control item-partName" value="${partName}" required>
            </td>>
            <td>
                <div class="input-wrapper">
                    <input type="number" class="form-control text-center item-quantity" min="1" value="${quantity}"  onkeypress="return isNumber(event);" placeholder="0">
                </div>
            </td>
            <td class="input-wrapper">
                <input type="number" class="form-control text-center item-price" min="0" value="${partPrice}"  onkeypress="return isNumber(event);" required>
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

    $("#orderItemsBody").append(row);
    resetValueProductSale();
    updateTotals();
}

function addProductItemFromJSON(items) {
    
    $("#orderItemsBody").html("");
    if(!items) return;
    items.forEach((item) => {
        const partId = item.id;
        const partName = item.name;
        const partPrice = item.price || 0;
        const quantity = item.quantity || 1;
        const total = partPrice * quantity;

        const row = `
        <tr data-part-id="${partId}">
            <td class="input-wrapper">
                <input type="text" class="form-control item-partName" value="${partName}" required>
            </td>>
            <td>
                <div class="input-wrapper">
                    <input type="number" class="form-control text-center item-quantity" min="1" value="${quantity}"  onkeypress="return isNumber(event);" placeholder="0">
                </div>
            </td>
            <td class="input-wrapper">
                <input type="number" class="form-control text-center item-price" min="0" value="${partPrice}"  onkeypress="return isNumber(event);" required>
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

        $("#orderItemsBody").append(row);
    });
    resetValueProductSale();
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
