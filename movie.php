<?php

function translate($text, $language) {
    $ch = curl_init();
    $url = 'https://api.us-south.language-translator.watson.cloud.ibm.com/instances/0587ced7-b51e-48de-a9bc-024ea69f4b14';
    $api_key = 'BbNokn8nJGWeUIQBRK8ctM-xihc0ucJT3UUkbbJWtWH5';

    $language_codes = [
        'Spanish' => 'es',
        'German' => 'de'
    ];

    curl_setopt($ch, CURLOPT_URL, $url . '/v3/translate?version=2018-05-01');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"text\":[\"" . $text ."\"],\"model_id\":\"en-". $language_codes[$language]  ."\"}");
    curl_setopt($ch, CURLOPT_USERPWD, 'apikey' . ':' . $api_key);

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = json_decode(curl_exec($ch), true)['translations'][0]['translation'];
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    return $result;
}

require "app/models/Movie.php";

$host = "localhost";
$username = "root";
$password = "";
$dbname = "movie_db";

$db = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!isset($_GET['id'])) {
    http_response_code(404);
    echo '404';
    die;
}


$show_comments = false;
$language = 'English';

if (isset($_GET['show_comments'])) {
    $show_comments = filter_var($_GET['show_comments'], FILTER_VALIDATE_BOOLEAN);
}

if (isset($_GET['lang']) and in_array($_GET['lang'], ['English', 'German', 'Spanish'])) {
    $language = $_GET['lang'];
}

$movie_id = $_GET['id'];

$movie = new Movie($db);
$comments = array();
$number_of_comments = $movie->countComments($movie_id);

if ($show_comments) {
    $comments = $movie->getComments($movie_id);
}

$movie = $movie->get($movie_id);
if ($movie === null) {
    http_response_code(404);
    echo '404';
    die;
}

if ($language !== 'English') {
    foreach ($comments as $key => $value) {
        $comments[$key]['text'] = translate($comments[$key]['text'], $language);
    }
}

include "app/templates/movie.tpl";
