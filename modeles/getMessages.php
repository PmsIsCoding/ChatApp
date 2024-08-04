<?php
session_start();
include('dbConnect.php');
include('dbHandler.php');

$sql = "
    SELECT login, contenu, dateMessage
    FROM message
    WHERE idDisc = ?
    ORDER BY dateMessage DESC
    ";

$array = array($_POST['idDisc']);

if($_POST['option'] == "nbrMessages"){
    $allMessages = dbGetter($sql,$array);
    echo count($allMessages);
}
if($_POST['option'] == "messages"){
    $allMessages = dbGetter($sql,$array);
    for($i = count($allMessages)-1; $i>=0;$i--) :  ?>
        <div class="
            <?php
                if($allMessages[$i]['login'] == $_POST['destination'])
                    echo "message-rec bg-secondary";
                else{
                    echo "message-env bg-success";
                }
            ?>
        ">
            <?php echo $allMessages[$i]['contenu'] ?>
        </div>
    <?php endfor;
} 
if($_POST['option'] == "lastMessage"){
    $allMessages = dbGetter($sql,$array);
    $lastMessage = $allMessages[0]; 
    if($lastMessage['login'] != $_SESSION['login']){
        echo "<div class='message-rec bg-secondary'>
            ".$lastMessage['contenu']."
        </div>";
    }
}
?>