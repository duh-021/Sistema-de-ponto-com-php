<?php
$host = "localhost";
$user = "root";
$senha = "";
$dbname="ponto";
$port = "3306";

try{
    $conecta_db = new PDO("mysql:host=$host;dbname=". $dbname, $user, $senha);
    //echo "ok";
}catch (PDOException $err){
    echo "A CASA CAIU CHEFE" . $err->getMessage();
}
?>