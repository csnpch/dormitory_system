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
    require_once ('../classes/ExchangeValue.php');

    $buildingClass = new Building();
    $floorClass = new Floor();
    $roomClass = new Room();
    $exchangeClass = new ExchangeValue();
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการอาคาร/ห้องหอพัก</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <link rel="stylesheet" href="../assets/css/style_x_tailwind.css">
    <link rel="icon" href=" ../assets/img/logoKmutnb.webp">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../assets/node_modules/daisyui/dist/full.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body class="font_prompt">

    <div class="flex">
        <!-- Sidebar -->
        <?php include ('./adm_file_link/sidebar.php'); ?>
        <!-- Navbar -->
        <div id="main" class="flex flex-col w-full lg:w-11/12 ml-0 lg:ml-64 trasition-all duration-300 bg-gray-100 h-screen">
            <?php include ('./adm_file_link/navbar.php'); ?>

            <!-- Content -->
            <!-- SESSION -->

                <session id="manage_main" class="font_kanit flex flex-col items-center w-min-screen pb-10 mt-6 md:ml-8 md:mr-8 pr-4 pl-4 bg-primary-content rounded-md shadow-md">
                    
                    <div class="w-full text-left breadcrumbs m-2 ml-10 sm:ml-4 tracking-wide" style="font-size: 0.8rem;">
                        <ul>
                            <li>
                                <i class="fas fa-city mr-2"></i>
                                <a href="./dorm_manage.php">
                                    ข้อมูลสิ่งปลูกสร้าง
                                </a>
                            </li> 
                        </ul>
                    </div>
                    
                    <div class="flex md:flex-row flex-col md:items-end items-center justify-between w-11/12">
                        <p class="text-lg text-center md:text-left ml-0 md:ml-4 mt-8 mb-2 w-11/12 text-red-900">ข้อมูลสิ่งปลูกสร้าง</p>
                        <p></p>
                        <!-- <a href="./book_zone_manage.php"> -->
                            <!-- <button class="btn btn-sm btn-secondary md:mr-4 mb-1 w-44">จัดการห้องตามโซนสาขา</button> -->
                        <!-- </a> -->
                    </div>

                    <div class="flex w-full sm:justify-center overflow-x-auto p-1.5">
                        <div class="bg-gray-200 md:w-11/12 p-1.5">
                            <table class="table w-full">
                                <thead>
                                    <tr>
                                        <th class="hidden"></th>
                                        <th><span class="font-normal" style="font-size: 16px;">ชื่ออาคาร / ตึก</span></th>
                                        <th><span class="font-normal text-center" style="font-size: 16px;">สถานะหอพัก</span></th>
                                        <th class="w-20 text-center font-semibold"><span class="font-normal" style="font-size: 16px;">จำนวนชั้น</span></th> 
                                        <th class="w-20 text-center"><span class="font-normal" style="font-size: 16px;">ห้องพักทั้งหมด</span></th>
                                        <th class="w-20 text-center text-blue-700"><span class="font-normal" style="font-size: 16px;">ห้องที่เปิด</span></th>
                                        <th class="w-20 text-center text-red-600"><span class="font-normal" style="font-size: 16px;">ห้องที่ปิด</span></th>
                                        <th class="w-40 text-center"><span class="font-normal" style="font-size: 16px;">ตัวเลือก</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Define variable
                                        $dataFloor = NULL;
                                        $dataRoom = NULL;
                                        $countRoom = array(0, 0, 0);
                                        $i = 0;

                                        $dataBuilding = $buildingClass->Select_Sort('building_id, building_name, building_gender', '	created_at ASC', '', '0');
                                        while ($valueBuilding = $dataBuilding->fetch(PDO::FETCH_ASSOC)):
                                            $dataFloor = $floorClass->Find('floor_id', 'building_id', $valueBuilding['building_id']);
                                            $countRoom[0] = 0;
                                            $countRoom[1] = 0;
                                            $countRoom[2] = 0;
                                            while ($valueFloor = $dataFloor->fetch(PDO::FETCH_ASSOC)) {
                                                $dataRoom = $roomClass->Find('room_status', 'floor_id', $valueFloor['floor_id']);
                                                while ($valueRoom = $dataRoom->fetch(PDO::FETCH_ASSOC)) {
                                                    $countRoom[2]++;
                                                    if ($valueRoom['room_status'] == '1')
                                                        $countRoom[1]++;
                                                    else if ($valueRoom['room_status'] == '0')
                                                        $countRoom[0]++;
                                                }
                                            }
                                            $dataFloor = $floorClass->Count_where('floor_id', 'count_floor', 'building_id', $valueBuilding['building_id']);
                                            $dataFloor = $dataFloor->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                            <tr class="text-sm">
                                                <td><a href="#" class="building_name md:ml-4"><?php echo ($valueBuilding['building_name']) ?></a></td> 
                                                <td class="text-left"><?php echo $exchangeClass->gender_dorm_is($valueBuilding['building_gender']); ?></td>
                                                <td class="text-center"><?php echo ($dataFloor['count_floor']); ?></td>
                                                <td class="text-center"><?php echo ($countRoom[2]) ?></td>
                                                <td class="text-center"><?php echo ($countRoom[1]) ?></td>
                                                <td class="text-center"><?php echo ($countRoom[0]) ?></td>
                                                <td class="text-center flex flex-row justify-center font_prompt">
                                                    <form action="" method="POST">
                                                        <input name="n_building" type="text" class="hidden" value="<?php echo ($i); ?>">
                                                        <input name="id_building" type="text" class="hidden" value="<?php echo ($valueBuilding['building_id']); ?>">
                                                        <button name="edit_building" class="pl-2 pr-2 p-1 bg-yellow-300 text-black mr-0.5 hover:bg-yellow-400 rounded-sm">จัดการ</button>
                                                        <button name="confirm_delete_building" class="confirm_delete_building hidden"></button>
                                                        <button name="delete_building" class="pl-2 pr-2 p-1 bg-red-600 text-gray-50 hover:bg-red-700 rounded-sm">ลบ</button>
                                                    </form>
                                                </td>
                                            </tr>
                                    <?php
                                            $i++;
                                        endwhile; 
                                        if ($i === 0):
                                    ?>
                                        <td colspan="7" class="w-full text-center text-sm text-red-900">ไม่พบข้อมูล</td>
                                    <?php
                                        endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="btn_area">
                        <button id="btn_manage" class="mt-4 btn btn-success btn-sm">
                            <i class="fas fa-edit"></i>
                            &nbsp;&nbsp;เพิ่ม
                        </button>
                    </div>

                </session>

            <div id="add_item" class="hidden z-20 fixed w-full h-screen">
                
                <div class="absolute w-full lg:w-10/12 h-full flex justify-center items-center">
                    <div class="absolute p-4 rounded-2xl flex flex-col font_kanit text-lg text-left bg-gray-100">
                        <form name="frm_add_building" action="#" method="POST">
                            <p class="text-red-800 font-lg">ชื่ออาคาร</p>
                            <input type="text" name="txt_building_name" class="h-10 p-2 mt-2 text-md" placeholder="หอพัก...(ชื่อ)....">
                            <select required type="text" name="select_building_status" class="h-10 p-2 mt-2 text-md" placeholder="เลือกสถานะ">
                                <option selected value="" disabled>เลือกประเภท</option>
                                <option value="2">หอพักทั่วไป</option>
                                <option value="0">หอพักชาย</option>
                                <option value="1">หอพักหญิง</option>
                            </select>
                            <div class="grid grid-cols-2 mt-4 gap-x-1">
                                <button name="btn_add_building" class="btn btn-success btn-sm">เพิ่มอาคาร</button>
                                <input type="reset" class="cancleInsertDorm btn btn-error btn-sm" value="ยกเลิก">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="overlay fixed hidden z-10 w-full h-full bg-black opacity-30"></div>

            <div class="space mb-40"></div>

        </div>

    </div>

    <script type="text/javascript" src="../assets/js/_title_change.js" onload="switchTitle('จัดการอาคาร/ห้องหอพัก')"></script>
    <script type="text/javascript" src="../assets/js/_adm_select_menu.js" onload="select_menu(3)"></script>
    <script type="text/javascript" src="../assets/js/_adm_dorm_manage.js"></script>

    <?php
        if (isset($_POST['btn_add_building'])) {
            if ($_POST['txt_building_name'] === "") {
                echo "<script type='text/javascript'>
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        html: 'โปรดระบุชื่ออาคาร !!',
                        showConfirmButton: false,
                        timer: 1000
                    })
                </script>";
            } else {
                if ($buildingClass->Insert($_POST['txt_building_name'], $_POST['select_building_status'])) {
                    echo "<script type='text/javascript'>
                            Swal.fire({
                                position: 'center-center',
                                icon: 'success',
                                html: 'เพิ่มข้อมูลสำเร็จ',
                                showConfirmButton: false,
                                timer: 1000
                            })
                            
                            setTimeout(() => {
                                window.location.href = './dorm_manage.php';
                            }, 1000);
                        </script>";
                } else {
                    echo "<script type='text/javascript'>
                        Swal.fire({
                            position: 'center-center',
                            icon: 'error',
                            html: 'เกิดข้อผิดพาด กรุณาติดต่อผู้ดูแลระบบ',
                            showConfirmButton: false,
                            timer: 1000
                        })
                    </script>";
                }
            }
        } else if (isset($_POST['edit_building'])) {
            echo "<script type='text/javascript'>window.location.href = './sub_dorm_manage.php?dorm_id={$_POST['id_building']}';</script>";
        } else if (isset($_POST['delete_building'])) {
            $n_building = intval($_POST['n_building']);
            echo "<script type='text/javascript'>
                Swal.fire({
                    title: 'คุณแน่ใจที่จะลบ<br>\" ' + document.getElementsByClassName('building_name')[".$n_building."].innerText + ' \"<br>ใช่หรือไม่ !!!',
                    html: '<span class="."text-red-600".">หากลบอาคาร ข้อมูลภายในอาคารจะหายหมด <br>และจะมีผลต่อข้อมูลอื่น ๆ ภายในอาคารด้วย<br><br>[ คำแนะนำ ]<br>โปรดปรึกษาผู้พัฒนาระบบ ก่อนดำเนินการนี้</span>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ฉันแน่ใจ',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'โปรดยืนยันการลบ<br>\" ' + document.getElementsByClassName('building_name')[".$n_building."].innerText + ' \"<br>อีกครั้ง !!!',
                            html: '<span class="."text-red-600".">หากลบอาคาร ข้อมูลภายในอาคารจะหายหมด <br>และจะมีผลต่อข้อมูลอื่น ๆ ภายในอาคารด้วย<br><br>[ คำแนะนำ ]<br>โปรดปรึกษาผู้พัฒนาระบบ ก่อนดำเนินการนี้</span>',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'ยืนยัน',
                            cancelButtonText: 'ยกเลิก'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementsByClassName('confirm_delete_building')[".($n_building)."].click();
                            }
                        })
                    }
                })
            </script>";
        } else if (isset($_POST['confirm_delete_building'])) {
            if($buildingClass->Delete($_POST['id_building'])) {
                echo "<script type='text/javascript'>
                    Swal.fire({
                        position: 'center-center',
                        icon: 'success',
                        html: 'ลบข้อมูลสำเร็จ',
                        showConfirmButton: false,
                        timer: 1000
                    })
                    setTimeout(() => {
                        window.location.href = './dorm_manage.php';
                    }, 1000);
                </script>";
            } else {
                echo "<script type='text/javascript'>
                    Swal.fire({
                        position: 'center-center',
                        icon: 'error',
                        html: 'เกิดข้อผิดพาด กรุณาติดต่อผู้ดูแลระบบ',
                        showConfirmButton: false,
                        timer: 1000
                    })
                </script>";
            }
        }
    ?>

</body>
</html>
