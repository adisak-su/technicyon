<?php
require_once("../../../service/connect.php");

$dirImages = '../images/';

try {
    $DB = new Database();
    $conn = $DB->connect();

    if (isset($_POST['id'])) {
        $adminID = $_POST['id'];
        $params = array(
            'adminID' => $adminID
        );

        $sql = "SELECT image FROM $tb_admins WHERE adminID=:adminID";
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $imageOld = "";
        if(count($result)>0) {
            $imageOld = $result[0]['image'];
        }

        $sql = "DELETE FROM $tb_admins WHERE adminID=:adminID";
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $response = [
			'status' => true,
			'message' => "Delete Success"
		];

        $file_delete = $dirImages . $imageOld;

        if (file_exists($file_delete)) {unlink($file_delete);}
    } else {
		$response = [
			'status' => true,
			'message' => "ข้อมูลไม่ครบ!!! "
		];
	}
	http_response_code(200);
} catch (PDOException $ex) {
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => json_encode($ex->getMessage())
	];
} catch (Exception $ex) {
	http_response_code(500);
	$response = [
		'status' => false,
		'message' => json_encode($ex->getMessage())
	];
}

header('Content-Type: application/json');
echo json_encode($response, 200);


?>