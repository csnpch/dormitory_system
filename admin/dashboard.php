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
    require_once ('../classes/FixReport.php');
    require_once ('../classes/Branch.php');
    require_once ('../classes/ExchangeValue.php');

    $stdClass = new Student();
    $fixClass = new FixReport();
    $branchClass = new Branch();
    $exchangeValueClass = new ExchangeValue();
    $Std_data = array(0, 0, 0, 0, 0, 0, 0);

    $stdClass->autoChangeStatusStd(1);
    
    // All std
    $sql = $stdClass->Count('std_id', 'count');
    $Std_data[0] = $sql->fetch(PDO::FETCH_ASSOC);
    
    // New std register
    $sql = $stdClass->Count_where('std_id', 'count', 'std_status = 1');
    $Std_data[1] = $sql->fetch(PDO::FETCH_ASSOC);

    // Std is male
    $sql = $stdClass->Count_where('std_id', 'count', 'std_sex = 0 AND room_id IS NOT NULL');
    $Std_data[2] = $sql->fetch(PDO::FETCH_ASSOC);

    // Std is female
    $sql = $stdClass->Count_where('std_id', 'count', '(std_sex = 1 OR std_sex = 2) AND room_id IS NOT NULL');
    $Std_data[3] = $sql->fetch(PDO::FETCH_ASSOC);

    // Old std
    $sql = $stdClass->Count_where('std_status', 'count', 'std_status = 0');
    $Std_data[4] = $sql->fetch(PDO::FETCH_ASSOC);

    // Std is book
    $sql = $stdClass->Count_where('std_id', 'count', 'room_id IS NOT NULL');
    $Std_data[5] = $sql->fetch(PDO::FETCH_ASSOC);

    // Std is't book
    $sql = $stdClass->Count_where('std_id', 'count', 'room_id IS NULL');
    $Std_data[6] = $sql->fetch(PDO::FETCH_ASSOC);

    // Fix report
    $sql = $fixClass->Count_where('fix_id', 'count', 'fix_status = 2 OR fix_status = 1');
    $Fix_data = $sql->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการหอพักนักศึกษา มจพ.</title>
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
        <div id="main" class="flex flex-col w-full lg:w-11/12 ml-0 lg:ml-64 trasition-all duration-300 bg-gray-100 h-min-screen">
            <?php include ('./adm_file_link/navbar.php'); ?>

            <!-- Content -->
            <!-- SESSION -->
            <session class="flex flex-col items-center w-min-screen ml-4 md:ml-8 mr-4 md:mr-8 pr-4 pl-4 mb-8 pb-6 md:pb-6 mt-4 pd:mt-8 pt-6 md:pt-6 bg-primary-content rounded-md shadow-md">
                <!-- <p class="text-center text-lg">ข้อมูลสมาชิกในหอพัก</p> -->
                <div class="grid md:grid-cols-2 lg:grid-cols-4 w-full gap-x-2 gap-y-3">

                    <div class="flex flex-col relative rounded-md bg_card_purple text-white shadow-md">
                        <div class="info mt-4 ml-4">
                            <p class="absolute top-5 left-5 text-3xl font-semibold tracking-wide">
                                <?php echo number_format(intval($Std_data[0]['count'])); ?>
                            </p>
                            <p class="mt-12 text-sm lg:ml-1 lg:text-base">นักศึกษาหอพักทั้งหมด</p>
                        </div>
                        <div class="icon absolute right-4 top-4 icon text-gray-800 opacity-80">
                            <i class="fas fa-users fa-3x xl:mt-1 xl:mr-1"></i>
                        </div>
                        <div class="more mt-4 h-8 w-full bg_card_purple_on_hv rounded-b-xl">
                            <a href="./member_manage.php">
                                <button class="defocus hover:text-gray-300 text-xs w-full mt-2 text-center"
                                        style="outline: none;">
                                    ดูเพิ่มเติม
                                    <i class="fas fa-arrow-circle-right"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                    
                    <div class="flex flex-col relative rounded-md bg_card_red text-white shadow-md">
                        <div class="info mt-4 ml-4">
                            <p class="absolute top-5 left-5 text-3xl font-semibold tracking-wide">
                                <?php echo number_format(intval($Std_data[1]['count'])); ?>
                            </p>
                            <p class="mt-12 text-sm lg:ml-1 lg:text-base">นักศึกษาที่เข้ามาใหม่</p>
                        </div>
                        <div class="icon absolute right-4 top-4 icon text-gray-800 opacity-80">
                            <i class="fas fa-user-edit fa-3x xl:mt-1 xl:mr-1"></i>
                        </div>
                        <div class="more mt-4 h-8 w-full bg_card_red_on_hv rounded-b-xl">
                            <a href="./member_manage.php">
                                <button class="defocus hover:text-gray-300 text-xs w-full mt-2 text-center"
                                        style="outline: none;">
                                    ดูเพิ่มเติม
                                    <i class="fas fa-arrow-circle-right"></i>
                                </button>
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-col relative rounded-md bg_card_blue text-white shadow-md">
                        <div class="info mt-4 ml-4">
                            <p class="absolute top-5 left-5 text-3xl font-semibold tracking-wide">
                                <?php echo number_format(intval($Std_data[2]['count'])); ?>
                            </p>
                            <p class="mt-12 text-sm lg:ml-1 lg:text-base">นักศึกษาชายในหอพัก</p>
                        </div>
                        <div class="icon absolute right-4 top-4 icon text-gray-800 opacity-80">
                            <i class="fas fa-male fa-3x mr-4 mt-2 lg:mt-1 lg:mr-4"></i>
                        </div>
                        <div class="more mt-4 h-8 w-full bg_card_blue_on_hv rounded-b-xl">
                            <a href="./member_manage.php">
                                <button class="defocus hover:text-gray-300 text-xs w-full mt-2 text-center"
                                        style="outline: none;">
                                    ดูเพิ่มเติม
                                    <i class="fas fa-arrow-circle-right"></i>
                                </button>
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-col relative rounded-md bg_card_green text-white shadow-md">
                        <div class="info mt-4 ml-4">
                            <p class="absolute top-5 left-5 text-3xl font-semibold tracking-wide">
                                <?php echo number_format(intval($Std_data[3]['count'])); ?>
                            </p>
                            <p class="mt-12 text-sm lg:ml-1 lg:text-base">นักศึกษาหญิงในหอพัก</p>
                        </div>
                        <div class="icon absolute right-4 top-4 icon text-gray-800 opacity-80">
                            <i class="fas fa-female fa-3x mr-4 mt-2 lg:mt-1 lg:mr-4"></i>
                        </div>
                        <div class="more mt-4 h-8 w-full bg_card_green_on_hv rounded-b-xl">
                            <a href="./member_manage.php">
                                <button class="defocus hover:text-gray-300 text-xs w-full mt-2 text-center"
                                        style="outline: none;">
                                    ดูเพิ่มเติม
                                    <i class="fas fa-arrow-circle-right"></i>
                                </button>
                            </a>
                        </div>
                    </div>

                    <!-- Data row 2 -->
                    <div class="flex flex-col relative rounded-md bg_color_key_1 text-white shadow-md">
                        <div class="info mt-4 ml-4">
                            <p class="absolute top-5 left-5 text-3xl font-semibold tracking-wide">
                                <?php echo number_format(intval($Std_data[4]['count'])); ?>
                            </p>
                            <p class="mt-12 text-sm lg:ml-1 lg:text-base">นักศึกษาเก่าหอพัก</p>
                        </div>
                        <div class="icon absolute right-4 top-4 icon text-gray-800 opacity-80">
                            <!-- <i class="fas fa-user-check fa-3x"></i> -->
                            <i class="fas fa-restroom fa-3x"></i>
                        </div>
                        <div class="more mt-4 h-8 w-full bg_color_key_1_on_hv rounded-b-xl">
                            <a href="./member_manage.php">
                                <button class="defocus hover:text-gray-300 text-xs w-full mt-2 text-center"
                                        style="outline: none;">
                                    ดูเพิ่มเติม
                                    <i class="fas fa-arrow-circle-right"></i>
                                </button>
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-col relative rounded-md bg_color_key_2 text-white shadow-md">
                        <div class="info mt-4 ml-4">
                            <p class="absolute top-5 left-5 text-3xl font-semibold tracking-wide">
                                <?php echo number_format(intval($Std_data[5]['count'])); ?>
                            </p>
                            <p class="mt-12 text-sm lg:ml-1 lg:text-base">นักศึกษาเข้าพักแล้ว</p>
                        </div>
                        <div class="icon absolute right-4 top-4 icon text-gray-800 opacity-80">
                            <i class="fas fa-user-check fa-3x"></i>
                        </div>
                        <div class="more mt-4 h-8 w-full bg_color_key_2_on_hv rounded-b-xl">
                            <a href="./member_manage.php">
                                <button class="defocus hover:text-gray-300 text-xs w-full mt-2 text-center"
                                        style="outline: none;">
                                    ดูเพิ่มเติม
                                    <i class="fas fa-arrow-circle-right"></i>
                                </button>
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-col relative rounded-md bg_color_key_3 text-white shadow-md">
                        <div class="info mt-4 ml-4">
                            <p class="absolute top-5 left-5 text-3xl font-semibold tracking-wide">
                                <?php echo number_format(intval($Std_data[6]['count'])); ?>
                            </p>
                            <p class="mt-12 text-sm lg:ml-1 lg:text-base">นักศึกษายังไม่เข้าพัก</p>
                        </div>
                        <div class="icon absolute right-4 top-4 icon text-gray-800 opacity-80">
                            <i class="fas fa-user-clock fa-3x"></i>
                        </div>
                        <div class="more mt-4 h-8 w-full bg_color_key_3_on_hv  rounded-b-xl">
                            <a href="./member_manage.php">
                                <button class="defocus hover:text-gray-300 text-xs w-full mt-2 text-center"
                                        style="outline: none;">
                                    ดูเพิ่มเติม
                                    <i class="fas fa-arrow-circle-right"></i>
                                </button>
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-col relative rounded-md bg_color_key_4 text-black shadow-md">
                        <div class="info mt-4 ml-4">
                            <p class="absolute top-5 left-5 text-3xl font-semibold tracking-wide">
                                <?php echo number_format(intval($Fix_data['count'])); ?>
                            </p>
                            <p class="mt-12 text-sm lg:ml-1 lg:text-base">รายการแจ้งซ่อม</p>
                        </div>
                        <div class="icon absolute right-4 top-4 icon text-gray-800 opacity-80">
                        <i class="fas fa-toolbox fa-3x lg:mr-2"></i>
                        </div>
                        <div class="more mt-4 h-8 w-full bg_color_key_4_on_hv  rounded-b-xl">
                            <a href="./fix_manage.php">
                                <button class="defocus text-gray-100 hover:text-gray-300 text-xs w-full mt-2 text-center"
                                        style="outline: none;">
                                    <span class="shadow-xl">ดูเพิ่มเติม</span>
                                    <i class="fas fa-arrow-circle-right"></i>
                                </button>
                            </a>
                        </div>
                    </div>

                </div>

            </session>

            <!-- SESSION -->
            <?php 
                $fixStd = $fixClass->countFix();
                $fixStd = $fixStd->fetch(PDO::FETCH_ASSOC);
                if (intval($fixStd['COUNT']) > 0): 
            ?>
                <session class="flex flex-col items-center w-min-screen md:pt-6 xl:pt-0 ml-4 md:ml-8 mr-4 md:mr-8 md:pr-4 md:pl-4 md:mb-8 pb-8 bg-primary-content rounded-md shadow-md">
                    <div class="table w-40 sm:w-full md:pl-10 md:pr-10 pt-6 sm:pt-0 lg:mt-5 mb-2">
                        <div class="flex flex-col sm:flex-row items-center justify-between">
                            <p class="text-center mb-4 text-xl lg:text-left lg:ml-4 text-red-900">รายการแจ้งซ่อมมาใหม่</p>
                            <a href="./fix_manage.php" class="btn btn-xs btn-error mb-4 sm:mb-0 md:mr-4">ดำเนินการจัดการ</a>
                        </div>
                        <div class="overflow-x-auto w-80 sm:w-8/12 md:w-full mx-auto shadow-sm p-1 rounded-md bg-gray-200">
                            <table class="table w-full">
                                <thead>
                                    <tr class="defocus">
                                        <th class="hidden">#</th> 
                                        <th>#</th>
                                        <th>ครุภัณฑ์ที่แจ้งซ่อม / รายละเอียด</th> 
                                        <th>แจ้งซ่อมเมื่อ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $fixStd = $fixClass->Find_Sort('fix_detail, created_at', 'fix_status', '2 OR fix_status = 1', 'created_at DESC', '');
                                $i = 0;
                                    while ($fixValue = $fixStd->fetch(PDO::FETCH_ASSOC)):
                                ?>
                                        <tr>
                                            <td class="text-sm"><?php echo $i+1; ?></td>
                                            <td class="text-sm w-9/12"><?php echo $fixValue['fix_detail']; ?></td>
                                            <td class="text-sm"><span class="lg:mr-4"><?php echo explode(',', $exchangeValueClass->DateThai($fixValue['created_at']))[0]; ?></span></td>
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
            <?php endif; ?>

            <!-- SESSION -->
            <session class="flex flex-col items-center w-min-screen mt-6 sm:mt-0 ml-4 md:ml-8 mr-4 md:mr-8 pr-4 pl-4 bg-primary-content rounded-md shadow-md">
                <div class="table md:w-full md:pl-10 md:pr-10 mt-5 mb-10">
                    <p class="text-center mb-4 text-xl lg:text-left lg:ml-4 text-red-900">รายชื่อนักศึกษาที่เข้ามาใหม่</p>
                    <div class="overflow-x-auto w-80 sm:w-8/12 md:w-full mx-auto shadow-sm p-1 rounded-md bg-gray-200">
                        <table class="table w-full">
                            <thead>
                                <tr class="defocus">
                                    <th class="hidden">#</th> 
                                    <th>#</th>
                                    <th>ชื่อนักศึกษา</th> 
                                    <th>มาจากจังหวัด</th> 
                                    <th>สาขา</th>
                                    <th>เข้าร่วมเมื่อ</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $dataStd = $stdClass->Select_Sort('std_firstname, std_lastname, std_address, branch_id, created_at', 'created_at ASC', '5', 1);
                                $i = 0;
                                while ($valueStd = $dataStd->fetch(PDO::FETCH_ASSOC)): 
                                    $dataBranch = $branchClass->Find('branch_name', 'branch_id', $valueStd['branch_id']);
                                    $dataBranch = $dataBranch->fetch(PDO::FETCH_ASSOC);
                            ?>
                                    <tr>
                                        <td class="text-sm"><?php echo $i+1; ?></td>
                                        <td class="text-sm lg:w-3/12"><?php echo $valueStd['std_firstname'].' '.$valueStd['std_lastname']; ?></td>
                                        <td class="text-sm lg:w-3/12"><?php echo explode(' ', explode('จ.', $valueStd['std_address'])[1])[0]; ?></td>
                                        <td class="text-sm lg:w-5/12"><?php echo $dataBranch['branch_name']; ?></td>
                                        <td class="text-sm"><span class="lg:mr-4"><?php echo explode(',', $exchangeValueClass->DateThai($valueStd['created_at']))[0]; ?></span></td>
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

            <div class="space  mb-10 "></div>
            
            <?php include('./adm_file_link/footer.php'); ?>

        </div>

    </div>
    
    <script type="text/javascript" src="../assets/js/_adm_select_menu.js" onload="select_menu(0)"></script>
    <script type="text/javascript" src="../assets/js/_adm_dashboard.js"></script>

</body>
</html>