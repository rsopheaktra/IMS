<?php
    
    //Getting the DbConnect.php file
    require '../backend/DbConnect.php';
    $dbConn = new DbConnect();
    $conn = $dbConn->connect();
            
    require '../backend/Shippers.php';
    $SUP = new Shippers();
    $SUP->CreateTable();
    
    if(isset($_POST['return'])){
       $url = '../List/Suppliers.php';
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
           $result = $SUP->DataEdit( $id, $_POST['company'], $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['mobile_phone'], $_POST['fixed_phone'], $_POST['address'], $_POST['zipcode'], $_POST['city'] , $_POST['country'] );
           
           if($result){
              $message = 'Edited';
              $sup = $SUP->getByID( $_POST['id'] );
           }else {
              $message = 'Error';
           }
       }else {
           $result = $SUP->DataEntry( $_POST['company'], $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['mobile_phone'], $_POST['fixed_phone'], $_POST['address'], $_POST['zipcode'], $_POST['city'] , $_POST['country'] );
           if($result){
              $message = 'Saved';
              $sup = $SUP->getLast();
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
            //alert(supplier);
            
            if(suppliers == null ){
              supplier =  <?php echo json_encode($sup) ; ?> ;
            }else {
              
              var str = suppliers;
              var res = str.split(",");
              var supplier = {};
                  
              supplier.id = res[0];
              supplier.company = res[1];
              supplier.first_name = res[2];
              supplier.last_name = res[3];
              supplier.email = res[4];
              supplier.mobile_phone = res[5];
              supplier.fixed_phone = res[6];
              supplier.address = res[7];
              supplier.zipcode = res[8];
              supplier.city = res[9];
              supplier.country = res[10];
            }
                  
            alert(supplier.id);
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
                        <th style="text-align:left;">NOM DE L'ENTREPRISE </th>
                        <td style="width:70%;">
                            <input id="id" value="" name="id" placeholder="1" type="hidden" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                            <input id="company" value="" name="company" placeholder="VWR" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;" required="true" />
                        </td>
                    </tr> 
                    <tr>
                        <th style="text-align:left;">NOM </th>
                        <td style="width:70%;">
                            <input id="first_name" value="" name="first_name" placeholder="ROS" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;" required="true"/>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> PRÉNOM </th>
                        <td style="width:70%;">
                            <input id="last_name" value="" name="last_name" placeholder="Sopheaktra"  type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;" required="true"/>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> COURRIER ÉLECTRONIQUE </th>
                        <td style="width:70%;">
                            <input id="email" value="" name="email" placeholder="rsopheaktra@gmail.com" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;" required="true"/>
                        </td>
                    </tr> 
                    <tr>
                        <th style="text-align:left;"> NUMÉRO DU TÉLÉPHONE </th>
                        <td style="width:70%;">
                            <input id="mobile_phone" value="" name="mobile_phone" placeholder="0768813758" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;" required="true"/>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> TÉLÉPHONE FIXE </th>
                        <td style="width:70%;">
                            <input id="fixed_phone" value="" name="fixed_phone" placeholder="" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> ADDRESS </th>
                        <td style="width:70%;">
                            <input id="address" value="" name="address" placeholder="20 rue d'Austerlitz" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> CODE POSTAL </th>
                        <td style="width:70%;">
                            <input id="zipcode" value="" name="zipcode" placeholder="67000" type="number" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> VILLE </th>
                        <td style="width:70%;">
                            <input id="city" value="" name="city" placeholder="Strasbourg" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> PAYS </th>
                        <td style="width:70%;">
                            <input id="country" value="" name="country" placeholder="0768813758" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- end right side bar -->
            <?php //var_dump($DataPage); ?>
             <script type="text/javascript">
                 var id = document.getElementById("id");
                 id.value = supplier.id;
                 var company = document.getElementById("company");
                 company.value = supplier.company;
                 var first_name = document.getElementById("first_name");
                 first_name.value = supplier.first_name;
                 var last_name = document.getElementById("last_name");
                 last_name.value = supplier.last_name;
                 var email = document.getElementById("email");
                 email.value = supplier.email;
                 var mobile_phone = document.getElementById("mobile_phone");
                 mobile_phone.value = supplier.mobile_phone;
                 var fixed_phone = document.getElementById("fixed_phone");
                 fixed_phone.value = supplier.fixed_phone;
                 var address = document.getElementById("address");
                 address.value = supplier.address;
                 var zipcode = document.getElementById("zipcode");
                 zipcode.value = supplier.zipcode;
                 var city = document.getElementById("city");
                 city.value = supplier.city;
                 var country = document.getElementById("country");
                 country.value = supplier.country;
                 
                 document.getElementById('page_title').innerHTML = datapage.title;
             </script>

        </div>
        </form>
    
    </body>
</html>
