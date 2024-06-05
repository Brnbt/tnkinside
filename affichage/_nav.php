<?php
ob_start();
session_start();
include_once 'traitement/_fonctions.inc.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="TNK">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta data-n-head="ssr" data-hid="og:type" name="og:type" property="og:type" content="website">
    <meta data-n-hd="ssr" data-hid="og:title" name="og:title" property="og:title" content="TNK">
    <meta data-n-head="ssr" data-hid="og:site_name" name="og:site_name" property="og:site_name" content="TNK">
    <meta data-n-head="ssr" data-hid="theme-color" name="theme-color" content="#090a0d">
    <link rel="apple-touch-icon" href="img/tnkicologo.png">
    <link rel="icon" type="image/png" href="img/tnkicologo.png">
    <link rel="apple-touch-startup-image" href="tnklogo.png">
    <link data-n-head="ssr" rel="shortcut icon" href="tnklogo.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mediasstyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Krona+One&display=swap">
    <link rel="stylesheet" href="css/flag-icons-main/css/flag-icons.css">
    <link rel='stylesheet' href='css/boxicons/css/boxicons.min.css'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geologica:wght@300&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="script.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        body {
            margin: 0;
        }

        .navbar {
          font-family: 'Geologica', sans-serif;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #090a0d;
            border-bottom: 1px solid #e0e0e0;
        }

        .navbar-left, .navbar-center, .navbar-right {
            display: flex;
            align-items: center;
        }

        .menu-icon, .logo, .champions-logo, .sponsor-logo {
            height: 40px;
            margin-right: 15px;
        }

        .navbar-center a {
            margin: 0 10px;
            text-decoration: none;
            color: white;
            transition: 0.3s ease;
            font-weight: 500;
        }

        .navbar-center a:hover {
            color: #daf37c;
            transition: 0.3s ease;
        }

        .username{
            background-color: #090a0d;
            border: 1px solid #090a0d;
            color: white;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            font-size: 10px;
            font-family: 'Krona One', sans-serif;

        }

        .login-button {
            background-color: transparent;
            border: 2px solid #daf37c;
            color: #daf37c;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s ease;
            margin-left: 8px;
        }

        .login-button:hover {
            background-color: #daf37c;
            color: black;
            transition: 0.3s ease;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #0d0e13;
            padding: 20px;
            border: 1px solid #090a0d;
            width: 300px;
            border-radius: 10px;
            text-align: center;
            color: white;
        }

        .modal-content input[type="text"],
        .modal-content input[type="password"],
        .modal-content input[type="submit"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #23272c;
            border-radius: 5px;
            font-size: 16px;
        }

        .modal-content input[type="submit"] {
            color: black;
            background-color: #daf37c;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .modal-content input[type="submit"]:hover {
            color: #daf37c;
            background-color: black;
        }

        .modal-content h2 {
            margin-bottom: 20px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover, .close:focus {
            color: black;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <img src="img/tnknavlogo.png" alt="Real Madrid Logo" class="logo">
        </div>
        <div class="navbar-center">
            <a href="index.php">Accueil</a>
            <a href="actualites.php">Actualités</a>
            <a href="calendrier.php">Calendrier</a>
            <a href="effectif.php">Effectif</a>
            <a href="stats.php">Stats</a>
        </div>
        <div class="navbar-right">
            <img src="img/imgsponsor/racism.png" alt="Emirates Logo" class="sponsor-logo">
            <?php if (isset($_SESSION['username'])) { ?>
              <a href="profile.php" class="">
              <button id="profileBtn" class="username"><?php echo strtoupper(htmlspecialchars($_SESSION['username'])); ?></button></a>
              <form id="myform" method="post" action="traitement/_deconnexion.php" class="mediacalenderhide">
                <button id="buttonco" class="login-button" type="submit" name="logout">Déconnexion</button>
              </form>
            <?php } else { ?>        
              <button id="connexionButton" class="login-button">Connexion</button>
              <button id="inscriptionButton" class="login-button">Inscription</button>
            <?php } ?>
        </div>
    </nav>

    <!-- Modals -->
    <div id="inscriptionModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeInscription">&times;</span>
            <h2>Inscription</h2>
            <form id="inscriptionForm" action="traitement/_inscription.php" method="post">
                <input type="text" id="mail" name="mail" placeholder="Adresse mail" required>
                <input id="usernameInput" type="text" name="username" placeholder="Nom d'utilisateur" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <input type="text" id="mobile" name="mobile" placeholder="Numéro de téléphone" required>
                <input type="submit" id="submit-button" value="S'inscrire">
            </form>
        </div>
    </div>

    <div id="connexionModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeConnexion">&times;</span>
            <h2>Connexion</h2>
            <form method="post" action="traitement/_connexion.php">
                <input id="inpututilisateur" type="text" name="username" placeholder="Utilisateur" required>
                <input id="inpututilisateur" type="password" name="password" placeholder="Mot de passe" required>
                <input type="submit" id="buttonco" name="login">
            </form>
        </div>
    </div>

    <script>
        // Get the modals
        var inscriptionModal = document.getElementById("inscriptionModal");
        var connexionModal = document.getElementById("connexionModal");

        // Get the buttons that open the modals
        var inscriptionButton = document.getElementById("inscriptionButton");
        var connexionButton = document.getElementById("connexionButton");

        // Get the <span> elements that close the modals
        var closeInscription = document.getElementById("closeInscription");
        var closeConnexion = document.getElementById("closeConnexion");

        // When the user clicks the button, open the modal 
        inscriptionButton.onclick = function() {
            inscriptionModal.style.display = "flex";
        }

        connexionButton.onclick = function() {
            connexionModal.style.display = "flex";
        }

        // When the user clicks on <span> (x), close the modal
        closeInscription.onclick = function() {
            inscriptionModal.style.display = "none";
        }

        closeConnexion.onclick = function() {
            connexionModal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == inscriptionModal) {
                inscriptionModal.style.display = "none";
            }
            if (event.target == connexionModal) {
                connexionModal.style.display = "none";
            }
        }
    </script>
</body>
</html>
