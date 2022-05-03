<?php 
    session_start();
    require_once ('./../disable_error_report.php');
    require_once ('./../classes/Admin.php');
    $adminClass = new Admin();

    if (!isset($_SESSION['adm_id'])) {
        header('Location: ../admin/login.php');
    } else if (isset($_SESSION['adm_id'])) {
        $statusAdmin = $adminClass->Find('adm_status', 'adm_id', $_SESSION['adm_id']);
        $statusAdmin = $statusAdmin->fetch(PDO::FETCH_ASSOC);
        if (intval($statusAdmin['adm_status']) === 2) {
            header('Location: ../admin/book_manage.php');
        }
    }

    require_once ('../classes/Status.php');
    $statusClass = new Status();
    $statusBook = $statusClass->Find('*', 'status_name', 'system_book');
    $statusBook = $statusBook->fetch(PDO::FETCH_ASSOC);
    $statusRegister = $statusClass->Find('*', 'status_name', 'system_register');
    $statusRegister = $statusRegister->fetch(PDO::FETCH_ASSOC);
    $statusMain = $statusClass->Find('*', 'status_name', 'system_main');
    $statusMain = $statusMain->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ควมคุมระบบหอพัก</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <link rel="stylesheet" href="../assets/css/style_x_tailwind.css">
    <link rel="icon" href=" ../assets/img/logoKmutnb.webp">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../assets/node_modules/daisyui/dist/full.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>
<body class="font_prompt">

    <?php
    
        function alertPopup($status, $txt) {
            switch ($status) {
                case 1:
                    echo "<script type='text/javascript'>
                        Swal.fire({
                            position: 'center-center',
                            icon: 'success',
                            html: '".$txt."',
                            showConfirmButton: false,
                            timer: 1000
                        })
                        
                        setTimeout(() => {
                            window.location.href='./control_system.php';
                        }, 1000);

                    </script>";
                    break;
                case 0:
                    echo "<script type='text/javascript'>
                        Swal.fire({
                            position: 'center-center',
                            icon: 'error',
                            html: 'เกิดข้อผิดพาด กรุณาติดต่อผู้ดูแลระบบ',
                            showConfirmButton: false,
                            timer: 1000
                        })
                    </script>";
                    break;
            }
        }
    
        if (isset($_POST['btn_change_status_register'])) {
            if (intval($statusRegister['status_switch']) === 1)  $statusRegister['status_switch'] = 0;
            else    $statusRegister['status_switch'] = 1;

            if($statusClass->Update_Switch($statusRegister['status_id'], $statusRegister['status_switch'])) {
                alertPopup(1, 'เปลี่ยนสถานะการสมัครสมาชิกสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        
        } else if (isset($_POST['btn_change_status_system_main'])) {
            if (intval($statusMain['status_switch']) === 1)  $statusMain['status_switch'] = 0;
            else    $statusMain['status_switch'] = 1;
            
            if($statusClass->Update_Switch($statusMain['status_id'], $statusMain['status_switch'])) {
                alertPopup(1, 'เปลี่ยนสถานะการปรับปรุงระบบสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        
        } else if (isset($_POST['btn_ImportantChangeImg'])) {
            copy($_POST['txt_link_img'], './../assets/img/maintenance/img_maintenance.jpg');
            alertPopup(1, 'บังคับเปลี่ยนรูปภาพสำเร็จ');
        }

    ?>

    <div class="flex">
            <!-- Content -->
        <!-- Sidebar -->
        <?php include ('./adm_file_link/sidebar.php'); ?>
        <!-- Navbar -->
        <div id="main" class="flex flex-col w-full lg:w-11/12 ml-0 lg:ml-64 trasition-all duration-300 bg-gray-100">
            <?php include ('./adm_file_link/navbar.php'); ?>
            
            <div class="flex justify-start sm:ml-10 sm:mt-4 breadcrumbs m-2 ml-6 sm:ml-4 tracking-wide" style="font-size: 0.8rem;">
                <ul>
                    <li>
                        <i class="fas fa-tasks mr-2"></i>
                        <a href="./control_system.php">
                            ควบคุมระบบ
                        </a>
                    </li> 
                </ul>
            </div>

            <session class="flex flex-col gap-y-2 border-2 border-black border-opacity-10 shadow-md pt-2 pb-8 items-center w-min-screen ml-4 md:ml-8 mr-4 md:mr-8 pr-4 pl-4 bg-primary-content rounded-md">
                <div class="flex flex-col items-center justify-center">
                    <p class="mb-2 mt-4 text-center" style="font-size: 1.1rem;">สถานะระบบสมัครสมาชิก</p>
                    <?php if ($statusRegister['status_switch'] == '0'): ?>
                        <input class="font_kanit w-64 p-1 bg-red-200" style="font-size: 0.9rem;" type="submit" value="ปิดทำงาน">
                    <?php elseif($statusRegister['status_switch'] == '1'): ?>
                        <input class="font_kanit w-64 p-1 bg-green-200" style="font-size: 0.9rem;" type="submit" value="เปิดทำงาน">
                    <?php endif; ?>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <p class="mb-2 mt-4 text-center" style="font-size: 1.1rem;">สถานะการจองห้องพักของนักศึกษา</p>
                    <?php if ($statusBook['status_switch'] == '0'): ?>
                        <input class="font_kanit p-1 w-64 bg-red-200" style="font-size: 0.9rem;" type="submit" value="ปิดทำงาน">
                    <?php elseif($statusBook['status_switch'] == '1' || $statusBook['status_switch'] == '3'): ?>
                        <input class="font_kanit p-1 w-64 bg-green-200" style="font-size: 0.9rem;" type="submit" value="เปิดทำงาน <?Php echo ($statusBook['status_switch'] == '3' ? '(ระบบอัตโนมัติ)' : '') ?>">
                    <?php elseif($statusBook['status_switch'] == '2'): ?>
                        <input class="font_kanit p-1 w-64 bg-yellow-200" style="font-size: 0.9rem;" type="submit" value="ระบบอัตโนมัติกำลังทำงาน">
                    <?php endif; ?>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <p class="mb-2 mt-4 text-center" style="font-size: 1.1rem;">สถานะปิดปรับปรุงระบบหอพัก</p>
                    <?php if ($statusMain['status_switch'] == '0'): ?>
                        <input class="font_kanit p-1 w-64 bg-red-200" style="font-size: 0.9rem;" type="submit" value="ปิดทำงาน">
                    <?php elseif($statusMain['status_switch'] == '1'): ?>
                        <input class="font_kanit p-1 w-64 bg-green-200" style="font-size: 0.9rem;" type="submit" value="เปิดทำงาน">
                    <?php endif; ?>
                </div>
            </session>

            <div class="space mb-4"></div>

            <session class="flex flex-col items-center gap-y-2 border-2 border-black border-opacity-10 shadow-md pt-2 pb-4 items-center w-min-screen ml-4 md:ml-8 mr-4 md:mr-8 pr-4 pl-4 bg-primary-content rounded-md">
                <div class="p-4 -mb-2 rounded-md w-full md:w-11/12 flex flex-col items-center justify-center text-center">
                    <p class="text-md lg:text-xl text-center text-red-900">เลือกสิ่งที่ต้องการควบคุม</p>
                </div>

                <div class="bg_card_blue_hv btn_control_system_register cursor-pointer text-center text-white p-3 relative bg-white rounded-lg shadow-md transition-all w-full">
                    <p style="font-size: 1rem;">ควบคุมการสมัครสมาชิก</p>
                </div>

                <form action="" method="POST">
                    <div class="manage_status_register hidden flex flex-col justify-center mb-4">
                        <input name="btn_change_status_register" class="changeStatusRegister hidden" type="submit">
                        <div class="flex flex-row mt-4">
                            <span class="text-md mr-4">เปิดให้นักศึกษาลงทะเบียนได้</span> 
                            <input type="checkbox"
                                <?php if($statusRegister['status_switch'] == '1') echo ("checked='checked'") ?> 
                                class="toggle toggle-primary" onchange="setTimeout(() => { document.getElementsByClassName('changeStatusRegister')[0].click(); }, 300);">
                        </div>
                    </div>
                </form> 

                <a href="./control_book_system.php" class="bg_card_purple_hv -mt-1.5 text-center text-white p-3 relative bg-white rounded-lg shadow-md transition-all w-full">
                    <p style="font-size: 1rem;">ควบคุมระบบจองห้องพัก</p>
                </a>

                <div class="bg_card_red_hv btn_control_system_main cursor-pointer text-center text-white p-3 relative bg-white rounded-lg shadow-md transition-all w-full">
                    <p style="font-size: 1rem;">ปิดปรับปรุงเว็บ</p>
                </div>

                <form action="" method="POST">
                    <div class="manage_status_system_main hidden flex flex-col justify-center ">
                        <input name="btn_change_status_system_main" class="changeStatusSystemMain hidden" type="submit">
                        <div class="flex flex-row mt-4">
                            <span class="text-md mr-4">เปิดการปรับปรุงระบบหอพัก</span> 
                            <input type="checkbox"
                                <?php if($statusMain['status_switch'] == '1') echo ("checked='checked'") ?> 
                                class="toggle toggle-primary" onchange="setTimeout(() => { document.getElementsByClassName('changeStatusSystemMain')[0].click(); }, 300);">
                        </div>
                        <p class="mt-8 text-red-900 text-sm text-center">รูปภาพที่แสดงหน้าปรับปรุงระบบ (1920x1080)</p>
                        <img src="./../assets/img/maintenance/img_maintenance.jpg" class="h-40 mt-2">
                        <p class="mt-2 text-red-900 text-sm text-center">(หากภาพไม่เปลี่ยนให้กด Shift + F5)</p>
                        <div class="btn_popupImportantChangeImg btn btn-xs mt-2 font_prompt">บังคับเปลี่ยน</div>
                        <div class="space mb-20"></div>
                        
                    </div>
                </form>

            </session>

            <div class="overlay hidden w-full h-screen fixed bg-black top-0 opacity-20 z-20"></div>

            <div class="popupImportantChangeImg hidden fixed w-full md:w-10/12 h-screen z-40 flex flex-col justify-center items-center">
                <form action="#" method="POST">
                    <div class="bg-white text-center p-4 flex flex-col w-full rounded-md">
                        <p class="mb-2 text-xl text-red-900">ลิ้งภาพข่าว&nbsp;&nbsp;<span class="text-sm">ขนาดแนะนำ (1920x1080)</span></p>
                        <textarea required name="txt_link_img" placeholder="link:url:img" class="border-2 border-black border-opacity-20 h-20 w-full p-2 rounded-md"></textarea>
                        <div class="grid grid-cols-2 gap-2 mt-2">
                            <button name="btn_ImportantChangeImg" class="btn btn-sm btn-info">บันทึก</button>
                            <button type="reset" class="btn_cancelImportantChangeImg btn btn-sm btn-error maintenance/img_maintenance.jpg-error">ยกเลิก</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="space mt-24"></div>

            <div class="">
                <?php include('./adm_file_link/footer.php'); ?>
            </div>

        </div>

    </div>
    
    <script type="text/javascript" src="../assets/js/_title_change.js" onload="switchTitle('ควมคุมระบบหอพัก')"></script>
    <script type="text/javascript" src="../assets/js/_adm_select_menu.js" onload="select_menu(1)"></script>
    <script type="text/javascript" src="../assets/js/_adm_control_system.js"></script>
    <script type="text/javascript" src="../assets/js/main.js"></script>

</body>
</html>
