<?php
class Departments
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
          $stmt = $this->con->prepare("CREATE TABLE IF NOT EXISTS `Departments` (`id` INT NOT NULL AUTO_INCREMENT, `service` VARCHAR(100), `vision` VARCHAR(255), `mission` VARCHAR(255), PRIMARY KEY (`id`)); ");
          if($stmt->execute()) {
             return true; 
          }
          return false;
     }

    /*
     * The create operation
     * When this method is called a new record is created in the database
     */
     function DataEntry($service, $vision, $mission){
          $stmt = $this->con->prepare("INSERT INTO Departments(service, vision, mission) VALUES (?, ?, ?)");
          $stmt->bind_param("sss", $service, $vision, $mission);
          if($stmt->execute()) {
             return true; 
          }
          return false; 
     }

/*
 * The read operation
 * When this method is called it is returning all the existing record of the database
 */
 function getCompanies(){
 $stmt = $this->con->prepare("SELECT id, images, name, type, address, zipcode, city, description FROM entreprise");
 $stmt->execute();
 $stmt->bind_result($id, $images, $name, $type, $address, $zipcode, $city, $description);
 
 $companies = array(); 
 
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
 
 array_push($companies, $company); 
 }
 
 return $companies; 
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
 function DeleteCompany($id){
    $stmt = $this->con->prepare("DELETE FROM entreprise WHERE id = ? ");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
       return true;
    } 
 
    return false; 
 }

}
?>