<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);

try {
	$DB = new Database();
	$conn = $DB->connect();

	$sql = "SELECT productid,name,groupname,suppliername,typename,price0, price1, price2, price3 FROM product ORDER BY name";
	$sql = "SELECT productid,name,price0, price1, price2, price3 FROM product ORDER BY name";
	$sql = "SELECT * FROM groupname ORDER BY groupname";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$response = [
		'status' => true,
		'message' => $result
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
