<?php

/**
 * Service Api
 */
//session_start();
require_once("../../../service/connect.php");
$dirImages = '../images/';
try {
	$DB = new Database();
	$conn = $DB->connect();
	if (!empty($_POST['username']) && !empty($_POST['password'])) {
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$permission = $_POST['permission'];
		$dataImage = $_POST['imgPreview'];
		$status = 1;

		$params = array(
			'firstName' => $firstName,
			'lastName' => $lastName,
			'username' => $username,
			'password' => $password,
			'permission' => $permission,
			'status' => $status
		);

		$sql = "INSERT INTO $tb_admins (firstName,lastName,username,password,permission,image,status) VALUES(:firstName,:lastName,:username,:password,:permission,'avatar.png',:status)";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);

		$insert_id = $conn->lastInsertId();
		$fileSave = $insert_id . ".jpg";

		$sql = "UPDATE $tb_admins SET image='$fileSave' WHERE adminID=$insert_id";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		
		$fileSave = $dirImages . $insert_id . ".jpg";
		$response = [
			'status' => true,
			'message' => "Create Success "
		];

		if ($dataImage != "images/avatar.png") {
			$dataImageFile = explode(',', $dataImage);
			$output_file = '../images/image.jpg';
			$ifp = fopen($fileSave, 'wb');
			fwrite($ifp, base64_decode($dataImageFile[1]));
			fclose($ifp);
		}
		else {
			copy('../images/avatar.png',$fileSave);
		}
		if (isset($_FILES['imageFile']['name']) && !empty($_FILES['imageFile']['name'])) {
			$response = [
				'status' => false,
				'message' => "Create Success With File"
			];
		}
		else{
			$response = [
				'status' => true,
				'message' => "Create Success With No File"
			];
		}
		/*

		if (isset($_FILES['imageFile']['name']) && !empty($_FILES['imageFile']['name'])) {
			$response = [
				'status' => true,
				'message' => "File name : " . $_FILES['imageFile']['name']
			];

			$fileSave = $insert_id . ".jpg";
			$filename = $_FILES['imageFile']['name'];

			$imageFileType = pathinfo($filename, PATHINFO_EXTENSION);
			$imageFileType = strtolower($imageFileType);

			// Valid extensions
			$valid_extensions = array("jpg", "jpeg", "png");
			$response = 0;
			// Check file extension
			if (in_array(strtolower($imageFileType), $valid_extensions)) {
				
				if (move_uploaded_file($_FILES['imageFile']['tmp_name'], $dirImages . $fileSave)) {
					$response = [
						'status' => true,
						'message' => "Create Success " . $dataImage
						// 'message' => "File name : " . $fileSave
					];
					$sql = "UPDATE $tb_admins SET image='$fileSave' WHERE adminID=$insert_id";
					$stmt = $conn->prepare($sql);
					$stmt->execute();
				} else {
					$response = [
						'status' => false,
						'message' => "Error file save!!!"
					];
				}
			} else {
				$response = [
					'status' => false,
					'message' => "Error file format!!!"
				];
			}
		}
		*/
	}
} catch (PDOException $ex) {
	$response = [
		'status' => false,
		'message' => json_encode($ex)
	];
} catch (Exception $ex) {
	$response = [
		'status' => false,
		'message' => json_encode($ex)
	];
}

header('Content-Type: application/json');
http_response_code(200);
echo json_encode($response, 200);
