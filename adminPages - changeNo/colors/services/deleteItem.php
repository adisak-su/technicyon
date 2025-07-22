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

		// $sql = "SELECT colorname FROM colorname WHERE colorId=$itemId";
		// $stmt = $conn->prepare($sql);
		// $stmt->execute();
		// $resultColor = $stmt->fetch(PDO::FETCH_ASSOC);

		$params = [
			"itemId" => $itemId
		];
		$sql = "DELETE FROM colorname WHERE colorId=:itemId";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		$rowEffect = $stmt->rowCount();

		if ($rowEffect) {
			$response = [
				'status' => true,
				'rowEffect' => $rowEffect,
				'message' => 'ลบข้อมูลเรียบร้อย'
			];
		} else {
			$response = [
				'status' => false,
				'message' => "ไม่พบข้อมูล !!!"
			];
		}
		// updateUsercar($resultColor["colorname"], $conn, $DB);

		// $DB->updateTableStatus("colorname");
		
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

function updateUsercar($itemColorNameOld, $conn, $DB)
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
			"itemColorNameNew" => "",
		];

		$sql = "UPDATE usercar SET colorname=:itemColorNameNew WHERE colorname = :itemColorNameOld";

		$stmt = $conn->prepare($sql);
		$stmt->execute($params);

		foreach ($resultCarIds as $item) {
			$DB->updateDataChange("usercars", $item["carId"], "UPDATE", "carId");
		}
	} catch (Exception $ex) {
		throw new Exception($ex);
	}
}