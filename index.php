<?php
//ประกาศ การใช้งาน session
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
// if (!isset($_SESSION['adminID'])) {
//     header('Location: login.php');
// } else {
//     header('Location: adminPages/indexedDB/syncDataAPI.php');
// }

require_once 'service/configJWT.php';
 
$payload = authenticate("login.php");

if(!isset($payload['adminID'])) {
    header('Location: login.php');
} else {
    // header('Location: adminPages/indexedDB/syncDataAPI.php');
    if($payload['typeDatabase'] == "adminPages") {
        header('Location: ' . $payload['typeDatabase'] . '/indexedDB/syncDataAPI.php');
    }
    else {
        header('Location: ' . $payload['typeDatabase'] . '/settings');
    }
}
