<?php
require_once("../../../service/connect.php");
require_once("../../configImage.php");

$dirImages = '../images/';

try {
	$DB = new Database();
	$conn = $DB->connect();
	$conn->beginTransaction();

	if (!empty($_POST['adminID']) && !empty($_POST['firstName']) && !empty($_POST['lastName'])) {

		$adminID = $_POST['adminID'];
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$permission = $_POST['permission'];
		$dataImage = $_POST['imgPreview'];

		$params = array(
			'adminID' => $adminID,
			'firstName' => $firstName,
			'lastName' => $lastName,
			'permission' => $permission
		);

		$sql = "UPDATE $tb_admins SET firstName=:firstName,lastName=:lastName,permission=:permission WHERE adminID=:adminID";
		$stmt = $conn->prepare($sql);
		$stmt->execute($params);

		$response = [
			'status' => true,
			'message' => "UPDATE Success : " . substr($dataImage, 0, 7)
		];

		//		$fileSave = $dirImages . $adminID . "-" . time() . ".jpg";

		// data:image/jpeg;

		if (substr($dataImage, 0, 7) != "images/") {
			$fileSave = $adminID . "-" . time() . ".jpg";

			$params = array(
				'adminID' => $adminID
			);

			$sql = "SELECT image FROM $tb_admins WHERE adminID=:adminID";
			$stmt = $conn->prepare($sql);
			$stmt->execute($params);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$imageOld = "";
			if (count($result) > 0) {
				$imageOld = $result[0]['image'];
			}

			$params = array(
				'adminID' => $adminID,
				'fileSave' => $fileSave
			);

			$sql = "UPDATE $tb_admins SET image=:fileSave WHERE adminID=:adminID";
			$stmt = $conn->prepare($sql);
			$stmt->execute($params);

			$fileSave = $dirImages . $fileSave;

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

			if (file_exists($tmpfilename)) {
				unlink($tmpfilename);
			}
			if($imageOld!="avatar.png") {
				$file_delete = $dirImages . $imageOld;
				if (file_exists($file_delete)) {
					unlink($file_delete);
				}	
			}
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
