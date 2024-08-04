<?php

function dbGetter($sql,$array){
    global $bd;
    $stmt = $bd->prepare($sql);
    $stmt->execute($array);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function dbSetter($sql,$array){
    global $bd;
    $stmt = $bd->prepare($sql);
    $stmt->execute($array);
}
