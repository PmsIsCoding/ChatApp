<?php 
    session_start();
    include('../modeles/dbConnect.php');
    include('../modeles/dbHandler.php');

    $sql = "INSERT INTO `etre_amis`(`login_f`, `login_s`, `dateDebut`, `etat`) VALUES (?,?,?,?)";

    $etat = "actif";

    $current_date = date('Y-m-d');

    $array = array($_SESSION['login'],$_GET['loginEnv'],$current_date,$etat);
    
    dbSetter($sql,$array);

    $sql = "UPDATE `demande` SET `etat`= 'acceptée' WHERE login_env= ? AND login_rec= ?";
    $array = array($_GET['loginEnv'],$_SESSION['login']);

    dbSetter($sql,$array);

?>