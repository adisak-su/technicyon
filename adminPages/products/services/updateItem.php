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
			"itemId_org" => $itemId_org,
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

		$sql = "UPDATE product SET productId=:itemId, name=:itemName, groupname=:itemGroupName, typename=:itemTypeName, suppliername=:itemSupplierName, storeMax=:itemStoreMax, storeMin=:itemStoreMin, storeFront=:itemStoreFront, storeBack=:itemStoreBack, priceInv=:itemPriceInv, priceFront=:itemPriceFront, priceBack=:itemPriceBack, priceShop=:itemPriceShop, location=:itemLocation, updatedAt=:itemUpdatedAt WHERE productId=:itemId_org";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		$rowEffect = $stmt->rowCount();

		// $DB->updateDataChange("products",$itemId,"UPDATE","productId");
		// $DB->updateDataChange("products",$itemId_org,"UPDATE","productId",$itemId);
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
	if($ex->getCode() == 23000) {
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
