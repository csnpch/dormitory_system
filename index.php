<?php 
    session_start(); 
    require_once ('./disable_error_report.php');
    require_once ('./classes/News.php');
    require_once('./classes/Status.php');
    
    $newsClass = new News();
    $statusClass = new Status();

    $statusMain = $statusClass->Find('status_switch', 'status_name', 'system_main');
    $statusMain = $statusMain->fetch(PDO::FETCH_ASSOC);
    if (intval($statusMain['status_switch']) === 1) { header('Location: ./maintenance.php'); }

    $statusBook = $statusClass->Find('status_id, status_switch, status_date_start, status_date_stop', 'status_name', 'สถานะการจองห้องพัก');
    $statusBook = $statusBook->fetch(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="./assets/css/tailwind.css">
    <link rel="stylesheet" href="./assets/css/style_x_tailwind.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style> 
        #container_navbar { background-color: rgba(0, 0, 0, 0.6); }
        svg {
            width: 28.8rem;
        }
        .defocus { user-select: none !important; }
    </style>
</head>
<body class="overflow-hidden">

    <div id="logoLoading" class="defocus transition-all top-0 duration-700 fixed flex flex-col justify-center items-center w-full h-full z-10 text-white">
        <img class="defocus relative z-20 w-52 -mt-16" src="./assets/img/logoKmutnb.webp" alt="">
        <svg class="absolute z-10 -mt-12" version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
            <path fill="#fff" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
            <animateTransform 
                attributeName="transform" 
                attributeType="XML" 
                type="rotate"
                dur="1s" 
                from="0 50 50"
                to="360 50 50" 
                repeatCount="indefinite" />
        </path>
        </svg>
        <div class="absolute z-0 w-full h-full bg-red-900"></div>
    </div>

    <input id="status_book" class="hidden" type="text" value="<?php echo ($statusBook['status_switch']) ?>">

    <div id="alertStatusBook" class="hidden defocus z-50 fixed right-0 bottom-0 p-4 m-4 text-sm sm:text-md sm:pl-6 sm:pr-6 sm:pt-4 sm:pb-4 sm:m-6 bg-green-100 shadow-md">
        ประกาศ 📢&nbsp;<br class="sm-hidden">ขณะนี้หอพักได้เปิดให้จองห้องพักแล้ว 🎉🎉
    </div>

    <?php
        $announceNew = $newsClass->Select_Order('news_header, news_link_img, news_link_main, created_at', 'created_at', 'DESC LIMIT 1');
        $announceNew = $announceNew->fetch(PDO::FETCH_ASSOC);
        if( !file_exists("./assets/img/news/importantNews.jpg") ) {
            try {
                copy($announceNew['news_link_img'], './assets/img/news/importantNews.jpg');
            } catch (\Throwable $th) { }
        }
    ?>

    <?php if(!isset($_SESSION['popupNew'])):
        $_SESSION['popupNew'] = FALSE; 
    ?>
        <div id="container_popup">
            <div id="areaPopup">
                <div id="closeBtn"><i class="fas fa-times fa-2x"></i></div>
                <div id="img">
                    <a href="<?php echo $announceNew['news_link_main'] ?>" 
                    target="_blank"><img src="./assets/img/news/importantNews.jpg" alt="" width="100%" height="100%"></a>
                </div>
            </div>
            <div id="overlayPopup"></div>
        </div>
    <?php endif; ?>

    <?php include ('./file_link/navbar.php'); ?>

    <div id="indexPage" class="container_sass deactive" style="display: block;">        
        <div class="header">
            <div class="banner">
                <div class="overlay"></div>
                <div id="slide" class="slide" style="background: url('./assets/img/dorm/women_01.webp');"></div>
                <div class="flexCenter">
                    <div class="textArea" onmouseover="openSubmenu(2)">
                        <div class="largeText">
                            <p>หอพักนักศึกษามหาวิทยาลัยเทคโนโลยี</p>
                            <p>พระจอมเกล้าพระนครเหนือ วิทยาเขตปราจีนบุรี</p>
                        </div>
                        <div class="smallText">
                            <p>Dormitory king mongkut's university of technology, Prachinburi.</p>
                        </div>
                        <div class="button">
                            <?php if (isset($_SESSION['std_id'])): ?>
                                <div id="btnLogin" class="btn2"> <a href="system_book.php" style="border-radius: 50px !important;">จองห้องพัก</a> </div>
                            <?php elseif (isset($_SESSION['adm_id'])): ?>
                                <div id="btnLogin" class="btn2"> <a href="./admin/dashboard.php" style="border-radius: 50px !important;">จัดการระบบหอพัก</a> </div>
                            <?php else: ?>
                                <div id="btnLogin" class="btn1"> <a href="login.php">เข้าสู่ระบบ</a> </div>
                                <div class="btn2"> <a href="register.php">สมัครสมาชิก</a> </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="godown">
            <a href="#sessionArea"><i class="fas fa-chevron-down md_hidden"></i></a>
        </div>
        
    </div>
    <div class="containerMain">
    
        <div class="container_news" id="sessionArea">
            <div class="announceNews userSelectNone">
                <p>ประกาศล่าสุด</p>
                <div class="announceImg">
                    <center>
                    <a href="<?php echo $announceNew['news_link_main'] ?>" target="_blank">
                        <img src="./assets/img/news/importantNews.jpg">
                    </a>
                    </center>
                </div>
                <div class="container_btnNews">
                    <!-- ลิ้งเดียวกับรูปภาพด้านบน -->
                    <a href="<?php echo $announceNew['news_link_main'] ?>" 
                        target="_blank">รายละเอียด</a>
                </div>
            </div>

            <?php
                function subTextNews($txt) {
                    if (strlen($txt) > 190) {
                        $txt = substr($txt, 0, 190);
                        return $txt.'...';
                    }
                    return $txt;
                }
            ?>

            <div class="areaNews">
                <p class="userSelectNone">ข่าวสารหอพัก</p>
                <div class="tableNews">
                    <div class="headTable userSelectNone">
                        <span>หัวข้อข่าว</span>
                        <span>วันที่ประกาศ</span>
                    </div>
                    <?php 
                        function dateFormat($str) {
                            $str = explode(" ", $str);
                            $str = explode("-", $str[0]);
                            return $str[2].'/'.$str[1].'/'.$str[0];
                        }

                        $selectNews = $newsClass->Select_Order('news_header, news_link_img, news_link_main, created_at', 'created_at', 'DESC LIMIT 8');
                        while ($value = $selectNews->fetch(PDO::FETCH_ASSOC)):
                    ?>
                            <div class="news">
                                <span>
                                    <!--  -->
                                    <a title="<?php echo $value['news_header'] ?>" href="<?php echo $value['news_link_main'] ?>" target="_blank">
                                        <?php echo subTextNews($value['news_header']); ?>
                                    </a>
                                </span>
                                <span class="dateNew">
                                    <?php 
                                        echo dateFormat($value['created_at']); 
                                    ?>
                                </span>
                            </div>
                    <?php 
                        endwhile; 
                    ?>
                </div>
                <div id="popupNews" class="container_btnNews userSelectNone">
                    <a href="https://www.facebook.com/%E0%B8%AB%E0%B8%AD%E0%B8%9E%E0%B8%B1%E0%B8%81%E0%B8%99%E0%B8%B1%E0%B8%81%E0%B8%A8%E0%B8%B6%E0%B8%81%E0%B8%A9%E0%B8%B2-%E0%B8%A1%E0%B8%88%E0%B8%9E-%E0%B8%9B%E0%B8%A3%E0%B8%B2%E0%B8%88%E0%B8%B5%E0%B8%99%E0%B8%9A%E0%B8%B8%E0%B8%A3%E0%B8%B5-225226107507988/photos/?tab=album&ref=" target="_blank" class="btn">ข่าวทั้งหมด</a>
                </div>
            </div>
        </div>
        
        <div class="container_contact">
            <p class="textTitle userSelectNone">ช่องทางติดต่อหอพัก</p>
            <div class="areaContact">
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3868.5074666381806!2d101.34320721491846!3d14.165029490081096!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311c532b780ce81b%3A0x89d2e263a6dfb9d5!2z4Lir4Lit4Lie4Lix4LiBIOC4oeC4iOC4niDguJvguKPguLLguIjguLXguJk!5e0!3m2!1sth!2sth!4v1621959668593!5m2!1sth!2sth" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="contacts">
                    <div class="fb">
                        <div id="icon">
                            <i class="fab fa-facebook-f"></i>
                            <!-- <i class="fab fa-facebook-square"></i> -->
                            <!-- <i class="fab fa-facebook"></i> -->
                        </div>
                        <p>หอพักนักศึกษา มจพ. ปราจีนบุรี</p>
                        <a href="https://www.facebook.com/%E0%B8%AB%E0%B8%AD%E0%B8%9E%E0%B8%B1%E0%B8%81%E0%B8%99%E0%B8%B1%E0%B8%81%E0%B8%A8%E0%B8%B6%E0%B8%81%E0%B8%A9%E0%B8%B2-%E0%B8%A1%E0%B8%88%E0%B8%9E-%E0%B8%9B%E0%B8%A3%E0%B8%B2%E0%B8%88%E0%B8%B5%E0%B8%99%E0%B8%9A%E0%B8%B8%E0%B8%A3%E0%B8%B5-225226107507988"
                            target="_blank">ไปยังเว็บเพจ</a>
                    </div>
                    <div class="phone">
                        <div id="icon">
                            <i class="fas fa-phone-alt"></i>
                            <!-- <i class="fas fa-phone-square-alt"></i> -->
                        </div>
                        <div class="number">
                            <p>037-217330</p>
                            <p>037-217300 ต่อ 7340</p>
                            <p>037-217300 ต่อ 7341</p>
                            <p>037-217300 ต่อ 7342</p>
                        </div>
                        <div class="text">
                            <p>มจพ. ปราจีน ฯ</p>
                            <p>หอพักนักศึกษาชาย</p>
                            <p>หอพักนักศึกษาหญิง 1</p>
                            <p>หอพักนักศึกษาหญิง 2</p>
                        </div>
                    </div>
                    <div class="location">
                        <div id="icon">
                            <i class="fas fa-thumbtack"></i>
                            <!-- <i class="fas fa-map-marker-alt"></i> -->
                        </div>
                        <div class="areaText">
                            <div class="text">
                                <p>หอพักนักศึกษา.... มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ</p>
                                <p>เลขที่ 129 หมู่ 21 ต.เนินหอม อ.เมืองปราจีบุรี จ.ปราจีนบุรี 25230</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


    <div id="container_popupNews" class="container_popupNews deactive">
        <div id="closeBtnNews"><i class="fas fa-times fa-2x"></i></div>
        <div class="areaNews">
            <div class="tableNews">
                <div class="headTable userSelectNone">
                    <span>หัวข้อข่าว</span>
                    <span>วันที่ประกาศ</span>
                </div>
                <!-- Limit 8 news !!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                <?php for($i = 0; $i < 60; $i++): ?>
                <div class="news">
                    <span>
                        <a href="https://www.facebook.com/media/set/?vanity=225226107507988&set=a.4238849449478947" target="_blank">
                            จ่ายค่าหอพัก สำหรับนักศึกษาเก่าที่ยืนยันอยู่หอพัก ภาคเรียนที่ 2/2563
                        </a>
                    </span>
                    <span>24/01/12</span>
                </div>
                <?php endfor; ?>
            </div>
        </div>
        <div id="overlayPopupNews"></div>
    </div> 
    
    <?php include ('./file_link/footer.php'); ?>

    <!-- alertStatusRoomActive -->

    <script type="text/javascript" src="./assets/js/_index.js"></script>
    <script type="text/javascript">
        
        if(parseInt(document.getElementById('status_book').value) == 1 || parseInt(document.getElementById('status_book').value) == 3) {
            setTimeout(() => {
                document.getElementById('alertStatusBook').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('alertStatusBook').classList.add('hidden');
                }, 4500);
            }, 3500);
        }

    </script>
</body>
</html>
