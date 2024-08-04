<?php 

try{
    $bd=new PDO("mysql:host=localhost;dbname=messagerie","root","");
}
catch (PDOException $e) {
    throw new Exception("Database connection failed: " . $e->getMessage());
}