<?php
require_once("../../../service/connect.php");

try {
	$DB = new Database();
	$conn = $DB->connect();
	$product_saleID = $_POST['productSaleID'];
	$customerID = $_POST['customerID'];

	$params = array(
		'customerID' => $customerID,
		'product_saleID' => $product_saleID
	);

	$sql = "SELECT * FROM $tb_customer_price Where customerID=:customerID AND product_saleID=:product_saleID";
	$stmt = $conn->prepare($sql);
	$stmt->execute($params);
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$response = [
		'status' => true,
		'message' => json_encode($result)
	];
} catch (PDOException $ex) {
	$response = [
		'status' => false,
		'message' => json_encode($ex)
	];
} catch (Exception $ex) {
	$response = [
		'status' => false,
		'message' => json_encode($ex)
	];
}

header('Content-Type: application/json');
http_response_code(200);
echo json_encode($response, 200);


?>