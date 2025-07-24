<?php
// require_once("../../assets/php/common.php");

require_once '../../service/configJWT.php';
 
$payload = authenticate("../../login.php");

//ประกาศ การใช้งาน session
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
// if (!isset($_SESSION['adminID'])) {
//     header('Location: ../../login.php');
// }
