<?php
    session_start(); 
    require_once ('./disable_error_report.php');
    require_once ('./classes/Student.php');
    require_once ('./classes/Encode.php');
    require_once ('./classes/Status.php');

    $statusClass = new Status();
    $statusMain = $statusClass->Find('status_switch', 'status_name', 'system_main');
    $statusMain = $statusMain->fetch(PDO::FETCH_ASSOC);
    if (intval($statusMain['status_switch']) === 1) { header('Location: ./maintenance.php'); }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>หอพักนักศึกษา มจพ. ปราจีนบุรี</title>
        <link rel="stylesheet" href="./assets/css/main.css">
        <link rel="icon" href="./assets/img/logoKmutnb.webp">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
<body>

    <?php
        $stdClass = new Student();
        $endcodeClass = new Encode();

        if (isset($_SESSION['std_id'])) {
            echo "<script>  
                Swal.fire({
                    title: 'คุณเข้าสู่ระบบอยู่แล้ว',
                    text: 'ระบบกำลังนำท่านกลับไปยังหน้าหลัก...',
                    icon: 'warning',
                    showConfirmButton: false,
                    showCancelButton: false,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    footer: '<a href=".'logout.php'.">ต้องการออกจากระบบเดี๋ยวนี้ คลิ๊ก!!</a>'
                }).then(setTimeout(() => {
                    window.location.href='index.php'
                }, 4000));
            </script>";
        }

        if (isset($_POST['btn_login'])) {
            $std_username = $_POST['txt_username'];
            $std_password = $_POST['txt_password'];

            $findAccount = $stdClass->Find('std_id, std_firstname, std_username, std_password, std_salt', 'std_username', $std_username);
            $dataStd = $findAccount->fetch(PDO::FETCH_ASSOC);

            if ($findAccount->rowCount() === 0) {
                echo "<script>
                    Swal.fire({
                        title: 'ไม่พบชื่อผู้ใช้ กรุณาลองใหม่',
                        text: 'หากยังไม่ได้ทำการสมัครสมาชิก โปรดสมัครสมาชิกก่อนค่ะ',
                        icon: 'error',
                        showConfirmButton: false,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'ปิด'
                    })
                </script>";
            } else {
                $endcodeClass->salt = $dataStd['std_salt'];
                $endcodeClass->Encode($std_password);

                if ($endcodeClass->passwordEncode === $dataStd['std_password'] && $std_username === $dataStd['std_username']) {
                    echo "<script>
                        Swal.fire({
                            title: 'เข้าสู่ระบบสำเร็จ',
                            text: 'ระบบกำลังพาท่านไปหน้าหลัก',
                            icon: 'success',
                            showConfirmButton: false,
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                        }).then(setTimeout(() => {
                            window.location.href='index.php'
                        }, 2000));
                    </script>";
                    $_SESSION['std_id'] = $dataStd['std_id'];
                    $_SESSION['std_firstname'] = $dataStd['std_firstname'];
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
                            text: 'โปรดลองใหม่ หากจำรหัสผ่านไม่ได้ ให้กดลืมรหัสผ่านค่ะ',
                            icon: 'error',
                            showConfirmButton: false,
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: 'ปิด'
                        })
                    </script>";
                }
            }
        }
        
    ?>
    
    <div class="container_login">
        <form action="#" method="POST">
            <div class="areaLogin">
                <p>เข้าสู่ระบบ</p>
                <div class="input">
                    <i class="fas fa-user"></i>
                    <i class="fas fa-lock"></i>
                    <input name="txt_username" type="text" placeholder="ชื่อผู้ใช้" required>
                    <input name="txt_password" type="password" placeholder="รหัสผ่าน" required>
                </div>
                <a href="forgot.php" class="forgotPassword">ลืมรหัสผ่าน</a>
                <input name="btn_login" class="btnLogin" type="submit" value="เข้าสู่ระบบ">
                <a href="register.php" class="areaLinkRegister">
                    <p class="btnLinkRegister" href="register.php">สมัครสมาชิก</p>
                </a>
            </div>
        </form>
        <div class="adminLogin">
            <a href="./admin/login.php">สำหรับเจ้าหน้าที่</a>
        </div>
    </div>
    <div class="overlayLogin"></div>
    
    <script src="./assets/js/_title_change.js" onload="switchTitle('เข้าสู่ระบบหอพัก')"></script>
    <script src="./assets/js/_login.js"></script>

</body>
</html>
