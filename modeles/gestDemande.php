<?php 
    session_start();
    include('../modeles/dbConnect.php');
    include('../modeles/dbHandler.php');

    $sql = "INSERT INTO `demande`(`dateDmd`, `etat`, `login_env`, `login_rec`) VALUES (:dateDmd,:etat,:login_env,:login_rec)";

    $etat = "en attente";

    $stmt = $bd->prepare($sql);

    $current_date = date('Y-m-d H:i:s');

    $stmt->bindParam('dateDmd',$current_date);

    $stmt->bindParam(':etat',$etat);

    $stmt->bindParam(':login_env',$_SESSION['login']);

    $stmt->bindParam(':login_rec',$_GET['loginTarget']);

    $stmt->execute();

?>