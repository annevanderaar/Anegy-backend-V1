<?php
require_once("DB/dbh.php");
require_once("Config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new dbconnection();
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['id'])) {
        $id = $data['id'];
        $output = $db->getUser($id);
        // $output = json_decode($output);
        $output = json_encode($output);
        echo ($output);
    } else {
        $email = trim($data['email']);
        $password = trim($data['password']);
        if (isset($data['firstname'])) {
            $firstname = $data['firstname'];
            $lastname = $data['lastname'];
            $output = $db->addUser($firstname, $lastname, $email, $password);
            if ($output == "error") {
                echo "error";
            } else {
                echo $output;
            }
        } else {
            $output = $db->getLogin($email, $password);
            if ($output == "invalid") {
                echo "invalid";
            } else {
                echo $output;
            }
        }
    }
}
