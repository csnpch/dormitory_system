<?php

    require_once ("Database.php");

    class Room extends Database {

        private $table = "tb_rooms";

        public function Select_All($select) {
            $sql = "SELECT $select FROM $this->table";
            $select = $this->db->prepare($sql);
            $select->execute();

            return $select;
        }

        public function Select_Order($select, $by, $how) {
            $sql = "SELECT $select FROM $this->table ORDER BY $by $how";
            $selectOrder = $this->db->prepare($sql);
            $selectOrder->execute();

            return $selectOrder;
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

        public function Insert($floor_id, $room_name, $room_member) {
            $sql = "INSERT INTO $this->table (floor_id, room_name, room_member) VALUES (?, ?, ?)";

            $insert = $this->db->prepare($sql);
            $insert->bindParam(1, $floor_id, PDO::PARAM_STR);
            $insert->bindParam(2, $room_name, PDO::PARAM_STR);
            $insert->bindParam(3, $room_member, PDO::PARAM_STR);
            $insert->execute();

            return $insert;
        }


        public function Update($room_id, $floor_id, $room_name, $room_member, $room_status) {
            $sql = "UPDATE $this->table 
                SET floor_id = ?,
                    room_name = ?,
                    room_member = ?,
                    room_status = ?,
                    updated_at = NOW()
                    WHERE room_id = ?";

            $update = $this->db->prepare($sql);
            $update->bindParam(1, $floor_id, PDO::PARAM_STR);
            $update->bindParam(2, $room_name, PDO::PARAM_STR);
            $update->bindParam(3, $room_member, PDO::PARAM_STR);
            $update->bindParam(4, $room_status, PDO::PARAM_STR);
            $update->bindParam(5, $room_id, PDO::PARAM_STR);
            $update->execute();

            return $update;
        }

        public function Delete($room_id) {
            $sql = "DELETE FROM $this->table WHERE room_id = ?";
            $delete = $this->db->prepare($sql);
            $delete->bindParam(1, $room_id, PDO::PARAM_INT);
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

        public function bookRelation() {
            $sql = "SELECT tb_branchs.branch_name, tb_students.room_id, tb_students.std_firstname, tb_students.std_lastname, tb_students.std_id
                    FROM $this->table 
                    LEFT JOIN tb_students ON $this->table.room_id = tb_students.room_id 
                    LEFT JOIN tb_branchs ON tb_students.branch_id = tb_branchs.branch_id
                    WHERE tb_students.room_id IS NOT NULL ORDER BY $this->table.created_at ASC";
            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

        public function getBranchOfRoom($room_id) {
            $sql = "SELECT tb_buildings.building_name FROM $this->table AS building_name
                    LEFT JOIN tb_floors ON $this->table.floor_id = tb_floors.floor_id
                    LEFT JOIN tb_buildings ON tb_floors.building_id = tb_buildings.building_id
                    WHERE $this->table.room_id = $room_id";
            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

    }

?>
 