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
    }

    require_once '../classes/Student.php';
    require_once '../classes/Branch.php';
    require_once '../classes/Building.php';
    require_once '../classes/Floor.php';
    require_once '../classes/Room.php';
    require_once '../classes/Book.php';
    require_once '../classes/Status.php';

    $stdClass = new Student();
    $branchClass = new Branch();
    $buildingClass = new Building();
    $floorClass = new Floor();
    $roomClass = new Room();
    $bookClass = new Book();
    $statusClass = new Status();

?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กางจองห้องพัก</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <link rel="stylesheet" href="../assets/css/style_x_tailwind.css">
    <link rel="icon" href=" ../assets/img/logoKmutnb.webp">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../assets/node_modules/daisyui/dist/full.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    
    <style>
        @keyframes rotateAnimate {
            from{ transform: rotate(-360deg); }
            to{ transform: rotate(360deg); }
        }

        .rotateAnimate {
            animation: rotateAnimate 2s 2;
        }

        .dropdown-room {
            color: #002858;
            background-color: #EFF6FF;
            filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
            border-radius: 5px;
        }

        .room:hover .dropdown-room {
            display: block;
        }
    </style>

</head>
<body class="font_prompt">


    
    <div class="flex">
        <!-- Sidebar -->
        <?php include ('./adm_file_link/sidebar.php'); ?>
        <!-- Navbar -->
        <div id="main" class="overflow-x-hidden flex flex-col w-full lg:w-11/12 ml-0 lg:ml-64 trasition-all duration-300 bg-gray-200 h-screen">
            <?php include ('./adm_file_link/navbar.php'); ?>


                <section  class="flex flex-col gap-y-2 mt-6 pl-2 pr-2 md:pl-10 sm:pl-8 md:pr-10 sm:pr-8">

                    <div class="text-left breadcrumbs mb-2 rounded-md tracking-wide w-full bg-gray-100" style="font-size: 0.8rem;">
                        <ul class="ml-4 mt-0.5 p-0.5">
                            <li>
                                <i class="fas fa-bed mr-2"></i>
                                <a href="./book_manage.php">
                                    การจองห้องพัก
                                </a>
                            </li> 
                        </ul>
                    </div>

                    <?php if (intval($statusAdmin['adm_status']) !== 2): ?>
                        <a href="./book_std_manage.php" class="bg_card_red_hv text-center text-white p-3 relative bg-white rounded-lg shadow-md transition-all w-full">
                            <p style="font-size: 1rem;">ปลดการเข้าพักของนักศึกษา</p>
                        </a>
                    <?php endif; ?>

                    <a href="./book_zone_manage.php" class="bg_card_purple_hv text-center text-white p-3 relative bg-white rounded-lg shadow-md transition-all w-full">
                        <p style="font-size: 1rem;">จัดสรรห้องพัก</p>
                    </a>

                    <button id="btnToggleShowRooms" class="bg_card_blue_hv text-center text-white p-3 relative bg-white rounded-lg shadow-md transition-all w-full">
                        <p style="font-size: 1rem;">สังเกตการณ์ห้องพัก</p>
                    </button>

                </section>

                <!-- SESSION -->
                <div id="area_reportRooms" class="hidden">
                    <section class="mt-4 pl-2 pr-2 md:pl-10 sm:pl-8 md:pr-10 sm:pr-8">
                
                        <div class="relative bg-white rounded-2xl pt-8 shadow-md transition-all">
                            <!-- <p class="defocus sm:ml-4 text-xl mb-6 mt-2 text-red-900 w-full text-center font_kanit">
                                สังเกตการณ์ห้องพัก
                            </p> -->

                            <a href="./book_manage.php">
                                <i id="btn_refresh" class="z-20 rotateAnimate absolute right-3 bottom-3 md:right-6 md:bottom-4 text-blue-900 cursor-pointer fas fa-redo-alt"></i>
                            </a>

                            <script type="text/javascript">
                                setInterval(() => { document.getElementById('btn_refresh').classList.toggle('rotateAnimate'); }, 10000);
                            </script>

                            <div id="selects" class="grid gap-y-4 sm:-ml-20 -ml-16">
                                <div class="flex items-center 
                                            grid grid-cols-5">
                                    <p class="mr-4 defocus text-sm sm:text-md text-right 
                                            col-start-2">
                                        โซนห้องตามสาขา
                                    </p>
                                    <select name="select_branch" id="select_branch"
                                            class="sm:pl-6 text-indigo-900 text-sm w-52 sm:w-full h-8 pl-2 text-black border border-gray-400
                                                    col-start-3 col-span-2" onchange="changeSelectBranch()">
                                        <option disabled value="null">- เลือกสาขา -</option>
                                    </select>
                                </div>
                                <div class="flex items-center
                                            grid grid-cols-5">
                                    <p class="defocus text-sm sm:text text-right mr-4
                                            col-start-2">
                                        เลือกหอพัก
                                    </p>
                                    <select name="select_building" id="select_building" onchange="set_selectFloor()"
                                            class="sm:pl-6 text-indigo-900 text-sm w-52 sm:w-full h-8 pl-2 text-black border border-gray-400
                                                    col-span-2">
                                        <option disabled selected value="null">- เลือกหอ -</option>
                                    </select>
                                </div>
                                <div class="flex items-center 
                                            grid grid-cols-5">
                                    <p class="mr-4 defocus text-sm sm:text text-right
                                                col-start-2">
                                        เลือกชั้น
                                    </p>
                                    <select name="select_floor" id="select_floor" class="sm:pl-6 text-indigo-900 text-sm w-52 sm:w-full h-8 pl-2 text-black border border-gray-400 col-span-2" 
                                            onchange="push_Room()">
                                        <option disabled selected value="null">- เลือกชั้น -</option>
                                    </select>
                                </div>
                            <div>

                        </div>

                        <div class="text-blue-800 -mt-2 pb-4 ml-10 md:ml-20 z-10 text-black w-full text-center text-sm tracking-wide">
                            ชื่อห้องที่มีดอกจัน ( * ) <br class="sm:hidden">หมายถึงห้องรวมสาขา, ทุกสาขาสามารถอยู่ร่วมกันได้
                        </div>
                        
                    </section> <!-- End section -->

                    <section id="not_found_this_rooms" class="hidden pl-2 pr-2 md:pl-10 sm:pl-8 md:pr-10 sm:pr-8 mt-16">
                        <div class="w-full flex justify-center text-lg text-red-800">
                            <p>ไม่พบห้องพัก</p>
                        </div>
                    </section>

                    <section id="section_room" class="hidden pl-2 pr-2 md:pl-10 sm:pl-8 md:pr-10 sm:pr-8 mt-4 mb-20">
                
                        <div id="area_showRoom" class="bg-white rounded-2xl pt-12 pb-12 shadow-md transition-all pl-14 pr-14 text-white
                                    grid xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-y-4 gap-x-4">
                        </div>

                    </section> <!-- End section -->
                </div>
            <div class="space mb-40"></div>

        </div>

    </div>
    
    <form action="#" name="frm_room_book" id="frm_room_book" method="POST" class="hidden absolute flex w-full justify-center">
        <input name="txt_idRoom" id="id_room" type="text" value="" class="">
        <input name="txt_numberRoom" id="number_room" type="text" value="" class="">
        <input name="txt_LimitMember" id="limit_member" type="text" value="" class="">
        <input name="btn_submitBook" type="submit" id="submitBook" value="BtnSubmitBook" class="">
    </form>
    
    <script type="text/javascript" src="./../assets/js/_title_change.js" onload="switchTitle('กางจองห้องพัก')"></script>
    <script type="text/javascript" src="./../assets/js/_adm_select_menu.js" onload="select_menu(6)"></script>
    <script type="text/javascript" src="./../assets/js/_adm_book_manage.js"></script>


    <?php 

        $statusBook = $statusClass->Find('status_id, status_switch, status_date_start, status_date_stop', 'status_name', 'สถานะการจองห้องพัก');
        $statusBook = $statusBook->fetch(PDO::FETCH_ASSOC);

        $array_branch = array();
        $array_building = array();
        $array_floor = array();
        $array_room = array();
        $array_areaBook = array();
        $array_book = array();


        $selectBranch = $branchClass->Select_All('branch_id, branch_name, fac_id');
        while ($value = $selectBranch->fetch(PDO::FETCH_ASSOC)) {
            array_push($array_branch, $value);
        }


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
            setValuesForBook(".json_encode($statusBook).", ".json_encode($array_branch).", ".json_encode($array_building).", ".json_encode($array_floor).", ".json_encode($array_room).", ".json_encode($array_areaBook).", ".json_encode($array_book).");
        </script>";

    ?>


</body>
</html>