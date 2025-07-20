<?php
    $fileName = $_REQUEST["fileName"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF</title>
    <style>
    </style>
</head>
<body>
    <h1>PDF viewer</h1>
    <div class="viewerPDF bgColor" style="background-color:0">aaa
    </div>
    <div class="viewerPDF bgColor">
    <object data="<?php echo $fileName; ?>" type="application/pdf" width="600px" height="850px"></object>

    </div>
</body>
</html>