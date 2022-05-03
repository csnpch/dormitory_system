<?php 
    session_start();
    
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
    <script src="./assets/js/_system_book.js"></script>

    <style>
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
<body class="bg-gray-900">

    <?php include('./file_link/system_sidebar.php'); ?>

    <?php 
        if (isset($_SESSION['std_id'])) {
            $dataStd = $stdClass->Find('std_status, std_sex, std_firstname, std_lastname, branch_id, room_id', 'std_id', $_SESSION['std_id']);
            $dataStd = $dataStd->fetch(PDO::FETCH_ASSOC);
            if ($dataStd['room_id'] !== NULL) { echo "<script type='text/javascript'> window.location = 'system_book_report.php'; </script>"; }
        }
        
        $statusBook = $statusClass->Find('status_id, status_switch, status_date_start, status_date_stop', 'status_name', 'สถานะการจองห้องพัก');
        $statusBook = $statusBook->fetch(PDO::FETCH_ASSOC);
    ?>

    <div id="areaBook" class="hidden">
       
        <div id="container" class="flex flex-col lg:w-9\/12 lg:ml-64 transition-all bg-gray-100">
            
            <div id="navbar" class="z-20 fixed flex flex-row items-center bg-white h-14 w-full border-b-2 border-gray-200 shadow-sm
                                                delay-400 transition-all">
                    <div id="menu"  class="lg:hidden absolute menuBar ml-4 cursor-pointer z-20">
                        <i class="fas fa-bars"></i>
                    </div>
                    <div id="title_nav"     class="w-full text-center lg:ml-6 lg:-ml-36">
                        <p class="tracking-widest mt-0.5 sm:ml-4 text-lg defocus">
                            <span id="txtNav" class="text-black font_prompt">จองห้องพัก</span>
                        </p>
                    </div>
            </div>

            <content class="min-h-screen text-black font_prompt">
            <?php if ($statusBook['status_switch'] === '1'): ?>
                <div class="space mb-20"></div>
            <?php endif; ?>

                <!-- 2 & 3 -->
            <div id="AutomateSystemBook" class="hidden">
                <section id="countDown" class="w-11/12 mx-auto text-center bg-white rounded-2xl mt-20 pt-6 pb-8 mb-6 shadow-md transition-all pl-14 pr-14">
                    <?php if($statusBook['status_switch'] === '2'): ?>
                        <p class="text-md lg:text-lg">เหลือเวลาที่จะ<span class="text-2xl text-green-800">&nbsp;เปิด&nbsp;<br class="sm:hidden"></span>ให้จองห้องพักในอีก</p> 
                    <?php elseif($statusBook['status_switch'] === '3'): ?>
                        <p class="text-md lg:text-lg">เหลือเวลาที่จะ<span class="text-2xl text-red-800">&nbsp;ปิด&nbsp;<br class="sm:hidden"></span>ให้จองห้องพักในอีก</p> 
                    <?php endif; ?>

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
                <section  class="pl-2 pr-2 md:pl-10 sm:pl-8 md:pr-10 sm:pr-8">
                    
                    <div class="bg-white rounded-2xl pt-8 pb-4 shadow-md transition-all">

                        <div id="selects" class="grid gap-y-4 sm:-ml-20 -ml-16">
                            <div class="flex items-center 
                                        grid grid-cols-5">
                                <p class="mr-4 defocus text-sm sm:text-md text-right 
                                        col-start-2">
                                    โซนห้องตามสาขา
                                </p>
                                <select name="select_branch" id="select_branch" 
                                        class="sm:pl-6 text-indigo-900 text-sm w-52 sm:w-full h-8 pl-2 text-black border border-gray-400
                                                col-start-3 col-span-2" onchange="get_select_option_book(0);">
                                    <option value="0" disabled>- เลือกสาขา -</option>
                                    <?php 
                                        $findFac = $branchClass->Find('fac_id', 'branch_id', $dataStd['branch_id']);
                                        $facStd = $findFac->fetch(PDO::FETCH_ASSOC);
                                        $select_branch = $branchClass->Select_All('branch_id, branch_name, fac_id');
                                        while ($value = $select_branch->fetch(PDO::FETCH_ASSOC)) {
                                            if ($value['fac_id'] == $facStd['fac_id'])
                                                echo "<option value=".$value['branch_id'].">".$value['branch_name']."</option>";
                                        }
                                    ?>
                                    <option value="999">- ภาพรวมทุกคณะ & สาขา -</option>
                                </select>
                            </div>
                            <div class="flex items-center
                                        grid grid-cols-5">
                                <p class="defocus text-sm sm:text text-right mr-4
                                        col-start-2">
                                    เลือกหอพัก
                                </p>
                                <select name="select_building" id="select_building" onchange="get_select_option_book(1);" 
                                        class="sm:pl-6 text-indigo-900 text-sm w-52 sm:w-full h-8 pl-2 text-black border border-gray-400
                                                col-span-2">
                                    <option value="0">- เลือกหอ -</option>
                                    <?php 
                                        $selectBuilding = $buildingClass->Select_All('building_id, building_name');
                                        while ($value = $selectBuilding->fetch(PDO::FETCH_ASSOC)) {
                                            if($dataStd['std_sex'] == 0 && $value['building_id'] == 1)
                                                echo "<option value=".$value['building_id'].">".$value['building_name']."</option>";
                                            else if ($dataStd['std_sex'] > 0 && $value['building_id'] != 1)
                                                echo "<option value=".$value['building_id'].">".$value['building_name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="flex items-center 
                                        grid grid-cols-5">
                                <p class="mr-4 defocus text-sm sm:text text-right
                                            col-start-2">
                                    เลือกชั้น
                                </p>
                                <select name="select_floor" id="select_floor" class="sm:pl-6 text-indigo-900 text-sm w-52 sm:w-full h-8 pl-2 text-black border border-gray-400 col-span-2" 
                                        onchange="get_select_option_book(2);">
                                    <option value="0">- เลือกชั้น -</option>
                                    <?php 
                                        $actual_link = "$_SERVER[REQUEST_URI]";
                                        $components = parse_url($actual_link);
                                        parse_str($components['query'], $parameter);

                                        $selectFloor = $floorClass->Select_All('building_id, floor_id, floor_name');
                                        while ($value = $selectFloor->fetch(PDO::FETCH_ASSOC)) {
                                            if($value['building_id'] == strval($parameter['building']))
                                                echo "<option value=".$value['floor_id'].">".$value['floor_name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        <div>

                    </div>
                    
                </section> <!-- End section -->

                <section id="section_room" class="hidden pl-2 pr-2 md:pl-10 sm:pl-8 md:pr-10 sm:pr-8 mt-4 mb-20">
            
                    <div class="bg-white rounded-2xl pt-12 pb-12 shadow-md transition-all pl-14 pr-14 text-white
                                grid xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-y-4 gap-x-4">
                            
                        <?php
                            // Defind variabe 1
                            $nRoom = 0;
                            $status = FALSE;
                            $statusRoomOfFloor = TRUE;
                            $roomOfBranchArray = array();

                            // Defind variabe 2
                            $nUnitPerson = 0;
                            $findBranch = NULL;

                            $selectBook = $bookClass->Find('room_id', 'branch_id', $parameter['branch']);
                            $selectRoom = $roomClass->Select_All('floor_id, room_id, room_name, room_member, room_status');
                            if ($parameter['branch'] == '999') {
                                while ($room = $selectRoom->fetch(PDO::FETCH_ASSOC)) {
                                    array_push($roomOfBranchArray, $room['room_id']);
                                    $status = TRUE;
                                }
                            } else {
                                while ($room = $selectBook->fetch(PDO::FETCH_ASSOC)) {
                                    array_push($roomOfBranchArray, $room['room_id']);
                                    $status = TRUE;
                                }
                            }

                            if ($status):
                                $selectRoom = $roomClass->Select_Order('floor_id, room_id, room_name, room_member, room_status', 'room_name', 'ASC');
                                while ($value = $selectRoom->fetch(PDO::FETCH_ASSOC)):
                                    foreach ($roomOfBranchArray as $roomBranch):
                                        if ( (($value['floor_id'] === $parameter['floor']) && 
                                            ($value['room_id'] === $roomBranch) && 
                                            ($value['room_status'] === '1')) // 1 is room active
                                        ):
                                            $nUnitPerson = 0;
                                            $statusRoomOfFloor = FALSE;
                        ?>
                                            <div class="room relative w-full h-20 text-right rounded-lg cursor-pointer transition-all duration-400"
                                                    onclick="showRoomBook(this,<?php echo $value['room_id']; ?>)">
                                                <p class="defocus tracking-tighter mr-2 mt-2 text-sm font_kanit font-light">
                                                    <span class="unitPerson"></span>
                                                    <span class="">/</span>
                                                    <span class="limitMember"><?php echo $value['room_member']; ?></span>
                                                </p>
                                                <p class="numberRoom flex w-full justify-center items-center -mt-1 text-3xl font_kanit tracking-widest">
                                                    <?php echo $value['room_name']; ?>
                                                </p>

                                                <div class="dropdown-room z-20 hidden font-medium absolute w-60 text-sm mt-5 pt-3 pb-1 shadow-2xl">
                                                    <ul>
                                                        <?php 
                                                            $selectDataStd = $stdClass->Find('std_id, std_firstname, std_lastname, branch_id', 'room_id', $value['room_id']);
                                                            while ($valueStd = $selectDataStd->fetch(PDO::FETCH_ASSOC)):
                                                                $findBranch = $branchClass->Find('branch_name', 'branch_id', $valueStd['branch_id']);
                                                                $findBranch = $findBranch->fetch(PDO::FETCH_ASSOC);
                                                                $nUnitPerson++;
                                                        ?>
                                                                <li class="flex items-center justify-between ml-4 mr-4 mb-2">
                                                                    <span class="text_fullname"><?php echo $valueStd['std_firstname'].' '.$valueStd['std_lastname']; ?></span>
                                                                    <span class="text_branch"><?php echo str_replace(array('(',')'), "", explode(" ", $findBranch['branch_name'])[1]); ?></span>
                                                                </li>
                                                        <?php 
                                                            endwhile; 
                                                        ?>
                                                    </ul>
                                                </div>

                                            </div>
                        <?php
                                            echo ("<script type='text/javascript'>setStatusRoom('".$nRoom."','".$nUnitPerson."')</script>");
                                            $nRoom++;
                                        endif;
                                    endforeach;
                                endwhile;
                            endif;
                            if ($statusRoomOfFloor) { echo ("<p class='text-red-800 text-lg text-center col-span-full'>ไม่พบห้องพัก</p>"); }
                        ?>

                    </div>

                </section> <!-- End section -->
            </div>

            <?php 
                if($statusBook['status_switch'] === '2' || $statusBook['status_switch'] === '3') {
                    echo "<script type='text/javascript'>
                        document.getElementById('AutomateSystemBook').classList.remove('hidden');
                        document.getElementById('areaBook').classList.remove('hidden');
                    </script>";
                }
                if($statusBook['status_switch'] === '1' || $statusBook['status_switch'] === '3') {
                    echo "<script type='text/javascript'>
                        document.getElementById('ManualSystemBook').classList.remove('hidden');
                        document.getElementById('areaBook').classList.remove('hidden');
                    </script>";
                } 
                // if ($statusBook['status_switch'] === '1' || $statusBook['status_switch'] === '2' || $statusBook['status_switch'] === '3') {
                //     echo "<script type='text/javascript'>
                //         document.getElementById('areaBook').classList.remove('hidden');
                //     </script>";
                // }

                // Change switch_dorm
                if (isset($_POST['toggleStatus'])) {
                    if ($statusBook['status_switch'] === '2') {
                        $statusToggleBook = '3';
                    } else if ($statusBook['status_switch'] === '3') {
                        $statusToggleBook = '0';
                    }

                    if(!$statusClass->Update_Switch($statusBook['status_id'], $statusToggleBook)) {
                        echo "<script type='text/javascript'>
                            Swal.fire({
                                title: 'ระบบเกิดข้อผิดพลาด',
                                text: 'กรุณาติดต่อเจ้าหน้าที่!',
                                icon: 'error',
                                showConfirmButton: false,
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                cancelButtonText: 'ปิด'
                            })
                        </script>";
                    } else {
                        echo "<script type='text/javascript'>window.location.href = './system_book.php?branch=".$dataStd['branch_id']."&building=0&floor=0';</script>";
                    }
                }

                // Set default standata php control
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
                } else if($statusBook['status_switch'] === '1' || $statusBook['status_switch'] === '3') {
                    
                    $findBranchStd = $branchClass->Find('branch_name', 'branch_id', $dataStd['branch_id']);
                    $branchStd = $findBranchStd->fetch(PDO::FETCH_ASSOC);

                    $select_branch = $branchClass->Select_All('branch_id, branch_name');
                    while ($value = $select_branch->fetch(PDO::FETCH_ASSOC)) {
                        if ($branchStd['branch_name'] == $value['branch_name'])
                            echo "<script>document.getElementById('select_branch').value = '".$value['branch_id']."';</script>";
                    }

                    if(!isset($_SESSION['firstSelectBook'])) {
                        $_SESSION['firstSelectBook'] = FALSE;
                        echo "<script>
                                document.getElementById('select_building').value = '0';
                                document.getElementById('select_floor').value = '0';
                                get_select_option_book(0);
                            </script>";
                    } else {
                        echo "<script>
                            document.getElementById('select_branch').value = {$parameter['branch']};
                            document.getElementById('select_building').value = {$parameter['building']};
                            document.getElementById('select_floor').value = {$parameter['floor']};
                        </script>";
                    }
                } else if($statusBook['status_switch'] === '0') {
                    echo "<script>
                        document.getElementById('container').style.display = 'none';
                        Swal.fire({
                            title: 'ระบบจองห้องพักปิดอยู่',
                            html: 'ทางหอจะแจ้งวันเปิดเข้าจองให้ทราบ <br>โปรดติดตามข่าวสารของหอพัก !',
                            icon: 'error',
                            showConfirmButton: true,
                            showCancelButton: false,
                            confirmButtonColor: '#cc0c62',
                            confirmButtonText: 'เข้าใจแล้ว'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = 'system_main.php';
                            }
                        })
                    </script>";
                }

                // System_book_php_control
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
                
                if ($statusBook['status_switch'] === '2') {
                    echo "<script type='text/javascript'>
                        callDateRange(1, '".strval($statusBook['status_date_start'].' - '.$statusBook['status_date_stop'])."');
                        document.getElementById('changeColorBorder').classList.add('md:border-b-2');
                        document.getElementById('changeColorBorder').classList.add('border-opacity-40');
                        document.getElementById('changeColorBorder').classList.add('border-green-700'); 
                    </script>"; // send 1 is active , 0 is deactive
                } else if ($statusBook['status_switch'] === '3') {
                    echo "<script type='text/javascript'>
                        callDateRange(0, '".strval($statusBook['status_date_start'].' - '.$statusBook['status_date_stop'])."');
                        document.getElementById('changeColorBorder').classList.add('md:border-b-2');
                        document.getElementById('changeColorBorder').classList.add('border-opacity-40');
                        document.getElementById('changeColorBorder').classList.add('border-red-700'); 
                    </script>"; // send 1 is active , 0 is deactive
                }


            ?>
                    
            </content>

            <?php include('./file_link/system_footer.php') ?>
        
        </div>

        <form action="#" name="frm_room_book" id="frm_room_book" method="POST" 
                class="hidden absolute flex w-full justify-center">
            <input name="txt_idRoom" id="id_room" type="text" value="" class="">
            <input name="txt_numberRoom" id="number_room" type="text" value="" class="">
            <input name="txt_LimitMember" id="limit_member" type="text" value="" class="">
            <input name="btn_submitBook" type="submit" id="submitBook" value="BtnSubmitBook">
        </form>

        <form action="#" method="POST">
            <input id="toggleStatus" name="toggleStatus" type="submit" class="hidden">
        </form>

    </div>

    <input type="text" id="std_status" value="<?php echo $dataStd['std_status'] ?>" style="display: none;">
    
    <script src="./assets/js/_title_change.js" onload="switchTitle('จองห้องพัก');"></script>
    <script src="./assets/js/_system_sidebar.js"></script>
    <script src="./assets/js/_system_book.js"></script>
    <script type="text/javascript">
        document.getElementsByClassName("list-item ")[0].style.listStyle = 'none';
    </script>

</body>
</html>

<!-- 2 is open 3 is to close -->