<?php
/*
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
*/
/**
 * Login Api
 */
require_once("connect.php");
session_start(); //ประกาศ การใช้งาน session

/**
 * Condition Login
 */
try {
	$DB = new Database();
	$conn = $DB->connect();
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];

	$params = array(
		'username' => $username,
		'password' => $password
	);

	$sql = "SELECT * FROM $tb_admins WHERE username = :username AND password = :password";
	$stmt = $conn->prepare($sql);
	$stmt->execute($params);
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if (count($result) > 0) {
		$item = $result[0];
		$response = [
			'status' => true,
			'message' => "Login Success"
		];
		$params = array(
			'username' => $username,
			'password' => $password,
			'datetime' => date("Y-m-d H:i:s"),
		);
		$_SESSION['adminID'] = $item['adminID'];
		$_SESSION['adminName'] = $item['firstName'];
		$_SESSION['permission'] = $item['permission'];
		$_SESSION['image'] = $item['image'];
		$sql = "UPDATE $tb_admins SET updated_at=:datetime WHERE username = :username AND password = :password";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
	} else {
		$response = [
			'status' => false,
			'message' => "Username or password not found !!!"
		];
	}
	http_response_code(200);
}
catch(PDOException $ex){	
	http_response_code(500);	
		$mess = $ex->getMessage();
		$response = [
			'status' => false,
			'message' => "มีข้อผิดพลาดเกินขึ้น โปรดติดต่อผู้ดูแลระบบ : Login PDOException $mess"
		];
}
catch (Exception $ex) {
	http_response_code(500);
	$mess = $ex->getMessage();
	$response = [
		'status' => false,
		'message' => "มีข้อผิดพลาดเกินขึ้น โปรดติดต่อผู้ดูแลระบบ : Login Exception $mess"
	];
}

header('Content-Type: application/json');
echo json_encode($response);

?>