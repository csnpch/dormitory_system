<?php

    require_once ("Database.php");

    class Building extends Database {

        private $table = "tb_buildings";

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

        public function Insert($building_name, $building_status) {
            $sql = "INSERT INTO $this->table (building_name, building_gender) VALUES (?, ?)";

            $insert = $this->db->prepare($sql);
            $insert->bindParam(1, $building_name, PDO::PARAM_STR);
            $insert->bindParam(2, $building_status, PDO::PARAM_STR);
            $insert->execute();

            return $insert;
        }

        public function Update($building_id, $building_name, $building_status) {
            $sql = "UPDATE $this->table 
                    SET building_name = ?,
                        building_gender = ?,
                        updated_at = NOW()
                    WHERE building_id = ?";

            $update = $this->db->prepare($sql);
            $update->bindParam(1, $building_name, PDO::PARAM_STR);
            $update->bindParam(2, $building_status, PDO::PARAM_STR);
            $update->bindParam(3, $building_id, PDO::PARAM_STR);
            $update->execute();

            return $update;
        }

        public function Delete($building_id) {
            $sql = "DELETE FROM $this->table WHERE building_id = ?";
            $delete = $this->db->prepare($sql);
            $delete->bindParam(1, $building_id, PDO::PARAM_INT);
            $delete->execute();

            return $delete;
        }

        // Custom function
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

    }

?>
 