<?php
/**
 * Service Api
 */
session_start();
header('Content-Type: application/json');
$response = [
    'status' => true,
    'message' => 'Delete Success'
];
http_response_code(200);
echo json_encode($response, 200);


?>