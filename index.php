<?php

require "app/models/Movie.php";

$host = "localhost";
$username = "root";
$password = "";
$dbname = "movie_db";

$db = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$movie = new Movie($db);
$movies = $movie->getMovies();

include "app/templates/index.tpl";
