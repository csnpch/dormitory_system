<?php
    require_once './classes/Student.php';
    $stdClass = new Student();
    $findDataStd = $stdClass->Find('std_id_student, std_firstname, std_lastname, branch_id', 'std_id', $_SESSION['std_id']);
    $dataStd = $findDataStd->fetch(PDO::FETCH_ASSOC);
?>

<div id="overlay" class="deactive bg-black opacity-40 z-30 w-full h-full fixed"></div>

<div id="sidebar"   class="overflow-y-scroll -ml-80 lg:ml-0 w-64 h-full fixed bg_red_nav font_prompt text-white
                                transition-all duration-600 shadow-xl z-30 overflow-x-hidden">

        <div class="absolute w-full text-right md:hidden pt-2 z-20 cursor-pointer">
            <i id="close_sidebar" class="ml-4 text-white fas fa-chevron-left fa-md mr-3"></i>
        </div>


        <div id="logo"          class="w-full flex flex-col items-center pb-3 line_b_white_5 transition-all duration-500">
            <!-- <img id="logo_img"  src="./assets/img/logoKmutnb.webp" alt="image" width="100"  class="mt-5 defocus"> -->
            <a id="logo_text" href="./system_main.php"   class=" text-white tracking-widest font-light text-xl mt-3.5 transition-all
                                        font_kanit defocus">
                ระบบหอพักนักศึกษา
            </a>
        </div> <!-- End logo area -->


        <div id="user"   class="flex justify-center w-full text-white mt-8 transition-all duration-700 defocus">
            <a href="./system_profile.php">
                <div id="area_user"  class="border_white_light flex p-2 pl-4 pr-4 hover:bg-red-900 rounded-lg">
                    <i id="icon_user" class="fas fa-user text-2xl mr-4 mt-2"></i>
                    <div class="flex flex-col text-sm tracking-widest">
                        <p class="sm_sidebar"><?php echo $dataStd['std_id_student'] ?></p>
                        <p class="font-light sm_sidebar whitespace-nowrap"><?php echo $dataStd['std_firstname'].' '.$dataStd['std_lastname']; ?></p>
                    </div>
                </div>
            </a>
        </div>


        <div id="main_menu"         class="mt-10 w-48 mx-auto duration-1000 defocus">
            <p id="text_main_menu"  class="font-light text-gray-200 font_kanit text-sm defocus pb-1.5 line_b_white_2">
                Main Menu
            </p>
        </div>

        <div id="list_menu" class="mt-4 flex flex-col ml-14 w-full transition-all pb-8 defocus" style="list-style-type: circle !important;">
            <ul class="list-item mt-4" style="list-style-type: circle;">
                <li class="menu mb-6 text-gray-300 hover:text-white tracking-widest">
                    <a href="./system_main.php">หน้าหลัก</a>
                </li>
                <li class="menu mb-6 text-gray-300 hover:text-white duration-200 tracking-widest">
                    <a href="./system_profile.php">ข้อมูลส่วนตัว</a>
                </li>
                <li class="menu mb-6 text-gray-300">
                    <a href="./system_book.php" class="hover:text-white duration-200 tracking-widest">จองห้องพัก</a>
                    <!-- <a href="./system_book.php?branch=<?php echo($dataStd['branch_id']); ?>&building=0&floor=0" class="hover:text-white duration-200 tracking-widest">จองห้องพัก</a> -->
                    <!-- <ul class="list-item ml-2 text-sm">
                        <div class="absolute w-14 bg-white opacity-30 transform rotate-90 left-3.5 mt-7" style="height: 0.2px;"></div>
                        <li class="mt-4"><a href="" class="hover:text-white duration-200 tracking-widest">สมัครหอพักระหว่างภาค</a></li>
                        <li class="mt-4"><a href="" class="hover:text-white duration-200 tracking-widest">ยืนยันสิทธิ์</a></li>
                    </ul> -->
                </li>
                <li class="menu mb-6 text-gray-300 hover:text-white duration-200">
                    <a href="./system_fix_report.php">แจ้งซ่อม</a>
                </li>
                <li class="menu mb-6 text-gray-300 hover:text-white duration-200">
                    <a href="./system_change_password.php">เปลี่ยนรหัสผ่าน</a>
                </li>
            </ul>
        </div>


        <a href="./logout.php">   <!--sm:w-12 sm:ml-0 lg:w-64-->
            <div id="btnLogout" class="flex flex-row items-center fixed bottom-0 bg_red_nav trasition-all duration-200
                                        hover_bg_red_nav cursor-pointer h-8 w-64 line_t_white_5">
                <!-- <i class="fas fa-sign-out-alt" class="ml-14 text-white fas fa-door-open fa-sm"></i> -->
                <i id="icon_door"   class="ml-16 text-white fas mt-0.5 fa-sign-out-alt fa-sm transform rotate-0"></i>
                <p id="text_logout" class="flex items-center ml-2 text-left h-full text-gray-200 
                                            bottom-0 left-0 defocus font-light">
                    ออกจากระบบ
                </p>
            </div>
        </a>

        
</div> <!-- End Sidebar -->
