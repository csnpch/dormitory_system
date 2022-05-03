<?php 
    session_start();
    
    require_once ('./disable_error_report.php');
    require_once './classes/Student.php';
    require_once './classes/Branch.php';
    require_once './classes/Building.php';
    require_once './classes/Floor.php';
    require_once './classes/Room.php';
    require_once './classes/Book.php';
    require_once './classes/Status.php';

    $stdClass = new Student();
    $branchClass = new Branch();
    $buildingClass = new Building();
    $floorClass = new Floor();
    $roomClass = new Room();
    $bookClass = new Book();
    $statusClass = new Status();

    $statusMain = $statusClass->Find('status_switch', 'status_name', 'system_main');
    $statusMain = $statusMain->fetch(PDO::FETCH_ASSOC);
    if (intval($statusMain['status_switch']) === 1) { header('Location: ./maintenance.php'); }

    if (isset($_SESSION['std_id'])) {
        $dataUser = $stdClass->Find('std_status, std_sex, std_firstname, std_lastname, branch_id, room_id', 'std_id', $_SESSION['std_id']);
        $dataUser = $dataUser->fetch(PDO::FETCH_ASSOC);
        if ($dataUser['room_id'] !== NULL) { echo "<script type='text/javascript'> window.location = 'system_book_report.php'; </script>"; }
    } else {
        header("Location: ./login.php");
    }

?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จองห้องพัก</title>
    <link rel="icon" href="./assets/img/logoKmutnb.webp">
    <link rel="stylesheet" href="./assets/css/tailwind.css">
    <link rel="stylesheet" href="./assets/css/style_x_tailwind.css">
    <link rel="stylesheet" href="./assets/node_modules/daisyui/dist/full.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
<body class="bg-gray-900 overflow-x-hidden">

    <?php 
        if ($dataUser['branch_id'] == 0) {
            echo "<script>
                Swal.fire({
                    title: 'นศ.ยังไม่มีคณะ สาขา',
                    text: 'โปรดเลือกคณะสาขาก่อนทำการจอง !',
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'เข้าใจแล้ว'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = 'system_profile.php';
                    } else {
                        window.location = 'system_profile.php';
                    }
                })
            </script>";
        }
    ?>

    <?php include('./file_link/system_sidebar.php'); ?>

    <div id="areaBook" class="hidden">
       
        <div id="container" class="flex flex-col lg:w-9\/12 lg:ml-64 transition-all bg-gray-100">
            
            <div id="navbar" class="z-20 fixed flex flex-row items-center bg-white h-14 w-full border-b-2 border-gray-200 shadow-sm delay-400 transition-all">
                <div id="menu" class="lg:hidden absolute menuBar ml-4 cursor-pointer z-20">
                    <i class="fas fa-bars"></i>
                </div>
                <div id="title_nav" class="w-full text-center lg:ml-6 lg:-ml-36">
                    <p class="tracking-widest mt-0.5 sm:ml-4 text-lg defocus">
                        <span id="txtNav" class="text-black font_prompt">จองห้องพัก</span>
                    </p>
                </div>
            </div>

            <content class="min-h-screen text-black font_prompt">
                <!-- 2 & 3 -->
                <div id="AutomateSystemBook" class="hidden">
                    <section id="countDown" class="w-11/12 mx-auto text-center bg-white rounded-2xl mt-20 pt-6 pb-8 shadow-md transition-all">
                            <p class="statusTimeoutAutomateSystemBook hidden text-md lg:text-lg">
                                เหลือเวลาที่จะ<span class="text-2xl text-green-800">&nbsp;เปิด&nbsp;<br class="sm:hidden"></span>ให้จองห้องพักในอีก
                            </p> 
                            <p class="statusTimeoutAutomateSystemBook hidden text-md lg:text-lg">
                                เหลือเวลาที่จะ<span class="text-2xl text-red-800">&nbsp;ปิด&nbsp;<br class="sm:hidden"></span>ให้จองห้องพักในอีก
                            </p> 

                        <!-- TIME AREA -->
                        <div class="w-full flex justify-center">
                            <div id="changeColorBorder" class="w-6/12 mt-6 grid grid-cols-2 sm:flex justify-center gap-5 place-items-end auto-cols-max defocus">
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
                        </div>
                    </section>
                </div>

                <!-- 1 & 3 -->
                <div id="ManualSystemBook" class="hidden">
                    <div class="spaceAreaManualSystemBook mb-20"></div>
                    <section  class="pl-2 pr-2 md:pl-10 sm:pl-8 md:pr-10 sm:pr-8">
                        
                        <div class="relative bg-white rounded-2xl pt-8 pb- shadow-md transition-all">

                            <a href="./system_book.php">
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
                                <div class="text-blue-800 mt-2 ml-10 md:ml-20 z-10 text-black sm:w-full text-center text-sm tracking-wide">
                                    ชื่อห้องที่มีดอกจัน ( * ) <br class="sm:hidden">หมายถึงห้องรวมสาขา, <br class="sm:hidden">ทุกสาขาสามารถจองอยู่ร่วมกันได้
                                </div>
                            <div>

                        </div>
                        
                    </section> <!-- End section -->
                </div>
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
            </content>

            <?php include('./file_link/system_footer.php') ?>
        
        </div>

    </div>


    <form action="#" name="frm_room_book" id="frm_room_book" method="POST" class="hidden absolute flex w-full justify-center">
        <input name="txt_idRoom" id="id_room" type="text" value="" class="">
        <input name="txt_numberRoom" id="number_room" type="text" value="" class="">
        <input name="txt_LimitMember" id="limit_member" type="text" value="" class="">
        <input name="btn_submitBook" type="submit" id="submitBook" value="BtnSubmitBook" class="">
    </form>

    <form action="#" method="POST">
        <input id="toggleStatus" name="toggleStatus" type="submit" class="hidden">
        <input type="text" class="hidden" name="5f14ac246f960a3173a16561d243a8f5b07cfcec5c787f09de52f318d746c833" id="5f14ac246f960a3173a16561d243a8f5b07cfcec5c787f09de52f318d746c833">
        <input type="submit" name="3c4ce757715a8b7fa461fcbf6cc91310d69661b3f7359d9992eff6217b8f6390" id="3c4ce757715a8b7fa461fcbf6cc91310d69661b3f7359d9992eff6217b8f6390" class="hidden">
    </form>
    

    <script src="./assets/js/_title_change.js" onload="switchTitle('จองห้องพัก');"></script>
    <script src="./assets/js/_system_sidebar.js"></script>
    <script src="./assets/js/_system_book.js"></script>
    <script type="text/javascript">
        document.getElementsByClassName("list-item")[0].style.listStyle = 'none';
    </script>

</body>
</html>

<?php


    $statusBook = $statusClass->Find('status_id, status_switch, status_date_start, status_date_stop', 'status_name', 'system_book');
    $statusBook = $statusBook->fetch(PDO::FETCH_ASSOC);
    
    if (isset($_POST['3c4ce757715a8b7fa461fcbf6cc91310d69661b3f7359d9992eff6217b8f6390'])) {
        $statusBookForUpdate = 0;
        if (intval($statusBook['status_switch']) === 2) { $statusBookForUpdate = 3; }
        else if (intval($statusBook['status_switch']) === 3) { $$statusBookForUpdate = 0; }

        if (intval($_POST['5f14ac246f960a3173a16561d243a8f5b07cfcec5c787f09de52f318d746c833']) <= 0) {
            if ($statusClass->Update_Switch($statusBook['status_id'], $statusBookForUpdate)) {
                echo "<script type='text/javascript'>window.location.href = './system_book.php';</script>";
            }
        } else {
            header("Location: ./system_book.php");
        }

    }

    if (intval($statusBook['status_switch']) === 2) {
        echo "<script type='text/javascript'>
            callDateRange(1, '".strval($statusBook['status_date_start'].' - '.$statusBook['status_date_stop'])."');
            document.getElementById('changeColorBorder').classList.add('border-b-2');
            document.getElementById('changeColorBorder').classList.add('border-green-600'); 
        </script>"; // send 1 is active , 0 is deactive
    } else if (intval($statusBook['status_switch']) === 3) {
        echo "<script type='text/javascript'>
            callDateRange(0, '".strval($statusBook['status_date_start'].' - '.$statusBook['status_date_stop'])."');
            document.getElementById('changeColorBorder').classList.add('border-b-2');
            document.getElementById('changeColorBorder').classList.add('border-red-500'); 
        </script>";
    }


    $findFac = $branchClass->Find('fac_id', 'branch_id', $dataUser['branch_id']);
    $facUser = $findFac->fetch(PDO::FETCH_ASSOC);


    $array_dataUser = array($dataUser, $facUser);
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


    $selectAreaBook = $bookClass->Select_All('branch_id, room_id');
    while ($value = $selectAreaBook->fetch(PDO::FETCH_ASSOC)) {
        array_push($array_areaBook, $value);
    }

        
    $selectBook = $roomClass->bookRelation();
    while ($value = $selectBook->fetch(PDO::FETCH_ASSOC)) {
        array_push($array_book, $value);
    }

    echo "<script type='text/javascript'>
        setValuesForBook(".json_encode($statusBook).", ".json_encode($array_dataUser).", ".json_encode($array_branch).", ".json_encode($array_building).", ".json_encode($array_floor).", ".json_encode($array_room).", ".json_encode($array_areaBook).", ".json_encode($array_book).");
    </script>";


    if (isset($_POST['btn_submitBook'])) {

        $selectDataStd = $stdClass->Find('std_id', 'room_id', $_POST['txt_idRoom']);
        $count = $stdClass->Count_memberRoom($_POST['txt_idRoom']);
        $count = $count->fetch(PDO::FETCH_ASSOC);

        if ($count['RESULT'] < intval($_POST['txt_LimitMember'])) {
            
            if ($stdClass->Update_Select(array('room_id'), array($_POST['txt_idRoom']), 'std_id', $_SESSION['std_id'])) {
                echo "<script>
                    Swal.fire({
                        title: 'จองห้องพักสำเร็จ',
                        text: 'ระบบกำลังพาท่านไปยังขั้นตอนต่อไป',
                        icon: 'success',
                        showConfirmButton: false,
                        showCancelButton: false
                    }).then(setTimeout(() => {
                        window.location.href='system_book_report.php';
                    }, 3000)); 
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'เกิดข้อผิดพลาดในการจอง',
                        text: 'โปรดลองใหม่! หรือติดต่อเจ้าหน้าที่',
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'ปิด'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = 'system_book_report.php';
                        }
                    })
                </script>";
            }
        
        } else {
            echo "<script>
                Swal.fire({
                    title: 'ห้อง '+ ".$_POST['txt_numberRoom']." +' เต็มแล้ว',
                    text: 'อาจมีคนจองก่อนคุณ! โปรดตรวจสอบห้องพักอีกครั้ง',
                    icon: 'error',
                    showConfirmButton: false,
                    showCancelButton: false
                }).then(setTimeout(() => {
                    get_select_option_book(0);
                }, 3000)); 
            </script>";
        }

    }


?>