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

    require_once './../classes/Student.php';
    require_once './../classes/Faculty.php';
    require_once './../classes/Branch.php';
    require_once './../classes/Family.php';
    require_once './../classes/Building.php';
    require_once './../classes/Floor.php';
    require_once './../classes/Room.php';
    require_once './../classes/ExchangeValue.php';

    $facClass = new Faculty();
    $branchClass = new Branch();
    $stdClass = new Student();
    $famClass = new Family();
    $buildingClass = new Building();
    $floorClass = new Floor();
    $roomClass = new Room();
    $exchangeClass = new ExchangeValue();
    $dataFam = array();

?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลนักศึกษารายบุคคล</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <link rel="stylesheet" href="../assets/css/style_x_tailwind.css">
    <link rel="icon" href=" ../assets/img/logoKmutnb.webp">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../assets/node_modules/daisyui/dist/full.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body class="font_prompt">

    <?php

        if (isset($_SESSION['adm_id'])) {
            $findDataStd = $stdClass->Find('*', 'std_id', $_GET['std_id']);
            $dataStd = $findDataStd->fetch(PDO::FETCH_ASSOC);
    
            $select_famId = $famClass->Find('fam_id', 'std_id', $_GET['std_id']);
            while ($value = $select_famId->fetch(PDO::FETCH_ASSOC)) {
                $findFam = $famClass->Find('fam_sex, fam_firstname, fam_lastname, fam_tel, fam_career, fam_work_at, fam_status, person_is, fam_id', 'fam_id', $value['fam_id']);
                while ($value = $findFam->fetch(PDO::FETCH_ASSOC)) {
                    array_push($dataFam, $value);
                }
            }

            $dataRoom = $roomClass->Find('room_name, floor_id', 'room_id', $dataStd['room_id']);
            $dataRoom = $dataRoom->fetch(PDO::FETCH_ASSOC);
        
            if (isset($dataStd['room_id'])) {
                $book_floor = $floorClass->Find('building_id, floor_id', 'floor_id', $dataRoom['floor_id']);
                $book_floor = $book_floor->fetch(PDO::FETCH_ASSOC);
                
                echo "<input id='txt_building_id' class='hidden' type='text' value='".$book_floor['building_id']."'>";
                echo "<input id='txt_floor_id' class='hidden' type='text' value='".$book_floor['floor_id']."'>";
                echo "<input id='txt_room_id' class='hidden' type='text' value='".$dataStd['room_id']."'>";
            } else {
                echo "<input id='txt_building_id' class='hidden' type='text' value=''>";
                echo "<input id='txt_floor_id' class='hidden' type='text' value=''>";
                echo "<input id='txt_room_id' class='hidden' type='text' value=''>";
            }
        
        }

    ?>

    <input id="std_id" type="text" value="<?php echo ($_GET['std_id']) ?>" class="hidden">

    <div class="flex">
        <!-- Sidebar -->
        <?php include ('./adm_file_link/sidebar.php'); ?>
        <!-- Navbar -->
        <div id="main" class="overflow-x-hidden flex flex-col w-full lg:w-11/12 ml-0 lg:ml-64 trasition-all duration-300 bg-gray-200 h-screen">

            <?php include ('./adm_file_link/navbar.php'); ?>

            <!-- SESSION -->
            <div id="content" class="font_kanit bg-gray-100 flex flex-col justify-center items-center w-min-screen m-2 pb-10 mt-6 md:ml-8 md:mr-8 md:pr-4 md:pl-4 rounded-md shadow-md">

                    
                <div class="text-left breadcrumbs m-2 ml-6 sm:ml-4 tracking-wide w-full" style="font-size: 0.8rem;">
                    <ul>
                        <li>
                            <i class="fas fa-lg fa-users mr-2 ml-4 sm:ml-0"></i>
                            <a href="./member_manage.php">
                                จัดการสมาชิก
                            </a>
                        </li> 
                        <li>
                            <i class="fas fa-lg fa-users mr-2"></i>
                            <a href="./sub_member_manage.php?dataStd&std_id=<?php echo $_GET['std_id'] ?>">
                                จัดการข้อมูลรายบุคคล
                            </a>
                        </li>
                    </ul>
                </div>

                <?php 
                    $findBranchId = $stdClass->Find('branch_id', 'std_id', $_GET['std_id']);
                    $findBranchId = $findBranchId->fetch(PDO::FETCH_ASSOC);
                    $findBranchForShowTitle = $branchClass->Find('branch_name, fac_id', 'branch_id', $findBranchId['branch_id']);
                    $findBranchForShowTitle = $findBranchForShowTitle->fetch(PDO::FETCH_ASSOC);
                    if ($findBranchId['branch_id'] != null) {
                        $findFacForShowTitle = $facClass->Find('fac_name', 'fac_id', $findBranchForShowTitle['fac_id']);
                        $findFacForShowTitle = $findFacForShowTitle->fetch(PDO::FETCH_ASSOC);
                    }

                    if(isset($dataRoom['room_name'])) {
                        $findBuildingForShowTitle = $floorClass->Find('building_id', 'floor_id', $dataRoom['floor_id']);
                        $findBuildingForShowTitle = $findBuildingForShowTitle->fetch(PDO::FETCH_ASSOC);
                        $findBuildingForShowTitle = $buildingClass->Find('building_name', 'building_id', $findBuildingForShowTitle['building_id']);
                        $findBuildingForShowTitle = $findBuildingForShowTitle->fetch(PDO::FETCH_ASSOC);
                    }
                ?>

                <?php if ($findBranchId['branch_id'] != null and isset($dataRoom['room_name']) != null): ?>
                    <div class="space mt-16"></div>
                <?php endif; ?>
                <div class="titleManage grid gap-y-4">
                    <p class="text-center mb-2 text-red-800 text-lg">คุณกำลังดูข้อมูลของ</p>
                    <?php if ($findBranchId['branch_id'] != null and isset($dataRoom['room_name']) != null): ?>
                        <p class="text-blue-900 text-sm sm:text-lg text-center sm:tracking-wide font_prompt md:hidden">
                            <?php
                                echo $dataStd['std_id_student'].'&nbsp;&nbsp;"&nbsp;'.
                                    $exchangeClass->sex_is($dataStd['std_sex']).
                                    $dataStd['std_firstname'].'&nbsp;&nbsp;&nbsp;'.
                                    $dataStd['std_lastname'].'&nbsp;"&nbsp;&nbsp;&nbsp;'.
                                    (isset($dataRoom['room_name']) ? '<br><br>อยู่ห้องพัก' : '').'&nbsp;&nbsp;'.
                                    (isset($dataRoom['room_name']) ? $dataRoom['room_name'] : '').
                                    '&nbsp;&nbsp;&nbsp;'.$findBuildingForShowTitle['building_name']; 
                            ?>
                        </p>
                    <?php else: ?>
                        <p class="text-blue-900 text-sm sm:text-lg text-center sm:tracking-wide font_prompt">
                            <?php 
                                echo $dataStd['std_id_student'].'&nbsp;&nbsp;"&nbsp;'.
                                    $exchangeClass->sex_is($dataStd['std_sex']).
                                    $dataStd['std_firstname'].'&nbsp;&nbsp;&nbsp;'.
                                    $dataStd['std_lastname'].'&nbsp;"&nbsp;&nbsp;&nbsp;'; 
                            ?>
                        </p>
                    <?php endif; ?>
                    <?php if ($findBranchId['branch_id'] != null and isset($dataRoom['room_name']) != null): ?>
                            <p class="text-blue-900 text-sm sm:text-lg text-center sm:tracking-wide font_prompt md_hidden">
                            <?php
                                echo $dataStd['std_id_student'].'&nbsp;&nbsp;&nbsp;&nbsp;"&nbsp;&nbsp;'.
                                    $exchangeClass->sex_is($dataStd['std_sex']).
                                    $dataStd['std_firstname'].'&nbsp;&nbsp;&nbsp;'.
                                    $dataStd['std_lastname'].'&nbsp;&nbsp;"&nbsp;&nbsp;&nbsp;'.
                                    (isset($dataRoom['room_name']) ? 'อยู่ห้องพัก' : '').'&nbsp;&nbsp;'.
                                    (isset($dataRoom['room_name']) ? $dataRoom['room_name'] : '').
                                    '&nbsp;&nbsp;&nbsp;'.(isset($findBuildingForShowTitle['building_name']) ? $findBuildingForShowTitle['building_name'] : '');
                            ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php if(isset($dataRoom['room_name'])): ?> 
                        <p class="text-blue-900 text-sm text-center sm:tracking-wide mb-4 md_hidden">
                            <?php 
                                echo 'สาขา : '.$findBranchForShowTitle['branch_name'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
                                    'คณะ : '.$findFacForShowTitle['fac_name']; 
                            ?>
                        </p>
                    <?php endif; ?>
                    <?php if(isset($dataRoom['room_name'])): ?>
                        <p class="text-blue-900 text-sm text-center sm:tracking-wide mb-4 md:hidden">
                            <?php
                                echo 'สาขา : '.$findBranchForShowTitle['branch_name'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
                                    '<br>คณะ : '.$findFacForShowTitle['fac_name']; 
                            ?>
                        </p>
                    <?php endif; ?>
                </div>
            
                <div class="space mt-8"></div>

                <!-- Data user -->
                <div class="frm_data">

                     <?php include('./../file_link/system_profile_nav.php') ?>
                    
                    <form name="frm_data_self" id="form_student" action="" method="POST">
                        
                        <p class="text-center sm:text-left mt-16 sm:ml-4 text-red-900 text-xl defocus">ข้อมูลนักศึกษา</p>
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 w-full mt-8 gap-x-4 gap-y-4 
                                    justify-self-center place-items-center">
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">คำนำ</p>
                                <select name="select_sex_std" id="select_sex_std" disabled class="disable text-sm cursor-not-allowed bg-gray-50 w-52 h-8 pl-2 text-black border border-gray-500">
                                    <option value="0">นาย</option>
                                    <option value="1">นางสาว</option>
                                    <option value="2">นาง</option>
                                </select>
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">ชื่อจริง</p>
                                <input type="text" name="txt_firstname" disabled value="<?php echo $dataStd['std_firstname']; ?>" 
                                        class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">นามสกุล</p>
                                <input type="text" name="txt_lastname" disabled value="<?php echo $dataStd['std_lastname']; ?>"
                                        class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">เลขบัตรประจำตัวประชาชน</p>
                                <input type="text" name="txt_idcard"maxlength="13" disabled value="<?php echo $dataStd['std_idcard']; ?>"
                                        class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">รหัสนักศึกษา</p>
                                <input type="text" name="txt_idstd" maxlength="13" disabled value="<?php echo $dataStd['std_id_student']; ?>"
                                        class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">เบอร์โทรศัพท์</p>
                                <input type="text" name="txt_tel" maxlength="10" disabled value="<?php echo $dataStd['std_tel']; ?>"
                                        class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">อีเมลล์</p>
                                <input type="text" name="txt_mail" disabled value="<?php echo $dataStd['std_email']; ?>"
                                        class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">หมู่เลือด</p>
                                <select name="select_blood_type" id="select_blood_type" disabled class="disable text-sm cursor-not-allowed bg-gray-50 w-52 h-8 pl-2 text-black border border-gray-500">
                                    <option value="0">A</option>
                                    <option value="1">B</option>
                                    <option value="2">O</option>
                                    <option value="3">AB</option>
                                </select>
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">ศาสนา</p>
                                <select name="select_religion" id="select_religion" disabled class="disable text-sm cursor-not-allowed bg-gray-50 w-52 h-8 pl-2 text-black border border-gray-500">
                                    <option value="0">พุทธ</option>
                                    <option value="1">คริสต์</option>
                                    <option value="2">อิสลาม</option>
                                    <option value="3">ฮินดู</option>
                                    <option value="4">ซิกข์</option>
                                    <option value="5">ไม่นับถือศาสนา</option>
                                </select>
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">วันเกิด&nbsp;ด/ว/ป.</p>
                                <input id="date_birthday" name="date_birthday" type="date" disabled class="disable cursor-not-allowed w-52 text-sm text-gray-500 bg-gray-50 border border-gray-400 bg-white outline-none h-8 pl-2 pr-2 w-full">
                            </div>

                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">คณะ</p>
                                <select name="select_faculty" id="select_faculty" disabled class="disable text-sm cursor-not-allowed bg-gray-50 w-52 h-8 pl-2 text-black border border-gray-500">
                                        <option value="" disabled>- เลือกคณะ -</option>
                                        <?php
                                            $select_fac = $facClass->Select_All('fac_id, fac_name');
                                            while ($row = $select_fac->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<option value=".$row['fac_id'].">".$row['fac_name']."</option>";
                                            }
                                        ?>
                                        <option value="null" disabled>- ยังไม่มีคณะ -</option>
                                </select>
                            </div>

                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">สาขา</p>
                                <select name="select_branch" id="select_branch" disabled class="disable text-sm cursor-not-allowed bg-gray-50 w-52 h-8 pl-2 text-black border border-gray-500">
                                        <option value="" disabled>- เลือกสาขา -</option>
                                        <?php 
                                            $select_branch = $branchClass->Select_All('branch_id, branch_name, fac_id');
                                            while ($value = $select_branch->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<option value=".$value['branch_id'].">".$value['branch_name']."</option>";
                                            }
                                        ?>
                                        <option value="null" disabled>- ยังไม่มีสาขา -</option>
                                </select>   
                            </div>

                            <div class="col-span-full sm:w-96 mt-4">
                                <p class="defocus ml-1 mb-1 text-md">ที่อยู่</p>
                                <textarea name="txt_address" id="txt_address" disabled class="disable text-sm cursor-not-allowed text-left w-full h-20 text-sm text-gray-500 bg-gray-50 border border-gray-400 
                                                                outline-none h-8 pl-2 pr-2 pt-2"><?php echo $dataStd['std_address']; ?></textarea>
                            </div>

                            <input id="updateData1" name="btn_hidden_edit_data1" type="submit" class="hidden">

                        </div>
                    </form>

                    <div class="w-full text-center mt-12">
                        <button name="" class="btnEdit text-yellow-600 p-1 pl-4 pr-4 round border-2 border-yellow-600 rounded-md 
                                                            hover:bg-yellow-600 hover:text-white" onclick="enableEditing()">
                                <i class="far fa-edit"></i>
                            จัดการข้อมูล
                        </button>
                        <button class="btnEdit hidden text-green-600 p-1 pl-4 pr-4 round border-2 border-green-600 rounded-md 
                                                            hover:bg-green-600 hover:text-white" onclick="updateData('updateData1')">    
                                <i class="far fa-calendar-check"></i>
                            บันทึกข้อมูล
                        </button>
                    </div>
                </div>


                <!-- Data family -->
                <div class="frm_data hidden">
                    
                    <?php include('./../file_link/system_profile_nav.php') ?>

                    <form name="frm_data_family" action="" method="POST">

                        <p class="text-center sm:text-left mt-16 sm:ml-2 text-red-900 text-xl defocus">ผู้ปกครองคนที่ 1 &nbsp;:&nbsp; บิดา</p>
                        <div class="grid sm:grid-cols-2 mt-8 md:grid-cols-3 xl:grid-cols-4 w-full gap-x-4 gap-y-4 
                                    justify-self-center place-items-center">
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">ชื่อจริง</p>
                                <input type="text" name="txt_firstnameParents1" disabled value="<?php echo $dataFam[0]['fam_firstname']; ?>"
                                        class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">นามสกุล</p>
                                <input type="text" name="txt_lastnameParents1" disabled value="<?php echo $dataFam[0]['fam_lastname'];  ?>" 
                                        class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">เบอร์โทรศัพท์ที่ติดต่อได้</p>
                                <input type="text" name="txt_telParents1" maxlength="10" disabled value="<?php echo $dataFam[0]['fam_tel']; ?>" 
                                        class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">อาชีพ</p>
                                <input type="text" name="txt_careerParents1" disabled value="<?php echo $dataFam[0]['fam_career']; ?>" 
                                        class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">สถานที่ทำงาน</p>
                                <input type="text" name="txt_workAtParents1" disabled value ="<?php echo $dataFam[0]['fam_work_at']; ?>" 
                                        class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">สถานะ</p>
                                <select name="select_statusParents1" id="select_statusParents1" disabled
                                        class="disable text-sm cursor-not-allowed bg-gray-50 w-52 h-8 pl-2 text-black border border-gray-600">
                                    <option value="0">ถึงแก่กรรม</option>
                                    <option value="1">ยังมีชีวิตอยู่</option>
                                </select>
                            </div>
                        </div>

                        <p class="text-center sm:text-left mt-16 sm:ml-2 text-red-900 text-xl defocus">ผู้ปกครองคนที่ 2 &nbsp;:&nbsp; มารดา</p>
                        <div class="grid sm:grid-cols-2 mt-8 md:grid-cols-3 xl:grid-cols-4 w-full gap-x-4 gap-y-4 
                                    justify-self-center place-items-center">
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">ชื่อจริง</p>
                                <input type="text" name="txt_firstnameParents2" disabled value="<?php echo $dataFam[1]['fam_firstname']; ?>" 
                                        class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">นามสกุล</p>
                                <input type="text" name="txt_lastnameParents2" disabled value="<?php echo $dataFam[1]['fam_lastname']; ?>" 
                                        class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">เบอร์โทรศัพท์ที่ติดต่อได้</p>
                                <input type="text" name="txt_telParents2" maxlength="10" disabled value="<?php echo $dataFam[1]['fam_tel']; ?>" 
                                        class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">อาชีพ</p>
                                <input type="text" name="txt_careerParents2" disabled value="<?php echo $dataFam[1]['fam_career']; ?>" 
                                        class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">สถานที่ทำงาน</p>
                                <input type="text" name="txt_workAtParents2" disabled value="<?php echo $dataFam[1]['fam_work_at']; ?>" 
                                        class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                            </div>
                            <div class="w-full">
                                <p class="defocus ml-1 mb-1 text-md">สถานะ</p>
                                <select name="select_statusParents2" id="select_statusParents2" disabled" 
                                        class="disable text-sm cursor-not-allowed bg-gray-50 w-52 h-8 pl-2 text-black border border-gray-600">
                                    <option value="0">ถึงแก่กรรม</option>
                                    <option value="1">ยังมีชีวิตอยู่</option>
                                </select>
                            </div>
                        </div>
                        <input id="updateData2" name="btn_hidden_edit_data2" type="submit" class="hidden">
                    </form>

                    <div class="w-full text-center mt-14">
                        <button name="" class="btnEdit text-yellow-600 p-1 pl-4 pr-4 round border-2 border-yellow-600 rounded-md 
                                                            hover:bg-yellow-600 hover:text-white" onclick="enableEditing()">
                                <i class="far fa-edit"></i>
                            จัดการข้อมูล
                        </button>
                        <button class="btnEdit hidden text-green-600 p-1 pl-4 pr-4 round border-2 border-green-600 rounded-md 
                                                            hover:bg-green-600 hover:text-white" onclick="updateData('updateData2')">    
                                <i class="far fa-calendar-check"></i>
                            บันทึกข้อมูล
                        </button>
                    </div>
                </div>

                <!-- Data Other -->
                <div class="frm_data hidden">
                    
                    <?php include('./../file_link/system_profile_nav.php'); ?>

                        <form name="frm_data_family" action="" method="POST">

                            <p class="text-center sm:text-left mt-16 sm:ml-2 text-red-900 text-xl defocus">ประวัติการศึกษา</p>
                            <div class="grid sm:grid-cols-2 mt-8 md:grid-cols-3 xl:grid-cols-4 w-full gap-x-4 gap-y-4 
                                        justify-self-center place-items-center">
                                <div>
                                    <p class="defocus ml-1 mb-1 text-md">จบการศึกษาจาก</p>
                                    <input type="text" name="txt_edu_academy" disabled value="<?php echo $dataStd['std_edu_academy']; ?>"
                                            class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                                </div>
                                <div>
                                    <p class="defocus ml-1 mb-1 text-md">ระดับการศึกษา</p>
                                    <select name="select_stdEduDegree" id="select_stdEduDegree" disabled 
                                            class="disable text-sm cursor-not-allowed bg-gray-50 w-52 h-8 pl-2 text-black border border-gray-600">
                                        <option value="0">มัธยมศึกษาตอนต้น</option>
                                        <option value="1">มัธยมศึกษาตอนปลาย</option>    
                                        <option value="2">ปวช.</option>
                                        <option value="3">ปวส.</option>
                                        <option value="4">อื่น ๆ ระบุในเอกสาร</option>
                                    </select>
                                </div>
                                <div>
                                    <p class="defocus ml-1 mb-1 text-md">ปีที่จบ</p>
                                    <input type="text" name="txt_edu_comple" minlength="4" maxlength="4" disabled value="<?php echo $dataStd['std_edu_comple']; ?>"
                                            class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                                </div>
                            </div>

                            <!-- Data sos -->
                            <?php if (count($dataFam) > 2): ?>
                                <p class="text-center sm:text-left mt-16 sm:ml-2 text-red-900 text-xl defocus">ผู้ติดต่อฉุกเฉินคนที่ 1</p>
                                <div class="grid sm:grid-cols-2 mt-8 md:grid-cols-3 xl:grid-cols-4 w-full gap-x-4 gap-y-4 
                                            justify-self-center place-items-center">
                                    <div>
                                        <p class="defocus ml-1 mb-1 text-md">ชื่อจริง</p>
                                        <input type="text" name="txt_firstnameEmergency1" disabled value="<?php echo $dataFam[2]['fam_firstname']; ?>"
                                                class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-50">
                                    </div>
                                    <div>
                                        <p class="defocus ml-1 mb-1 text-md">นามสกุล</p>
                                        <input type="text" name="txt_lastnameEmergency1" disabled value="<?php echo $dataFam[2]['fam_lastname']; ?>"
                                                class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-50">
                                    </div>
                                    <div>
                                        <p class="defocus ml-1 mb-1 text-md">เบอร์โทรศัพท์ที่ติดต่อได้</p>
                                        <input type="text" name="txt_telEmergency1" disabled value="<?php echo $dataFam[2]['fam_tel']; ?>"
                                                class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-50">
                                    </div>
                                    <div>
                                        <p class="defocus ml-1 mb-1 text-md">ผู้ติดต่อฉุกเฉินคนนี้คือ</p>
                                        <select name="select_person_is_Emergency1" id="select_person_is_Emergency1" disabled 
                                                class="disable text-sm cursor-not-allowed bg-gray-50 w-52 h-8 pl-2 text-black border border-gray-600">
                                            <option value="0">บิดา</option>
                                            <option value="1">มารดา</option>
                                            <option value="2">ปู่</option>
                                            <option value="3">ย่า</option>
                                            <option value="4">ตา</option>
                                            <option value="5">ยาย</option>
                                            <option value="6">ลุง</option>
                                            <option value="7">ป้า</option>
                                            <option value="8">พี่</option>
                                            <option value="9">อื่น ๆ ระบุในเอกสาร</option>
                                        </select>
                                    </div>
                                </div>

                                <p class="text-center sm:text-left mt-16 sm:ml-2 text-red-900 text-xl defocus">ผู้ติดต่อฉุกเฉินคนที่ 2</p>
                                <div class="grid sm:grid-cols-2 mt-8 md:grid-cols-3 xl:grid-cols-4 w-full gap-x-4 gap-y-4 
                                            justify-self-center place-items-center">
                                    <div>
                                        <p class="defocus ml-1 mb-1 text-md">ชื่อจริง</p>
                                        <input type="text" name="txt_firstnameEmergency2" disabled value="<?php echo $dataFam[3]['fam_firstname']; ?>"
                                                class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                                    </div>
                                    <div>
                                        <p class="defocus ml-1 mb-1 text-md">นามสกุล</p>
                                        <input type="text" name="txt_lastnameEmergency2" disabled value="<?php echo $dataFam[3]['fam_lastname']; ?>"
                                                class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                                    </div>
                                    <div>
                                        <p class="defocus ml-1 mb-1 text-md">เบอร์โทรศัพท์ที่ติดต่อได้</p>
                                        <input type="text" name="txt_telEmergency2" disabled value="<?php echo $dataFam[3]['fam_tel']; ?>"
                                                class="disable cursor-not-allowed text-sm text-gray-500 bg-gray-50 border border-gray-400 outline-none h-8 pl-2 pr-2 w-full">
                                    </div>
                                    <div>
                                        <p class="defocus ml-1 mb-1 text-md">ผู้ติดต่อฉุกเฉินคนนี้คือ</p>
                                        <select name="select_person_is_Emergency2" id="select_person_is_Emergency2" disabled 
                                                class="disable text-sm cursor-not-allowed bg-gray-50 w-52 h-8 pl-2 text-black border border-gray-600">
                                            <option value="0">บิดา</option>
                                            <option value="1">มารดา</option>
                                            <option value="2">ปู่</option>
                                            <option value="3">ย่า</option>
                                            <option value="4">ตา</option>
                                            <option value="5">ยาย</option>
                                            <option value="6">ลุง</option>
                                            <option value="7">ป้า</option>
                                            <option value="8">พี่</option>
                                            <option value="9">อื่น ๆ ระบุในเอกสาร</option>
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Data dorm -->
                            
                            <?php 

                                $std_dataBuilding = $buildingClass->Select_All('building_id, building_name');
                                $std_dataFloor = $floorClass->Select_All('floor_id, building_id, floor_name');
                                $std_dataRoom = $roomClass->Select_All('room_id, floor_id, room_name');
                                $arr_valueBuilding = array();
                                $arr_valueFloor = array();
                                $arr_valueRoom = array();

                                $i = 0;
                                while ($valueBuilding = $std_dataBuilding->fetch(PDO::FETCH_ASSOC)) {
                                    array_push($arr_valueBuilding, array());
                                    array_push($arr_valueBuilding[$i], $valueBuilding['building_id']);
                                    array_push($arr_valueBuilding[$i++], $valueBuilding['building_name']);
                                }

                                $i = 0;
                                while ($valueFloor = $std_dataFloor->fetch(PDO::FETCH_ASSOC)) {
                                    array_push($arr_valueFloor, array());
                                    array_push($arr_valueFloor[$i], $valueFloor['floor_id']);
                                    array_push($arr_valueFloor[$i], $valueFloor['floor_name']);
                                    array_push($arr_valueFloor[$i++], $valueFloor['building_id']);
                                }

                                $i = 0;
                                while ($valueRoom = $std_dataRoom->fetch(PDO::FETCH_ASSOC)) {
                                    array_push($arr_valueRoom, array());
                                    array_push($arr_valueRoom[$i], $valueRoom['room_id']);
                                    array_push($arr_valueRoom[$i], $valueRoom['room_name']);
                                    array_push($arr_valueRoom[$i++], $valueRoom['floor_id']);
                                }

                                $dataBook = array($arr_valueBuilding, $arr_valueFloor, $arr_valueRoom);
                                echo "<script>var data_Book = ". json_encode($dataBook) .";</script>";

                            ?>

                            <div class="flex flex-row items-end justify-between">
                                <p class="text-center sm:text-left mt-16 w-full sm:ml-2 text-red-900 text-xl defocus">ห้องที่นักศึกษาเข้าพัก</p>
                                <p></p>
                            </div>
                            <div class="grid sm:grid-cols-2 mt-8 md:grid-cols-3 xl:grid-cols-4 w-full gap-x-4 gap-y-4 
                                        justify-self-center place-items-center">
                                <div>
                                    <p class="defocus ml-1 mb-1 text-md">อาคาร</p>
                                    <select name="select_Building" id="select_Building" onchange="newBook(0)" disabled 
                                            class="disable text-sm cursor-not-allowed bg-gray-50 w-48 h-8 pl-2 text-black border border-gray-600">
                                            <option value="" disabled selected>-</option>
                                    </select>
                                </div>
                                <div>
                                    <p class="defocus ml-1 mb-1 text-md">ชั้น</p>
                                    <select name="select_Floor" id="select_Floor" onchange="newBook(1)" disabled 
                                            class="disable text-sm cursor-not-allowed bg-gray-50 w-48 h-8 pl-2 text-black border border-gray-600">
                                            <option value="" disabled selected>-</option>
                                    </select>
                                </div>
                                <div>
                                    <p class="defocus ml-1 mb-1 text-md">ชื่อห้อง</p>
                                    <select name="select_Room" id="select_Room" disabled 
                                            class="disable text-sm cursor-not-allowed bg-gray-50 w-48 h-8 pl-2 text-black border border-gray-600">
                                            <option value="null" disabled selected>-</option>
                                    </select>
                                </div>
                                <?php if (isset($dataStd['room_id'])): ?>
                                    <center>
                                    <div class="md:relative">
                                        <input type="submit" id="btn_cancleBook" name="btn_cancleBook" class="hidden">
                                        <div onclick="sure_toDestroyBook()" class="btn btn-sm sm:mt-7">
                                            <i class="fas fa-door-open mr-2"></i>
                                            <span class="font-light">ยกเลิกการเข้าพักของ นศ.</span>
                                        </div>
                                        <center>
                                        <p class="md:absolute mt-4 w-11/12 font-light md:mr-2">หากต้องการแก้ไขห้องพักของนักศึกษา โปรดยกเลิกการเข้าพักของ นศ. ก่อน !!</p>
                                        </center>
                                    </div>
                                    </center>
                                <?php endif; ?>
                            </div>


                            <input id="updateData3" name="btn_hidden_edit_data3" type="submit" class="hidden">
                        </form>

                        <div class="w-full text-center mt-14">
                            <button name="" class="btnEdit text-yellow-600 p-1 pl-4 pr-4 round border-2 border-yellow-600 rounded-md 
                                                                hover:bg-yellow-600 hover:text-white" onclick="enableEditing()">
                                    <i class="far fa-edit"></i>
                                จัดการข้อมูล
                            </button>
                            <button class="btnEdit hidden text-green-600 p-1 pl-4 pr-4 round border-2 border-green-600 rounded-md 
                                                                hover:bg-green-600 hover:text-white" onclick="updateData('updateData3')">    
                                    <i class="far fa-calendar-check"></i>
                                บันทึกข้อมูล
                            </button>
                        </div>
                </div>

            </div>

                <div class="w-11/12 flex justify-end items-center">
                    <div class="cursor-pointer btn btn-sm mt-20 btn-error btn_destroy_check">
                        <i class="fas fa-exclamation-triangle mr-4"></i>
                        ลบนักศึกษาคนนี้ออกจากระบบหอพัก
                    </div>
                    <form action="#" method="POST">
                        <input type="submit" name="btn_destroy_std" class="hidden btn_destroy_std">
                    </form>
                </div>
            <div class="overlay fixed hidden z-10 w-full h-full bg-black opacity-30"></div>
            <div class="space mb-40"></div>

        </div>

    </div>

    <script type="text/javascript" src="./../assets/js/_title_change.js" onload="switchTitle('ข้อมูลนักศึกษารายบุคคล')"></script>
    <script type="text/javascript" src="./../assets/js/_adm_select_menu.js" onload="select_menu(4)"></script>
    <script type="text/javascript" src="./../assets/js/_adm_sub_member_manage.js"></script>
    <script type="text/javascript">
        setTimeout(() => {
            for (let i = 0; i < document.getElementsByClassName('btn_showDataUser').length; i++) {
                document.getElementsByClassName('btn_showDataUser')[i].classList.remove('bg-gray-100');
                document.getElementsByClassName('btn_showDataUser')[i].classList.add('bg-gray-50');
            }
        }, 0);

        
        document.getElementsByClassName('btn_destroy_check')[0].addEventListener('click', () => {
            Swal.fire({
                title: 'คุณต้องการนำนักศึกษาคนนี้ออกจากระบบหอพัก ?',
                text: 'หากดำเนินการแล้วจะไม่สามารถกู้ข้อมูลใด ๆ กลับมาได้อีก !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยันการลบ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                Swal.fire({
                    title: 'ต้องการนำนักศึกษาคนนี้ออก!! โปรดยืนยันอีกครั้ง',
                    text: 'หากดำเนินการแล้วจะไม่สามารถกู้ข้อมูลใด ๆ กลับมาได้อีก !',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยันการลบ',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementsByClassName('btn_destroy_std')[0].click();
                    }
                })
            })
        });
    </script>


    <?php

    
        if (isset($_POST['btn_destroy_std'])) {
            $stdClass->Delete($_GET['std_id']);
            echo "<script type='text/javascript'>
                Swal.fire({
                    title: 'ลบข้อมูลนักศึกษาคนนี้แล้ว',
                    text: '',
                    icon: 'success',
                    showConfirmButton: false,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then(setTimeout(() => {
                    window.location.href='./member_manage.php';
                }, 1000)); 
            </script>";
        }

        
        if (!isset($_GET['std_id'])) {
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
        } else {
            echo "<script>
                selectOption("."'".$dataStd['std_sex']."', 'select_sex_std'".");
                selectOption("."'".$dataStd['std_blood']."', 'select_blood_type'".");
                selectOption("."'".$dataStd['std_religion']."', 'select_religion'".");
                selectOption("."'".$dataFam[0]['fam_status']."', 'select_statusParents1'".");
                selectOption("."'".$dataFam[1]['fam_status']."', 'select_statusParents2'".");
                selectOption("."'".$dataStd['std_edu_degree']."', 'select_stdEduDegree'".");
                birthdaySet("."'".$dataStd['std_birthday']."'".");
            </script>";
            
            // $select_branch = $branchClass->Select_All('branch_id, branch_name, fac_id');
            // while ($value = $select_branch->fetch(PDO::FETCH_ASSOC)) {
            //     if ($dataStd['branch_id'] == $value['branch_id']) {
            //         echo "<script>selectOption("."'".$value['fac_id']."', 'select_faculty'".");</script>";
            //         echo "<script>selectOption("."'".$value['branch_id']."', 'select_branch'".");</script>";
            //     }
            // }
        }

        function alertUpdate($status, $pageHash) {
            switch ($status) {
                case 0:
                    echo "<script>
                            Swal.fire({
                                title: 'จัดการข้อมูลแล้ว',
                                text: '',
                                icon: 'success',
                                showConfirmButton: false,
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                            }).then(setTimeout(() => {
                                window.location.href='./sub_member_manage.php?".$pageHash."&std_id=".$_GET['std_id']."';
                                destroySweetAlert();
                            }, 1000)); 
                        </script>";
                    break;
                case 1:
                    echo "<script>  
                            Swal.fire({
                                title: 'ระบบเกิดข้อผิดพลาด',
                                text: 'จัดการข้อมูลไม่สำเร็จ โปรดติดต่อเจ้าหน้าที่หอพัก',
                                icon: 'error',
                                showConfirmButton: false,
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                cancelButtonText: 'ปิด'
                            }).then((result) => {
                                if (!result.isConfirmed) {
                                    window.location.href='./sub_member_manage.php?dataStd&std_id=".$_GET['std_id']."'
                                }
                            })
                        </script>";
                    break;
            }
        }


        // Variable for update data student
        $fieldStd = array('std_sex', 'std_firstname', 'std_lastname', 'std_idcard', 
                        'std_id_student', 'std_tel', 'std_email', 'std_blood', 
                        'std_religion', 'std_birthday', 'std_address', 'branch_id');
        $valueStd = array(null, null, null, null, 
                        null, null, null, null, 
                        null, null, null, null);
        // Variable for update data family
        $fieldFam = array('fam_firstname', 'fam_lastname', 'fam_tel', 'fam_career', 'fam_work_at', 'fam_status'); 
        $valueFam1 = array(null, null, null, null, null, null);
        $valueFam2 = array(null, null, null, null, null, null);
        // Variable for update data other
        $fieldOther = array('std_edu_academy', 'std_edu_degree', 'std_edu_comple');
        $valueOther = array(null, null, null);
        // Variable for update data person_sos
        if (count($dataFam) > 2) {
            $fieldSos = array('fam_firstname', 'fam_lastname', 'fam_tel', 'person_is');  
            $valueSos1 = array(null, null, null, null);
            $valueSos2 = array(null, null, null, null);
            echo "<script>
                selectOption("."'".$dataFam[2]['person_is']."', 'select_person_is_Emergency1'".");
                selectOption("."'".$dataFam[3]['person_is']."', 'select_person_is_Emergency2'".");
            </script>";
        }

        // Update data student user
        if (isset($_POST['btn_hidden_edit_data1'])) {
            $valueStd[0] = $_POST['select_sex_std'];
            $valueStd[1] = $_POST['txt_firstname'];
            $valueStd[2] = $_POST['txt_lastname'];
            $valueStd[3] = $_POST['txt_idcard'];
            $valueStd[4] = $_POST['txt_idstd'];
            $valueStd[5] = $_POST['txt_tel'];
            $valueStd[6] = $_POST['txt_mail'];
            $valueStd[7] = $_POST['select_blood_type'];
            $valueStd[8] = $_POST['select_religion'];
            $valueStd[9] = $_POST['date_birthday'];
            $valueStd[10] = $_POST['txt_address'];
            $valueStd[11] = ($_POST['select_branch'] == 'null' ? 0 : $_POST['select_branch']);

            if ($stdClass->Update_Select($fieldStd, $valueStd, 'std_id', $_GET['std_id']))
                alertUpdate(0,'dataStd');
            else alertUpdate(1, 'dataStd');

        } else if (isset($_POST['btn_hidden_edit_data2'])) {
            $valueFam1[0] = $_POST['txt_firstnameParents1'];
            $valueFam1[1] = $_POST['txt_lastnameParents1'];
            $valueFam1[2] = $_POST['txt_telParents1'];
            $valueFam1[3] = $_POST['txt_careerParents1'];
            $valueFam1[4] = $_POST['txt_workAtParents1'];
            $valueFam1[5] = $_POST['select_statusParents1'];
 
            $valueFam2[0] = $_POST['txt_firstnameParents2'];
            $valueFam2[1] = $_POST['txt_lastnameParents2'];
            $valueFam2[2] = $_POST['txt_telParents2'];
            $valueFam2[3] = $_POST['txt_careerParents2'];
            $valueFam2[4] = $_POST['txt_workAtParents2'];
            $valueFam2[5] = $_POST['select_statusParents2'];

            if ($famClass->Update_Select($fieldFam, $valueFam1, 'fam_id', $dataFam[0]['fam_id']) && 
                $famClass->Update_Select($fieldFam, $valueFam2, 'fam_id', $dataFam[1]['fam_id']))
                alertUpdate(0, 'dataFam');
            else alertUpdate(1, 'dataFam');        
            
        } else if (isset($_POST['btn_hidden_edit_data3'])) {

            if (isset($_POST['select_Room'])) {
                $stdClass->room_book($_GET['std_id'], (!isset($_POST['select_Room']) ? NULL : $_POST['select_Room']));
            }

            $valueOther[0] = $_POST['txt_edu_academy'];
            $valueOther[1] = $_POST['select_stdEduDegree'];
            $valueOther[2] = $_POST['txt_edu_comple'];

            if (count($dataFam) > 2) {

                $valueSos1[0] = $_POST['txt_firstnameEmergency1'];
                $valueSos1[1] = $_POST['txt_lastnameEmergency1'];
                $valueSos1[2] = $_POST['txt_telEmergency1'];
                $valueSos1[3] = $_POST['select_person_is_Emergency1'];
            
                $valueSos2[0] = $_POST['txt_firstnameEmergency2'];
                $valueSos2[1] = $_POST['txt_lastnameEmergency2'];
                $valueSos2[2] = $_POST['txt_telEmergency2'];
                $valueSos2[3] = $_POST['select_person_is_Emergency2'];

                 if ($famClass->Update_Select($fieldSos, $valueSos1, 'fam_id', $dataFam[2]['fam_id']) && 
                    $famClass->Update_Select($fieldSos, $valueSos2, 'fam_id', $dataFam[3]['fam_id']) &&
                    $stdClass->Update_Select($fieldOther, $valueOther, 'std_id', $_GET['std_id']))
                    alertUpdate(0, 'dataOther');
                else alertUpdate(1, 'dataOther');

            } else {

                if ($stdClass->Update_Select($fieldOther, $valueOther, 'std_id', $_GET['std_id']))
                    alertUpdate(0,'dataOther');
                else alertUpdate(1, 'dataOther');
            
            }
        } else if (isset($_POST['btn_cancleBook'])) {
            $stdClass->book_destory($_GET['std_id']);
            echo "<script type='text/javascript'>
                Swal.fire({
                    title: 'จัดการข้อมูลแล้ว',
                    text: '',
                    icon: 'success',
                    showConfirmButton: false,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then(setTimeout(() => {
                    window.location.href='./sub_member_manage.php?dataOther&std_id=".$_GET['std_id']."';
                    destroySweetAlert();
                }, 1000)); 
            </script>";
        }

        $findBranchId = $stdClass->Find('branch_id', 'std_id', $_GET['std_id']); 
        $findBranchId = $findBranchId->fetch(PDO::FETCH_ASSOC);
        $DataBranch = $branchClass->Find('branch_id, fac_id', 'branch_id', $findBranchId['branch_id']);
        $DataBranch = $DataBranch->fetch(PDO::FETCH_ASSOC); 

        if ($findBranchId['branch_id'] != null) {
            echo "<script>setDataFacBranchStd(".json_encode($DataBranch).")</script>";
        } else {
            echo "<script>setDataFacBranchStdEmpty()</script>";
        }


    ?>

    
</body>
</html>