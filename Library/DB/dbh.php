<?php

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require '../../vendor/autoload.php';
// require_once('phpmail/PHPMailerAutoload.php');

require_once("../Config.php");

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

  public function getReset($email) {
    $dbconnect = new dbconnection();
    $sql = "SELECT email FROM users WHERE email = :email";
    $query = $dbconnect->prepare($sql);
    $query->bindParam(":email", $email);
    if ($query->execute()) {
      if ($query->rowCount() == 1) {
        if ($row = $query->fetch()) {
          $email = $row["email"];
          if ($email == "") {
            return "";
          } else {
            return $email;
            //Add step 4

            // $token = md5($email) . rand(10, 9999);

            // $expFormat = mktime(
            //   date("H"),
            //   date("i"),
            //   date("s"),
            //   date("m"),
            //   date("d") + 1,
            //   date("Y")
            // );

            // $expDate = date("Y-m-d H:i:s", $expFormat);

            // //$update = mysqli_query($conn, "UPDATE users set  password='" . $password . "', reset_link_token='" . $token . "' ,exp_date='" . $expDate . "' WHERE email='" . $email . "'");

            // $link = "<a href='www.anegy.nl/reset-form?key=" . $email . "&token=" . $token . "'>Click To Reset password</a>";

            // $mail = new PHPMailer();
            // $mail->CharSet =  "utf-8";
            // $mail->IsSMTP();
            // // enable SMTP authentication
            // $mail->SMTPAuth = true;
            // // GMAIL username
            // $mail->Username = "info@anegy.nl";
            // // GMAIL password
            // $mail->Password = $EMAIL_PASSWORD;
            // $mail->SMTPSecure = "ssl";
            // // sets GMAIL as the SMTP server
            // $mail->Host = $EMAIL_HOST;
            // // set the SMTP port for the GMAIL server
            // $mail->Port = $EMAIL_PORT;
            // $mail->From = 'info@anegy.nl';
            // $mail->FromName = 'Anegy';
            // $mail->AddAddress('reciever_email_id', 'reciever_name');
            // $mail->Subject  =  'Reset Password';
            // $mail->IsHTML(true);
            // $mail->Body    = 'Click On This Link to Reset Password ' . $link . '';
            // if ($mail->Send()) {
            //   echo "Check Your Email and Click on the link sent to your email";
            // } else {
            //   echo "Mail Error - >" . $mail->ErrorInfo;
            // }
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
