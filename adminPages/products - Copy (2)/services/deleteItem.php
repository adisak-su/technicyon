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

		$DB->updateDataChange("products",$itemId,"DELETE","productd");

		$params = [
			"itemId" => $itemId
		];
		$sql = "DELETE FROM products WHERE productId=:itemId";
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
