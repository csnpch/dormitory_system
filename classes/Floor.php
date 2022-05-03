<?php

    require_once ("Database.php");

    class Floor extends Database {

        private $table = "tb_floors";

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

        public function Find_Sort($select, $where, $keyword, $order_by, $options) {   //  DESC, ASC
            $sql = "SELECT $select FROM $this->table WHERE $where = $keyword ORDER BY $order_by $options";
            $select = $this->db->prepare($sql);        
            $select->execute();

            return $select;
        }

        public function Insert($buildings_id, $floor_name) {
            $sql = "INSERT INTO $this->table (building_id, floor_name) VALUES (?, ?)";

            $insert = $this->db->prepare($sql);
            $insert->bindParam(1, $buildings_id, PDO::PARAM_STR);
            $insert->bindParam(2, $floor_name, PDO::PARAM_STR);
            $insert->execute();

            return $insert;
        }

        public function Update($floor_id, $building_id, $floor_name) {
            $sql = "UPDATE $this->table 
                SET building_id = ?,
                    floor_name = ?,
                    updated_at = NOW()
                    WHERE `floor_id` = ?";

            $update = $this->db->prepare($sql);
            $update->bindParam(1, $building_id, PDO::PARAM_STR);
            $update->bindParam(2, $floor_name, PDO::PARAM_STR);
            $update->bindParam(3, $floor_id, PDO::PARAM_STR);
            $update->execute();

            return $update;
        }

        public function Delete($floor_id) {
            $sql = "DELETE FROM $this->table WHERE floor_id = ?";
            $delete = $this->db->prepare($sql);
            $delete->bindParam(1, $floor_id, PDO::PARAM_INT);
            $delete->execute();

            return $delete;
        }

        // Custom function
        public function Count_where($select, $as, $where, $keyword) {
            $sql = "SELECT COUNT($select) as '$as' FROM $this->table WHERE $where = $keyword";
            $select = $this->db->prepare($sql);        
            $select->execute();

            return $select;
        }


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
 