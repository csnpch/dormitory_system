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
    $statusData = $statusClass->Find('*', 'status_name', 'system_book');
    $statusData = $statusData->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ควมคุมระบบจองห้องพัก</title>
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

        $AlertError = FALSE;

        if (isset($_POST['btn_custom_change_status'])) {
            if ($statusData['status_switch'] == '1' || $statusData['status_switch'] == '3')  $statusData['status_switch'] = 0;
            else    $statusData['status_switch'] = 1;
            
            if(!$statusClass->Update_Switch($statusData['status_id'], $statusData['status_switch'])) {
                $AlertError = TRUE;
            }
    
        } else if (isset($_POST['btn_auto_change_status'])) {
            $statusData['status_switch'] = 2;
            if($statusClass->Update_date_range($statusData['status_id'], explode(' - ', $_POST['value_range_time'])[0], explode(' - ', $_POST['value_range_time'])[1])
                && ($statusClass->Update_Switch($statusData['status_id'], $statusData['status_switch']))) {
                echo "<script type='text/javascript'>window.location.href = './control_book_system.php';</script>";
            } else {
                $AlertError = TRUE;
            }
        } else if (isset($_POST['btn_auto_change_status2'])) {
            if ($statusData['status_switch'] == '2')  $statusData['status_switch'] = 3;
            else    $statusData['status_switch'] = 2;

            if($statusClass->Update_date_range($statusData['status_id'], explode(' - ', $_POST['value_range_time'])[0], explode(' - ', $_POST['value_range_time'])[1])
                && ($statusClass->Update_Switch($statusData['status_id'], $statusData['status_switch']))) {
                echo "<script type='text/javascript'>window.location.href = './control_book_system.php';</script>";
            } else {
                $AlertError = TRUE;
            }
        }
        
        if ($AlertError) {
            echo "<script type='text/javascript'>
                Swal.fire({
                    title: 'ระบบเกิดข้อผิดพลาด',
                    text: 'กรุณาติดต่อผู้ดูแลระบบ!',
                    icon: 'error',
                    showConfirmButton: false,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'ปิด'
                })
            </script>";
        }

    ?>

    <div class="flex">
            <!-- Content -->
        <!-- Sidebar -->
        <?php include ('./adm_file_link/sidebar.php'); ?>
        <!-- Navbar -->
        <div id="main" class="flex flex-col w-full lg:w-11/12 ml-0 lg:ml-64 trasition-all duration-300 bg-gray-100 h-min-screen">
            <?php include ('./adm_file_link/navbar.php'); ?>
            
            <div class="flex justify-start sm:ml-10 sm:mt-4 breadcrumbs m-2 ml-6 sm:ml-4 tracking-wide" style="font-size: 0.8rem;">
                <ul>
                    <li>
                        <i class="fas fa-tasks mr-2"></i>
                        <a href="./control_system.php">
                            ควบคุมระบบ
                        </a>
                    </li> 
                    <li>
                        <i class="fas fa-person-booth mr-2"></i>
                        <a href="./control_book_system.php">
                            ระบบจองห้องพัก
                        </a>
                    </li>
                </ul>
            </div>

            <!-- SESSION -->
            <session class="flex flex-col shadow-md pt-2 pb-6 items-center w-min-screen ml-4 md:ml-8 mr-4 md:mr-8 pr-4 pl-4 bg-primary-content rounded-md">
                <!-- <p class="text-md lg:text-xl mt-10 text-center">สถานะการเปิดให้จองห้องพักของนักศึกษา : <span class="text-red-600">ปิดอยู่</span></p> -->
                <div class="flex flex-col justify-center">
                    <p class="text-md lg:text-xl mt-4 text-center">สถานะการจองห้องพักของนักศึกษา</p>
                    <?php if ($statusData['status_switch'] == '0'): ?>
                        <input class="mt-2 font_kanit p-1 bg-red-200" type="submit" value="ปิดทำงาน">
                    <?php elseif($statusData['status_switch'] == '1' || $statusData['status_switch'] == '3'): ?>
                        <input class="mt-2 font_kanit p-1 bg-green-200" type="submit" value="เปิดทำงาน <?Php echo ($statusData['status_switch'] == '3' ? '(ระบบอัตโนมัติ)' : '') ?>">
                    <?php elseif($statusData['status_switch'] == '2'): ?>
                        <input class="mt-2 font_kanit p-1 bg-yellow-200" type="submit" value="ระบบอัตโนมัติกำลังทำงาน">
                    <?php endif; ?>
                </div>
            </session>

            <session class="flex flex-col shadow-md pt-2 pb-4 items-center w-min-screen mt-6 ml-4 md:ml-8 mr-4 md:mr-8 pr-4 pl-4 bg-primary-content rounded-md">
                <div class="p-4 pt-8 pb-8 rounded-md w-full md:w-11/12 flex flex-col items-center justify-center text-center">
                    <p class="text-md lg:text-xl mb-6 text-center text-red-900">ควมคุมเวลาการจองห้องพัก<br class="md:hidden">&nbsp;( อัตโนมัติ )</p>

                    <?php if ($statusData['status_switch'] == '0' || $statusData['status_switch'] == '1'): ?>
                        <p class="text-md lg:text-lg">เวลา เปิด-ปิด ให้จองห้องพักอัตโนมัติ</p>
                    <?php elseif($statusData['status_switch'] == '2'): ?>
                        <p class="text-md lg:text-lg text-green-800">เหลือเวลาที่จะเปิดให้จองห้องพักในอีก</p> 
                    <?php elseif($statusData['status_switch'] == '3'): ?>
                        <p class="text-md lg:text-lg text-red-800">เหลือเวลาที่จะปิดให้จองห้องพักในอีก</p> 
                    <?php endif; ?>
                    <!-- TIME AREA -->
                    <div id="changeColorBorder" class="mt-4 flex flex-row gap-5 auto-cols-max defocus">
                        <div>
                            <span class="font-mono text-4xl countdown">
                            <span id="day" style="--value:00;"></span>
                            </span>
                                days
                        </div> 
                        <div>
                            <span class="font-mono text-4xl countdown">
                            <span id="hour" style="--value:00;"></span>
                            </span>
                                hours
                        </div> 
                        <div>
                            <span class="font-mono text-4xl countdown">
                            <span id="min" style="--value:00;"></span>
                            </span>
                                min
                        </div> 
                        <div>
                            <span class="font-mono text-4xl countdown">
                            <span id="sec" style="--value:00;"></span>
                            </span>
                                sec
                        </div>
                    </div>

                    <p class="mt-8 text-center">กำหนดช่วงวันเปิดให้จองห้องพัก<br class="md:hidden">&nbsp;(ด/ว/ป)</p>
                    <div class="mt-4 flex flex-col md:h-8 md:flex-row items-center justify-center">
                        <form method="POST" action="#">
                            <input id="btn_auto_change_status" name="btn_auto_change_status" type="submit" value>
                            <input id="btn_auto_change_status2" name="btn_auto_change_status2" type="submit" value>
                            <input id="demo-mobile-picker-button" name="value_range_time" class="txt_timeRange text-red-800 md:mr-2 text-center md-mobile-picker-input h-full" 
                                value="<?php echo ($statusData['status_date_start'].' - '.$statusData['status_date_stop'] ); ?>">
                        </form>

                        <div class="space mb-3 md:mb-0"></div>

                        <div class="mt-2">
                            <button data-variant="outline" id="show-mobile-date-picker" onclick="submitTimeRange(0)" 
                                class="h-full pl-2 pr-2 border-2 border-purple-800 rounded-md text-purple-800 hover:bg-purple-800 hover:text-white md-mobile-picker-button">
                                <span class="font_kanit">เปลี่ยน</span>
                            </button>
                            <button id="confirmTimeRange" onclick="submitTimeRange(1)"
                                class="confirmTimeRange hidden mt-2 md:mt-0 p-0.4 pl-2 pr-2 rounded-md text-green-800 border-2 border-green-800 hover:bg-green-800 hover:text-white">
                                ยืนยันช่วงเวลา
                            </button>
                        </div>
                        <div class="md-mobile-picker-inline hidden">
                            <div id="demo-mobile-picker-inline"></div>
                        </div>
                    </div>
                </div>
            </session>

            <session class="flex flex-col shadow-md items-center w-min-screen mt-6 ml-4 md:ml-8 mr-4 md:mr-8 pr-4 pl-4 bg-primary-content rounded-md">
                <div class="p-4 pt-2 pb-2 rounded-md w-full md:w-11/12 flex flex-col items-center justify-center text-center">
                    <p class="text-md lg:text-xl mt-10 text-center text-red-900">ควมคุมเวลาการจองห้องพัก<br class="md:hidden">&nbsp;( ควบคุมมือ )</p>
                    <div class="p-6 card bordered">
                        <div class="form-control">
                            <form method="POST" action="#">
                                <label class="cursor-pointer label">
                                    <span class="text-md mr-4">เปิดให้นักศึกษาจองห้องพัก</span> 
                                    <input name="btn_custom_change_status" id="changeStatusCustom" type="submit" value="">
                                    <input type="checkbox" 
                                        <?php if($statusData['status_switch'] == '1') echo ("checked='checked'") ?> 
                                        class="toggle toggle-primary" onchange="setTimeout(() => { document.getElementById('changeStatusCustom').click(); }, 300);">
                                </label>
                            </form>
                        </div>
                    </div>
                </div>
            </session>

            <div class="space mb-10"></div>
            <!-- <div class="space mb-10"></div> -->

            <div class="md:hidden">
                <?php include('./adm_file_link/footer.php'); ?>
            </div>

        </div>

    </div>

    <script type="text/javascript">
        function submitTimeRange(n){
            switch (n) {
                case 0:
                    document.getElementById('demo-mobile-picker-button').click();
                    document.getElementById('confirmTimeRange').classList.remove('hidden');
                    break;
                case 1:
                    document.getElementById('btn_auto_change_status').click();
                    break;
            }
        }

        $('input[name="value_range_time"]').daterangepicker();

        document.getElementById('demo-mobile-picker-button').addEventListener('click', () => {
            submitTimeRange(0);
        })

    </script>
    
    <script type="text/javascript" src="../assets/js/_title_change.js" onload="switchTitle('ควมคุมระบบหอพัก')"></script>
    <script type="text/javascript" src="../assets/js/_adm_select_menu.js" onload="select_menu(1)"></script>
    <script type="text/javascript" src="../assets/js/_adm_control_book_system.js"></script>
    <script type="text/javascript" src="../assets/js/main.js"></script>

</body>
</html>


<?php 

    if ($statusData['status_switch'] == '2') {
        echo "<script type='text/javascript'>
            callDateRange(1, '".strval($statusData['status_date_start'].' - '.$statusData['status_date_stop'])."');
            document.getElementById('changeColorBorder').classList.add('border-b-2');
            document.getElementById('changeColorBorder').classList.add('border-green-600'); 
        </script>"; // send 1 is active , 0 is deactive
    } else if ($statusData['status_switch'] == '3') {
        echo "<script type='text/javascript'>
            callDateRange(0, '".strval($statusData['status_date_start'].' - '.$statusData['status_date_stop'])."');
            document.getElementById('changeColorBorder').classList.add('border-b-2');
            document.getElementById('changeColorBorder').classList.add('border-red-500'); 
        </script>";
    }

?>