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

    require_once ('../classes/Student.php');
    require_once ('../classes/Faculty.php');
    require_once ('../classes/Branch.php');
    require_once ('../classes/ExchangeValue.php');
    require_once ('../classes/Building.php');
    require_once ('../classes/Floor.php');
    require_once ('../classes/Room.php');
    $stdClass = new Student();
    $facClass = new Faculty();
    $branchClass = new Branch();
    $exchangeClass = new ExchangeValue();
    $buildingClass = new Building();
    $floorClass = new Floor();
    $roomClass = new Room();

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงาน/ส่งออกข้อมูล</title>
    <link rel="icon" href=" ../assets/img/logoKmutnb.webp">
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
</head>
<body>

    <div style="
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 80vh;
    ">
        <h3>กำลังดำเนินการส่งออกข้อมูลนักศึกษา</h3>
    </div>

    <?php
        
        $dataStd = $stdClass->Select_Sort('std_id, room_id, branch_id, std_status, std_id_student, std_sex, std_firstname, std_lastname, std_tel, std_address, created_at', 'created_at DESC', '', 0);
        $dataTable = array();
        $buildingNameForXlsx = array();
        $addressStdForXlsx = array();
        $valueBranch = NULL;
        $valueFac = NULL;
        $valueRoom = NULL;
        $i = 0;

        while ($valueStd = $dataStd->fetch(PDO::FETCH_ASSOC)) {
            if ($valueStd['branch_id'] != null) {
                $valueBranch = $branchClass->Find('fac_id, branch_name', 'branch_id', $valueStd['branch_id']);
                $valueBranch = $valueBranch->fetch(PDO::FETCH_ASSOC);
                $valueFac = $facClass->Find('fac_name', 'fac_id', $valueBranch['fac_id']);
                $valueFac = $valueFac->fetch(PDO::FETCH_ASSOC);
            }
            array_push($dataTable, array("", "", "", "", "", "", "", "", "", "", "", "", ""));

            $dataTable[$i][0] = $valueStd['std_id'];
            $dataTable[$i][1] = $valueStd['std_id_student'];
            $dataTable[$i][2] = $exchangeClass->sex_is($valueStd['std_sex']);
            $dataTable[$i][3] = $valueStd['std_firstname'];
            $dataTable[$i][4] = $valueStd['std_lastname'];
            $dataTable[$i][5] = $valueStd['std_tel'];
            $dataTable[$i][6] = (isset($valueFac['fac_name']) ? $valueFac['fac_name'] : '');
            $dataTable[$i][7] = ($valueStd['branch_id'] != null ? $exchangeClass->getBranchShort($valueBranch['branch_name']) : '-');
            $dataTable[$i][10] = explode(' ', explode('จ.', $valueStd['std_address'])[1])[0];
            $addressStdForXlsx[$i] = $valueStd['std_address'];
            $dataTable[$i][11] = explode(',', $exchangeClass->DateThai($valueStd['created_at']))[0];
            $dataTable[$i][8] = ($valueStd['std_status'] == '1' ? 'นศ.ใหม่' : 'นศ.หอพัก');
            $dataTable[$i][12] = $valueStd['room_id'];

            if ($valueStd['room_id'] != NULL) {
                $valueRoom = $roomClass->Find('room_name, floor_id', 'room_id', $valueStd['room_id']);
                $valueRoom = $valueRoom->fetch(PDO::FETCH_ASSOC);
                $dataTable[$i][9] = $valueRoom['room_name'];
                
                $valueFloor = $floorClass->Find('building_id', 'floor_id', $valueRoom['floor_id']);
                $valueFloor = $valueFloor->fetch(PDO::FETCH_ASSOC);

                $valueBuilding = $buildingClass->Find('building_name', 'building_id', $valueFloor['building_id']);
                $valueBuilding = $valueBuilding->fetch(PDO::FETCH_ASSOC);
                array_push($buildingNameForXlsx, $valueBuilding['building_name']);
            } else {
                array_push($buildingNameForXlsx, '');
            }
            $i++;
        }
        // echo "<script>console.log(". json_encode($dataTable) .");</script>";
    ?>

    <script type="text/javascript">
        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('tbl_exporttable_to_xls');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
                XLSX.writeFile(wb, fn || ('ข้อมูลนักศึกษาหอพัก_มจพ_ปราจีนบุรี.' + (type || 'xlsx')));
        }
        
        function ExportToExcel2(type, fn, dl) {
            var elt = document.getElementById('tbl_exporttable_to_xls_two');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
                XLSX.writeFile(wb, fn || ('ข้อมูลนักศึกษาตามห้องพัก_มจพ_ปราจีนบุรี.' + (type || 'xlsx')));
        }
        window.onload = () => {
            ExportToExcel('xlsx');
            ExportToExcel2('xlsx');
            setInterval(() => {
                window.location.href = './member_manage.php';
            }, 4000);
        }
    </script>

    <table id="tbl_exporttable_to_xls" style="display: none">
        <thead>
            <tr class="h-12">
                <th>เข้าร่วมเมื่อ</th>
                <th>ลำดับ</th> 
                <th>รหัสนักศึกษา</th> 
                <th>คำนำ</th> 
                <th>ชื่อจริง</th> 
                <th>นามสกุล</th> 
                <th>เบอร์โทรศัพท์</th> 
                <th>คณะ</th> 
                <th>สาขา</th>
                <th>สถานะ นศ.</th>
                <th>อยู่ห้องพัก</th>
                <th>หอพัก</th>
                <th>จากจังหวัด</th>
                <th>ที่อยู่นักศึกษา</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                for ($i = 0; $i < count($dataTable); $i++):
            ?>
                <tr>
                    <td><?php echo $dataTable[$i][11] ?></td>
                    <td><?php echo ($i+1); ?></td>
                    <td><?php echo $dataTable[$i][1] ?></td>
                    <td><?php echo $dataTable[$i][2] ?></td>
                    <td><?php echo $dataTable[$i][3] ?></td>
                    <td><?php echo $dataTable[$i][4] ?></td>
                    <td><?php echo $dataTable[$i][5] ?></td>
                    <td><?php echo $dataTable[$i][6] ?></td>
                    <td><?php echo $dataTable[$i][7] ?></td>
                    <td><?php echo $dataTable[$i][8] ?></td>
                    <td><?php echo $dataTable[$i][9] ?></td>
                    <td><?php echo $buildingNameForXlsx[$i] ?></td>
                    <td><?php echo $dataTable[$i][10] ?></td>
                    <td><?php echo $addressStdForXlsx[$i] ?></td>
                </tr>
            <?php 
                endfor;
            ?>
        </tbody>
    </table>

    <table id="tbl_exporttable_to_xls_two" style="display: none">
        <thead>
            <tr class="h-12">
                <th>หอพัก</th>
                <th>ชั้น</th>
                <th>ชื่อห้อง</th>
                <th>สถานะ นศ.</th>
                <th>รหัสนักศึกษา</th>
                <th>คำนำ</th>
                <th>ชื่อจริง</th>
                <th>นามสกุล</th>
                <th>เบอร์โทรศัพท์</th>
                <th>สาขา</th>
                <th>คณะ</th> 
            </tr>
        </thead>
        <tbody>
            <tr></tr>
        <?php 
            $dataBuilding = $buildingClass->Select_Sort('building_id, building_name', 'building_name', 'ASC', 0);
            while ($valueBuilding = $dataBuilding->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>".$valueBuilding['building_name']."</td>
                </tr>";
                $dataFloor = $floorClass->Find_Sort('floor_id, floor_name', 'building_id', $valueBuilding['building_id'], 'floor_name', 'ASC');
                while ($valueFloor = $dataFloor->fetch(PDO::FETCH_ASSOC)) {
                    echo "
                        <tr></tr>
                        <tr>
                            <td></td>
                            <td>".$valueFloor['floor_name']."</td>
                        </tr>
                    ";
                    $roomCount = 0;
                    $dataRoom = $roomClass->Find_Sort('room_id, room_name', 'floor_id', $valueFloor['floor_id'], 'room_name', 'ASC');
                    while ($valueRoom = $dataRoom->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                            <td></td>
                            <td></td>
                            <td>".$valueRoom['room_name']."</td>
                        </tr>";
                        $roomCount++;
                        $memberCount = 0;
                        for ($i = 0; $i < count($dataTable); $i++) {
                            if ($dataTable[$i][12] == $valueRoom['room_id']) {
                                echo "<tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>".$dataTable[$i][8]."</td>
                                    <td>".$dataTable[$i][1]."</td>
                                    <td>".$dataTable[$i][2]."</td>
                                    <td>".$dataTable[$i][3]."</td>
                                    <td>".$dataTable[$i][4]."</td>
                                    <td>".$dataTable[$i][5]."</td>
                                    <td>".$dataTable[$i][7]."</td>
                                    <td>คณะ".$dataTable[$i][6]."</td>
                                 </tr>";
                                $memberCount++;
                            }
                        }
                        if ($memberCount < 1) {
                            echo "<tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>ไม่พบ นศ.</td>
                            </tr>";
                        }
                    }
                    if ($roomCount < 1) {
                        echo "<tr>
                            <td></td>
                            <td></td>
                            <td>ไม่พบห้อง</td>
                        </tr>";
                    }
                }
                echo "<tr></tr>";
                echo "<tr></tr>";
            }
        ?>
            
        </tbody>
    </table>


</body>
</html>