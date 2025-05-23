<?php
/**
 * Login Api
 */
session_start();
header('Content-Type: application/json');
/**
 * Condition Login
 */
$response = [
    'status' => true,
    'data' => [
        'data1' => 'data1', 
        'data2' => 'data2'
    ],
    'message' => 'Login Success'
];
$_SESSION['admin_id'] = '1';
$_SESSION['admin_name'] = 'AppzStory';
http_response_code(200);
echo json_encode($response, 200);

?>