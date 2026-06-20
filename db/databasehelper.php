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

    $sql = "SELECT * FROM EGLISE";
    $result = $pdo->prepare($sql);
    $result->execute();
    
    $row = $result->fetchAll(PDO::FETCH_ASSOC);
   echo  json_encode($row);
}
catch(PDOException $e){
echo "Error : " . $e->getMessage();
}
?>