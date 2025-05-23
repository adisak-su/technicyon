<?php
require_once("../../../service/connect.php");

try {
	$DB = new Database();
	$conn = $DB->connect();

	$orderNo = $_REQUEST["orderNo"];

	$sql = "SELECT * FROM $tb_ordersale WHERE orderNo='$orderNo'";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$sql = "SELECT * FROM $tb_detailsale WHERE orderNo='$orderNo'";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$resultDetail = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$response = [
		'status' => true,
		'message' => json_encode(array("header"=>$result[0],"detail"=>$resultDetail))
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