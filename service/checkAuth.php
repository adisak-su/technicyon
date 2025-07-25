<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'configJWT.php';

//ประกาศ การใช้งาน session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    if (!isset($_COOKIE[HTTP_COOKIE_NAME])) {
        echo json_encode(['success' => false]);
        exit;
    }

    $payload = verifyJWT($_COOKIE[HTTP_COOKIE_NAME]);
    if (!$payload) {
        setcookie(HTTP_COOKIE_NAME, '', time() - 3600, '/');
        echo json_encode(['success' => false]);
        exit;
    }

    $_SESSION['adminID'] = $payload['adminID'];
    $_SESSION['adminName'] = $payload['adminName'];
    $_SESSION['permission'] = $payload['permission'];
    $_SESSION['image'] = $payload['image'];
    $_SESSION['typeDatabase'] = $payload['typeDatabase'];
    $_SESSION['lastSync'] = $payload['lastSync'];
    $_SESSION['expires'] = $payload['expires'];
    if ($payload['typeDatabase'] == "adminPages") {
        echo json_encode(['success' => true, 'redirect' => 'adminPages/indexedDB/syncDataAPI.php']);
    } else {
        echo json_encode(['success' => true, 'redirect' => 'adminPagesServer/settings/index.php']);
    }
    exit;
} catch (Exception $ex) {
    http_response_code(500);
    $mess = $ex->getMessage();
    $response = [
        'status' => false,
        'message' => "มีข้อผิดพลาดเกินขึ้น โปรดติดต่อผู้ดูแลระบบ : Login Exception $mess"
    ];
}
