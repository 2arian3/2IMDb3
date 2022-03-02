<?php

class Movie
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

    public function getMovies()
    {
        $sql = "SELECT * FROM movie
                ORDER BY date_added DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id)
    {
        $sql = 'SELECT * FROM movie WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() <= 0) {
            return null;
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getComments($movie_id)
    {
        $sql = "SELECT * FROM comment WHERE movie_id = :movie_id ORDER BY date_added DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':movie_id', $movie_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
