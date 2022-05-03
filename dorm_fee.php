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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
<body>

    <!-- Menu  -->
    <?php include "./file_link/navbar.php"; ?>

    <div class="container">
        <div class="container_fee">
            <div class="areaFee">
                <p class="veryTitle userSelectNone">ค่าธรรมเนียมหอพัก</p>
                <div class="icon fa-8x"> <i class="fas fa-bed"></i> </div>
                
                <div class="room_fee">                    
                    <div id="text" class="title userSelectNone"> <p>ค่าห้องพักต่อเทอม</p> </div>
                
                    <div id="text" class="man userSelectNone"> <p>หอพักชาย</p> </div>
                    <div id="text" class="women userSelectNone"> <p>หอพักหญิง 1</p> </div>
                    <div id="text" class="women2 userSelectNone"> <p>หอพักหญิง 2</p> </div>
            
                    <div id="text" class="manT1 txt price_male"> <p>3,600 บาท</p> </div>
                    <!-- <div id="text" class="manT2 txt"> <p></p> </div> -->
                    
                    <div id="text" class="womenT1 txt price_female_1"> <p>3,600 บาท</p> </div>
                    <!-- <div id="text" class="womenT2 txt"> <p></p> </div> -->
                    
                    <div id="text" class="women2T1 txt price_female_2_f_1-3"> <p>4,600 บาท &nbsp; ชั้น 1-3</p> </div>
                    <div id="text" class="women2T2 txt price_female_2_f_4-5"> <p>3,600 บาท &nbsp; ชั้น 4-5</p> </div>
                </div>
            </div>
            
            <div class="areaInsurance">
                <div class="insurance">
                    <div class="icon fa-4x"> <i class="fas fa-exclamation-circle"></i> </div>
                    <div id="text" class="title userSelectNone"> <p style="font-family: 'Prompt', sans-serif">ประกันทรัพย์สินเสียหาย</p> </div>
                    <div id="text" class="text price_guarantee"> <p style="font-family: 'Prompt', sans-serif">>1,000 บาท</p> </div>
                </div>
            </div>
                
            <div class="areaInsuKey">
                <div class="insuKey">
                    <div class="icon fa-4x"> <i class="fas fa-key"></i> </div>
                    <div id="text" class="title userSelectNone"> <p style="font-family: 'Prompt', sans-serif">ค่าประกันกุญแจ</p> </div>
                    <div id="text" class="text price_key"> <p style="font-family: 'Prompt', sans-serif">>100 บาท</p> </div>
                </div>
            </div>
            
            <div class="areafeeToday">
                <div class="feeToday">
                    <div class="icon fa-4x"> <i class="fas fa-sun"></i> </div>
                    <div id="text" class="title userSelectNone"> <p style="font-family: 'Prompt', sans-serif">ค่าห้องพักภาคฤดูร้อน</p> </div>
                    <div id="text" class="text price_summer"> <p style="font-family: 'Prompt', sans-serif">>40 บาท / วัน</p> </div>
                </div>
            </div>
            
        </div>
    </div>

    <?php 
    
        // $sql = "INSERT INTO * ".${sfsf}
    ?>
        
    <!-- Footer -->
    <?php include "./file_link/footer.php"; ?>
    
    <script src="./assets/js/_title_change.js" onload="switchTitle('ค่าธรรมเนียมหอพัก')"></script>
    <script type="text/javascript">
        var elements = {
            fee_dorm: {
                male: document.getElementsByClassName('price_male')[0],
                female_1: document.getElementsByClassName('price_female_1')[0],
                female_2_floor_1_to_3: document.getElementsByClassName('price_female_2_f_1-3')[0],
                female_2_floor_4_to_5: document.getElementsByClassName('price_female_2_f_4-5')[0]
            },
            insurance: {
                guarantee_room: document.getElementsByClassName('price_guarantee')[0],
                key_door: document.getElementsByClassName('price_key')[0],
                price_room_on_summer: document.getElementsByClassName('price_summer')[0]
            }
        };

        let afterPrice = ' บาท';

        axios.get('./assets/data/fee_dorm.json')
        .then((res) => {
            res.data = JSON.parse(res.data);
            console.log('res.data', res.data);
            elements.fee_dorm.male.innerHTML = `${new Intl.NumberFormat('th-TH').format(res.data.fee_dorm.male) } ${afterPrice}`;
            elements.fee_dorm.female_1.innerHTML = `${new Intl.NumberFormat('th-TH').format(res.data.fee_dorm.female_1)} ${afterPrice}`;
            elements.fee_dorm.female_2_floor_1_to_3.innerHTML = `ชั้น 1-3 &nbsp;${new Intl.NumberFormat('th-TH').format(res.data.fee_dorm.female_2_floor_1_to_3)} ${afterPrice}`;
            elements.fee_dorm.female_2_floor_4_to_5.innerHTML = `ชั้น 4-5 &nbsp;${new Intl.NumberFormat('th-TH').format(res.data.fee_dorm.female_2_floor_4_to_5)} ${afterPrice}`;
            elements.insurance.guarantee_room.innerHTML = `${new Intl.NumberFormat('th-TH').format(res.data.insurance.guarantee_room)} ${afterPrice}`;
            elements.insurance.key_door.innerHTML = `${new Intl.NumberFormat('th-TH').format(res.data.insurance.key_door)} ${afterPrice}`;
            elements.insurance.price_room_on_summer.innerHTML = `${new Intl.NumberFormat('th-TH').format(res.data.insurance.price_room_on_summer)} ${afterPrice}  / วัน`;
        })
        .catch((err) => {
            alert('เกิดข้อผิดพลาดบางอย่าง');
        });



    </script>
</body>    
</html>
