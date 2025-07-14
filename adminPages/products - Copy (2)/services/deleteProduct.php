<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);

try {
	$DB = new Database();
	$conn = $DB->connect();
	if (isset($_POST["productId"]) && !empty($_POST["productId"])) {
		// $data = json_decode(file_get_contents("php://input"));
		// var_dump($data);
		$productId = $_POST["productId"];
		$params = [
			"productId" => $productId
		];
		$sql = "DELETE FROM products WHERE productId=:productId";
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
