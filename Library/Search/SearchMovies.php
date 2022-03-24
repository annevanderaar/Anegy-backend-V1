<?php
require_once("Config.php");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $query = json_decode(file_get_contents('php://input'), true);
    $query = $query['query'];
    $search =  str_replace(' ', '%20', $query);

    $ch = curl_init($SEARCH_URL_MOVIES . $search);
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