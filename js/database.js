function Dictionary(){
    var dic = {
       "Products" : { "title":{"type":"text","fr":"titre","en":"title"}, "price":{"type":"text","fr":"prix","en":"price"},"volume":{"type":"text","fr":"volume","en":"volume"}, "categories_id":{"type":"select","fr":"No Catégories","en":"categories_id"} },
       "Categories" : {"title":{"type":"text","fr":"titre","en":"title"}, "image":{"type":"text","fr":"Lien d\'image","en":"Image URL"}, "description":{"type":"textarea","fr":"description","en":"description"}},
       "Employees" : { "username":{"type":"text","fr":"Identifiant","en":"username"},"password":{"type":"password","fr":"Mot de passe","en":"password"},"first_name":{"type":"text","fr":"nom","en":"first_name"}, "last_name":{"type":"text","fr":"prénom","en":"last_name"}, "email":{"type":"text","fr":"e-mail","en":"e-mail"}, "telephone":{"fr":"téléphone","en":"telephone"}, "address":{"fr":"Addresse","en":"address"}, "code_postal":{"fr":"code postale","en":"code_postal"}, "city":{"fr":"ville","en":"city"}, "country":{"fr":"Pays","en":"country"}},
       "Customers" : { "username":{"type":"text","fr":"Identifiant","en":"username"},"password":{"type":"password","fr":"Mot de passe","en":"password"},"first_name":{"type":"text","fr":"nom","en":"first_name"}, "last_name":{"type":"text","fr":"prénom","en":"last_name"}, "email":{"type":"text","fr":"e-mail","en":"e-mail"}, "telephone":{"fr":"téléphone","en":"telephone"}, "address":{"fr":"Addresse","en":"address"}, "code_postal":{"fr":"code postale","en":"code_postal"}, "city":{"fr":"ville","en":"city"}, "country":{"fr":"Pays","en":"country"}},
       "CommandList" : { "table_nb":{"type":"text","fr":"Numéro de la Table","en":"Table Number"}, "deliveries_id":{"type":"select","fr":"Mode du livraison","en":"Deliveries Methods"}, "customer_id":{"type":"select","fr":"Nom du Client","en":"Customer Name"}, "command_no":{"type":"text","fr":"No de la commande","en":"Command No"}, "payment_id":{"type":"select","fr":"Mode du payement","en":"Payment Method"}, "payment_status_id":{"type":"select","fr":"Statut Du Payement","en":"Payment Status"}, "tva":{"type":"text","fr":"tva","en":"tva"}, "created_at":{"type":"date","fr":"Date Crée","en":"Created At"},"time_arrived":{"type":"text","fr":"Heures Arrivée","en":"Arrived Time"}},
       "ProductSoldDailyReport" : {"title":{"type":"text","fr":"titre","en":"title"},"started_date":{"type":"text","fr":"date commancée","en":"started date"},"ended_date":{"type":"text","fr":"Date Terminée","en":"ended date"}},
       "ProductSoldDailyDetailReport" : {"product_id":{"type":"select","fr":"Produit","en":"Product"},"quantity":{"type":"text","fr":"Quantité","en":"quantity"},"product_daily_report_list_id":{"type":"select","fr":"catégories","en":"categories"}},
       
    };
    return dic;
}

function DataPages(){
    var pages = [
       {"id":"0","page_id":"Login","title":"LOGIN","url":"login.html","div_menu":"block"},
       {"id":"1","page_id":"Dashboard","title":"ACCUEIL","url":"dashboard.php","div_menu":"block"},
       {"id":"2","page_id":"Product","title":"PRODUITS","url":"product.php","div_menu":"block"},
       {"id":"3","page_id":"Employee","title":"PERSONNELS","url":"employee.html","div_menu":"block"},
       {"id":"4","page_id":"AddEmployee","title":"NOUVEAU PERSONNEL","url":"employee_add.html","div_menu":"block"},
       {"id":"5","page_id":"Command","title":"COMMANDER","url":"OrderList.php","div_menu":"block"},
       {"id":"6","page_id":"Cuisine","title":"LISTE DES COMMANDES","url":"cuisine.html","div_menu":"block"},
       {"id":"7","page_id":"Cashier","title":"CASHIERS","url":"cashier.html","div_menu":"block"},
       {"id":"8","page_id":"Home","title":"ACCUEIL","url":"OrderList.php","div_menu":"block"},
       {"id":"9","page_id":"DailyReport","title":"RAPPORT JOURNAL DU VENT DES PRODUITS","url":"product_daily_report.html","div_menu":"block"},
       {"id":"10","page_id":"MonthlyReport","title":"RAPPORT MENSUEL DU VENT DES PRODUITS","url":"product_daily_report.html","div_menu":"block"},
       {"id":"11","page_id":"YearlyReport","title":"RAPPORT ANNUEL DU VENT DES PRODUITS","url":"product_daily_report.html","div_menu":"block"},
    ];
    return pages;
}

function Products_Daily_Sold_List (){
    var rawmaterial = [
       {"id":"0","title":"Lundi 23","started_date":"2020-11-23","ended_date":"2020-11-23"},
       {"id":"1","title":"Mardi 24","started_date":"2020-11-24","ended_date":"2020-11-24"},
       {"id":"2","title":"Mercredi 25","started_date":"2020-11-25","ended_date":"2020-11-25"},
       {"id":"3","title":"Jeudi 26","started_date":"2020-11-26","ended_date":"2020-11-26"},
       {"id":"4","title":"Vendredi 27","started_date":"2020-11-27","ended_date":"2020-11-27"},
       {"id":"5","title":"Samedi 28","started_date":"2020-11-28","ended_date":"2020-11-28"},
       {"id":"6","title":"Dimanche 29","started_date":"2020-11-29","ended_date":"2020-11-29"},

    ];
    return rawmaterial;
}

function Products_Daily_Sold_Detail (){
    var rawmaterial = [
       {"id":"0","product_id":"0", "quantity":"10", "product_daily_report_list_id":"0"},
       {"id":"1","product_id":"1", "quantity":"19", "product_daily_report_list_id":"0"},
       {"id":"2","product_id":"2", "quantity":"18", "product_daily_report_list_id":"0"},
       {"id":"3","product_id":"3", "quantity":"17", "product_daily_report_list_id":"0"},
       {"id":"4","product_id":"4", "quantity":"16", "product_daily_report_list_id":"0"},
       {"id":"5","product_id":"5", "quantity":"15", "product_daily_report_list_id":"0"},
    ];
    return rawmaterial;
}

function Command_List(){
    var command_list = [
        {"id":"0","table_nb":"","deliveries_id":"0","customer_id":"0","command_no":"CB00001","payment_id":"0","payment_status_id":"1","tva":"0.10","created_at":"11/11/2020","time_arrived":"19:00:10"},
        {"id":"1","table_nb":"","deliveries_id":"0","customer_id":"1","command_no":"CB00002","payment_id":"0","payment_status_id":"1","tva":"0.10","created_at":"11/11/2020","time_arrived":"19:05:10"},
        {"id":"2","table_nb":"","deliveries_id":"1","customer_id":"2","command_no":"CB00003","payment_id":"0","payment_status_id":"1","tva":"0.10","created_at":"11/11/2020","time_arrived":"19:10:10"},
        {"id":"3","table_nb":"2","deliveries_id":"1","customer_id":"3","command_no":"ESP0001","payment_id":"1","payment_status_id":"1","tva":"0.10","created_at":"11/11/2020","time_arrived":"19:10:10"},
        {"id":"4","table_nb":"1","deliveries_id":"1","customer_id":"4","command_no":"ESP0002","payment_id":"1","payment_status_id":"1","tva":"0.10","created_at":"11/11/2020","time_arrived":"19:15:10"}
    ];
    return command_list;
}

function Command_Detail() {
    var command_detail = [
        {"id":"0","product_id":"1","quantity":"2","price":"5.90", "cmd_list_id":"0"},
        {"id":"1","product_id":"2","quantity":"1","price":"5.90","cmd_list_id":"0"},
        {"id":"2","product_id":"3","quantity":"1","price":"5.90","cmd_list_id":"1"},
        {"id":"3","product_id":"1","quantity":"2","price":"5.90","cmd_list_id":"1"},
        {"id":"4","product_id":"5","quantity":"1","price":"5.90","cmd_list_id":"1"},
        {"id":"5","product_id":"3","quantity":"1","price":"5.90","cmd_list_id":"2"},
        {"id":"6","product_id":"1","quantity":"2","price":"5.90","cmd_list_id":"2"},
        {"id":"7","product_id":"5","quantity":"1","price":"5.90","cmd_list_id":"2"},
        {"id":"8","product_id":"3","quantity":"1","price":"5.90","cmd_list_id":"3"},
        {"id":"9","product_id":"1","quantity":"2","price":"5.90","cmd_list_id":"3"},
        {"id":"10","product_id":"5","quantity":"1","price":"5.90","cmd_list_id":"3"},
        {"id":"11","product_id":"3","quantity":"1","price":"5.90","cmd_list_id":"4"},
        {"id":"12","product_id":"1","quantity":"2","price":"5.90","cmd_list_id":"4"},
        {"id":"13","product_id":"5","quantity":"1","price":"5.90","cmd_list_id":"4"},
        {"id":"14","product_id":"3","quantity":"1","price":"5.90","cmd_list_id":"4"},
    ];
    
    return command_detail;
}

function Audit(){
    var audit = [
       {"id":"0","created_at":"20-11-2020,11,9,20","username":"sros","page_id":"0","menu":"none"}
    ];
       
    return audit;
}


function Users(){
    var users = [
        {"id":"0","username":"sros","password":"pwd","employee_id":"0"},
        {"id":"1","username":"qdd","password":"pwd","employee_id":"0"},
        {"id":"2","username":"thuc","password":"pwd","employee_id":"0"},
    ];
    
    return users;
}

function Employees(){
    var employees = [
        {"id":"0","username":"sros","password":"pwd","first_name":"PHANDARA","last_name":"Maly","email":"pmaly@domain.com","telephone":"0123456789","address":"20 rue d'Austerlitz","code_postal":"67000","city":"Strasbourg","country":"France"},
        {"id":"1","username":"qdd","password":"pwd","first_name":"DAVIES","last_name":"Virginie","email":"pmaly@domain.com","telephone":"0123456789","address":"20 rue d'Austerlitz","code_postal":"67000","city":"Strasbourg","country":"France"},
        {"id":"2","username":"thuc","password":"pwd","first_name":"DELECOLLE","last_name":"Delphine","email":"pmaly@domain.com","telephone":"0123456789","address":"20 rue d'Austerlitz","code_postal":"67000","city":"Strasbourg","country":"France"},
    
    ];
    return employees;
    //alert('App Working :' + employees[0].first_name );
}

//var emp = new Customers();
//alert("Customer :" + emp[1].first_name);
function Customers(){
    var customers = [
        {"id":"0","username":"sros","password":"pwd","first_name":"ROS","last_name":"Sopheaktra","email":"pmaly@domain.com","telephone":"0123456789","address":"20 rue d'Austerlitz","code_postal":"67000","city":"STRASBOURG"},
        {"id":"1","username":"qdd","password":"pwd","first_name":"SIMON","last_name":"Sopheaktra","email":"pmaly@domain.com","telephone":"0123456789","address":"20 rue d'Austerlitz","code_postal":"67000","city":"STRASBOURG"},
        {"id":"2","username":"thuc","password":"pwd","first_name":"PAUL","last_name":"Sopheaktra","email":"pmaly@domain.com","telephone":"0123456789","address":"20 rue d'Austerlitz","code_postal":"67000","city":"STRASBOURG"},
        {"id":"3","username":"sros","password":"pwd","first_name":"JEAN","last_name":"Sopheaktra","email":"pmaly@domain.com","telephone":"0123456789","address":"20 rue d'Austerlitz","code_postal":"67000","city":"STRASBOURG"},
        {"id":"4","username":"sros","password":"pwd","first_name":"JULIE","last_name":"Sopheaktra","email":"pmaly@domain.com","telephone":"0123456789","address":"20 rue d'Austerlitz","code_postal":"67000","city":"STRASBOURG"},
    ];
    
    return customers;
}

function PaymentStatus() {
    var mode = [
       {"id":"0","title":"Non Payé"},
       {"id":"1","title":"Payé"},
    ];
    
    return mode ;
}

function PaymentMethod() {
    var mode = [
       {"id":"0","title":"Card Bancaire","prefix":"CB"},
       {"id":"1","title":"Liquide","prefix":"ESP"},
    ];
    
    return mode ;
}

function DeliveriesMethod() {
    var mode = [
       {"id":"0","title":"En Ligne"},
       {"id":"1","title":"Sur Place"},
       {"id":"2","title":"À Emporter"},

    ];
    
    return mode ;
}


function Products(){
    var products = [
        {
          "id":"0",
          "title": "1 sirop à l’eau",
          "price": "5.90",
          "volume":"",
          "categories_id": "0",
        },

        {
          "id":"1",
          "title": "1/2 pizza au jambon blanc",
          "price":"5.90",
          "volume":"",
          "categories_id": "0",
        },

        {
          "id":"2",
          "title": "1/2 spaghetti aux polpettes de boeuf",
          "price":"5.90",
          "volume":"",
          "categories_id": "0",
        },

        {
          "id":"3",
          "title": "L'émincé de poulet sauce crème champignons, frites",
          "price":"5.90",
          "volume":"",
          "categories_id": "0",
        },

        {
          "id":"4",
          "title": "2 boules de glace au choix",
          "price":"5.90",
          "volume":"",
          "categories_id": "0",
       },

       {
          "id":"5", 
          "title":"LA MOZZARELLA DI BUFFALA",
          "price":"8.90",
          "volume":"",
          "categories_id": "1",
       },
    
       {
          "id":"6", 
          "title":"ASSIETTE PARME OU BRESAOLA Accompagné de sa pizza blanche",
          "price":"8.90",
          "volume":"",
          "categories_id": "2",
       },
       {
          "id":"7", 
          "title":"Bresaola, mozzarella di buffala, tomates sechées, salade",
          "price":"8.90",
          "volume":"",
          "categories_id": "3",
       },
       {
          "id":"8", 
          "title":"3 FROMAGES : Fromage de chèvre, gorgonzola, fromage à pizza",
          "price":"8.90",
          "volume":"",
          "categories_id": "4",
       },
       {
          "id":"9", 
          "title":"GNOCCHIS AUX FROMAGES ",
          "price":"13.90",
          "volume":"",
          "categories_id": "5",
       },
       {
          "id":"10", 
          "title":"GNOCCHIS AUX FROMAGES ",
          "price":"13.90",
          "volume":"",
          "categories_id": "6",
       },
       {
          "id":"11", 
          "title":"ENTRECÔTE A L'ITALIENNE : Tomates cerises, roquette, Grana AOP, huile d\'olive ",
          "price":"20.90",
          "volume":"",
          "categories_id": "7",
       },
       {
          "id":"12", 
          "title":"CORDON BLEU : Sauce crème, champignons frais. ",
          "price":"20.90",
          "volume":"",
          "categories_id": "8",
       },
       {
          "id":"13", 
          "title":"CORDON BLEU DE POULET : Sauce crème, champignons de Paris.\(si sans jambon le préciser à la commande\) ",
          "price":"20.90",
          "volume":"",
          "categories_id": "9",
       },
       {
          "id":"14", 
          "title":"LES PROFITEROLES: 3 choux garnis de glace vanille bourbon de Madagascar, nappage chocolat chaud maison, chantilly ",
          "price":"8.00",
          "volume":"",
          "categories_id": "10",
       },
       {
          "id":"15", 
          "title":"AMERICANO BAR",
          "price":"8.00",
          "volume":"33cl",
          "categories_id": "11",
       },
       {
          "id":"16", 
          "title":"COCA : Normal, Zéro",
          "price":"8.00",
          "volume":"6cl",
          "categories_id": "12",
       },
       {
          "id":"17", 
          "title":"SUPPLÉMENT DE SAUCE",
          "price":"8.00",
          "volume":"",
          "categories_id": "13",
       },
    ];
    
    return products;
}

function Categories(){
    var categories = [
       {"id":"0","title":"MENU ENFANTS","image":"images/enfants.png","description":"MENU D'ENFANTS - 10 ANS"},
       {"id":"1","title":"NOS ANTIPASTI","image":"images/antipasti.png","description":""},
       {"id":"2","title":"NOS CHARCUTERIES","image":"images/charcuterie.png","description":""},
       {"id":"3","title":"NOS SALADES","image":"images/salade.png","description":"Envie d'une salade mais aussi d'une pizza ?<br/>On a la solution !<br\/>La formule Pizzalade une ½ pizza et une ½ salade.<br\/>Partagez la même pizza et la même salade de votre choix<br\/>\(sauf salade verte et pizza calzone\)"},
       {"id":"4","title":"NOS PIZZAS","image":"","description":"Toutes les pizzas sont garnies de sauce tomate et de fromage à pizza.<br\/>🔴 Tout supplément éventuel sera facturé 1€ sauf scampis, st-jacques, bresaola, parme et saumon 4€. 🔴"},
       {"id":"5","title":"NOS PÂTES","image":"images/pates.png","description":""},
       {"id":"6","title":"NOS POISSONS ET CRUSTACÉS","image":"images/antipasti.png","description":"NOS POISSONS ET CRUSTACÉS"},
       {"id":"7","title":"NOS BŒUFS","image":"images/boeuf.png","description":"Les viandes sont préparées et cuites au moment de votre commande, donc si vous êtes pressés \(surtout le midi\) orientez votre choix vers un autre plat de la carte. Merci de votre compréhension. 1 garniture au choix: frites, pâtes, salade ou légumes frais \(à indiquer dans le commentaire\)"},
       {"id":"8","title":"NOS VEAUX","image":"images/veau.png","description":""},
       {"id":"9","title":"NOS VOLAILLES(HALAL)","image":"images/volaille.png","description":""},
       {"id":"10","title":"NOS DESSERTS","image":"images/dessert.png","description":""},
       {"id":"11","title":"NOS BOISSONS ALCOOLISÉES","image":"images/cognac.png","description":""},
       {"id":"12","title":"NOS BOISSONS SANS ALCOOL","image":"images/boisson.png","description":""},
       {"id":"13","title":"SUPPLÉMENTS","image":"","description":""},

    ];
    
    return categories;
}



