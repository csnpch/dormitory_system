<?php

    require_once ("Database.php");

    class Admin extends Database {

        private $table = "tb_admins";

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

        public function Insert($user, $pass, $salt, $fname, $lname) {
            $sql = "INSERT INTO $this->table (adm_username, adm_password, adm_salt, adm_fullname, adm_description) 
                    VALUES (?, ?, ?, ?, ?)";

            $insert = $this->db->prepare($sql);
            $insert->bindParam(1, $user, PDO::PARAM_STR);
            $insert->bindParam(2, $pass, PDO::PARAM_STR);
            $insert->bindParam(3, $salt, PDO::PARAM_STR);
            $insert->bindParam(4, $fname, PDO::PARAM_STR);
            $insert->bindParam(5, $lname, PDO::PARAM_STR);
            $insert->execute();

            return $insert;
        }


        public function Update($id, $user, $fname, $lname, $status) {
            $sql = "UPDATE $this->table 
                SET adm_username = ?,
                    adm_fullname = ?,
                    adm_description = ?,
                    adm_status = ?,
                    updated_at = NOW()
                    WHERE adm_id = ?";

            $update = $this->db->prepare($sql);
            $update->bindParam(1, $user, PDO::PARAM_STR);
            $update->bindParam(2, $fname, PDO::PARAM_STR);
            $update->bindParam(3, $lname, PDO::PARAM_STR);
            $update->bindParam(4, $status, PDO::PARAM_STR);
            $update->bindParam(5, $id, PDO::PARAM_STR);
            $update->execute();

            return $update;
        }

        public function Update_password($id, $pass, $salt) {
            $sql = "UPDATE $this->table
                SET adm_password = ?,
                    adm_salt = ?,
                    updated_at = NOW()
                    WHERE adm_id = ?";

            $update = $this->db->prepare($sql);
            $update->bindParam(1, $pass, PDO::PARAM_STR);
            $update->bindParam(2, $salt, PDO::PARAM_STR);
            $update->bindParam(3, $id, PDO::PARAM_STR);
            $update->execute();

            return $update;
        }

        public function Delete($id) {
            $sql = "DELETE FROM $this->table WHERE adm_id = ?";
            $delete = $this->db->prepare($sql);
            $delete->bindParam(1, $id, PDO::PARAM_INT);
            $delete->execute();

            return $delete;
        }

    }

?>
 