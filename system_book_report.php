<?php 
    session_start();
    require_once ('./disable_error_report.php');
    require_once './classes/Student.php';
    require_once './classes/Family.php';
    require_once './classes/Faculty.php';
    require_once './classes/Branch.php';
    require_once './classes/Room.php';
    require_once './classes/ExchangeValue.php';
    require_once ('./classes/Status.php');

    $statusClass = new Status();
    $stdClass = new Student();
    $famClass = new Family();
    $facultyClass = new Faculty();
    $branchClass = new Branch();
    $roomClass = new Room();
    $exchangeClass = new ExchangeValue();
    $dataFam = array();
    global $dataStd;

    $statusMain = $statusClass->Find('status_switch', 'status_name', 'system_main');
    $statusMain = $statusMain->fetch(PDO::FETCH_ASSOC);
    
    $selectFam = $famClass->find('*', 'std_id', $_SESSION['std_id']);
    
    if (intval($statusMain['status_switch']) === 1) { header('Location: ./maintenance.php'); }

    if (isset($_SESSION['std_id'])) {
        $findStd = $stdClass->Find('*', 'std_id', $_SESSION['std_id']);
        $dataStd = $findStd->fetch(PDO::FETCH_ASSOC);
        if ($dataStd['room_id'] == NULL) {
            header("Location: ./system_book.php");
        }
        $findBranch = $branchClass->Find('fac_id, branch_name', 'branch_id', $dataStd['branch_id']);
        $dataBranch = $findBranch->fetch(PDO::FETCH_ASSOC);
        
        $findFac = $facultyClass->Find('fac_name', 'fac_id', $dataBranch['fac_id']);
        $dataFac = $findFac->fetch(PDO::FETCH_ASSOC);

        $findRoom = $roomClass->Find('room_name', 'room_id', $dataStd['room_id']);
        $dataRoom = $findRoom->fetch(PDO::FETCH_ASSOC);

        $select_famId = $famClass->Find('fam_id', 'std_id', $_SESSION['std_id']);
        while ($value = $select_famId->fetch(PDO::FETCH_ASSOC)) {
            $findFam = $famClass->Find('fam_firstname, fam_lastname, fam_tel, fam_career, fam_work_at, fam_status', 'fam_id', $value['fam_id']);
            while ($value = $findFam->fetch(PDO::FETCH_ASSOC)) {
                array_push($dataFam, $value);
            }
        }

        // find another student in room by room_id
        $dataAnotherStudentInThisRoom = $stdClass->getStudentsByRoomId($dataStd['room_id']);
        $dataAnotherStudentInThisRoom = $dataAnotherStudentInThisRoom->fetchAll(PDO::FETCH_ASSOC);

    } else {
        header("Location: ./login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานการจองห้องพัก</title>
    <link rel="icon" href="./assets/img/logoKmutnb.webp">
    <link rel="stylesheet" href="./assets/css/tailwind.css">
    <link rel="stylesheet" href="./assets/css/style_x_tailwind.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="https://cdn.jsdelivr.net/npm/labelmake@2.0.16/dist/labelmake.min.js" integrity="sha256-TQ35Ix2CgcpWrDkm0zdd2YKIrCdIpu+HOe/3OU8jjJY=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="./assets/js/_system_book_report.js">

    <style>

        body, html {
            scroll-behavior: smooth;
        }

        .dorpdown-room {
            display: none;
            color: #002858;
            background-color: #EFF6FF;
            filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
            border-radius: 5px;
        }

        .room:hover .dorpdown-room {
            display: block;
        }

    </style>

</head>
<body class="overflow-x-hidden">

    <script>
        var dataAnotherStudentInThisRoom = <?php echo json_encode($dataAnotherStudentInThisRoom); ?>;
        function showPopupMemberInRoom() {
            let strOutput = '';
            for (let item of dataAnotherStudentInThisRoom) {
                console.log(item);
                strOutput += `
                    <ul>
                        <li>${item.std_firstname} ${item.std_lastname} (${item.std_nickname})<br>${item.std_email}<br><br></li>
                    </ul>
                `;
            }
            Swal.fire({
                title: 'สมาชิกภายในห้องพัก',
                html: strOutput,
                icon: 'warning',
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'ปิด'
            }).then((result) => {
                if (result.isConfirmed) {
                }
            })     
        }

    </script>

    <div id="areaDataAppend" class="hidden absolute w-full lg:ml-32 mx-auto h-full z-50 overflow-y-scroll">
        <form name="dataAppend" class="mt-20 mb-20 p-6 sm:p-10 rounded-xl mx-auto w-11/12 lg:w-9/12 bg-white">
            <div class="flex justify-end">
                <i onclick="closePopup()" class="far fa-times-circle text-xl text-red-800 -mr-6 md:mr-0 cursor-pointer hover:text-red-400"></i>
            </div>
            <p class="defocus text-center text-lg text-red-800">
                เพิ่มข้อมูลในเอกสาร (แค่บางส่วน)<br>
                <span class="text-sm text-indigo-900">*** หลังจากนักศึกษาพิมพ์เอกสารแล้ว ให้ตรวจสอบสิ่งที่จำเป็นต้องกรอกอีกรอบค่ะ ***</span>
            </p>
            
            <p class="text-left sm:ml-10 lg:ml-52 text-md text-red-800 mt-10">ข้อมูลอาจารย์ที่ปรึกษา มจพ.</p>
            <div class="sm:-ml-36 grid sm:grid-cols-2 mt-6 gap-y-3">
                <p class="defocus text-sm sm:text-right mt-1.5 mr-2">ชื่ออาจารย์ที่ปรึกษา</p>
                <input type="text" name="txt_fullname_teacher_new" placeholder="ประหยัด จันทร์อังคาร"
                        class="text-sm w-full sm:w-80 text-gray-600 border border-gray-400 outline-none h-8 pl-2 pr-2">
                <p class="defocus text-sm sm:text-right mt-1.5 mr-2">เบอร์อาจารย์ที่ปรึกษา</p>
                <input type="text" name="txt_tel_teacher_new" placeholder="ไม่ต้องมีขีด ( - )"
                        class="text-sm w-full sm:w-80 text-gray-600 border border-gray-400 outline-none h-8 pl-2 pr-2">
            </div>

            <p class="text-left sm:ml-10 lg:ml-52 text-md text-red-800 mt-8">ประวัติการศึกษา & นักศึกษา</p>
            <div class="sm:-ml-36 grid sm:grid-cols-2 mt-6 gap-y-3">
                <p class="defocus text-sm sm:text-right mt-1.5 mr-2">ชื่ออาจารย์ที่ปรึกษาสถาบันเดิม</p>
                <input type="text" name="txt_fullname_teacher_old" placeholder="ประหยัด จันทร์อังคาร"
                        class="text-sm w-full sm:w-80 text-gray-600 border border-gray-400 outline-none h-8 pl-2 pr-2">
                
                <p class="defocus text-sm sm:text-right mt-1.5 mr-2">เบอร์โทรศัพท์บ้านนักศึกษา <span class="text-indigo-800">(ถ้ามี)</span></p>
                <input type="text" name="txt_tel_home" placeholder="ไม่ต้องมีขีด ( - )"
                        class="text-sm w-full sm:w-80 text-gray-600 border border-gray-400 outline-none h-8 pl-2 pr-2">
                
                <p class="defocus text-sm sm:text-right mt-1.5 mr-2">โรคประจำตัว <span class="text-indigo-800">(ถ้ามี)</span></p>
                <select id="select_disease" name="select_disease" onchange="is_disease()"
                        class="text-sm w-full sm:w-80 text-gray-600 border border-gray-400 outline-none h-8 pl-2 pr-2">
                    <option value="0">ไม่มีโรคประจำตัว</option>
                    <option value="1">มีโรคประจำตัว</option>
                </select>
                
                <p class="is_disease hidden defocus text-sm sm:text-right mt-1.5 mr-2">โปรดระบุโรค (ได้มากกว่า 1 โรค)</p>
                <input type="text" name="txt_disease" placeholder="ถ้ามากกว่า 1 โรค คั่นด้วย ( , )"
                        class="is_disease hidden text-sm w-full sm:w-80 text-gray-600 border border-gray-400 outline-none h-8 pl-2 pr-2">
            </div>

            <p class="text-left sm:ml-10 lg:ml-52 text-md text-red-800 mt-8">ประวัติครอบครัวผู้สมัคร</p>
            <div class="sm:-ml-36 grid sm:grid-cols-2 mt-6 gap-y-3">
                <p class="defocus text-sm sm:text-right mt-1.5 mr-2">อายุของบิดา <span class="text-indigo-900">(พ่อ)</span></p>
                <input type="text" name="txt_fam_age_1" placeholder="หากถึงแก่กรรม ไม่ต้องระบุ" min="0"
                        class="text-sm w-full sm:w-80 text-gray-600 border border-gray-400 outline-none h-8 pl-2 pr-2">
                
                <p class="defocus text-sm sm:text-right mt-1.5 mr-2">อายุของมาดา <span class="text-indigo-900">(แม่)</span></p>
                <input type="text" name="txt_fam_age_2" placeholder="หากถึงแก่กรรม ไม่ต้องระบุ" min="0"
                        class="text-sm w-full sm:w-80 text-gray-600 border border-gray-400 outline-none h-8 pl-2 pr-2">

                <p class="defocus text-sm sm:text-right mt-1.5 mr-2">รายได้ต่อเดือนของบิดา <span class="text-indigo-900">(พ่อ)</span></p>
                <input type="text" name="txt_fam_salary_1" placeholder="ระบุเฉพาะตัวเลข" min="0"
                        class="text-sm w-full sm:w-80 text-gray-600 border border-gray-400 outline-none h-8 pl-2 pr-2">

                <p class="defocus text-sm sm:text-right mt-1.5 mr-2">รายได้ต่อเดือนของมารดา <span class="text-indigo-900">(แม่)</span></p>
                <input type="text" name="txt_fam_salary_2" placeholder="ระบุเฉพาะตัวเลข" min="0"
                        class="text-sm w-full sm:w-80 text-gray-600 border border-gray-400 outline-none h-8 pl-2 pr-2">
                
                <p class="defocus text-sm sm:text-right mt-1.5 mr-2">ผู้สมัครมีพี่น้อง <span class="text-indigo-900">(รวมตัวเองด้วย)</span></p>
                <input type="number" name="txt_sibling" placeholder="ระบุเฉพาะตัวเลข" min="0"
                        class="text-sm w-full sm:w-80 text-gray-600 border border-gray-400 outline-none h-8 pl-2 pr-2">

                <p class="defocus text-sm sm:text-right mt-1.5 mr-2">ชาย</p>
                <input type="number" name="txt_sibling_male" placeholder="จำนวนพี่น้องเพศชาย" min="0"
                        class="text-sm w-full sm:w-80 text-gray-600 border border-gray-400 outline-none h-8 pl-2 pr-2">
                
                <p class="defocus text-sm sm:text-right mt-1.5 mr-2">หญิง</p>
                <input type="number" name="txt_sibling_female" placeholder="จำนวนพี่น้องเพศหญิง" min="0"
                        class="text-sm w-full sm:w-80 text-gray-600 border border-gray-400 outline-none h-8 pl-2 pr-2">
            </div>
            <!-- <p class="text-left sm:ml-10 lg:ml-52 text-md text-red-800 mt-8">ข้อมูลเพิ่มเติมในเอกสาร</p>
            <div class="sm:-ml-36 grid sm:grid-cols-2 mt-6 gap-y-3">
                <p class="defocus text-sm sm:text-right mt-1.5 mr-2">งานอดิเรก / ความสามารถพิเศษ</p>
                <textarea type="text" name="txt" placeholder=""
                        class="text-sm h-16 pt-1 w-full sm:w-80 text-gray-600 border border-gray-400 outline-none pl-2 pr-2"
                ></textarea>
                <p class="defocus text-sm sm:text-right mt-1.5 mr-2">ข้าพเจ้ามีความประสงค์<br />จะเข้าหอพักของมหาวิทยาลัยเนื่องจาก</p>
                <textarea type="text" name="txt" placeholder=""
                        class="text-sm h-16 pt-1 w-full sm:w-80 text-gray-600 border border-gray-400 outline-none pl-2 pr-2"
                ></textarea>
            </div> -->
            <div id="btn_appendData" class="flex justify-center w-full md:w-6/12 mt-10 mx-auto justify-self-center sm:col-start-3 
                        sm:col-span-2 text-center cursor-pointer mt-2 btnEdit text-green-700 p-1 pl-4 pr-4 round border-2 
                        border-green-700 rounded-md hover:bg-green-600 hover:text-white duration-200 outline-none" onclick="ReportPDF()">
                <i class="fas fa-calendar-check mt-1 mr-2"></i>
                ส่งข้อมูลไปยังเอกสาร
            </div>

        
        </form>
    </div>
    <div id="overlay" class="hidden fixed w-full h-screen bg-black z-40 opacity-30 defocus"></div>


    <?php include('./file_link/system_sidebar.php'); ?>

    <div id="container"     class="flex flex-col lg:w-9\/12 lg:ml-64 transition-all bg-gray-100">
        
        <div id="navbar"    class="z-20 fixed flex flex-row items-center bg-white h-14 w-full border-b-2 shadow-sm
                                            delay-400 transition-all">
                <div id="menu"  class="lg:hidden absolute menuBar ml-4 cursor-pointer z-20">
                    <i class="fas fa-bars"></i>
                </div>
                <div id="title_nav"     class="w-full text-center ml-6 lg:-ml-36">
                    <p class="tracking-widest mt-0.5 sm:ml-4 text-lg defocus">
                        <span id="txtNav">รายงานการจองห้องพัก</span>
                    </p>
                </div>
        </div>

        <content class="min-h-screen">
            <section class="pl-2 pr-2 pt-20 md:pl-10 sm:pl-8 md:pr-10 sm:pr-8">
            
                <div class="area_report_book w-full bg-white rounded-2xl p-6 shadow-lg transition-all">
                    <div class="w-64 sm:w-96 text-center m-auto mt-10 pb-14 pt-10 bg-pink-50 border-t-4 border-r-4 
                        relative border-red-200 hover:border-red-800 rounded-t-2xl duration-200 hover:bg-red-100 cursor-pointer"
                        onclick="showPopupMemberInRoom()"
                    >
                        <p class="text-2xl mt-2 text-black defocus">ห้องพักที่จอง</p>
                        <p class="text-7xl mt-8 text-black tracking-widest text-red-900 font-light font_kanit"><?php echo $dataRoom['room_name']; ?></p>
                    </div>
                    <div class="w-64 sm:w-96 m-auto text-center col-span-3 mb-14 duration-200 shadow-xl">
                        <input id="btn_report" type="submit" value="พิมพ์เอกสารสำหรับยื่นเข้าหอพัก" onclick="report()"
                            class="defocus p-5 pt-3 pb-3 w-full bg-red-700 hover:bg-red-800 shadow-lg border-r-4 border-red-900
                                transform scale-100 cursor-pointer rounded-b-2xl text-white duration-200"
                        >
                    </div>
                </div>
                
                <div class="mt-4 text-center w-full flex flex-row justify-end">
                    <div onclick="cancelBook()" class="p-2 pl-4 pr-4 text-sm w-content bg-gray-700 duration-200 rounded-md text-white cursor-pointer hover:bg-black">
                        ยกเลิกการจองห้องพัก
                    </div>
                </div>

                <div id="showPDF"></div>

                <iframe id="iframe" class="area_pdf hidden w-full h-screen h-auto mt-4 mb-20 bg-white rounded-2xl p-6 shadow-lg transition-all"></iframe>

            </section> <!-- End section -->
        </content>

        <?php include('./file_link/system_footer.php') ?>

        <?php 
            $findStd = $stdClass->Find('*', 'std_id', $_SESSION['std_id']);
            $dataStd = $findStd->fetch(PDO::FETCH_ASSOC);
        ?>

        <form name="data" style="display: none;">
            <input type="text" name="fullname"      value="<?php echo $exchangeClass->sex_is(intval($dataStd['std_sex'])).$dataStd['std_firstname'].' '.' '.$dataStd['std_lastname']; ?>">
            <input type="text" name="idcard"        value="<?php echo $dataStd['std_idcard']; ?>">
            <input type="text" name="nickname"      value="<?php echo $dataStd['std_nickname']; ?>">
            <input type="text" name="faculty"       value="<?php echo $dataFac['fac_name']; ?>">
            <input type="text" name="branch"        value="<?php echo str_replace(array('(',')'), "", explode(" ", $dataBranch['branch_name'])[1]); ?>">
            <input type="text" name="idstd"         value="<?php echo $dataStd['std_id_student']; ?>">
            <input type="text" name="birthday"      value="<?php echo $dataStd['std_birthday']; ?>">
            <input type="text" name="religion"      value="<?php echo $exchangeClass->religion_is(intval($dataStd['std_religion'])); ?>">
            <input type="text" name="blood"         value="<?php echo $exchangeClass->blood_type_is(intval($dataStd['std_blood'])); ?>">
            <input type="text" name="tel"           value="<?php echo $dataStd['std_tel']; ?>">
            <input type="text" name="eduAcademy"    value="<?php echo $dataStd['std_edu_academy']; ?>">
            <input type="text" name="eduDegree"     value="<?php echo $exchangeClass->degree_is(intval($dataStd['std_edu_degree'])); ?>">
            <input type="text" name="eduComple"     value="<?php echo $dataStd['std_edu_comple']; ?>">
            <input type="text" name="address"       value="<?php echo $dataStd['std_address']; ?>">

            <input type="text" name="fam1_fullname" value="<?php echo $dataFam[0]['fam_firstname'].' '.' '.$dataFam[0]['fam_lastname']; ?>">
            <input type="text" name="fam1_career"   value="<?php echo $dataFam[0]['fam_career']; ?>">
            <input type="text" name="fam1_status"   value="<?php echo $dataFam[0]['fam_status']; ?>">
            <input type="text" name="fam1_work_at"  value="<?php echo $dataFam[0]['fam_work_at']; ?>">
            <input type="text" name="fam1_tel"      value="<?php echo $dataFam[0]['fam_tel']; ?>">

            <input type="text" name="fam2_fullname" value="<?php echo $dataFam[1]['fam_firstname'].' '.' '.$dataFam[1]['fam_lastname']; ?>">
            <input type="text" name="fam2_career"   value="<?php echo $dataFam[1]['fam_career']; ?>">
            <input type="text" name="fam2_status"   value="<?php echo $dataFam[1]['fam_status']; ?>">
            <input type="text" name="fam2_work_at"  value="<?php echo $dataFam[1]['fam_work_at']; ?>">
            <input type="text" name="fam2_tel"      value="<?php echo $dataFam[1]['fam_tel']; ?>">

            <input type="text" name="sponsor_status"       value="<?php echo $dataStd['std_sponsor']; ?>">
            <input type="text" name="sponsor_name"       value="<?php echo $exchangeClass->person_is($dataStd['std_sponsor']); ?>">
            <input type="text" name="howmush"       value="<?php echo number_format($dataStd['std_howmuch']); ?>">
            <input type="text" name="room_name"     value="<?php echo $dataRoom['room_name']; ?>">
        </form>
        
    </div>

    <form action="#" method="POST" class="">
        <input id="toggleStatus" name="toggleStatus" type="submit">

        <?php 
            $statusBook = $statusClass->Find('status_switch', 'status_name', 'system_book');
            $statusBook = $statusBook->fetch(PDO::FETCH_ASSOC);
        ?>
        <input value="<?php echo $statusBook['status_switch'] ?>"  type="text" name="statusSwitchBook" id="statusSwitchBook">
        <input type="text" name="5f14ac246f960a3173a16561d243a8f5b07cfcec5c787f09de52f318d746c833" id="5f14ac246f960a3173a16561d243a8f5b07cfcec5c787f09de52f318d746c833">
        <input type="submit" name="3c4ce757715a8b7fa461fcbf6cc91310d69661b3f7359d9992eff6217b8f6390" id="3c4ce757715a8b7fa461fcbf6cc91310d69661b3f7359d9992eff6217b8f6390" class="hidden">
    </form>

    <script src="./assets/js/_title_change.js" onload="switchTitle('รายงานการจองห้องพัก');"></script>
    <script src="./assets/js/_system_sidebar.js"></script>
    <script src="./assets/js/_system_book_report.js"></script>
    <script src="./PDF/PDFconfig.js"></script>

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

        $statusBook = $statusClass->Find('status_id, status_switch, status_date_start, status_date_stop', 'status_name', 'system_book');
        $statusBook = $statusBook->fetch(PDO::FETCH_ASSOC);

        echo "<script type='text/javascript'>
            setValueStatusBook(".json_encode($statusBook).");
        </script>";
        
        if (isset($_POST['3c4ce757715a8b7fa461fcbf6cc91310d69661b3f7359d9992eff6217b8f6390'])) {
            if (intval($_POST['statusSwitchBook']) != 0) {
                if ($stdClass->book_destory($_SESSION['std_id'])) {
                    echo "<script>  
                        Swal.fire({
                            title: 'ยกเลิกการจองห้องพักสำเร็จ',
                            text: '',
                            icon: 'success',
                            showConfirmButton: false,
                            showCancelButton: false,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6'
                        }).then(setTimeout(() => {
                            window.location.href='system_book.php'
                        }, 2000));
                    </script>";
                } else {
                    echo "<script>  
                        Swal.fire({
                            title: 'เกิดข้อผิดพลาด, โปรดติดต่อเจ้าหน้าที่',
                            text: '',
                            icon: 'error',
                            showConfirmButton: false,
                            showCancelButton: false,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6'
                        }).then(setTimeout(() => {
                            window.location.href='system_book.php'
                        }, 2000));
                    </script>";
                }
            } else {
                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: 'ไม่สามารถยกเลิกการจองได้',
                        html: 'จะสามารถยกเลิกได้ในช่วงที่เปิดให้จองห้องพักเท่านั้น<br>โปรดติดต่อเจ้าหน้าที่เพื่อทำการยกเลิก!',
                        icon: 'error',
                        showConfirmButton: true,
                        showCancelButton: false,
                        confirmButtonColor: '#cc0c62',
                        confirmButtonText: 'เข้าใจแล้ว'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = './system_book.php';
                        } else {
                            window.location = './system_book.php';
                        }
                    })
                </script>";
            }
        }

    ?>

</body>
</html>
 