<?php
    //Getting the DbConnect.php file
    require '../backend/DbConnect.php';
    $dbConn = new DbConnect();
    $conn = $dbConn->connect();
            
    require '../backend/DataPages.php';
    $DP = new DataPages();
    $DP->CreateTable();
    $DataPages = $DP->getAll();
        
    if(isset($_POST['add_new'])){
       $url = '../DataEntry/DataPage.php';
       header('location: ' . $url);
       exit();
    }

    if(isset($_POST['edit'])){
       $dps = array();
       foreach($DataPages as $dp){
          if(isset($_POST['chk_' . $dp['id']])){
             array_push($dps,$dp);
          }
       }

       $countIds = count($dps);
       if($countIds < 2 ){
          $url =$dps[0]['id'];
          header('location:../DataEntry/​DataPages​.php?id=',TRUE, 302);
          exit();
       }
    }

    if(isset($_POST['export'])){
       //Define the filename with current date
       $fileName = "DataPages-".date('d-m-Y').".xlsx";

       //Set header information to export data in excel format
       header('Content-Type: application/vnd.ms-excel');
       header('Content-Disposition: attachment; filename='.$fileName);
       //readfile(dirname(dirname(__FILE__)) . $fileName );
       //Set variable to false for heading
       $heading = false;

       //Add the MySQL table data to excel file
       if(!empty($DataPages)) {
          foreach($DataPages as $item) {
             if(!$heading) {
                //echo implode("\t", array_keys($item)) . "\n";
                $array = array('No', 'PAGE ID', 'TITRE', 'URL', 'MENU');
                echo implode("\t", array_values($array)) . "\n";
                $heading = true;
             }
             echo implode("\t", array_values($item)) . "\n";
          }
      }
      exit();

    }

    if(isset($_POST['import'])){
       // (B) PHPSPREADSHEET TO LOAD EXCEL FILE
       require "../vendor/autoload.php";
       $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
       $spreadsheet = $reader->load("DataPages-19-03-2021.xlsx");
       $worksheet = $spreadsheet->getActiveSheet();

       // (C) READ DATA + IMPORT
       //$sql = "INSERT INTO Suppliers (company, first_name, last_name, email, mobile_phone, fixed_phone, address, zipcode, city, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
       $count = 0;
       foreach ($worksheet->getRowIterator() as $row) {
           
           // (C1) FETCH DATA FROM WORKSHEET
           $cellIterator = $row->getCellIterator();
           $cellIterator->setIterateOnlyExistingCells(false);
           $data = [];
           //print_r( $cellIterator );
           
           foreach ($cellIterator as $cell) {
              $data[] = $cell->getValue();
           }

           // (C2) INSERT INTO DATABASE
           //print_r($count . ' : ' . $dp[1] . ' : ' . $dp[2]. ' : ' . $dp[3]. ' : ' . $dp[4] . '<br/>');
           try {
              //$stmt = $conn->prepare($sql);
              //$stmt->execute($data);
              /* $count = 0 is first row and is header */
              if($count != 0){
                 
                 $result = $DP->DataEntry( addslashes($data[1]) , addslashes($data[2]), addslashes($data[3]), addslashes($data[4]));
              }else {
                 $result = true;
              }
              //$message = "OK - SUPPLIER ID - {$conn->lastInsertId()}<br>";
              if($result){
                 $message = '<div style="color:green;" > Data have been imported </div>';
                 $DataPages = $DP->getAll();

              }else {
                 $message = '<div style="color:red;" > Error </div>';
              } 
            } catch (Exception $ex) { 
              $message = $ex->getMessage() . "<br>";
            }
            $stmt = null;
            $count++;
       }

       // (D) CLOSE DATABASE CONNECTION
       if ($stmt !== null) { $stmt = null; }
       if ($conn !== null) { $conn = null; } 
  
    }
?>
<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
        <title>DATA PAGE LIST</title>
        <link rel="stylesheet" href="../css/generic_layout.css">
        <script src="../js/jquery-1.7.2.js"></script>
        <script type="text/javascript">
            //alert(parent.pages[1]['page_id']);
            var pages = parent.pages;
        </script>
        
    </head>
    <body>
        
        <form method="POST">
            <!-- start ribbon bar -->
            <div style="width:100%;min-height:50px;border:1px solid white; border-radius:2px;">
                <table style="">
                    <tr>
                        <td style="border:1px solid white;border-radius:2px;">
                            <p id="page_title" style="padding:10px 5px;"> DATAPAGES </p>
                        </td>
                        <td style="border:1px solid white;border-radius:2px;">
                            <table style="height:100px;width:100%;">
                                <tr >
                                    <td style="text-align:center;">
                                        <!--input name="add_new" onclick="addNew();" type="submit" style="border:none;width:100%;height:100%;background:url('../images/png32/Add.png') no-repeat 50% 20%; color:white;text-align:center;padding-top:80%;" alt="Add" value="Nouveau"/><br/-->
                                        <a style="text-decoration:none;color:white;width:100%;height:100%;text-align:center;" id="anchor_add_new" href="javascript:parent.datapage.navigateTo('AddPage',pages);" >
                                            <img src="../images/png32/Add.png" />
                                            <p>AJOUTER</p>
                                        </a>
                                    </td>
                                    <td style="padding-top:0px">
                                        <input onclick="javascript:editData();" name="edit" type="button" style="border:none;width:100%;height:40%;background:url('../images/png32/Edit.png') no-repeat 20% 50%; color:white;text-align:right;padding-left:50px;" alt="Edit" value="Modifier"/><br/>
                                        <input name="delete" type="submit" style="border:none;width:100%;height:40%;background:url('../images/png/Delete.png') no-repeat 20% 50%; color:white;text-align:right;padding-left:50px;" alt="Delete" value="Supprimer"/><br/>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        
                        <td style="border:1px solid white;border-radius:2px;">
                            <table style="height:100px;width:100%;">
                                <tr >
                                    <td style="text-align:center;">
                                        <!--input name="add_new" onclick="addNew();" type="submit" style="border:none;width:100%;height:100%;background:url('../images/png32/Add.png') no-repeat 50% 20%; color:white;text-align:center;padding-top:80%;" alt="Add" value="Nouveau"/><br/-->
                                        <input name="import" onclick="addNew();" type="submit" style="border:none;width:100%;height:100%;background:url('../images/png32/Import32x32.png') no-repeat 50% 20%; color:white;text-align:center;padding-top:80%;" alt="Add" value="IMPORTER"/><br/>
                                    </td>
                                    <td style="text-align:center;">
                                        <!--input name="add_new" onclick="addNew();" type="submit" style="border:none;width:100%;height:100%;background:url('../images/png32/Add.png') no-repeat 50% 20%; color:white;text-align:center;padding-top:80%;" alt="Add" value="Nouveau"/><br/-->
                                        <input name="export" onclick="addNew();" type="submit" style="border:none;width:100%;height:100%;background:url('../images/png32/Excel32x32.png') no-repeat 50% 20%; color:white;text-align:center;padding-top:80%;" alt="Export Database" value="EXPORTER"/><br/>
                                    </td>
                                    <td style="text-align:center;">
                                        <!--input name="add_new" onclick="addNew();" type="submit" style="border:none;width:100%;height:100%;background:url('../images/png32/Add.png') no-repeat 50% 20%; color:white;text-align:center;padding-top:80%;" alt="Add" value="Nouveau"/><br/-->
                                        <input name="print" onclick="Print();" type="submit" style="border:none;width:100%;height:100%;background:url('../images/png32/Print.png') no-repeat 50% 20%; color:white;text-align:center;padding-top:80%;" alt="Print Database" value="IMPRIMER"/><br/>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        
                        <!--td style="border:1px solid white;border-radius:2px;">
                            <input name="prepa"  type="submit" style="border:none;width:100%;height:100%;background:url('../images/png/couverts.png') no-repeat 50% 20%; color:white;text-align:center;padding-top:80%;" alt="Add" value="Service"/><br/>
                        </td>
                        <td style="border:1px solid white;border-radius:2px;">
                            <input name="delivered"  type="submit" style="border:none;width:100%;height:100%;background:url('../images/png32/payment-icon-5655_32x32.png') no-repeat 50% 20%; color:white;text-align:center;padding-top:80%;" alt="Add" value="Payement"/><br/>
                        </td-->
                    </tr>
                </table>
            </div>
            <!-- end ribbon bar -->
            
            <!-- start left side bar -->
            <div style="margin-top:10px;float:left;overflow:auto;width:20%; height:60vh; border-radius:2px 0px 0px 2px;border:1px solid white;">
                <p style="border-bottom:1px dashed white;">Barre de recherche : </p>
                <div>
                    <input id="myInput" onkeyup="myFunction();" style="float:left;color:white;background-color:transparent;margin-left:5px; border-radius:5px;" placeholder="Numéro de la commande" type="text"/>
                    <input onclick="search();"style="float:right;margin-top:-19px;width:18px;height:18px;"type="image" src="../images/search-icon-windows-phone_249467.png"/>
                </div>
                <div style="clear:both">
                    <br/>
                </div>
                <div id="lstMenuNo" onload="alert('ListBox onload');"style="overflow:auto;height:85vh; border-radius:2px;border:1px solid white;">
                    ListBox
                </div>
            </div>
            <!-- end left side bar -->
        <!-- start right side bar -->
        <div id="right_content" style="margin-top:10px;float:left;overflow:auto;width:80%; height:60vh; border-radius:0px 2px 2px 0px;border:1px solid white;">
            <?php
                //echo $countIds;
                    if($DataPages != null){
            ?>           
            <table style="border:1px solid white; width:100%; margin:10px 10px 10px 10px;">
               <thead>
                   <tr style="text-align:center;">
                       <th>
                           <input onClick="checkAll()" id="chkAll" name="chkAll" type="checkbox" value="chkAll"/>
                       </th>
                       <th>
                           PAGE ID
                       </th>
                       <th>
                           TITRE 
                       </th>
                       <th>
                           LIEN
                       </th>
                       <th>
                           MENU
                       </th>
                       
                   </tr>
                </thead>
                <tbody>
                    <?php
                foreach($DataPages as $dp){

                    if($dp['div_menu'] == 'block'){
                       $menu_status = 'Show';
                    }else{
                       $menu_status = 'none';
                    }

                    echo '<tr>';
                        echo '<td style="text-align:center;border-top:1px dashed white;">';
                        echo '  <input id="chk" name="chk_' . $dp['id'] . '" type="checkbox" value="' . $dp['id'] . ',' .$dp['page_id'] .','. $dp['title'] .','. $dp['url'] . ','. $dp['div_menu'] .'"/>';    
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo '  <input name="page_id_' . $dp['page_id'] . '" type="hidden" value="' . $dp['page_id'] . '"/><a href="OrderDetail.php?id=' . $dp['id'] . '" style="color:white;" >' . $dp['page_id'] . '</a>';
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo '  <input name="title_' . $dp['id'] . '" type="hidden" value="' . $dp['title'] . '"/>' . $dp['title'];
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo '  <input name="url_' . $dp['id'] . '" type="hidden" value="' . $dp['url'] . '"/>' . $dp['url'];
                        echo '</td>';
                        echo '<td style="text-align:center;border-top:1px dashed white;">';
                        echo '  <input name="menu_' . $dp['id'] . '" type="hidden" value="' . $dp['div_menu'] . '"/>' . $menu_status;
                        echo '</td>';
                        echo '</tr>';
                 }
                    ?>
                </tbody>
            </table>
            <?php
                
            }else {
               echo '0 Commande';
            }
            ?>
        </div>
        <!-- end right side bar -->
        
        </form>
    <script type="text/javascript">
    

    var isChecked = false;
function checkAll() {
    var checkboxes = document.getElementsByTagName('input');
     if (isChecked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
  isChecked = !isChecked;
 }
 
 function editData(){
    //alert('Edit Data ');
    var dp = [];
    var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    //alert("nb CheckBoxes is checked " + checkboxes.length);
    if(checkboxes.length == 1){
        for(var i = 0; i < checkboxes.length; i++){
            //alert( checkboxes[i].value );
            dp.push(checkboxes[i].value);
        }  
        sessionStorage.setItem("datapage", dp );
        parent.datapage.navigateTo('AddPage',pages);
    }else {
        
        for(var i = 0; i < checkboxes.length; i++){
            //alert(checkboxes[i].value );
            if(checkboxes[i].value != 'chkAll'){
               dp.push(checkboxes[i].value);
            }
        }
        //alert(dp[0]);
        sessionStorage.setItem("datapage", JSON.stringify( dp ) );
        parent.datapage.navigateTo('AddMultiPages',pages);
    }
    //location.replace = 'dashboard.php';
    
 }
            
function Print(){
   var style = "<style>";
   style = style + "img{ background-color :red;}"
   style = style + "table thead tbody { background-color:white; width: 100%;font: 17px Calibri;}";
   style = style + "th {background-color:gray;}";
   style = style + "td {border: solid 1px #DDD; border-collapse: collapse; text-align:left;";
   style = style + "padding: 2px 3px;}";
   style = style + "</style>";

   //GET ELEMENT ID
   //var el_html = document.getElementById(el_id);
   //el_html.innerHTML = el_html.innerHTML + qrcode.makeCode("Test")
   // CREATE A WINDOW OBJECT.
   var win = window.open('', '', 'height=700,width=700');
   win.document.write('<html><head>');
   win.document.write('<title> SUPPLIERS </title>');   // <title> FOR PDF HEADER.
   win.document.write(style);          // ADD STYLE INSIDE THE HEAD TAG.
   win.document.write('</head>');
   win.document.write('<body>');

   win.document.write('<h4 style="text-align:center;"> Liste des Fournisseurs <\/h4>');
   win.document.write('<div style="text-align:center;"id="qrcode"></div>');
  
   //win.document.write(el_html.innerHTML);
   win.document.write('<table>');
       
   win.document.write('<tr>');     
   win.document.write('<th>');
   win.document.write('No.');  
   win.document.write('</th>');
   win.document.write('<th>');
   win.document.write('PAGE ID');  
   win.document.write('</th>');
   win.document.write('<th>');
   win.document.write('TITRE ');  
   win.document.write('</th>');
   win.document.write('<th>');
   win.document.write('URL');  
   win.document.write('</th>');
   win.document.write('<th>');
   win.document.write('MENU');  
   win.document.write('</th>');
   
   win.document.write('</tr>');
       
   <?php foreach($DataPages as $dp){ ?>
       
   win.document.write('<tr>');     
   win.document.write('<td style="text-align:center;">');
   win.document.write(' <?php echo $dp['id']; ?> ');  
   win.document.write('</td>');
   win.document.write('<td>');
   win.document.write('  <?php echo $dp['page_id']; ?> ');  
   win.document.write('</td>');
   win.document.write('<td>');
   win.document.write(' <?php echo $dp['title']; ?> ');  
   win.document.write('</td>');
   win.document.write('<td>');
   win.document.write(' <?php echo $dp['url']; ?> ');  
   win.document.write('</td>');
   win.document.write('<td>');
   win.document.write(' <?php echo $dp['div_menu']; ?> ');  
   win.document.write('</td>');
       
   win.document.write('</tr>');
   
   <?php } ?>
   win.document.write('</table>');
       
   /*    
   //var qrcode = new QRCode("test", { text: "test", width: 128, height: 128, colorDark : "#000000", colorLight : "#ffffff", correctLevel : QRCode.CorrectLevel.H });
   win.document.write('<script type="text\/javascript" src="..\/js\/jquery.min.js"><\/script>');
   win.document.write('<script type="text\/javascript" src="..\/js\/qrcode.js"><\/script>');
        
   win.document.write('<script type="text\/javascript">');
   win.document.write('var qrcode = new QRCode(document.getElementById("qrcode"), { width : 100,	height : 100 });');
   win.document.write('qrcode.makeCode("' + qrText + '")');
   win.document.write('<\/script>');
*/
   win.document.write('</body></html>');

   win.document.close(); 	// CLOSE THE CURRENT WINDOW.

   win.print();    // PRINT THE CONTENTS.
    
}
</script>
    </body>
</html>
