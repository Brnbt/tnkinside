<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #mediacalenderhide {
            margin-top: 20px;
            padding-bottom: 20px;
        }

        .derniermatch {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .derniermatch1 {
            background-color: #0d0f13;
            border-radius: 10px;
            border: 1px solid #1d2026;
            padding: 15px;
            text-align: center;
            flex: 1 1 calc(33.333% - 40px); /* Trois éléments par ligne avec espacement */
            box-sizing: border-box;
            max-width: calc(33.333% - 40px);
            margin: 10px;
            text-decoration: none;
            transition: transform 0.7s;
 /* Pour enlever la décoration du lien */
        }
        .derniermatch1:hover{
            transform: scale(1.05);

        }

        .logoderniermatch {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logoderniermatch img {
            max-width: 40%;
            width: 160px;
            height: auto;
        }

        .result-win {
            color: greenyellow;
        }

        .result-loss {
            color: red;
        }

        .voirmatch {
            margin-top: 30px;
            text-align: center;
        }

        .voirmatch a {
            padding: 9px 25px;
            text-decoration: none;
            font-weight: bold;
            color: rgb(255, 253, 253);
            border: none;
            background-color: #0d0f13;
            border: #1d2026 1px solid;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.8s ease 0s;
        }

        .voirmatch a:hover {
            color: #daf37c;
            background-color: #0d0f13;
            border: #1e232d 1px solid;
        }

        /* Add media query for mobile responsiveness */
        @media (max-width: 600px) {
            .derniermatch1 {
                flex: 1 1 100%; /* Full width on small screens */
                max-width: 90%;
                margin: 10px 0;
                 /* Adjust margin for better spacing */
            }

            .logoderniermatch img {
                width: 120px; /* Adjust image size for mobile */
            }

            .voirmatch a {
                padding: 7px                 20px; /* Adjust padding for smaller buttons on mobile */
            }
        }
    </style>
    <title>Derniers Matchs</title>
</head>
<body>
    <section id="mediacalenderhide">
        <div class="derniermatch">
            <?php
            $listeMatchs = listematchs();
            $troisDerniersMatchs = array_slice($listeMatchs, 0, 3);

            foreach ($troisDerniersMatchs as $index => $matchs) {
                $adversaireLogo = displayLogo($matchs["Adversaire"]);
                $match_id = $matchs['MatchID']; // Assurez-vous d'avoir l'ID du match dans les données
            ?>
                <a href="match_details.php?match_id=<?= $match_id ?>" class="derniermatch1 match-<?php echo $index + 1; ?>">
                    <div class="logoderniermatch">
                        <img src="img/tnklogo.png" alt="tnklogo">
                        <div style="padding: 15px; color: white;font-family: 'Krona One', sans-serif; font-size: 30px;">X</div>
                        <img src="img/<?php echo $adversaireLogo; ?>" alt="adversaire_logo">
                    </div>
                    <div style="font-size: 20px; font-family: 'Krona One', sans-serif;" class="result-<?php echo ($matchs["ScoreTNK"] > $matchs["ScoreAdversaires"]) ? 'win' : 'loss'; ?>">
                        <?php echo $matchs["ScoreTNK"]; ?> -
                        <?php echo $matchs["ScoreAdversaires"]; ?>
                    </div>
                </a>
            <?php
            }
            ?>
        </div>
        <div class="voirmatch">
            <a href="calendrier.php">VOIR TOUS LES MATCHS</a>
        </div>
    </section>
</body>
</html>

