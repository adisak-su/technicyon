<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);

try {
	$DB = new Database();
	$conn = $DB->connect();
	if (isset($_POST["itemName"]) && !empty($_POST["itemName"]) && isset($_POST["itemUpdatedAt"]) && !empty($_POST["itemUpdatedAt"])) {
		$itemName = $_POST["itemName"];
		$itemUpdatedAt = $_POST["itemUpdatedAt"];
		$params = [
			"itemName" => $itemName,
			"itemUpdatedAt" => $itemUpdatedAt,
		];
		$sql = "INSERT INTO groupname (groupname,updatedAt) VALUE(:itemName,:itemUpdatedAt)";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		$last_id = $conn->lastInsertId();
		$response = [
			'status' => true,
			'insertedId' => $last_id
		];
	} else {
		http_response_code(500);
		$response = [
			'status' => false,
			'message' => "Error Data"
		];
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
