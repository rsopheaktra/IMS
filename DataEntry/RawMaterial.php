<?php
    
    //Getting the DbConnect.php file
    require '../backend/DbConnect.php';
    $dbConn = new DbConnect();
    $conn = $dbConn->connect();
            
    require '../backend/RawMaterials.php';
    $RM = new RawMaterials();
    $RM->CreateTable();
    $groups = $RM->getGroup();
    
    $categories = array( array('id'=>1, 'title'=>'Verrerie'),array('id'=>2, 'title'=>'Solvant'), );
    if(isset($_POST['return'])){
       $url = '../List/RawMaterials​.php';
       header('location: ' . $url);
       exit();
    }

    if(isset( $_POST['id'] )){
       if( $_POST['id'] != ''){
          $bntSave = 'edit';
          $id = $_POST['id'];
          
       }else {
          $btnSave = 'add';
       }
    }

    if(isset($_POST['save'])){
       if($bntSave == 'edit'){
           $result = $RM->DataEdit( $id, $_POST['title'], $_POST['images'], $_POST['fds'], $_POST['price'], $_POST['currency'], $_POST['quantity'], $_POST['unit'], $_POST['description'], $_POST['group_id'] , $_POST['categorie_id'], $_POST['tools'] , $_POST['group_only'], $_POST['invoice_only'], $_POST['report_only']);
           
           if($result){
              $message = 'Edited';
              $rm = $RM->getOne( $_POST['id'] );
           }else {
              $message = 'Error';
           }
       }else {
           $result = $RM->DataEntry( $_POST['title'], $_POST['images'], $_POST['fds'], $_POST['price'], $_POST['currency'], $_POST['quantity'], $_POST['unit'], $conn->real_escape_string($_POST['description']), $_POST['group_id'] , $_POST['categorie_id'], $_POST['tools'] , $_POST['group_only'], $_POST['invoice_only'], $_POST['report_only']);
           if($result){
              $message = 'Saved';
              $rm = $RM->getLast();
           }else {
              $message = 'Error';
           }
       }
    }
?>
<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
        <title id="header_title">NOUVELLE PAGE</title>
        <link rel="stylesheet" href="../css/generic_layout.css">
        <script src="../js/jquery-1.7.2.js"></script>
        <script type="text/javascript">
            //alert(parent.pages[1]['page_id']);
            var pages = parent.pages;
            
            /* get data from session in form of string */
            var suppliers = sessionStorage.getItem("suppliers");
            sessionStorage.removeItem("suppliers");
            alert(suppliers);
            
            if(suppliers == null ){
              supplier =  <?php echo json_encode($rm) ; ?> ;
            }else {
              
              var str = suppliers;
              var res = str.split(",");
              var supplier = {};
                  
              supplier.id = res[0];
              supplier.title = res[1];
              supplier.images = res[2];
              supplier.fds = res[3];
              supplier.price = res[4];
              supplier.currency = res[5];
              supplier.quantity = res[6];
              supplier.unit = res[7];
              supplier.description = res[8];
              supplier.group_id = res[9];
              supplier.categorie_id = res[10];
              supplier.tools = res[11];
              supplier.group_only = res[12];
              supplier.invoice_only = res[13];
              supplier.report_only = res[14];
            }
                  
            //alert(supplier.id);
            document.getElementById('title').innerHTML = datapage.title;
        </script>
            
    </head>
    <body>
        <form method="POST">
            <!-- start ribbon bar -->
            <div style="width:100%;min-height:50px;border:1px solid white; border-radius:2px;">
                <table style="">
                    <tr>
                        <td style="border:1px solid white;border-radius:2px;">
                            <p id="page_title" style="padding:10px 5px;"> DATAENTRY </p>
                        </td>
                        <td style="border:1px solid white;border-radius:2px;">
                            <table style="height:100px;width:100%;">
                                <tr >
                                    <td style="">
                                        <input name="save" onclick="addNew();" type="submit" style="border:none;width:100%;height:100%;background:url('../images/png32/Save.png') no-repeat 50% 20%; color:white;text-align:center;padding-top:80%;" alt="Add" value="Sauvegarder"/><br/>
                                    </td>
                                    <td style="padding-top:0px">
                                        <!--input name="return" type="submit" style="border:none;width:100%;height:40%;background:url('../images/png32/backtolist.png') no-repeat 20% 50%; color:white;text-align:right;padding-left:50px;" alt="Edit" value="Retourner"/><br/-->
                                        <a style="margin-left:5%;text-decoration:none;color:white;text-align:right;" id="anchor_return" href="javascript:parent.datapage.navigateTo('RawMaterials',pages);" >
                                            <img style="padding:5%;" src="../images/png32/ReturntoList.png" />
                                            <p style="margin-left:10%;margin-top:-30%;">Retourner</p>
                                        </a>
                                        <input name="delete" type="submit" style="border:none;width:100%;height:40%;background:url('../images/png/Delete.png') no-repeat 20% 50%; color:white;text-align:right;padding-left:50px;" alt="Delete" value="Supprimer"/><br/>
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
            <div >           
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
                <div id="message">
                    <?php if(isset($message)){ echo $message; } ?>
                </div>
                
                <table style="padding-top:5px; padding-left: 5%;padding-right: 5%; width:100%;margin-left:auto; margin-right:auto;">
                    <tr>
                        <th style="text-align:left;">  DÉSIGNATION </th>
                        <td style="width:70%;">
                            <input id="id" value="" name="id" placeholder="1" type="hidden" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                            <input id="title" value="" name="title" placeholder="HCL" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;" required="true" />
                        </td>
                    </tr> 
                    <tr>
                        <th style="text-align:left;"> L'IMAGE  </th>
                        <td style="width:70%;">
                            <input id="images" value="" name="images" placeholder="image1.jpg" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;" />
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> FICHE DES DONNÉES DE LA SÉCURITÉ </th>
                        <td style="width:70%;">
                            <input id="fds" value="" name="fds" placeholder="hcl.pdf"  type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;" />
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> PRIX </th>
                        <td style="width:70%;">
                            <input id="price" value="" name="price" placeholder="40,0" type="number" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;" />
                        </td>
                    </tr> 
                    <tr>
                        <th style="text-align:left;"> MONNAIE </th>
                        <td style="width:70%;">
                            <input id="currency" value="" name="currency" placeholder="€" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;" />
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> QUANTITÉ </th>
                        <td style="width:70%;">
                            <input id="quantity" value="" name="quantity" placeholder="10" type="number" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> UNITÉ </th>
                        <td style="width:70%;">
                            <input id="unit" value="" name="unit" placeholder="g" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                        </td>
                    </tr>
                    
                    <tr>
                        <th style="text-align:left;"> GROUP </th>
                        <td style="width:70%;">
                            <select id="group_id" name="group_id" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;" >
                                <?php foreach( $groups as $gp) { ?>
                                   <option value="<?php echo $gp['id']; ?>" > <?php echo $gp['name'] ; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> CATÉGORIE </th>
                        <td style="width:70%;">
                            <select id="categorie_id" name="categorie_id" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;" >
                                <?php foreach( $categories as $cate) { ?>
                                   <option value="<?php echo $cate['id']; ?>" > <?php echo $cate['title'] ; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> UTILS </th>
                        <td style="width:70%;">
                            <input id="tools" value="ou" name="tools" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> GROUP SEULEMENT </th>
                        <td style="width:70%;">
                            <input id="group_only" value="1" name="group_only" type="checkbox" />
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> FACTURE SEULEMENT </th>
                        <td style="width:70%;">
                            <input id="invoice_only" value="1" name="invoice_only" type="checkbox" />
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> RAPPORT SEULEMENT </th>
                        <td style="width:70%;">
                            <input id="report_only" value="1" name="report_only" type="checkbox" />
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left; top:0px;"> DESCRIPTION </th>
                        <td style="width:70%;">
                            <textarea id="description" name="description" rows="5" cols="40" style="text-align:left;height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;" >
                                
                            </textarea> 
                        </td>
                    </tr>
                </table>
            </div>
            <!-- end right side bar -->
            <?php //var_dump($DataPage); ?>
             <script type="text/javascript">
                 alert('Working ' + supplier.title);
                 var id = document.getElementById("id");
                 id.value = supplier.id;
                 var title = document.getElementById("title");
                 title.value = supplier.title;
                 var images = document.getElementById("images");
                 images.value = supplier.images;
                 var fds = document.getElementById("fds");
                 fds.value = supplier.fds;
                 var price = document.getElementById("price");
                 price.value = supplier.price;
                 var currency = document.getElementById("currency");
                 currency.value = supplier.currency;
                 var quantity = document.getElementById("quantity");
                 quantity.value = supplier.quantity;
                 var unit = document.getElementById("unit");
                 unit.value = supplier.unit;
                 var description = document.getElementById("description");
                 description.value = supplier.description;
                 var group_id = document.getElementById("group_id");
                 group_id.value = supplier.group_id;
                 var categories_id = document.getElementById("categorie_id");
                 categorie_id.value = supplier.categorie_id;
                 var tools = document.getElementById("tools");
                 tools.value = supplier.tools;
                 var group_only = document.getElementById("group_only");
                 //alert('Group Only ' + supplier.group_only );
                 if( supplier.group_only == 1 ){
                    group_only.setAttribute('checked',true);
                 }else{
                    group_only.setAttribute('checked',false);
                 }
                 
                 var invoice_only = document.getElementById("invoice_only");
                 //alert('Group Only ' + supplier.group_only );
                 if( supplier.invoice_only == 1 ){
                    invoice_only.setAttribute('checked',true);
                 }else{
                    invoice_only.setAttribute('checked',false);
                 }
                 
                 var report_only = document.getElementById("report_only");
                 //alert('Group Only ' + supplier.group_only );
                 if( supplier.report_only == 1 ){
                    report_only.setAttribute('checked',true);
                 }else{
                    report_only.setAttribute('checked',false);
                 }
                 
                 document.getElementById('page_title').innerHTML = datapage.title;
             </script>

        </div>
        </form>
    
    </body>
</html>
