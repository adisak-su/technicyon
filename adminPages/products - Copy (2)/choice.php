<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choices.js กับระบบค้นหา</title>
    <!-- Choices.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            margin: 30px 0;
        }
        h2 {
            color: #2c3e50;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .select-box {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>ระบบเลือกกลุ่มสินค้า (พร้อมค้นหา)</h2>
        
        <div class="select-box">
            <label for="singleSelect">เลือกรายการเดียว:</label>
            <select id="singleSelect"></select>
        </div>
        
        <div class="select-box">
            <label for="multiSelect">เลือกหลายรายการ:</label>
            <select id="multiSelect" multiple></select>
        </div>
    </div>

    <!-- Choices.js JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        // ข้อมูลกลุ่มสินค้า 100 รายการ
        const productGroups = [
            {value: 'g1', label: 'อิเล็กทรอนิกส์ - โทรศัพท์มือถือ'},
            {value: 'g2', label: 'อิเล็กทรอนิกส์ - คอมพิวเตอร์'},
            {value: 'g3', label: 'เครื่องใช้ในบ้าน - เครื่องซักผ้า'},
            {value: 'g4', label: 'เครื่องใช้ในบ้าน - ตู้เย็น'},
            {value: 'g5', label: 'แฟชั่น - เสื้อผ้าผู้ชาย'},
            {value: 'g6', label: 'แฟชั่น - เสื้อผ้าผู้หญิง'},
            // เพิ่มข้อมูลอีก 94 รายการ...
            {value: 'g100', label: 'เครื่องเขียน - สมุดบันทึก'}
        ];

        // สำหรับตัวอย่าง เราจะสร้างข้อมูลเพิ่มอัตโนมัติ
        for (let i = 7; i <= 100; i++) {
            const categories = ['อิเล็กทรอนิกส์', 'เครื่องใช้ในบ้าน', 'แฟชั่น', 'ของใช้เด็ก', 'อาหาร', 'สุขภาพ'];
            const subCategories = ['โทรศัพท์', 'คอมพิวเตอร์', 'เครื่องซักผ้า', 'ตู้เย็น', 'เสื้อผ้า', 'เครื่องสำอาง', 'อาหารเสริม', 'ของเล่น'];
            
            const category = categories[Math.floor(Math.random() * categories.length)];
            const subCategory = subCategories[Math.floor(Math.random() * subCategories.length)];
            
            productGroups.push({
                value: `g${i}`,
                label: `${category} - ${subCategory} ${i}`
            });
        }

        // เรียกใช้งาน Choices.js เมื่อ DOM โหลดเสร็จ
        document.addEventListener('DOMContentLoaded', function() {
            // ตัวเลือกแบบเลือกรายการเดียว
            const singleSelect = new Choices('#singleSelect', {
                choices: productGroups,
                searchEnabled: true,
                placeholder: true,
                placeholderValue: 'ค้นหาหรือเลือกกลุ่มสินค้า...',
                searchPlaceholderValue: 'พิมพ์เพื่อค้นหา...',
                noResultsText: 'ไม่พบผลลัพธ์ที่ตรงกัน',
                itemSelectText: 'กดเพื่อเลือก',
                shouldSort: true,
                position: 'auto'
                shouldSort: true,
                fuseOptions: {
                    threshold: 0.3,
                    distance: 100,
                    minMatchCharLength: 2
                },
                
                loadingText: 'กำลังโหลด...',
                
                renderChoiceLimit: 50,
                searchFloor: 1,
                searchResultLimit: 100
            });

            // ตัวเลือกแบบหลายรายการ
            const multiSelect = new Choices('#multiSelect', {
                choices: productGroups,
                removeItemButton: true,
                searchEnabled: true,
                placeholder: true,
                placeholderValue: 'ค้นหาหรือเลือกหลายกลุ่มสินค้า...',
                searchPlaceholderValue: 'พิมพ์เพื่อค้นหา...',
                noResultsText: 'ไม่พบผลลัพธ์ที่ตรงกัน',
                itemSelectText: 'กดเพื่อเลือก',
                maxItemCount: 5,
                shouldSort: true
            });
        });
    </script>
</body>
</html>