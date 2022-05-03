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

    require_once ('./../classes/News.php');
    require_once ('./../classes/ExchangeValue.php');
    
    $newsClass = new News();
    $exchangeClass = new ExchangeValue();

    $newsClass->autoDestroyNews(3);

?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการข่าวสารหอพัก</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <link rel="stylesheet" href="../assets/css/style_x_tailwind.css">
    <link rel="icon" href=" ../assets/img/logoKmutnb.webp">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../assets/node_modules/daisyui/dist/full.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="../assets/node_modules/daisyui/dist/full.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <style>
        
        .dataTables_filter {
            padding: 0 0 0.5rem 0;
        }

        .dataTables_filter input {
            padding: 0.1rem 0.5rem;
            outline: none;
            border: 1px solid #222;
        }

        .dataTables_length {
            font-size: 14px;
            margin-top: 0.2rem;
        }

        .dataTables_paginate a {
            font-size: 13px;
            margin-top: 6px;
        }

        .dataTables_info {
            margin-top: 10px;
            font-size: 13px;
        }

        .dataTables_length select {
            border: 1px solid #222;
        }

    </style>
</head>
<body class="font_prompt">

    <form action="#" method="POST" class="hidden">
        <input name="idNewsForDelete" class="idNewsForDelete" type="text" value>
        <input name="submit_delete_news" class="submit_delete_news" type="submit" value="del">
    </form>

    <script type="text/javascript">
        function deleteNews(idNews) {
            document.getElementsByClassName('idNewsForDelete')[0].value = idNews;
            Swal.fire({
                title: 'คุณต้องการที่จะลบข่าวสารใช่หรือไม่',
                text: 'หากลบแล้วจะไม่สามารถกู้คืนข้อมูลกลับมาได้',
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementsByClassName('submit_delete_news')[0].click();
                }
            })
        }
    </script>

<?php

    function subTextNews($txt) {
        if (strlen($txt) > 190) {
            $txt = substr($txt, 0, 190);
            return $txt.'...';
        }
        return $txt;
    }
    
?>

    <div class="flex">
        <!-- Sidebar -->
        <?php include ('./adm_file_link/sidebar.php'); ?>
        <!-- Navbar -->
        <div id="main" class="overflow-x-hidden flex flex-col w-full lg:w-11/12 ml-0 lg:ml-64 trasition-all duration-300 bg-gray-200 h-screen">
            <?php include ('./adm_file_link/navbar.php'); ?>

            <!-- SESSION -->
            <session class="font_kanit bg-gray-100 flex flex-col justify-center items-center w-min-screen pb-10 mt-6 md:ml-8 md:mr-8 md:pr-4 md:pl-4 rounded-md shadow-md">
                <p class="mt-6 text-xl">รูปภาพข่าวหน้าเว็บ</p>
                <div class="mt-4 w-6/12">
                    <center>
                        <a href="./../assets/img/news/importantNews.jpg" target="_blank">
                            <img src="./../assets/img/news/importantNews.jpg" style="max-height: 320px !important;">
                        </a>
                    </center>
                </div>
                <p class="mt-3">(หากภาพไม่เปลี่ยนให้กด Shift + F5)</p>
                <button class="btn_popupImportantChangeImgNews btn btn-xs mt-2 font_prompt">บังคับเปลี่ยน</button>
            </session>

            <div class="popupImportantChangeImgNews hidden fixed w-full md:w-10/12 h-screen z-40 flex flex-col justify-center items-center">
                <form action="#" method="POST">
                    <div class="bg-white text-center p-4 flex flex-col w-full rounded-md">
                        <p class="mb-2 text-xl text-red-900">ลิ้งภาพข่าว</p>
                        <textarea required name="txt_link_img_important" placeholder="link:url:img" class="border-2 border-black border-opacity-20 h-20 w-full p-2 rounded-md"></textarea>
                        <div class="grid grid-cols-2 gap-2 mt-2">
                            <button name="btn_ImportantChangeImgNews" class="btn btn-sm btn-info">บันทึก</button>
                            <button type="reset" class="btn_cancelImportantChangeImgNews btn btn-sm btn-error">ยกเลิก</button>
                        </div>
                    </div>
                </form>
            </div>

            <session id="manage_main" class="font_kanit bg-gray-100 flex flex-col justify-center items-center w-min-screen pb-10 mt-6 md:ml-8 md:mr-8 md:pr-4 md:pl-4 rounded-md shadow-md">
                
                <div class="header flex items-center justify-between w-11/12">
                    <p class="text-lg text-center sm:text-left mb-5 mt-10 sm:mb-6 text-xl mb-2 w-11/12 sm:pl-2 text-red-900">จัดการข่าวสารหอพัก</p>
                    <button class="btn_addNews btn btn-sm btn-success sm:mt-2 mr-4">
                        <i class="far fa-plus-square mr-2"></i>
                        เพิ่มข่าว
                    </button>
                </div>

                <?php 
                    $dataNews = $newsClass->Select_Order('*', 'created_at', 'DESC');
                ?>

                <div class="flex flex-col justify-center items-center overflow-x-auto p-1.5 w-11/12">

                    <div class="p-1.5 w-full">
                        
                        <table id="table_news" class="hidden text-center table table-zebra table-compact font_sarabun">
                            <thead>
                                <tr class="h-12">
                                    <th>#</th>
                                    <th>หัวข้อข่าว</th> 
                                    <th>ภาพข่าว</th>
                                    <th>วันที่ลงข่าว</th>
                                    <th class="text-center">จัดการ</th>
                                </tr>
                            </thead> 
                            <tbody id="sub_datas">
                            <?php
                                $arrayNews = array();
                                $i = 0;
                                while($valueNews = $dataNews->fetch(PDO::FETCH_ASSOC)):
                                    $i += 1;
                                    array_push($arrayNews, array($valueNews['news_id'], $valueNews['news_header'], $valueNews['news_link_img'], $valueNews['news_link_main']));
                            ?>
                                    <tr class="valueNews">
                                        <input type="text" name="txt_news_id" class="hidden" value="<?php echo $valueNews['news_id']; ?>">
                                        <td class="text-center"><?php echo $i; ?></td>
                                        <td class="value_news_haeder cursor-pointer hover:text-blue-800" title="<?php echo $valueNews['news_header'] ?>"><a target="_blank" href="<?php echo $valueNews['news_link_main'] ?>"><?php echo subTextNews($valueNews['news_header']); ?></a></td>
                                        <td><a class="value_news_link_img" target="_blank" href="<?php echo $valueNews['news_link_img'] ?>">คลิ๊กเพื่อดู</a></td>
                                        <td><?php echo $exchangeClass->DateThai($valueNews['created_at']); ?></td>
                                            <td class="text-center flex flex-row gap-x-0.5 justify-center font_prompt">
                                            <p class="news_id hidden"><?php echo $valueNews['news_id']; ?></p>
                                            <div name="edit_news" onclick="togglePopupEdit(<?php echo $valueNews['news_id']; ?>)" class="cursor-pointer pl-2 pr-2 p-1 bg-blue-500 text-black mr-0.5 hover:bg-blue-600 rounded-sm"><i class="fas fa-pencil-alt text-white"></i></div>
                                            <button onclick="deleteNews(<?php echo $valueNews['news_id']; ?>)" class="btn_deleteNews cursor-pointer pl-2 pr-2 p-1 bg-red-500 text-gray-50 hover:bg-red-600 rounded-sm"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                            <?php 
                                endwhile;
                            ?>
                            </tbody> 
                        </table>
                    </div>

                </div>

            </session>

            <div class="popupInsert hidden">
                    <div class="absolute bottom-0 flex justify-center items-center w-full md:w-9/12 h-screen z-50">
                        <div class="bg-white w-11/12 md:w-6/12 h-content p-6">
                            <p class="text-center font-medium text-xl">เพิ่มข่าว</p>
                            <form class="mt-4" action="#" name="form_insertDataNews" method="POST">
                                <p class="mt-2">หัวข้อข่าว</p>
                                <textarea required name="txt_news_header" placeholder="หัวข้อข่าว" class="border-2 border-black border-opacity-40 rounded-md w-full h-22 p-4"></textarea>
                                <p class="mt-2">ลิ้งภาพที่แสดง</p>
                                <textarea name="txt_news_img" placeholder="link:url" class="border-2 border-black border-opacity-40 rounded-md w-full h-48 p-4"></textarea>
                                <p class="mt-2">ลิ้งแหล่งที่มาข่าว</p>
                                <textarea name="txt_news_link" placeholder="link:url" class="border-2 border-black border-opacity-40 rounded-md w-full h-22 p-4"></textarea>
                                <div class="flex mt-4 gap-x-2 justify-center">
                                    <button name="btn_insertNews" class="btn btn-sm btn-success w-24">เพิ่มข่าว</button>
                                    <input type="reset" class="btn_cancelInsert btn btn-sm btn-error w-24" value="ยกเลิก">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="popupEdit hidden">
                    <div class="absolute bottom-0 flex justify-center items-center w-full md:w-9/12 h-screen z-50">
                        <div class="bg-white w-11/12 md:w-6/12 h-content p-6">
                            <p class="text-center font-medium text-xl">แก้ไขข่าว</p>
                            <form class="mt-4" action="#" name="form_editDataNews" method="POST">
                                <input class="hidden" type="text" name="txt_news_id_edit" value="">
                                <p class="mt-2">หัวข้อข่าว</p>
                                <textarea required name="txt_news_title_edit" placeholder="หัวข้อข่าว" class="border-2 border-black border-opacity-40 rounded-md w-full h-22 p-4"></textarea>
                                <p class="mt-2">ลิ้งภาพที่แสดง</p>
                                <textarea name="txt_news_img_edit" placeholder="link:url" class="border-2 border-black border-opacity-40 rounded-md w-full h-48 p-4"></textarea>
                                <p class="mt-2">ลิ้งแหล่งที่มาข่าว</p>
                                <textarea name="txt_news_link_edit" placeholder="link:url" class="border-2 border-black border-opacity-40 rounded-md w-full h-22 p-4"></textarea>
                                <button class="btn_submitEditAdmin hidden"></button>
                                <div class="flex flex-row justify-end gap-x-2 mt-5">
                                    <button name="btn_editNews" class="btn btn-sm btn-success">บันทึก</button>
                                    <div class="btn_cancelEdit btn btn-sm btn-error">ยกเลิก</div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="overlayEdit w-full h-screen fixed bg-black top-0 opacity-20 z-20"></div>
                </div>

            <div class="overlay hidden w-full h-screen fixed bg-black top-0 opacity-20 z-20"></div>
            <div class="space mb-40"></div>

        </div>

    </div>

    <script type="text/javascript" src="./../assets/js/_title_change.js" onload="switchTitle('ข่าวสารหอพัก')"></script>
    <script type="text/javascript" src="./../assets/js/_adm_select_menu.js" onload="select_menu(2)"></script>
    <script type="text/javascript" src="../assets/js/_adm_news_manage.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#table_news").DataTable();
        });

        setTimeout(() => {
            document.getElementById('table_news').classList.remove('hidden');
        }, 50);
    </script>

    <?php 

        function alertPopup($status, $txt) {
            switch ($status) {
                case 1:
                    echo "<script type='text/javascript'>
                        Swal.fire({
                            position: 'center-center',
                            icon: 'success',
                            html: '".$txt."',
                            showConfirmButton: false,
                            timer: 1000
                        })
                        
                        setTimeout(() => {
                            location.reload(true);
                            window.location.href='./news_manage.php'
                        }, 1000);

                    </script>";
                    break;
                case 0:
                    echo "<script type='text/javascript'>
                        Swal.fire({
                            position: 'center-center',
                            icon: 'error',
                            html: 'เกิดข้อผิดพลาด กรุณาติดต่อผู้ดูแลระบบ',
                            showConfirmButton: false,
                            timer: 1000
                        })
                    </script>";
                    break;
            }
        }

        echo "<script type='text/javascript'>
            setValueNews(".json_encode($arrayNews).");
        </script>";

        $newsClass = new News();

        if (isset($_POST['btn_insertNews'])) {
            if($newsClass->Insert($_POST['txt_news_header'], $_POST['txt_news_img'], $_POST['txt_news_link'])) {
                try {
                    unlink('./assets/img/news/importantNews.jpg');
                    unlink('./assets/img/news/importantNews.jpg');
                    unlink('./assets/img/news/importantNews.jpg');
                } catch (\Throwable $th) { }
                try {
                    copy($_POST['txt_news_img'], './../assets/img/news/importantNews.jpg');
                } catch (\Throwable $th) { }
                alertPopup(1, 'เพิ่มข้อมูลผู้ดูแลสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['submit_delete_news'])) {
            if ($newsClass->Delete($_POST['idNewsForDelete'])) {
                alertPopup(1, 'ลบข้อมูลสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['btn_editNews'])) {
            if ($newsClass->Update($_POST['txt_news_id_edit'], $_POST['txt_news_title_edit'], $_POST['txt_news_img_edit'], $_POST['txt_news_link_edit'])) {
                alertPopup(1, 'แก้ไขข้อมูลสำเร็จ');
            } else {
                alertPopup(0, '');
            }
        } else if (isset($_POST['btn_ImportantChangeImgNews'])) {
            copy($_POST['txt_link_img_important'], './../assets/img/news/importantNews.jpg');
            alertPopup(1, 'บังคับเปลี่ยนรูปภาพสำเร็จ');
        }

    ?>

</body>
</html>