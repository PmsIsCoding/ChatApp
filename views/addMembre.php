<?php 
    session_start();
    include('../modeles/dbConnect.php');
    include('../modeles/dbHandler.php');

    $sql = "SELECT * FROM membre JOIN photo
    ON membre.login = photo.login
    WHERE membre.login NOT IN(SELECT login_env FROM demande WHERE login_rec = ?) AND membre.login NOT IN(SELECT login_rec FROM demande WHERE login_env = ?) AND membre.login <> ? AND membre.login NOT IN(SELECT login_s FROM etre_amis WHERE login_f = ?) AND membre.login NOT IN(SELECT login_f FROM etre_amis WHERE login_s = ?)";
    $array = array($_SESSION['login'],$_SESSION['login'],$_SESSION['login'],$_SESSION['login'],$_SESSION['login']);
    $aDemander = dbGetter($sql,$array);
    // var_dump($aDemander);

    $sql = "SELECT * FROM membre JOIN photo ON membre.login = photo.login
    WHERE (membre.login IN(SELECT login_s FROM etre_amis WHERE login_f = ?) OR membre.login IN(SELECT login_f FROM etre_amis WHERE login_s = ?)) AND membre.login <> ?
    ";

    $array = array($_SESSION['login'],$_SESSION['login'],$_SESSION['login']);
    $amis = dbGetter($sql,$array);

    $sql = "SELECT * FROM membre JOIN photo ON membre.login = photo.login 
    WHERE membre.login IN(SELECT login_rec FROM demande WHERE login_env = ? AND etat = 'en attente') ";
    $array = array($_SESSION['login']);
    $allMembresEnv = dbGetter($sql,$array);
    // var_dump($allMembresEnv) 

    $sql = "SELECT * FROM membre JOIN photo ON membre.login = photo.login WHERE membre.login IN(SELECT login_env FROM demande WHERE login_rec = ?)";
    $array = array($_SESSION['login']);
    $demandesRec = dbGetter($sql,$array);
    // var_dump($demandesRec)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap 5.3.3/css/bootstrap.css">
    <link rel="stylesheet" href="css/fontImport.css">
    <link rel="stylesheet" href="css/addPage.css">
    <!-- <link rel="stylesheet" href="css/home.css"> -->
    <title>Membres</title>
</head>
<body class="bg-dark">
    <header class="border-bottom border-secondary">
        <nav class="navbar navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand text-light title" href="home.php">ChatApp</a>
                <ul class="navbar nav">
                    <li class="nav-item">
                        <img src="medias/icons8-rappels-de-rendez-vous-100.png" alt="notif" class="notif"><span class="text-danger">(0)</span>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <div class="img bg-warning"><img src="<?php echo $_SESSION['photo'] ?>" alt="profil"></div>
                        <h2 class="text-light user-name"><?php echo $_SESSION['username'] ?></h2>
                    </li>
                </ul>
            </div>  
        </nav>
    </header>
    <main>
        <h1 class="text-center text-light titre h3">Ajoutez un ami</h1>
        <section class="aDemander text-light container"> 
            <div class="row">
            <?php 
            if(!empty($aDemander)) : ?>
                <?php foreach($aDemander as $row) : ?>
                    <div class="MembreaDemander bg-success d-flex flex-column align-items-center col-3">
                        <div class="img">
                            <img src="<?php echo $row['url'] ?>" alt="photo profil">
                        </div>
                        <h3 class="user-name text-center"><?php echo $row['prenom']." ".$row['nom'] ?></h3>
                        <button class="btn btn-light ajouter" id="<?php echo $row['login'] ?>">+</button>
                    </div>
                <?php endforeach; ?>
            <?php else :  ?>
                <h2 class="text-center text-secondary titre">Personne à ajouter</h2>
            <?php endif; ?>
            </div>
        </section><hr class="text-light">
        <h1 class="text-center text-light titre h3">Amis</h1>
        <section class="amis text-light container"> 
            <div class="row">
            <?php 
            if(!empty($amis)) : ?>
                <?php foreach($amis as $row) : ?>
                    <div class="MembreaDemander bg-success d-flex flex-column align-items-center col-3 ami" id="<?php echo $row['login'] ?>">
                        <div class="img">
                            <img src="<?php echo $row['url'] ?>" alt="photo profil">
                        </div>
                        <h3 class="user-name text-center"><?php echo $row['prenom']." ".$row['nom'] ?></h3>
                    </div>
                <?php endforeach; ?>
            <?php else :  ?>
                <h2 class="text-center text-secondary titre">Aucun Amis</h2>
            <?php endif; ?>
            </div>
        </section><hr class="text-light">
        <h1 class="text-center text-light titre h3">Vos Demandes en attente</h1>
        <section class="aDemander text-light container"> 
            <div class="row">
            <?php 
            if(!empty($allMembresEnv)) : ?>
                <?php foreach($allMembresEnv as $row) : ?>
                    <div class="MembreaDemander bg-success d-flex flex-column align-items-center col-3">
                        <div class="img">
                            <img src="<?php echo $row['url'] ?>" alt="photo profil">
                        </div>
                        <h3 class="user-name text-center"><?php echo $row['prenom']." ".$row['nom'] ?></h3>
                        <button class="btn btn-light attente">En attente</button>
                    </div>
                <?php endforeach; ?>
            <?php else :  ?>
                <h2 class="text-center text-secondary titre">Aucune demande</h2>
            <?php endif; ?>
            </div>
        </section>
    </main>
    <div class="fond-flou d-none"></div>
    <div class="main-message col-7 nouveauDisc modale-message d-none">
        <div class="fenetre-messages  border border-secondary h-100">
            
        </div>
        <form class="form-inline d-flex sendMessage">
            <textarea class="form-control mr-sm-2 bg-dark border-secondary text-white messageContent" placeholder="Message..." aria-label="Search"></textarea>
            <button class="btn btn-outline-success btn-success text-dark my-2 my-sm-0 buttonSend" type="button">Send</button>
        </form>
    </div>
    <script language="javascript" src="js/jquery.js"></script>
    <script language="javascript" src="js/sendDemandes.js"></script>
    <script language="javascript" src="js/newMessage.js"></script>
</body>
</html>