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
    $sql = "SELECT ID, firstname, lastname, email FROM users WHERE ID = :id";
    $query = $dbconnect->prepare($sql);
    $query->bindParam(":id", $id);
    $query->execute();
    $output = $query->fetchAll(PDO::FETCH_ASSOC);
    return $output;
  }

  public function addUser($firstname, $lastname, $email, $password) {
    $dbconnect = new dbconnection();
    $sql = "INSERT INTO users ( firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)";
    $query = $dbconnect->prepare($sql);
    $query->bindParam(":firstname", $firstname);
    $query->bindParam(":lastname", $lastname);
    $query->bindParam(":email", $email);
    $query->bindParam(":password", $password);
    $password = password_hash($password, PASSWORD_DEFAULT);
    if ($query->execute()) {
      $id = $dbconnect->lastInsertId();
      return $id;
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
          $id = $row["ID"];
          $email = $row["email"];
          $hashed_password = $row["password"];
          if (password_verify($password, $hashed_password)) {
            return $id;
          } else {
            return "invalid";
          }
        }
      }
    }
  }

  public function delete($id) {
    $dbconnect = new dbconnection();
    $sql = "DELETE FROM users WHERE ID = :id";
    $query = $dbconnect->prepare($sql);
    $query->bindParam(":id", $id);
    $query->execute();
    $output = $query->fetchAll(PDO::FETCH_ASSOC);
    return $output;
  }
}
