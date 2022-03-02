<?php


class Comment
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
        $sql = "CREATE TABLE IF NOT EXISTS movie(
                   id int(11) PRIMARY KEY AUTO_INCREMENT,
                   name varchar(255) NOT NULL,
                   director varchar(255) NOT NULL,
                   poster text NOT NULL,
                   date_added DATETIME DEFAULT CURRENT_TIMESTAMP
                )";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $sql = "CREATE TABLE IF NOT EXISTS comment(
                   id int(11) PRIMARY KEY AUTO_INCREMENT,
                   text text NOT NULL,
                   username varchar(255) NOT NULL,
                   movie_id int(11) NOT NULL,
                   FOREIGN KEY (movie_id) REFERENCES movie(id),
                   date_added DATETIME DEFAULT CURRENT_TIMESTAMP
                )";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    public function countAll($movie_id)
    {
        $sql = 'SELECT COUNT(*) AS count FROM comment WHERE movie_id = :movie_id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch()['count'];
    }

    public function insertComment($movie_id, $username, $text)
    {
        $sql = "INSERT INTO comment (username, text, movie_id) 
                VALUES (:username, :text, :movie_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':text' => $text,
            ':movie_id' => $movie_id
        ]);
    }
}