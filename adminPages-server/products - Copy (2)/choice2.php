<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบค้นหาสินค้าแบบครบถ้วน</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        .search-container {
            margin: 30px 0;
        }
        .custom-choices .choices__list--dropdown {
            max-height: 400px;
            overflow-y: auto;
        }
        .custom-choices .choices__list--multiple .choices__item {
            background-color: #4a6cf7;
            border: 1px solid #3a5bd9;
        }
        .choices__list--dropdown .choices__item {
            padding: 10px 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="search-container">
        <h2>ระบบค้นหาสินค้า 1,000 รายการ</h2>
        <select id="productSearch" multiple></select>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        // สร้างข้อมูลตัวอย่าง 1,000 รายการ
        const generateProducts = () => {
            const products = [];
            const categories = ['อิเล็กทรอนิกส์', 'เครื่องใช้ไฟฟ้า', 'เสื้อผ้า', 'เครื่องสำอาง', 'ของเล่น'];
            const brands = ['Samsung', 'Apple', 'Sony', 'LG', 'Panasonic', 'Nike', 'Adidas'];
            
            for (let i = 1; i <= 1000; i++) {
                const category = categories[Math.floor(Math.random() * categories.length)];
                const brand = brands[Math.floor(Math.random() * brands.length)];
                products.push({
                    value: `p${i}`,
                    label: `${brand} ${category} รุ่น ${i}`,
                    customProperties: {
                        category: category,
                        brand: brand,
                        id: i
                    }
                });
            }
            return products;
        };

        document.addEventListener('DOMContentLoaded', function() {
            const products = generateProducts();
            const search = new Choices('#productSearch', {
                choices: products,
                removeItemButton: true,
                searchEnabled: true,
                searchFields: ['label', 'customProperties.category', 'customProperties.brand'],
                placeholderValue: 'ค้นหาสินค้า...',
                searchPlaceholderValue: 'พิมพ์ชื่อสินค้า, หมวดหมู่ หรือแบรนด์...',
                noResultsText: 'ไม่พบสินค้าที่ตรงกับคำค้นหา',
                noChoicesText: 'ไม่มีสินค้าให้เลือก',
                itemSelectText: 'กดเพื่อเลือก',
                shouldSort: false,
                fuseOptions: {
                    threshold: 0.4,
                    distance: 50,
                    minMatchCharLength: 1
                },
                position: 'auto',
                loadingText: 'กำลังค้นหา... กรุณารอสักครู่',
                maxItemCount: 100,
                renderChoiceLimit: 100,
                searchFloor: 0,
                searchResultLimit: 200,
                classNames: {
                    containerOuter: 'choices custom-choices'
                }
            });

            // เพิ่ม Event Listener สำหรับการค้นหา
            document.querySelector('.choices__input').addEventListener('input', function(e) {
                console.log('กำลังค้นหา:', e.target.value);
            });
        });
    </script>
</body>
</html>