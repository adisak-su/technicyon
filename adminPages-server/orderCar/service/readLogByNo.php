<?php
require_once("../../../service/connect.php");

try {
	$DB = new Database();
	$conn = $DB->connect();

	$orderNo = $_REQUEST["orderNo"];
    

	$sql = "SELECT * FROM $tb_ordersale_change WHERE orderNo='$orderNo' INNER JOIN $tb_admins ON $tb_ordersale_change.adminID=$tb_admins.adminID";

    $sql = "SELECT * FROM (SELECT * FROM $tb_ordersale_change WHERE orderNo='$orderNo') AS tmpChange INNER JOIN $tb_admins ON tmpChange.adminID=$tb_admins.adminID";
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