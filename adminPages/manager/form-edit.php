<?php
    require_once('../authen.php');
    require_once('../../service/connect.php'); 

    header('Cache-Control: no-cache, must-revalidate, max-age=0');

    $DB = new Database();
    $conn = $DB->connect();
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "SELECT * FROM $tb_admins WHERE adminID=$id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($result)>0) {
            $data = $result[0];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>จัดการผู้ดูแลระบบ | <?php echo $shopName; ?></title>
    <!-- Favicons -->
    <?php include_once('../../includes/pagesFavicons.php'); ?>
    <!-- stylesheet -->
    <?php include_once('../../includes/pagesStylesheet.php'); ?>

</head>

<body class="hold-transition sidebar-mini dark-mode">
    <div class="wrapper">
        <?php include_once('../../includes/loading.php') ?>
        <?php include_once('../includes/sidebar.php') ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <label class="m-0 text-dark">จัดการผู้ดูแลระบบ</label>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">ผู้ดูแลระบบ</a></li>
                                <li class="breadcrumb-item active">แก้ไขข้อมูล</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <label class="mr-auto" style="line-height: 2.1rem;">แก้ไขผู้ดูแล</label>
                                    <a href="index.php" class="btn btn-warning float-right">กลับ</a>
                                </div>
                                <form id="formData" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <input type="hidden" class="form-control" name="adminID" id="adminID" value="<?php echo $data['adminID']; ?>" required>
                                            <div class="form-group col-sm-6">
                                                <label for="firstName">ชื่อจริง</label>
                                                <input type="text" class="form-control" name="firstName" id="firstName" value="<?php echo $data['firstName']; ?>" placeholder="ชื่อจริง" required>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="lastName">นามสกุล</label>
                                                <input type="text" class="form-control" name="lastName" id="lastName" value="<?php echo $data['lastName']; ?>" placeholder="นามสกุล" required>
                                            </div>
                                            <!-- <div class="form-group col-sm-6">
                                                <label for="username">ชื่อผู้ใช้งาน</label>
                                                <input type="text" class="form-control" name="username" id="username" value="<?php echo $data['username']; ?>" placeholder="ชื่อผู้ใช้งาน" required>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="password">รหัสผ่าน</label>
                                                <input type="password" class="form-control" name="password" id="password" value="<?php echo $data['password']; ?>" placeholder="รหัสผ่าน" required>
                                            </div> -->
                                            
                                            <div class="form-group col-sm-6">
                                                <label for="permission">สิทธิ์การใช้งาน</label>
                                                <select class="form-control" name="permission" id="permission" required>
                                                    <option value disabled selected>กำหนดสิทธิ์</option>
                                                    <option value="superadmin">Super Admin</option>
                                                    <option value="admin">Admin</option>
                                                </select>
                                                <input type="hidden" class="form-control" name="itemType" id="itemType" value="<?php echo $data['permission']; ?>" required>
                                            </div>

                                            <!-- <div class="form-group col-sm-6">
                                                <label for="imageFile">รูปโปรไฟล์</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="imageFile" id="imageFile" style=" z-index: 1;">
                                                    <label class="custom-file-label" for="imageFile" style=" z-index: 1;">เลือกรูปภาพ</label>
                                                </div>
                                            </div> -->

                                            <div class="form-group col-sm-6">
                                                <label for="imageFile" id="lbImage">รูปโปรไฟล์</label>
                                                <!-- <input type="file" name="imageFile" id="imageFile" accept="image/*" style="width:0px;height:0px;" onchange="loadFile(event)"> -->
                                                <input type="file" name="imageFile" id="imageFile" accept="image/*" style="width:0px;height:0px;">
                                                <div class="preview" style="display: flex; justify-content: space-around">
                                                    <img src="images/<?php echo $data['image']; ?>" id="imgPreview" width="100" height="100" onclick="imageClick();">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <button type="submit" class="btn btn-primary" name="submit">บันทึกข้อมูล</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('../includes/footer.php') ?>
    </div>
    <!-- SCRIPTS -->
    <?php include_once('../../includes/pagesScript.php') ?>
    <?php include_once('../../includes/myScript.php') ?>
    <script src="../../assets/js/imageCropResize.js?<?php echo time(); ?>"></script>

    <script>

        function imageClick() {
            $("#imageFile").click()
        }

        $('#imageFile').imageUploadResizer({
            max_width: 1000, // Defaults 1000
            max_height: 1000, // Defaults 1000
            quality: 1, // Defaults 1
            do_not_resize: ['gif', 'svg'], // Defaults []
            preview: "imgPreview",
        });

        // var loadFile = function(event) {
        //     var reader = new FileReader();
        //     reader.onload = function() {
        //         // $('.preview img').attr("src", reader.result);
        //         $('#imgPreview').attr("src", reader.result);
        //     };
        //     reader.readAsDataURL(event.target.files[0]);
        // };

        $(document).ready(function() {
            loaderScreen("hide");
            permission.value = $('#itemType').val();
            $('#formData').on('submit', function(e) {
                e.preventDefault();
                var frm = new FormData(this);
                frm.delete('imageFile');
                frm.append('imgPreview', $('#imgPreview').attr("src"));
                loaderScreen("show");
                $.ajax({
                    type: 'POST',
                    url: 'service/update.php',
                    // data: new FormData(this),
                    data: frm,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST'
                }).done(function(resp) {
                    loaderScreen("hide");
                    if (resp.status) {
                        Swal.fire({
                            text: 'แก้ไขข้อมูลเรียบร้อย',
                            icon: 'success',
                            timer: 1500,
                            confirmButtonText: 'ตกลง',
                        }).then((result) => {
                            location.assign('index.php');
                        });
                    } else {
                        Swal.fire({
                            text: 'เกิดข้อผิดพลาด : ' + resp.message,
                            icon: 'error',
                            confirmButtonText: 'ตกลง',
                        });
                    }
                })
            });
        });
    </script>

</body>

</html>