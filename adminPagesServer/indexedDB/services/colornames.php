<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);
$DB = new Database();
$conn = $DB->connect();
try {

    $sql = "SELECT * FROM colorname ORDER BY colorname";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result) {
        $response = [
            'status' => true,
            'message' => $result
        ];
    } else {
        $response = [
            'status' => false,
        ];
    }
} catch (PDOException $ex) {
    http_response_code(500);
    $response = [
        'status' => false,
        'message' => json_encode($ex)
    ];
} catch (Exception $ex) {
    http_response_code(500);
    $response = [
        'status' => false,
        'message' => json_encode($ex)
    ];
}

echo json_encode($response);
