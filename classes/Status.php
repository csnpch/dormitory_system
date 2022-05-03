<?php

    require_once ("Database.php");

    class Status extends Database {

        private $table = "tb_status";

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

        public function Insert($status_name) {
            $sql = "INSERT INTO $this->table (status_name) VALUE $status_name";
            $insert = $this->db->prepare($sql);
            $insert->execute();

            return $insert;
        }

        public function Update($status_id, $status_name, $status_switch) {
            $sql = "UPDATE $this->table 
                SET status_name = ?,
                    status_switch = ?,
                    update_at = NOW()
                    WHERE status_id = ?";

            $update = $this->db->prepare($sql);
            $update->bindParam(1, $status_name, PDO::PARAM_STR);
            $update->bindParam(2, $status_switch, PDO::PARAM_STR);
            $update->bindParam(3, $status_id, PDO::PARAM_STR);
            $update->execute();

            return $update;
        }

        public function Update_Switch($status_id, $status_switch) {
            $sql = "UPDATE $this->table 
                SET status_switch = ?,
                    update_at = NOW()
                    WHERE status_id = ?";

            $update = $this->db->prepare($sql);
            $update->bindParam(1, $status_switch, PDO::PARAM_STR);
            $update->bindParam(2, $status_id, PDO::PARAM_STR);
            $update->execute();

            return $update;
        }

        public function Update_date_range($status_id, $status_date_start, $status_date_stop) {
            $sql = "UPDATE $this->table 
                    SET status_date_start = ?,
                    status_date_stop = ?,
                    update_at = NOW()
                    WHERE status_id = ?";

            $update = $this->db->prepare($sql);
            $update->bindParam(1, $status_date_start, PDO::PARAM_STR);
            $update->bindParam(2, $status_date_stop, PDO::PARAM_STR);
            $update->bindParam(3, $status_id, PDO::PARAM_STR);
            $update->execute();

            return $update;
        }

        public function Delete($status_id) {
            $sql = "DELETE FROM $this->table WHERE book_id = ?";
            $delete = $this->db->prepare($sql);
            $delete->bindParam(1, $status_id, PDO::PARAM_INT);
            $delete->execute();

            return $delete;
        }

    }

?>
