<?php 
    require_once("../../assets/php/common.php");
    session_start();
    if( !isset($_SESSION['adminID'] ) ){
        header('Location: ../../login.php');  
    }
?>