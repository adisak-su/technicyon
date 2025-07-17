<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);

try {
	$DB = new Database();
	$conn = $DB->connect();

	$sql = "SELECT orderId_front AS orderId FROM userdata";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$orderId = 0;
	if (count($result) > 0) {
		$orderId = $result[0]["orderId"];
	}

	$response = [
		'status' => true,
		'orderId' => "F" . date("Y") . substr("0000" . $orderId, -5)
	];
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
