<?php 
/**
 * Visitors Api
 */
header('Content-Type: application/json');
$response = [
    'status' => true,
    'data' => [
        'labels' => ['18th', '19th', '20th', '21th', '22th', '23th', '24th','25th', '26th', '27th'], 
        'data' => [125, 147,136, 142, 118, 180, 140, 176, 190, 220]
    ],
    'message' => 'OK'
];
http_response_code(200);
echo json_encode($response, 200);

?>