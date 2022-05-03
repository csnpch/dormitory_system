<?php

    require_once ("Database.php");

    class FixReport extends Database {

        private $table = "tb_fixs";

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


        public function Insert($std_id, $fix_detail, $fix_area) {
            $sql = "INSERT INTO $this->table (std_id, fix_detail, fix_area) VALUES (?, ?, ?)";

            $insert = $this->db->prepare($sql);
            $insert->bindParam(1, $std_id, PDO::PARAM_STR);
            $insert->bindParam(2, $fix_detail, PDO::PARAM_STR);
            $insert->bindParam(3, $fix_area, PDO::PARAM_STR);
            $insert->execute();

            return $insert;
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
            
            $sql = "UPDATE $this->table SET $txtSet WHERE $where = $keyword";
            $update = $this->db->prepare($sql);
            $update->execute();

            return $update;
        }
        

        public function Delete($fix_id) {
            $sql = "DELETE FROM $this->table WHERE fix_id = ?";
            $delete = $this->db->prepare($sql);
            $delete->bindParam(1, $fix_id, PDO::PARAM_INT);
            $delete->execute();

            return $delete;
        }

         // -- Custom function --
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

        public function ChangeStatusFix($fix_id, $status) {
            $sql = "UPDATE $this->table 
                SET fix_status = ?,
                    updated_at = NOW()
                WHERE fix_id = ?";
            $query = $this->db->prepare($sql);
            $query->bindParam(1, $status, PDO::PARAM_INT);
            $query->bindParam(2, $fix_id, PDO::PARAM_INT);
            $query->execute();

            return $query;
        }

        public function countFix() {
            $sql = "SELECT COUNT(fix_id) as COUNT FROM `tb_fixs` WHERE fix_status = 2 OR fix_status = 1";
            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

        public function autoDestroyFixs($year) {
            $sql = "DELETE FROM $this->table
                    WHERE YEAR(updated_at) <= EXTRACT(YEAR FROM CURRENT_DATE) - $year";
            
            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

    }

?>
 