<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json; charset=utf-8');


// ตรวจสอบว่ามีการส่งข้อมูล POST มา
$json = file_get_contents('php://input');
$data = json_decode($json, true);
$tables = $data['tables'] ?? [];

if (empty($tables) || !is_array($tables)) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Table names are required']);
    exit;
}
$DB = new Database();
$conn = $DB->connect();

$csvFilename = tempnam(sys_get_temp_dir(), 'csv_');
$csvFile = fopen($csvFilename, 'w');

// วนลูปตารางที่เลือก
foreach ($tables as $tableName) {
    // ตรวจสอบว่าตารางมีอยู่จริง
    $result = $conn->query("SHOW TABLES LIKE '{$tableName}'");
    $sql = "SHOW TABLES LIKE '{$tableName}'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) === 0) {
        continue; // ข้ามตารางที่ไม่พบ
    }

    // เขียนหัวข้อตาราง
    fputcsv($csvFile, ["=== TABLE: {$tableName} ==="]);

    // ดึงข้อมูลจากตาราง
    // $query = "SELECT * FROM `$tableName`";
    // $result = $conn->query($query);

    $sql = "SELECT * FROM `$tableName`";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!count($result)) {
        continue;
    }

    // สร้างไฟล์ CSV ชั่วคราว
    $csvFilename = tempnam(sys_get_temp_dir(), 'csv_');
    $csvFile = fopen($csvFilename, 'w');

    // เขียนหัวข้อ
    $fields = array_keys($result[0]);
    
    $headers = array();
    foreach ($fields as $field) {
        $headers[] = $field;
    }
    fputcsv($csvFile, $headers);

    // $fields = $conn->fetch_fields();
    // $headers = array();
    // foreach ($fields as $field) {
    //     $headers[] = $field->name;
    // }
    // fputcsv($csvFile, $headers);

    // เขียนข้อมูล
    foreach ($result as $row) {
        // แปลงข้อมูลเป็น UTF-8 หากจำเป็น
        $row = array_map(function ($value) {
            // if (is_string($value)) {
            //     return mb_convert_encoding($value, 'TIS-620', 'UTF-8');
            //     // แปลง encoding เป็น UTF-8 หากไม่ใช่
            //     // if (mb_detect_encoding($value, 'UTF-8', true) === false) {
            //     //     // return iconv('TIS-620', 'UTF-8', $value); // หรือใช้ 'CP874' สำหรับ Windows Thai
            //     //     return iconv('TIS-620', 'CP874', $value); // หรือใช้ 'CP874' สำหรับ Windows Thai
            //     // }
            //     // return $value;
            // }
            return $value;
        }, $row);
        fputcsv($csvFile, $row);
    }
    // while ($row = $result->fetch_row()) {
    //     // แปลงข้อมูลเป็น UTF-8 หากจำเป็น
    //     $row = array_map(function ($value) {
    //         if (is_string($value)) {
    //             return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    //         }
    //         return $value;
    //     }, $row);
    //     fputcsv($csvFile, $row);
    // }
    fputcsv($csvFile, [""]);

    // fclose($csvFile);

    // // เพิ่มไฟล์ CSV เข้าไปใน ZIP
    // $zip->addFile($csvFilename, $tableName . '.csv');
}
fclose($csvFile);

// ปิด ZIP
// $zip->close();

// ส่งไฟล์ CSV ไปให้ผู้ใช้
$downloadFilename = 'multi_table_export_' . date('Ymd_His') . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment;filename="' . $downloadFilename . '"');
header('Cache-Control: max-age=0');

readfile($csvFilename);
unlink($csvFilename);

// // ส่งไฟล์ ZIP ไปให้ผู้ใช้
// $downloadFilename = 'multi_table_export_' . date('Ymd_His') . '.zip';

// header('Content-Type: application/zip');
// header('Content-Disposition: attachment;filename="' . $downloadFilename . '"');
// header('Cache-Control: max-age=0');
// header('Content-Length: ' . filesize($zipFilename));

// readfile($zipFilename);

// // ลบไฟล์ชั่วคราว
// unlink($zipFilename);
// array_map('unlink', glob(sys_get_temp_dir() . '/csv_*'));

// echo $fields;

exit;
