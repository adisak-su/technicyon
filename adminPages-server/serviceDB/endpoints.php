<?php
require_once("../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);

try {
	$DB = new Database();
	$conn = $DB->connect();
	$response = [];
	$result = [];
	if ('POST' === $_SERVER['REQUEST_METHOD']) {
		$lastSyncTime = $_POST["lastSyncTime"];
		$statusType = $_POST["statusType"];
		$tableName = $_POST["tableName"];
		
		if ($statusType == "insertExpire") {
			$params = array(
				'lastSync' => $lastSyncTime,
			);
			$sql = "SELECT * FROM $tableName WHERE updatedAt >= :lastSync";
			$stmt = $conn->prepare($sql);
			$stmt->execute($params);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$sql = "SELECT * FROM $tableName";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		$response = $result;
		$response = [
			'status' => true,
			'datas' => $result,
			'sql' => $sql . " : " . $lastSyncTime

		];
		if (function_exists('gzencode')) {
			$compressed = gzencode(json_encode($response), 9); // ระดับการบีบอัดสูงสุด

			// ตั้งค่า header สำหรับเนื้อหาที่บีบอัด
			header('Content-Encoding: gzip');
			header('Content-Length: ' . strlen($compressed));
			echo $compressed;
			exit;
		}
	}
	else {
		http_response_code(201);
		$response = [
			'status' => false,
			'message' => "Method not found !!!"
		];
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
