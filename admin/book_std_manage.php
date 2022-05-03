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

    require_once ('../classes/Building.php');
    require_once ('../classes/Floor.php');
    require_once ('../classes/Room.php');
    require_once ('../classes/Student.php');
    require_once ('../classes/Book.php');
    require_once ('../classes/Branch.php');
    $buildingClass = new Building();
    $floorClass = new Floor();
    $roomClass = new Room();
    $bookClass = new Book();
    $stdClass = new Student();
    $branchClass = new Branch();

?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>การจองห้องพัก</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <link rel="stylesheet" href="../assets/css/style_x_tailwind.css">
    <link rel="icon" href=" ../assets/img/logoKmutnb.webp">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../assets/node_modules/daisyui/dist/full.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body class="font_prompt">

    <script type="text/javascript">
        function select_option(id, val) {
            document.getElementById(id).value = val;
        }
    </script>

    <div class="flex">
        <!-- Sidebar -->
        <?php include ('./adm_file_link/sidebar.php'); ?>
        <!-- Navbar -->
        <div id="main" class="overflow-x-hidden flex flex-col w-full lg:w-11/12 ml-0 lg:ml-64 trasition-all duration-300 bg-gray-200 h-screen">
            <?php include ('./adm_file_link/navbar.php'); ?>

            <!-- SESSION -->
                <session id="manage_main" class="font_kanit bg-gray-100 flex flex-col justify-center items-center w-min-screen pb-10 mt-6 md:ml-8 md:mr-8 md:pr-4 md:pl-4 rounded-md shadow-md">
                    
                    <div class="text-left breadcrumbs m-2 ml-6 sm:ml-4 tracking-wide w-full" style="font-size: 0.8rem;">
                        <ul>
                            <li>
                                <i class="fas fa-bed mr-2"></i>
                                <a href="./book_manage.php">
                                    การจองห้องพัก
                                </a>
                            </li> 
                            <li>
                                <i class="fas fa-exclamation-circle mr-2 fa-lg"></i>
                                <a href="./book_std_manage.php">
                                    ปลดการเข้าพักของนักศึกษา
                                </a>
                            </li>
                        </ul>
                    </div>

        
                    <form action="#" method="POST" name="dynamic_manage" class="w-full">
                        <div class="font_sarabun bg-white rounded-2xl mt-10 border-2 border-green-900 border-opacity-70 w-11/12 mx-auto p-2 pt-8 pb-8 flex flex-col text-center items-center">
                            <p class="text-lg text-black tracking-wide text-black">เลือกห้องพักเพื่อนำนักศึกษาออก&nbsp;&nbsp;<br class="sm:hidden"><span class="text-red-900">&nbsp;&nbsp;( แนะนำ )</span></p>
                            
                            <div class="gap-x-4 flex flex-row justify-center mt-6">
                                <div class="gap-y-2 flex flex-col justify-center items-center">
                                    <select id="select_building" name="select_building" class="select select-bordered w-full max-w-xs" onchange="set_selectFloor()">
                                    </select>
                                </div>
                                <div class="gap-y-2 flex flex-col justify-center items-center">
                                    <select id="select_floor" name="select_floor" class="select select-bordered w-full max-w-xs" onchange="appendDataTable()">
                                        <option selected disabled>- เลือกชั้น -</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="flex flex-col justify-center items-center overflow-x-auto p-1.5 w-11/12 hidden" id="areaTable">
                                <div class="p-1.5 w-full">
                                    <form action="#" method="POST">
                                        <div id="dataRoom">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="checkAllBtn" class="w-11/12 text-left">
                            </div>
                            <input type="submit" name="btn_destroyRoomFormSelect" class="btn_destroyRoomFormSelect hidden">
                        </div>
                    </form>

                    <form action="#" method="POST" name="constant_manage" class="mt-10 w-11/12 mx-auto">
                        <div class="font_sarabun bg-white rounded-2xl border-2 border-indigo-900 border-opacity-60 w-full p-2 pt-8 pb-8 flex flex-col text-center items-center">
                            <p class="text-lg text-black tracking-wide">นำนักศึกษาออกจากห้องพัก <br class="sm:hidden"> ตาม " ปี " ของรหัสนักศึกษา</p>
                            <p class="mt-1 text-lg text-black tracking-wide">ตัวอย่าง&nbsp;&nbsp;<span class="underline mr-0.5">63</span>06021621138</p>
                            <div class="w-64 flex flex-col gap-y-4 mt-4">
                                <select name="select_year" required class="select_year p-2 text-center w-full shadow-md border-2 border-black border-opacity-10">
                                    <option disabled selected>- เลือกปีที่ต้องการ -</option>
                                    <?php 
                                        $yearIdStd = $stdClass->getYearStdIdForDestroyBook();
                                        while ($value = $yearIdStd->fetch(PDO::FETCH_ASSOC)):
                                    ?>
                                        <option value="<?php echo $value['stdYearId'] ?>"><?php echo $value['stdYearId']; ?></option>
                                    <?php 
                                        endwhile;
                                    ?>
                                </select>
                                <div class="btn_destroyRoomFormYearCheck bg_card_red_on_hv hover:bg-red-800 cursor-pointer font_prompt text-center text-white rounded-lg h-10 w-full p-4 flex justify-center items-center">
                                    นำออกตามปีรหัส นศ.
                                </div>
                            </div>
                        </div>

                        <div class="font_sarabun bg-white mt-10 rounded-2xl border-2 border-red-900 border-opacity-60 w-full p-2 pt-8 pb-8 flex flex-col text-center items-center">
                            <p class="text-lg text-black tracking-wide">นำนักศึกษาออกทุกคนออกจากห้องพัก !</p>
                            <div class="btn_destroyRoomAllStdCheck bg_card_red_on_hv hover:bg-red-800 cursor-pointer w-64 flex flex-col gap-y-4 mt-4 font_prompt text-center text-white rounded-lg h-10 p-4 flex justify-center items-center">
                                นำออกจากห้องพักทุกคน
                            </div>
                        </div>

                        <input type="submit" name="btn_destroyRoomFormYear" class="hidden btn_destroyRoomFormYear">
                        <input type="submit" name="btn_destroyRoomAllStd" class="hidden btn_destroyRoomAllStd">

                    </form>

                </session>

            <div class="overlay fixed hidden z-10 w-full h-full bg-black opacity-30"></div>

            <div class="space mb-40"></div>

        </div>

    </div>

    <script type="text/javascript" src="./../assets/js/_title_change.js" onload="switchTitle('ปลดการเข้าพักของ นศ.')"></script>
    <script type="text/javascript" src="./../assets/js/_adm_select_menu.js" onload="select_menu(6)"></script>
    <script type="text/javascript" src="./../assets/js/_adm_book_std_manage.js"></script>

    <?php

        $stdClass->autoDestroyRoom(4);

        $array_building = array();
        $array_floor = array();
        $array_room = array();
        $array_areaBook = array();
        $array_book = array();
        

        $selectBuilding = $buildingClass->Select_Sort('building_id, building_name, building_gender', 'building_id ASC', '', 0);
        while ($value = $selectBuilding->fetch(PDO::FETCH_ASSOC)) {
            array_push($array_building, $value);
        }


        $selectFloor = $floorClass->Select_Sort('building_id, floor_id, floor_name', 'floor_name ASC', '', 0);
        while ($value = $selectFloor->fetch(PDO::FETCH_ASSOC)) {
            array_push($array_floor, $value);
        }


        $selectRoom = $roomClass->Select_Order('floor_id, room_id, room_name, room_member, room_status', 'room_name', 'ASC');
        while ($value = $selectRoom->fetch(PDO::FETCH_ASSOC)) {
            array_push($array_room, $value);
        }


        $selectAreaBook = $bookClass->getDataBook();
        while ($value = $selectAreaBook->fetch(PDO::FETCH_ASSOC)) {
            array_push($array_areaBook, $value);
        }

            
        $selectBook = $roomClass->bookRelation();
        while ($value = $selectBook->fetch(PDO::FETCH_ASSOC)) {
            array_push($array_book, $value);
        }

        echo "<script type='text/javascript'>
            setValuesForBook(".json_encode($array_building).", ".json_encode($array_floor).", ".json_encode($array_room).", ".json_encode($array_book).");
        </script>";


        function alertPopup($status, $txt) {
            switch ($status) {
                case 1:
                    echo "<script type='text/javascript'>
                        Swal.fire({
                            position: 'center-center',
                            icon: 'success',
                            html: '".$txt."',
                            showConfirmButton: false,
                            timer: 2000
                        })
                        
                        setTimeout(() => {
                            window.location.href='./book_std_manage.php';
                        }, 2000);

                    </script>";
                    break;
                case 0:
                    echo "<script type='text/javascript'>
                        Swal.fire({
                            position: 'center-center',
                            icon: 'error',
                            html: 'เกิดข้อผิดพาด กรุณาติดต่อผู้ดูแลระบบ',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    </script>";
                    break;
            }
        }
    
        if (isset($_POST['btn_destroyRoomFormYear'])) {
            if ($stdClass->destroyRoomFormStdYear($_POST['select_year'])) {
                alertPopup(1, 'นำนักศึกษาออกจากห้องพักตามปีสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['btn_destroyRoomAllStd'])) {
            if ($stdClass->destroyRoomFormStdAll()) {
                alertPopup(1, 'นำนักศึกษาออกจากห้องพักทั้งหมดสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['btn_destroyRoomFormSelect'])) {
            foreach ($_POST['id_rooms'] as $room_id) { 
                $stdClass->destroyRoomByRoomId($room_id);
            }
            echo "<script type='text/javascript'>
                Swal.fire({
                    position: 'center-center',
                    icon: 'success',
                    html: 'นำนักศึกษาออกจากห้องพักที่ท่านเลือกสำเร็จ',
                    showConfirmButton: false,
                    timer: 2000
                })
                setTimeout(() => {
                    window.location.href='./book_std_manage.php?building=".$_POST['select_building']."&floor=".$_POST['select_floor']."';
                }, 2000);
            </script>";
        }

        if(isset($_GET['building'])) {
            echo "<script type='text/javascript'>
                for (let i = 0; i < 2; i++) {
                    setTimeout(() => {
                        document.getElementById('select_building').value = ".$_GET['building'].";
                        set_selectFloor();
                    }, 1000);
                    setTimeout(() => {
                        document.getElementById('select_floor').value = ".$_GET['floor']."; 
                        appendDataTable();
                    }, 1050);
                }
            </script>";
        }

    ?>

</body>
</html>