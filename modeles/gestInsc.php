<?php

session_start();
require('dbConnect.php');
include('dbHandler.php');

///Enregistrement dans a table des membres

$login = $_POST['login'];
$mdp = $_POST['mdp'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$sel = 'non';

$sql = "INSERT INTO `membre`(`login`, `mdp`, `nom`, `prenom`, `statut_en_ligne`) VALUES (?,?,?,?,?)";

$array = array($login,$mdp,$nom,$prenom,$sel);

dbSetter($sql,$array);


///Enregistement du photos de profil
$destination = "pps/par_defaut.webp";
if(!empty($_FILES['photo']))
{
    $extensions_ok = array( 'jpg' , 'jpeg' , 'png', 'webp' );
    $extension=strtolower(substr(strrchr($_FILES['photo']['name'], '.') ,1));

    if($_FILES['photo']['error']==0 && in_array($extension,$extensions_ok)){
        $destination = "../views/pps/".$login."-".$_FILES['photo']['name'];
        $moved=move_uploaded_file($_FILES['photo']['tmp_name'],$destination);
    }
}

$sql= "INSERT INTO `photo`(`url`, `login`) VALUES (?,?)";
$array=array($destination,$login);
dbSetter($sql,$array);

$_SESSION['connected'] = true;
$_SESSION['login'] = $login;
$_SESSION['photo'] = "pps/".$login."-".$_FILES['photo']['name'];
$_SESSION['username'] = $prenom." ".$nom;
header('location:../index.php?page=home')
?>