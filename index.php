<?php 
    session_start(); //ประกาศ การใช้งาน session
//    session_destroy(); // ลบตัวแปร session ทั้งหมด
    if( !isset($_SESSION['adminID'] ) ){
        header('Location: login.php');
    } else {
        // header('Location: adminPages/indexedDB/syncDataAPI.php');
        header('Location: adminPages/indexedDB/syncDataAPI.php');
        // if( $_SESSION['permission'] == "admin") {
        //     header('Location: adminPages/options/');
        // } else if( $_SESSION['permission'] == "superadmin") {
        //     header('Location: adminPages/');
        // } else if( $_SESSION['permission'] == "POS") {
        //     header('Location: posPages/');
        // } else {
        //     header('Location: adminPages/');
        // }
    }
//    header('Location: ../login.php');
?>
