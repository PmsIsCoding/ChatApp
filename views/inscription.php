<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap 5.3.3/css/bootstrap.css">
    <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #6a11cb;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }
    </style>
    <title>Inscrivez-vous</title>
</head>
<body>
    <main>
    <section class="gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">
          <form action="../modeles/gestInsc.php" method="POST" enctype="multipart/form-data" id="inscription">
            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Inscription</h2>
              <p class="text-white-50 mb-5">Remplissez le formulaire pour créer un compte</p>

              <div data-mdb-input-init class="form-outline form-white mb-4">                
                <label class="form-label" for="photo">Photo de profil</label>
                <input type="file" name="photo" id="photo" class="form-control form-control-lg" required/>
              </div>

              <div data-mdb-input-init class="form-outline form-white mb-4">
                <label class="form-label" for="login">Login(Adresse Mail)</label>
                <input type="email" id="login" name="login" class="form-control form-control-lg" required />
                <span class="error-login text-danger">
                </span>
              </div>

              <div data-mdb-input-init class="form-outline form-white mb-4">
                <label class="form-label" for="nom">Nom</label>
                <input type="text" id="nom" name="nom" class="form-control form-control-lg" required />
              </div>

              <div data-mdb-input-init class="form-outline form-white mb-4">
                <label class="form-label" for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" class="form-control form-control-lg" required />
              </div>

              <div data-mdb-input-init class="form-outline form-white mb-4">
                <label class="form-label" for="mdp">Mot de Passe</label>
                <input type="password" id="mdp" name="mdp" class="form-control form-control-lg" required />
                <span class="mdp-error text-danger">
              </div>

              <div data-mdb-input-init class="form-outline form-white mb-4">
                <label class="form-label" for="confmdp">Confirmez votre Mot de Passe</label>
                <input type="password" id="confmdp" name="confmdp" class="form-control form-control-lg" required />
                <span class="confmdp-error text-danger">
                </span>
              </div>

              <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5 submit" type="submit" disabled>Inscription</button>

            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    <script src="js/jquery.js"></script>
    <script src="js/ajax.js"></script>
</body>
</html>