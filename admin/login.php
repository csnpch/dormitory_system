<?php 
    session_start();
    require_once ('./../disable_error_report.php');
    require_once ('../classes/Admin.php');
    require_once ('../classes/Encode.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>หอพักนักศึกษา มจพ. ปราจีนบุรี</title>
        <link rel="stylesheet" href="../assets/css/main.css">
        <link rel="icon" href="../assets/img/logoKmutnb.webp">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
<body>

<?php
    $admClass = new Admin();
    $endcodeClass = new Encode();

    if (isset($_SESSION['adm_id'])) {
        echo "<script>  
            Swal.fire({
                title: 'คุณเข้าสู่ระบบอยู่แล้ว',
                html: '<p>กรุณาออกจากระบบก่อนเข้าใช้งานบัญชีใหม่</p><p>ระบบกำลังพาท่านกลับไปยังหน้าหลัก...</p>',
                icon: 'warning',
                showConfirmButton: false,
                showCancelButton: false,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                footer: '<a href=".'../logout.php'.">ต้องการออกจากระบบเดี๋ยวนี้ คลิ๊ก!!</a>'
            }).then(setTimeout(() => {
                window.location.href='dashboard.php'
            }, 4000));
        </script>";
    }

    if (isset($_POST['btn_login'])) {
        $adm_username = $_POST['txt_username'];
        $adm_password = $_POST['txt_password'];

        $findAccount = $admClass->Find('adm_id, adm_fullname, adm_description, adm_username, adm_password, adm_salt', 'adm_username', $adm_username);
        $dataAdm = $findAccount->fetch(PDO::FETCH_ASSOC);

        if ($findAccount->rowCount() === 0) {
            echo "<script>
                Swal.fire({
                    title: 'ไม่พบชื่อผู้ใช้ กรุณาลองใหม่',
                    text: '',
                    icon: 'error',
                    showConfirmButton: false,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'ปิด'
                })
            </script>";
        } else {
            $endcodeClass->salt = $dataAdm['adm_salt'];
            $endcodeClass->Encode($adm_password);

            if ($endcodeClass->passwordEncode === $dataAdm['adm_password'] && $adm_username === $dataAdm['adm_username']) {
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
                        window.location.href='../admin/dashboard.php'
                    }, 2000)); 
                </script>";
                $_SESSION['adm_id'] = $dataAdm['adm_id'];
                $_SESSION['adm_fullname'] = $dataAdm['adm_fullname'];
                $_SESSION['adm_description'] = $dataAdm['adm_description'];
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
                        html: '<p>โปรดลองใหม่ หากจำรหัสผ่านไม่ได้ โปรดติดต่อผู้พัฒนาระบบ</p><p>หรือให้แอดมินท่านอื่นเปลี่ยนรหัสผ่านให้คุณ</p>',
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
                <img src="../assets/img/logoKmutnb.webp" alt="" style="margin-top: -126px; width: 160px; height: 160px; margin-bottom: 28px;">
                <p class="text-title-login-manager">เข้าสู่ระบบเจ้าหน้าที่หอพัก</p>
                <div class="input">
                    <i class="fas fa-user"></i>
                    <i class="fas fa-lock"></i>
                    <input name="txt_username" type="text" placeholder="ชื่อผู้ใช้" required>
                    <input name="txt_password" type="password" placeholder="รหัสผ่าน" required>
                </div>
                <input name="btn_login" class="btnLogin" type="submit" style="margin-top: 24px; margin-bottom: -6px;" value="เข้าสู่ระบบ">
            </div>

        </form>
        
    </div>
    <div class="overlayLogin"></div>
    
    <script src="./assets/js/_login.js"></script>
</body>    
</html>


<style>
    @media screen and (max-width: 768px) {
        .text-title-login-manager {
            font-size: 1.4rem !important;
        }
    }   

    .text-title-login-manager {
    }    
</style>