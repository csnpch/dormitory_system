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

    require_once ('../classes/Student.php');
    require_once ('../classes/Faculty.php');
    require_once ('../classes/Branch.php');
    require_once ('../classes/ExchangeValue.php');
    require_once ('../classes/Building.php');
    require_once ('../classes/Floor.php');
    require_once ('../classes/Room.php');
    $stdClass = new Student();
    $facClass = new Faculty();
    $branchClass = new Branch();
    $exchangeClass = new ExchangeValue();
    $buildingClass = new Building();
    $floorClass = new Floor();
    $roomClass = new Room();

?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลนักศึกษาหอพัก</title>
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

        html {
            scroll-behavior: smooth;
        }

        .dataTables_filter {
            padding: 0 0 0.5rem 0;
        }

        .dataTables_filter input {
            padding: 0.1rem 0.5rem;
            outline: none;
            border: 1px solid #222;
        }

        .dataTables_length {
            font-size: 14px;
            margin-top: 0.2rem;
        }

        .dataTables_paginate a {
            font-size: 13px;
            margin-top: 6px;
        }

        .dataTables_info {
            margin-top: 10px;
            font-size: 13px;
        }

        .dataTables_length select {
            border: 1px solid #222;
        }

    </style>
</head>
<body class="font_prompt">

    <?php
    
        $dataStd = $stdClass->Select_Sort('std_id, room_id, branch_id, std_status, std_id_student, std_sex, std_firstname, std_lastname, std_tel, std_address, created_at', 'created_at DESC', '', 0);
        $dataTable = array();
        $buildingNameForXlsx = array();
        $addressStdForXlsx = array();
        $valueBranch = NULL;
        $valueFac = NULL;
        $valueRoom = NULL;
        $i = 0;

        while ($valueStd = $dataStd->fetch(PDO::FETCH_ASSOC)) {
            if ($valueStd['branch_id'] != null) {
                $valueBranch = $branchClass->Find('fac_id, branch_name', 'branch_id', $valueStd['branch_id']);
                $valueBranch = $valueBranch->fetch(PDO::FETCH_ASSOC);
                $valueFac = $facClass->Find('fac_name', 'fac_id', $valueBranch['fac_id']);
                $valueFac = $valueFac->fetch(PDO::FETCH_ASSOC);
            }
            array_push($dataTable, array("", "", "", "", "", "", "", "", "", "", "", ""));

            $dataTable[$i][0] = $valueStd['std_id'];
            $dataTable[$i][1] = $valueStd['std_id_student'];
            $dataTable[$i][2] = $exchangeClass->sex_is($valueStd['std_sex']);
            $dataTable[$i][3] = $valueStd['std_firstname'];
            $dataTable[$i][4] = $valueStd['std_lastname'];
            $dataTable[$i][5] = $valueStd['std_tel'];
            $dataTable[$i][6] = (isset($valueFac['fac_name']) ? $valueFac['fac_name'] : '');
            $dataTable[$i][7] = ($valueStd['branch_id'] != null ? $exchangeClass->getBranchShort($valueBranch['branch_name']) : '-');
            $dataTable[$i][10] = explode(' ', explode('จ.', $valueStd['std_address'])[1])[0];
            $addressStdForXlsx[$i] = $valueStd['std_address'];
            $dataTable[$i][11] = explode(',', $exchangeClass->DateThai($valueStd['created_at']))[0];
            $dataTable[$i][8] = ($valueStd['std_status'] == '1' ? 'นศ.ใหม่' : 'นศ.หอพัก');

            if ($valueStd['room_id'] != NULL) {
                $valueRoom = $roomClass->Find('room_name, floor_id', 'room_id', $valueStd['room_id']);
                $valueRoom = $valueRoom->fetch(PDO::FETCH_ASSOC);
                $dataTable[$i][9] = $valueRoom['room_name'];
                
                $valueFloor = $floorClass->Find('building_id', 'floor_id', $valueRoom['floor_id']);
                $valueFloor = $valueFloor->fetch(PDO::FETCH_ASSOC);

                $valueBuilding = $buildingClass->Find('building_name', 'building_id', $valueFloor['building_id']);
                $valueBuilding = $valueBuilding->fetch(PDO::FETCH_ASSOC);
                array_push($buildingNameForXlsx, $valueBuilding['building_name']);
            } else {
                array_push($buildingNameForXlsx, '');
            }
            $i++;
        }
        echo "<script>var data_Table = ". json_encode($dataTable) .";</script>";
    ?>

    <div class="flex">
        <!-- Sidebar -->
        <?php include ('./adm_file_link/sidebar.php'); ?>
        <!-- Navbar -->
        <div id="main" class="overflow-x-hidden flex flex-col w-full lg:w-11/12 ml-0 lg:ml-64 trasition-all duration-300 bg-gray-200 h-screen">
            <?php include ('./adm_file_link/navbar.php'); ?>

            <!-- SESSION -->
                <session id="manage_main" class="m-2 font_kanit bg-gray-100 flex flex-col justify-center items-center w-min-screen pb-10 mt-6 md:ml-8 md:mr-8 md:pr-4 md:pl-4 rounded-md shadow-md">
                    
                    <div class="w-full text-left breadcrumbs m-2 ml-10 sm:ml-4 tracking-wide" style="font-size: 0.8rem;">
                        <ul>
                            <li>
                                <i class="fas fa-lg fa-users mr-2"></i>
                                <a href="./member_manage.php">
                                    จัดการสมาชิก
                                </a>
                            </li> 
                        </ul>
                    </div>

                    <div class="header flex flex-col md:flex-row items-center justify-between w-11/12">
                        <p class="text-lg text-center sm:text-left mb-5 mt-10 sm:mb-6 text-xl mb-2 w-11/12 sm:pl-2 text-red-900">
                            ข้อมูลนักศึกษาหอพัก
                        </p>
                        <a href="./export_data.php" class="btn btn-xs w-9/12 mb-4 sm:mb-0 sm:mt-6 md:w-40">
                            ส่งออกข้อมูลนักศึกษา
                        </a>
                    </div>

                    <div class="flex flex-col justify-center items-center overflow-x-auto p-1.5 w-11/12">

                        <div class="p-1.5 w-full">
                            <div>
                                <table id="table_DataStd" class="hidden table table-zebra table-compact font_sarabun">
                                    <thead>
                                        <tr class="h-12">
                                            <th></th> 
                                            <th>รหัสนักศึกษา</th> 
                                            <th>คำนำ</th> 
                                            <th>ชื่อจริง</th> 
                                            <th>นามสกุล</th> 
                                            <th>เบอร์โทรศัพท์</th> 
                                            <th>คณะ</th> 
                                            <th>สาขา</th>
                                            <th>สถานะ นศ.</th>
                                            <th>อยู่ห้องพัก</th>
                                            <th>จากจังหวัด</th>
                                            <th>เข้าร่วมเมื่อ</th>
                                        </tr>
                                    </thead> 
                                    <tbody id="sub_datas">
                                    </tbody> 
                                </table>
                            </div>
                        </div>

                    </div>

                </session>

            <div class="overlay fixed hidden z-10 w-full h-full bg-black opacity-30"></div>

            <div class="flex flex-row justify-end w-11/12 mt-8">
                <a href="#choice_destroyStd" id="btn_select_destroy" class="p-1 pr-3 pl-3 text-sm bg_card_purple_hv text-white rounded-md">
                    ทางเลือกการนำนักศึกษาออกจากระบบ
                </a>
            </div>

            <div id="choice_destroyStd" class="hidden flex justify-center w-full mt-10 h-screen">
                
                <form action="#" method="POST" name="constant_manage" class="mt-10 w-11/12 mx-auto">
                    <div class="font_sarabun bg-gray-100 rounded-2xl border-2 border-indigo-900 border-opacity-60 w-full p-2 pt-8 pb-8 flex flex-col text-center items-center">
                        <p class="text-lg text-black tracking-wide">ลบข้อมูลนักศึกษาออกจากระบบ <br class="sm:hidden"> ตาม " ปี " ของรหัสนักศึกษา</p>
                        <p class="mt-1 text-lg text-black tracking-wide">ตัวอย่าง&nbsp;&nbsp;<span class="underline mr-0.5">63</span>06021621138 <br class="sm:hidden">&nbsp;&nbsp;<span class="text-red-900">(แนะนำ)</span></p>
                        <div class="w-64 flex flex-col gap-y-4 mt-4">
                            <select name="select_year" required class="select_year p-2 text-center w-full shadow-md border-2 border-black border-opacity-10">
                                <option disabled selected>- เลือกปีที่ต้องการ -</option>
                                <?php 
                                    $yearIdStd = $stdClass->getYearStdIdForDestroyStd();
                                    while ($value = $yearIdStd->fetch(PDO::FETCH_ASSOC)):
                                ?>
                                    <option value="<?php echo $value['stdYearId'] ?>"><?php echo $value['stdYearId']; ?></option>
                                <?php 
                                    endwhile;
                                ?>
                            </select>
                            <div class="grid grid-cols-5 justify-center items-center mt-3">
                                <input type="checkbox" class="checkboxStatusDestroy checkbox checkbox-primary" checked>
                                <div class="grid-start-2 col-span-4 text-left">
                                    <p>เฉพาะ นศ. ที่ไม่ได้อยู่ในห้องพัก</p>
                                    <p class="text-sm">(หากต้องการลบ นศ. ทุกคนในปีที่เลือก&nbsp;&nbsp;ให้นำเครื่องหมายถูกออก)</p>
                                </div>
                            </div>
                            <div class="btn_destroyStdFormYearCheck bg_card_red_on_hv hover:bg-red-800 cursor-pointer font_prompt text-center text-white rounded-lg h-10 w-full p-4 flex justify-center items-center">
                                ลบออกจากระบบตามปีรหัส นศ.
                            </div>
                        </div>
                    </div>

                    <div class="font_sarabun mt-10 bg-gray-100 rounded-2xl border-2 border-red-900 border-opacity-60 w-full p-2 pt-8 pb-8 flex flex-col text-center items-center">
                        <p class="text-lg text-black tracking-wide">ลบข้อมูลนักศึกษาออกทุกคนออกจากระบบ !!</p>
                        <div class="w-64 flex flex-col gap-y-4 mt-4">
                            <div class="grid grid-cols-5 justify-center items-center mt-3">
                                <input type="checkbox" class="checkboxStatusDestroy checkbox checkbox-primary" checked>
                                <div class="grid-start-2 col-span-4 text-left">
                                    <p>เฉพาะ นศ. ที่ไม่ได้อยู่ในห้องพัก</p>
                                    <p class="text-sm">(หากต้องการลบ นศ. ทุกคน&nbsp;&nbsp;ให้นำเครื่องหมายถูกออก)</p>
                                </div>
                            </div>
                        </div>
                        <div class="btn_destroyAllStdCheck bg_card_red_on_hv hover:bg-red-800 cursor-pointer w-64 flex flex-col gap-y-4 mt-4 font_prompt text-center text-white rounded-lg h-10 p-4 flex justify-center items-center">
                            ลบนักศึกษาทุกคนออกจากระบบ
                        </div>
                    </div>
                    
                    <input type="text" name="status_destroyStdFormYear" class="hidden status_destroyStdFormYear" value="1">
                    <input type="text" name="status_destroyAllStd" class="hidden status_destroyAllStd" value="1">
                    <input type="submit" name="btn_destroyStdFormYear" class="hidden btn_destroyStdFormYear">
                    <input type="submit" name="btn_destroyAllStd" class="hidden btn_destroyAllStd">

                </form>
            </div>

            <div class="space mb-20"></div>

        </div>

    </div>

    <script type="text/javascript" src="./../assets/js/_title_change.js" onload="switchTitle('ข้อมูลนักศึกษาหอพัก')"></script>
    <script type="text/javascript" src="./../assets/js/_adm_select_menu.js" onload="select_menu(4)"></script>
    <script type="text/javascript" src="../assets/js/_adm_member_manage.js"></script>
    <script type="text/javascript">
        // window.$('#table_DataStd').DataTable();
        $(document).ready(function () {
            $("#table_DataStd").DataTable({
                "lengthMenu": [10, 25, 50, 70, 100, 500, 1000, 2000]
            });
        });

        let sub_datas = document.getElementById('sub_datas');
        let str_innerHtmlTable = "", str_innerHtmlSelectNextData = "";
        for (let r = 0; r < data_Table.length; r++) {
            str_innerHtmlTable += `<tr class="hover:text-blue-800">`;
            str_innerHtmlTable += `<td><a href="#" class="font-bold">${r+1}</a></td>`;
            for (let c = 1; c < data_Table[0].length; c++) {
                str_innerHtmlTable += `<td><a href="./sub_member_manage.php?dataStd&std_id=${data_Table[r][0]}">${(data_Table[r][c] == undefined ||
                                                    data_Table[r][c] == '' ? '-' : data_Table[r][c])}</a></td>`;
            }
            str_innerHtmlTable += `</tr>`;
        }
        sub_datas.innerHTML = str_innerHtmlTable;

        setTimeout(() => {
            document.getElementById('table_DataStd').classList.remove('hidden');
        }, 50);

        document.getElementById('btn_select_destroy').addEventListener('click', () => {
            document.getElementById('choice_destroyStd').classList.toggle('hidden');
        });

    </script>
    

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
                        timer: 2000
                    })
                    
                    setTimeout(() => {
                        window.location.href='./member_manage.php';
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

        $stdClass->autoChangeStatusStd(1);
        $stdClass->autoDestroyStdAll(7);
        $stdClass->autoDestroyStdIsNotRoomId(5);
    
        if (isset($_POST['btn_destroyStdFormYear'])) {
            if($stdClass->destroyStdByYear($_POST['status_destroyStdFormYear'], $_POST['select_year'])) {
                switch (intval($_POST['status_destroyStdFormYear'])) {
                    case 0:
                        alertPopup(1, 'ลบข้อมูลนักศึกษาตามปีรหัส นศ. สำเร็จ');
                        break;
                    case 1:
                        alertPopup(1, 'ลบข้อมูลนักศึกษาตามปีรหัส นศ. สำเร็จ,<br>เฉพาะคนที่ไม่ได้อยู่ในห้องพักสำเร็จ');
                        break;
                }
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['btn_destroyAllStd'])) {
            if($stdClass->destroyStdAll($_POST['status_destroyAllStd'])) {
                switch (intval($_POST['status_destroyStdFormYear'])) {
                    case 0:
                        alertPopup(1, 'ลบข้อมูลนักศึกษาทั้งหมดสำเร็จ');
                        break;
                    case 1:
                        alertPopup(1, 'ลบข้อมูลนักศึกษาทั้งหมดสำเร็จ,<br>เฉพาะคนที่ไม่ได้อยู่ในห้องพัก');
                        break;
                }
            } else {
                alertPopup(0, '');
            }
        }
    
    ?>


</body>
</html>