<?php

function speech_to_text($speech, $type) {
    $ch = curl_init();
    $url = 'https://api.us-south.speech-to-text.watson.cloud.ibm.com/instances/c2ac6a7c-22bb-41d5-a3f5-ad7498312daf';
    $api_key = 'bkmB-1McEUfEpXYxQN0LdFVRTA-NgRIRviL58IQ1_1eg';

    curl_setopt($ch, CURLOPT_URL, $url.'/v1/recognize?model=en-US_BroadbandModel');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    $post = array(
        'file' => file_get_contents($speech)
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_USERPWD, 'apikey' . ':' . $api_key);

    $headers = array();
    $headers[] = 'Content-Type: '.$type;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = json_decode(curl_exec($ch), true)['results'][0]['alternatives'][0]['transcript'];
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    return $result;
}

function comment_is_offensive($text) {
    $ch = curl_init();
    $url = 'https://api.us-south.natural-language-understanding.watson.cloud.ibm.com/instances/e33a0a2f-6eca-4ca5-b159-3de0165efe28';
    $api_key = 'bMnM9htDNBXXjCdgD9AEXVigsRqlcqYa4pHgGJGVBAHm';

    curl_setopt($ch, CURLOPT_URL, $url.'/v1/analyze?version=2021-08-01');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    $post = json_encode(array(
        'html' => $text,
        'features' => [
            'emotion' => (object) null
        ]
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_USERPWD, 'apikey' . ':' . $api_key);

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = json_decode(curl_exec($ch), true)['emotion']['document']['emotion']['anger'];
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    return $result >= 0.4 ? true : false;
}
require "app/models/Comment.php";

$host = "localhost";
$username = "root";
$password = "";
$dbname = "movie_db";

$db = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!isset($_GET['id']) or !isset($_POST['username']) or (!isset($_FILES['file']['tmp_name']) and !isset($_POST['comment']))) {
    http_response_code(404);
    echo '404';
    die;
}

$comment = new Comment($db);
$comment_text = '';
if (isset($_POST['comment']) and !empty($_POST['comment'])) {
    $comment_text = $_POST['comment'];
} else if (isset($_FILES['file']['tmp_name'])) {
    $comment_text = speech_to_text($_FILES['file']['tmp_name'], $_FILES['file']['type']);
}

if (!comment_is_offensive($comment_text) and !empty($comment_text) and !empty($_POST['username'])) {
    $comment->insertComment($_GET['id'], $_POST['username'], $comment_text);
}

header('Location:'.$_SERVER['HTTP_REFERER']);
