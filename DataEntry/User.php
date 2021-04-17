<?php
    
    //Getting the DbConnect.php file
    require '../backend/DbConnect.php';
    $dbConn = new DbConnect();
    $conn = $dbConn->connect();
            
    require '../backend/Users.php';
    $Usr = new Users();
    $Usr->CreateTable();
    
    require '../backend/Employees.php';
    $Emp = new Employees();
    $Emp->CreateTable();
    
?>
<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
        <title id="title"> NOUVEAU UTILISATEUR </title>
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
                                            <img style="padding:5%;" src="../images/png32/backtolist.png" />
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
                        <th style="text-align:left;">NOM ET PRÉNOM </th>
                        <td style="width:80%;">
                            <input id="id" value="" name="id" placeholder="1" type="hidden" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                            <select id="cboEmployee" name="cboEmployee"" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"></select>
                        </td>
                    </tr> 
                    <tr>
                        <th style="text-align:left;">IDENTIFIANT </th>
                        <td style="width:80%;">
                            <input id="title" value="" name="username" placeholder="sros" type="text" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;"> MOT DE PASSE </th>
                        <td style="width:80%;">
                            <input id="url" value="" name="password" placeholder="Min. 6 caractères" minlength="6"  type="password" style="height:100%;width:100%;background:transparent;border:1px solid white;background-color:lightgray;"/>
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
