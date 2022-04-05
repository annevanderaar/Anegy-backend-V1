<?php
require_once("Config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $query = json_decode(file_get_contents('php://input'), true);
    $url = $query['url'];
    $page = $query['page'];
    //$query = $query['query'];
    $search =  str_replace(' ', '%20', $query['query']);

    $ch = curl_init($BASE_URL . $url . $API_KEY . "&query=" . $search . "&page=" . $page);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    if(curl_error($ch)) {
        return curl_error($ch);
    }
    curl_close($ch);

    echo $data;
}