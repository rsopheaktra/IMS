<?php
    /* refresh every 10 seconds */
    header( "refresh:10;url=OrderList.php" );
    
    require '../../command/includes/DbConnect.php';
    $dbConn = new DbConnect();
    $conn = $dbConn->connect();
    
    require '../../command/includes/OrderList.php';
    $OL = new OrderList();
    $OL->CreateTable();
    $OrderLists = $OL->getAllOrderList();
    
    if(isset($_POST['prepa'])){
       foreach($OrderLists as $ol){
          //echo 'ID : ' . $ol['id'];
          if(isset( $_POST['chk_' . $ol['id'] ])){
             //echo 'ID : ' . $ol['id'];
             $OL->DataEdit($ol['id'], $_POST['created_date_' . $ol['id'] ],$_POST['created_time_' . $ol['id'] ], $_POST['customer_id_' . $ol['id'] ], $_POST['name_' . $ol['id'] ],1,0);
          }
       }
       $OrderLists = $OL->getAllOrderList();
    }

    if(isset($_POST['delivered'])){
       foreach($OrderLists as $ol){
          //echo 'ID : ' . $ol['id'];
          if(isset( $_POST['chk_' . $ol['id'] ])){
             //echo 'ID : ' . $ol['id'];
             $OL->DataEdit($ol['id'], $_POST['created_date_' . $ol['id'] ],$_POST['created_time_' . $ol['id'] ], $_POST['customer_id_' . $ol['id'] ], $_POST['name_' . $ol['id'] ],$_POST['preparation_' . $ol['id'] ],1);
          }
       }
       $OrderLists = $OL->getAllOrderList();
    }

    if(isset($_POST['btnSearch'])){
       $OrderLists = $OL->getByName($_POST['txtSearch']);
    }
?>
<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
        <title> ORDER LIST </title>
        <link rel="stylesheet" href="../css/generic_layout.css">
    </head>
    <body>
        <form method="POST">
        <!-- start ribbon bar -->
        <div style="width:100%;min-height:50px;border:1px solid white; border-radius:2px;">
            <table style="">
                <tr>
                    <td style="border:1px solid white;border-radius:2px;">
                        <p id="page_title" style="padding:10px 5px;">LISTE DES COMMANDES </p>
                    </td>
                    <td style="border:1px solid white;border-radius:2px;">
                        <table style="height:100px;width:100%;">
                            <tr >
                                <td style="">
                                    <input onclick="addNew();" type="button" style="border:none;width:100%;height:100%;background:url('../images/png32/Add.png') no-repeat 50% 20%; color:white;text-align:center;padding-top:80%;" alt="Add" value="Nouveau"/><br/>
                                </td>
                                <td style="padding-top:0px">
                                    <input type="submit" style="border:none;width:100%;height:40%;background:url('../images/png32/Edit.png') no-repeat 20% 50%; color:white;text-align:right;padding-left:50px;" alt="Edit" value="Modifier"/><br/>
                                    <input name="delete" type="submit" style="border:none;width:100%;height:40%;background:url('../images/png/Delete.png') no-repeat 20% 50%; color:white;text-align:right;padding-left:50px;" alt="Delete" value="Supprimer"/><br/>

                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="border:1px solid white;border-radius:2px;">
                        <input name="prepa"  type="submit" style="border:none;width:100%;height:100%;background:url('../images/png/couverts.png') no-repeat 50% 20%; color:white;text-align:center;padding-top:80%;" alt="Add" value="Service"/><br/>
                    </td>
                    <td style="border:1px solid white;border-radius:2px;">
                        <input name="delivered"  type="submit" style="border:none;width:100%;height:100%;background:url('../images/png32/payment-icon-5655_32x32.png') no-repeat 50% 20%; color:white;text-align:center;padding-top:80%;" alt="Add" value="Payement"/><br/>
                    </td>
                </tr>
            </table>
        </div>
        <!-- end ribbon bar -->
        
        <!-- start left side bar -->
        <div style="margin-top:10px;float:left;overflow:auto;width:20%; height:60vh; border-radius:2px 0px 0px 2px;border:1px solid white;">
            <p style="border-bottom:1px dashed white;">Barre de recherche : </p>
            <div style="">
                <input name="txtSearch" id="myInput" onkeyup="myFunction();" style="width:85%;color:white;background-color:transparent;margin-left:5px; border-radius: 5px 0px 0px 5px;" placeholder="Numéro de la commande" type="text"/>
                <button name="btnSearch" style="background:transparent;float:right;text-align:center;width:26px;height:22px;border:1px solid white;margin-top:-22px; border-radius:0px 5px 5px 0px; margin-right:0px;" type="submit" ><img style="width:18px;height:18px;margin-right:28px;padding:1%;" src="../images/search-icon-windows-phone_249467.png"/> </button>
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
                    if($OrderLists != null){
            ?>           
            <table style="border:1px solid white; width:100%; margin:10px 10px 10px 10px;">
               <thead>
                   <tr style="text-align:center;">
                       <th>
                           <input onClick="checkAll()" id="chkAll" name="chkAll" type="checkbox"/>
                       </th>
                       <th>
                           No. DE LA COMMANDE
                       </th>
                       <th>
                           DATE CRÉÉE
                       </th>
                       <th>
                           HEURES CRÉÉE
                       </th>
                       <th>
                           PRÉPARATION
                       </th>
                       <th>
                           CLIENT
                       </th>
                   </tr>
                </thead>
                <tbody>
                    <?php
                foreach($OrderLists as $OL){
                    if($OL['customer_id']){
                     
                    }else{

                    }

                    if($OL['preparation'] == 0){
                       $prepa_status = 'En cours';
                    }else{
                       $prepa_status = 'Terminé';
                    }

                    if($OL['delivered'] == 0){
                       $delivered_status = 'En cours';
                    }else{
                       $delivered_status = 'Terminé';
                    }

                    echo '<tr>';
                        echo '<td style="text-align:center;border-top:1px dashed white;">';
                        echo '  <input name="chk_' . $OL['id'] . '" type="checkbox"/>';    
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo '  <input name="name_' . $OL['id'] . '" type="hidden" value="' . $OL['name'] . '"/><a href="OrderDetail.php?id=' . $OL['id'] . '" style="color:white;" >' . $OL['name'] . '</a>';
                        echo '</td>';
                        echo '<td style="text-align:center;border-top:1px dashed white;">';
                        echo '  <input name="created_date_' . $OL['id'] . '" type="hidden" value="' . $OL['created_date'] . '"/>' . $OL['created_date'];
                        echo '</td>';
                        echo '<td style="text-align:center;border-top:1px dashed white;">';
                        echo '  <input name="created_time_' . $OL['id'] . '" type="hidden" value="' . $OL['created_time'] . '"/>' . $OL['created_time'];
                        echo '</td>';
                        echo '<td style="text-align:center;border-top:1px dashed white;">';
                        echo '  <input name="preparation_' . $OL['id'] . '" type="hidden" value="' . $OL['preparation'] . '"/>' . $prepa_status;
                        echo '</td>';
                        echo '<td style="text-align:center;border-top:1px dashed white;">';
                        echo '  <input name="customer_id_' . $OL['id'] . '" type="hidden" value="' . $OL['customer_id'] . '"/>' . $OL['customer_id'] ;
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
             
function addNew(){
   var url = window.location.pathname;
   var url = url.substring(0,url.lastIndexOf('/')+1) + 'OrderDetail.php';
   alert('Current URL​: '+ url);
   location.href = url;
}
</script>
             
    </body>
</html>
