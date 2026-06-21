<?php
 // connection paramters and databse informations
$host = 'localhost';
$dbname ='eglise_db'; // eglise_db  or banquecentral
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$dbname";

 // attempt to connect to the database
try{
    $pdo = new PDO($dsn,$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
echo "Error : " . $e->getMessage();
}
?>