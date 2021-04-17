<?php
    
    //Getting the DbConnect.php file
    require '../backend/DbConnect.php';
    $dbConn = new DbConnect();
    $conn = $dbConn->connect();
            
    require '../backend/Shippers.php';
    $SUP = new Shippers();
    $SUP->CreateTable();
    
    if(isset($_POST['save'])){
       if(isset( $_POST["id"] )){
          $count = count($_POST["id"]);
       }else{
          $count = 0;
       }
       $sups =array();
       for($i=0;$i<$count;$i++){
           $result = $SUP->DataEdit( $_POST['id'][$i], $_POST['company'][$i], $_POST['first_name'][$i], $_POST['last_name'][$i], $_POST['email'][$i], $_POST['mobile_phone'][$i], $_POST['fixed_phone'][$i], $_POST['address'][$i], $_POST['zipcode'][$i], $_POST['city'][$i], $_POST['country'][$i]);
           $sup = $SUP->getByID( $_POST['id'][$i]);
           if($result){
              $message = 'Updated';
              array_push($sups,$sup);
           }else {
              $message = 'Error';
           } 
       }
    }
?>

<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
        <title>NOUVEAUX FOURNISSEURS</title>
        <link rel="stylesheet" href="../css/generic_layout.css">
        <script src="../js/jquery-1.7.2.js"></script>
        <script type="text/javascript">
            //alert(parent.pages[1]['page_id']);
            var pages = parent.pages;
            
            /* get data from session in forms array */
            var suppliers = JSON.parse(sessionStorage.getItem("suppliers") );
            sessionStorage.removeItem("suppliers");
            //alert( suppliers );
            if(suppliers == null ){
              suppliers =  <?php echo json_encode($sups) ; ?> ;
            }else {
              var sups = [];
              for(var i = 0 ; i < suppliers.length; i++){
                  var str = suppliers[i];
                  var res = str.split(",");
                  var sup = {};
                  
                  sup.id = res[0];
                  sup.company = res[1];
                  sup.first_name = res[2];
                  sup.last_name = res[3];
                  sup.email = res[4];
                  sup.mobile_phone = res[5];
                  sup.fixed_phone = res[6];
                  sup.address = res[7];
                  sup.zipcode = res[8];
                  sup.city = res[9];
                  sup.country = res[10];
                  
                  sups.push(sup);
              }
              suppliers = sups;
            }
            alert( suppliers[0].company );

            //alert( <?php echo $count ; ?> );
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
                                        <a style="margin-left:5%;text-decoration:none;color:white;text-align:right;" id="anchor_return" href="javascript:parent.datapage.navigateTo('Shippers',pages);" >
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
                <div>
                    <table style="border:1px solid white; width:100%; margin:10px 10px 10px 10px;">
                        <thead>
                            <tr>
                                <th style="text-align:center;">
                                    ID
                                </th>
                                <th style="text-align:center;">
                                    ENTREPRISE 
                                </th>
                                <th style="text-align:center;">
                                    NOM 
                                </th>
                                <th style="text-align:center;">
                                    PRÉNOM 
                                </th>
                                <th style="text-align:center;">
                                    COURRIER ÉLECTRONIQUE 
                                </th>
                                <th style="text-align:center;">
                                    TÉLÉPHONE PORTABLE 
                                </th>
                                <th style="text-align:center;">
                                    TÉLÉPHONE FIXE 
                                </th>
                                <th style="text-align:center;">
                                    ADRESSE
                                </th>
                                <th style="text-align:center;">
                                    CODE POSTAL 
                                </th>
                                <th style="text-align:center;">
                                    VILLE 
                                </th>
                                <th style="text-align:center;">
                                    PAYS 
                                </th>
                       
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <script type="text/javascript">
                var tbl = document.getElementById("tbody");
                var html = '';
                for(var i = 0 ; i < suppliers.length; i++){
                    
                    html += '<tr>';
                        
                    html += '<td style="width:10%;text-align:center;border-top:1px dashed white;"><input name="id[]" style="width:100%;text-align:center;background-color:yellow;" type="text" value="' + suppliers[i].id + '"/></td>';
                    html += '<td style="text-align:left;border-top:1px dashed white;"><input name="company[]" style="width:100%;background-color:yellow;" type="text" value="' + suppliers[i].company + '"/></td>';
                    html += '<td style="text-align:left;border-top:1px dashed white;"><input name="first_name[]" style="width:100%;background-color:yellow;" type="text" value="' + suppliers[i].first_name + '"/></td>';
                    html += '<td style="text-align:left;border-top:1px dashed white;"><input name="last_name[]" style="width:100%;background-color:yellow;" type="text" value="' + suppliers[i].last_name + '"/></td>';
                    html += '<td style="text-align:left;border-top:1px dashed white;"><input name="email[]" style="width:100%;background-color:yellow;" type="text" value="' + suppliers[i].email + '"/></td>';
                    html += '<td style="text-align:left;border-top:1px dashed white;"><input name="mobile_phone[]" style="width:100%;background-color:yellow;" type="text" value="' + suppliers[i].mobile_phone + '"/></td>';
                    html += '<td style="text-align:left;border-top:1px dashed white;"><input name="fixed_phone[]" style="width:100%;background-color:yellow;" type="text" value="' + suppliers[i].fixed_phone + '"/></td>';
                    html += '<td style="text-align:left;border-top:1px dashed white;"><input name="address[]" style="width:100%;background-color:yellow;" type="text" value="' + suppliers[i].address + '"/></td>';
                    html += '<td style="text-align:left;border-top:1px dashed white;"><input name="zipcode[]" style="width:100%;background-color:yellow;" type="text" value="' + suppliers[i].zipcode + '"/></td>';
                    html += '<td style="text-align:left;border-top:1px dashed white;"><input name="city[]" style="width:100%;background-color:yellow;" type="text" value="' + suppliers[i].city + '"/></td>';
                    html += '<td style="text-align:left;border-top:1px dashed white;"><input name="country[]" style="width:100%;background-color:yellow;" type="text" value="' + suppliers[i].country + '"/></td>';
                    
                    html += '</tr>';
                }
                //alert( res[1] );
                tbl.innerHTML = html ;
            </script>
    </body>
</html>
