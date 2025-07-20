<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);
$DB = new Database();
$conn = $DB->connect();
$conn->beginTransaction();
try {
	if (isset($_POST["itemName"]) && !empty($_POST["itemName"]) && isset($_POST["itemUpdatedAt"]) && !empty($_POST["itemUpdatedAt"])) {
		$itemName = $_POST["itemName"];
		$itemAddress = $_POST["itemAddress"];
		$itemTelephone = $_POST["itemTelephone"];
		$itemUpdatedAt = $_POST["itemUpdatedAt"];
		$itemId = getCounter($conn);
		$itemId = "S" . substr("000000000" . $itemId, -9);
		$params = [
			"itemId" => $itemId,
			"itemName" => $itemName,
			"itemAddress" => $itemAddress,
			"itemTelephone" => $itemTelephone,
			"itemUpdatedAt" => $itemUpdatedAt,
		];
		$sql = "INSERT INTO supplier (supplierId,name,address,telephone,updatedAt) VALUE(:itemId,:itemName,:itemAddress,:itemTelephone,:itemUpdatedAt)";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		
		$DB->updateDataChange("suppliers",$itemId,"CREATE","supplierId");
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

function getCounter($conn)
{
	try {
		$sql = "SELECT supplierId AS countNo FROM userdata";
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$sql = "UPDATE userdata SET supplierId=supplierId+1";
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