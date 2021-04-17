<?php
class Users
{
    //Database connection link
    private $con;
 
    //Class constructor
    function __construct()
    {
        global $conn;
        //Getting the DbConnect.php file
        //require dirname(__FILE__) . '/DbConnect.php';
 
        //Creating a DbConnect object to connect to the database
        //$db = new DbConnect();
 
        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $conn;
    }

     /*
     * The create new table if not exist 
     * When this method is called a new table is created in the database
     */

     function CreateTable(){
          $stmt = $this->con->prepare("CREATE TABLE IF NOT EXISTS `users` (`id` INT NOT NULL AUTO_INCREMENT, `username` VARCHAR(100), `password` VARCHAR(100), `employee_id` INT, PRIMARY KEY (`id`)); ");
          if($stmt->execute()) {
             return true; 
          }
          return false;
     }

    /*
     * The create operation
     * When this method is called a new record is created in the database
     */
     function DataEntry($username, $password, $employee_id){
          $stmt = $this->con->prepare("INSERT INTO users(username, password, employee_id) VALUES (?, ?, ?)");
          $stmt->bind_param("sss", $username, md5($password), $employee_id);
          if($stmt->execute()) {
             return true; 
          }
          return false; 
     }

     /*
      * The update operation
      * When this method is called the record with the given id is updated with the new given values
      */
 function DataEdit($id, $images, $name, $type, $address, $zipcode, $city, $description){
     $stmt = $this->con->prepare("UPDATE entreprise SET images = ?, name = ?, type = ?, address = ?, zipcode = ?, city = ?, description = ? WHERE id = ?");
     $stmt->bind_param("sssssssi", $images, $name, $type, $address, $zipcode, $city, $description, $id);
     if($stmt->execute()){
        return true;
     }
     return false; 
 }

/*
 * The delete operation
 * When this method is called record is deleted for the given id 
 */
 function Delete($id){
    $stmt = $this->con->prepare("DELETE FROM users WHERE id = ? ");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
       return true;
    } 
 
    return false; 
 }

/*
 * The read operation
 * When this method is called it is returning all the existing record of the database
 */
 function getAll(){
 $stmt = $this->con->prepare("SELECT id, username, password, employee_id FROM users");
 $stmt->execute();
 $stmt->bind_result($id, $username, $password, $employee_id);
 
 $users = array(); 
 
 while($stmt->fetch()){
 $user = array();
 $user['id'] = $id;
 $user['username'] = $username; 
 $user['password'] = $password; 
 $user['employee_id'] = $employee_id; 
 
 array_push($users, $user); 
 }
 
 return $users; 
 }


function getOneCompanies($id){

 $stmt = $this->con->prepare("SELECT id, images, name, type, address, zipcode, city, description FROM entreprise WHERE id = " .$id);
 $stmt->execute();
 $stmt->bind_result($id, $images, $name, $type, $address, $zipcode, $city, $description);
 
 //$companies = array(); 
 
 while($stmt->fetch()){
 $company = array();
 $company['id'] = $id; 
 $company['images'] = $images; 
 $company['name'] = $name; 
 $company['type'] = $type; 
 $company['address'] = $address; 
 $company['zipcode'] = $zipcode;
 $company['city'] = $city; 
 $company['description'] = $description;
 
 //array_push($companies, $company); 
 }

 return $company; 
 }


function getLastCompanies(){
 $stmt = $this->con->prepare("SELECT id, images, name, type, address, zipcode, city, description FROM entreprise ORDER BY id DESC LIMIT 1;");
 $stmt->execute();
 $stmt->bind_result($id, $images, $name, $type, $address, $zipcode, $city, $description);
 
 //$companies = array(); 
 
 while($stmt->fetch()){
 $company = array();
 $company['id'] = $id; 
 $company['images'] = $images; 
 $company['name'] = $name; 
 $company['type'] = $type; 
 $company['address'] = $address; 
 $company['zipcode'] = $zipcode;
 $company['city'] = $city; 
 $company['description'] = $description;
 
 //array_push($companies, $company); 
 }
 
 return $company; 
 }


}
?>