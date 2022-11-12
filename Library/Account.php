<?php

require_once("DB/dbh.php");
require_once("Config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new dbconnection();
    $data = json_decode(file_get_contents('php://input'), true);
    if ($data['param'] == "account") {
        $id = $data['id'];
        $output = $db->getUser($id);
        $output = json_encode($output);
        echo ($output);
    } else if ($data['param'] == "create" || $data['param'] == "login") {
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
            } else if ($output == "") {
                echo "exist";
            } else {
                echo $output;
            }
        }
    } else if ($data['param'] == "reset") {
        $email = trim($data['email']);
        $output = $db->getReset($email);
        if ($output == "") {
            echo "exist";
        } else {
            echo $output;
        }
    } else if ($data['param'] == "reset-form") {
        $password = trim($data['password']);
        //$output = $db->getReset($password);
        if ($output == "") {
            echo "exist";
        } else {
            echo $output;
        }
    } else if ($data['param'] == "fave") {
        $id = $data['id'];
        $output = $db->getFavorites($id);
        $output = json_encode($output);
        echo ($output);
    } else if ($data['param'] == "addFave") {
        $userid = $data['userid'];
        $msid = $data['msid'];
        $type = $data['type'];
        $output = $db->addFavorite($userid, $msid, $type);
        echo $output;
    } else if ($data['param'] == "deleteFave") {
        $userid = $data['userid'];
        $msid = $data['msid'];
        $output = $db->deleteFavorite($userid, $msid);
        echo $output;
    } else if ($data['param'] == "watched") {
        $id = $data['id'];
        $output = $db->getWatched($id);
        $output = json_encode($output);
        echo ($output);
    } else if ($data['param'] == "addWatched") {
        $userid = $data['userid'];
        $msid = $data['msid'];
        $type = $data['type'];
        $output = $db->addWatched($userid, $msid, $type);
        echo $output;
    } else if ($data['param'] == "deleteWatched") {
        $userid = $data['userid'];
        $msid = $data['msid'];
        $output = $db->deleteWatched($userid, $msid);
        echo $output;
    } else if ($data['param'] == "deleteUser") {
        $id = $data['id'];
        $output = $db->deleteUser($id);
        echo $output;
    }
}
