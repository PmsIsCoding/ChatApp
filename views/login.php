<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/css/bootstrap 5.3.3/css/bootstrap.css">
    <link rel="stylesheet" href="views/css/gradient.css">
    <title>Connextez-vous</title>
    <style>
        body{
            overflow: hidden;
        }
    </style>
</head>
<body>
<section class="gradient-custom">
  <div class="container py-3 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">
          <form action="modeles/gestAuth.php" method="POST" id="auth">
            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
              <p class="text-white-50 mb-5">Entrez votre e-mail et votre mot de passe</p>

              <div data-mdb-input-init class="form-outline form-white mb-4">
                <span class="error-login text-danger">
                    <?php if (isset($_GET['error']) && $_GET['error'] == 1) {
                       echo 'Login Introuvable';
                    }?>
                </span>
                <input type="email" id="login" name="login" class="form-control form-control-lg" />
                <label class="form-label" for="email">Email</label>
              </div>

              <div data-mdb-input-init class="form-outline form-white mb-4">
                <span class="error-mdp text-danger">
                    <?php if (isset($_GET['error']) && $_GET['error'] == 2) {
                        echo 'Mot de passe incorrect';
                    }?>
                </span>
                <input type="password" id="mdp" name="mdp" class="form-control form-control-lg" />
                <label class="form-label" for="mdp">Password</label>
              </div>

              <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                <div>
                <p class="mb-0">Vous n'avez pas de compte? <a href="views/inscription.php" class="text-white-50 fw-bold">Inscrivez-vous</a>
                </p>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    <script src="jquery.js"></script>
</body>
</html>