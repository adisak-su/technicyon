<?php

require_once("../../../service/connect.php");

$dirImages = '../images/';

try {
    $DB = new Database();
    $conn = $DB->connect();

    if (isset($_POST['id']) && isset($_POST['status'])) {
        $adminID = $_POST['id'];
        $status = $_POST['status'];
        $params = array(
            'adminID' => $adminID,
            'status' => $status
        );

        $sql = "UPDATE $tb_admins SET status=:status WHERE adminID=:adminID";
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $response = [
			'status' => true,
			'message' => "Update Success"
		];
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