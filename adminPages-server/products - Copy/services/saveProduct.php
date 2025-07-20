<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);

try {
	$DB = new Database();
	$conn = $DB->connect();
	if ('PUT' === $_SERVER['REQUEST_METHOD']) {
		$data = json_decode(file_get_contents("php://input"));
		var_dump($data);
		$productId = $data->productId;
		$productName = $data->productName;
		$price = $data->price;
		$params = [
			"productId" => $productId,
			"productName" => $productName,
			"price" => $price,
		];
		$sql = "UPDATE products SET productName = :productName,price = :price WHERE productId=:productId";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		$response = "OK";
	}
	else {
		http_response_code(500);
		$response = "Error Method";
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
