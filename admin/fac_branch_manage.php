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

    require_once ('../classes/Branch.php');
    require_once ('../classes/Faculty.php');
    require_once ('../classes/ExchangeValue.php');
    require_once ('../classes/Building.php');
    require_once ('../classes/Floor.php');
    require_once ('../classes/Room.php');
    require_once ('../classes/Book.php');
    require_once ('../classes/Log.php');
    $branchClass = new Branch();
    $facClass = new Faculty();
    $exchangeClass = new ExchangeValue();
    $buildingClass = new Building();
    $floorClass = new Floor();
    $roomClass = new Room();
    $bookClass = new Book();
    $logClass = new Log();

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
</head>
<body class="font_prompt">

    <div class="flex">
        <!-- Sidebar -->
        <?php include ('./adm_file_link/sidebar.php'); ?>
        <!-- Navbar -->
        <div id="main" class="overflow-x-hidden flex flex-col w-full lg:w-11/12 ml-0 lg:ml-64 trasition-all duration-300 bg-gray-200 h-screen">
            <?php include ('./adm_file_link/navbar.php'); ?>

            <!-- SESSION -->
            <session id="manage_main" class="font_kanit bg-gray-100 flex flex-col justify-center items-center w-11/12 sm: mx-auto w-min-screen pb-10 mt-6 md:ml-8 md:mr-8 md:pr-4 md:pl-4 rounded-md shadow-md">
   
                <div class="text-black w-full flex flex-col items-center">
                    <p class="mt-8 text-lg text-center w-full text-red-800 mb-8">
                        จัดการคณะ / สาขา                 
                    </p>
                    <div class="w-11/12 md:w-8/12">
                        <?php 
                            $i = 0;
                            $dataFac = $facClass->Select_All('fac_id, fac_name');
                            while($valueFac = $dataFac->fetch(PDO::FETCH_ASSOC)):
                                $dataBranch = $branchClass->Find('fac_id, branch_id, branch_name', 'fac_id', $valueFac['fac_id']);
                        ?>
                            <div onclick="toggleBranch(<?php echo $i; ?>)" class="border-2 border-black border-opacity-20 rounded-md cursor-pointer hover:bg-gray-200 w-full mb-2">
                                <div class="header m-2 flex justify-center h-full w-full">
                                    <span class="w-11/12 ml-4"><?php echo $valueFac['fac_name'] ?></span>
                                    <div class="w-16 flex gap-x-4 mr-5 mt-1">
                                        <i onclick="popupEditFac(<?php echo $valueFac['fac_id'] ?>, '<?php echo $valueFac['fac_name'] ?>')" class="text-center fas fa-pencil-alt text-green-600"></i>
                                        <i onclick="popupDelFac(<?php echo $valueFac['fac_id'] ?>, '<?php echo $valueFac['fac_name'] ?>')" class="fas fa-trash-alt text-red-700"></i>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="branchContainer hidden text-blue-900 w-10/12 mx-auto mb-6 mt-6">
                                <?php
                                    $n = 0;
                                    while($valueBranch = $dataBranch->fetch(PDO::FETCH_ASSOC)):
                                ?>
                                <ul class="flex flex-col mb-6">
                                    <li class="border-b-2 border-black border-opacity-10">
                                        <div class="flex flex-row justify-between items-center">
                                            <span class="ml-2"><?php echo $valueBranch['branch_name'] ?></span>
                                            <div class="w-10 flex gap-x-4 mr-4">
                                                <i onclick="popupEditBranch(<?php echo $valueBranch['branch_id'] ?>, '<?php echo $valueBranch['branch_name'] ?>', <?php echo $valueBranch['fac_id'] ?>)" class="cursor-pointer text-center fas fa-pencil-alt text-indigo-600 text-sm z-20"></i>
                                                <i onclick="popupDelBranch(<?php echo $valueBranch['branch_id'] ?>, '<?php echo $valueBranch['branch_name'] ?>', <?php echo $valueBranch['fac_id'] ?>)" class="cursor-pointer fas fa-trash-alt text-red-700 text-sm"></i>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <?php 
                                    $n++;
                                    endwhile;
                                    if ($n == 0):
                                ?>
                                    <p class="w-full text-center">ไม่พบสาขา</p>
                                <?php 
                                    endif;
                                ?>
                            </div>
                        <?php
                            $i++;
                            endwhile; 
                            if ($i == 0):
                        ?>
                            <p class="w-full text-center">ยังไม่มีข้อมูลคณะ</p>
                        <?php 
                            endif;
                        ?>
                    </div>
                    
                </div>

                <div class="relative flex justify-center">

                    <button class="btn btn-sm mt-6" onclick="document.getElementById('what_addItem').style.display = (document.getElementById('what_addItem').style.display == 'none' ? 'block' : 'none')">
                        เพิ่มข้อมูล
                    </button>
                    <ul id="what_addItem" style="display: none;" class="absolute menu p-2 shadow-lg bg-white rounded-box top-16 w-44 sm:w-44">
                        <li class="menu-title w-full sm:w-40 mb-1">
                            <span>เลือกสิ่งที่ต้องการเพิ่ม</span>
                        </li> 
                        <li class="mb-1">
                            <button id="fac_add_item" class="btn btn-sm btn-info" onclick="document.getElementById('what_addItem').style.display = (document.getElementById('what_addItem').style.display == 'none' ? 'block' : 'none')">
                                เพิ่มคณะ
                            </button>
                        </li> 
                        <li>
                            <button id="branch_add_item" class="btn btn-sm btn-error" onclick="document.getElementById('what_addItem').style.display = (document.getElementById('what_addItem').style.display == 'none' ? 'block' : 'none')">
                                เพิ่มสาขา
                            </button>
                        </li> 
                    </ul>

                </div>

            </session>

            <div class="area_add_fac hidden flex justify-center items-center fixed z-20 w-full md:w-10/12 h-screen font_prompt">
                <form action="#" method="POST">
                    <div class="p-6 rounded-md bg-gray-100 w-96">
                        <p class="text-black font-lg text-center text-lg">เพิ่มคณะ</p>
                        <p class="mt-4 text-red-800 font-lg">ชื่อคณะ</p>
                        <textarea required type="text" name="txt_fac_name" class="txt_fac_name text-black h-10 p-2 pl-3 mt-2 text-md tracking-widest h-16 w-full" placeholder="คณะ...."></textarea>
                        <div class="grid grid-cols-2 mt-4 gap-x-1">
                            <button name="btn_add_fac" class="btn btn-success btn-sm">เพิ่มข้อมูล</button>
                            <button type="reset" class="cancleAddItem btn btn-error btn-sm" onclick="clearPopup()" value="ยกเลิก">ยกเลิก</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="area_add_branch hidden flex justify-center items-center fixed z-20 w-full md:w-10/12 h-screen font_prompt">
                <form action="#" method="POST">
                    <div class="p-6 rounded-md bg-gray-100 w-96">
                        <p class="text-black font-lg text-center text-lg">เพิ่มสาขา</p>
                        <p class="mt-4 text-red-800 font-lg">เลือกคณะ</p>
                        <select required name="select_fac" class="p-2 w-full">
                            <option value="" selected disabled>- เลือกคณะ -</option>
                            <?php 
                                $i = 0;
                                $dataFac = $facClass->Select_All('fac_name, fac_id');                    
                                while($valueFac = $dataFac->fetch(PDO::FETCH_ASSOC)):
                            ?>
                                <option value="<?php echo $valueFac['fac_id'] ?>"><?php echo $valueFac['fac_name'] ?></option>
                            <?php
                                $i++; 
                                endwhile;
                                if ($i == 0): 
                            ?>
                                <option value="" disabled>โปรดเพิ่มคณะก่อน</option>
                            <?php 
                                endif;
                            ?>
                        </select>
                        <p class="mt-4 text-red-800 font-lg">ชื่อสาขา</p>
                        <textarea required type="text" name="txt_branch_name" class="txt_branch_name text-black h-10 p-2 pl-3 mt-2 text-md tracking-widest h-16 w-full" placeholder="สาขา...."></textarea>
                        <p class="mt-2 text-red-800 font-lg">ตัวย่อสาขาภาษาอังกฤษ (ระบุเฉพาะตัวอักษร)</p>
                        <input type="text" name="txt_branch_short" class="mt-2 pl-4 pr-4 h-10 w-full" placeholder="Hi">
                        <div class="grid grid-cols-2 mt-4 gap-x-1">
                            <button name="btn_add_branch" class="btn btn-success btn-sm">เพิ่มข้อมูล</button>
                            <button type="reset" class="cancleAddItem btn btn-error btn-sm" onclick="clearPopup()" value="ยกเลิก">ยกเลิก</button>
                        </div>
                    </div>
                </form>
            </div>


            <form action="#" method="POST" class="popupEditFac hidden z-30 w-full lg:w-10/12 h-screen flex justify-center items-center fixed">
                <div class="p-6 rounded-md bg-gray-100 w-96">
                    <p class="text-black font-lg text-center text-lg">แก้ไขคณะ</p>
                    <p class="mt-4 text-red-800 font-lg">ชื่อคณะ</p>
                    <input type="text" name="txt_fac_id_edit" class="txt_fac_id_edit hidden">
                    <textarea required type="text" name="txt_fac_name_edit" class="txt_fac_name_edit text-black h-10 p-2 pl-3 text-md h-10 w-full" placeholder="สาขา...."></textarea>
                    <div class="grid grid-cols-2 mt-4 gap-x-1">
                        <button name="btn_edit_fac" class="btn btn-success btn-sm">บันทึก</button>
                        <button type="reset" class="cancleAddItem btn btn-error btn-sm" onclick="clearPopup()" value="ยกเลิก">ยกเลิก</button>
                    </div>
                </div>
            </form>


            <form action="#" method="POST" class="popupEditBranch hidden z-30 w-full lg:w-10/12 h-screen flex justify-center items-center fixed">
                <div class="p-6 rounded-md bg-gray-100 w-96">
                    <p class="text-black font-lg text-center text-lg">แก้ไขสาขา</p>
                    <p class="mt-4 text-red-800 font-lg">เลือกคณะ</p>
                    <select required name="select_fac_edit" class="select_fac_edit p-2 w-full">
                        <option value="" selected disabled>- เลือกคณะ -</option>
                        <?php 
                            $i = 0;
                            $dataFac = $facClass->Select_All('fac_name, fac_id');                    
                            while($valueFac = $dataFac->fetch(PDO::FETCH_ASSOC)):
                        ?>
                            <option value="<?php echo $valueFac['fac_id'] ?>"><?php echo $valueFac['fac_name'] ?></option>
                        <?php
                            $i++; 
                            endwhile;
                            if ($i == 0): 
                        ?>
                            <option value="" disabled>โปรดเพิ่มคณะก่อน</option>
                        <?php 
                            endif;
                        ?>
                    </select>
                    <input type="text" name="txt_branch_id_edit" class="hidden txt_branch_id_edit">
                    <p class="mt-4 text-red-800 font-lg">ชื่อสาขา</p>
                    <textarea required type="text" name="txt_branch_name_edit" class="txt_branch_name_edit text-black h-10 p-2 pl-3 text-md h-16 w-full" placeholder="สาขา...."></textarea>
                    <div class="grid grid-cols-2 mt-4 gap-x-1">
                        <button name="btn_edit_branch" class="btn btn-success btn-sm">บันทึก</button>
                        <button type="reset" class="cancleAddItem btn btn-error btn-sm" onclick="clearPopup()" value="ยกเลิก">ยกเลิก</button>
                    </div>
                </div>
            </form>

            <form action="" method="POST" class="hidden">
                <input type="text" name="txt_id_fac_branch_del" class="txt_id_fac_branch_del">
                <input type="submit" class="btn_delFac" name="btn_delFac">
                <input type="submit" class="btn_delBranch" name="btn_delBranch">
            </form>


            <div class="overlay hidden fixed z-10 w-full h-full bg-black opacity-30"></div>
            <div class="space mb-40"></div>

        </div>

    </div>

    <script type="text/javascript" src="./../assets/js/_title_change.js" onload="switchTitle('จัดการห้องตามสาขา')"></script>
    <script type="text/javascript" src="./../assets/js/_adm_select_menu.js" onload="select_menu(8)"></script>
    <script type="text/javascript" src="./../assets/js/_adm_fac_branch_manage.js"></script>
 
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
                            window.location.href='./fac_branch_manage.php';
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

        if (isset($_POST['btn_add_fac'])) {
            if($facClass->Insert($_POST['txt_fac_name'])) {
                alertPopup(1, 'เพิ่มคณะสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['btn_add_branch'])) {
            $fac_id = $_POST['select_fac'];
            $branch_name = $_POST['txt_branch_name'].' ('.$_POST['txt_branch_short'].')';

            if($branchClass->Insert($fac_id, $branch_name)) {
                alertPopup(1, 'เพิ่มสาขาสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['btn_edit_fac'])) {
            if ($facClass->Update($_POST['txt_fac_id_edit'], $_POST['txt_fac_name_edit'])) {
                alertPopup(1, 'แก้ไขคณะสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['btn_edit_branch'])) {
            if ($branchClass->Update($_POST['txt_branch_id_edit'], $_POST['select_fac_edit'], $_POST['txt_branch_name_edit'])) {
                alertPopup(1, 'แก้ไขสาขาสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['btn_delFac'])) {
            if ($facClass->Delete($_POST['txt_id_fac_branch_del'])) {
                alertPopup(1, 'ลบคณะสำเร็จ');
                $logClass->Insert('ลบคณะ, ดำเนินการโดย '.$_SESSION['adm_firstname'].' '.$_SESSION['adm_lastname']);
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['btn_delBranch'])) {
            if ($branchClass->Delete($_POST['txt_id_fac_branch_del'])) {
                alertPopup(1, 'ลบสาขาสำเร็จ');
                $logClass->Insert('ลบสาขา, ดำเนินการโดย '.$_SESSION['adm_firstname'].' '.$_SESSION['adm_lastname']);
            } else {
                alertPopup(0, '');
            }
        }
    ?>
  
</body>
</html>