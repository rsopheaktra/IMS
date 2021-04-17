<?php
class PagesSettings
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
          $stmt = $this->con->prepare("CREATE TABLE IF NOT EXISTS `PagesSettings` (`id` INT NOT NULL AUTO_INCREMENT, `user_id` INT(50), `datapage_id` INT(50), `has_access` TINYINT, PRIMARY KEY (`id`)); ");
          if($stmt->execute()) {
             return true; 
          }
          return false;
     }

    /*
     * The create operation
     * When this method is called a new record is created in the database
     */
     function DataEntry($page_id, $title, $url, $div_menu){
          $stmt = $this->con->prepare("INSERT INTO DataPages (page_id, title, url, div_menu) VALUES (?, ?, ?, ?)");
          $stmt->bind_param("ssss", $page_id, $title, $url, $div_menu);
          if($stmt->execute()) {
             return true; 
          }
          return false; 
     }

     

/*
 * The read operation
 * When this method is called it is returning all the existing record of the database
 */
 function getAll(){
 $stmt = $this->con->prepare("SELECT id, page_id, title, url, div_menu FROM DataPages");
 $stmt->execute();
 $stmt->bind_result($id, $page_id, $title, $url, $div_menu);
 
 $DataPages = array(); 
 
 while($stmt->fetch()){
 $DataPage = array();
 $DataPage['id'] = $id; 
 $DataPage['page_id'] = $page_id; 
 $DataPage['title'] = $title; 
 $DataPage['url'] = $url; 
 $DataPage['div_menu'] = $div_menu; 
 
 array_push($DataPages, $DataPage); 
 }
  return $DataPages; 
 }

function getByName(){
 $stmt = $this->con->prepare("SELECT id, page_id, title, url, div_menu FROM DataPages");
 $stmt->execute();
 $stmt->bind_result($id, $page_id, $title, $url, $div_menu);
 
 $DataPages = array(); 
 
 while($stmt->fetch()){
 $DataPage = array();
 $DataPage['id'] = $id; 
 $DataPage['page_id'] = $page_id; 
 $DataPage['title'] = $title; 
 $DataPage['url'] = $url; 
 $DataPage['div_menu'] = $div_menu; 
 
 array_push($DataPages, $DataPage); 
 }
  return $DataPages; 
 }

function getByID($id){
 $stmt = $this->con->prepare("SELECT id, page_id, title, url, div_menu FROM DataPages WHERE id = " . $id);
 $stmt->execute();
 $stmt->bind_result($id, $page_id, $title, $url, $div_menu);
 
 //$DataPages = array(); 
 
 while($stmt->fetch()){
 $DataPage = array();
 $DataPage['id'] = $id; 
 $DataPage['page_id'] = $page_id; 
 $DataPage['title'] = $title; 
 $DataPage['url'] = $url; 
 $DataPage['div_menu'] = $div_menu; 
 
 //array_push($DataPages, $DataPage); 
 }
 
 return $DataPage; 
 }

function getLast(){
 $stmt = $this->con->prepare("SELECT id, page_id, title, url, div_menu FROM DataPages ORDER BY id DESC LIMIT 1;");
 $stmt->execute();
 $stmt->bind_result($id, $page_id, $title, $url, $div_menu);
 
 //$DataPages = array(); 
 
 while($stmt->fetch()){
 $DataPage = array();
 $DataPage['id'] = $id; 
 $DataPage['page_id'] = $page_id; 
 $DataPage['title'] = $title; 
 $DataPage['url'] = $url; 
 $DataPage['div_menu'] = $div_menu; 
 
 //array_push($DataPages, $DataPage); 
 }
 
 return $DataPage; 
 }

function getFirst(){
 $stmt = $this->con->prepare("SELECT id, page_id, title, url, div_menu FROM DataPages ORDER BY id ASC LIMIT 1;");
 $stmt->execute();
 $stmt->bind_result($id, $page_id, $title, $url, $div_menu);
 
 //$DataPages = array(); 
 
 while($stmt->fetch()){
 $DataPage = array();
 $DataPage['id'] = $id; 
 $DataPage['page_id'] = $page_id; 
 $DataPage['title'] = $title; 
 $DataPage['url'] = $url; 
 $DataPage['div_menu'] = $div_menu; 
 
 //array_push($DataPages, $DataPage); 
 }
 
 return $DataPage; 
 }


 /*
 * The update operation
 * When this method is called the record with the given id is updated with the new given values
 */
 function DataEdit($id, $page_id, $title, $url, $div_menu){
     $stmt = $this->con->prepare("UPDATE DataPages SET page_id = ?, title = ?, url = ?, div_menu = ? WHERE id = ?");
     $stmt->bind_param("ssssi", $page_id, $title, $url, $div_menu, $id);
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
    $stmt = $this->con->prepare("DELETE FROM DataPages WHERE id = ? ");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
       return true;
    } 
 
    return false; 
 }

}
?>