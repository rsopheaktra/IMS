<?php
class Suppliers
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
          $stmt = $this->con->prepare("CREATE TABLE IF NOT EXISTS `Suppliers` (`id` INT NOT NULL AUTO_INCREMENT, `company` VARCHAR(100), `first_name` VARCHAR(50), `last_name` VARCHAR(50), `email` VARCHAR(50), `mobile_phone` VARCHAR(50), `fixed_phone` VARCHAR(50), `address` VARCHAR(255), `zipcode` VARCHAR(50),`city` VARCHAR(50), `country` VARCHAR(25), PRIMARY KEY (`id`)); ");
          if($stmt->execute()) {
             return true; 
          }
          return false;
     }

    /*
     * The create operation
     * When this method is called a new record is created in the database
     */
     function DataEntry($company, $first_name, $last_name, $email, $mobile_phone, $fixed_phone, $address, $zipcode, $city, $country){
          $stmt = $this->con->prepare("INSERT INTO Suppliers (company, first_name, last_name, email, mobile_phone, fixed_phone, address, zipcode, city, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
          $stmt->bind_param("ssssssssss", $company, $first_name, $last_name, $email, $mobile_phone, $fixed_phone, $address, $zipcode, $city, $country);
          if($stmt->execute()) {
             return true; 
          }
          return false; 
     }
/*
 * The update operation
 * When this method is called the record with the given id is updated with the new given values
 */
 function DataEdit($id, $company, $first_name, $last_name, $email, $mobile_phone, $fixed_phone, $address, $zipcode, $city, $country){
     $stmt = $this->con->prepare("UPDATE Suppliers SET company = ?, first_name = ?, last_name = ?, email = ?, mobile_phone = ?, fixed_phone = ?, address = ?, zipcode = ?, city = ?, country = ? WHERE id = ?");
     $stmt->bind_param("ssssssssssi", $company, $first_name, $last_name, $email, $mobile_phone, $fixed_phone, $address, $zipcode, $city, $country, $id);
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
    $stmt = $this->con->prepare("DELETE FROM Suppliers WHERE id = ? ");
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
 $stmt = $this->con->prepare("SELECT id, company, first_name, last_name, email, mobile_phone, fixed_phone, address, zipcode, city, country FROM Suppliers");
 $stmt->execute();
 $stmt->bind_result($id, $company, $first_name, $last_name, $email, $mobile_phone, $fixed_phone, $address, $zipcode, $city, $country);
 
 $suppliers = array(); 
 
 while($stmt->fetch()){
 $supplier = array();
 $supplier['id'] = $id; 
 $supplier['company'] = $company; 
 $supplier['first_name'] = $first_name;
 $supplier['last_name'] = $last_name;
 $supplier['email'] = $email;
 $supplier['mobile_phone'] = $mobile_phone;
 $supplier['fixed_phone'] = $fixed_phone;
 $supplier['address'] = $address; 
 $supplier['zipcode'] = $zipcode;
 $supplier['city'] = $city; 
 $supplier['country'] = $country;
 
 array_push($suppliers, $supplier); 
 }
 
 return $suppliers; 
 }


function getByID($id){

 $stmt = $this->con->prepare("SELECT id, company, first_name, last_name, email, mobile_phone, fixed_phone, address, zipcode, city, country FROM Suppliers WHERE id = " .$id);
 $stmt->execute();
 $stmt->bind_result($id, $company, $first_name, $last_name, $email, $mobile_phone, $fixed_phone, $address, $zipcode, $city, $country);
 
 $suppliers = array(); 
 
 while($stmt->fetch()){
 $supplier = array();
 $supplier['id'] = $id; 
 $supplier['company'] = $company; 
 $supplier['first_name'] = $first_name;
 $supplier['last_name'] = $last_name;
 $supplier['email'] = $email;
 $supplier['mobile_phone'] = $mobile_phone;
 $supplier['fixed_phone'] = $fixed_phone;
 $supplier['address'] = $address; 
 $supplier['zipcode'] = $zipcode;
 $supplier['city'] = $city; 
 $supplier['country'] = $country;
 
 //array_push($suppliers, $supplier); 
 }

 return $supplier; 
 }


function getLast(){
 $stmt = $this->con->prepare("SELECT id, company, first_name, last_name, email, mobile_phone, fixed_phone, address, zipcode, city, country FROM Suppliers ORDER BY id DESC LIMIT 1;");
 $stmt->execute();
 $stmt->bind_result($id, $company, $first_name, $last_name, $email, $mobile_phone, $fixed_phone, $address, $zipcode, $city, $country);
 
 $suppliers = array(); 
 
 while($stmt->fetch()){
 $supplier = array();
 $supplier['id'] = $id; 
 $supplier['company'] = $company; 
 $supplier['first_name'] = $first_name;
 $supplier['last_name'] = $last_name;
 $supplier['email'] = $email;
 $supplier['mobile_phone'] = $mobile_phone;
 $supplier['fixed_phone'] = $fixed_phone;
 $supplier['address'] = $address; 
 $supplier['zipcode'] = $zipcode;
 $supplier['city'] = $city; 
 $supplier['country'] = $country;
 
 //array_push($suppliers, $supplier); 
 }

 return $supplier; 
 }

}
?>