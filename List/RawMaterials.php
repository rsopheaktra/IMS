<?php
    //Getting the DbConnect.php file
    require '../backend/DbConnect.php';
    $dbConn = new DbConnect();
    $conn = $dbConn->connect();
            
    require '../backend/RawMaterials.php';
    $RM = new RawMaterials();
    $RM->CreateTable();
    $RawMaterials = $RM->getAll();
    if(isset($_POST['delete'])){
       $message = '<div style="color:red;" >Deleted </div>';
    }
    if(isset($_POST['export'])){
       //Define the filename with current date
       $fileName = "Raw-Materials-".date('d-m-Y').".xlsx";

       //Set header information to export data in excel format
       header('Content-Type: application/vnd.ms-excel');
       header('Content-Disposition: attachment; filename='.$fileName);
       //readfile(dirname(dirname(__FILE__)) . $fileName );
       //Set variable to false for heading
       $heading = false;

       //Add the MySQL table data to excel file
       if(!empty( $RawMaterials )) {
          foreach( $RawMaterials as $item) {
             if(!$heading) {
                //echo implode("\t", array_keys($item)) . "\n";
                $array = array('No', 'TITRE', 'LIEN DES IMAGES', 'FICHE DES DONNÉES DE SÉCURITÉ ', 'PRIX', 'SIGNE', 'QUANTITÉ', 'MESURE', 'DESCRIPTION', 'GROUP ID', 'CATÉGORIE', 'UTILE', 'GROUP SEUL', 'FACTURE SEUL', 'RAPPORT SEUL');
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
       $spreadsheet = $reader->load("Raw-Materials-17-03-2021.xlsx");
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
           //print_r($count . ' : ' . $data);
           try {
              //$stmt = $conn->prepare($sql);
              //$stmt->execute($data);
              /* $count = 0 is first row and is header */
              if($count != 0){
                 $result = $RM->DataEntry( $data[1],$data[2],$data[3],$data[4],$data[5],$data[6],$data[7], $data[8], $data[9], $data[10], $data[11], $data[12], $data[13], $data[14]);
              }else {
                 $result = true;
              }
              //$message = "OK - SUPPLIER ID - {$conn->lastInsertId()}<br>";
              if($result){
                 $message = '<div style="color:green;" > Data have been imported </div>';
                 $RawMaterials = $RM->getAll();

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

<html>
    <head>
        <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
        <title> MATIÈRES PREMIÈRES </title>
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
                                        <a style="text-decoration:none;color:white;width:100%;height:100%;text-align:center;" id="anchor_add_new" href="javascript:parent.datapage.navigateTo('AddRawMaterial',pages);" >
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
                    <input onclick="search();" style="float:right;margin-top:-19px;width:18px;height:18px;" type="image" src="../images/search-icon-windows-phone_249467.png"/>
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
            <div id="message">
                <?php if(isset($message)){ echo $message; } ?>
            </div>
            <?php
                //echo $countIds;
                    if( $RawMaterials != null){
            ?>           
            <table id="tableSup" style="border:1px solid white; width:100%; margin:10px 10px 10px 10px;">
               <thead>
                   <tr style="text-align:center;">
                       <th>
                           <input onClick="checkAll()" id="chkAll" name="chkAll" type="checkbox" value="chkAll"/>
                       </th>
                       <th>
                           DÉSIGNATION 
                       </th>
                       <th>
                           CHEMIN DES IMAGES
                       </th>
                       <th>
                           FICHE DES DONNÉES DE LA SÉCURITÉ 
                       </th>
                       <th>
                           PRIX 
                       </th>
                       <th>
                           MONNAIE 
                       </th>
                       <th>
                           QUANTITÉ
                       </th>
                       <th>
                           UNITÉ 
                       </th>
                       <th>
                           DESCRIPTION 
                       </th>
                       <th>
                           GROUP 
                       </th>
                       <th>
                           CATÉGORIE 
                       </th>
                   </tr>
                </thead>
                 
                <tbody id="tbody">
                    <?php
                foreach( $RawMaterials as $ram){

                    echo '<tr>';
                        echo '<td style="text-align:center;border-top:1px dashed white;">';
                        echo '  <input id="chk" name="chk_' . $ram['id'] . '" type="checkbox" value="' . $ram['id'] . ',' .$ram['title'] .','. $ram['images'] .','. $ram['fds'] . ','. $ram['price'] . ','. $ram['currency'] . ',' . $ram['quantity'] . ','. $ram['unit'] .  ','. $ram['description'] . ','. $ram['group_id'] .  ','. $ram['categorie_id'] .  ','. $ram['tools'] . ','. $ram['group_only'] .  ','. $ram['invoice_only']  .  ','. $ram['report_only'] .'"/>';    
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo '<input onclick="javascript:View();" style="text-decoration:underline;color:blue;text-align:left;width:100%;border:none;background:transparent;" type="button" value="' . $ram['title'] . '"/>';
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo $ram['images'];
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo $ram['fds'];
                        echo '</td>';
                        echo '<td style="text-align:right;border-top:1px dashed white;">';
                        echo $ram['price'];
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo $ram['currency'];
                        echo '</td>';
                        echo '<td style="text-align:right;border-top:1px dashed white;">';
                        echo $ram['quantity'];
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo $ram['unit'];
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo $ram['description'];
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo $ram['group_id'];
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo $ram['categorie_id'];
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
               <script type="text/javascript">
//alert('Working ')	;
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
                
 function View(){
     alert('View'); 
     // CREATE A WINDOW OBJECT.
     var win = window.open('', '', 'height=700,width=700');
   
 }
              
  function editData(){
    alert('Edit Data ');
    var dp = [];
    var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    //alert("nb CheckBoxes is checked " + checkboxes.length);
    if(checkboxes.length == 1){
        for(var i = 0; i < checkboxes.length; i++){
            //alert( checkboxes[i].value );
            dp.push(checkboxes[i].value);
        }  
        sessionStorage.setItem("suppliers", dp );
        parent.datapage.navigateTo('AddRawMaterial',pages);
    }else {
        
        for(var i = 0; i < checkboxes.length; i++){
            //alert(checkboxes[i].value );
            if(checkboxes[i].value != 'chkAll'){
               dp.push(checkboxes[i].value);
            }
        }
        alert(dp[0]);
        sessionStorage.setItem("suppliers", JSON.stringify( dp ) );
        parent.datapage.navigateTo('AddMultiRawLaterials',pages);
    }
    //location.replace = 'dashboard.php';
    
 }
         </script>  
        </div>
        <!-- end right side bar -->       
        </form>
    <script type="text/javascript">
  //alert('Working ')	;


 

 var qrcode = new QRCode(document.getElementById("qrcode"), {
      width : 100,
      height : 100,
      useSVG: true
  });

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
   win.document.write('ENTREPRISE');  
   win.document.write('</th>');
   win.document.write('<th>');
   win.document.write('NOM');  
   win.document.write('</th>');
   win.document.write('<th>');
   win.document.write('PRÉNOM');  
   win.document.write('</th>');
   win.document.write('<th>');
   win.document.write('E-MAIL');  
   win.document.write('</th>');
   win.document.write('<th>');
   win.document.write('TÉLÉPHONE PORTABLE');  
   win.document.write('</th>');
   win.document.write('<th>');
   win.document.write('TÉLÉPHONE FIXE');  
   win.document.write('</th>');
   win.document.write('<th>');
   win.document.write('L\'ADRESSE');  
   win.document.write('</th>');
   win.document.write('<th>');
   win.document.write('CODE POSTAL');  
   win.document.write('</th>');
   win.document.write('<th>');
   win.document.write('VILLE');  
   win.document.write('</th>');  
   win.document.write('<th>');
   win.document.write('PAYS');  
   win.document.write('</th>');
       
   win.document.write('</tr>');
       
   <?php foreach($Suppliers as $sup){ ?>
       
   win.document.write('<tr>');     
   win.document.write('<td style="text-align:center;">');
   win.document.write(' <?php echo $sup['id']; ?> ');  
   win.document.write('</td>');
   win.document.write('<td>');
   win.document.write('  <?php echo $sup['company']; ?> ');  
   win.document.write('</td>');
   win.document.write('<td>');
   win.document.write(' <?php echo $sup['first_name']; ?> ');  
   win.document.write('</td>');
   win.document.write('<td>');
   win.document.write(' <?php echo $sup['last_name']; ?> ');  
   win.document.write('</td>');
   win.document.write('<td>');
   win.document.write(' <?php echo $sup['email']; ?> ');  
   win.document.write('</td>');
   win.document.write('<td>');
   win.document.write(' <?php echo $sup['mobile_phone']; ?> ');  
   win.document.write('</td>');
   win.document.write('<td>');
   win.document.write(' <?php echo addslashes($sup['fixed_phone']); ?> ');  
   win.document.write('</td>');
   win.document.write('<td>');
   win.document.write(' <?php echo addslashes($sup['address']); ?> ');  
   win.document.write('</td>');
   win.document.write('<td>');
   win.document.write(' <?php echo $sup['zipcode']; ?> ');  
   win.document.write('</td>');
   win.document.write('<td>');
   win.document.write(' <?php echo $sup['city']; ?> ');  
   win.document.write('</td>');       
   win.document.write('<td>');
   win.document.write(' <?php echo $sup['country']; ?> ');  
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
