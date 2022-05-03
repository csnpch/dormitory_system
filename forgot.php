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
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
<body>

    <?php 
        require_once ('./classes/Student.php');
        require_once ('./classes/Encode.php');
        $stdClass = new Student();
        $endcodeClass = new Encode();
 
        if (isset($_POST['btn_check'])) {
            $chk_idcard = $_POST['id_card'];
            $chk_firstname = $_POST['firstname'];
            $chk_lastname = $_POST['lastname'];
            $chk_birthday = $_POST['birthday'];
            
            $findData = $stdClass->Find('std_firstname, std_lastname, std_birthday, std_salt', 'std_idcard', $chk_idcard);
            $dataStd = $findData->fetch(PDO::FETCH_ASSOC);

            if ($findData->rowCount() === 0 || $chk_idcard === "") {
                echo "<script>
                    Swal.fire({
                        title: 'ไม่พบข้อมูลในระบบ',
                        text: 'หากไม่สามารถดำเนินการได้จริง ๆ กรุณาติดต่อหอพัก',
                        icon: 'error',
                        showConfirmButton: false,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'ปิด'
                    })
                </script>";
            } else if ($dataStd['std_firstname'] === $chk_firstname && $dataStd['std_lastname'] === $chk_lastname &&
                        $dataStd['std_birthday'] === $chk_birthday) {

                $endcodeClass->salt = $dataStd['std_salt'];
                $passwordEncode = $endcodeClass->Encode($chk_idcard);
                $data_sets = array("std_password");
                $data_news = array($passwordEncode);
                $statusChangePassword = $stdClass->Update_Select($data_sets, $data_news, 'std_idcard', $chk_idcard);
                
                if ($statusChangePassword) {
                    echo "<script>
                        Swal.fire({
                            title: 'รีเซ็ตรหัสผ่านแล้ว',
                            text: 'รหัสผ่านของคุณคือ : ".$chk_idcard."',
                            icon: 'success',
                            showConfirmButton: true,
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'ปิด',
                            footer: '<a href=".'login.php'.">เข้าสู่ระบบเลย คลิ๊ก!!</a>'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href='index.php'
                            } else {
                                window.location.href='index.php'
                            }
                        })
                    </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'ระบบเกิดข้อผิดพลาด',
                            text: 'ไม่สามารถรีเซ็ตรหัสผ่านได้ โปรดติดต่อเจ้าหน้าที่ให้ทราบ',
                            icon: 'error',
                            showConfirmButton: false,
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: 'ปิด'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href='index.php'
                            }
                        })
                    </script>";
                }
                
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'พบเลขบัตรประชาชนในระบบ',
                        text: 'แต่ข้อมูลบางส่วนยังไม่ตรง เช่น ชื่อจริง นามสกุล หรือวันเกิด',
                        icon: 'warning',
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






    <!-- Menu  -->
    <?php include "./file_link/navbar.php"; ?>

    <form action="" method="post">
        <div class="container_forgot">
            <p class="title userSelectNone">รีเช็ตรหัสผ่าน</p>
            
            <div class="areaInputCheck">
                <div class="data">
                    <p class="userSelectNone">หมายเลขบัตรประชาชน</p>
                    <input name="id_card" class="input" type="text" placeholder="หมายเลขบัตรประชาชน">
                </div>
                <div class="data">
                    <p class="userSelectNone">ชื่อจริง</p>
                    <input name="firstname" class="input" type="text" placeholder="ประหยัด">
                </div>
                <div class="data">
                    <p class="userSelectNone">นามสกุล</p>
                    <input name="lastname" class="input" type="text" placeholder="จันทร์อังคาร">
                    <p class="userSelectNone">วันเกิดของคุณ</p>
                    <input name="birthday" class="date" type="date">
                </div>
                    <input name="btn_check" class="submit" type="submit" value="ตรวจสอบ">
            </div>
            <div id="result" class="deactive">
                <p class="userSelectNone">รหัสผ่านของคุณคือ</p>
                <p class="password_is"><?php echo $chk_idcard; ?></p>
                <a class="userSelectNone" href="login.php">รู้รหัสผ่านแล้ว เข้าสู่ระบบเลย</a>
            </div>
        </div>
    </form>
        
    <!-- Footer -->
    <?php include "./file_link/footer.php"; ?>
    
    





    <script src="./assets/js/_title_change.js" onload="switchTitle('ลืมรหัสผ่าน')"></script>
    <script src="./assets/js/_forgot.js"></script>
    <script type="text/javascript">
        function confirmDataCheckForReset() {
            alert("HI");
        }
    </script>
</body>    
</html>
