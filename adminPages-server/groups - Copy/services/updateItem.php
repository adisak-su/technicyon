<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);

try {
	$DB = new Database();
	$conn = $DB->connect();
	if (isset($_POST["itemId"]) && !empty($_POST["itemId"]) && isset($_POST["itemName"]) && !empty($_POST["itemName"]) && isset($_POST["itemUpdatedAt"]) && !empty($_POST["itemUpdatedAt"])) {
		$itemId = $_POST["itemId"];
		$itemName = $_POST["itemName"];
		$itemUpdatedAt = $_POST["itemUpdatedAt"];
		$params = [
			"itemId" => $itemId,
			"itemName" => $itemName,
			"itemUpdatedAt" => $itemUpdatedAt
		];
		$sql = "UPDATE groupname SET groupname=:itemName , updatedAt=:itemUpdatedAt  WHERE groupId=:itemId";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		$response = [
			'status' => true
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
