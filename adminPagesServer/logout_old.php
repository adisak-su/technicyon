<?php
//ประกาศ การใช้งาน session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy(); // ลบตัวแปร session ทั้งหมด
define('HTTP_COOKIE_NAME', 'technicyon_auth_token');

setcookie(HTTP_COOKIE_NAME, '', time() - 3600, '/');
header('Location: login.php');
exit;
