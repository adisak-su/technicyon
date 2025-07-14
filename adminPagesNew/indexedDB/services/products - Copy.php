<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);

try {
	$DB = new Database();
	$conn = $DB->connect();

	$sql = "SELECT productid as id,name,groupname, price1,now() as updateAt FROM product LIMIT 100";
	//$sql = "SELECT productid,name,price0, price1, price2, price3 FROM product ORDER BY name";
	//$sql = "SELECT productid as id,name,groupname, price1,updatedAt FROM products LIMIT 100";
	$sql = "SELECT productid as productId,name, price1 as price,now() as updateAt FROM product LIMIT 100";
	//$sql = "SELECT productid as productId,name, price1 as price,now() as updateAt FROM product LIMIT 10000";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$response = $result;
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