<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
http_response_code(200);
$DB = new Database();
$conn = $DB->connect();
try {

    $sql = "SELECT supplierId AS countNo FROM userdata";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $itemId = "S" . substr("000000000" . $result["countNo"] + 1, -9);
        $response = [
            'status' => true,
            'couterId' => $itemId
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
