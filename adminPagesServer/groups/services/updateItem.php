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
		$itemName_org = $_POST["itemName_org"];
		$itemName = $_POST["itemName"];
		$itemUpdatedAt = $_POST["itemUpdatedAt"];

		$params = [
			"itemId" => $itemId,
			"itemName" => $itemName,
			"itemUpdatedAt" => $itemUpdatedAt
		];
		$sql = "UPDATE groupname SET groupname=:itemName , updatedAt=:itemUpdatedAt  WHERE groupNo=:itemId";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		$rowEffect = $stmt->rowCount();

		// $DB->updateDataChange("groupnames", $itemId, "UPDATE", "groupNo", $itemId);
		// updateUsercar($itemName_org, $itemName, "groupname", $conn, $DB);

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

function updateUsercar($itemValueOld, $itemValueNew, $key, $conn, $DB) {
	try {
		$params = [
			"itemValueOld" => $itemValueOld
		];

		$sql = "SELECT usercarId FROM usercar WHERE $key = :itemValueOld";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		$resultusercarIds = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$params = [
			"itemValueOld" => $itemValueOld,
			"itemValueNew" => $itemValueNew
		];

		$sql = "UPDATE usercar SET $key=:itemValueNew WHERE $key = :itemValueOld";

		$stmt = $conn->prepare($sql);
		$stmt->execute($params);

		foreach ($resultusercarIds as $item) {
			$DB->updateDataChange("usercars", $item["usercarId"], "UPDATE", "usercarId", $item["usercarId"]);
		}
	} catch (Exception $ex) {
		throw new Exception($ex);
	}
}
