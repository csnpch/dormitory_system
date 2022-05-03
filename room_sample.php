<?php 
    session_start(); 
    require_once ('./disable_error_report.php');
    require_once ('./classes/Status.php');
    $statusClass = new Status();

    $statusMain = $statusClass->Find('status_switch', 'status_name', 'system_main');
    $statusMain = $statusMain->fetch(PDO::FETCH_ASSOC);
    if (intval($statusMain['status_switch']) === 1) { header('Location: ./maintenance.php'); }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>หอพักนักศึกษา มจพ. ปราจีนบุรี</title>
        <link rel="stylesheet" href="./assets/css/main.css">
        <link rel="icon" href="./assets/img/logoKmutnb.webp">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
<body id="body">

    <!-- Menu  -->
    <?php include "./file_link/navbar.php"; ?>

    <div id="container_ImageZoom" class="deactive">
    <div id="closeBtnImageZoom"><i class="fas fa-times fa-2x"></i></div>
    <div id="areaImageRoomZoom">
        <div id="zoom">
            <img id="imgZoom" src="" alt="" width="100%" height="100%">
        </div>
    </div>
        <div id="overlayImageZoom"></div>
    </div>

    <div class="container">
        <div class="areaSample">
            <div class="areaSection">
                <div class="session1">
                    <div class="title">
                        <p class="txtSample" style="font-family: 'Kanit', sans-serif">ตัวอย่างห้องพัก</p>
                    </div>
                          
                    <div class="txtSelect" style="font-family: 'Prompt', sans-serif"">
                        <p>เลือกหอพักที่ต้องการดู</p>
                    </div>
                
                    <div class="select userSelectNone" style="font-family: 'Kanit', sans-serif">
                        <div class="btn btn1"><p>หอชาย</p></div>
                        <div class="btn btn2"><p>หอหญิง 1</p></div>
                        <div class="btn btn3"><p>หอหญิง 2</p></div>
                    </div>
                          
                </div>
                <div class="session2">
                    <div class="status userSelectNone">
                        <span class="statusTxt" style="font-family: 'Prompt', sans-serif;">หอพักชาย</span>       
                    </div>
                    <div class="description" style="margin-top: 40px">
                    <p class="userSelectNone">คำอธิบาย</p>
                    <div id="txt" class="textDescript">
                        <ul>
                            <li>หอพักชาย ห้องละ 5 คน</li>
                            <li>เตียงเดี่ยว 5 เตียง</li>
                            <li>ตู้เสื้อผ้า โต๊ะเขียนหนังสือและเก้าอี้ คนละ 1 ชุด</li>
                            <li>พัดลมติดผนัง 4 ตัว</li>
                            <li>ระเบียงหลังห้องพร้อมราวตากผ้า</li>
                        </ul>
                    </div>
                    <div id="txt" class="textDescript deactive">
                        <ul>
                            <li>หอพักหญิง 1 ห้องละ 4 คน</li>
                            <li>เตียง 2 ชั้น 2 เตียง</li>
                            <li>ตู้เสื้อผ้า โต๊ะเขียนหนังสือและเก้าอี้ คนละ 1 ชุด</li>
                            <li>พัดลมเพดาล 1 ตัว</li>
                            <li>ระเบียงหลังห้องพร้อมราวตากผ้า</li>
                        </ul>
                    </div>
                    <div id="txt" class="textDescript deactive">
                        <ul>
                            <li>หอพักหญิง 2 ห้องละ 3-4 คน</li>
                            <li>เตียง 2 ชั้น 2 เตียง หรือ เตียงเดียว 3 เตียง</li>
                            <li>ตู้เสื้อผ้า โต๊ะเขียนหนังสือและเก้าอี้ คนละ 1 ชุด</li>
                            <li>พัดลมเพดาล 1 ตัว</li>
                            <li>ระเบียงหลังห้องพร้อมราวตากผ้า</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="areaImage">
            <div class="dorm">
                <img id="zoomImg" onclick="clickZoom(1,1);" src="./assets/img/dorm/room_male_01.webp" alt="">
                <img id="zoomImg" onclick="clickZoom(1,2);" src="./assets/img/dorm/room_male_02.webp" alt="">
                <img id="zoomImg" onclick="clickZoom(1,3);" src="./assets/img/dorm/room_male_03.webp" alt="">
                <img id="zoomImg" onclick="clickZoom(1,4);" src="./assets/img/dorm/room_male_04.webp" alt="">
                <img id="zoomImg" onclick="clickZoom(1,5);" src="./assets/img/dorm/room_male_05.webp" alt="">
                <img id="zoomImg" onclick="clickZoom(1,6);" src="./assets/img/dorm/room_male_06.webp" alt="">
                <img id="zoomImg" onclick="clickZoom(1,7);" src="./assets/img/dorm/room_male_07.webp" alt="">
                <img id="zoomImg" onclick="clickZoom(1,8);" src="./assets/img/dorm/room_male_08.webp" alt="">
                <!-- <img id="zoomImg" onclick="clickZoom(1,9);" src="./assets/img/dorm/room_male_09.webp" alt=""> -->
                <!-- <img id="zoomImg" onclick="clickZoom(1,10);" src="./assets/img/dorm/room_male_10.webp" alt=""> -->
            </div>
            <div class="dorm deactive">
                <img id="zoomImg" onclick="clickZoom(2,1);" src="./assets/img/dorm/room_female_1_01.webp" alt="">                 
                <img id="zoomImg" onclick="clickZoom(2,2);" src="./assets/img/dorm/room_female_1_02.webp" alt="">                 
                <img id="zoomImg" onclick="clickZoom(2,3);" src="./assets/img/dorm/room_female_1_03.webp" alt="">
                <img id="zoomImg" onclick="clickZoom(2,4);" src="./assets/img/dorm/room_female_1_04.webp" alt="">
                <!-- <img id="zoomImg" onclick="clickZoom(2,5);" src="./assets/img/dorm/room_female_1_05.webp" alt=""> -->
                <!-- <img id="zoomImg" onclick="clickZoom(2,6);" src="./assets/img/dorm/room_famele_1_06.webp" alt=""> -->
                <!-- <img id="zoomImg" onclick="clickZoom(2,7);" src="./assets/img/dorm/room_famele_1_07.webp" alt=""> -->
                <!-- <img id="zoomImg" onclick="clickZoom(2,8);" src="./assets/img/dorm/room_famele_1_08.webp" alt=""> -->
                <!-- <img id="zoomImg" onclick="clickZoom(2,9);" src="./assets/img/dorm/room_famele_1_09.webp" alt=""> -->
                <!-- <img id="zoomImg" onclick="clickZoom(2,10);" src="./assets/img/dorm/room_famele_1_10.webp" alt=""> -->
            </div>
            <div class="dorm deactive">
                <img id="zoomImg" onclick="clickZoom(3,1);" src="./assets/img/dorm/room_female_2_01.webp" alt="">
                <img id="zoomImg" onclick="clickZoom(3,2);" src="./assets/img/dorm/room_female_2_02.webp" alt="">
                <img id="zoomImg" onclick="clickZoom(3,3);" src="./assets/img/dorm/room_female_2_03.webp" alt="">
                <img id="zoomImg" onclick="clickZoom(3,4);" src="./assets/img/dorm/room_female_2_04.webp" alt="">
                <img id="zoomImg" onclick="clickZoom(3,5);" src="./assets/img/dorm/room_female_2_05.webp" alt="">
                <!-- <img id="zoomImg" onclick="clickZoom(3,6);" src="./assets/img/dorm/room_female_2_06.webp" alt=""> -->
                <!-- <img id="zoomImg" onclick="clickZoom(3,7);" src="./assets/img/dorm/room_female_2_07.webp" alt=""> -->
                <!-- <img id="zoomImg" onclick="clickZoom(3,8);" src="./assets/img/dorm/room_female_2_08.webp" alt=""> -->
                <!-- <img id="zoomImg" onclick="clickZoom(3,9);" src="./assets/img/dorm/room_female_2_09.webp" alt=""> -->
                <!-- <img id="zoomImg" onclick="clickZoom(3,10);" src="./assets/img/dorm/room_female_2_10.webp" alt=""> -->
            </div>
        </div>
    </div>
        
    <!-- Footer -->
    <?php include "./file_link/footer.php"; ?>
    
    <script src="./assets/js/_title_change.js" onload="switchTitle('ตัวอย่างห้องพัก')"></script>
    <script src="./assets/js/_room_sample.js"></script>    
</body>    
</html>
