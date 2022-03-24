<?php
require_once("Config.php");

header('Access-Control-Allow-Origin: *');

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $d = json_decode(file_get_contents('php://input'));
    $ch = curl_init($SEARCH_URL . 'zoekopdracht');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    if(curl_error($ch)) {
        return curl_error($ch);
    }
    curl_close($ch);

    echo $data;
    // return $data;
}