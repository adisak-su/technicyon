<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);
$DB = new Database();
$conn = $DB->connect();
$conn->beginTransaction();
try {
	if (isset($_POST["itemName"]) && !empty($_POST["itemName"])) {
		$itemName = $_POST["itemName"];
		$itemUpdatedAt = $_POST["itemUpdatedAt"];
		$params = [
			"itemName" => $itemName,
			"itemUpdatedAt" => $itemUpdatedAt,
		];
		$sql = "INSERT INTO colorname (colorname,updatedAt) VALUE(:itemName,:itemUpdatedAt)";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		$last_id = $conn->lastInsertId();
		
		// $DB->updateDataChange("colornames",$last_id,"CREATE","colorNo");
		// $DB->insertTableStatus("colorname");
		
		$response = [
			'status' => true,
			'insertedId' => $last_id,
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
