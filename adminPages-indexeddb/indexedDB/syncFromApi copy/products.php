<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);
set_time_limit(120);
try {
	$DB = new Database();
	$conn = $DB->connect();
	$response = [];

	// var_dump($data);
	$sql = "SELECT * FROM product ORDER BY name";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$response = $result;
	$response = [
		'status' => false,
		'message' => $result
	];

	// 4. ตรวจสอบการรองรับการบีบอัดของ Client
	// $supportsGzip = strpos($_SERVER['HTTP_ACCEPT_ENCODING'] ?? '', 'gzip') !== false;

	// 5. บีบอัดข้อมูล (ถ้ารองรับ)
	if (function_exists('gzencode')) {
		$compressed = gzencode(json_encode($response), 9); // ระดับการบีบอัดสูงสุด

		// ตั้งค่า header สำหรับเนื้อหาที่บีบอัด
		header('Content-Encoding: gzip');
		header('Content-Length: ' . strlen($compressed));

		echo $compressed;
		exit;
	}
	$response = [
		'status' => false,
		'message' => "! function_exists('gzencode')"
	];

	// ปิดการเชื่อมต่อฐานข้อมูล
	// $pdo = null;
} catch (PDOException $ex) {
	$response = [
		'status' => false,
		'message' => json_encode($ex)
	];
} catch (Exception $ex) {
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => json_encode($ex)
	];
}

echo json_encode($response);
