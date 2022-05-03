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

    $buildingClass = new Building();
    $floorClass = new Floor();
    $roomClass = new Room();
    $studentClass = new Student();
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการข่าวสารหอพัก</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <link rel="stylesheet" href="../assets/css/style_x_tailwind.css">
    <link rel="icon" href=" ../assets/img/logoKmutnb.webp">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../assets/node_modules/daisyui/dist/full.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body class="font_prompt">

    <?php
        
        if (isset($_GET['dorm_id'])) {
            $dataDorm = $buildingClass->Find('building_id, building_name, building_gender', 'building_id', $_GET['dorm_id']);
            $dataDorm = $dataDorm->fetch(PDO::FETCH_ASSOC);
        }

    ?>

    <script type="text/javascript">
        function select_option(id, val) {
            document.getElementById(id).value = val;
        }
    </script>

    <div class="flex">
        <!-- Sidebar -->
        <?php include ('./adm_file_link/sidebar.php'); ?>
        <!-- Navbar -->
        <div id="main" class="flex flex-col w-full lg:w-11/12 ml-0 lg:ml-64 trasition-all duration-300 bg-gray-100 h-min-screen">
            <?php include ('./adm_file_link/navbar.php'); ?>

            <!-- Content -->
            <!-- SESSION -->
            <div class="h-screen">

                <session id="showData" class="grid md:grid-cols-2 w-min-screen justify-center mt-4 sm:mt-8 ml-4 md:ml-8 mr-4 md:mr-8 pr-4 pl-4 bg-primary-content rounded-md shadow-md">

                    <div class="absolute text-left breadcrumbs m-2 ml-6 sm:ml-4 tracking-wide" style="font-size: 0.8rem;">
                        <ul>
                            <li>
                                <i class="fas fa-city mr-2"></i>
                                <a href="./dorm_manage.php">
                                    ข้อมูลสิ่งปลูกสร้าง
                                </a>
                            </li> 
                            <li>
                                <i class="fas fa-building mr-2"></i>
                                <a href="./sub_dorm_manage.php?dorm_id=<?php echo $_GET['dorm_id'] ?>">
                                    จัดการข้อมูลภายใน
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="p-4 mb-14 lg:mb-24 md:mb-0 flex flex-col items-center mt-16 -pb-0 md:pb-10">
                        <p class="pt-4 text-xl sm:text-2xl">คุณกำลังจัดการข้อมูลของ</p>
                        <p id="showNameBuilding" class="pt-4 text-xl text-red-700 sm:text-3xl">"&nbsp;<?php echo $dataDorm['building_name']; ?>&nbsp;"</p>
                        <form name="editName" method="POST" class="flex flex-col items-center">
                            <input name="txt_nameBuilding" class="hidden text-xl sm:text-2xl text-center mt-4 border-black w-60 text-red-700" type="text" 
                                    value="<?php echo $dataDorm['building_name']; ?>">
                            <select disabled required type="text" name="select_building_status" id="select_building_status" class="h-10 p-2 mt-2 text-md" placeholder="เลือกสถานะ">
                                <option value="" disabled>เลือกประเภท</option>
                                <option value="2">หอพักทั่วไป</option>
                                <option value="0">หอพักชาย</option>
                                <option value="1">หอพักหญิง</option>
                            </select>
                            <?php 
                                echo "<script type='text/javascript'>select_option('select_building_status', ".$dataDorm['building_gender'].")</script>";
                            ?>
                            <input id="btn_saveNameBuilding" name="btn_editName" type="submit" value="บันทึก" class="cursor-pointer hidden w-28 p-1 text-white text-md rounded-lg bg-green-600 m-4">
                        </form>
                        <button id="btn_editNameBuilding" class="w-28 p-1 text-white text-md rounded-lg bg-indigo-600 mt-6">แก้ไข</button>
                    </div>

                    <div class="flex flex-col justify-start changeWidth lg:border-l-2 lg:border-yellow-100 sm:pl-10 sm:p-4 mb-4 -mt-10 md:mt-0">
                        <div class="flex flex-col md:flex-row mb-4 mb-4 md:mb-2 md:justify-between">
                            <p class="text-xl -mb-2 lg:mb-4 mt-4 w-full text-center md:text-left sm:mt-6">ข้อมูลภายในอาคาร</p>
                            <div class="relative font_kanit">
                                <button id="add_item" class="relative w-full sm:w-32 flex flex-row btn btn-xs sm:btn-sm btn-success text-sm mt-5">
                                    <i class="far fa-plus-square text-white pl-2"></i>
                                    <span class="ml-2 mr-2">เพิ่มข้อมูล</span>
                                </button>
                                <div id="popup_addItem" class="hidden w-full">
                                    <div class="absolute artboard artboard-demo bg-base-200">
                                        <ul class="z-20 menu p-2 shadow-lg bg-white rounded-box">
                                            <li class="menu-title w-full sm:w-40 mb-1">
                                                <span>เลือกสิ่งที่ต้องการเพิ่ม</span>
                                            </li> 
                                            <li class="mb-1">
                                                <button id="floor_add_item" class="btn btn-sm btn-info">
                                                    เพิ่มชั้น
                                                </button>
                                            </li> 
                                            <li>
                                                <button id="room_add_item" class="btn btn-sm btn-error">
                                                    เพิ่มห้องพัก
                                                </button>
                                            </li> 
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            $dataRoom = NULL;
                            $check_room = NULL;
                            $i = 0;
                            $dataFloor = $floorClass->Find_Sort('floor_id, floor_name', 'building_id', $_GET['dorm_id'], 'floor_name ASC', '');
                            while ($valueFloor = $dataFloor->fetch(PDO::FETCH_ASSOC)):
                        ?>
                            <div class="floor item_floor bg-gray-100 cursor-pointer hover:bg-gray-200">
                                <div class="p-3 ml-4 flex justify-between border-opacity-40">
                                    <div class="flex flex-row pr-20 sm:pr-72" onclick="toggleRoomShow(<?php echo ($i); ?>)">
                                        <p class="w-14"><?php echo $valueFloor['floor_name']; ?></p>
                                        <i class="fas fa-angle-down fa-sm transform rotate-90 trasition-all duration-300"></i>
                                    </div>
                                    <form name="frm_floor" action="#" method="POST">
                                        <div class="flex flex-row gap-x-4 main_tools mr-0 md:mr-4">
                                            <div onclick="editFloorRoom(this, 0)">
                                                <input class="floor_id" name="txt_floor_id" type="text" value="<?php echo ($valueFloor['floor_id']) ?>" style="display: none;">
                                                <input class="floor_name" name="txt_floor_name" type="text" value="<?php echo ($valueFloor['floor_name']) ?>" style="display: none;">
                                                <i class="fas fa-pencil-alt text-indigo-600"></i>
                                            </div>
                                            <div onclick="confirm_delete(this, 0, <?php echo $i; ?>)">
                                                <input name="floor_id_del" type="text" value="<?php echo ($valueFloor['floor_id']) ?>" style="display: none;">
                                                <input class="nameDel" name="floor_name_del" type="text" value="<?php echo ($valueFloor['floor_name']) ?>" style="display: none;">
                                                <i class="fas fa-trash-alt text-red-700"></i>
                                            </div>
                                            <input class="btn_del_floor" name="floor_submit_del" type="submit" style="display: none;">
                                        </div>
                                    </form>
                                </div>
                                <div class="room bg-gray-50 hidden">
                                    <?php
                                        $indexRoom = 0;
                                        $check_room = 0;
                                        $dataRoom = $roomClass->Find_Sort('room_id, room_name, room_member, room_status', 'floor_id', $valueFloor['floor_id'], 'room_name ASC', '');
                                        while ($valueRoom = $dataRoom->fetch(PDO::FETCH_ASSOC)):
                                            $countMember = $studentClass->Count_memberRoom($valueRoom['room_id']);
                                            $countMember = $countMember->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                            <div class="flex justify-between hover:bg-gray-100 text-sm font_kanit">
                                                <div>
                                                <?php
                                                    if ($valueRoom['room_status'] != '0') {
                                                        echo "<p class='relative pl-20 p-2 tracking-widest text-green-800'>";
                                                    } else {
                                                        echo "<p class='relative pl-20 p-2 tracking-widest text-red-700'>";
                                                    }
                                                ?>
                                                    <?php 
                                                        echo $valueRoom['room_name'];
                                                        if (intval($countMember['RESULT']) < intval($valueRoom['room_member'])):
                                                    ?>
                                                            <span class='absolute sm_hidden w-full -right-40 text-xs mt-0.5 text-green-800'>
                                                    <?php 
                                                        else:
                                                    ?>
                                                            <span class='absolute sm_hidden w-full -right-40 text-xs mt-0.5 text-red-700'>
                                                    <?php 
                                                        endif;
                                                    ?>
                                                            <?php echo $countMember['RESULT'].'/'.$valueRoom['room_member']; ?>
                                                        </span>
                                                    </p>
                                                </div>
                                                <form name="frm_room" action="#" method="POST">
                                                    <div class="tools_room flex flex-row pr-4 sm:pr-20 mt-2">
                                                        <div onclick="editFloorRoom(this, 1)">
                                                            <input class="hidden floor_id_only" name="txt_floor_id" type="text" value="<?php echo ($valueFloor['floor_id']) ?>">
                                                            <input class="hidden floor_room_id" name="txt_room_id" type="text" value="<?php echo ($valueRoom['room_id']) ?>">
                                                            <input class="hidden floor_room_name" name="txt_room_name" type="text" value="<?php echo ($valueRoom['room_name']) ?>">
                                                            <input class="hidden room_member" name="txt_room_member" type="text" value="<?php echo ($valueRoom['room_member']) ?>">
                                                            <input class="hidden room_status" name="txt_room_status" type="text" value="<?php echo ($valueRoom['room_status']) ?>">
                                                            <i class="fas fa-pencil-alt text-indigo-600"></i>
                                                        </div>
                                                        <div onclick="confirm_delete(this, 1, <?php echo $indexRoom; ?>, <?php echo $i ?>)">
                                                            <input name="room_id_del" type="text" value="<?php echo ($valueRoom['room_id']) ?>" style="display: none;">
                                                            <input class="nameDel" name="room_name_del" type="text" value="<?php echo ($valueRoom['room_name']) ?>" style="display: none;">
                                                            <i class="ml-2 p-1 fa-sm fas fa-trash-alt text-red-700"></i>
                                                        </div>
                                                        <input class="btn_del_room" name="room_submit_del" type="submit" style="display: none;">
                                                    </div>
                                                </form>
                                            </div>
                                    <?php
                                            $indexRoom++;
                                            $check_room++;
                                        endwhile;
                                        if ($check_room <= 0)
                                            echo "<p class='ml-6 sm:ml-20 p-2 text-sm sm:text-md'>ยังไม่มีข้อมูลห้องพักในชั้นนี้</p>";
                                    ?>
                                </div>
                            </div>
                        <?php
                                $i++;
                            endwhile;
                            if ($i <= 0)
                                echo "<p class='ml-36 mt-24 p-2 text-red-800'>ยังไม่มีข้อมูล</p>";
                        ?>
                    </div>

                    <div class="sm:fixed bottom-10 flex justify-center col-span-full">
                        <a href="./dorm_manage.php" class="btn btn-sm mb-4"><i class="fas fa-chevron-left mr-2"></i>กลับหน้าจัดการ</a>
                    </div>

                    <div class="space"></div>

                    <div class="arrow_go_up fixed bottom-10 right-20 hidden cursor-pointer">
                        <i onclick="goUp()" class="fa-2x fas fa-chevron-circle-up"></i>
                    </div>

                </session>

            </div>

            <?php 
                $dataFloor = $floorClass->Find('floor_id, floor_name', 'building_id', $_GET['dorm_id']); 
                $valueFloor = NULL;
            ?>
            
            <div id="edit_room" class="hidden z-20 fixed flex justify-center items-center w-full lg:tailwind h-screen">
                <form name="frm_edit_floor" action="#" method="POST">
                    <div id="change_name_floor" class="bg-gray-100 p-4 font_kanit rounded-lg hidden">
                        <p class="mt-4 mb-6 text-black font-lg text-center text-lg">แก้ไขข้อมูลชั้น</p>
                        <input type="text" name="txt_floor_id" class="hidden h-10 p-2 pl-3 mt-2 text-md">
                        <p class="text-red-800 font-lg">แก้ไขชื่อชั้น</p>
                        <input required type="text" name="txt_floor_name" class="h-10 p-2 pl-3 mt-2 text-md">
                        <div class="change_name_floor grid grid-cols-2 mt-4 gap-x-1">
                            <button name="btn_edit_floor" class="btn btn-success btn-sm">เปลี่ยนชื่อ</button>
                            <div class="cancleEditFloor btn btn-error btn-sm">ยกเลิก</div>
                        </div>
                    </div>
                </form>
                <form name="frm_edit_room" action="#" method="POST">
                    <div id="change_name_room" class="bg-gray-100 p-4 font_kanit rounded-lg hidden">
                        <p class="mt-4 mb-6 text-black font-lg text-center text-lg">แก้ไขข้อมูลห้องพัก</p>
                        <input type="text" name="txt_floor_only_id" class="hidden h-10 p-2 pl-3 mt-2 text-md">
                        <input type="text" name="txt_room_id" class="hidden h-10 p-2 pl-3 mt-2 text-md">
                        <p class="text-red-800 font-lg">แก้ไขชื่อห้อง</p>
                        <input required type="text" name="txt_room_name" class="h-10 p-2 pl-3 mt-2 text-md">
                        <p class="mt-2 text-red-800 font-lg">จำนวนที่รองรับได้</p>
                        <input required type="number" name="txt_room_member" class="h-10 p-2 pl-3 mt-2 text-md w-full">
                        <p class="mt-3 text-red-800 font-lg">ชั้นของห้อง</p>
                        <select name="select_floor" class="w-full p-1.5">
                        <?php while($valueFloor = $dataFloor->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $valueFloor['floor_id'] ?>"><?php echo $valueFloor['floor_name']; ?></option>
                        <?php endwhile; ?>
                        </select>
                        <p class="mt-3 text-red-800 font-lg mb-1">สถานะห้อง</p>
                        <select name="select_status" class="w-full p-1.5">
                            <option value="0">ปิดใช้งานห้อง</option>
                            <option value="1">เปิดใช้งานห้อง</option>
                        </select>
                        <div class="change_name_floor grid grid-cols-2 mt-4 gap-x-1">
                            <button name="btn_edit_room" class="btn btn-success btn-sm">บันทึก</button>
                            <div class="cancleEditFloor btn btn-error btn-sm">ยกเลิก</div>
                        </div>
                    </div>
                </form>
            </div>

            <?php 
                $dataFloor = $floorClass->Find('floor_id, floor_name', 'building_id', $_GET['dorm_id']); 
                $valueFloor = NULL;
                $i = 0;
            ?>

            <div class="add_item_floor_room hidden z-20 fixed flex justify-center items-center w-full lg:w-10/12 h-screen">
                <form name="zone_add_item_floor" action="#" method="POST">
                    <div class="add_item_floor bg-gray-100 p-4 font_kanit rounded-lg hidden">
                        <p class="mt-4 mb-6 text-black font-lg text-center text-lg">เพิ่มชั้นในอาคาร</p>
                        <p class="text-red-800 font-lg">ชื่อชั้น</p>
                        <input required type="text" name="txt_floor_name" class="h-10 p-2 pl-3 mt-2 text-md tracking-widest" placeholder="ชั้น 0">
                        <div class="change_name_floor grid grid-cols-2 mt-4 gap-x-1">
                            <button name="btn_add_floor" class="btn btn-success btn-sm">เพิ่มข้อมูล</button>
                            <div class="cancleAddItem btn btn-error btn-sm">ยกเลิก</div>
                        </div>
                    </div>
                </form>
                <form name="zone_add_item_room" action="#" method="POST">
                    <div class="add_item_room bg-gray-100 p-4 font_kanit rounded-lg hidden">
                        <p class="mt-4 mb-6 text-black font-lg text-center text-lg">เพิ่มห้องพัก</p>
                        <p class="mt-2 mb-1.5 text-red-800 font-lg">เลือกชั้น</p>
                        <select required name="select_floor" class="p-2 w-full">
                        <?php 
                            while($valueFloor = $dataFloor->fetch(PDO::FETCH_ASSOC)): 
                        ?>
                            <option value="<?php echo $valueFloor['floor_id'] ?>"><?php echo $valueFloor['floor_name']; ?></option>
                        <?php
                                $i++; 
                            endwhile; 
                            if ($i < 1) {
                                echo ("<option disabled class='p-4 text-xl text-red-700'>กรุณาเพิ่มชั้นก่อน</option>");
                            }
                        ?>
                        </select>
                        <p class="text-red-800 font-lg mt-4">ชื่อห้องพัก</p>
                        <input required type="text" name="txt_room_name" placeholder="E999" class="h-10 p-2 pl-3 mt-2 text-md tracking-widest">
                        <p class="mt-4 text-red-800 font-lg">จำนวนที่รองรับได้</p>
                        <input required type="number" min="0" placeholder="0" name="txt_room_member" class="h-10 p-2 pl-3 mt-2 text-md">
                        <div class="change_name_floor grid grid-cols-2 mt-4 gap-x-1">
                            <button name="btn_add_room" class="btn btn-success btn-sm">เพิ่มข้อมูล</button>
                            <div class="cancleAddItem btn btn-error btn-sm">ยกเลิก</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="overlay fixed hidden z-10 w-full h-full bg-black opacity-30"></div>

        </div>

    </div>
    
    
    <script type="text/javascript" src="../assets/js/_title_change.js" onload="switchTitle('จัดการข่าวสารหอพัก')"></script>
    <script type="text/javascript" src="../assets/js/_adm_select_menu.js" onload="select_menu(3)"></script>
    <script type="text/javascript" src="../assets/js/_adm_sub_dorm_manage.js"></script>
    <script type="text/javascript" src="../assets/js/_adm_dashboard.js"></script>

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
                            window.location.href='./sub_dorm_manage.php?dorm_id={$_GET['dorm_id']}';
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
    
        if (isset($_POST['btn_editName'])) {
            if ($buildingClass->Update($_GET['dorm_id'], $_POST['txt_nameBuilding'], $_POST['select_building_status'])) {
                alertPopup(1, 'เปลี่ยนชื่อสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['btn_add_floor'])) {
            if ($floorClass->Insert($_GET['dorm_id'], $_POST['txt_floor_name'])) {
                alertPopup(1, 'เพิ่มข้อมูลสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['btn_add_room'])) {
            if ($roomClass->Insert($_POST['select_floor'], $_POST['txt_room_name'], $_POST['txt_room_member'])) {
                alertPopup(1, 'เพิ่มข้อมูลสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['btn_edit_floor'])) {
            if ($floorClass->Update($_POST['txt_floor_id'], $_GET['dorm_id'], $_POST['txt_floor_name'])) {
                alertPopup(1, 'เปลี่ยนชื่อสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['btn_edit_room'])) {
            if ($roomClass->Update($_POST['txt_room_id'], $_POST['select_floor'], $_POST['txt_room_name'], $_POST['txt_room_member'], $_POST['select_status'])) {
                alertPopup(1, 'แก้ไขข้อมูลสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['floor_submit_del'])) {
            if ($floorClass->Delete($_POST['floor_id_del'])) {
                alertPopup(1, 'ลบข้อมูลสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['room_submit_del'])) {
            if ($roomClass->Delete($_POST['room_id_del'])) {
                alertPopup(1, 'ลบข้อมูลสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        }    
    ?>

</body>
</html>