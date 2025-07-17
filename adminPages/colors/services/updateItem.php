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

		// $params = [
		// 	"itemId" => $itemId,
		// ];
		// $sql = "SELECT colorname FROM colorname WHERE colorId=:itemId";
		// $stmt = $conn->prepare($sql);
		// $stmt->execute($params);
		// $resultColor = $stmt->fetch(PDO::FETCH_ASSOC);

		$params = [
			"itemId" => $itemId,
			"itemName" => $itemName,
			"itemUpdatedAt" => $itemUpdatedAt
		];
		$sql = "UPDATE colorname SET colorname=:itemName , updatedAt=:itemUpdatedAt WHERE colorId=:itemId";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		$rowEffect = $stmt->rowCount();

		// $DB->updateDataChange("colornames", $itemId, "UPDATE", "colorId");
		$DB->updateDataChange("colornames",$itemId,"UPDATE","colorId",$itemId);

		// updateUsercar($resultColor["colorname"], $itemName, $conn, $DB);
		updateUsercar($itemName_org, $itemName, "colorname", $conn, $DB);

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
		$message = "สีรถยนต์ ซ้ำกับที่มีอยู่แล้ว !!!";
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

		$sql = "SELECT carId FROM usercar WHERE $key = :itemValueOld";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		$resultCarIds = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$params = [
			"itemValueOld" => $itemValueOld,
			"itemValueNew" => $itemValueNew
		];

		$sql = "UPDATE usercar SET $key=:itemValueNew WHERE $key = :itemValueOld";

		$stmt = $conn->prepare($sql);
		$stmt->execute($params);

		foreach ($resultCarIds as $item) {
			$DB->updateDataChange("usercars", $item["carId"], "UPDATE", "carId", $item["carId"]);
		}
	} catch (Exception $ex) {
		throw new Exception($ex);
	}
}

function _updateUsercar($itemColorNameOld, $itemColorNameNew, $conn, $DB)
{
	try {
		$params = [
			"itemColorNameOld" => $itemColorNameOld
		];

		$sql = "SELECT carId FROM usercar WHERE colorname = :itemColorNameOld";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		$resultCarIds = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$params = [
			"itemColorNameOld" => $itemColorNameOld,
			"itemColorNameNew" => $itemColorNameNew
		];

		$sql = "UPDATE usercar SET colorname=:itemColorNameNew WHERE colorname = :itemColorNameOld";

		$stmt = $conn->prepare($sql);
		$stmt->execute($params);

		foreach ($resultCarIds as $item) {
			$DB->updateDataChange("usercars", $item["carId"], "UPDATE", "carId", $item["carId"]);
		}
	} catch (Exception $ex) {
		throw new Exception($ex);
	}
}
