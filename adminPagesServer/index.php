<?php
// header('Location: orders');
require_once('../service/configJWT.php');

$payload = authenticate("../login.php");

if (!isset($payload['adminID'])) {
    header('Location: ../login.php');
} else {
    // header('Location: adminPages/indexedDB/syncDataAPI.php');
    header('Location: settings');
}
