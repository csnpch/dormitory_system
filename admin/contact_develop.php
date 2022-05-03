<?php 
    session_start();
    require_once ('./../disable_error_report.php');

    if (!isset($_SESSION['adm_id'])) {
        header('Location: ../admin/login.php');
    }
    
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ติดต่อผู้พัฒนาระบบ</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <link rel="stylesheet" href="../assets/css/style_x_tailwind.css">
    <link rel="icon" href=" ../assets/img/logoKmutnb.webp">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../assets/node_modules/daisyui/dist/full.css">
    <!-- <link rel="stylesheet" href="../assets/node_modules/daisyui/dist/themes.css"> -->
    <!-- <script type="text/javascript" src="../assets/node_modules/daisyui/dist/base.js"></script> -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body class="font_prompt overflow-hidden">

    <div class="flex">
        <!-- Sidebar -->
        <?php include ('./adm_file_link/sidebar.php'); ?>
        <!-- Navbar -->
        <div id="main" class="flex flex-col w-full lg:w-11/12 ml-0 lg:ml-64 trasition-all duration-300 bg-base-200 h-min-screen">
            <?php include ('./adm_file_link/navbar.php'); ?>

            <!-- Content -->

            <!-- SESSION -->
            <div class="h-screen">
                <session class="flex flex-col items-center w-min-screen mt-10 ml-4 md:ml-8 mr-4 md:mr-8 pr-4 pl-4 bg-primary-content rounded-md shadow-md">
                    <p class="mt-6 text-md text-red-800 text-lg">ช่องทางติดต่อผู้พัฒนาระบบ</p>
                    <i class="fab fa-facebook fa-3x mt-10 text-blue-800"></i>
                    <a target="_blank" href="https://www.fb.com/100007208803749" class="hover:text-indigo-900 flex flex-row gap-x-4  items-center text-xl text-blue-800 pt-4">
                        <p class="mt-2 hover:underline">Chitsanuphong Chaihong (Ham)</p>
                    </a>
                    <a target="_blank" href="https://www.fb.com/100009072478192" class="pb-8 hover:text-indigo-900 flex flex-row gap-x-4  items-center text-xl text-blue-800 p-4">
                        <p class="hover:underline">Thanaphoom Arunchit &nbsp;(Phoom)</p>
                    </a>
                </session>
            </div>

            <div class="space  mb-10 "></div>
            
            <?php include('./adm_file_link/footer.php'); ?>

        </div>

    </div>
    
    <script type="text/javascript" src="../assets/js/_title_change.js" onload="switchTitle('ติดต่อผู้พัฒนาระบบ')"></script>
    <script type="text/javascript" src="../assets/js/_adm_select_menu.js" onload="select_menu(9)"></script>
    <script type="text/javascript" src="../assets/js/_adm_dashboard.js"></script>

</body>
</html>