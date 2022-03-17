<?php
class dbconnection extends PDO {
  private $servername = "localhost";
  private $dBUsername = "root";
  private $dBPassword = "";
  private $dBName = "movies-series";

  public function __construct() {
    parent::__construct("mysql:host=".$this->servername.";dbname=".$this->dBName."; charset=utf8", $this->dBUsername, $this->dBPassword);
    $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  }

}
?>