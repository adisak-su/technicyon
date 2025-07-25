<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json; charset=utf-8');

http_response_code(200);
$DB = new Database();
$conn = $DB->connect();
try {
    if (isset($_GET['action']) && $_GET['action'] === 'get_tables') {
        $tables = [];
        $sql = "SHOW TABLES";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        // if (count($result) > 0) {
        //     foreach($result as $row) {
        //         $tables[] = $row[0];
        //     }
        // }

        $response = [
            'status' => true,
            'tables' => $result//$tables
        ];
    } else {
        $response = [
            'status' => false,
            'message' => "Invalid Method !!!"
        ];
    }
} catch (PDOException $ex) {
    $conn->rollBack();
    http_response_code(500);
    $message = $ex->getMessage();
    $response = [
        'status' => false,
        'message' => $message
    ];
} catch (Exception $ex) {
    $conn->rollBack();
    http_response_code(500);
    $response = [
        'status' => false,
        'message' => $ex->getMessage()
    ];
}

echo json_encode($response);