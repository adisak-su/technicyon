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
			$sql = "SELECT * FROM groupname WHERE updatedAt > :lastSyncTime ORDER BY groupname";
			$stmt = $conn->prepare($sql);
			$stmt->execute($param);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$response = $result;
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
