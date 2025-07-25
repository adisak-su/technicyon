<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);
$DB = new Database();
$conn = $DB->connect();
$conn->beginTransaction();
try {
	if (isset($_POST["itemId"]) && !empty($_POST["itemId"])) {
		$itemId = $_POST["itemId"];
		$itemType = $_POST["itemType"];
		$itemColor = $_POST["itemColor"];
		$itemMile = $_POST["itemMile"];
		$itemName = $_POST["itemName"];
		$itemAddress = $_POST["itemAddress"];
		$itemTelephone = $_POST["itemTelephone"];
		$itemUpdatedAt = $_POST["itemUpdatedAt"];
		$params = [
			"itemId" => $itemId,
			"itemType" => $itemType,
			"itemColor" => $itemColor,
			"itemMile" => $itemMile,
			"itemName" => $itemName,
			"itemAddress" => $itemAddress,
			"itemTelephone" => $itemTelephone,
			"itemUpdatedAt" => $itemUpdatedAt,
		];
		$sql = "INSERT INTO usercar (carId,type,color,mile,name,address,telephone,updatedAt) VALUE(:itemId,:itemType,:itemColor,:itemMile,:itemName,:itemAddress,:itemTelephone,:itemUpdatedAt)";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		
		$DB->updateDataChange("usercars",$itemId,"CREATE","carId");
		$response = [
			'status' => true,
			'message' => 'เพิ่มข้อมูลเรียบร้อย'
		];
	} else {
		http_response_code(401);
		$response = [
			'status' => false,
			'message' => "Error Data"
		];
	}
	$conn->commit();
} catch (PDOException $ex) {
	$conn->rollBack();
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => json_encode($ex)
	];
} catch (Exception $ex) {
	$conn->rollBack();
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => json_encode($ex)
	];
}

echo json_encode($response);