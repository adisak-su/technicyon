<?php
/*
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
*/

/**
 * Login Api
 */
header('Content-Type: application/json; charset=utf-8');
require_once("configJWT.php");
// define('HTTP_COOKIE_NAME', 'technicyon_auth_token');

require_once("connect.php");
//ประกาศ การใช้งาน session
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

/**
 * Condition Login
 */
try {
	$DB = new Database();
	$conn = $DB->connect();
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// ตรวจสอบข้อมูลล็อกอิน
		if (!isset($_POST['username']) || empty($_POST['username']) || !isset($_POST['password']) || empty($_POST['password'])) {
			http_response_code(400);
			echo json_encode(['message' => 'Username and password are required']);
			exit;
		}
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		$typeDatabase = $_REQUEST['typeDatabase'];

		$params = array(
			'username' => $username,
			'password' => $password
		);

		$sql = "SELECT * FROM $tb_admins WHERE username = :username AND password = :password";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);
		// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result) {
			$item = $result;
			$lastSync = date("Y-m-d H:i:s");
			$response = [
				'status' => true,
				'message' => "Login Success"
			];
			$params = array(
				'username' => $username,
				'password' => $password,
				'datetime' => $lastSync,
			);
			$_SESSION['adminID'] = $item['adminID'];
			$_SESSION['adminName'] = $item['firstName'];
			$_SESSION['permission'] = $item['permission'];
			$_SESSION['image'] = $item['image'];
			$_SESSION['lastSync'] = $lastSync;
			$_SESSION['expires'] = time() + JWT_EXPIRE;

			if($typeDatabase == 1) {
				$_SESSION['typeDatabase'] = "adminPagesServer";
			}
			else {
				$_SESSION['typeDatabase'] = "adminPages";
			}
			
			$sql = "UPDATE $tb_admins SET updated_at=:datetime WHERE username = :username AND password = :password";
			$stmt = $conn->prepare($sql);
			$stmt->execute($params);

			// สร้าง JWT Token
			$token = generateJWT([
				'adminID' => $item['adminID'],
				'adminName' => $item['firstName'],
				'permission' => $item['permission'],
				'image' => $item['image'],
				'typeDatabase' => $_SESSION['typeDatabase'],
				'lastSync' => $_SESSION['lastSync'],
				'expires' => $_SESSION['expires'],
			]);

			// ตั้งค่า HTTP-only Cookie for localhost
			setcookie(HTTP_COOKIE_NAME, $token, [
				'expires' => time() + JWT_EXPIRE,
				'path' => '/',
				'secure' => false,
				'httponly' => true,
				'samesite' => 'Lax'
			]);
			

			// // ตั้งค่า HTTP-only Cookie For Domain
			// setcookie(
			// 	HTTP_COOKIE_NAME,
			// 	$token,
			// 	[
			// 		"expires" => time() + JWT_EXPIRE, // 1 วัน
			// 		"path" => "/",
			// 		"domain" => DOMAIN, // หรือเว้นว่างไว้สำหรับ localhost
			// 		"secure" => true,            // ใช้ HTTPS เท่านั้น
			// 		"httponly" => true,          // ป้องกัน JavaScript อ่านค่า
			// 		"samesite" => "Strict"       // ป้องกัน CSRF
			// 	]
			// );

		} else {
			$response = [
				'status' => false,
				'message' => "ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง !!!"

			];
		}
		http_response_code(200);
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
