<?php

    require_once ("Database.php");

    class Book extends Database {

        private $table = "tb_books";

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

        public function Insert($branch_id, $room_id) {
            $sql = "INSERT INTO $this->table (branch_id, room_id) VALUES (?, ?)";

            $insert = $this->db->prepare($sql);
            $insert->bindParam(1, $branch_id, PDO::PARAM_STR);
            $insert->bindParam(2, $room_id, PDO::PARAM_STR);
            $insert->execute();

            return $insert;
        }


        public function Update($book_id, $branch_id, $room_id) {
            $sql = "UPDATE $this->table 
                SET branch_id = ?,
                    room_id = ?,
                    updated_at = NOW()
                    WHERE book_id = ?";

            $update = $this->db->prepare($sql);
            $update->bindParam(1, $branch_id, PDO::PARAM_STR);
            $update->bindParam(2, $room_id, PDO::PARAM_STR);
            $update->bindParam(3, $book_id, PDO::PARAM_STR);
            $update->execute();

            return $update;
        }

        public function Delete($book_id) {
            $sql = "DELETE FROM $this->table WHERE book_id = $book_id";
            $delete = $this->db->prepare($sql);
            $delete->execute();

            return $delete;
        }

        // custom function
        public function getDataBook() {
            $sql = "SELECT book_id, branch_id, tb_books.room_id, tb_rooms.room_name 
                    FROM `tb_books` 
                    INNER JOIN tb_rooms ON tb_books.room_id = tb_rooms.room_id
                    ORDER BY tb_rooms.room_name ASC";
            $query = $this->db->prepare($sql);
            $query->execute();

            return $query;
        }
    
    }

?>