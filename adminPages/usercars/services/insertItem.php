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
		$itemGroupName = $_POST["itemGroupName"];
		$itemColor = $_POST["itemColor"];
		$itemMile = $_POST["itemMile"];
		$itemYear = $_POST["itemYear"];
		$itemVehicleId = $_POST["itemVehicleId"];
		$itemName = $_POST["itemName"];
		$itemAddress = $_POST["itemAddress"];
		$itemTelephone = $_POST["itemTelephone"];
		$itemUpdatedAt = $_POST["itemUpdatedAt"];
		$params = [
			"itemId" => $itemId,
			"itemGroupName" => $itemGroupName,
			"itemColor" => $itemColor,
			"itemMile" => $itemMile,
			"itemYear" => $itemYear,
			"itemVehicleId" => $itemVehicleId,
			"itemName" => $itemName,
			"itemAddress" => $itemAddress,
			"itemTelephone" => $itemTelephone,
			"itemUpdatedAt" => $itemUpdatedAt,
		];
		$sql = "INSERT INTO usercar (carId,groupname,colorname,mile,year,vehicleId,name,address,telephone,updatedAt) VALUE(:itemId,:itemGroupName,:itemColor,:itemMile,:itemYear,:itemVehicleId,:itemName,:itemAddress,:itemTelephone,:itemUpdatedAt)";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);

		// $DB->updateDataChange("usercars", $itemId, "CREATE", "carId");
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
	$message = $ex->getMessage();
	if($ex->getCode() == 23000) {
		$message = "ทะเบียนรถยนต์ซ้ำกับที่มีอยู่แล้ว !!!";
	}
	$response = [
		'status' => false,
		'message' => $message
	];
} catch (Exception $ex) {
	$conn->rollBack();
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => $ex->getMessage()
	];
}

echo json_encode($response);
