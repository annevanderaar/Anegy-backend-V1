<?php
require_once("DB/dbh.php");
require_once("Config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new dbconnection();
    $data = json_decode(file_get_contents('php://input'), true);
    $email = trim($data['email']);
    $password = trim($data['password']);
    if (isset($data['name'])) {
        $name = $data['name'];
        $output = $db->addUser($name, $email, $password);
        if ($output == "error") {
            echo "error";
        } else {
            echo "succes";
        }
    } else {
        $output = $db->getLogin($email, $password);
        if ($output == "invalid") {
            echo "invalid";
        } else {
            echo "succes";
        }
    }
} else if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $db = new dbconnection();
    $id = 1;
    $output = $db->getUser($id);
    // $output = json_decode($output);
    $output = json_encode($output);
    echo ($output);
}
