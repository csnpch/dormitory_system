<?php 

    require_once ("Database.php");

    class Student extends Database {

        private $table = "tb_students";
        
        public function Select_All($select) {
            $sql = "SELECT $select FROM $this->table";
            $select = $this->db->prepare($sql);        
            $select->execute();

            return $select;
        }


        public function Find($select, $where, $keyword) {
            $sql = "SELECT $select FROM $this->table WHERE $where = ?";
            $find = $this->db->prepare($sql);
            $find->bindParam(1, $keyword, PDO::PARAM_STR);
            $find->execute();

            return $find;
        }


        public function Insert(
                                $std_status, $std_username, $std_password, $std_salt,
                                $std_sex, $std_firstname, $std_lastname, $std_idcard,
                                $std_nickname, $std_blood, $std_religion, $std_birthday,
                                $std_id_student, $branch_id,

                                $std_tel, $std_email, $std_address,

                                $std_edu_academy, $std_edu_degree, $std_edu_comple,

                                $std_sponsor, $std_howmuch
                                ) 
        {
            $sql = "INSERT INTO $this->table (
                std_status, std_username, std_password, std_salt,
                std_sex, std_firstname, std_lastname, std_idcard,
                std_nickname, std_blood, std_religion, std_birthday,
                std_id_student, branch_id,

                std_tel, std_email, std_address,

                std_edu_academy, std_edu_degree, std_edu_comple,

                std_sponsor, std_howmuch
            ) VALUES (
                :std_status, :std_username, :std_password, :std_salt,
                :std_sex, :std_firstname, :std_lastname, :std_idcard,
                :std_nickname, :std_blood, :std_religion, :std_birthday,
                :std_id_student, :branch_id,

                :std_tel, :std_email, :std_address,

                :std_edu_academy, :std_edu_degree, :std_edu_comple,

                :std_sponsor, :std_howmuch
            )";

            $insert = $this->db->prepare($sql);
            $insert->bindParam(':branch_id', $branch_id, PDO::PARAM_INT);
            $insert->bindParam(':std_status', $std_status, PDO::PARAM_INT);
            $insert->bindParam(':std_username', $std_username, PDO::PARAM_STR);
            $insert->bindParam(':std_password', $std_password, PDO::PARAM_STR);
            $insert->bindParam(':std_salt', $std_salt, PDO::PARAM_STR);
            $insert->bindParam(':std_sex', $std_sex, PDO::PARAM_STR);
            $insert->bindParam(':std_firstname', $std_firstname, PDO::PARAM_STR);
            $insert->bindParam(':std_lastname', $std_lastname, PDO::PARAM_STR);
            $insert->bindParam(':std_idcard', $std_idcard, PDO::PARAM_STR);
            $insert->bindParam(':std_nickname', $std_nickname, PDO::PARAM_STR);
            $insert->bindParam(':std_blood', $std_blood, PDO::PARAM_STR);
            $insert->bindParam(':std_religion', $std_religion, PDO::PARAM_STR);
            $insert->bindParam(':std_birthday', $std_birthday, PDO::PARAM_STR);
            $insert->bindParam(':std_id_student', $std_id_student, PDO::PARAM_STR);
            $insert->bindParam(':std_tel', $std_tel, PDO::PARAM_STR);
            $insert->bindParam(':std_email', $std_email, PDO::PARAM_STR);
            $insert->bindParam(':std_address', $std_address, PDO::PARAM_STR);
            $insert->bindParam(':std_edu_academy', $std_edu_academy, PDO::PARAM_STR);
            $insert->bindParam(':std_edu_degree', $std_edu_degree, PDO::PARAM_STR);
            $insert->bindParam(':std_edu_comple', $std_edu_comple, PDO::PARAM_STR);
            $insert->bindParam(':std_sponsor', $std_sponsor, PDO::PARAM_STR);
            $insert->bindParam(':std_howmuch', $std_howmuch, PDO::PARAM_STR);
            $insert->execute();
            
            return $insert;
        }


        public function Update($std_id, $std_status, $username, $password, 
                                $sex, $firstname, $lastname, $idCard, 
                                $nickname, $blood, $religion, $birthday,
                                $idStd, $faculty, $branch,
                                
                                $tel, $email, $address,
                                
                                $EduAcademy, $EduDegree, $EduComple,

                                $sponsor, $howmuch)
        {

            $sql = "UPDATE $this->table 
                    SET std_status_std = :statusStd,
                        std_username = :user,
                        std_password = :pass,
                        std_sex = :sex,
                        std_firstname = :fname,
                        std_lastname = :lname,
                        std_idCard = :idCard,
                        std_nickname = :nickname,
                        std_blood = :blood,
                        std_religion = :religion,
                        std_birthday = :birthday,
                        std_idStd = :idStd,
                        std_faculty = :faculty,
                        std_branch = :branch,
                        std_tel = :tel,
                        std_email = :email,
                        std_address = :addresss,
                        std_edu_academy = :eduAcademy,
                        std_edu_degree = :eduDegree,
                        std_edu_comple = :eduComple;
                        std_sponsor = :sponsor,
                        std_howmuch = :howmuch,
                        std_updated_at = NOW()
                    WHERE std_id = :id ";

            $update = $this->db->prepare($sql);
            $update->bindParam(':id', $std_id, PDO::PARAM_STR);
            $update->bindParam(':statusStd', $std_status, PDO::PARAM_INT);
            $update->bindParam(':user', $username, PDO::PARAM_STR);
            $update->bindParam(':pass', $password, PDO::PARAM_STR);
            $update->bindParam(':sex', $sex, PDO::PARAM_STR);
            $update->bindParam(':fname', $firstname, PDO::PARAM_STR);
            $update->bindParam(':lname', $lastname, PDO::PARAM_STR);
            $update->bindParam(':idCard', $idCard, PDO::PARAM_STR);
            $update->bindParam(':nickname', $nickname, PDO::PARAM_STR);
            $update->bindParam(':blood', $blood, PDO::PARAM_STR);
            $update->bindParam(':religion', $religion, PDO::PARAM_STR);
            $update->bindParam(':birthday', $birthday, PDO::PARAM_STR);
            $update->bindParam(':idstd', $idStd, PDO::PARAM_STR);
            $update->bindParam(':faculty', $faculty, PDO::PARAM_STR);
            $update->bindParam(':branch', $branch, PDO::PARAM_STR);
            $update->bindParam(':tel', $tel, PDO::PARAM_STR);
            $update->bindParam(':email', $email, PDO::PARAM_STR);
            $update->bindParam(':addresss', $address, PDO::PARAM_STR);
            $update->bindParam(':eduAcademy', $EduAcademy, PDO::PARAM_STR);
            $update->bindParam(':eduDegree', $EduDegree, PDO::PARAM_STR);
            $update->bindParam(':eduComple', $EduComple, PDO::PARAM_STR);
            $update->bindParam(':sponsor', $sponsor, PDO::PARAM_STR);
            $update->bindParam(':howmuch', $howmuch, PDO::PARAM_STR);
            $update->execute();

            return $update;
        }


        public function Delete($id) {
            $sql = "DELETE FROM $this->table WHERE std_id = ?";
            $delete = $this->db->prepare($sql);
            $delete->bindParam(1, $id, PDO::PARAM_INT);
            $delete->execute();

            return $delete;
        }

        
        // -- Custom function --
        public function Select_Sort($select, $order_by, $limit, $option) {   //  DESC, ASC
            if ($option == 0) { // 0 is default
                $sql = "SELECT $select FROM $this->table ORDER BY $order_by";
            } else if ($option == 1) {
                $sql = "SELECT $select FROM $this->table ORDER BY $order_by LIMIT $limit";
            }
            $select = $this->db->prepare($sql);        
            $select->execute();

            return $select;
        }

        public function Update_Select($sets, $dataNews, $where, $keyword) {
            $txtSet = "";
            for ($i = 0; $i < count($sets); $i++) {
                if ($i < count($sets) - 1) {
                    $txtSet = $txtSet.$sets[$i]." = '".$dataNews[$i]."', ";
                } else {
                    $txtSet = $txtSet.$sets[$i]." = '".$dataNews[$i]."'";
                }
            }

            $txtSet = $txtSet.', updated_at = NOW()';
            $sql = "UPDATE $this->table SET $txtSet WHERE $where = $keyword";
            $update = $this->db->prepare($sql);
            $update->execute();

            return $update;
        }

        public function Count($select, $as) {
            $sql = "SELECT COUNT($select) as '$as' FROM $this->table";
            $select = $this->db->prepare($sql);        
            $select->execute();

            return $select;
        }

        public function Count_where($select, $as, $where_full) {
            $sql = "SELECT COUNT($select) as '$as' FROM $this->table WHERE $where_full";
            $select = $this->db->prepare($sql);        
            $select->execute();

            return $select;
        }

        public function Count_memberRoom($room_id) {
            $sql = "SELECT COUNT(room_id) as 'RESULT' FROM $this->table WHERE room_id = $room_id";
            $count = $this->db->prepare($sql);
            $count->execute();

            return $count;
        }

        public function room_book($std_id, $room_id) {
            $sql = "UPDATE $this->table 
                    SET room_id = $room_id,
                    updated_at = NOW()
                    WHERE std_id = $std_id";
            
            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

        public function book_destory($std_id) {
            $sql = "UPDATE $this->table 
                    SET room_id = NULL
                    WHERE std_id = $std_id";
            
            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

        public function getYearStdIdForDestroyStd() {
            $sql = "SELECT DISTINCT SUBSTRING($this->table.std_id_student, 1, 2) AS stdYearId
                    FROM $this->table 
                    ORDER BY stdYearId DESC";

            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

        public function getYearStdIdForDestroyBook() {
            $sql = "SELECT DISTINCT SUBSTRING($this->table.std_id_student, 1, 2) AS stdYearId
                    FROM $this->table 
                    WHERE room_id IS NOT NULL
                    ORDER BY stdYearId DESC";

            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

        public function destroyStdByYear($choice, $year) {
            switch (intval($choice)) {
                case 0:
                    $sql = "DELETE FROM $this->table 
                            WHERE SUBSTRING($this->table.std_id_student, 1, 2) = $year";
                    break;
                case 1:
                    $sql = "DELETE FROM $this->table 
                            WHERE SUBSTRING($this->table.std_id_student, 1, 2) = $year 
                            AND room_id IS NULL";
                    break;
            }

            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

        public function destroyStdAll($choice) {
            switch (intval($choice)) {
                case 0:
                    $sql = "DELETE FROM $this->table";
                    break;
                case 1:
                    $sql = "DELETE FROM $this->table 
                            WHERE room_id IS NULL";
                    break;
            }

            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

        public function destroyRoomFormStdYear($yearStd) {
            $sql = "UPDATE $this->table 
                    SET room_id = NULL
                    WHERE SUBSTRING($this->table.std_id_student, 1, 2) = $yearStd";

            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

        public function destroyRoomFormStdAll() {
            $sql = "UPDATE $this->table
                    SET room_id = NULL";

            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }


        public function autoDestroyStdAll($year) {
            $sql = "DELETE FROM $this->table
                    WHERE YEAR(updated_at) <= EXTRACT(YEAR FROM CURRENT_DATE) - $year";
            
            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }


        public function autoDestroyStdIsNotRoomId($year) {
            $sql = "DELETE FROM $this->table
                    WHERE YEAR(updated_at) <= EXTRACT(YEAR FROM CURRENT_DATE) - $year
                    AND room_id IS NOT NULL";

            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

        public function autoDestroyRoom($year) {
            $sql = "UPDATE $this->table
                    SET room_id = NULL
                    WHERE YEAR(updated_at) <= EXTRACT(YEAR FROM CURRENT_DATE) - $year";
            
            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

        public function destroyRoomByRoomId($room_id) {
            $sql = "UPDATE $this->table
                    SET room_id = NULL
                    WHERE $this->table.room_id = $room_id";

            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

        public function autoChangeStatusStd($year) {
            $sql = "UPDATE $this->table
                    SET std_status = 0
                    WHERE YEAR(created_at) <= EXTRACT(YEAR FROM CURRENT_DATE) - $year";
            
            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

        // Dashboard member
        public function getDataToReportMember($how) {
            switch (intval($how)) {
                case 1:
                    $sql = "SELECT SUM(tb_rooms.room_member) as result FROM `tb_rooms` 
                            LEFT JOIN tb_floors ON tb_rooms.floor_id = tb_floors.floor_id
                            LEFT JOIN tb_buildings ON tb_floors.building_id = tb_buildings.building_id
                            WHERE tb_buildings.building_gender = 0 OR tb_buildings.building_gender = 2";
                    break;
                case 2:
                    $sql = "SELECT SUM(tb_rooms.room_member) as result FROM `tb_rooms` 
                            LEFT JOIN tb_floors ON tb_rooms.floor_id = tb_floors.floor_id
                            LEFT JOIN tb_buildings ON tb_floors.building_id = tb_buildings.building_id
                            WHERE tb_buildings.building_gender = 1 OR tb_buildings.building_gender = 2";
                    break;
                case 3:
                    $sql = "SELECT COUNT(tb_students.room_id) as result 
                            FROM tb_students WHERE tb_students.room_id IS NOT NULL 
                            AND tb_students.std_sex = 0 OR tb_students.std_sex = 2";
                    break;
                case 4:
                    $sql = "SELECT COUNT(tb_students.room_id) as result
                            FROM tb_students WHERE tb_students.room_id IS NOT NULL 
                            AND tb_students.std_sex = 1 OR tb_students.std_sex = 2";
                    break;
            }

            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }


        // Find students by roomId
        public function getStudentsByRoomId($roomId) {
            $sql = "SELECT * FROM $this->table 
                    WHERE room_id = $roomId";

            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

    }
?>
