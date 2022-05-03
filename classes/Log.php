<?php

    require_once ("Database.php");

    class Log extends Database {

        private $table = "tb_logs";

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

        public function Insert($log_detail) {
            $sql = "INSERT INTO $this->table (log_detail) 
                    VALUE (?)";

            $insert = $this->db->prepare($sql);
            $insert->bindParam(1, $log_detail, PDO::PARAM_STR);
            $insert->execute();

            return $insert;
        }

        public function Delete($id) {
            $sql = "DELETE FROM $this->table WHERE log_id = ?";
            $delete = $this->db->prepare($sql);
            $delete->bindParam(1, $id, PDO::PARAM_INT);
            $delete->execute();

            return $delete;
        }

        // Custom function
        public function autoDestroyLogs($year) {
            $sql = "DELETE FROM $this->table
                    WHERE YEAR(created_at) < EXTRACT(YEAR FROM CURRENT_DATE) - $year";
            
            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }



    }

?>
 