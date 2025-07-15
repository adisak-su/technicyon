<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);
$DB = new Database();
$conn = $DB->connect();
$conn->beginTransaction();
try {
	if (isset($_POST["itemId"]) && !empty($_POST["itemId"]) && isset($_POST["itemName"]) && !empty($_POST["itemName"])) {
		$itemId_org = $_POST["itemId_org"];
		$itemId = $_POST["itemId"];
		$itemName = $_POST["itemName"];
		$itemGroupName = $_POST["itemGroupName"];
		$itemTypeName = $_POST["itemTypeName"];
		$itemSupplierName = $_POST["itemSupplierName"];
		$itemStoreMax = $_POST["itemStoreMax"];
		$itemStoreMin = $_POST["itemStoreMin"];
		$itemStoreFront = $_POST["itemStoreFront"];
		$itemStoreBack = $_POST["itemStoreBack"];
		$itemPriceInv = $_POST["itemPriceInv"];
		$itemPriceFront = $_POST["itemPriceFront"];
		$itemPriceBack = $_POST["itemPriceBack"];
		$itemPriceShop = $_POST["itemPriceShop"];
		$itemLocation = $_POST["itemLocation"];
		$itemUpdatedAt = $_POST["itemUpdatedAt"];
		$params = [
			// "itemId_org" => $itemId_org,
			"itemId" => $itemId,
			"itemName" => $itemName,
			"itemGroupName" => $itemGroupName,
			"itemTypeName" => $itemTypeName,
			"itemSupplierName" => $itemSupplierName,
			"itemStoreMax" => $itemStoreMax,
			"itemStoreMin" => $itemStoreMin,
			"itemStoreFront" => $itemStoreFront,
			"itemStoreBack" => $itemStoreBack,
			"itemPriceInv" => $itemPriceInv,
			"itemPriceFront" => $itemPriceFront,
			"itemPriceBack" => $itemPriceBack,
			"itemPriceShop" => $itemPriceShop,
			"itemLocation" => $itemLocation,
			"itemUpdatedAt" => $itemUpdatedAt,
		];

		$sql = "INSERT INTO product (productId,name,groupname,typename,suppliername,storeMax,storeMin,storeFront,StoreBack,priceInv,priceFront,priceBack,priceShop,location,updatedAt) 
		VALUE(:itemId,:itemName,:itemGroupName,:itemTypeName,:itemSupplierName,:itemStoreMax,:itemStoreMin,:itemStoreFront,:itemStoreBack,:itemPriceInv,:itemPriceFront,:itemPriceBack,:itemPriceShop,:itemLocation,:itemUpdatedAt)";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);

		$DB->updateDataChange("products", $itemId, "CREATE", "productId");
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
	if ($ex->getCode() == 23000) {
		$message = "รหัส/ชื่อสินค้าซ้ำกับที่มีอยู่แล้ว !!!";
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
