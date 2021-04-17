<?php
    $dbusername = 'root';
    $dbpassword = 'root';
    $dbname = 'resto';
    
    $pdo = new PDO("mysql:host=0.0.0.0", $dbusername, $dbpassword); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $dbname = "`".str_replace("`","``",$dbname)."`"; 
    $pdo->query("CREATE DATABASE IF NOT EXISTS $dbname"); 
    $pdo->query("use $dbname");
?>