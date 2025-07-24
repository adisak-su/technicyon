<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);

try {
	$DB = new Database();
	$conn = $DB->connect();

	$response = [];

	$sql = "SELECT orderId,usercarId,mydate,nettotal FROM usercar_head ORDER BY mydate DESC";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$response = [
		'status' => true,
		'message' => $result
	];
} catch (PDOException $ex) {
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => $ex->getMessage()
	];
} catch (Exception $ex) {
	$conn->rollBack();
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => $ex->getMessage()
	];
}

echo json_encode($response);
