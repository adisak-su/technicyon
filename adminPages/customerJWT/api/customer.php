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

// ข้อมูลลูกค้าตัวอย่าง (ในระบบจริงควรดึงจากฐานข้อมูล)
$customer = [
    'id' => 'CUST-2023-00125',
    'name' => 'นางสาวสมหญิง ใจดี',
    'full_name' => 'สมหญิง ใจดี',
    'gender' => 'หญิง',
    'dob' => '1990-05-15',
    'age' => 33,
    'email' => 'somying@example.com',
    'phone' => '081-234-5678',
    'address' => '123/456 ถนนสุขุมวิท แขวงคลองเตย เขตคลองเตย กรุงเทพมหานคร 10110',
    'join_date' => '2021-03-12',
    'type' => 'ลูกค้าประจำ',
    'points' => 12500,
    'status' => 'ใช้งานอยู่',
    'total_purchases' => 24,
    'total_spent' => 125800,
    'last_purchase' => '2023-10-28',
    'level' => 'Gold'
];

// ส่งข้อมูลกลับ
echo json_encode([
    'status' => 'success',
    'message' => 'ดึงข้อมูลลูกค้าสำเร็จ',
    'customer' => $customer
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