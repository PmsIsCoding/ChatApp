<?php
session_start();
require('dbConnect.php');
include('dbHandler.php');

$login = trim($_POST['login']);
$mdp = trim($_POST['mdp']);

$sql = "SELECT * FROM membre WHERE login = ?";

$array = array($login);

$result = dbGetter($sql,$array);
if(!$result){
    header('location:../index.php?error=1');
}
elseif($result[0]['mdp'] == $mdp){
    $sql = "SELECT nom,prenom FROM membre WHERE login = ?";
    $user = dbGetter($sql,$array);

    $sql = "SELECT url FROM photo WHERE login = ?";
    $userPhoto = dbGetter($sql,$array);

    $_SESSION['connected'] = true;
    $_SESSION['login'] = $login;
    $_SESSION['username'] = $user[0]['prenom']." ".$user[0]['nom'];
    $_SESSION['photo'] = $userPhoto[0]['url'];
    $_SESSION['photo'] = "pps/par_defaut.webp";
    if(!empty($userPhoto))
        $_SESSION['photo'] = $userPhoto[0]['url'];
    
    header('location:../index.php?page=home');
} 
elseif($result[0]['mdp'] != $mdp){
    header('location:../index.php?error=2');
}
  


?>