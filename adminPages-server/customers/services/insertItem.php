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
		$itemAddress = $_POST["itemAddress"];
		$itemTelephone = $_POST["itemTelephone"];
		$itemType = $_POST["itemType"];
		$itemUpdatedAt = $_POST["itemUpdatedAt"];
		$itemId = getCounter($conn);
		$itemId = "C" . substr("000000000" . $itemId, -9);
		$params = [
			"itemId" => $itemId,
			"itemName" => $itemName,
			"itemAddress" => $itemAddress,
			"itemTelephone" => $itemTelephone,
			"itemType" => $itemType,
			"itemUpdatedAt" => $itemUpdatedAt,
		];
		$sql = "INSERT INTO customer (customerId,name,address,telephone,type,updatedAt) VALUE(:itemId,:itemName,:itemAddress,:itemTelephone,:itemType,:itemUpdatedAt)";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		
		$DB->updateDataChange("customers",$itemId,"CREATE","customerId");
		$response = [
			'status' => true,
			'insertedId' => $itemId,
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

function getCounter($conn)
{
	try {
		$sql = "SELECT customerId AS countNo FROM userdata";
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$sql = "UPDATE userdata SET customerId=customerId+1";
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		if (count($result)) {
			return $result[0]['countNo'];
		} else {
			return 1;
		}
	} catch (Exception $ex) {
		throw new Exception($ex);
	}
}