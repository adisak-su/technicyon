<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);

try {
	$DB = new Database();
	$conn = $DB->connect();
	if (isset($_POST["itemId"]) && !empty($_POST["itemId"])) {
		$itemId = $_POST["itemId"];
		$params = [
			"itemId" => $itemId
		];
		$sql = "DELETE FROM groupname WHERE groupId=:itemId";
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
