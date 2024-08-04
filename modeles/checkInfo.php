<?php 

session_start();
require('dbConnect.php');
include('dbHandler.php');


$sql = "SELECT * FROM membre WHERE login = ?";

$array = array($_GET['login']);

$result = $result = dbGetter($sql,$array);

if(!empty($result)){
    echo "0";
}
else{
    echo "1";
}