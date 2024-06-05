<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Centre d'aide - TNK INSIDE</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers votre fichier CSS -->
    <style>
        /* Votre CSS personnalisé ici */
        body {
            font-family: 'Geologica', sans-serif;
            background-color: #090a0d;
            margin: 0;
            padding: 0;
            height: 100vh;
            color: white;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 50px;
        }

        .section {
            margin-bottom: 30px;
            max-width: 800px;
            width: 100%;
            padding: 20px;
            border-radius: 15px;
            background-color: #0d0f13;
            border: 1px solid #1d2026;
        }

        .section h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .section p {
            margin-bottom: 10px;
        }

        .section a {
            color: #daf37c;
            text-decoration: none;
            font-weight: bold;
        }

        .section a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include_once 'affichage/_debut.inc.php'; ?>
        
    <div class="container">
        
        <div class="section">
            <h2>CALENDRIER & RÉSULTATS</h2>
            <p>Obtenez des informations détaillées sur les statistiques des équipes, des joueurs et des matchs.</p>
        </div>
        <div class="section">
            <h2>EFFECTIF</h2>
            <p>Découvrez les joueurs qui composent l'équipe de TNK INSIDE, avec leurs statistiques individuelles.</p>
        </div>
        <div class="section">
            <h2>SUPPORT ET ASSISTANCE</h2>
            <p>Besoin d'aide ? Contactez notre équipe de support :</p>
            <ul>
                <li><a href="support.php">Contacter le support</a></li>
            </ul>
        </div>
    </div>

    <div style="height: 100px"></div>

    
    <?php include_once 'affichage/_fin.inc.php'; ?>
</body>
</html>
