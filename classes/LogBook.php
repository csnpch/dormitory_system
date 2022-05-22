<?php

    require_once ("Database.php");

    class LogBook extends Database {

        private $table = "tb_log_stdbook";

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

        public function Find_Sort($select, $where, $keyword, $std_fullname, $options) {   //  DESC, ASC
            $sql = "SELECT $select FROM $this->table WHERE $where = $keyword ORDER BY $order_by $options";
            $select = $this->db->prepare($sql);        
            $select->execute();

            return $select;
        }

        public function Insert($std_citizen_number, $std_fullname, $roomBook) {
            $sql = "INSERT INTO $this->table (std_citizen_number, std_fullname, roomBook) VALUES (?, ?, ?)";

            $insert = $this->db->prepare($sql);
            $insert->bindParam(1, $std_citizen_number, PDO::PARAM_STR);
            $insert->bindParam(2, $std_fullname, PDO::PARAM_STR);
            $insert->bindParam(3, $roomBook, PDO::PARAM_STR);
            $insert->execute();

            return $insert;
        }

        public function Update($log_id, $std_citizen_number, $std_fullname, $roomBook) {
            $sql = "UPDATE $this->table 
                SET std_citizen_number = ?,
                    std_fullname = ?,
                    roomBook = ?,
                    updated_at = NOW()
                    WHERE `log_id` = ?";

            $update = $this->db->prepare($sql);
            $update->bindParam(1, $std_citizen_number, PDO::PARAM_STR);
            $update->bindParam(2, $std_fullname, PDO::PARAM_STR);
            $update->bindParam(3, $roomBook, PDO::PARAM_STR);
            $update->bindParam(4, $log_id, PDO::PARAM_STR);
            $update->execute();

            return $update;
        }

        public function Delete($log_id) {
            $sql = "DELETE FROM $this->table WHERE log_id = ?";
            $delete = $this->db->prepare($sql);
            $delete->bindParam(1, $log_id, PDO::PARAM_INT);
            $delete->execute();

            return $delete;
        }

        // Custom function
        
        public function findDataToLogBook($room_id) {
            $sql = "SELECT tb_rooms.room_name, tb_floors.floor_name, tb_buildings.building_name FROM `tb_rooms` 
                    LEFT JOIN tb_floors
                    ON tb_floors.floor_id = tb_rooms.floor_id
                    LEFT JOIN tb_buildings
                    ON tb_floors.building_id = tb_buildings.building_id
                    WHERE room_id = ?";
            $find = $this->db->prepare($sql);
            $find->bindParam(1, $room_id, PDO::PARAM_INT);
            $find->execute();

            return $find;
        }


        public function autoDestroyLogBooks($year) {
            $sql = "DELETE FROM $this->table
                    WHERE YEAR(created_at) < EXTRACT(YEAR FROM CURRENT_DATE) - $year";
            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

    }

?>
 