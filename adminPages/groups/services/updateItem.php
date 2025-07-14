<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);
$DB = new Database();
$conn = $DB->connect();
$conn->beginTransaction();
try {
	if (isset($_POST["itemId"]) && !empty($_POST["itemId"]) && isset($_POST["itemName"])) {
		$itemId = $_POST["itemId"];
		$itemName = $_POST["itemName"];
		$itemUpdatedAt = $_POST["itemUpdatedAt"];
		$params = [
			"itemId" => $itemId,
			"itemName" => $itemName,
			"itemUpdatedAt" => $itemUpdatedAt
		];
		$sql = "UPDATE groupname SET groupname=:itemName , updatedAt=:itemUpdatedAt  WHERE groupId=:itemId";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		$rowEffect = $stmt->rowCount();

		$DB->updateDataChange("groupnames", $itemId, "UPDATE", "groupId");

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
		http_response_code(500);
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
		$message = "ยี่ห้อ/รุ่นรถ ซ้ำกับที่มีอยู่แล้ว !!!";
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
