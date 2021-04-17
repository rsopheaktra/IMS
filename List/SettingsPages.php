<?php
    //Getting the DbConnect.php file
    require '../backend/DbConnect.php';
    $dbConn = new DbConnect();
    $conn = $dbConn->connect();
            
    require '../backend/Users.php';
    $Us = new Users();
    $Us->CreateTable();
    $Users = $Us->getAll();
    
    require '../backend/DataPages.php';
    $DPs = new DataPages();
    $DPs->CreateTable();
    $DataPages = $DPs->getAll();
    
    require '../backend/PagesSettings.php';
    $PS = new PagesSettings();
    $PS->CreateTable();
    
?>    
<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
        <title id="title"> UTILISATEURS </title>
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
                            <p id="page_title" style="padding:10px 5px;"> PARAMÈTRES </p>
                        </td>
                        <td style="border:1px solid white;border-radius:2px;">
                            <table style="height:100px;width:100%;">
                                <tr >
                                    <td style="text-align:center;">
                                        <!--input name="add_new" onclick="addNew();" type="submit" style="border:none;width:100%;height:100%;background:url('../images/png32/Add.png') no-repeat 50% 20%; color:white;text-align:center;padding-top:80%;" alt="Add" value="Nouveau"/><br/-->
                                        <a style="text-decoration:none;color:white;width:100%;height:100%;text-align:center;" id="anchor_add_new" href="javascript:parent.datapage.navigateTo('AddUser',pages);" >
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
                    if($Users != null){
            ?>           
            <table style="border:1px solid white; width:100%; margin:10px 10px 10px 10px;">
               <thead>
                   <tr style="text-align:center;">
                       <th>
                           <input onClick="checkAll()" id="chkAll" name="chkAll" type="checkbox" value="chkAll"/>
                       </th>
                       <th>
                           IDENTIFIANT
                       </th>
                       <th>
                           MOT DE PASS
                       </th>
                       <th>
                           ID PERSONNEL
                       </th>
                       
                   </tr>
                </thead>
                <tbody>
                    <?php
                foreach($Users as $user){

                    if($dp['div_menu'] == 'block'){
                       $menu_status = 'Show';
                    }else{
                       $menu_status = 'none';
                    }

                    echo '<tr>';
                        echo '<td style="text-align:center;border-top:1px dashed white;">';
                        echo '  <input id="chk" name="chk_' . $user['id'] . '" type="checkbox" value="' . $user['id'] . ',' .$user['username'] .','. $user['password'] .','. $dp['employee_id'] .'"/>';    
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo '  <input name="username_' . $user['id'] . '" type="hidden" value="' . $user['id'] . '"/><a href="User.php?id=' . $user['id'] . '" style="color:white;" >' . $user['username'] . '</a>';
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo '  <input name="password_' . $user['id'] . '" type="hidden" value="' . $user['password'] . '"/>' . $user['password'];
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo '  <input name="employee_id_' . $user['id'] . '" type="hidden" value="' . $user['employee_id'] . '"/>' . $dp['employee_id'];
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
        parent.datapage.navigateTo('AddMultiPage',pages);
    }
    //location.replace = 'dashboard.php';
    
 }
</script>
            
    </body>
</html>
