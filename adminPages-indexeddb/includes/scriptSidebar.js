// $(document).ready(function () {
//     //alert(navigator.userAgent);
//     //alert(navigator.platform);
//     var isMobile = /iPhone|iPad|MacIntel|Android/i.test(navigator.platform);
//     if (isMobile) {
//         // $('#hrefProductsSort').attr("href","../productsSort/indexMobile.php");
//         $('#hrefProductsSort').attr("href", "../productsSort/index.php");
//     } else {
//         $('#hrefProductsSort').prop("href", "../productsSort/index.php");
//     }
// });
/*
<a class="nav-link" id="timeExpires"><?php
        echo "เข้าสู่ระบบครั้งล่าสุด :  ";
        echo getLocalDateTime($_SESSION['lastSync'],true);
        echo " เหลือเวลาอีก :  ";
        date_default_timezone_set("UTC");
        echo date("H:i:s",$_SESSION['expires'] - time());
        date_default_timezone_set('Asia/Bangkok');
        ?></a>
        
        setInterval(function () {
   element.innerHTML += "Hello";
   $("#timeExpires").innerHTML
}, 1000);


setInterval(function () {
   element.innerHTML += "Hello";
   $("#timeExpires").innerHTML
}, 1000);

let expiresTime = "" + "<?php echo time(); ?>";
alert(expiresTime);
$("#timeExpires").text(expiresTime)
alert($("#timeExpires").text());

*/
// let expiresTime = "" + <?php echo ("".$_SESSION['expires']); ?>;
//"<?php echo $someVar; ?>";

// Close sidebar when clicking on content (except when clicking on sidebar)
// window.addEventListener("DOMContentLoaded", function () {
//     $(".content").click(function (e) {
//         if ($("#sidebar").hasClass("active")) {
//             $("#sidebar").removeClass("active");
//             $("#content").removeClass("active");
//         }
//     });
// });


