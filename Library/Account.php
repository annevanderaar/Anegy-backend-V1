<?php
require_once("DB/dbh.php");
require_once("Config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'];
    $password = $data['password'];
    echo $email;
} else if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $db = new dbconnection();
    $id = 1;
    $output = $db->getUser($id);
    // $output = json_decode($output);
    $output = json_encode($output);
    echo ($output);
}
