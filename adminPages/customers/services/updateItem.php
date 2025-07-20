<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);
$DB = new Database();
$conn = $DB->connect();
$conn->beginTransaction();
try {
	if (isset($_POST["itemId"]) && !empty($_POST["itemId"]) && isset($_POST["itemName"]) && !empty($_POST["itemName"]) && isset($_POST["itemUpdatedAt"]) && !empty($_POST["itemUpdatedAt"])) {
		$itemId_org = $_POST["itemId_org"];
		$itemId = $_POST["itemId"];
		$itemName = $_POST["itemName"];
		$itemAddress = $_POST["itemAddress"];
		$itemTelephone = $_POST["itemTelephone"];
		$itemType = $_POST["itemType"];
		$itemUpdatedAt = $_POST["itemUpdatedAt"];
		$params = [
			"itemId_org" => $itemId_org,
			"itemId" => $itemId,
			"itemName" => $itemName,
			"itemAddress" => $itemAddress,
			"itemTelephone" => $itemTelephone,
			"itemType" => $itemType,
			"itemUpdatedAt" => $itemUpdatedAt
		];
		$sql = "UPDATE customer SET customerId=:itemId, name=:itemName, address=:itemAddress, telephone=:itemTelephone, type=:itemType, updatedAt=:itemUpdatedAt  WHERE customerId=:itemId_org";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		$rowEffect = $stmt->rowCount();

		// $DB->updateDataChange("customers",$itemId,"UPDATE","customerId");
		// $DB->updateDataChange("customers",$itemId,"UPDATE","customerId",$itemId);

		if ($rowEffect) {
			$response = [
				'status' => true,
				'rowEffect' => $rowEffect,
				'message' => 'แก้ไขข้อมูลเรียบร้อย'
			];
		} else {
			$response = [
				'status' => false,
				'message' => "ไม่พบข้อมูล !!!"
			];
		}
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
	if ($ex->getCode() == 23000) {
		$message = "รหัส/ชื่อลูกค้า ซ้ำกับที่มีอยู่แล้ว !!!";
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
