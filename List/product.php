<?php 
    require '../../command/includes/DbConnect.php';
    $dbConn = new DbConnect();
    $conn = $dbConn->connect();
    
    require '../../command/includes/Category.php';
    $CATE = new Category();
    $CATE->CreateTable();
    $Categories = $CATE->getAll();
    
    require '../../command/includes/Product.php';
    $PROD = new Product();
    $PROD->CreateTable();
    $Products = $PROD->getAll();
    $Groups = $PROD->getGroup();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
        <title>PRODUCT</title>
        <link rel="stylesheet" href="../css/generic_layout.css">
    </head>
    <body>
        <form method="POST">
            <!-- start ribbon bar -->
        <div style="width:100%;min-height:50px;border:1px solid white; border-radius:2px;">
            <table style="">
                <tr>
                    <td style="border:1px solid white;border-radius:2px;">
                        <p id="page_title" style="padding:10px 5px;">LISTE DES PRODUITS </p>
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
                    if($Products != null){
            ?>           
            <table style="border:1px solid white; width:100%; margin:10px 10px 10px 10px;">
               <thead>
                   <tr style="text-align:center;">
                       <th>
                           <input onClick="checkAll()" id="chkAll" name="chkAll" type="checkbox"/>
                       </th>
                       <th>
                           DÉSIGNATION
                       </th>
                       <th>
                           LIEN DE L'IMAGE 
                       </th>
                       <th>
                           PRIX
                       </th>
                       <th>
                           EN STOCK
                       </th>
                       <th>
                           DESCRIPTION
                       </th>
                       <th>
                           GROUPE
                       </th>
                       <th>
                           CATÉGORIE 
                       </th>
                   
                   </tr>
                </thead>
                <tbody>
                    <?php
                foreach($Products as $Product){
                    
                    echo '<tr>';
                        echo '<td style="text-align:center;border-top:1px dashed white;">';
                        echo '  <input name="chk_' . $Product['id'] . '" type="checkbox"/>';    
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo '  <input name="name_' . $Product['id'] . '" type="hidden" value="' . $Product['name'] . '"/><a href="OrderDetail.php?id=' . $Product['id'] . '" style="color:white;" >' . $Product['name'] . '</a>';
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo '  <input name="images_' . $Product['id'] . '" type="hidden" value="' . $Product['images'] . '"/>' . $Product['images'];
                        echo '</td>';
                        echo '<td style="text-align:center;border-top:1px dashed white;">';
                        echo '  <input name="price_' . $Product['id'] . '" type="hidden" value="' . $Product['price'] . '"/>' . $Product['price'] . ' ' .$Product['currency'];
                        echo '</td>';
                        echo '<td style="text-align:center;border-top:1px dashed white;">';
                        echo '  <input name="quantity_' . $Product['id'] . '" type="hidden" value="' . $Product['quantity'] . '"/>' . $Product['quantity'] . ' ' . $Product['unit'];
                        echo '</td>';
                        echo '<td style="text-align:left;border-top:1px dashed white;">';
                        echo '  <input name="description_' . $Product['id'] . '" type="hidden" value="' . $Product['description'] . '"/>' . $Product['description'] ;
                        echo '</td>';
                        if($Groups != null ){
                           foreach($Groups as $Group){
                              if($Product['group_id'] == $Group['id'] ){
                                 $group = $Group['name'];
                                 break;
                              }else {
                                 $group = '';
                              }
                           }
                        }else{
                           $group = '';
                        }
                        echo '<td style="text-align:groupe;border-top:1px dashed white;">';
                        echo '  <input name="group_' . $Product['id'] . '" type="hidden" value="' . $Product['group_id'] . '"/>' . $group ;
                        echo '</td>';
                        if($Categories != null ){
                           foreach($Categories as $Cate){
                              if($Product['categorie_id'] == $Cate['id'] ){
                                 $cate = $Cate['name'];
                                 break;
                              }else {
                                 $cate = '';
                              }
                           }
                        }else{
                           $cate = '';
                        }
                        echo '<td style="text-align:groupe;border-top:1px dashed white;">';
                        echo '  <input name="categorie_id_' . $Product['id'] . '" type="hidden" value="' . $Product['categorie_id'] . '"/>' . $cate ;
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
            //var_dump($Groups);
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
   var url = url.substring(0,url.lastIndexOf('/')-4) + 'DateEntry/Product.php';
   alert('Current URL​: '+ url);
   window.location.href = '../DateEntry/Product.php';
}
</script>
        </form>
    </body>
</html>
