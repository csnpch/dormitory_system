<?php

    require_once ("Database.php");

    class Branch extends Database {

        private $table = "tb_branchs";

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

        public function Insert($fac_id, $branch_name) {
            $sql = "INSERT INTO $this->table (fac_id, branch_name) VALUES (?, ?)";

            $insert = $this->db->prepare($sql);
            $insert->bindParam(1, $fac_id, PDO::PARAM_STR);
            $insert->bindParam(2, $branch_name, PDO::PARAM_STR);
            $insert->execute();

            return $insert;
        }


        public function Update($branch_id, $fac_id, $branch_name) {
            $sql = "UPDATE $this->table 
                    SET fac_id = ?,
                    branch_name = ?,
                    updated_at = NOW()
                    WHERE branch_id = ?";

            $update = $this->db->prepare($sql);
            $update->bindParam(1, $fac_id, PDO::PARAM_STR);
            $update->bindParam(2, $branch_name, PDO::PARAM_STR);
            $update->bindParam(3, $branch_id, PDO::PARAM_STR);
            $update->execute();

            return $update;
        }

        public function Delete($branch_id) {
            $sql = "DELETE FROM $this->table WHERE branch_id = ?";
            $delete = $this->db->prepare($sql);
            $delete->bindParam(1, $branch_id, PDO::PARAM_INT);
            $delete->execute();

            return $delete;
        }

    }

?>
 