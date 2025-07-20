<?php
require_once("../../../service/connect.php");
require_once("../../configImage.php");

$dirImages = '../images/';
$masterFile = '../images/avatar.png';

try {
	$DB = new Database();
	$conn = $DB->connect();
	$conn->beginTransaction();
	
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
		$fileSave = $insert_id . "-" . time() . ".jpg";

		$sql = "UPDATE $tb_admins SET image='$fileSave' WHERE adminID=$insert_id";
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		$fileSave = $dirImages . $fileSave;
		$response = [
			'status' => true,
			'message' => "Create Success "
		];

		if ($dataImage != "images/avatar.png") {
			$dataImageFile = explode(',', $dataImage);

			$tmpfilename = $dirImages . time() . ".jpg";
			$file = fopen($tmpfilename, 'wb');
			fwrite($file, base64_decode($dataImageFile[1]));
			fclose($file);

			$imgsize = getimagesize($tmpfilename);
			$img_width = $imgsize[0];

			if ($img_width < $master_size) {
				copy($tmpfilename, $fileSave);
			} else {
				resize_crop_image($master_size, $master_size, $tmpfilename, $fileSave);
			}

			//unlink($tmpfilename);
			//$file_delete = $dirImages . $imageOld;
			if (file_exists($tmpfilename)) {unlink($tmpfilename);}
		} else {
			copy($masterFile, $fileSave);
		}
		
		$conn->commit();
	} else {
		$response = [
			'status' => true,
			'message' => "ข้อมูลไม่ครบ!!! "
		];
	}
	http_response_code(200);	
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

exit;

function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = -1)
{
	try {
	$imgsize = getimagesize($source_file);
	$width = $imgsize[0];
	$height = $imgsize[1];

	$dst_img = imagecreatetruecolor($max_width, $max_height);

	$src_img = imagecreatefromjpeg($source_file);

	$width_new = $height * $max_width / $max_height;
	$height_new = $width * $max_height / $max_width;

	//if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
	if ($width_new > $width) {
		//cut point by height
		$h_point = (($height - $height_new) / 2);
		//copy image
		imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
	} else {
		//cut point by width
		$w_point = (($width - $width_new) / 2);
		imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
	}

	imagejpeg($dst_img, $dst_dir);

	if ($dst_img) imagedestroy($dst_img);
	if ($src_img) imagedestroy($src_img);
	} catch (Exception $ex) {
		$conn->rollBack();
		$response = [
			'status' => false,
			'message' => json_encode($ex)
		];
		throw $ex;
	}
}
