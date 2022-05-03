<?php 
    session_start();

    if (!isset($_SESSION['std_id'])) {
        header("Location: ./login.php");
    }

    require_once ('./disable_error_report.php');
    require_once './classes/Student.php';
    require_once './classes/Branch.php';
    require_once './classes/Room.php';
    require_once './classes/FixReport.php';
    require_once './classes/ExchangeValue.php';
    require_once './classes/Floor.php';
    require_once './classes/Building.php';
    require_once ('./classes/Status.php');

    $statusClass = new Status();
    $branchClass = new Branch();
    $stdClass = new Student();
    $RoomClass = new Room();
    $fixClass = new FixReport(); 
    $exchangeClass = new ExchangeValue();
    $floorClass = new Floor();
    $buildingClass = new Building();

    $fixClass->autoDestroyFixs(6);

    $statusMain = $statusClass->Find('status_switch', 'status_name', 'system_main');
    $statusMain = $statusMain->fetch(PDO::FETCH_ASSOC);
    if (intval($statusMain['status_switch']) === 1) { header('Location: ./maintenance.php'); }

    $findStd = $stdClass->Find('room_id', 'std_id', $_SESSION['std_id']);
    $dataStd = $findStd->fetch(PDO::FETCH_ASSOC);
    
    $findRoom = $RoomClass->Find('floor_id, room_name', 'room_id', $dataStd['room_id']);
    $dataRoom = $findRoom->fetch(PDO::FETCH_ASSOC);
    if (isset($dataRoom['room_name'])) {
        $findFloor = $floorClass->find('floor_name, building_id', 'floor_id', $dataRoom['floor_id']);
        $dataFloor = $findFloor->fetch(PDO::FETCH_ASSOC);
        $findBuilding = $buildingClass->Find('building_name', 'building_id', $dataFloor['building_id']);
        $dataBuilding = $findBuilding->fetch(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งซ่อมครุภัณฑ์</title>
    <link rel="icon" href="./assets/img/logoKmutnb.webp">
    <link rel="stylesheet" href="./assets/css/tailwind.css">
    <link rel="stylesheet" href="./assets/css/style_x_tailwind.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./assets/js/_system_fix_report.js"></script>

</head>
<body>

    <?php include('./file_link/system_sidebar.php'); ?>

    <div id="container"     class="flex flex-col lg:w-9\/12 lg:ml-64 transition-all bg-gray-100">
        
        <div id="navbar"    class="z-20 fixed flex flex-row items-center bg-white h-14 w-full border-b-2 shadow-sm
                                            delay-400 transition-all">
                <div id="menu"  class="lg:hidden absolute menuBar ml-4 cursor-pointer z-20">
                    <i class="fas fa-bars"></i>
                </div>
                <div id="title_nav"     class="w-full text-center ml-6 lg:-ml-36">
                    <p class="tracking-widest mt-0.5 sm:ml-4 text-lg defocus">
                        <span id="txtNav">แจ้งซ่อมครุภัณฑ์</span>
                    </p>
                </div>
        </div>

        <content class="min-h-screen">
            <section class="pl-2 pr-2 pt-20 md:pl-10 sm:pl-8 md:pr-10 sm:pr-8">
            
                <div class="w-full bg-white rounded-2xl pt-8 pb-8 shadow-md transition-all">
                    <form method="POST">
                        <div class="grid grid-cols-5 gap-y-4">
                            <p class="flex items-start mt-2 w-9/12 md:text-right sm:w-full text-sm sm:text-md justify-self-center sm:justify-end col-span-full sm:col-start-1 sm:col-span-2 mr-6 text-red-900">
                                ต้องการแจ้งซ่อมสิ่งใด /<br class="sm_hidden"/> พร้อมรายละเอียดการชำรุด
                            </p>
                            <textarea name="txt_detail" type="text" placeholder="โต๊ะ, เตียง, ราวผ้า / ขาเก้าอี้หัก, เตียง 2 ชั้นถล่ม, ราวผ้าหัก"
                                    class="tracking-wide text-xs p-2 h-20 sm:text-sm w-9/12 sm:w-full justify-self-center col-span-full sm:ml-0 sm:col-span-2 border-2 bg-gray-50 focus:bg-gray-100 outline-none rounded"
                            ></textarea>

                            <p class="flex items-center w-9/12 sm:w-full text-sm sm:text-md justify-self-center sm:justify-end col-span-full sm:col-start-1 sm:col-span-2 mr-6 text-red-900">
                                ชื่อสถานที่ครุภัณฑ์ที่แจ้งซ่อม
                            </p>
                            <input name="txt_area" type="text" placeholder="ห้อง, ชั้น, หรือสถานที่ ตามด้วยชื่ออาคาร..." value="<?php if(isset($dataRoom['room_name'])) { echo $dataRoom['room_name'].' '.$dataFloor['floor_name'].' '.$dataBuilding['building_name']; } ?>"
                                class="tracking-wide text-xs sm:text-sm w-9/12 sm:w-full justify-self-center col-span-full sm:ml-0 sm:col-span-2 border-2 pl-4 pr-4 h-10 bg-gray-50 focus:bg-gray-100 outline-none rounded">
                                   
                            <button name="btn_report" class="col-span-full w-9/12 sm:w-full justify-self-center sm:col-start-3 sm:col-span-2 text-center cursor-pointer mt-2 btnEdit text-red-700 p-1 pl-4 pr-4 round border-2 border-red-700 rounded-md 
                                        hover:bg-red-700 hover:text-white duration-200">
                                <i class="fas fa-tools"></i>
                                รายงานแจ้งซ่อม
                            </button>
                        </div>
                    </form>
                </div>
                
            </section> <!-- End section -->

            <section class="pl-2 pr-2 pt-6 md:pl-10 pb-20 sm:pl-8 md:pr-10 sm:pr-8">
            
                <div class="w-full bg-white rounded-2xl p-8 shadow-md transition-all">
                    <p class="defocus flex items-center sm:ml-4 text-red-900">
                        รายการแจ้งซ่อมของคุณ
                    </p>

                    <div class="flex justify-center mt-4 mb-2 sm:ml-12 sm:mr-12 gap-y-4">
                        <div class="w-full pt-2">
                            <p class="defocus text-md border-b-2 pb-2 sm:pl-4">ชื่อรายการ</p>
                        </div>
                        <div class="w-60 text-center pt-2">
                            <p class="defocus text-md border-b-2 border-l-2 pb-2">สถานะ</p>
                        </div>
                    </div>

                    <?php 
                        $dataFix = $fixClass->Find_Sort('fix_detail, created_at, fix_status', 'std_id', $_SESSION['std_id'], 'created_at DESC', '');
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
                            $n++;
                    ?>
                        <div class="flex justify-center sm:ml-12 sm:mr-12 gap-y-4">
                            <div class="w-full pt-2">
                                <p class="pl-2 sm:pl-4 pt-2 pb-2 h-10 overflow-x-hidden">
                                    <?php echo $value['fix_detail']; ?>
                                </p>
                            </div>
                            <div class="w-60 text-center pt-2">
                                <p class="txtStatus pt-2 pb-2 border-l-2 h-10 overflow-x-hidden">
                                    <?php echo $exchangeClass->status_fix_is($value['fix_status']); ?>
                                </p>
                            </div>
                        </div>
                    <?php 
                        endwhile;
                        if ($dataFix->rowCount() === 0):
                    ?>
                        <p class="defocus text-red-900 flex mt-8 text-sm justify-center items-center sm:ml-4 text-black">
                            ยังไม่มีรายการแจ้งซ่อมของคุณ
                        </p>
                    <?php endif; ?>
                </div>
                
            </section> 
        </content>

        <?php include('./file_link/system_footer.php') ?>
    
    </div>

    <script src="./assets/js/_title_change.js" onload="switchTitle('แจ้งซ่อมครุภัณฑ์');"></script>
    <script src="./assets/js/_system_sidebar.js"></script>

    <?php 
        
        if (!isset($_SESSION['std_id'])) {
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
        }

        if (isset($_POST['btn_report'])) {
            $detail = $_POST['txt_detail'];
            $area = $_POST['txt_area'];

            if (trim($_POST['txt_detail']) != '') {
                $fixClass->Insert($_SESSION['std_id'], $detail, $area);

                if ($fixClass) {
                    echo "<script>
                            Swal.fire({
                                title: 'แจ้งซ่อมสำเร็จ',
                                text: '',
                                icon: 'success',
                                showConfirmButton: false,
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                            }).then(setTimeout(() => {
                                window.location.href='system_fix_report.php'
                            }, 1500)); 
                        </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'ไม่สามารถแจ้งซ่อมได้',
                            text: 'โปรดลองใหม่! หรือติดต่อเจ้าหน้าที่',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'ปิด'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = 'system_fix_report.php';
                            }
                        })
                        </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'กรุณากรอกข้อมูลให้ครบ',
                        text: '',
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '',
                        confirmButtonText: 'เข้าใจแล้ว'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = 'system_fix_report.php';
                        }
                    })
                    </script>";
            }
        }

        ?> 
  
</body>
</html>
 