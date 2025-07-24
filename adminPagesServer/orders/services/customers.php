<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);

try {
	$DB = new Database();
	$conn = $DB->connect();
	$response = [
		'status' => false,
		'message' => []
	];

	$sql = "SELECT * FROM customer ORDER BY name";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	// $response = $result;
	$response = [
		'status' => true,
		'message' => $result
	];
	if (function_exists('gzencode')) {
		$compressed = gzencode(json_encode($response), 9); // ระดับการบีบอัดสูงสุด

		// ตั้งค่า header สำหรับเนื้อหาที่บีบอัด
		header('Content-Encoding: gzip');
		header('Content-Length: ' . strlen($compressed));
		echo $compressed;
		exit;
	}
} catch (PDOException $ex) {
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => $ex->getMessage()
	];
} catch (Exception $ex) {
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => $ex->getMessage()
	];
}
echo json_encode($response);
