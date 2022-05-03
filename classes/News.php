<?php

    require_once ("Database.php");

    class News extends Database {

        private $table = "tb_news";

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

        public function Insert($news_header, $news_link_img, $news_link_main) {
            $sql = "INSERT INTO $this->table (news_header, news_link_img, news_link_main) VALUES (?, ?, ?)";

            $insert = $this->db->prepare($sql);
            $insert->bindParam(1, $news_header, PDO::PARAM_STR);
            $insert->bindParam(2, $news_link_img, PDO::PARAM_STR);
            $insert->bindParam(3, $news_link_main, PDO::PARAM_STR);
            $insert->execute();

            return $insert;
        }


        public function Update($news_id, $news_header, $news_link_img, $news_link_main) {
            $sql = "UPDATE $this->table 
                SET news_header = ?,
                    news_link_img = ?,
                    news_link_main = ?,
                    updated_at = NOW()
                    WHERE `news_id` = ?";

            $update = $this->db->prepare($sql);
            $update->bindParam(1, $news_header, PDO::PARAM_STR);
            $update->bindParam(2, $news_link_img, PDO::PARAM_STR);
            $update->bindParam(3, $news_link_main, PDO::PARAM_STR);
            $update->bindParam(4, $news_id, PDO::PARAM_STR);
            $update->execute();

            return $update;
        }

        public function Delete($news_id) {
            $sql = "DELETE FROM $this->table WHERE news_id = ?";
            $delete = $this->db->prepare($sql);
            $delete->bindParam(1, $news_id, PDO::PARAM_INT);
            $delete->execute();

            return $delete;
        }

        // Custom function
        public function autoDestroyNews($year) {
            $sql = "DELETE FROM $this->table
                    WHERE YEAR(created_at) <= EXTRACT(YEAR FROM CURRENT_DATE) - $year";
            
            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }

    }

?>
 