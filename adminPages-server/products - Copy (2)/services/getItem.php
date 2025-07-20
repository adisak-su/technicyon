<?php
// check login token in page php
require_once('../../../service/configJWT.php');
authenticateAPI();
// if (!authenticateAPI()) {
//     http_response_code(401);
//     echo json_encode(['success' => false, 'message' => 'Unauthorized']);
//     exit;
// }
header('Content-Type: application/json; charset=utf-8');
require_once("../../../service/connect.php");
http_response_code(200);

try {
	$DB = new Database();
	$conn = $DB->connect();
		$sql = "SELECT * FROM groupname";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$response = [
			'status' => true,
			'message' => $result
		];
} catch (PDOException $ex) {
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => $ex->getMessage()
	];
} catch (Exception $ex) {
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => $ex->getMessage()
	];
}

echo json_encode($response);
