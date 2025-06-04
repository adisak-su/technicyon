<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>ค้นหาสินค้า & ลูกค้า (มี code และรายละเอียด)</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .autocomplete-container {
            position: relative;
        }

        .suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            border: 1px solid #ccc;
            border-top: none;
            max-height: 200px;
            overflow-y: auto;
            background-color: #fff;
            z-index: 1000;
        }

        .suggestion-item {
            padding: 8px 12px;
            cursor: pointer;
        }

        .suggestion-item:hover,
        .suggestion-item.active {
            background-color: rgb(122, 184, 247);
        }

        .details-box {
            font-size: 90%;
            margin-top: 5px;
            color: #555;
        }

        /* style button */
        .boxx {
            padding: 12px 26px;
            border: 0;
            font-size: 16px;
            font-weight: 600;
            border-radius: 12px;
            background-image: radial-gradient(50% 115% at 50% -5%, rgba(255, 255, 255, 0.11) 0%, transparent 100%);
            box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
        }
        .boxx:focus:not(:focus-visible) {
            outline: none;
            box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
        }
        .boxx:active,
        .boxx:focus {
            background-image: radial-gradient(50% 115% at 50% -5%, rgba(255, 255, 255, 0.11) 0%, transparent 100%);
            box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
        }
        .boxx:active:active {
            background-image: radial-gradient(50% 115% at 50% -5%, rgba(255, 255, 255, 0.11) 0%, transparent 100%);
            box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
        }
        .boxx:not(:disabled):not(:disabled):active:focus {
            box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
        }
        .boxx:active {
            transform: scale(.95);
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h4 class="mb-4">ค้นหาสินค้า & ลูกค้า พร้อมรายละเอียด</h4>

        <!-- ค้นหาสินค้า -->
        <div class="form-group autocomplete-container mb-4">
            <label for="productInput">สินค้า</label>
            <input type="text" id="productInput" class="form-control" placeholder="พิมพ์ชื่อหรือรหัสสินค้า..." autocomplete="off">
            <input type="hidden" id="productCode">
            <div id="productSuggestions" class="suggestions"></div>
            <div id="productDetails" class="details-box"></div>
        </div>

        <!-- ค้นหาลูกค้า -->
        <div class="form-group autocomplete-container">
            <label for="customerInput">ลูกค้า</label>
            <input type="text" id="customerInput" class="form-control" placeholder="พิมพ์ชื่อลูกค้าหรือรหัส..." autocomplete="off">
            <input type="hidden" id="customerCode">
            <div id="customerSuggestions" class="suggestions"></div>
            <div id="customerDetails" class="details-box"></div>
        </div>

        <div>
            <button class="btn btn-primary boxx">
                <span class="text">Button boxx</span>
            </button>
            <button class="btn btn-success boxx">
                <span class="text">Button boxx</span>
            </button>
        </div>
    </div>

    <script>
        // ข้อมูลสินค้า (code, name, price)
        const products = Array.from({
            length: 1000
        }, (_, i) => ({
            code: `P${(i + 1).toString().padStart(4, '0')}`,
            name: `สินค้า ${(i + 1).toString().padStart(4, '0')}`,
            price: (Math.random() * 1000 + 100).toFixed(2) + " บาท"
        }));

        // ข้อมูลลูกค้า (code, name, address)
        const customers = Array.from({
            length: 500
        }, (_, i) => ({
            code: `C${(i + 1).toString().padStart(4, '0')}`,
            name: `ลูกค้า ${(i + 1).toString().padStart(4, '0')}`,
            address: `ที่อยู่ ${i + 1} ถนนสุขุมวิท เขตบางนา กรุงเทพฯ`
        }));

        function setupAutocomplete(inputId, suggestionsId, hiddenId, detailsId, dataList, displayField1, displayField2) {
            const input = document.getElementById(inputId);
            const suggestionsBox = document.getElementById(suggestionsId);
            const hiddenInput = document.getElementById(hiddenId);
            const detailsBox = document.getElementById(detailsId);
            let currentFocus = -1;

            input.addEventListener("input", function() {
                const value = this.value.toLowerCase();
                suggestionsBox.innerHTML = "";
                currentFocus = -1;
                detailsBox.textContent = "";
                hiddenInput.value = "";

                if (!value || value.length < 2) return;

                const matches = dataList.filter(item =>
                    item.code.toLowerCase().includes(value) || item.name.toLowerCase().includes(value)
                );

                matches.forEach(item => {
                    const div = document.createElement("div");
                    div.textContent = `${item.code} - ${item.name}`;
                    div.classList.add("suggestion-item");
                    div.addEventListener("click", () => {
                        input.value = `${item.code} - ${item.name}`;
                        input.value = `${item.code}`;
                        hiddenInput.value = item.code;
                        detailsBox.textContent = `${displayField1}: ${item[displayField1]} | ${displayField2}: ${item[displayField2]}`;
                        suggestionsBox.innerHTML = "";
                    });
                    suggestionsBox.appendChild(div);
                });
            });

            input.addEventListener("keydown", function(e) {
                const items = suggestionsBox.querySelectorAll(".suggestion-item");

                if (e.key === "ArrowDown") {
                    currentFocus++;
                    if (currentFocus >= items.length) currentFocus = 0;
                    setActive(items);
                    e.preventDefault();
                } else if (e.key === "ArrowUp") {
                    currentFocus--;
                    if (currentFocus < 0) currentFocus = items.length - 1;
                    setActive(items);
                    e.preventDefault();
                } else if (e.key === "Enter") {
                    if (currentFocus > -1 && items[currentFocus]) {
                        items[currentFocus].click();
                    }
                    e.preventDefault();
                }
            });

            function setActive(items) {
                if (!items.length) return;
                items.forEach(item => item.classList.remove("active"));
                items[currentFocus]?.classList.add("active");
                items[currentFocus]?.scrollIntoView({
                    block: "nearest"
                });
            }

            document.addEventListener("click", (e) => {
                if (!e.target.closest(`#${inputId}`)) {
                    suggestionsBox.innerHTML = "";
                }
            });
        }

        // เรียกใช้ autocomplete สำหรับสินค้า
        setupAutocomplete(
            "productInput", "productSuggestions", "productCode", "productDetails",
            products, "price", "name"
        );

        // เรียกใช้ autocomplete สำหรับลูกค้า
        setupAutocomplete(
            "customerInput", "customerSuggestions", "customerCode", "customerDetails",
            customers, "address", "name"
        );
    </script>

</body>

</html>