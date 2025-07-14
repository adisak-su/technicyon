<?php
date_default_timezone_set('Asia/Bangkok');

// includes/config.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ตั้งค่า JWT
define('JWT_SECRET', 'your-secret-key-here');
define('JWT_EXPIRE', 3600 * 24); // 1 ชั่วโมง
// define('JWT_EXPIRE', 60*1); // 1 นาที

define('HTTP_COOKIE_NAME', 'technicyon_auth_token');

define('DOMAIN', 'technicyon.pp2831.com');

// ฟังก์ชันสร้าง JWT
function generateJWT($payload)
{
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $payload['exp'] = time() + JWT_EXPIRE;
    $payload = json_encode($payload);

    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET, true);
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
}

// ฟังก์ชันตรวจสอบ JWT
function verifyJWT($token)
{
    try {
        $parts = explode('.', $token);
        if (count($parts) !== 3) return false;

        $signature = hash_hmac('sha256', $parts[0] . "." . $parts[1], JWT_SECRET, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        if ($base64UrlSignature !== $parts[2]) return false;

        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1])), true);

        if (isset($payload['exp']) && $payload['exp'] < time()) return false;

        return $payload;
    } catch (Exception $e) {
        return false;
    }
}

// ฟังก์ชันตรวจสอบ JWT
function authenticate($location)
{
    if (!isset($_COOKIE[HTTP_COOKIE_NAME])) {
        header("Location: $location");
        exit;
    }

    $payload = verifyJWT($_COOKIE[HTTP_COOKIE_NAME]);
    if (!$payload) {
        setcookie(HTTP_COOKIE_NAME, '', time() - 3600, '/');
        header("Location: $location");
        exit;
    }
    
    $_SESSION['adminID'] = $payload['adminID'];
    $_SESSION['adminName'] = $payload['adminName'];
    $_SESSION['permission'] = $payload['permission'];
    $_SESSION['image'] = $payload['image'];
    $_SESSION['lastSync'] = $payload['lastSync'];
    $_SESSION['expires'] = $payload['expires'];
    

    return $payload;
}

function authenticateAPI()
{
    header('Content-Type: application/json; charset=utf-8');
    if (!isset($_COOKIE[HTTP_COOKIE_NAME])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }

    $payload = verifyJWT($_COOKIE[HTTP_COOKIE_NAME]);
    if (!$payload) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }

}
