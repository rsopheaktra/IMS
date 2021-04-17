<?php 

/*
* Created by Sopheaktra Ros
* website: v2d1click.42web.io
*/

//Class DbConnect

class DbConnect
{
      //Variable to store database link
      private $con;

      //Class constructor
      function __construct()
      {

      }

      //This method will connect to the database
      function connect()
      {
           //Including the constants.php file to get the database constants
           include_once dirname(__FILE__) . '/Constants.php';
           //connecting to mysql database
           include_once dirname(__FILE__) . '/create_db.php';
           $this->con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
           //Checking if any error occured while connecting
           if (mysqli_connect_errno()) {
              
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
              //$this->create_db($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
           }

           //finally returning the connection link
           return $this->con;
      }

      function create_db($hostname, $dbusername, $dbpassword, $dbname ){
          $pdo = new PDO("mysql:host=0.0.0.0", $dbusername, $dbpassword); 
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
          $dbname = "`".str_replace("`","``",$dbname)."`"; 
          $pdo->query("CREATE DATABASE IF NOT EXISTS $dbname"); 
          $pdo->query("use $dbname");
          $this->connect();
      }
      function close()
      {
          // mysqli_close($thicon);
      }

}

?>