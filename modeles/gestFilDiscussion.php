<?php session_start();
require('../modeles/dbConnect.php');
include('../modeles/dbHandler.php');


// Les discussions aux quelles participe le membre qui se connecte
$sql = "SELECT * FROM discussion WHERE login_f = ? OR login_s = ? ORDER BY dernierMaj DESC";

$array = array($_SESSION['login'],$_SESSION['login']);
$discussions = dbGetter($sql,$array);

// $sql = "SELECT * FROM membre JOIN photo ON membre.login = photo.login
//     WHERE (membre.login IN(SELECT login_s FROM etre_amis WHERE login_f = ?) OR membre.login IN(SELECT login_f FROM etre_amis WHERE login_s = ?)) AND membre.login <> ?
//     ";

// $array = array($_SESSION['login'],$_SESSION['login'],$_SESSION['login']);
// $membreDiscussions = dbGetter($sql,$array);
// var_dump($discussions);

//--------------------

//Les memebres qui ont une discussion avec le membre qui se connecte
$membreDiscussions = array();
$logins = array();
foreach($discussions as $discussion){
    if($discussion['login_f'] == $_SESSION['login'])
        $logins[] = $discussion['login_s'];
    elseif($discussion['login_s'] == $_SESSION['login'])
        $logins[] = $discussion['login_f'];
}


foreach ($logins as $login) {
    $sql = "SELECT DISTINCT membre.*, photo.url 
            FROM membre 
            JOIN photo ON membre.login = photo.login 
            WHERE membre.login = ?";
    $result = dbGetter($sql, array($login));
    if ($result) {
        $membreDiscussions[] = $result[0]; // On suppose que le login est unique
    }
};
 

?>
<form class="form-inline d-flex searchDisc">
    <input class="form-control mr-sm-2 bg-dark border-secondary text-white" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form>
<?php foreach($membreDiscussions as $membre)  : ?>
    <div class="discussion d-flex align-items-center" id="<?php echo $membre['login'] ?>" value = "<?php
    foreach( $discussions as $disc ) :
        if($disc['login_f'] == $membre['login'] || $disc['login_s'] == $membre['login']){
            echo $disc['idDisc'];
            break;
        }
        endforeach
    ?>">
        <div class="img"><img src="<?php echo $membre['url'] ?>" alt="photo_profil"></div>
        <div class="info border-bottom border-secondary">
            <h2 class="text-light user-name"><?php echo $membre['prenom']." ".$membre['nom'] ?></h2>
            <p class="lastMess text-secondary">
            <?php
                //Discussion concernant ce membre 
                $array = array($_SESSION['login'],$membre['login'],$membre['login'],$_SESSION['login']);
                $sql = "SELECT * FROM discussion WHERE (login_f = ? AND login_s = ?) OR (login_f = ? AND login_s = ?)";
                $disc = dbGetter($sql,$array);
                //----------------------

                if(!empty($disc)){
                    $array = array($disc[0]['idDisc']);
                    $sql = "
                        SELECT login, contenu, dateMessage
                        FROM message
                        WHERE idDisc = ?
                        ORDER BY dateMessage DESC
                        LIMIT 1
                    ";            
                    $message = dbGetter($sql,$array);
                    // var_dump($message);
                    if($message[0]['login'] == $_SESSION['login']){
                        echo "<span class='text-success'>Vous : </span>".$message[0]['contenu'];
                    }
                    else{
                        echo $message[0]['contenu'];
                    }
                }
                else{
                    echo "Aucune Discussion";
                }
            ?>
            </p>
        </div>
    </div>
<?php endforeach; ?>