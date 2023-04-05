<?php
require_once("./DB/dbh.php");

$db = new dbconnection();
$sql = "SELECT * FROM users";
$query = $db->prepare($sql);
$query->execute();
$output = $query->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($output);
echo "</pre>";
