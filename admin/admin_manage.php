<?php 
    session_start(); 
    // require_once ('./../disable_error_report.php');
    require_once ('./../classes/Admin.php');
    require_once ('./../classes/Encode.php');
    $adminClass = new Admin();
    $encodeClass = new Encode();

    if (!isset($_SESSION['adm_id'])) {
        header('Location: ../admin/login.php');
    } else if (isset($_SESSION['adm_id'])) {
        $statusAdmin = $adminClass->Find('adm_status', 'adm_id', $_SESSION['adm_id']);
        $statusAdmin = $statusAdmin->fetch(PDO::FETCH_ASSOC);
        if (intval($statusAdmin['adm_status']) === 2) {
            header('Location: ../admin/book_manage.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการผู้ดูแลระบบ</title>
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
        <div id="main" class="flex flex-col w-full lg:w-11/12 ml-0 lg:ml-64 trasition-all duration-300 bg-gray-200 h-min-screen">
            <?php include ('./adm_file_link/navbar.php'); ?>

            <!-- Content -->
            <div class="h-screen">

                <session class="flex flex-col items-center w-min-screen mt-8 ml-4 md:ml-8 mr-4 md:mr-8 pr-4 pl-4 bg-primary-content rounded-md shadow-md">
                
                    <div class="flex justify-between ml-0 md:ml-4 mt-8 mb-2 w-11/12">
                        <p class="text-lg text-center md:text-left text-red-900">จัดการผู้ดูแลระบบ</p>
                        <button class="btn_addAdmin btn btn-sm mr-4 w-32 btn-success">
                            <i class="far fa-plus-square mr-2"></i>
                            <span>เพิ่มผู้ดูแล</span>
                        </button>
                    </div>
                    <div class="flex w-full sm:justify-center overflow-x-auto p-1.5">
                        <div class="bg-gray-200 md:w-11/12 p-1.5 mt-2 mb-10">
                            <table class="table w-full">
                                <thead>
                                    <tr>
                                        <th class="hidden"></th>
                                        <th class="text-left"><span class="font-normal" style="font-size: 16px;">Username</span></th>
                                        <th class="text-left"><span class="font-normal" style="font-size: 16px;">Fullname</span></th>
                                        <th class="text-left"><span class="font-normal" style="font-size: 16px;">Description</span></th>
                                        <th class="text-center"><span class="font-normal" style="font-size: 16px;">Status</span></th>
                                        <th class="text-center"><span class="font-normal" style="font-size: 16px;">TOOLS</span></th>
                                    </tr>
                                </thead>
                                <tbody>

                    <?php 
                        $i = 0;
                        $dataAdmin = $adminClass->Select_All('*');
                        $statusAdmin = $adminClass->Find('adm_status', 'adm_id', $_SESSION['adm_id']);
                        $statusAdmin = $statusAdmin->fetch(PDO::FETCH_ASSOC);
                        while($valueAdmin = $dataAdmin->fetch(PDO::FETCH_ASSOC)):
                    ?>
                            <form action="#" method="POST">
                                <tr class="text-sm valueAdmin">
                                    <input type="text" class="hidden" name="txt_adm_id" value="<?php echo $valueAdmin['adm_id'] ?>">
                                    <td class="username text-left"><?php echo $valueAdmin['adm_username'] ?></td>
                                    <td class="fullname text-left"><?php echo $valueAdmin['adm_fullname'] ?></td>
                                    <td class="description text-left"><?php echo ($valueAdmin['adm_description'] == null ? '-' : $valueAdmin['adm_description']) ?></td>
                                    <td class="status text-center"><?php echo ($valueAdmin['adm_status'] == 0 ? 'ผู้ดูแลระบบ' : ($valueAdmin['adm_status'] == 1 ? 'ผู้พัฒนาระบบ' : 'ผู้จัดสรรห้องพัก')) ?></td>
                                    <td class="text-center flex flex-row gap-x-0.5 justify-center font_prompt">
                                        <p class="adm_id hidden"><?php echo $valueAdmin['adm_id']; ?></p>
                                        <div name="edit_adm" onclick="togglePopupEdit(<?php echo ($valueAdmin['adm_status'] == 1 ? -1 : $i); ?>)" class="cursor-pointer pl-2 pr-2 p-1 bg-blue-600 text-black mr-0.5 hover:bg-blue-700 rounded-sm"><i class="fas fa-pencil-alt text-white"></i></div>
                                        <div onclick="<?php echo ($valueAdmin['adm_status'] == 1 ? "deactionPermision()" : '') ?>" class="<?php echo ($valueAdmin['adm_status'] == 1 ? '' : "btn_delete_admin_check") ?> cursor-pointer pl-2 pr-2 p-1 bg-red-600 text-gray-50 hover:bg-red-700 rounded-sm"><i class="fas fa-trash-alt"></i></div>
                                        <input name="btn_delete_admin" type="submit" class="hidden btn_delete_admin">
                                    </td>
                                </tr>
                            </form>
                    <?php 
                        $i++;
                        endwhile; 
                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                        
                </session>

                <div class="popupInsert hidden">
                    <div class="absolute bottom-0 flex justify-center items-center w-9/12 h-screen z-50">
                        <div class="bg-white w-6/12 h-content p-6">
                            <p class="text-center font-medium text-xl">เพิ่มผู้ดูแลระบบ</p>
                            <form class="mt-4" action="#" name="form_insertDataAdmin" method="POST">
                                <p class="mt-2">ชื่อผู้ใช้</p>
                                <input name="txt_username" class="border-2 border-black border-opacity-40 rounded-md w-full h-9 pl-4 pr-4 pt-0.5" type="text" placeholder="ชื่อผู้ใช้" value>
                                <p class="mt-2">ชื่อเต็ม</p>
                                <input name="txt_fullname" class="border-2 border-black border-opacity-40 rounded-md w-full h-9 pl-4 pr-4 pt-0.5" type="text" placeholder="ชื่อเต็ม" value>
                                <p class="mt-2">คำอธิบาย</p>
                                <input name="txt_description" class="border-2 border-black border-opacity-40 rounded-md w-full h-9 pl-4 pr-4 pt-0.5" type="text" placeholder="คำอธิบาย" value>
                                <p class="mt-2">รหัสผ่านใหม่</p>
                                <input name="txt_password" minlength="8" class="border-2 border-black border-opacity-40 rounded-md w-full h-9 pl-4 pr-4 pt-0.5" type="password" placeholder="รหัสผ่านใหม่" value>
                                <p class="mt-2">ยืนยันรหัสผ่านใหม่</p>
                                <input name="txt_password_again" minlength="8" class="border-2 border-black border-opacity-40 rounded-md w-full h-9 pl-4 pr-4 pt-0.5" type="password" placeholder="ยืนยันรหัสผ่านใหม่" value>
                                <div class="flex mt-4 gap-x-2 justify-center">
                                    <button name="btn_insertAdmin" class="btn btn-sm btn-success w-24">เพิ่มผู้ดูแล</button>
                                    <input type="reset" class="btn_cancelInsert btn btn-sm btn-error w-24" value="ยกเลิก">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="overlay w-full h-screen fixed bg-black top-0 opacity-20 z-20"></div>
                </div>

                <div class="popupEdit hidden">
                    <div class="absolute bottom-0 flex justify-center items-center w-9/12 h-screen z-50">
                        <div class="bg-white w-6/12 h-content p-6">
                            <p class="text-center font-medium text-xl">แก้ไขข้อมูลผู้ดูแล</p>
                            <form class="mt-4" action="#" name="form_editDataAdmin" method="POST">
                                <input class="hidden" type="text" name="txt_adm_id_edit" value="">
                                <p class="mt-2">ชื่อผู้ใช้</p>
                                <input name="txt_username_edit" class="border-2 border-black border-opacity-40 rounded-md w-full h-9 pl-4 pr-4 pt-0.5" type="text" placeholder="ชื่อผู้ใช้" value="">
                                <p class="mt-2">ชื่อเต็ม</p>
                                <input name="txt_fullname_edit" class="border-2 border-black border-opacity-40 rounded-md w-full h-9 pl-4 pr-4 pt-0.5" type="text" placeholder="ชื่อเต็ม" value="">
                                <p class="mt-2">คำอธิบาย</p>
                                <input name="txt_description_edit" class="border-2 border-black border-opacity-40 rounded-md w-full h-9 pl-4 pr-4 pt-0.5" type="text" placeholder="คำอธิบาย" value="">
                                <p class="mt-2">*** ระดับการเข้าถึง ***</p>
                                <?php
                                    $dataAdmin = $adminClass->Find('adm_status', 'adm_id', $_SESSION['adm_id']); 
                                    $dataAdmin = $dataAdmin->fetch(PDO::FETCH_ASSOC);
                                    if(intval($dataAdmin['adm_status']) == 0): 
                                ?>
                                    <select name="select_level" class="border-2 border-black border-opacity-40 rounded-md w-full h-9 pl-4 pr-4 pt-0.5" value="">
                                        <option disabled value="null">ผู้พัฒนาระบบ</option>
                                        <option selected value="2">ผู้จัดสรรห้องพัก</option>
                                        <option value="0">ผู้ดูแลระบบ</option>
                                    </select>
                                <?php
                                    endif;
                                    if (intval($dataAdmin['adm_status']) == 1):
                                ?>
                                    <select name="select_level" class="border-2 border-black border-opacity-40 rounded-md w-full h-9 pl-4 pr-4 pt-0.5" value="">
                                        <option value="2">ผู้จัดสรรห้องพัก</option>
                                        <option value="0">ผู้ดูแลระบบ</option>
                                        <option value="1">ผู้พัฒนาระบบ</option>
                                    </select>
                                <?php 
                                    endif;
                                ?>
                                <p class="mt-2 changePassword hidden">รหัสผ่านใหม่</p>
                                <input name="txt_password_edit" minlength="8" class="changePassword hidden border-2 border-black border-opacity-40 rounded-md w-full h-9 pl-4 pr-4 pt-0.5" type="password" placeholder="รหัสผ่านใหม่" value="">
                                <p class="mt-2 changePassword hidden">ยืนยันรหัสผ่านใหม่</p>
                                <input name="txt_password_again" minlength="8" class="changePassword hidden border-2 border-black border-opacity-40 rounded-md w-full h-9 pl-4 pr-4 pt-0.5" type="password" placeholder="ยืนยันรหัสผ่านใหม่" value="">
                                <button class="btn_submitEditAdmin hidden"></button>
                                <div class="flex flex-row justify-between mt-5">
                                    <div class="btn btn-sm btn_changePassword">เปลี่ยนรหัสผ่าน</div>
                                    <div>
                                        <button name="btn_editAdmin" class="btn btn-sm btn-success">บันทึก</button>
                                        <div class="btn_cancelEdit btn btn-sm btn-error">ยกเลิก</div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="overlay w-full h-screen fixed bg-black top-0 opacity-20 z-20"></div>
                </div>

            </div>

            <div class="space  mb-10 "></div>
            
            <?php include('./adm_file_link/footer.php'); ?>

        </div>

    </div>
    
    <script type="text/javascript" src="../assets/js/_title_change.js" onload="switchTitle('จัดการผู้ดูแลระบบ')"></script>
    <script type="text/javascript" src="../assets/js/_adm_select_menu.js" onload="select_menu(5)"></script>
    <script type="text/javascript" src="../assets/js/_adm_admin_manage.js"></script>

    <?php 
    
        if (isset($_POST['btn_insertAdmin'])) {
            if ($_POST['txt_fullname'] !== '' && $_POST['txt_description'] !== '' && $_POST['txt_username'] !== '' 
                && $_POST['txt_password'] !== '' && $_POST['txt_password_again'] !== '') 
            {
                if ($_POST['txt_password'] === $_POST['txt_password_again']) {
                    $adm_salt = $encodeClass->RandomSalt();
                    $adm_password = $_POST['txt_password'];
                    $adm_password = $encodeClass->Encode($adm_password);
                    if ($adminClass->Insert($_POST['txt_username'], $adm_password, $adm_salt, $_POST['txt_fullname'], $_POST['txt_description'])) {
                        echo "<script>
                            Swal.fire({
                                title: 'เพิ่มข้อมูลผู้ดูแลสำเร็จ',
                                text: '',
                                icon: 'success',
                                showConfirmButton: false,
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                cancelButtonText: 'ปิด'
                            }).then(setTimeout(() => {
                                window.location.href='./admin_manage.php'
                            }, 2000));
                        </script>";
                    }
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'รหัสผ่านไม่ตรงกัน, โปรดลองใหม่',
                            text: '',
                            icon: 'warning',
                            showConfirmButton: false,
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: 'ปิด'
                        })
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'กรอกข้อมูลไม่ครบ, โปรดลองใหม่',
                        text: '',
                        icon: 'warning',
                        showConfirmButton: false,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'ปิด'
                    })
                </script>";
            }
        } else if (isset($_POST['btn_delete_admin'])) {
            if ($adminClass->Delete($_POST['txt_adm_id'])) {
                echo "<script>
                        Swal.fire({
                            title: 'ลบข้อมูลสำเร็จ',
                            text: '',
                            icon: 'success',
                            showConfirmButton: false,
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: 'ปิด'
                        }).then(setTimeout(() => {
                            window.location.href='./admin_manage.php'
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
        } else if (isset($_POST['btn_editAdmin'])) {
        
            if ($adminClass->Update($_POST['txt_adm_id_edit'], $_POST['txt_username_edit'], $_POST['txt_fullname_edit'], $_POST['txt_description_edit'], $_POST['select_level'])) {
                if ($_POST['txt_password_edit'] !== '') {
                    $salt_new = $encodeClass->RandomSalt();
                    $password_new = $_POST['txt_password_edit'];
                    $password_new = $encodeClass->Encode($password_new);
                    $adminClass->Update_password($_POST['txt_adm_id_edit'], $password_new, $salt_new);
                }
                echo "<script>
                    Swal.fire({
                        title: 'แก้ไขข้อมูลสำเร็จ',
                        text: '',
                        icon: 'success',
                        showConfirmButton: false,
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'ปิด'
                    }).then(setTimeout(() => {
                        window.location.href='./admin_manage.php'
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