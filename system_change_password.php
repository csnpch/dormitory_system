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

    $stdClass = new Student();
    $endcodeClass = array(new Encode(), new Encode());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เปลี่ยนรหัสผ่าน</title>
    <link rel="icon" href="./assets/img/logoKmutnb.webp">
    <link rel="stylesheet" href="./assets/css/tailwind.css">
    <link rel="stylesheet" href="./assets/css/style_x_tailwind.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
    <?php include('./file_link/system_sidebar.php') ?>

    <div id="container"     class="flex flex-col lg:w-9\/12 lg:ml-64 transition-all">
        
        <div id="navbar"    class="z-20 fixed flex flex-row items-center bg-white h-14 w-full border-b-2 shadow-sm
                                            delay-400 transition-all">
                <div id="menu"  class="lg:hidden absolute menuBar ml-4 cursor-pointer z-20">
                    <i class="fas fa-bars"></i>
                </div>
                <div id="title_nav"     class="w-full text-center ml-6 lg:-ml-36">
                    <p class="tracking-widest mt-0.5 sm:ml-4 text-lg defocus">
                        <span id="txtNav">เปลี่ยนรหัสผ่าน</span>
                    </p>
                </div>
        </div>

        <section    class="min-h-screen bg-gray-100 pl-2 pr-2 pt-20 md:pl-10 sm:pl-8 md:pr-10 sm:pr-8 pb-20">
        
            <form name="frm_change_password" action="" method="POST">
                <div id="content" class="bg-white rounded-2xl pt-12 pb-10 shadow-md transition-all grid gap-y-4 justify-center">
                    
                    <div class="sm:grid grid-cols-4 sm:items-center">
                        <p class="sm:mr-4 sm:text-right defocus ml-1 mb-1 text-md">รหัสผ่านปัจจุบัน</p>
                        <input type="password" name="txt_password" minlength="8" placeholder="รหัสผ่านปัจจุบันของคุณ" 
                                class="sm:col-start-2 sm:col-span-4 sm:w-full shadow-sm text-sm focus:text-md text-black border border-gray-400 bg-white outline-none h-8 pl-2 pr-2">
                    </div>
                    <div class="sm:grid grid-cols-4 sm:items-center">
                        <p class="sm:mr-4 sm:text-right defocus ml-1 mb-1 text-md">รหัสผ่านใหม่</p>
                        <input id="newPass" type="password" name="txt_newPassword" minlength="8" placeholder="Password # 8 ตัวขึ้นไป" 
                                class="sm:col-start-2 sm:col-span-4 sm:w-full shadow-sm text-sm focus:text-md text-black border border-gray-400 bg-white outline-none h-8 pl-2 pr-2">
                    </div>
                    <div class="sm:grid grid-cols-4 sm:items-center">
                        <p class="sm:mr-4 sm:text-right defocus ml-1 mb-1 text-md">ยืนยันรหัสผ่านใหม่</p>
                        <input id="newPass" type="password" name="txt_newPassword2" minlength="8" placeholder="Password again" 
                                class="sm:col-start-2 sm:col-span-4 sm:w-full shadow-sm text-sm focus:text-md text-black border border-gray-400 bg-white outline-none h-8 pl-2 pr-2">
                    </div>
                    <a href="forgot.php" class="-mt-2 text-right text-xs text-blue-800 hover:underline">จำรหัสผ่านปัจจุบันไม่ได้&nbsp;?</a>
                    <input type="submit" id="btn_change" name="btnChangePassword" class="hidden">
                    <div class="sm:grid grid-cols-4 sm:items-center">
                        <div class="sm:col-start-2 sm:col-span-3 text-center cursor-pointer mt-2 text-red-700 p-1 pl-4 pr-4 round border-2 border-red-700 rounded-md 
                                    duration-200 hover:bg-red-700 hover:text-white" onclick="checkNewPasswordEqual()">
                            <i class="fas fa-key transform rotate-90 sm:mr-1"></i>
                            เปลี่ยนรหัสผ่าน
                        </div>
                    </div>
                </div>
            </form>
            
        </section> <!-- End section -->
        <?php include('./file_link/system_footer.php') ?>
    </div>

    <script src="./assets/js/_title_change.js" onload="switchTitle('เปลี่ยนรหัสผ่าน')"></script>
    <script src="./assets/js/_system_sidebar.js"></script>
    <script type="text/javascript">
        function checkNewPasswordEqual() {
            if (document.forms['frm_change_password']['txt_newPassword'].value != document.forms['frm_change_password']['txt_newPassword2'].value 
                  || (document.forms['frm_change_password']['txt_newPassword'].value.length == 0 && document.forms['frm_change_password']['txt_newPassword2'].value.length == 0))
                Swal.fire({
                    title: 'รหัสผ่านใหม่ไม่ตรงกัน',
                    text: 'กรุณาลองใหม่อีกครั้ง',
                    icon: 'error',
                    showConfirmButton: false,
                    showCancelButton: false,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6'
                }).then(setTimeout(() => {
                    window.location.href='system_change_password.php'
                }, 1000));
            else document.getElementById('btn_change').click();
        }
    </script>

    <?php 
        
        if (!isset($_SESSION['std_id'])) {
            echo "<script>  
                document.getElementById('sidebar').style.display = 'none';
                document.getElementById('container').style.display = 'none';
                Swal.fire({
                    title: 'กรุณาเข้าสู่ระบบก่อน',
                    text: 'ระบบกำลังพาท่านไปยังหน้าเข้าสู่ระบบ',
                    icon: 'error',
                    showConfirmButton: false,
                    showCancelButton: false,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6'
                }).then(setTimeout(() => {
                    window.location.href='login.php'
                }, 3000));
            </script>";
        }

        if (isset($_POST['btnChangePassword'])) {

            $txt_password = $_POST['txt_password'];
            $txt_passwordNew = $_POST['txt_newPassword'];

            $findId = $stdClass->Find('std_password, std_salt', 'std_id', $_SESSION['std_id']);
            $dataStd = $findId->fetch(PDO::FETCH_ASSOC);

            if ($findId->rowCount() === 0) {
                echo "<script>
                    Swal.fire({
                        title: 'ไม่มีข้อมูลของคุณในส่วนนี้',
                        text: 'ระบบเกิดข้อผิดพลาด กรุณาติดต่อเจ้าหน้าที่ ขอบคุณค่ะ',
                        icon: 'error',
                        showConfirmButton: false,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'ปิด'
                    })
                </script>";
            } 
            else {
                $endcodeClass[0]->salt = $dataStd['std_salt'];
                $endcodeClass[0]->Encode($txt_password);

                $pass_salt = $endcodeClass[1]->RandomSalt();
                $passEndcode = $endcodeClass[1]->Encode($txt_passwordNew);

                // $statusChangePassword = ;
                if ($endcodeClass[0]->passwordEncode === $dataStd['std_password'] &&
                    $stdClass->Update_Select(array('std_salt', 'std_password'), array($pass_salt, $passEndcode), 'std_id', $_SESSION['std_id'])) 
                {
                    echo "<script>
                        Swal.fire({
                            title: 'เปลี่ยนรหัสผ่านสำเร็จ',
                            text: '',
                            icon: 'success',
                            showConfirmButton: false,
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                        }).then(setTimeout(() => {
                            window.location.href='system_main.php'
                        }, 2000)); 
                    </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'รหัสผ่านปัจจุบันของคุณไม่ถูกต้อง',
                            text: '',
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

</body>
</html>
 