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
    <div id="areaImageZoom">
        <div id="zoom">
            <img id="imgZoom" src="" alt="" width="100%" height="100%">
        </div>
    </div>
        <div id="overlayImageZoom"></div>
    </div>

    <div class="container">
        <div class="areaPlan">
            <div class="session1 userSelectNone">
                <div class="titleText">
                    <p id="txtStatus">แผนผังหอพัก</p>
                </div>
                <div class="textSelect">
                    <p>เลือกแผนผังหอพักที่ต้องการดู</p>
                </div>
                <div class="btnSelect">
                    <div class="btn btn1"><p>หอชาย</p></div>
                    <div class="btn btn2"><p>หอหญิง 1</p></div>
                    <div class="btn btn3"><p>หอหญิง 2</p></div>
                </div>
            </div>
            <div class="session2 userSelectNone">
                <div class="plan">
                    <div class="item">
                        <p>ชั้น 1</p>
                        <img id="zoomImg" onclick="clickZoom(1,1);" src="./assets/img/dorm/plan_male_01.webp" alt="">
                    </div>
                    <div class="item">
                        <p>ชั้น 2</p>
                        <img id="zoomImg" onclick="clickZoom(1,2);" src="./assets/img/dorm/plan_male_02.webp" alt="">
                    </div>
                    <div class="item">
                        <p>ชั้น 3</p>
                        <img id="zoomImg" onclick="clickZoom(1,3);" src="./assets/img/dorm/plan_male_03.webp" alt="">
                    </div>
                    <div class="item">
                        <p>ชั้น 4</p>
                        <img id="zoomImg" onclick="clickZoom(1,4);" src="./assets/img/dorm/plan_male_04.webp" alt="">
                    </div>
                    <div class="item">
                        <p>ชั้น 5</p>
                        <img id="zoomImg" onclick="clickZoom(1,5);" src="./assets/img/dorm/plan_male_05.webp" alt="">
                    </div>
                </div>
                <div class="plan deactive">
                    <div class="item">
                        <p>ชั้น 1</p>
                        <img id="zoomImg" onclick="clickZoom(2,1);" src="./assets/img/dorm/plan_female_1_01.webp" alt="">
                    </div>
                    <div class="item">
                        <p>ชั้น 2</p>
                        <img id="zoomImg" onclick="clickZoom(2,2);" src="./assets/img/dorm/plan_female_1_02.webp" alt="">
                    </div>
                    <div class="item">
                        <p>ชั้น 3</p>
                        <img id="zoomImg" onclick="clickZoom(2,3);" src="./assets/img/dorm/plan_female_1_03.webp" alt="">
                    </div>
                    <div class="item">
                        <p>ชั้น 4</p>
                        <img id="zoomImg" onclick="clickZoom(2,4);" src="./assets/img/dorm/plan_female_1_04.webp" alt="">
                    </div>
                    <div class="item">
                        <p>ชั้น 5</p>
                        <img id="zoomImg" onclick="clickZoom(2,5);" src="./assets/img/dorm/plan_female_1_05.webp" alt="">
                    </div>
                </div>
                <div class="plan deactive">
                    <div class="item">
                        <p>ชั้น 1</p>
                        <img id="zoomImg" onclick="clickZoom(3,1);" src="./assets/img/dorm/plan_female_2_01.webp" alt="">
                    </div>
                    <div class="item">
                        <p>ชั้น 2</p>
                        <img id="zoomImg" onclick="clickZoom(3,2);" src="./assets/img/dorm/plan_female_2_02.webp" alt="">
                    </div>
                    <div class="item">
                        <p>ชั้น 3</p>
                        <img id="zoomImg" onclick="clickZoom(3,3);" src="./assets/img/dorm/plan_female_2_03.webp" alt="">
                    </div>
                    <div class="item">
                        <p>ชั้น 4</p>
                        <img id="zoomImg" onclick="clickZoom(3,4);" src="./assets/img/dorm/plan_female_2_04.webp" alt="">
                    </div>
                    <div class="item">
                        <p>ชั้น 5</p>
                        <img id="zoomImg" onclick="clickZoom(3,5);" src="./assets/img/dorm/plan_female_2_05.webp" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <!-- Footer -->
    <?php include "./file_link/footer.php"; ?>
    
    <script src="./assets/js/_title_change.js" onload="switchTitle('แผนผังหอพัก')"></script>
    <script src="./assets/js/_dorm_plan.js"></script>    
</body>    
</html>
