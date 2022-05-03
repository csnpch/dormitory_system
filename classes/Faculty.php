<?php

    require_once ("Database.php");

    class Faculty extends Database {

        private $table = "tb_facultys";

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

    
        public function Insert($fac_name) {
            $sql = "INSERT INTO $this->table (fac_name) VALUE (?)";

            $insert = $this->db->prepare($sql);
            $insert->bindParam(1, $fac_name, PDO::PARAM_STR);
            $insert->execute();

            return $insert;
        }

        public function Update($fac_id, $fac_name) {
            $sql = "UPDATE $this->table 
                    SET fac_name = ?,
                        updated_at = NOW()
                    WHERE fac_id = ?";

            $update = $this->db->prepare($sql);
            $update->bindParam(1, $fac_name, PDO::PARAM_STR);
            $update->bindParam(2, $fac_id, PDO::PARAM_STR);
            $update->execute();

            return $update;
        }

        public function Delete($fac_id) {
            $sql = "DELETE FROM $this->table WHERE fac_id = ?";
            $delete = $this->db->prepare($sql);
            $delete->bindParam(1, $fac_id, PDO::PARAM_INT);
            $delete->execute();

            return $delete;
        }

    }

?>
