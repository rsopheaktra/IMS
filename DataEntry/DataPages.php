<?php
    
    //Getting the DbConnect.php file
    require '../backend/DbConnect.php';
    $dbConn = new DbConnect();
    $conn = $dbConn->connect();
            
    require '../backend/DataPages.php';
    $DP = new DataPages();
    $DP->CreateTable();
    
    if(isset($_POST['save'])){
       if(isset( $_POST["id"] )){
          $count = count($_POST["id"]);
       }else{
          $count = 0;
       }
       $dps =array();
       for($i=0;$i<$count;$i++){
           $result = $DP->DataEdit( $_POST['id'][$i], $_POST['page_id'][$i], $_POST['title'][$i], $_POST['url'][$i], $_POST['div_menu'][$i]);
           $dp = $DP->getByID( $_POST['id'][$i]);
           if($result){
              $message = 'Updated';
              array_push($dps,$dp);
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
        <title>NOUVELLES PAGES</title>
        <link rel="stylesheet" href="../css/generic_layout.css">
        <script src="../js/jquery-1.7.2.js"></script>
        <script type="text/javascript">
            //alert(parent.pages[1]['page_id']);
            var pages = parent.pages;
            /* get data from session in forms array */
            var datapage = JSON.parse(sessionStorage.getItem("datapage") );
            sessionStorage.removeItem("datapage");
            //alert( datapage );
            if(datapage == null ){
              datapage =  <?php echo json_encode($dps) ; ?> ;
            }else {
              var dps = [];
              for(var i = 0 ; i < datapage.length; i++){
                  var str = datapage[i];
                  var res = str.split(",");
                  var dp = {};
                  
                  dp.id = res[0];
                  dp.page_id = res[1];
                  dp.title = res[2];
                  dp.url = res[3];
                  dp.div_menu = res[4];
                  dps.push(dp);
              }
              datapage = dps;
            }
            alert( datapage );

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
                <div>
                    <table style="border:1px solid white; width:100%; margin:10px 10px 10px 10px;">
                        <thead>
                            <tr>
                                <th style="width:32px;">
                                    ID
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
                                <th style="width:50px;">
                                    MENU
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
                for(var i = 0 ; i < datapage.length; i++){
                    
                    html += '<tr>';
                        
                    html += '<td style="width:10%;text-align:center;border-top:1px dashed white;"><input name="id[]" style="width:100%;text-align:center;background-color:yellow;" type="text" value="' + datapage[i].id + '"/></td>';
                    html += '<td style="text-align:center;border-top:1px dashed white;"><input name="page_id[]" style="width:100%;background-color:yellow;" type="text" value="' + datapage[i].page_id + '"/></td>';
                    html += '<td style="text-align:center;border-top:1px dashed white;"><input name="title[]" style="width:100%;background-color:yellow;" type="text" value="' + datapage[i].title + '"/></td>';
                    html += '<td style="text-align:center;border-top:1px dashed white;"><input name="url[]" style="width:100%;background-color:yellow;" type="text" value="' + datapage[i].url + '"/></td>';
                    html += '<td style="width:10%;text-align:center;border-top:1px dashed white;"><input name="div_menu[]" style="width:100%;background-color:yellow;" type="text" value="' + datapage[i].div_menu + '"/></td>';
                    
                    html += '</tr>';
                }
                //alert( res[1] );
                tbl.innerHTML = html ;
            </script>
    </body>
</html>
