<?php
    
    //Getting the DbConnect.php file
    require '../backend/DbConnect.php';
    $dbConn = new DbConnect();
    $conn = $dbConn->connect();
            
    require '../backend/DataPages.php';
    $DP = new DataPages();
    $DP->CreateTable();
    
    if(isset($_POST['return'])){
       $url = '../List/DataPage.php';
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
           $result = $DP->DataEdit( $id, $_POST['page_id'], $_POST['title'], $_POST['url'], $_POST['menu']);
           
           if($result){
              $message = 'Edited';
              $dps = $DP->getByID( $_POST['id'] );
           }else {
              $message = 'Error';
           }
       }else {
           $result = $DP->DataEntry( $_POST['page_id'], $_POST['title'], $_POST['url'], $_POST['menu']);
           if($result){
              $message = 'Saved';
              $dps = $DP->getLast();
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
            var datapage = sessionStorage.getItem("datapage");
            sessionStorage.removeItem("datapage");
            if(datapage == null ){
              datapage =  <?php echo json_encode($dps) ; ?> ;
            }else {
              
              var str = datapage;
              var res = str.split(",");
              var datapage = {};
                  
              datapage.id = res[0];
              datapage.page_id = res[1];
              datapage.title = res[2];
              datapage.url = res[3];
              datapage.div_menu = res[4];
            }
                  
            //alert(datapage.id);
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
                                        <a style="margin-left:5%;text-decoration:none;color:white;text-align:right;" id="anchor_return" href="javascript:parent.datapage.navigateTo('DataPages',pages);" >
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
                        <th style="text-align:left;">PAGE ID</th>
                        <td style="width:80%;">
                            <input id="id" value="" name="id" placeholder="1" type="hidden" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                            <input id="page_id" value="" name="page_id" placeholder="Home" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                        </td>
                    </tr> 
                    <tr>
                        <th style="text-align:left;">TITRE </th>
                        <td style="width:80%;">
                            <input id="title" value="" name="title" placeholder="ACCUEIL" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">CHEMIN DU DOSSIER </th>
                        <td style="width:80%;">
                            <input id="url" value="" name="url" placeholder="home.php"  type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">MENU</th>
                        <td style="width:80%;">
                            <input id="div_menu" value="" name="menu" placeholder="block/none" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                        </td>
                    </tr> 
                </table>
            </div>
            <!-- end right side bar -->
            <?php //var_dump($DataPage); ?>
             <script type="text/javascript">
                 var id = document.getElementById("id");
                 id.value = datapage.id;
                 var page_id = document.getElementById("page_id");
                 page_id.value = datapage.page_id;
                 var title = document.getElementById("title");
                 title.value = datapage.title;
                 var url = document.getElementById("url");
                 url.value = datapage.url;
                 var div_menu = document.getElementById("div_menu");
                 div_menu.value = datapage.div_menu;
                 document.getElementById('page_title').innerHTML = datapage.title;
             </script>

        </div>
        </form>
    
    </body>
</html>
