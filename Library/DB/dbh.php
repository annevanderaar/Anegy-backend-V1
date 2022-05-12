<?php
class dbconnection extends PDO {
  private $servername = "localhost";
  private $dBUsername = "root";
  private $dBPassword = "";
  private $dBName = "movies-series";

  public function __construct() {
    parent::__construct("mysql:host=" . $this->servername . ";dbname=" . $this->dBName . "; charset=utf8", $this->dBUsername, $this->dBPassword);
    $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  }

  public function getUsers() {
    $dbconnect = new dbconnection();
    $sql = "SELECT * FROM users";
    $query = $dbconnect->prepare($sql);
    $query->execute();
    $output = $query->fetchAll(PDO::FETCH_ASSOC);
    return $output;
  }

  public function getUser($id) {
    $dbconnect = new dbconnection();
    $sql = "SELECT ID, name, email FROM users WHERE ID = :id";
    $query = $dbconnect->prepare($sql);
    $query->bindParam(":id", $id);
    $query->execute();
    $output = $query->fetchAll(PDO::FETCH_ASSOC);
    return $output;
  }

  public function addUser($name, $email, $password) {
    $dbconnect = new dbconnection();
    $sql = "INSERT INTO users ( name, email, password) VALUES (:name, :email, :password)";
    $query = $dbconnect->prepare($sql);
    $query->bindParam(":name", $name);
    $query->bindParam(":email", $email);
    $query->bindParam(":password", $password);
    $password = password_hash($password, PASSWORD_DEFAULT);
    if ($query->execute()) {
      $output = $query->fetchAll(PDO::FETCH_ASSOC);
      return $output;
    } else {
      echo "error";
    }
  }

  public function getLogin($email, $password) {
    $dbconnect = new dbconnection();
    $sql = "SELECT ID, email, password FROM users WHERE email = :email";
    $query = $dbconnect->prepare($sql);
    $query->bindParam(":email", $email);
    if ($query->execute()) {
      if ($query->rowCount() == 1) {
        if ($row = $query->fetch()) {
          //$id = $row["id"];
          $email = $row["email"];
          $hashed_password = $row["password"];
          if (password_verify($password, $hashed_password)) {
            // $_SESSION["loggedin"] = true;
            // $_SESSION["id"] = $id;
            // $_SESSION["email"] = $email;
          } else {
            echo "invalid";
          }
        }
      }
    }
  }
}
