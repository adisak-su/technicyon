<?php
require_once("../../../service/connect.php");

try {
	$DB = new Database();
	$conn = $DB->connect();

	$dateSale = date("yy-m-d");
	$startDate = $_REQUEST['startDate'];
	$endDate = $_REQUEST['endDate'];
	$checkStartDate = $_REQUEST['checkStartDate'];
	$conditionTime = "";
	if($checkStartDate=="true") {
		$conditionTime = "orderDateTime >= '$startDate' AND orderDateTime < '$endDate' + INTERVAL 1 DAY";
	}
	else {
		$conditionTime = "orderDateTime < '$endDate' + INTERVAL 1 DAY";
	}

	// $sql = "SELECT saleDate,Sum(total) as sumTotal FROM (SELECT DATE_FORMAT(saleDate, '%Y-%m-%d') as saleDate,total FROM $tb_sales WHERE saleDate >= '$startDate' AND saleDate < '$endDate' + INTERVAL 1 DAY) as tmp group by tmp.saleDate ORDER BY tmp.saleDate desc";

	if($checkStartDate=="true") {
		$sql = "SELECT * FROM $tb_ordersale WHERE $conditionTime AND status=1 ORDER BY orderNo DESC";
	}
	else {
		$sql = "SELECT * FROM $tb_ordersale WHERE $conditionTime AND status=1 ORDER BY orderNo DESC";
	}

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