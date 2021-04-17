function AppCore(){
    
       
    this.login = function(user,pwd,users){
         //alert("User : " + user +"\r\nPassword : " + pwd);
         for(var i = 0; i < users.length ; i++){
            //alert("User : " + user +"\r\nPassword : " + pwd + "\r\nNb Users : " + users[i].username );
            if(user == users[i].username && pwd == users[i].password ){
                //alert("Login Page");
                return true;
            }else{
                //alert("The Username or Password is not matched, please try again !");
                return false;
            }
            
         }
    
    }
       
    this.navigateTo = function(id,dataPage){
        //alert("Working" + dataPage[1].page_id );
        var title = '';
        var div_menu = '';
        var url = '';
        for(var i = 0; i < dataPage.length ; i++){
            //alert('Url in loop : ' + dataPage[i]['url']);
            if(id == dataPage[i]['page_id']){
                title = dataPage[i]['title'] ;
                div_menu = dataPage[i]['div_menu'] ;
                url = dataPage[i]['url'] ;
            }
        }
        //alert('URL​: ' + url );
        document.getElementById('iframe_main').src = url ;
        //reload to get cookies 
        location.reload(true);
        /* Store Url when user refresh page and Load function will called */
        sessionStorage.setItem("title", title);
        sessionStorage.setItem("divMenu", div_menu );
        sessionStorage.setItem("url", url );

    }
       
    this.GetFileName = function(){
        var url = window.location.pathname;
        var filename = url.substring( url.lastIndexOf('/')+1 );
        return filename;
    }
    
    this.GetCurrentPath = function(){
        var url = window.location.pathname;
        //alert(url.substring(0,url.lastIndexOf('/')+1) );
        return url.substring(0,url.lastIndexOf('/')+1 );
    }
    
    this.Load = function(){
        //var divMenu = document.getElementById('menu');
        //alert("Load function " + sessionStorage.getItem("divMenu"));
        
        var menu = sessionStorage.getItem("divMenu");
        var title = sessionStorage.getItem("title");
        var url = sessionStorage.getItem("url");
        var currentURL = sessionStorage.getItem("currenturl");
        
        //remove sessionStorage to change code
        //sessionStorage.removeItem("divMenu");
        //sessionStorage.removeItem("title");
        //sessionStorage.removeItem("url");
        //sessionStorage.removeItem("currenturl");
        
        document.getElementById('title').innerHTML = title;
        
        if( menu == "none") {
            document.getElementById('menu').style.display = menu;
            document.getElementById('btnShow').style.display = 'block';
            document.getElementById('btnHide').style.display = 'none';
        } else {
            document.getElementById('menu').style.display = 'block';
            document.getElementById('btnShow').style.display = 'none';
            document.getElementById('btnHide').style.display = 'block';
        
        }
        
        //alert("Next URL : " + url + "\r\nLast URL : " + currentURL );
        //Prévention quand on quitte .
        if(url == "login.php"){
            location.href = this.GetCurrentPath() + url ;
            sessionStorage.removeItem("divMenu");
            sessionStorage.removeItem("title");
            sessionStorage.removeItem("url");
            sessionStorage.removeItem("currenturl");
            sessionStorage.removeItem("command_list_id");
             
            sessionStorage.clear();
        }
    
        /* when user refresh url = none */
        if( url == null){
            url = sessionStorage.getItem("url");
            //alert('url: ' + url);
            if(url == null ){
               url = 'List/home.php';
               document.getElementById('iframe_main').src = 'List/home.php' ;
            }
            alert('url: ' + url);
            currentURL = 'dashboard.php';
            document.getElementById('title').innerHTML = title;
            
        }
    
        if(url == ''){
           document.getElementById('iframe_main').src = 'List/home.php' ;
        }

        if(currentURL != "login.php" && url != "dashboard.php"){
            document.getElementById('iframe_main').src = this.GetCurrentPath() + url;
        }
        
        alert('URL​: ' + url);
        
    }
    //return pages;
}

