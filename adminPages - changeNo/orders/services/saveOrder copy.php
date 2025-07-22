<?php
require_once("../../../service/connect.php");
require_once("../../../assets/php/common.php");
session_start();

// $adminID = $_SESSION["adminID"];
try {
	// date_default_timezone_set("Asia/Bangkok");
	$startYear = date("Y");

	$DB = new Database();
	$conn = $DB->connect();
	$conn->beginTransaction();

	if (!empty($_POST['customerID']) && !empty($_POST['customerName']) && !empty($_POST['arrProductSale']) && isset($_POST['typeSale'])) {
		$customerID = $_POST['customerID'];
		$customerName = $_POST['customerName'];
		$total = $_POST['total'];
		$vat = $_POST['vat'];
		$arrProductSale = $_POST['arrProductSale'];
		$arrProductSale = json_decode($arrProductSale);

		$coutOrder = getCountOrder($conn, $vat);
		$coutOrder = substr("00000000" . $coutOrder, -8);
		$startYear = substr($startYear, -2);
		if ($vat) {
			$orderNo = "ORV-$startYear-$coutOrder";
		} else {
			$orderNo = "OR-$startYear-$coutOrder";
		}

		// $orderDateTime = new DateTime();
		// $orderDateTime->setTimezone(new DateTimeZone('Asia/Bangkok'));

		$orderDateTime = date("Y-m-d H:i:s");
		$params = array(
			'orderNo' => $orderNo,
			'customerID' => $customerID,
			'customerName' => $customerName,
			'amount' => $amount,
			'vat' => $vat,
			'total' => $total,
			"thai" => Convert($total),
			"orderDateTime" => $orderDateTime,
			"adminID" => $adminID
		);

		$sql = "INSERT INTO ordersale (orderNo,orderDateTime,customerID,customerName,amount,vat,total,thai,adminID) VALUES(:orderNo,:orderDateTime,:customerID,:customerName,:amount,:vat,:total,:thai,:adminID)";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);

		insertOrderDeatil($conn, $orderNo, $arrProductSale);

		$response = [
			'status' => true,
			'message' => "count " . $orderNo
		];
	} else {
		$response = [
			'status' => false,
			'message' => "ข้อมูลไม่ครบ!!! "
		];
	}
	http_response_code(200);
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

header('Content-Type: application/json');
echo json_encode($response);

function insertOrderDeatil($conn, $orderNo, $arrProduct)
{
	try {
		for ($index = 0; $index < count($arrProduct); $index++) {
			$product = $arrProduct[$index];
			$params = array(
				'orderNo' => $orderNo,
				'productSaleID' => $product->productID,
				'productName' => $product->name,
				'price' => $product->price,
				'qty' => $product->qty,
				'total' => $product->price * $product->qty,
			);

			$sql = "INSERT INTO detailsale (orderNo,productSaleID,productName,price,qty,total) VALUES(:orderNo,:productSaleID,:productName,:price,:qty,:total)";
			$stmt = $conn->prepare($sql);
			$stmt->execute($params);
		}
	} catch (Exception $ex) {
		throw new Exception($ex);
	}
}

function getCountOrder($conn, $vat)
{
	date_default_timezone_set("Asia/Bangkok");
	$startYear = date("Y");

	$sql = "UPDATE configorder SET countNo = 0,resetYear = $startYear WHERE resetYear != $startYear";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	$sql = "SELECT * FROM configorder WHERE vat=$vat";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$sql = "UPDATE configorder SET countNo=countNo+1 WHERE vat=$vat";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	if (count($result)) {
		return $result[0]['countNo'];
	} else {
		return 1;
	}
}
