<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);

try {
	$DB = new Database();
	$conn = $DB->connect();

	$response = [];

	if ('POST' === $_SERVER['REQUEST_METHOD']) {
		$data = json_decode(file_get_contents("php://input"));
		// var_dump($data);
		$lastSyncTime = $data->lastSyncTime;
		if ($lastSyncTime != "empty") {
			$lastSyncTime = str_replace("T", " ", $lastSyncTime);
			$lastSyncTime = substr($lastSyncTime, 0, 19);
			$param = [
				"lastSyncTime" => $lastSyncTime
			];
			$sql = "SELECT * FROM supplier WHERE updatedAt > :lastSyncTime ORDER BY name";
			$stmt = $conn->prepare($sql);
			$stmt->execute($param);
		}
		else {
			$sql = "SELECT * FROM supplier ORDER BY name";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
		}
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$response = $result;
		if (function_exists('gzencode')) {
			$compressed = gzencode(json_encode($response), 9); // ระดับการบีบอัดสูงสุด

			// ตั้งค่า header สำหรับเนื้อหาที่บีบอัด
			header('Content-Encoding: gzip');
			header('Content-Length: ' . strlen($compressed));
			echo $compressed;
			exit;
		}
	}
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