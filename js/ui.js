function fieldType(field,fieldType,data,comboType,Value){
    //var fldType = 'text';
    switch(fieldType) {
      case "text":
        //alert("Value : " + Value );
        return inputType(field, fieldType, Value) ;
        break;
      case "password":
        //alert("password" + Value );
        return inputType(field, fieldType, Value ) ;
        break;
      case "textarea":
        return '<textarea id="' + field + '" name="' + field + '" rows="4" cols="50" style="padding-right:0px;width:100%;background-color:transparent;color:white;border:1px solid white;"></textarea>';
        break;
      case "select":
        if( comboType != 'Group'){
           //alert("Combo Type : " + comboType );
           return comboTypePerson(field,data,Value);
        }else{
           return comboTypeGroup(field,data,Value);
        }
        
        break;
      default:
        return   '<input value="" id="' + field + '" name="' + field + '" style="padding-right:0px;width:100%;background-color:transparent;color:white;border:1px solid white;" type="text"/>';
    
    }
     
}
function currentDate() {
    var today = new Date();  
    return today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
}
 
function currentTime() {
    var today = new Date();
    return today.getHours() + ":" + today.getMinutes() + ":"  + today.getSeconds() ;
}
        
function fieldName(name){
    name = name.replaceAll("_"," ");
    var cvName = name.toUpperCase();
    return cvName;
}

function inputType(field, fieldType, Val) {
    return '<input value="' + Val + '" id="' + field + '" name="' + field + '" style="padding-right:0px;width:100%;background-color:transparent;color:white;border:1px solid white;" type="' + fieldType + '"/>';

}    

function comboTypeGroup(field,table,val){
        
    //alert(table);
    var html = '';
    html += '<select name="' + field + '" id="' + field + '" style="padding-right:0px;width:100%;background-color:transparent;color:white;border:1px solid white;">';
    for(var n = 0; n < table.length ; n++){
        if( val == table[n].id ){
            html +=    '<option value="' + table[n].id + '" selected>' + table[n]["title"] + '</option>';
        }else {
            html +=    '<option value="' + table[n].id + '">' + table[n]["title"] + '</option>';
        }
    }
    html += '</select>';
    return html;
}

function comboTypePerson(field,table,val){
        
    //alert(table);
    var html = '';
    html += '<select name="' + field + '" id="' + field + '" style="padding-right:0px;width:100%;background-color:transparent;color:white;border:1px solid white;">';
    for(var n = 0; n < table.length ; n++){
        if( val == table[n].id ){
            html +=    '<option value="' + table[n].id + '" selected>' + table[n]["first_name"] + " " + table[n]["last_name"] + '</option>';
        }else {
            html +=    '<option value="' + table[n].id + '">' + table[n]["first_name"] + " " + table[n]["last_name"] + '</option>';
        }
    }
    html += '</select>';
    return html;
}

function tableName(field){
    var tableName =  field.substring(0,field.lastIndexOf('_') );
    tableName = capitalizeFirstLetter(tableName) ;
    return tableName;
}
        
function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}
        
function fieldName(name){
    name = name.replace("_"," ");
    var cvName = name.toUpperCase();
    return cvName;
}

function escapeSpecialCaseChar(text) { 
    return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, '\\$&');  
}

function sendData(title,data) {
    sessionStorage.setItem(title, data);
}

function sendDataArray(title,arrayData) {
    sessionStorage.setItem(title, JSON.stringify(arrayData));
}

function receiveData(title){
    return sessionStorage.getItem(title);
}

function reveiveDataArray(title){
    return JSON.parse(sessionStorage.getItem(title));
}

function removeData(title) {
    sessionStorage.removeItem(title);
}