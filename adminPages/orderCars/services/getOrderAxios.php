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
$conn->beginTransaction();
try {

	// date_default_timezone_set("Asia/Bangkok");
	$response = [
		'status' => true,
		'message' => "Before POST "
	];
	if ('POST' === $_SERVER['REQUEST_METHOD']) {
		$content = json_decode(file_get_contents("php://input"));
		$orderId = $content->orderId;
		if ($orderId) {
			$params = array(
				'orderId' => $orderId,
			);
			$sql = "SELECT * FROM usercar_head WHERE orderId=:orderId";
			$stmt = $conn->prepare($sql);
			$stmt->execute($params);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($result) {
				$response = [
					'status' => true,
					'message' => $result
				];
			} else {
				$response = [
					'status' => false,
					'message' => "OrderId not found!!!"
				];
			}
		} else {
			http_response_code(400);
			$response = [
				'status' => false,
				'message' => "Error in parameter orderId"
			];
		}
	} else {
		http_response_code(400);
		echo json_encode(['success' => false, 'message' => 'Mothod POST are required']);
		exit;
	}
} catch (PDOException $ex) {
	http_response_code(500);
	$mess = $ex->getMessage();
	$response = [
		'status' => false,
		'message' => "มีข้อผิดพลาดเกินขึ้น โปรดติดต่อผู้ดูแลระบบ : Login PDOException $mess"
	];
} catch (Exception $ex) {
	http_response_code(500);
	$mess = $ex->getMessage();
	$response = [
		'status' => false,
		'message' => "มีข้อผิดพลาดเกินขึ้น โปรดติดต่อผู้ดูแลระบบ : Login Exception $mess"
	];
}

header('Content-Type: application/json');
echo json_encode($response);
