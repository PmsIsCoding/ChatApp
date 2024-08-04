<?php
    session_start();
    try{
        $bd=new PDO("mysql:host=localhost;dbname=messagerie","root","");
    }
    catch (PDOException $e) {
        throw new Exception("Database connection failed: " . $e->getMessage());
    }

    // $_SESSION['connected'] = false;

    if(!isset($_SESSION['connected']) || $_SESSION['connected'] != true){
        include("views/login.php");
    }
    elseif($_SESSION['connected'] == true){
        if(!empty($_GET['page']))
            header('location:views/'.$_GET['page'].".php");
        else
            include("views/login.php"); 
    }

    $bd = null;
?>