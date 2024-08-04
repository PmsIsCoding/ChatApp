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

//--------------------

//Les memebres qui ont une discussion avec le membre qui se connecte
$logins = array();
foreach($discussions as $discussion){
    if($discussion['login_f'] == $_SESSION['login'])
        $logins[] = $discussion['login_s'];
    else
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
// var_dump($membreDiscussions);
//-------------------

$sql = "SELECT * FROM membre JOIN photo ON membre.login = photo.login WHERE membre.login IN(SELECT login_env FROM demande WHERE login_rec = ? AND etat = 'en attente')";
$array = array($_SESSION['login']);
$demandesRec = dbGetter($sql,$array);
// var_dump($_SESSION['login']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap 5.3.3/css/bootstrap.css">
    <link rel="stylesheet" href="css/fontImport.css">
    <link rel="stylesheet" href="css/home.css">
    <title>Chattez</title>
</head>
<body class="bg-dark">
    <header class="border-bottom border-secondary">
    <nav class="navbar navbar-light bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-light title" href="home.php">ChatApp</a>
            <ul class="navbar nav">
                <li class="nav-item text-secondary ">
                    <a href="addMembre.php" class="btn btn-outline-success">Ajouter des Amis</a>
                </li>
            </ul>
            <ul class="navbar nav">
                <li class="nav-item notif-icon">
                    <img src="medias/icons8-rappels-de-rendez-vous-100.png" alt="notif" class="notif"><span class="text-danger">(<?php echo count($demandesRec) ?>)</span>
                </li>
                <li class="nav-item d-flex align-items-center">
                    <div class="img bg-warning"><img src="<?php echo $_SESSION['photo'] ?>" alt="profil"></div>
                    <h2 class="text-light user-name"><?php echo $_SESSION['username'] ?></h2>
                </li>
            </ul>
        </div>  
    </nav>
    </header>
    <div class="container-fluid main">
       <div class="row">
            <div class="discussions col-4 border border-secondary vh-100 fenetre-discussion fenetre">
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
            </div>
            <div class="main-message col-7">
                <div class="fenetre-messages  border border-secondary vh-100 fenetre">
                    <div class="infos-discussion align-items-center">
                        <div class="img"><img src="" alt="" class="barre-photo"></div>
                        <h1 class="text-light info-username"></h1>
                    </div>
                    <div class="messages">
                        <span class="text-success">Choisissez une discussion</span>
                    </div>
                </div>
                <form class="form-inline d-flex sendMessage">
                    <textarea class="form-control mr-sm-2 bg-dark border-secondary text-white messageContent" placeholder="Message..." aria-label="Search"></textarea>
                    <button class="btn btn-outline-success btn-success text-dark my-2 my-sm-0" type="button">Send</button>
                </form>
            </div>
       </div>
    </div>
    <div class="fond-flou d-none"></div>
    <div class="notifs text-light d-none bg-success">
        <?php foreach($demandesRec as $row) : ?>
            <p class="<?php echo $row['login'] ?>"><span class="text-light">"<?php echo $row['prenom']." ".$row['nom'] ?>"</span> Vous a Envoyé une demande <button type="button" class="btn btn-outline-light accepter" id="<?php echo $row['login'] ?>">Accepter</button></p>
        <?php endforeach; ?>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/sendMessages.js" language="javascript"></script> 
    <script src="js/getDiscussion.js"></script>
    <script language="javascript" src="js/gestFilDiscussions.js"></script>
    <script src="js/gestAcceptAmis.js" language="javascript"></script>
    <script language="javascript" src="js/gestModale.js"></script>
</body>
</html>