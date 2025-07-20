<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ERROR);

//error_reporting(E_ALL);
//error_reporting(-1);
//ini_set('error_reporting', E_ALL);


require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);
// session_start();

$DB = new Database();
$conn = $DB->connect();
$conn->beginTransaction();
try {

	// date_default_timezone_set("Asia/Bangkok");
	$response = [
		'status' => true,
		'message' => "Before POST "
	];
	$startYear = date("Y");
	if ('POST' === $_SERVER['REQUEST_METHOD']) {
		
		
		$data = 1;
		if ($data) {
			$editMode = 1; //$data->editMode;
			if ($editMode) {
				$orderId = "F202500004"; // $data->orderId;
				
				$params = array(
					'orderId' => $orderId,
					'total' => 1000,
					'vatvalue'=> 200
				);
				
				$sql = "UPDATE order_head set total=:total WHERE orderId=:orderId";
				$stmt = $conn->prepare($sql);
			      $stmt->execute($params);
			} 

			$response = [
				'status' => true,
				'message' => "Update ok "
			];
			
		} else {
			http_response_code(400);
			$response = [
				'status' => false,
				'message' => "Error in data"
			];
		}
	}
	$conn->commit();
} catch (PDOException $ex) {
	$conn->rollBack();
	// print_r($ex);
	http_response_code(500);
	//throw new Exception($ex);
	//die("PDO failed: " . $ex->getMessage());
	
	$response = [
		'status' => false,
		'message' => json_encode($ex->getMessage())
	];
} catch (Exception $ex) {
	$conn->rollBack();
	// print_r($ex);
	http_response_code(500);
	//throw new Exception($ex);
	//die("Exception failed: " . $ex->getMessage());
	$response = [
		'status' => false,
		'message' => json_encode($ex->getMessage())
		//json_encode(['error' => $e->getMessage()]);
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
