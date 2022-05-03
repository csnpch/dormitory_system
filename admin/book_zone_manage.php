<?php 
    session_start();
    require_once ('./../disable_error_report.php');
    require_once ('./../classes/Admin.php');
    $adminClass = new Admin();

    if (!isset($_SESSION['adm_id'])) {
        header('Location: ../admin/login.php');
    }

    require_once ('../classes/Branch.php');
    require_once ('../classes/ExchangeValue.php');
    require_once ('../classes/Building.php');
    require_once ('../classes/Floor.php');
    require_once ('../classes/Room.php');
    require_once ('../classes/Book.php');
    $branchClass = new Branch();
    $exchangeClass = new ExchangeValue();
    $buildingClass = new Building();
    $floorClass = new Floor();
    $roomClass = new Room();
    $bookClass = new Book();

?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ปลดการเข้าพัก นศ.</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <link rel="stylesheet" href="../assets/css/style_x_tailwind.css">
    <link rel="icon" href=" ../assets/img/logoKmutnb.webp">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../assets/node_modules/daisyui/dist/full.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <style>
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
                    
                    <div class="text-left breadcrumbs m-2 ml-2 sm:ml-4 tracking-wide w-full" style="font-size: 0.8rem;">
                        <ul>
                            <li>
                                <i class="fas fa-bed mr-2"></i>
                                <a href="./book_manage.php">
                                    การจองห้องพัก
                                </a>
                            </li> 
                            <li>
                                <i class="fas fa-lg fa-cogs mr-2"></i>
                                <a href="./book_zone_manage.php">
                                    จัดสรรห้องตามสาขา
                                </a>
                            </li>
                        </ul>
                    </div>

                    <?php

                        $dataBuilding = $buildingClass->Select_Sort('building_id, building_name, building_gender', 'created_at ASC', '', 0);
                        $arrayBuilding = array();
                        $i = 0;
                        while($valBuilding = $dataBuilding->fetch(PDO::FETCH_ASSOC)) {
                            array_push($arrayBuilding, array('', '', ''));
                            $arrayBuilding[$i][0] = $valBuilding['building_id'];
                            $arrayBuilding[$i][1] = $valBuilding['building_name'];
                            $arrayBuilding[$i][2] = $valBuilding['building_gender'];
                            $i++;
                        }
                        
                        $get_building_id = (isset($_GET['building']) ? $_GET['building'] : $arrayBuilding[0][0]);
                        $dataFloor = $floorClass->Find_Sort('building_id, floor_id, floor_name', 'building_id', $get_building_id, 'floor_name ASC', '');
                        $arrayFloor = array();
                        $i = 0;
                        while($valueFloor = $dataFloor->fetch(PDO::FETCH_ASSOC)) {
                            array_push($arrayFloor, array('', '', ''));
                            $arrayFloor[$i][0] = $valueFloor['building_id'];
                            $arrayFloor[$i][1] = $valueFloor['floor_id'];
                            $arrayFloor[$i][2] = $valueFloor['floor_name'];
                            $i++;
                        }
                    
                    ?>

                    <div class="select_area">
                        <p class="mt-10 mb-4 text-lg text-red-900 w-full text-center">โปรดเลือกเพื่อดำเนินการ</p>
                        <div class="gap-x-4 flex flex-row justify-center">
                            <div class="gap-y-2 flex flex-col justify-center items-center">
                                <select id="select_building" name="select_building" class="select select-bordered w-full max-w-xs" onchange="get_select_option_book(0)">
                                    <?php for ($i = 0; $i < count($arrayBuilding); $i++): ?>
                                        <option value="<?php echo $arrayBuilding[$i][0] ?>"><?php echo $arrayBuilding[$i][1] ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="gap-y-2 flex flex-col justify-center items-center">
                                <select id="select_floor" name="select_floor" class="select select-bordered w-full max-w-xs" onchange="get_select_option_book(1)">
                                    <option selected disabled>- เลือกชั้น -</option>
                                    <?php for ($i = 0; $i < count($arrayFloor); $i++): ?>
                                        <option value="<?php echo $arrayFloor[$i][1] ?>"><?php echo $arrayFloor[$i][2] ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <?php if(isset($_GET['floor'])): ?>
                            <p class="lg:-mb-20 mt-12 w-full text-center text-lg text-blue-800">" โปรดคลิ๊กเลือกห้องที่ต้องการ "</p>
                        <?php endif; ?>
                    </div>

                    <?php 
                        echo "<script>select_option('select_building', ".$get_building_id.")</script>";
                        if (isset($_GET['floor'])) {
                            echo "<script>select_option('select_floor', ".$_GET['floor'].")</script>";
                        }
                    ?>

                    <div class="flex flex-col justify-center items-center overflow-x-auto p-1.5 w-11/12">

                        <div class="p-1.5 w-full mt-10">
                            <form action="#" method="POST">
                                <table id="table_data" class="hidden table table-zebra table-compact font_sarabun">
                                    <thead>
                                        <tr class="h-12">
                                            <th class="text-center w-4">#</th>
                                            <th class="text-center w-40">สถานะห้อง</th>
                                            <th class="text-left w-20" title="หากต้องการใช้ฟังก์ชั่นนี้ โปรดเลือกโชว์ข้อมูลสูงสุด(ทั้งหมด)ทางซ้ายบน"><input id="checkbox_all" type="checkbox" onclick="checkBoxAll()" class="checkbox checkbox-sm checkbox-primary mr-2">ชื่อห้องพัก</th>
                                            <th class="w-96">โซนสาขา</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sub_datas">
                                        <?php
                                            if (isset($_GET['floor'])):
                                                $dataBranch = $branchClass->Select_All('branch_id, branch_name');
                                                $arrayBranch = array();
                                                $i = 0;
                                                while($valueBranch = $dataBranch->fetch(PDO::FETCH_ASSOC)) {
                                                    array_push($arrayBranch, array('', ''));
                                                    $arrayBranch[$i][0] = $valueBranch['branch_id'];
                                                    $arrayBranch[$i][1] = $valueBranch['branch_name'];
                                                    $i++;
                                                }
                                                $dataRoom = $roomClass->Find_Sort('room_id, floor_id, room_name, room_status', 'floor_id', $_GET['floor'], 'room_name ASC', '');
                                                $dataBook = $bookClass->Select_All('book_id, branch_id, room_id');
                                                $arrayBook = array();
                                                $i = 0;
                                                while($valueBook = $dataBook->fetch(PDO::FETCH_ASSOC)) {
                                                    array_push($arrayBook, array('', '', ''));
                                                    $arrayBook[$i][0] = $valueBook['book_id'];
                                                    $arrayBook[$i][1] = $valueBook['branch_id'];
                                                    $arrayBook[$i][2] = $valueBook['room_id'];
                                                    $i++;
                                                }
                                                $i = 0;
                                                while ($valueRoom = $dataRoom->fetch(PDO::FETCH_ASSOC)):
                                                    $valueBranch = array('NULL', 'NULL');
                                                    for ($r = 0; $r < count($arrayBook); $r++) {
                                                        for ($c = 0; $c < count($arrayBranch); $c++) {
                                                            if ($arrayBook[$r][1] == $arrayBranch[$c][0] && $arrayBook[$r][2] == $valueRoom['room_id']) {
                                                                $valueBranch[0] = $arrayBranch[$c][0];
                                                                $valueBranch[1] = $arrayBranch[$c][1];
                                                                break;
                                                            } else if (($arrayBook[$r][1] == NULL && $arrayBook[$r][2] == $valueRoom['room_id'])) {
                                                                $valueBranch[0] = 'FREE';
                                                                $valueBranch[1] = 'ได้รับการจัดสรรสำหรับทุกสาขา';
                                                            }
                                                        }
                                                    }
                                        ?>
                                                    <?php echo "<script>console.log('". $valueBranch[0] .", ". $valueBranch[1] . "')</script>"; ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $i+1; ?></td>
                                                        <td class="text-center <?php echo ($valueRoom['room_status'] == 0 ? 'text-red-900' : 'text-green-900') ?>"><?php echo ($valueRoom['room_status'] == 0 ? 'ปิดใช้งาน' : 'ปกติ') ?></td>
                                                        <td class="text-left flex items-center">
                                                            <input class="checkbox_room checkbox checkbox-sm checkbox-primary mr-2" type="checkbox" name="check_book_room[]" value="<?php echo $valueRoom['room_id'] ?>">
                                                            <?php echo $valueRoom['room_name']; ?>
                                                        </td>
                                                        <td class="
                                                            <?php echo ($valueBranch[0] == 'NULL' ? 'text-red-900' : (($valueBranch[0] == 'FREE' || $valueBranch[0] == '-' || $valueBranch[0] == 0) ? 'text-green-900' : 'text-blue-900')) ?>">
                                                            <?php echo ($valueBranch[0] == 'NULL' ? 'ยังไม่ได้รับการจัดสรร (จะไม่แสดงหน้าจองห้องพัก)' : (($valueBranch[0] == 'FREE' || $valueBranch[0] == '-' || $valueBranch[0] == 0) ? (($valueBranch[1] == '-' || $valueBranch[1] == 0) ? 'ได้รับการจัดสรรสำหรับทุกสาขา' : $valueBranch[1]) : 'จัดสรรให้ : '.$valueBranch[1])) ?>
                                                        </td> 
                                                    </tr>
                                        <?php 
                                                $i++;
                                                endwhile;
                                            endif;
                                        ?>
                                    </tbody> 
                                </table>
                                <?php 
                                    if (isset($_GET['floor'])):
                                ?>
                                    <div class="mt-6 w-full flex flex-col items-center justify-center">
                                        <p class="mb-2 text-lg text-blue-800">" เลือกสาขาที่ต้องการจัดสรรให้ห้องที่คุณเลือก "</p>
                                        <select name="select_branch" class="select select-bordered w-full md:w-96">
                                            <option value="FREE"># จัดสรรสำหรับทุกสาขา</option>
                                            <?php for($i = 0; $i < count($arrayBranch); $i++): ?>
                                                <?php if ($arrayBranch[$i][1] != '-'): ?>
                                                    <option value="<?php echo $arrayBranch[$i][0] ?>"><?php echo $arrayBranch[$i][1]; ?></option>
                                                <?php endif; ?>        
                                            <?php endfor; ?>
                                            <option value="DESTROY"># ยกเลิกการจัดสรร</option>
                                        </select>
                                        <button name="btn_saveData" class="mt-4 btn btn-sm btn-success">จัดสรรห้อง & บันทึก</button>
                                    </div>
                                <?php 
                                    //  IF BRANCH in book is null = all branch to book
                                    endif;
                                ?>
                            </form>
                        </div>

                    </div>

                </session>

            <div class="overlay fixed hidden z-10 w-full h-full bg-black opacity-30"></div>

            <div class="space mb-40"></div>

        </div>

    </div>

    <script type="text/javascript" src="./../assets/js/_title_change.js" onload="switchTitle('จัดการห้องตามสาขา')"></script>
    <script type="text/javascript" src="./../assets/js/_adm_select_menu.js" onload="select_menu(6)"></script>
    <script type="text/javascript" src="./../assets/js/_adm_book_zoon_manage.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $("#table_data").DataTable({
                "autoWidth": false,
                "pageLength": 200,
                "lengthMenu": [10 ,20, 40, 60, 80, 100, 200, 500],
            });
        });

        setTimeout(() => {
            document.getElementById('table_data').classList.remove('hidden');
        }, 50);

    </script>
    
    <?php 
    
        if (isset($_POST['check_book_room'])) {
            $branch_id = ($_POST['select_branch'] == 'FREE' ? NULL : $_POST['select_branch']);
            foreach ($_POST['check_book_room'] as $room_id){ 
                $statusSearch = false;
                if ($_POST['select_branch'] == 'DESTROY') {
                    for ($i = 0; $i < count($arrayBook); $i++) {
                        if ($room_id == $arrayBook[$i][2]) {
                            $book_id = $arrayBook[$i][0];
                            $statusSearch = true;
                            break;
                        }
                    }
                    if ($statusSearch) {
                        $bookClass->Delete($book_id);
                    }
                } else {
                    $statusSearch = false;
                    for ($i = 0; $i < count($arrayBook); $i++) {
                        if ($room_id == $arrayBook[$i][2]) {
                            $book_id = $arrayBook[$i][0];
                            $statusSearch = true;
                            break;
                        }
                    }
                    if ($statusSearch) {
                        $bookClass->Update($book_id, $branch_id, $room_id);
                    } else {
                        $bookClass->Insert($branch_id, $room_id);
                    }
                }
            }
            echo "<script type='text/javascript'>
                    Swal.fire({
                        title: 'ดำเนินการสำเร็จ',
                        text: '',
                        icon: 'success',
                        showConfirmButton: false,
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'ปิด'
                    }).then(setTimeout(() => {
                        window.location = './book_zone_manage.php?building=".$_GET['building']."&floor=".$_GET['floor']."'
                    }, 1000));
                </script>";
        }
    
    ?>

</body>
</html>