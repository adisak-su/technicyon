<?php
header('Content-Type: application/json');
require_once '../../../jwt/jwt_helper.php';

// ตรวจสอบ token
$token = getBearerToken();
if (!$token) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Token ไม่พบใน request']);
    exit;
}

// ตรวจสอบความถูกต้องของ token
$decoded = verify_jwt($token);
if (!$decoded) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Token ไม่ถูกต้องหรือหมดอายุ']);
    exit;
}

// ข้อมูลประวัติการซื้อตัวอย่าง (ในระบบจริงควรดึงจากฐานข้อมูล)
$purchases = [
    [
        'id' => 'ORD-2023-00158',
        'date' => '2023-10-28',
        'items' => 3,
        'total' => 8450,
        'payment_method' => 'บัตรเครดิต',
        'status' => 'completed',
        'items_detail' => [
            [
                'id' => 'PDT-1001',
                'name' => 'โน้ตบุ๊ก Lenovo ThinkPad X1 Carbon',
                'price' => 32900,
                'quantity' => 1
            ],
            [
                'id' => 'PDT-2003',
                'name' => 'เมาส์ไร้สาย Logitech MX Master 3',
                'price' => 2450,
                'quantity' => 1
            ],
            [
                'id' => 'PDT-3007',
                'name' => 'ที่เก็บข้อมูล SSD 1TB Samsung T7',
                'price' => 3900,
                'quantity' => 1
            ]
        ]
    ],
    [
        'id' => 'ORD-2023-00142',
        'date' => '2023-10-15',
        'items' => 5,
        'total' => 6250,
        'payment_method' => 'โอนผ่านธนาคาร',
        'status' => 'completed',
        'items_detail' => [
            [
                'id' => 'PDT-4002',
                'name' => 'หูฟัง Sony WH-1000XM5',
                'price' => 12900,
                'quantity' => 1
            ],
            [
                'id' => 'PDT-5005',
                'name' => 'ที่ชาร์จไร้สาย Samsung 15W',
                'price' => 1200,
                'quantity' => 2
            ]
        ]
    ],
    [
        'id' => 'ORD-2023-00135',
        'date' => '2023-10-05',
        'items' => 2,
        'total' => 18500,
        'payment_method' => 'บัตรเครดิต',
        'status' => 'completed',
        'items_detail' => [
            [
                'id' => 'PDT-6009',
                'name' => 'สมาร์ทโฟน Samsung Galaxy S23 Ultra',
                'price' => 36900,
                'quantity' => 1
            ],
            [
                'id' => 'PDT-7012',
                'name' => 'เคสป้องกัน Samsung Galaxy S23 Ultra',
                'price' => 850,
                'quantity' => 1
            ]
        ]
    ],
    [
        'id' => 'ORD-2023-00167',
        'date' => '2023-11-02',
        'items' => 4,
        'total' => 7200,
        'payment_method' => 'พร้อมเพย์',
        'status' => 'pending',
        'items_detail' => [
            [
                'id' => 'PDT-8001',
                'name' => 'สมาร์ทวอทช์ Apple Watch Series 8',
                'price' => 14900,
                'quantity' => 1
            ],
            [
                'id' => 'PDT-9003',
                'name' => 'สายนาฬิกา Apple Watch สี Midnight',
                'price' => 1900,
                'quantity' => 1
            ]
        ]
    ]
];

// ส่งข้อมูลกลับ
echo json_encode([
    'status' => 'success',
    'message' => 'ดึงข้อมูลประวัติการซื้อสำเร็จ',
    'purchases' => $purchases
]);
/*
// ฟังก์ชันดึง token จาก header
function getBearerToken() {
    $headers = apache_request_headers();
    if (isset($headers['Authorization'])) {
        $matches = [];
        if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
            return $matches[1];
        }
    }
    return null;
}
*/
?>