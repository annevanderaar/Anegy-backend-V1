<?php
require_once("Config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $page = $data['page'];
    $url = $data['url'];

    $ch = curl_init($BASE_URL . $url . $API_KEY . "&page=" . $page);
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