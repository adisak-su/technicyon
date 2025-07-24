<?php
require_once("../../service/connect.php");
http_response_code(200);
try {
	$DB = new Database();
	$conn = $DB->connect();

	$sql = "SELECT * FROM tablestatus";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$response = [
		'status' => true,
		'message' => $result,
	];
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

header('Content-Type: application/json');
echo json_encode($response);
?>