<?php
class Products
{
    //Database connection link
    private $con;
 
    //Class constructor
    function __construct()
    {
        //Getting the DbConnect.php file
        //require dirname(__FILE__) . '/DbConnect.php';
 
        //Creating a DbConnect object to connect to the database
        //$db = new DbConnect();
 
        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        global $conn;
        $this->con = $conn;
    }

    /*
     * The create new table if not exist 
     * When this method is called a new table is created in the database
     */

     function CreateTable(){
          $stmt = $this->con->prepare("CREATE TABLE IF NOT EXISTS `Products` (`id` INT NOT NULL AUTO_INCREMENT, `name` VARCHAR(100), `images` VARCHAR(255), `fds` VARCHAR(255), `price` VARCHAR(50), `currency` VARCHAR(50), `quantity` INT, `unit` VARCHAR(50),  `description` VARCHAR(255), `group_id` INT, `categorie_id` INT, `tools` VARCHAR(25), `group_only` TINYINT, `invoice_only` TINYINT, `report_only` TINYINT, PRIMARY KEY (`id`)); ");
          if($stmt->execute()) {
             return true; 
          }
          return false;
     }

    /*
     * The create operation
     * When this method is called a new record is created in the database
     */
     function DataEntry($name, $images, $fds, $price, $currency, $quantity, $unit, $description, $group_id, $categories_id, $tools, $group_only, $invoice_only, $report_only){
          $stmt = $this->con->prepare("INSERT INTO Products(name, images, fds, price, currency, quantity, unit, description, group_id, categorie_id, tools, group_only, invoice_only, report_only) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
          $stmt->bind_param("sssssissiisiii", $name, $images, $fds, $price, $currency, $quantity, $unit, $description, $group_id, $categorie_id, $tools, $group_only, $invoice_only, $report_only);
          if($stmt->execute()) {
             return true; 
          }
          return false; 
     }

/*
 * The update operation
 * When this method is called the record with the given id is updated with the new given values
 */
 function DataEdit($id, $name, $images, $fds, $price, $currency, $quantity, $unit, $description, $group_id, $categorie_id, $tools, $group_only, $invoice_only, $report_only){
     $stmt = $this->con->prepare("UPDATE Products SET name = ?, images = ?, price = ?, currency = ?, quantity = ?, unit = ?, description = ?, group_id = ?, categorie_id = ?, tools = ?, group_only = ?, invoice_only = ?, report_only = ? WHERE id = ?");
     $stmt->bind_param("sssssissiisiiii", $name, $images, $price, $currency, $quantity, $unit, $description, $group_id, $categorie_id, $tools, $group_only, $invoice_only, $report_only, $id);
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
    $stmt = $this->con->prepare("DELETE FROM Products WHERE id = ? ");
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
 $stmt = $this->con->prepare("SELECT id, name, images, fds, price, currency, quantity, unit, description, group_id,  categorie_id, tools, group_only, invoice_only, report_only FROM Products");
 $stmt->execute();
 $stmt->bind_result($id, $name, $images, $fds, $price, $currency, $quantity, $unit, $description, $group_id, $categorie_id, $tools, $group_only, $invoice_only, $report_only);
 
 $products = array(); 
 
 while($stmt->fetch()){
 $product = array();
 $product['id'] = $id; 
 $product['name'] = $name; 
 $product['images'] = $images; 
 $product['fds'] = $fds; 
 $product['price'] = $price;
 $product['currency'] = $currency; 
 $product['quantity'] = $quantity; 
 $product['unit'] = $unit;
 $product['description'] = $description;
 $product['group_id'] = $group_id;
 $product['categorie_id'] = $categorie_id; 
 $product['tools'] = $tools;
 $product['group_only'] = $group_only;
 $product['invoice_only'] = $invoice_only;
 $product['report_only'] = $report_only;

 array_push($products, $product); 
 }
 
 return $products; 
 }

 function getGroup(){
 $stmt = $this->con->prepare("SELECT id, name, images, fds, price, currency, quantity, unit, description, group_id,  categorie_id, tools, group_only, invoice_only, report_only FROM Products WHERE group_only = 1");
 $stmt->execute();
 $stmt->bind_result($id, $name, $images, $fds, $price, $currency, $quantity, $unit, $description, $group_id, $categorie_id, $tools, $group_only, $invoice_only, $report_only);
 
 $products = array(); 
 
 while($stmt->fetch()){
 $product = array();
 $product['id'] = $id; 
 $product['name'] = $name; 
 $product['images'] = $images;
 $product['fds'] = $fds; 
 $product['price'] = $price;
 $product['currency'] = $currency; 
 $product['quantity'] = $quantity; 
 $product['unit'] = $unit;
 $product['description'] = $description;
 $product['group_id'] = $group_id;
 $product['categorie_id'] = $categorie_id; 
 $product['tools'] = $tools;
 $product['group_only'] = $group_only;
 $product['invoice_only'] = $invoice_only;
 $product['report_only'] = $report_only;

 array_push($products, $product); 
 }
 
 return $products; 
 }

function getToOrder($id){
 $stmt = $this->con->prepare("SELECT id, name, images, fds, price, currency, quantity, unit, description, group_id,  categorie_id, tools, group_only, invoice_only, report_only FROM Products WHERE group_id = " . $id . "");
 $stmt->execute();
 $stmt->bind_result($id, $name, $images, $fds, $price, $currency, $quantity, $unit, $description, $group_id, $categorie_id, $tools, $group_only, $invoice_only, $report_only);
 
 $products = array(); 
 
 while($stmt->fetch()){
 $product = array();
 $product['id'] = $id; 
 $product['name'] = $name; 
 $product['images'] = $images;
 $product['fds'] = $fds; 
 $product['price'] = $price;
 $product['currency'] = $currency; 
 $product['quantity'] = $quantity; 
 $product['unit'] = $unit;
 $product['description'] = $description;
 $product['group_id'] = $group_id;
 $product['categorie_id'] = $categorie_id; 
 $product['tools'] = $tools;
 $product['group_only'] = $group_only;
 $product['invoice_only'] = $invoice_only;
 $product['report_only'] = $report_only;

 array_push($products, $product); 
 }
 
 return $products; 
 }


function getOne($id){
 $stmt = $this->con->prepare("SELECT id, name, images, fds, price, currency, quantity, unit, description, group_id, categorie_id, tools, group_only, invoice_only, report_only FROM products WHERE id = " . $id);
 $stmt->execute();
 $stmt->bind_result($id, $name, $images, $fds, $price, $currency, $quantity, $unit, $description, $group_id, $categorie_id, $tools, $group_only, $invoice_only, $report_only);
 
 //$products = array(); 
 
 while($stmt->fetch()){
 $product = array();
 $product['id'] = $id; 
 $product['name'] = $name; 
 $product['images'] = $images;
 $product['fds'] = $fds; 
 $product['price'] = $price;
 $product['currency'] = $currency; 
 $product['quantity'] = $quantity; 
 $product['unit'] = $unit;
 $product['description'] = $description;
 $product['group_id'] = $group_id; 
 $product['categorie_id'] = $categorie_id; 
 $product['tools'] = $tools;
 $product['group_only'] = $group_only;
 $product['invoice_only'] = $invoice_only;
 $product['report_only'] = $report_only;
 
 //array_push($products, $product); 
 }
 
 return $product; 
 }


function getLast(){
 $stmt = $this->con->prepare("SELECT id, name, images, fds, price, currency, quantity, unit, description, group_id, categorie_id, tools, group_only, invoice_only, report_only FROM Products ORDER BY id DESC LIMIT 1;");
 $stmt->execute();
 $stmt->bind_result($id, $name, $images, $fds, $price, $currency, $quantity, $unit, $description, $group_id, $categorie_id, $tools, $group_only, $invoice_only, $report_only);
 
 //$companies = array(); 
 
 while($stmt->fetch()){
 $product = array();
 $product['id'] = $id; 
 $product['name'] = $name; 
 $product['images'] = $images; 
 $product['fds'] = $fds; 
 $product['price'] = $price;
 $product['currency'] = $currency; 
 $product['quantity'] = $quantity; 
 $product['unit'] = $unit;
 $product['description'] = $description;
 $product['group_id'] = $group_id; 
 $product['categorie_id'] = $categorie_id; 
 $product['tools'] = $tools;
 $product['group_only'] = $group_only;
 $product['invoice_only'] = $invoice_only;
 $product['report_only'] = $report_only;

 //array_push($companies, $company); 
 }
 
 return $product; 
 }

}
?>