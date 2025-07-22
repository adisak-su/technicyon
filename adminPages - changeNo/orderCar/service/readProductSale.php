<?php
require_once("../../../service/connect.php");

try {
	$DB = new Database();
	$conn = $DB->connect();

	$sql = "SELECT * FROM $tb_product_sale WHERE status=1 ORDER BY name";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
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