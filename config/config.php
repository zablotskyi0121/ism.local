<?php
$server = "localhost";
$username = "root";
$password = "root";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try{
    $db_connection = new PDO("mysql:host=$server; dbname = Ism", $username, $password, $options);
    //echo 'Connection successfully';
    
} catch (PDOException $ex) {
    echo 'Connection failed: ' . $ex->getMessage();
}

?>