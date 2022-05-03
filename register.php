<?php 
    session_start(); 
    require_once ('./disable_error_report.php');
    require_once ('./classes/Status.php');
    $statusClass = new Status();

    $statusMain = $statusClass->Find('status_switch', 'status_name', 'system_main');
    $statusMain = $statusMain->fetch(PDO::FETCH_ASSOC);
    if (intval($statusMain['status_switch']) === 1) { header('Location: ./maintenance.php'); }

    $statusRegister = $statusClass->Find('status_switch', 'status_name', 'system_register');
    $statusRegister = $statusRegister->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>หอพักนักศึกษา มจพ. ปราจีนบุรี</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="icon" href="./assets/img/logoKmutnb.webp">
    <link rel="stylesheet" href="./assets/AddressJSON/dist/jquery.Thailand.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o), m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-33058582-1', 'auto', {
            'name': 'Main'
        });
        ga('Main.send', 'event', 'jquery.Thailand.js', 'GitHub', 'Visit');

    </script>

</head>

<body>

    <?php

        if (intval($statusRegister['status_switch']) === 0) {
            echo "<script type='text/javascript'>
                Swal.fire({
                    title: 'ยังไม่เปิดให้สมัครสมาชิกในตอนนี้',
                    html: 'โปรดกลับมาใหม่ในภายหลัง หรือติดต่อเจ้าหน้าที่!',
                    icon: 'error',
                    showConfirmButton: true,
                    showCancelButton: false,
                    confirmButtonColor: '#cc0c62',
                    confirmButtonText: 'เข้าใจแล้ว'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = './index.php';
                    } else {
                        window.location = './index.php';
                    }
                })
            </script>";
        }

        if (isset($_SESSION['std_id'])) {
            echo "<script>  
                Swal.fire({
                    title: 'คุณเข้าสู่ระบบอยู่',
                    text: 'ต้องออกจากระบบก่อนเพื่อทำการสมัครสมาชิกใหม่',
                    icon: 'error',
                    showConfirmButton: false,
                    showCancelButton: false,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6'
                }).then(setTimeout(() => {
                    window.location.href='index.php'
                }, 3000));
            </script>";
        }

        require_once ('./classes/Faculty.php');
        require_once ('./classes/Branch.php');
        require_once ('./classes/Student.php');
        require_once ('./classes/Family.php');
        require_once ('./classes/Encode.php');

        $facClass = new Faculty();
        $branchClass = new Branch();
        $stdClass = new Student();
        $famClass = new Family();
        $encodeClass = new Encode();

        $select_fac = $facClass->Select_All('fac_id, fac_name');
        $find_branch = $branchClass->Select_All('branch_id, branch_name, fac_id');


        if (isset($_POST['btn_register'])) {
            
            $branch_id = $_POST['select_branch'];
            $std_status = $_POST['radio_statusStd'];
            $std_username = $_POST['txt_username'];
            $std_password = $_POST['txt_password'];
            $std_salt = $encodeClass->RandomSalt();
            $std_sex = $_POST['select_sex'];
            $std_firstname = $_POST['txt_firstname'];
            $std_lastname = $_POST['txt_lastname'];
            $std_idcard = $_POST['txt_idCard'];
            $std_nickname = $_POST['txt_nickname'];
            $std_blood = $_POST['select_blood_type'];
            $std_religion = $_POST['select_religion'];
            $std_birthday = $_POST['date_birthday'];
            $std_id_student = $_POST['txt_idStd'];
            $std_tel = $_POST['txt_tel'];
            $std_email = $_POST['txt_email'];
            $std_address = $_POST['txt_home_number'];
            $std_address = $std_address.( (empty($_POST['txt_village_name']) || $_POST['txt_village_name'] == "-") ? "" : " หมู่บ้าน".$_POST['txt_village_name']);
            $std_address = $std_address.( (empty($_POST['txt_swine']) || $_POST['txt_swing'] == "-") ? "" : " ม.".$_POST['txt_swine']);
            $std_address = $std_address.( (empty($_POST['txt_alley']) || $_POST['txt_alley'] == "-") ? "" : " ซ.".$_POST['txt_alley']);
            $std_address = $std_address.( (empty($_POST['txt_road']) || $_POST['txt_road'] == "-") ? "" : " ถ.".$_POST['txt_road']);
            $std_address = $std_address.( (empty($_POST['txt_locality']) || $_POST['txt_locality'] == "-") ? "" : " ต.".$_POST['txt_locality']);
            $std_address = $std_address.( (empty($_POST['txt_district']) || $_POST['txt_district'] == "-") ? "" : " อ.".$_POST['txt_district']);
            $std_address = $std_address.( (empty($_POST['txt_province']) || $_POST['txt_province'] == "-") ? "" : " จ.".$_POST['txt_province']);
            $std_address = $std_address." ".$_POST['txt_zipCode']; 
            $std_edu_academy = $_POST['txt_stdEduAcademy'];
            $std_edu_degree = $_POST['select_stdEduDegree'];
            $std_edu_comple = $_POST['txt_stdEduComple'];
            $std_sponsor = $_POST['select_sponsor'];
            $std_howmuch = $_POST['txt_howmuch'];

            $findUsername = $stdClass->Find('std_username', 'std_username', $std_username);
            if($findUsername->rowCount() === 0) {
                // $encodeClass->RandomSalt();
                $std_password = $encodeClass->Encode($std_password);
    
                $std_statusInsert = $stdClass->Insert(
                    $std_status, $std_username, $std_password, $std_salt,
                    $std_sex, $std_firstname, $std_lastname, $std_idcard,
                    $std_nickname, $std_blood, $std_religion, $std_birthday,
                    $std_id_student, $branch_id,
    
                    $std_tel, $std_email, $std_address,
    
                    $std_edu_academy, $std_edu_degree, $std_edu_comple,
    
                    $std_sponsor, $std_howmuch
                );
    
                // Class Family zone
                $selectIdStd = $stdClass->Find('std_id' ,'std_username', $std_username);
                $std_id = $selectIdStd->fetch(PDO::FETCH_ASSOC);
    
                // Insert Class family data 1
                $fam_sex = $_POST['select_sexParents1'];
                $fam_firstname = $_POST['txt_firstnameParents1'];
                $fam_lastname = $_POST['txt_lastnameParents1'];
                $fam_tel = $_POST['txt_telParents1'];
                $fam_career = $_POST['txt_careerParents1'];
                $fam_work_at = $_POST['txt_workAtParents1'];
                $fam_status = $_POST['select_statusParents1'];    // 1 is life ,  2 is dead or die
                $person_status = 1; // 1&2 person in family 1, 2 person sos 3,4
                $person_is = 1; // 1= บิดา
    
                $fam_statusInsert1 = $famClass->Insert(
                    $std_id['std_id'], $fam_sex, 
                    $fam_firstname, $fam_lastname, $fam_tel,
                    $fam_career, $fam_work_at,  $fam_status, 
                    $person_status, $person_is
                );

                // Insert Class family data 2
                $fam_sex = $_POST['select_sexParents2'];
                $fam_firstname = $_POST['txt_firstnameParents2'];
                $fam_lastname = $_POST['txt_lastnameParents2'];
                $fam_tel = $_POST['txt_telParents2'];
                $fam_career = $_POST['txt_careerParents2'];
                $fam_work_at = $_POST['txt_workAtParents2'];
                $fam_status = $_POST['select_statusParents2'];    // 1 is life ,  2 is dead or die
                $person_status = 2; // 1&2 person in family 1, 2 person sos 3,4
                $person_is = 2;// 2= มารดา
    
                $fam_statusInsert2 = $famClass->Insert(
                    $std_id['std_id'], $fam_sex, 
                    $fam_firstname, $fam_lastname, $fam_tel,
                    $fam_career, $fam_work_at,  $fam_status, 
                    $person_status, $person_is
                );

                if ($_POST['txt_firstnameEmergency1'] != '' && $_POST['txt_firstnameEmergency1'] != '' && $_POST['txt_telEmergency1'] != '') {
                    // Insert Class family data 3  #' SOS '
                    $fam_sex = $_POST['select_sexEmergency1'];
                    $fam_firstname = $_POST['txt_firstnameEmergency1'];
                    $fam_lastname = $_POST['txt_lastnameEmergency1'];
                    $fam_tel = $_POST['txt_telEmergency1'];
                    $fam_career = null;
                    $fam_work_at = null;
                    $fam_status = 1;    // 1 is life ,  2 is dead or die
                    $person_status = 3; // 1&2 person in family 1, 2 person sos 3,4
                    $person_is = $_POST['select_person_is_Emergency1'];

                    $fam_statusInsert3 = $famClass->Insert(
                        $std_id['std_id'], $fam_sex,
                        $fam_firstname, $fam_lastname, $fam_tel,
                        $fam_career, $fam_work_at,  $fam_status,
                        $person_status, $person_is
                    );
                }

                if ($_POST['txt_firstnameEmergency2'] != '' && $_POST['txt_firstnameEmergency2'] != '' && $_POST['txt_telEmergency2'] != '') {
                    $fam_sex = $_POST['select_sexEmergency2'];
                    $fam_firstname = $_POST['txt_firstnameEmergency2'];
                    $fam_lastname = $_POST['txt_lastnameEmergency2'];
                    $fam_tel = $_POST['txt_telEmergency2'];
                    $fam_career = null;
                    $fam_work_at = null;
                    $fam_status = 1;    // 1 is life ,  2 is dead or die
                    $person_status = 4; // 1&2 person in family 1, 2 person sos 3,4
                    $person_is = $_POST['select_person_is_Emergency2'];

                    $fam_statusInsert4 = $famClass->Insert(
                        $std_id['std_id'], $fam_sex,
                        $fam_firstname, $fam_lastname, $fam_tel,
                        $fam_career, $fam_work_at,  $fam_status,
                        $person_status, $person_is
                    );
                }

                // if ($std_statusInsert && $fam_statusInsert1 && $fam_statusInsert2 && $fam_statusInsert3 && $fam_statusInsert4) {
                if ($std_statusInsert && $fam_statusInsert1 && $fam_statusInsert2) {
                    echo "<script>
                        setTimeout(() => {
                            window.location.href='login.php'
                        }, 6000);
                    </script>";

                    echo "<script>
                        Swal.fire({
                            title: 'สมัครสมาชิกเสร็จสิ้น',
                            text: 'ระบบกำลังพาท่านไปหน้าเข้าสู่ระบบ',
                            icon: 'success',
                            showConfirmButton: false,
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                        }).then(setTimeout(() => {
                            window.location.href='login.php'
                        }, 2000)); 
                    </script>";
                } else {
                    echo "<script>  
                        Swal.fire({
                            title: 'ระบบเกิดข้อผิดพลาด',
                            text: 'สมัครสมาชิกไม่สำเร็จ โปรดแจ้งเจ้าหน้าที่หอพักให้ทราบ',
                            icon: 'error',
                            showConfirmButton: false,
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: 'ปิด'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                
                            } else {
                                window.location.href='register.php'
                            }
                        })
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'มีชื่อผู้ใช้งานนี้ในระบบแล้ว',
                        text: 'โปรดตั้งชื่อผู้ใช้งานใหม่ในส่วนของชื่อผู้ใช้งาน หรือ Username',
                        icon: 'error',
                        showConfirmButton: false,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'ปิด'
                    }).then(setTimeout(() => {
                        window.location.href='register.php'
                    }, 4000));
                </script>";
            }
        }

    ?>

    <script type="text/javascript">
        var dataBranchOnJs = {
            fac_id: [],
            branch_id: [],
            branch_name: []
        };
        var status_selectBranch = false;
        

        setTimeout(() => {
            dataBranchOnJs.fac_id.unshift(0);
            insertBranchForSelect();
        }, 1000);

        function insertBranchForSelect() {
            let select_faculty = document.getElementById("select_faculty");
            let select_branch = document.getElementById("select_branch");
            let tmpInnerHtml = '<option disabled selected>- กรุณาเลือกสาขา -</option>';
            for (let i = 0; i < dataBranchOnJs.branch_id.length; i++) {
                if (dataBranchOnJs.branch_name[i] != "-") {
                    if (parseInt(select_faculty.value) == dataBranchOnJs.fac_id[i]) {
                        console.log(dataBranchOnJs.branch_name[i]);
                        tmpInnerHtml += '<option value="' + dataBranchOnJs.branch_id[i] + '">' + dataBranchOnJs.branch_name[i] + '</option>';
                    }
                }
            }
            select_branch.innerHTML = tmpInnerHtml;
        }
    </script>

    <!-- Menu  -->
    <?php include "./file_link/navbar.php"; ?>


        <div class="areaRegister">

        <form method="POST" action="" id="form_register" name="process_register">
            <div class="header">
                <div class="title userSelectNone">
                    <p>สมัครสมาชิกหอพัก</p>
                </div>

                <div class="areaCheckStatus">
                    <div class="checkStatusStd userSelectNone" >
                        <input name="radio_statusStd" type="radio" value="0" ><span>นักศึกษาหอพัก</span>
                        <input name="radio_statusStd" type="radio" value="1" checked="checked" ><span>นักศึกษาใหม่<?php echo "ปี 2" . (date('y')+543) ?></span>
                    </div>
                    <div class="description"> 
                        <p>**กรณีที่เป็นนักศึกษาเก่าย้ายออกจากหอพักแล้วประสงค์จะเข้าพักใหม่กรุณาติดต่าเจ้าหน้าที่</p>
                    </div>
                </div>
            </div>

            
            <!-- Username for manager system -->
            <div class="session userSelectNone sectionRegister">
                <div class="titleSection userSelectNone">
                    <p>ข้อมูลสำหรับเข้าใช้งานระบบ</p>
                </div>
                <div class="areaInput">
                    <div class="question">
                        <p>ชื่อผู้ใช้งาน</p>
                        <input  name="txt_username" type="text" placeholder="Username" maxlength="30">
                    </div>
                    <div class="question">
                        <p>รหัสผ่าน</p>
                        <input class="txtPass" name="txt_password" type="password" placeholder="Password # 8 ตัวขึ้นไป">
                    </div>
                    <div class="question">
                        <p>ยืนยันรหัสผ่าน</p>
                        <input class="txtPass" name="txt_password2" type="password" placeholder="Password again">
                    </div>
                </div>
            </div>


            <!-- ข้อมูลนักศึกษา -->
            <div class="session userSelectNone">

                <div class="titleSection userSelectNone">
                    <p>ข้อมูลนักศึกษา</p>
                </div>

                <div class="areaInput">

                    <div class="question">
                        <p>คำนำหน้า</p>
                        <select name="select_sex" id="">
                            <option value="0">นาย</option>
                            <option value="1">นางสาว</option>
                            <option value="2">นาง</option>
                        </select>
                    </div>

                    <div class="question">
                        <p>ชื่อจริง</p>
                        <input  name="txt_firstname" type="text" placeholder="ชื่อนักศึกษา">
                    </div>

                    <div class="question">
                        <p>นามสกุล</p>
                        <input  name="txt_lastname" type="text" placeholder="นามสกุล">
                    </div>

                    <div class="question">
                        <p>เลขบัตรประจำตัวประชาชน</p>
                        <input  name="txt_idCard" type="text" maxlength="13" placeholder="เลขบัตรประจำตัวประชาชน" maxlength="13">
                    </div>

                    <div class="question">
                        <p>ชื่อเล่น</p>
                        <input  name="txt_nickname" type="text" placeholder="ชื่อเล่น">
                    </div>
                    
                    <div class="question">
                        <p>หมู่เลือด</p>
                        <select name="select_blood_type" id="blood_type">
                            <option value="0">A</option>
                            <option value="1">B</option>
                            <option value="2">O</option>
                            <option value="3">AB</option>
                        </select>
                    </div>

                    <div class="question">
                        <p>ศาสนา</p>
                        <select name="select_religion" id="religion">
                            <option value="0">พุทธ</option>
                            <option value="1">คริสต์</option>
                            <option value="2">อิสลาม</option>
                            <option value="3">ฮินดู</option>
                            <option value="4">ซิกข์</option>
                            <option value="5">ไม่นับถือศาสนา</option>
                        </select>
                    </div>

                    <div class="question">
                        <p>วันเกิด&nbsp;ด/ว/ป.</p>
                        <input  name="date_birthday" type="date" placeholder="วัดเกิด" style="height: 20px;">
                    </div>

                    <div class="question" style="position: relative; margin-bottom: 22px;">
                        <p>รหัสนักศึกษา</p>
                        <input name="txt_idStd" type="text" maxlength="13" placeholder="ถ้าไม่มีรหัส นศ. เช่น 2564 ให้ใส่ 64">
                        <p style="font-size:13px; bottom: -28px; position: absolute; width: max-content;">(ถ้ายังไม่มี ให้ใส่เลขท้ายปี พ.ศ. ที่สมัคร 2 หลัก)</p>
                    </div>

                    <div class="question">
                        <p>คณะ</p>
                        <select name="select_faculty" id="select_faculty" onChange="insertBranchForSelect()" >
                            <?php 
                                echo "<option selected disabled value=".">- กรุณาเลือกคณะ -"."</option>";
                                while ($row = $select_fac->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value=".$row['fac_id'].">".$row['fac_name']."</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="question">
                        <p>สาขา</p>
                        <select name="select_branch" id="select_branch" >
                            <option selected disabled value="">- กรุณาเลือกสาขา -</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- ข้อมูลติดต่อ -->
            <div class="session userSelectNone">
                
                <div class="titleSection userSelectNone">
                    <p>ข้อมูลติดต่อ</p>
                </div>
                
                <div class="areaInput">
                    
                    <div  class="question">
                        <p>เบอร์โทรศัพท์</p>
                        <input name="txt_tel" type="text" placeholder="เบอร์โทรศัพท์" maxlength="10">
                    </div>
                    
                    <div class="question">
                        <p>อีเมลล์</p>
                        <input name="txt_email" type="email" placeholder="อีเมลล์">
                    </div>
                    
                    <div  class="question">
                        <p>บ้านเลขที่</p>
                        <input name="txt_home_number" type="text" placeholder="บ้านเลขที่ ตย.(162/4)">
                    </div>
                    
                    <div class="question">
                        <p>ชื่อหมู่บ้าน (ถ้ามี)</p>
                        <input name="txt_village_name" type="text" placeholder="ชื่อหมู่บ้าน ตย.(รุ่งนิรันด์)" style="border-bottom: 2px solid rgba(0, 0, 0, 0.226) !important">
                    </div>
                    
                    <div  class="question">
                        <p>หมู่ที่</p>
                        <input name="txt_swine" type="text" placeholder="หมู่ที่ ตย.(12)">
                    </div>
                    
                    <div class="question">
                        <p>ซอย (ถ้ามี)</p>
                        <input name="txt_alley" type="text" placeholder="ซอย ตย.(ยิ่งเจริญ)"  style="border-bottom: 2px solid rgba(0, 0, 0, 0.226) !important">
                    </div>
                    
                    <div class="question">
                        <p>ถนน (ถ้ามี)</p>
                        <input name="txt_road" type="text" placeholder="ถนน ตย.(มิตรภาพ)"  style="border-bottom: 2px solid rgba(0, 0, 0, 0.226) !important">
                    </div>
                    
                    <div  class="question">
                        <p>ตำบล / แขวง</p>
                        <input name="txt_locality" id="autocomplete1" type="text" placeholder="ตำบล / แขวง" style="border: 1px solid #222;">
                    </div>

                    <div  class="question">
                        <p>อำเภอ / เขต</p>
                        <input name="txt_district" id="autocomplete2" type="text" placeholder="อำเภอ / เขต" style="border: 1px solid #222;">
                    </div>
                    
                    <div  class="question">
                        <p>จังหวัด</p>
                        <input name="txt_province" id="autocomplete3" type="text" placeholder="จังหวัด" style="border: 1px solid #222;">
                    </div>
                    <div  class="question">
                        <p>รหัสไปรษณี</p>
                        <input name="txt_zipCode" id="autocomplete4" type="text" placeholder="รหัสไปรษณี" style="border: 1px solid #222;">
                    </div>
                </div>
            </div>


            <!-- ประวัติการศึกษา -->
            <div class="session userSelectNone">
                
                <div class="titleSection userSelectNone">
                    <p>ประวัติการศึกษา (ล่าสุด)</p>
                </div>
                
                <div class="areaInput">
                    
                    <div class="question">
                        <p>จบการศึกษาจาก</p>
                        <input  name="txt_stdEduAcademy" type="text" placeholder="โรงเรียน, วิทยาลัย, อื่น ๆ">
                    </div>
                    
                    <div class="question">
                        <p>ระดับชั้น</p>
                        <select class="selectCheck" name="select_stdEduDegree" id="education">
                            <option value="" disabled selected>- กรุณาเลือกระดับชั้น -</option>
                            <option value="0">มัธยมศึกษาตอนต้น</option>
                            <option value="1">มัธยมศึกษาตอนปลาย</option>    
                            <option value="2">ปวช.</option>
                            <option value="3">ปวส.</option>
                            <option value="4">อื่น ๆ ระบุในเอกสาร</option>
                        </select>
                    </div>
                    
                    <div class="question">
                        <p>ปีการศึกษาที่จบ</p>
                        <input  name="txt_stdEduComple" type="text" placeholder="ปี พ.ศ. 4 หลัก" maxlength="4">
                    </div>

                </div>
            </div>


            <!-- ได้รับอุปการะด้านการเงินจาก -->
            <div class="session userSelectNone">
                
                <div class="titleSection userSelectNone">
                    <p>นักศึกษาได้รับอุปการะด้านการเงินจากใคร</p>
                </div>

                <div class="areaInput">

                    <div class="question">
                        <p>ผู้อุปการะเงิน</p>
                        <select  name="select_sponsor" id="person_is">
                            <option value="10">พ่อ/แม่</option>
                            <option value="11">ปู่/ย่า</option>
                            <option value="12">ตา/ยาย</option>
                            <option value="13">ลุง/ป้า</option>
                            <option value="0">พ่อ</option>
                            <option value="1">แม่</option>
                            <option value="2">ปู่</option>
                            <option value="3">ย่า</option>
                            <option value="4">ตา</option>
                            <option value="5">ยาย</option>
                            <option value="6">ลุง</option>
                            <option value="7">ป้า</option>
                            <option value="8">พี่</option>
                            <option value="9">อื่น ๆ ระบุในเอกสาร</option>
                        </select>
                    </div>

                    <div class="question">
                        <p>ได้รับเดือนละกี่บาท</p>
                        <input  name="txt_howmuch" type="text" placeholder="ระบุเฉพาะตัวเลข" style="text-align: center; width: 110px;">
                    </div>

                </div>
            </div>


            <!-- ประวัติครอบครัวผู้สมัคร : บิดา -->
            <div class="session userSelectNone">
                
                <div class="titleSection userSelectNone">
                    <p>ข้อมูลครอบครัวผู้สมัคร : บิดา</p>
                </div>
                
                <div class="areaInput">
                    
                    <div class="question">
                        <p>คำนำหน้า</p>
                        <select name="select_sexParents1" id="">
                            <option value="0">นาย</option>
                        </select>
                    </div>
                    
                    <div class="question">
                        <p>ชื่อจริง</p>
                        <input name="txt_firstnameParents1" type="text" placeholder="ชื่อบิดา" id="firstnameParents1">
                    </div>
                    
                    <div class="question">
                        <p>นามสกุล</p>
                        <input name="txt_lastnameParents1" type="text" placeholder="นามสกุล" id="lastnameParents1">
                    </div>
                    
                    <div class="question">
                        <p>เบอร์โทรศัพท์ที่ติดต่อได้</p>
                        <input name="txt_telParents1" type="text" placeholder="เบอร์โทรศัพท์" id="telParents1" maxlength="10">
                    </div>

                    <div class="question">
                        <p>อาชีพ</p>
                        <input name="txt_careerParents1" type="text" placeholder="รับจ้างทั่วไป, พนักงานบริษัท, อื่น ๆ">
                    </div>

                    <div class="question">
                        <p>สถานที่ทำงาน</p>
                        <input name="txt_workAtParents1" type="text" placeholder="บริษัทฮาไม่จำกัด นครราชสีมา">
                    </div>
                    
                    <div class="question">
                        <p>สถานะ</p>
                        <select name="select_statusParents1" id="blood_type" onchange="checkStatusFamily()">
                            <option selected value="1">ยังมีชีวิตอยู่</option>
                            <option value="0">ถึงแก่กรรม</option>
                        </select>
                    </div>
                </div>
            </div>


            <!-- ประวัติครอบครัวผู้สมัคร : มารดา -->
            <div class="session userSelectNone">
                
                <div class="titleSection userSelectNone">
                    <p>ข้อมูลครอบครัวผู้สมัคร : มารดา</p>
                </div>
                
                <div class="areaInput">
                    <div class="question">
                        <p>คำนำหน้า</p>
                        <select name="select_sexParents2">
                            <option value="2">นาง</option>
                            <option value="1">นางสาว</option>
                        </select>
                    </div>
                
                    <div class="question">
                        <p>ชื่อจริง</p>
                        <input name="txt_firstnameParents2" type="text" placeholder="ชื่อมารดา" id="firstnameParents2">
                    </div>
                
                    <div class="question">
                        <p>นามสกุล</p>
                        <input name="txt_lastnameParents2" type="text" placeholder="นามสกุล" id="lastnameParents2">
                    </div>
                    
                    <div class="question">
                        <p>เบอร์โทรศัพท์ที่ติดต่อได้</p>
                        <input name="txt_telParents2" type="text" placeholder="เบอร์โทรศัพท์" id="telParents2" maxlength="10">
                    </div>

                    <div class="question">
                        <p>อาชีพ</p>
                        <input name="txt_careerParents2" type="text" placeholder="รับจ้างทั่วไป, พนักงานบริษัท อื่น ๆ">
                    </div>

                    <div class="question">
                        <p>สถานที่ทำงาน</p>
                        <input name="txt_workAtParents2" type="text" placeholder="กระทรวงมหาดไทย กรุงเทพ ฯ">
                    </div>
                    
                    <div class="question">
                        <p>สถานะ</p>
                        <select name="select_statusParents2" id="blood_type" onchange="checkStatusFamily()">
                            <option selected value="1">ยังมีชีวิตอยู่</option>
                            <option value="0">ถึงแก่กรรม</option>
                        </select>
                    </div>
                </div>
            </div>

            
            <!-- ข้อมูลผู้ติดต่อฉุกเฉิน 1 -->
            
            <div class="EmergencyArea session userSelectNone deactive">
                <div class="titleSection userSelectNone">
                    <p>ข้อมูลผู้ติดต่อฉุกเฉิน 1 
                        <!-- <span style="font-size: 14px; color: black; font-weight: 400;">
                            <input name="checkbox1" id="useDataAfter1" type="checkbox" onclick="useDataAfter(1)">ใช้ข้อมูลเดียวกับบิดา
                        </span>  -->
                    </p>
                </div>
                
                <div class="areaInput">
                    <div class="question">
                        <p>คำนำหน้า</p>
                        <select  name="select_sexEmergency1">
                            <option value="0">นาย</option>
                            <option value="1">นางสาว</option>
                            <option value="2">นาง</option>
                        </select>
                    </div>
                    
                    <div class="question">
                        <p>ชื่อจริง</p>
                        <input name="txt_firstnameEmergency1" type="text" placeholder="ชื่อผู้ติดต่อฉุกเฉิน" id="firstnameParents1">
                    </div>
                    
                    <div class="question">
                        <p>นามสกุล</p>
                        <input name="txt_lastnameEmergency1" type="text" placeholder="นามสกุล">
                    </div>
                    
                    <div class="question">
                        <p>เบอร์โทรศัพท์ที่ติดต่อได้</p>
                        <input name="txt_telEmergency1" type="text" placeholder="เบอร์โทรศัพท์">
                    </div>
                    
                    <div class="question">
                        <p>ผู้ติดต่อฉุกเฉินคนนี้เป็นใคร</p>
                        <div class="question">
                        <select  name="select_person_is_Emergency1" id="person_is">
                            <!-- <option value="0" selected>บิดา</option> -->
                            <!-- <option value="1">มารดา</option> -->
                            <option value="9" selected disabled>โปรดเลือก</option>
                            <option value="2">ปู่</option>
                            <option value="3">ย่า</option>
                            <option value="4">ตา</option>
                            <option value="5">ยาย</option>
                            <option value="6">ลุง</option>
                            <option value="7">ป้า</option>
                            <option value="8">พี่</option>
                            <option value="9">อื่น ๆ ระบุในเอกสาร</option>
                        </select>
                    </div>
                    </div>
                </div>
            </div>
           

            <!-- ข้อมูลผู้ติดต่อฉุกเฉิน 2 -->
            
            <div class="EmergencyArea session userSelectNone deactive">
                <div class="titleSection userSelectNone">
                    <p>ข้อมูลผู้ติดต่อฉุกเฉิน 2
                        <!-- <span style="font-size: 14px; color: black; font-weight: 400;">
                            <input name="checkbox2" id="useDataAfter2" type="checkbox" onclick="useDataAfter(2)">ใช้ข้อมูลเดียวกับมารดา
                        </span> -->
                    </p>
                </div>
                
                <div class="areaInput">
                    <div class="question">
                        <p>คำนำหน้า</p>
                        <select name="select_sexEmergency2">
                            <option value="0">นาย</option>
                            <option value="1">นางสาว</option>
                            <option value="2" selected>นาง</option>
                        </select>
                    </div>
                    
                    <div class="question">
                        <p>ชื่อจริง</p>
                        <input name="txt_firstnameEmergency2" type="text" placeholder="ชื่อผู้ติดต่อฉุกเฉิน">
                    </div>
                    
                    <div class="question">
                        <p>นามสกุล</p>
                        <input name="txt_lastnameEmergency2" type="text" placeholder="นามสกุล">
                    </div>
                    
                    <div class="question">
                        <p>เบอร์โทรศัพท์ที่ติดต่อได้</p>
                        <input name="txt_telEmergency2" type="text" placeholder="เบอร์โทรศัพท์">
                    </div>
                    
                    <div class="question">
                        <p>ผู้ติดต่อฉุกเฉินคนนี้เป็นใคร</p>
                        <select name="select_person_is_Emergency2" id="select_person_is_Emergency2">
                            <!-- <option value="0">บิดา</option> -->
                            <!-- <option value="1" selected>มารดา</option> -->
                            <option value="9" selected disabled>โปรดเลือก</option>
                            <option value="2">ปู่</option>
                            <option value="3">ย่า</option>
                            <option value="4">ตา</option>
                            <option value="5">ยาย</option>
                            <option value="6">ลุง</option>
                            <option value="7">ป้า</option>
                            <option value="8">พี่</option>
                            <option value="9">อื่น ๆ ระบุในเอกสาร</option>
                        </select>
                    </div>
                </div>
            </div>
           

            <input id="hiddenBtnRegister" name="btn_register" type="submit" style="display: none !important">
            </form>
                <div class="areabutton">
                    
                    <div class="btnRegis">
                        <button name="btnCheckStatusRegsiter" class="button" onclick="checkEmpty()">
                            <i class="far fa-plus-square fa-lg"></i>
                            สมัครสมาชิก
                        </button>
                    </div>

                    <div class="btnReset">
                        <button class="button" type="reset" onclick="resetData()">    
                            <i class="fas fa-ban"></i>
                            ล้างข้อมูล
                        </button>
                    </div>

                </div>
        </div>


    <!-- Footer -->
    <?php include "./file_link/footer.php"; ?>
    
    
    <script src="./assets/js/_title_change.js" onload="switchTitle('สมัครสมาชิกหอพัก')"></script>
    <script type="text/javascript">
    
        function resetBgAutoComplete() {
            for (let i = 0; i < 4; i++) {
                let txt = ['autocomplete1', 'autocomplete2', 'autocomplete3', 'autocomplete4']
                document.getElementById(txt[i]).style.backgroundColor = '#fff';
            }
        }
        setTimeout(() => {  resetBgAutoComplete();
            setTimeout(() => {  resetBgAutoComplete();
                setTimeout(() => {  resetBgAutoComplete();
                    setTimeout(() => {  resetBgAutoComplete();
                        setTimeout(() => {  resetBgAutoComplete();
                            setTimeout(() => {  resetBgAutoComplete();
                            }, 10000)
                        }, 5000)
                    }, 2000)
                }, 1000)
            }, 500)
        }, 200)
        
    </script>

    <script src="./assets/js/_register.js"></script>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.20/js/uikit.min.js"></script>

    <!-- dependencies for zip mode -->
    <script type="text/javascript" src="./assets/AddressJSON/dependencies/zip.js/zip.js"></script>
    <!-- / dependencies for zip mode -->

    <script type="text/javascript" src="./assets/AddressJSON/dependencies/JQL.min.js"></script>
    <script type="text/javascript" src="./assets/AddressJSON/dependencies/typeahead.bundle.js"></script>

    <script type="text/javascript" src="./assets/AddressJSON/dist/jquery.Thailand.min.js"></script>

    <script type="text/javascript">

        $.Thailand({
            database: './assets/AddressJSON/database/db.json',

            $district: $('#form_register [name="txt_locality"]'),
            $amphoe: $('#form_register [name="txt_district"]'),
            $province: $('#form_register [name="txt_province"]'),
            $zipcode: $('#form_register [name="txt_zipCode"]'),

            onDataFill: function(data) {
                console.info('Data Filled', data);
            },

            onLoad: function() {
                console.info('Autocomplete is ready!');
                $('#loader, .demo').toggle();
            }
        });

    </script>

</body>
</html>

<?php
    while ($row = $find_branch->fetch(PDO::FETCH_ASSOC)) {
        echo "<script>
            dataBranchOnJs.fac_id.push(".$row['fac_id'].");
            dataBranchOnJs.branch_id.push(".$row['branch_id'].");
            dataBranchOnJs.branch_name.push("."'".$row['branch_name']."'".");
        </script>";
    }
?>

<!-- INSERT DATA FAM SOS 2 DIABLE FUTURE -->
<!-- // Insert Class family data 3
/*
    $fam_sex = $_POST['select_sexEmergency1'];
    $fam_firstname = $_POST['txt_firstnameEmergency1'];
    $fam_lastname = $_POST['txt_lastnameEmergency1'];
    $fam_tel = $_POST['txt_telEmergency1'];
    $fam_career = null;
    $fam_work_at = null;
    $fam_status = 1;    // 1 is life ,  2 is dead or die
    $person_status = 3; // 1&2 person in family 1, 2 person sos 3,4
    $person_is = $_POST['select_person_is_Emergency1'];

    $fam_statusInsert3 = $famClass->Insert(
        $std_id['std_id'], $fam_sex,
        $fam_firstname, $fam_lastname, $fam_tel,
        $fam_career, $fam_work_at,  $fam_status,
        $person_status, $person_is
    );
*/


// Insert Class family data 4
/*
    $fam_sex = $_POST['select_sexEmergency2'];
    $fam_firstname = $_POST['txt_firstnameEmergency2'];
    $fam_lastname = $_POST['txt_lastnameEmergency2'];
    $fam_tel = $_POST['txt_telEmergency2'];
    $fam_career = null;
    $fam_work_at = null;
    $fam_status = 1;    // 1 is life ,  2 is dead or die
    $person_status = 4; // 1&2 person in family 1, 2 person sos 3,4
    $person_is = $_POST['select_person_is_Emergency2'];

    $fam_statusInsert4 = $famClass->Insert(
        $std_id['std_id'], $fam_sex,
        $fam_firstname, $fam_lastname, $fam_tel,
        $fam_career, $fam_work_at,  $fam_status,
        $person_status, $person_is
    );
*/