<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);
// session_start();

$DB = new Database();
$conn = $DB->connect();
// $conn->beginTransaction();
try {

	// date_default_timezone_set("Asia/Bangkok");
	$response = [
		'status' => true,
		'message' => "Before POST "
	];
	$startYear = date("Y");
	if ('POST' === $_SERVER['REQUEST_METHOD']) {
		$content = json_decode(file_get_contents("php://input"));
		$data = $content->data;

		/*
				orderId: orderId,
                orderDate: $("#orderDate").val(),
                customerId: $("#customerInput").val(),
                customerName: $("#customerName").val(),
                customerAddress: $("#customerAddress").val(),
                customerTelephone: $("#customerTelephone").val(),
                status: 0,
                vat: vat,
                typeSale: typeSale,
                vatValue: vatValue,
                partsTotal: partsTotal,
                total: total,
                orderItems: orderItems,
*/


		// $params = array(
		// 	'orderId' => $data->orderId,
		// 	'mydate' => $orderDateTime,
		// 	'customerId' => $data->customerId,
		// 	'status' => $data->status,
		// 	'vat' => $data->vat,
		// 	'typeSale' => $data->typeSale,
		// 	'total' => $data->partsTotal,
		// 	'nettotal' => $nettotal,
		// 	'thaiBahtText' => $data->thaiBahtText,
		// 	'vatvalue' => $vatvalue,
		// 	'discount' => 0,
		// );

		// $orderItems = $data->orderItems;
		// $mydate = $orderDateTime;
		// $customerId = $data->customerId;
		// $status = $data->status;
		// $typeSale = $data->typeSale;
		// $total = $data->partsTotal;
		// $nettotal = $nettotal;
		// $mystring = $data->thaiBahtText;
		// $vatvalue = $vatvalue;
		// $discount = 0;

		if ($data) {
			$editMode = 1;//$data->editMode;
			if ($editMode) {
				$orderId = "F202500043"; // $data->orderId;
				$orderDateTime = $data->orderDate;
				// $orderDateTime = '2025-06-22 12:00:00';
				$sql = "UPDATE order_head set mydate=:mydate,customerId=:customerId,total=:total,vatvalue=:vatvalue,nettotal=:nettotal,discount=:discount,mystring=:mystring,details=:details WHERE orderId=:orderId";
			} else {
				$orderId = getCountOrder($conn);
				$orderId = "F" . date("Y") . substr("0000" . $orderId, -5);

				$orderDateTime = date("Y-m-d H:i:s");
				$sql = "INSERT INTO order_head (orderId,mydate,customerId,total,vatvalue,nettotal,discount,mystring,details) VALUES(:orderId,:mydate,:customerId,:total,:vatvalue,:nettotal,:discount,:mystring,:details)";
			}

			if ($data->vat == 1) {
				$vatvalue = 0.07 * $data->partsTotal;
				$nettotal = $vatvalue + $data->partsTotal;
			} else {
				$vatvalue = 0;
				$nettotal = 0;
			}

			$params = array(
				'orderId' => $orderId,
				'mydate' => $orderDateTime,
				'customerId' => $data->customerId,
				// 'status' => $status,
				// 'typeSale' => $typeSale,
				'total' => $data->partsTotal,
				'nettotal' => $nettotal,
				'vatvalue' => $vatvalue,
				'discount' => 0,
				'mystring' => $data->thaiBahtText,
				'details' => json_encode($data->orderItems)
			);
			// $sql = "INSERT INTO order_head (orderId,mydate,customerId,total,vatvalue,nettotal,discount,mystring,details) VALUES(:orderId,:mydate,:customerId,:total,:vatvalue,:nettotal,:discount,:mystring,:details)";
			// $sql = "INSERT INTO order_head (orderId,mydate,customerId,total,vatvalue,nettotal,discount,mystring,details) VALUES(:orderId,:mydate,:customerId,:total,:vatvalue,:nettotal,:discount,:mystring,:details)";
			$stmt = $conn->prepare($sql);
			$stmt->execute($params);


			if (!$editMode) {
				$orderItems =  $data->orderItems;
				insertOrderDeatil($conn, $orderId, $orderItems);
			}

			$response = [
				'status' => true,
				'message' => "count " . $orderId
			];
			$response = [
				'status' => true,
				'message' => $params
			];
		} else {
			http_response_code(400);
			$response = [
				'status' => false,
				'message' => "Error "
			];
		}
	}
	// $conn->commit();
} catch (PDOException $ex) {
	// $conn->rollBack();
	// print_r($ex);
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => json_encode($ex)
	];
} catch (Exception $ex) {
	// $conn->rollBack();
	// print_r($ex);
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => json_encode($ex)
	];
}

header('Content-Type: application/json');
echo json_encode($response);

function insertOrderDeatil($conn, $orderId, $arrProduct)
{
	try {
		for ($index = 0; $index < count($arrProduct); $index++) {
			$product = $arrProduct[$index];
			$params = array(
				'orderId' => $orderId,
				'productId' => $product->id,
				'name' => $product->name,
				'price' => $product->price,
				'qty' => $product->quantity,
				'total' => $product->total,
			);

			$sql = "INSERT INTO order_detail (orderId,productId,name,price,qty,total) VALUES(:orderId,:productId,:name,:price,:qty,:total)";
			$stmt = $conn->prepare($sql);
			$stmt->execute($params);
		}
	} catch (Exception $ex) {
		throw new Exception($ex);
	}
}

function getCountOrder($conn)
{
	try {
		date_default_timezone_set("Asia/Bangkok");
		$startYear = date("Y");

		$sql = "UPDATE userdata SET orderId_front = 0,resetYear = $startYear WHERE resetYear != $startYear";
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		$sql = "SELECT orderId_front AS countNo FROM userdata";
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$sql = "UPDATE userdata SET orderId_front=orderId_front+1";
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
