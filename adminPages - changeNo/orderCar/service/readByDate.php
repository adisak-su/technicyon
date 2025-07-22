<?php
require_once("../../../service/connect.php");

try {
	$DB = new Database();
	$conn = $DB->connect();

	$dateSale = date("yy-m-d");
	$startDate = $_REQUEST['startDate'];
	$endDate = $_REQUEST['endDate'];
	$status = $_REQUEST['status'];
	$checkStartDate = $_REQUEST['checkStartDate'];
	$checkEndDate = $_REQUEST['checkEndDate'];
	$conditionTime = "";
	if($checkStartDate=="true" && $checkEndDate=="true") {
		$conditionTime = "WHERE orderDateTime >= '$startDate' AND orderDateTime < '$endDate' + INTERVAL 1 DAY";
	}
	else if($checkStartDate=="true") {
		$conditionTime = "WHERE orderDateTime >= '$startDate'";
	}
	else if($checkEndDate=="true") {
		$conditionTime = "WHERE orderDateTime < '$endDate' + INTERVAL 1 DAY";
	}
	else {
		$conditionTime = "";
	}

	if($status!="All") {
		// $sql = "SELECT * FROM $tb_ordersale WHERE orderDateTime >= '$startDate' AND orderDateTime < '$endDate' + INTERVAL 1 DAY AND status='$status' ORDER BY orderNo DESC";
		if($conditionTime == "") {
			$sql = "SELECT * FROM $tb_ordersale WHERE status='$status' ORDER BY orderDateTime DESC";
		}
		else {
			$sql = "SELECT * FROM $tb_ordersale $conditionTime AND status='$status' ORDER BY orderDateTime DESC";
		}
	}
	else {
		// $sql = "SELECT * FROM $tb_ordersale WHERE orderDateTime >= '$startDate' AND orderDateTime < '$endDate' + INTERVAL 1 DAY ORDER BY orderNo DESC";
		$sql = "SELECT * FROM $tb_ordersale $conditionTime ORDER BY orderDateTime DESC";
	}
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$response = [
		'status' => true,
		'message' => json_encode($result)
	];
	http_response_code(200);
} catch (PDOException $ex) {
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => json_encode($ex->getMessage())
	];
} catch (Exception $ex) {
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => json_encode($ex->getMessage())
	];
}

header('Content-Type: application/json');
echo json_encode($response);
?>