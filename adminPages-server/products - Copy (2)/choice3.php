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
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .search-container {
            margin: 30px 0;
        }
        .choices__list--dropdown .choices__item {
            padding: 8px 10px;
        }
    </style>
</head>
<body>
    <div class="search-container">
        <h2>ระบบค้นหาสินค้า 1,000 รายการ</h2>
        <select id="productSearch"></select>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        // สร้างข้อมูลตัวอย่าง 1,000 รายการ
        const generateProducts = () => {
            let products = [];
            const categories = [
                'อิเล็กทรอนิกส์', 'เครื่องใช้ไฟฟ้า', 'เสื้อผ้า', 
                'เครื่องสำอาง', 'ของเล่น', 'อาหาร', 'เครื่องดื่ม',
                'เฟอร์นิเจอร์', 'กีฬา', 'หนังสือ'
            ];
            
            const brands = [
                'Samsung', 'Apple', 'Sony', 'LG', 'Panasonic',
                'Nike', 'Adidas', 'Unilever', 'Nestle', 'Dell'
            ];
            
            for (let i = 1; i <= 1000; i++) {
                const category = categories[Math.floor(Math.random() * categories.length)];
                const brand = brands[Math.floor(Math.random() * brands.length)];
                products.push({
                    value: `p${i}`,
                    label: `${brand} ${category} รุ่น ${i}`,
                    customProperties: {
                        category: category,
                        brand: brand
                    }
                });
            }
            //alert(products[0].label);
            products.sort((a, b) => { 
               return a.label.localeCompare(b.label);
            });
            //alert(products[0].label);
            return products;
        };

        document.addEventListener('DOMContentLoaded', function() {
            const products = generateProducts();
            const search = new Choices('#productSearch', {
                choices: products,
                
                searchEnabled: true,
                searchFields: ['label', 'customProperties.category', 'customProperties.brand'],
                placeholderValue: 'ค้นหาสินค้า...',
                searchPlaceholderValue: 'พิมพ์ชื่อสินค้า, หมวดหมู่ หรือแบรนด์...',
                noResultsText: 'ไม่พบสินค้าที่ตรงกับคำค้นหา',
                noChoicesText: 'ไม่มีสินค้าให้เลือก',
                itemSelectText: 'กดเพื่อเลือก',
                shouldSort: false,
                sortFn: (a, b) => {
                    return a.label.length - b.label.length
                },
                fuseOptions: {
                    threshold: 0.3,
                    distance: 100,
                    minMatchCharLength: 1
                },
                position: 'auto',
                loadingText: 'กำลังโหลด...',
                searchResultLimit: 1000,
                
                
                
            });
        });
        
        /*
        choices: products,
                
                searchEnabled: true,
                searchFields: ['label', 'customProperties.category', 'customProperties.brand'],
                placeholderValue: 'ค้นหาสินค้า...',
                searchPlaceholderValue: 'พิมพ์ชื่อสินค้า, หมวดหมู่ หรือแบรนด์...',
                noResultsText: 'ไม่พบสินค้าที่ตรงกับคำค้นหา',
                noChoicesText: 'ไม่มีสินค้าให้เลือก',
                itemSelectText: 'กดเพื่อเลือก',
                shouldSort: false,
                fuseOptions: {
                    threshold: 0.3,
                    distance: 100,
                    minMatchCharLength: 1
                },
                position: 'auto',
                loadingText: 'กำลังโหลด...',
                renderChoiceLimit: 50,
                searchFloor: 1,
                searchResultLimit: 1000,
                sorter: (a, b) => {
                    return a.label.localeCompare(b.label)
                },
                sorter: (a, b) => {
                    return a.label.length - b.label.length
                },
                sortFn: (a, b) => {
                    return a.label.localeCompare(b.label)
                },
        sorter: (a, b) => {
    return a.label.localeCompare(b.label)
  },
        */
        document1.addEventListener('DOMContentLoaded', function() {
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
                shouldSort: true,
                fuseOptions: {
                    threshold: 0.3,
                    distance: 100,
                    minMatchCharLength: 2
                },
                position: 'auto',
                loadingText: 'กำลังโหลด...',
                maxItemCount: 100,
                renderChoiceLimit: 50,
                searchFloor: 1,
                searchResultLimit: 100
            });
        });
    </script>
</body>
</html>