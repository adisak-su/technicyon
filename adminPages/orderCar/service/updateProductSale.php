<?php
require_once("../../../service/connect.php");
require_once("../../../assets/php/common.php");
session_start();
// require_once('../../../tcpdf/tcpdf.php');
// require_once('../../../myTCPDF.php');
// require_once("../../../genOrderPDFNew.php");

// require_once("../../../service/genOrderPDFNew.php");

// require_once("./service/genOrderPDFNew.php");
// require_once("/service/genOrderPDFNew.php");
// require_once("./genOrderPDFNew.php");
$adminID = $_SESSION["adminID"];
try {
	date_default_timezone_set("Asia/Bangkok");
	$startYear = date("Y");

	$DB = new Database();
	$conn = $DB->connect();
	$conn->beginTransaction();

	if (!empty($_POST['orderNo']) && !empty($_POST['customerID']) && !empty($_POST['customerName']) && !empty($_POST['arrProductSale']) && isset($_POST['vat'])) {

		$orderNo = $_POST['orderNo'];
		$customerID = $_POST['customerID'];
		$customerName = $_POST['customerName'];
		$amount = $_POST['amount'];
		$total = $_POST['total'];
		$vat = $_POST['vat'];
		$arrProductSale = $_POST['arrProductSale'];
		$arrProductSale = json_decode($arrProductSale);
		$description = $_POST['description'];

		// $coutOrder = getCountOrder($conn, $vat);
		// $coutOrder = substr("00000000" . $coutOrder, -8);
		// $startYear = substr($startYear, -2);
		// if ($vat) {
		// 	$orderNo = "RV-$startYear-$coutOrder";
		// } else {
		// 	$orderNo = "INV-$startYear-$coutOrder";
		// }

		$params = array(
			'orderNo' => $orderNo,
			"dateTimeChange" => date("Y-m-d H:i:s"),
			"adminID" => $adminID,
			"description" => $description
		);

		// $sql = "INSERT INTO ordersale (orderNo,customerID,customerName,amount,vat,total,thai) VALUES(:orderNo,:customerID,:customerName,:amount,:vat,:total,:thai)";
		// $stmt = $conn->prepare($sql);
		// $stmt->execute($params);
		$sql = "INSERT INTO ordersale_change (orderNo,dateTimeChange,adminID,description) VALUES(:orderNo,:dateTimeChange,:adminID,:description)";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);

		$params = array(
			'orderNo' => $orderNo,
			'amount' => $amount,
			'total' => $total,
			"thai" => Convert($total),
		);

		// $sql = "INSERT INTO ordersale (orderNo,customerID,customerName,amount,vat,total,thai) VALUES(:orderNo,:customerID,:customerName,:amount,:vat,:total,:thai)";
		// $stmt = $conn->prepare($sql);
		// $stmt->execute($params);

		$sql = "UPDATE ordersale SET amount=:amount,total=:total,thai=:thai,statusChange=1 WHERE orderNo=:orderNo";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);

		updateOrderDeatil($conn, $orderNo, $arrProductSale);
		insertCustomerPrice($conn, $customerID, $arrProductSale);

		// $order = $DB->getOrderByOrderID($orderNo);

		// $pdf = new MYTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// $directory = getcwd();
		// $directory = str_replace("/adminPages/orderSale/service", "", $directory);
		// $directory = str_replace("\adminPages\orderSale\service", "", $directory);

		// $pdf = genOrderPDF($orderNo, $order);
		// $filename = "$orderNo.pdf";
		// $filename = str_replace("-", "_", $filename);

		// $pdf->Output("$directory/order_pdf/$filename", 'F');

		$response = [
			'status' => true,
			'message' => "count " . $orderNo
		];
	} else {
		$response = [
			'status' => true,
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
		'message' => json_encode($ex->getMessage())
	];
} catch (Exception $ex) {
	$conn->rollBack();
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => json_encode($ex->getMessage())
	];
}

header('Content-Type: application/json');
echo json_encode($response, 200);

function updatetProductSaleID($conn, $arrProduct)
{
	for ($index = 0; $index < count($arrProduct); $index++) {
		if (property_exists($arrProduct[$index], 'objProductSale')) {
			$product = $arrProduct[$index]->objProductSale;
			$params = array(
				'productID' => $product->product->id,
				'sizeID' => $product->size->id,
				'gramID' => $product->gram->id,
				'colorID' => $product->color->id,
			);
			try {
				$sql = "SELECT product_saleID FROM product_sale WHERE productID=:productID AND sizeID=:sizeID AND gramID=:gramID AND colorID=:colorID";
				$stmt = $conn->prepare($sql);
				$stmt->execute($params);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)) {
					$arrProduct[$index]->productID = $result[0]['product_saleID'];
				}
			} catch (Exception $ex) {
				continue;
			}
		}
	}
}

function insertProductSale($conn, $arrProduct)
{
	for ($index = 0; $index < count($arrProduct); $index++) {
		if (property_exists($arrProduct[$index], 'objProductSale')) {
			$product = $arrProduct[$index]->objProductSale;
			$params = array(
				'productID' => $product->product->id,
				'sizeID' => $product->size->id,
				'gramID' => $product->gram->id,
				'colorID' => $product->color->id,
				'price' => $arrProduct[$index]->price,
				'productName' => $arrProduct[$index]->name,
			);
			try {
				$sql = "INSERT INTO product_sale (productID,sizeID,gramID,colorID,price,productName) VALUES(:productID,:sizeID,:gramID,:colorID,:price,:productName)";
				$stmt = $conn->prepare($sql);
				$stmt->execute($params);
			} catch (Exception $ex) {
				continue;
			}
		}
	}
}

function insertCustomerPrice($conn, $customerID, $arrProduct)
{
	for ($index = 0; $index < count($arrProduct); $index++) {
		$product = $arrProduct[$index];
		$params = array(
			'customerID' => $customerID,
			'productID' => $product->productID,
			'price' => $product->price,
		);
		try {
			$sql = "INSERT INTO customer_price (customerID,product_saleID,price) VALUES(:customerID,:productID,:price)";
			$stmt = $conn->prepare($sql);
			$stmt->execute($params);
		} catch (Exception $ex) {
			$sql = "UPDATE customer_price SET price=:price WHERE customerID=:customerID AND product_saleID=:productID";
			$stmt = $conn->prepare($sql);
			$stmt->execute($params);
			continue;
		}
	}
}

function updateOrderDeatil($conn, $orderNo, $arrProduct)
{
	try {
		$sql = "DELETE FROM detailsale WHERE orderNo='$orderNo'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();

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
