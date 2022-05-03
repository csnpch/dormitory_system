<?php

    class ExchangeValue extends Database {

        public function sex_is($value) {
            switch($value) {
                case 0:     return 'นาย';
                case 1:     return 'นางสาว';
                case 2:     return 'นาง';
            }
        }


        public function blood_type_is($value) {
            switch($value) {
                case 0:     return "A";
                case 1:     return "B";
                case 2:     return "O";
                case 3:     return "AB";
                default:    return "";
            }
        }


        public function religion_is($value) {
            switch($value) {
                case 0:     return "พุทธ";
                case 1:     return "คริสต์";
                case 2:     return "อิสราม";
                case 3:     return "ฮินดู";
                case 4:     return "ซิกข์";
                case 5:     return "ไม่นับถือ";
                default:    return "";
            }
        }


        public function degree_is($value) {
            switch($value) {
                case 0:     return "ม.ต้น";
                case 1:     return "ม.ปลาย";
                case 2:     return "ปวช.";
                case 3:     return "ปวส.";
                default:    return "";
            }
        }


        public function person_is($value) {
            switch($value) {
                case 0:     return "บิดา";
                case 1:     return "มารดา";
                case 2:     return "ปู่";
                case 3:     return "ย่า";
                case 4:     return "ตา";
                case 5:     return "ยาย";
                case 6:     return "ลุง";
                case 7:     return "ป้า";
                case 8:     return "พี่";
                case 9:     return "อื่น ๆ";
                case 10:    return "บิดา/มารดา";
                case 11:    return "ปู่/ย่า";
                case 12:    return "ตา/ยาย";
                case 13:    return "ลุง/ป้า";
                default:    return "";
            }
        }


        public function status_fix_is($value) {
            switch($value) {
                case 0:     return "ดำเนินการซ่อมแล้ว";
                case 1:     return "เจ้าหน้าที่รับเรื่องแล้ว";
                case 2:     return "รอเจ้าหน้าที่รับเรื่อง";
                default:    return "-";
            }
        }


        public function getBranchShort($branchNameFull) {
            return str_replace(array('(',')'), "", explode(" ", $branchNameFull)[1]);
        }

        public function gender_dorm_is($value) {
            switch ($value) {
                case 2: return "หอพักทั่วไป";
                case 0: return "หอพักชาย";
                case 1: return "หอพักหญิง";
            }
        }


        function DateThai($strDate) {
            $strYear = date("Y",strtotime($strDate))+543;
            $strMonth= date("n",strtotime($strDate));
            $strDay= date("j",strtotime($strDate));
            $strHour= date("H",strtotime($strDate));
            $strMinute= date("i",strtotime($strDate));
            $strSeconds= date("s",strtotime($strDate));
            $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
            $strMonthThai=$strMonthCut[$strMonth];
            return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
        }

    }

?>
 