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

    require_once ('./../classes/News.php');
    require_once ('./../classes/ExchangeValue.php');
    require_once ('../classes/Student.php');
    require_once ('../classes/FixReport.php');
    require_once ('../classes/Room.php');
    
    $newsClass = new News();
    $exchangeClass = new ExchangeValue();
    $stdClass = new Student();
    $fixClass = new FixReport();
    $roomClass = new Room();

    $fixClass->autoDestroyFixs(7);

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
        function changeColorStatus(n, status) {
            setTimeout(() => {
                switch(status) {
                    case 0: document.getElementsByClassName('txtStatus')[n].classList.add('text-green-600');
                        break;
                    case 1: document.getElementsByClassName('txtStatus')[n].classList.add('text-red-500');
                        break;
                    case 2: document.getElementsByClassName('txtStatus')[n].classList.add('text-red-800');
                }
            }, 100);
        }
    </script>

    <div class="flex">
        <!-- Sidebar -->
        <?php include ('./adm_file_link/sidebar.php'); ?>
        <!-- Navbar -->
        <div id="main" class="overflow-x-hidden flex flex-col w-full lg:w-11/12 ml-0 lg:ml-64 trasition-all duration-300 bg-gray-200 h-screen">
            <?php include ('./adm_file_link/navbar.php'); ?>

            <!-- SESSION -->
            <session class="mt-10 font_kanit bg-gray-100 flex flex-col justify-center items-center w-min-screen pb-10 mt-6 md:ml-8 md:mr-8 md:pr-4 md:pl-4 rounded-md shadow-md">
                <p class="defocus pt-4 flex items-center sm:ml-4 text-lg mb-6 mt-4 text-red-900">
                    รายการแจ้งซ่อมที่ยังไม่เสร็จสิ้น
                </p>
                <div class="w-11/12 lg:w-full overflow-x-auto border-2 border-black border-opacity-20">
                    <table class="table w-full overflow-y-auto">
                        <thead>
                            <th class="hidden"></th>
                            <th class="font-normal lg:w-80">ชื่อรายการ</th>
                            <th class="font-normal">สถานที่</th>
                            <th class="font-normal text-center">แจ้งซ่อมจากนักศึกษา</th>
                            <th class="font-normal text-center">เวลาที่แจ้ง</th>
                            <th class="font-normal text-center">สถานะ</th>
                            <th class="font-normal text-center">ดำเนินการ</th>
                        </thead>
                        <tbody>
                            <?php 
                                $dataFix = $fixClass->Find_Sort('fix_id, std_id, fix_detail, fix_area, created_at, fix_status', 'fix_status', '2 OR fix_status = 1', 'fix_status DESC', '');
                                // $dataFix = $fixClass->Find_Order('fix_detail, fix_status', 'std_id', $_SESSION['std_id'], 'fix_status', 'ASC');
                                $n = 0;
                                while ($value = $dataFix->fetch(PDO::FETCH_ASSOC)):
                                    switch (intval($value['fix_status'])) {
                                        case 0: 
                                            echo "<script>changeColorStatus(".$n.', 0'.");</script>";
                                            break;
                                        case 1:
                                            echo "<script>changeColorStatus(".$n.', 1'.");</script>";
                                            break;
                                        case 2:
                                            echo "<script>changeColorStatus(".$n.', 2'.");</script>"; 
                                    }
                                    if ($value['std_id'] != null) {
                                        $valueStd = $stdClass->Find('std_id, room_id, std_sex, std_firstname, std_lastname', 'std_id', $value['std_id']);
                                        $valueStd = $valueStd->fetch(PDO::FETCH_ASSOC);
                                    }
                            ?>
                                    <tr class="font-light">
                                        <td class="hidden"></td>
                                        <td><textarea disabled name="" class="p-2 h-14 w-full text-blue-900"><?php echo $value['fix_detail']; ?></textarea></td>
                                        <td><?php echo $value['fix_area']; ?></td>
                                        <td>
                                            <?php if ($value['std_id'] != null): ?>
                                                <a class="hover:text-blue-800 hover:underline" href="./sub_member_manage.php?dataStd&std_id=<?php echo ($value['std_id'] !== '' ? $value['std_id'] : '') ?>"></a>
                                                <?php
                                                    echo $valueStd['std_firstname'].' '.$valueStd['std_lastname']; 
                                                ?>
                                            <?php else: ?>
                                                ไม่มี นศ. ในระบบแล้ว !
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $exchangeClass->DateThai($value['created_at']); ?></td>
                                        <td class="txtStatus"><?php echo $exchangeClass->status_fix_is($value['fix_status']); ?></td>
                                        <td>
                                            <center>
                                            <form action="#" method="POST">
                                                <input name="id_fix" class="hidden" type="text" value="<?php echo $value['fix_id'] ?>">
                                                <?php if($value['fix_status'] == 2): ?>
                                                    <button name="btn_receive_fix" class="btn btn-sm btn-error hover:text-black"><p class="font-normal">รับเรื่อง</p></button>
                                                <?php elseif ($value['fix_status'] == 1): ?>
                                                    <button name="btn_success_fix" class="btn btn-sm btn-warning hover:text-black"><p class="font-normal">ทำเครื่องหมายว่าซ่อมแล้ว</p></button>
                                                <?php endif; ?>
                                            </form>
                                            </center>
                                        </td>
                                    </tr>
                            <?php
                                    $n++;
                                endwhile;
                                if ($dataFix->rowCount() === 0):
                            ?>
                                    <td colspan="6" class="text-blue-800 pb-4 underline text-center pt-10">" ยังไม่มีรายการแจ้งซ่อมเข้ามาใหม่ "</td>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </session>

            <session id="manage_main" class="font_kanit bg-gray-100 flex flex-col justify-center items-center w-min-screen pb-10 mt-6 md:ml-8 md:mr-8 md:pr-4 md:pl-4 rounded-md shadow-md">
                
                <div class="header flex items-center justify-between w-11/12">
                    <p class="text-lg text-center sm:text-left mb-5 mt-10 sm:mb-6 text-xl mb-2 w-11/12 sm:pl-2 text-red-900">รายการแจ้งซ่อมทั้งหมด</p>
                </div>

                <?php 
                    $dataNews = $newsClass->Select_Order('*', 'created_at', 'DESC');
                ?>

                <div class="flex flex-col justify-center items-center overflow-x-auto p-1.5 w-11/12">

                    <div class="p-1.5 w-full">
                        <table id="table_data" class="hidden text-center table table-zebra table-compact font_sarabun">
                            <thead>
                                <tr class="h-12">
                                    <th class="font-normal">#</th>
                                    <th class="font-normal">ชื่อรายการ</th>
                                    <th class="font-normal text-center">สถานที่</th>
                                    <th class="font-normal">แจ้งซ่อมจากนักศึกษา</th>
                                    <th class="font-normal">เวลาที่แจ้ง</th>
                                    <th class="font-normal text-center">สถานะ</th>
                                </tr>
                            </thead> 
                            <tbody id="sub_datas">
                            <?php
                                $i = 0;
                                $valueFix = $fixClass->Select_Order('fix_id, std_id, fix_detail, fix_area, created_at, fix_status', 'created_at', 'DESC');
                                while($value = $valueFix->fetch(PDO::FETCH_ASSOC)):
                                    if (isset($value['std_id'])) {

                                        $valueStd = $stdClass->Find('room_id, std_sex, std_firstname, std_lastname', 'std_id', $value['std_id']);
                                        $valueStd = $valueStd->fetch(PDO::FETCH_ASSOC);
                                    }
                            ?>
                                    <tr class="">
                                        <td><?php echo ($i+1); ?></td>
                                        <td><textarea disabled class="w-full p-2 lg:w-96 text-blue-900"><?php echo $value['fix_detail']; ?></textarea></td>
                                        <td>
                                            <p class="text-center"><?php echo ($value['fix_area'] == '' ? 'ไม่ระบุ' : $value['fix_area']) ?></p>
                                        </td>
                                        <td>
                                            <?php if ($value['std_id'] != null): ?>
                                                <a class="hover:text-blue-800 hover:underline" href="./sub_member_manage.php?dataStd&std_id=<?php echo ($value['std_id'] !== '' ? $value['std_id'] : '') ?>"></a>
                                                <?php
                                                    echo $valueStd['std_firstname'].' '.$valueStd['std_lastname']; 
                                                ?>
                                            <?php else: ?>
                                                ไม่มี นศ. ในระบบแล้ว !
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $exchangeClass->DateThai($value['created_at']); ?></td>
                                        <td><p class="<?php echo ($value['fix_status'] == '0' ? 'text-green-800' : ($value['fix_status'] == '1' ? 'text-yellow-600' : 'text-red-800')); ?>"><?php echo $exchangeClass->status_fix_is($value['fix_status']); ?></p></td>
                                    </tr>
                            <?php 
                                $i++;
                                endwhile;
                            ?>
                            </tbody> 
                        </table>
                    </div>

                </div>

            </session>

            <div class="overlay fixed hidden z-10 w-full h-full bg-black opacity-30"></div>

            <div class="space mb-40"></div>

        </div>

    </div>

    <script type="text/javascript" src="./../assets/js/_title_change.js" onload="switchTitle('รายการแจ้งซ่อม')"></script>
    <script type="text/javascript" src="./../assets/js/_adm_select_menu.js" onload="select_menu(7)"></script>
    <script type="text/javascript" src="../assets/js/_adm_news_manage.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#table_data").DataTable();
        });

        setTimeout(() => {
            document.getElementById('table_data').classList.remove('hidden');
        }, 50);
    </script>

    <?php 
        
        if (isset($_POST['btn_receive_fix'])) {
            if ($fixClass->ChangeStatusFix($_POST['id_fix'], 1)) {
                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: 'รับเรื่องซ่อมสำเร็จ',
                        text: '',
                        icon: 'success',
                        showConfirmButton: false,
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'ปิด'
                    }).then(setTimeout(() => {
                        window.location.href='./fix_manage.php'
                    }, 2000));
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'เกิดข้อผิดพลาด, โปรดลองใหม่',
                        text: '',
                        icon: 'error',
                        showConfirmButton: false,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'ปิด'
                    })
                </script>";
            }
        } else if (isset($_POST['btn_success_fix'])) {
            if ($fixClass->ChangeStatusFix($_POST['id_fix'], 0)) {
                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: 'ทำเครื่องหมายว่าซ่อมเสร็จแล้ว',
                        text: '',
                        icon: 'success',
                        showConfirmButton: false,
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'ปิด'
                    }).then(setTimeout(() => {
                        window.location.href='./fix_manage.php'
                    }, 2000));
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'เกิดข้อผิดพลาด, โปรดลองใหม่',
                        text: '',
                        icon: 'error',
                        showConfirmButton: false,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'ปิด'
                    })
                </script>";
            }
        }
    
    ?>

</body>
</html>