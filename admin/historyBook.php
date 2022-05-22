<?php 
    session_start();
    require_once ('./../disable_error_report.php');
    require_once ('./../classes/Admin.php');
    require_once ('./../classes/ExchangeValue.php');
    $adminClass = new Admin();
    $exchangeValueClass = new ExchangeValue();

    if (!isset($_SESSION['adm_id'])) {
        header('Location: ../admin/login.php');
    } else if (isset($_SESSION['adm_id'])) {
        $statusAdmin = $adminClass->Find('adm_status', 'adm_id', $_SESSION['adm_id']);
        $statusAdmin = $statusAdmin->fetch(PDO::FETCH_ASSOC);
        if (intval($statusAdmin['adm_status']) === 2) {
            header('Location: ../admin/book_manage.php');
        }
    }

    require_once './../classes/LogBook.php';
    $logBookClass = new LogBook();

?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กางจองห้องพัก</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <link rel="stylesheet" href="../assets/css/style_x_tailwind.css">
    <link rel="icon" href=" ../assets/img/logoKmutnb.webp">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../assets/node_modules/daisyui/dist/full.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css" />
    <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
</head>
<body class="font_prompt">
    
    <div class="flex">
        <!-- Sidebar -->
        <?php include ('./adm_file_link/sidebar.php'); ?>
        <!-- Navbar -->
        <div id="main" class="overflow-x-hidden flex flex-col w-full lg:w-11/12 ml-0 lg:ml-64 trasition-all duration-300 bg-gray-200 h-screen">
            <?php include ('./adm_file_link/navbar.php'); ?>

            <section  class="flex flex-col gap-y-2 mt-6 pl-2 pr-2 md:pl-10 sm:pl-8 md:pr-10 sm:pr-8">

                <div class="text-left breadcrumbs mb-2 rounded-md tracking-wide w-full bg-gray-100" style="font-size: 0.8rem;">
                    <ul class="ml-4 mt-0.5 p-0.5">
                        <li>
                            <i class="fas fa-bed mr-2"></i>
                            <a href="./book_manage.php">
                                การจองห้องพัก
                            </a>
                        </li> 
                        <li>
                            <i class="fas fa-history mr-2"></i>
                            <a href="./historyBook.php">
                                ประวัติการจองห้องพัก
                            </a>
                        </li> 
                    </ul>
                </div>

            </section>

            <section class="flex flex-col gap-y-2 mt-6 pl-2 pr-2 md:pl-10 sm:pl-8 md:pr-10 sm:pr-8">
                <div 
                    class="text-left breadcrumbs mb-2 rounded-md tracking-wide w-full bg-gray-100" 
                    style="font-size: 0.8rem; padding: 40px 40px;"
                >
                    
                    <table id="myTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <td>ประทับเวลาการจอง</td>
                                <td>บัตรประชาชน</td>
                                <td>ชื่อนักศึกษา</td>
                                <td>ห้องที่นักศึกษาจอง</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $dataLogs = $logBookClass->Select_All("*");
                                while ($val = $dataLogs->fetch(PDO::FETCH_ASSOC)): 
                            ?>
                            <tr>
                                <td><?php echo $exchangeValueClass->DateThai($val['created_at']) ?></td>
                                <td><?php echo $val['std_citizen_number'] ?></td>
                                <td><?php echo $val['std_fullname'] ?></td>
                                <td><?php echo $val['roomBook'] ?></td>
                            </tr>
                            <?php 
                                endwhile;
                            ?>
                        </tbody>
                    </table>

                    <button
                        id="exportData"
                        style="
                            margin-top: 24px;
                            width: 100%;
                            padding: 8px 0;
                            background: green;
                            color: white;
                            border-radius: 5px;
                        "
                    >
                        Export to excel
                    </button>
                </div>


            </section>

            <div class="space mb-40"></div>

        </div>

    </div>
    
    <script type="text/javascript" src="./../assets/js/_title_change.js" onload="switchTitle('กางจองห้องพัก')"></script>
    <script type="text/javascript" src="./../assets/js/_adm_select_menu.js" onload="select_menu(6)"></script>
    <script type="text/javascript" src="./../assets/js/_adm_book_manage.js"></script>

    <script type="text/javascript">

        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('myTable');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
                XLSX.writeFile(wb, fn || ('ข้อมูลประวัติการจองหอพักของนักศึกษา_มจพ_ปราจีนบุรี.' + (type || 'xlsx')));
        }

        document.querySelector('#exportData').addEventListener('click', () => {
            ExportToExcel();
        });
        
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );

    </script>

</body>
</html>