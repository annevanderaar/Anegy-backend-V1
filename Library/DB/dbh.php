<?php
class dbconnection extends PDO {
  private $servername = "localhost";
  private $dBUsername = "root";
  private $dBPassword = "";
  private $dBName = "anegy";

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
    $check = $dbconnect->prepare("SELECT 1 FROM `users` WHERE `email` = ?");
    $check->execute([$email]);
    $found = $check->fetchColumn();
    if ($found) {
      echo "emailUse";
    } else {
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
  }

  public function deleteUser($id) {
    $dbconnect = new dbconnection();
    $sql = "DELETE FROM users WHERE ID = :id";
    $query = $dbconnect->prepare($sql);
    $query->bindParam(":id", $id);
    if ($query->execute()) {
      echo "succes";
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

  public function addFavorite($userid, $msid, $type) {
    $dbconnect = new dbconnection();
    $sql = "INSERT INTO favorites ( user_id, ms_id, type) VALUES (:user_id, :ms_id, :type)";
    $query = $dbconnect->prepare($sql);
    $query->bindParam(":user_id", $userid);
    $query->bindParam(":ms_id", $msid);
    $query->bindParam(":type", $type);
    if ($query->execute()) {
      echo "succes";
    } else {
      echo "error";
    }
  }

  public function getFavorites($id) {
    $dbconnect = new dbconnection();
    $sql = "SELECT * FROM favorites WHERE user_id = :user_id";
    $query = $dbconnect->prepare($sql);
    $query->bindParam(":user_id", $id);
    $query->execute();
    $output = $query->fetchAll(PDO::FETCH_ASSOC);
    return $output;
  }

  public function deleteFavorite($userid, $msid) {
    $dbconnect = new dbconnection();
    $sql = "DELETE FROM favorites WHERE user_id = :user_id and ms_id = :ms_id";
    $query = $dbconnect->prepare($sql);
    $query->bindParam(":user_id", $userid);
    $query->bindParam(":ms_id", $msid);
    if ($query->execute()) {
      echo "succes";
    } else {
      echo "error";
    }
  }

  public function addWatched($userid, $msid, $type) {
    $dbconnect = new dbconnection();
    $sql = "INSERT INTO watched ( user_id, ms_id, type) VALUES (:user_id, :ms_id, :type)";
    $query = $dbconnect->prepare($sql);
    $query->bindParam(":user_id", $userid);
    $query->bindParam(":ms_id", $msid);
    $query->bindParam(":type", $type);
    if ($query->execute()) {
      echo "succes";
    } else {
      echo "error";
    }
  }

  public function getWatched($id) {
    $dbconnect = new dbconnection();
    $sql = "SELECT * FROM watched WHERE user_id = :user_id";
    $query = $dbconnect->prepare($sql);
    $query->bindParam(":user_id", $id);
    $query->execute();
    $output = $query->fetchAll(PDO::FETCH_ASSOC);
    return $output;
  }

  public function deleteWatched($userid, $msid) {
    $dbconnect = new dbconnection();
    $sql = "DELETE FROM watched WHERE user_id = :user_id and ms_id = :ms_id";
    $query = $dbconnect->prepare($sql);
    $query->bindParam(":user_id", $userid);
    $query->bindParam(":ms_id", $msid);
    if ($query->execute()) {
      echo "succes";
    } else {
      echo "error";
    }
  }
}
