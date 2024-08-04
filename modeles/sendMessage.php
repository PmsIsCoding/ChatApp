<?php
    session_start();
    include('dbConnect.php');
    include('dbHandler.php');

    $message = $_POST['message'];
    $destination = $_POST['destination'];


    $sql = 'SELECT * FROM `discussion` WHERE (login_f = ? AND login_s = ?) OR (login_f = ? AND login_s = ?)';
    $array = array($destination,$_SESSION['login'],$_SESSION['login'],$destination);


    $selected = dbGetter($sql,$array);

    // var_dump($selected);
    // // var_dump($_SESSION['login']);
    // // var_dump("ok");
    // // var_dump("ok");

    if(empty($selected)){
        $current_date = date('Y-m-d H:i:s');
        $type = "text";
        $sql = "INSERT INTO `discussion`(`dernierMaj`, `login_f`, `login_s`) VALUES (?, ?, ?)";
        $array = array($current_date,$destination,$_SESSION['login']);
        dbSetter($sql,$array);


        $sql = "SELECT MAX(idDisc) as id FROM `discussion`";
        $array = array();
        $id = dbGetter($sql,$array);


        $sql = "INSERT INTO `message`(`contenu`, `dateMessage`, `type`, `idDisc`, `login`) VALUES (?,?,?,?,?)";
        $array = array($message,$current_date,$type,$id[0]['id'],$_SESSION['login']);
        dbSetter($sql,$array);
    }
    else{
        $idDisc = $selected[0]['idDisc'];
        $current_date = date('Y-m-d H:i:s');
        $type = "text";
        $sql = "INSERT INTO `message`(`contenu`, `dateMessage`, `type`, `idDisc`, `login`) VALUES (?,?,?,?,?)";
        $array = array($message,$current_date,$type,$idDisc,$_SESSION['login']);
        dbSetter($sql,$array);
        $sql = "UPDATE discussion SET dernierMaj = ? WHERE idDisc = ?";
        $array = array($current_date,$idDisc);
        dbSetter($sql,$array);
        echo $current_date;
    }
    
?>