<?php
    session_start();
    if( !isset($_SESSION['adminID'] ) ){
        header('Location: login.php');
    }
    if( $_SESSION['permission'] === "admin" || $_SESSION['permission'] === "superadmin" ) {
        header('Location: ../admin/pages/dashboard/');
    }
    if( $_SESSION['permission'] === "POS" ) {
        header('Location: ../pos/');
    }
?>