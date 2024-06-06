<?php
require_once 'traitement/_fonctions.inc.php';

if (isset($_GET['joueur_numero'])) {
    $JoueurID = $_GET['joueur_numero'];
    $JoueurDetails = getPlayerDetails($JoueurID);
    $TotalDeMatch = getMatchesByPlayer($JoueurID);
    $CountTotaldeMatchs = count($TotalDeMatch);
    $TotalBut = getTotalGoalsByPlayer($JoueurID);
    $TotalMatchsEquipe = count(listematchs());
    $ButConcedeEquipeParMatchs = getButConcedeEquipeByPlayer($JoueurID);
    $ButEquipeParMatchs = getButEquipeByPlayer($JoueurID);

    $victoires = 0;
    $defaites = 0;
    $matchsNuls = 0;
    $butsMarques = 0;

    foreach ($TotalDeMatch as $match) {
        if ($match['ScoreTNK'] > $match['ScoreAdversaires']) {
            $victoires++;
        } elseif ($match['ScoreTNK'] < $match['ScoreAdversaires']) {
            $defaites++;
        } else {
            $matchsNuls++;
        }
        $butsMarques += $match['ScoreTNK'];
    }

    $rapportVictoiresParMatch = $CountTotaldeMatchs > 0 ? $victoires / $CountTotaldeMatchs : 0;
    $rapportDefaitesParMatch = $CountTotaldeMatchs > 0 ? $defaites / $CountTotaldeMatchs : 0;

    usort($TotalDeMatch, function($a, $b) {
        return strtotime($b['DateMatch']) - strtotime($a['DateMatch']);
    });

    $lastThreeMatches = array_slice($TotalDeMatch, 0, 3);
    $remainingMatches = array_slice($TotalDeMatch, 3);
} else {
    header("Location: effectif.php");
    exit;
}

include_once 'affichage/_debut.inc.php';
?>

<title>Détail Joueur | Site Officiel TNK inside</title>
<style>
    .match-container { margin-bottom: 20px; }
    .hidden { display: none; }
    .background-number {
        position: absolute;
        top: 70%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 18em;
        color: rgba(0, 0, 0, 0.2);
        z-index: 0;
    }
    .flex-container {
        display: flex;
        justify-content: space-between;
        border: 1px solid #1d2026;

    }
    .containerMaillot {
        position: relative;
        width: 500px;
        margin: auto;
        background-color: #0d0f13;
        border: 1px solid #1d2026;
        border-radius: 8px;
    }
    .containerMaillot img {
        width: 100%;
        display: block;
    }
    .name, .number {
        position: absolute;
        width: 100%;
        text-align: center;
        font-size: 36px;
        font-family: Arial, sans-serif;
        color: white;
    }
    .name {
        font-family: "Righteous", sans-serif;
        font-weight: 400;
        top: 60px;
    }
    .number {
        font-family: "Righteous", sans-serif;
        font-weight: 400;
        font-weight: 500;
        top: 40%;
        transform: translateY(-50%);
        font-size: 170px;
    }
    .container {
        width: 50%;
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background-color: #0d0f13;
        border: 1px solid #1d2026;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }
    h1 {
        font-size: 2em;
        margin-bottom: 20px;
        color: #daf37c;
    }
    h2 {
        font-size: 1.5em;
        margin-bottom: 10px;
        color: white;
    }
    .player-details {
        margin-bottom: 30px;
    }
    .player-details p {
        font-size: 1em;
        margin: 5px 0;
        color: white;
    }
    .player-stats {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-evenly;
        margin-bottom: 20px;
    }
    .stat {
        display: flex;
        flex-direction: column;
        flex: 1 2 22%;
        background-color: #daf37c;
        color: black;
        text-align: center;
        margin: 10px;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .stat-number {
        font-size: 1.5em;
        font-weight: bold;
    }
    .stat-label {
        font-size: 1em;
        margin-top: 10px;
    }
    .match-container {
        margin-bottom: 20px;
    }
    .hidden {
        display: none;
    }
    #toggleButton {
        display: inline-block;
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        margin: 20px 0;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        text-align: center;
        font-size: 1em;
    }
    #toggleButton:hover {
        background-color: #0056b3;
    }

    @media only screen and (max-width: 600px) {
            /* Styles pour les appareils avec une largeur maximale de 600px */
            .flex-container {
                flex-direction: column;
            }
            .containerMaillot,
            .container {
                width: 100%;
            }
            .containerMaillot {
                margin-bottom: 20px;
            }
            .container {
                padding: 10px;
            }
            .number {
                font-size: 100px;
            }
            .name {
                font-size: 24px;
                top: 40px;
            }
            .player-stats {
                flex-direction: column;
            }
            .stat {
                margin: 10px 0;
                padding: 10px;
            }
            .bilan {
                margin-top: 10px;
                font-size: 14px;
            }
            #containerMatchCenter {
                width: 100%;
            }
            #containerMatch {
                width: 100%;
                margin-bottom: 10px;
                padding: 10px;
            }
            #containerMatch1 {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    
</style>

<style>
    #containerMatchCenter {
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        border-radius: 10px;
    }

    #containerMatch {
        width: 60%;
        background-color: #0d0f13;
        border: 1px solid #1d2026;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        padding: 20px;
        transition: transform 0.2s;
    }

    #containerMatch:hover {
        transform: scale(1.03);
    }

    #contextMatch {
        display: block;
        color: #fff;
        margin-bottom: 10px;
    }

    #containerMatch1 {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #mediacalenderhide {
        font-size: 14px;
        margin-bottom: 10px;
    }

    #containerMatchResultat {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 10px;
    }

    #equipeMatch {
        display: flex;
        align-items: center;
    }

    .nomAdversaire {
        font-size: 18px;
        color: #fff;
        margin-right: 10px;
    }

    #imgMatch {
        width: 50px;
        height: 50px;
        margin: 0 10px;
    }

    #resultat {
        font-size: 18px;
        font-weight: bold;
        background-color: #0d0f13;
        border: 1px solid #1d2026;
        padding: 8px;
        border-radius: 8px;
    }

    .result-win {
        color: greenyellow;
    }

    .result-draw {
        color: orange;
    }

    .result-loss {
        color: red;
    }

    .bilan {
        color: #0000EE;
        margin-top: 10px;
        text-decoration: none;
    }

    .bilan:hover {
        text-decoration: underline;
    }

    #contextMatch:last-child {
        color: gray;
    }

    .position-title {
        width: 100%;
        font-size: 24px;
        font-weight: bold;
        margin-top: 20px;
        margin-bottom: 20px;
        color: #fff;
        text-align: center;
    }
</style>

<div class="flex-container">
    <div class="containerMaillot">
        <img src="img/maillot.png" alt="Maillot">
        <div class="name"><?php echo htmlspecialchars(strtoupper($JoueurDetails['Surnom'])); ?></div>
        <div class="number"><?php echo htmlspecialchars($JoueurDetails['Numero']); ?></div>
    </div>
    <div class="container" style="position: relative;">
        <div class="background-number">
            <?php echo htmlspecialchars($JoueurDetails['Numero']); ?>
        </div>
        <div style="position: relative; z-index: 1;">
            <h1>Détail de <?php echo htmlspecialchars($JoueurDetails['Surnom']); ?></h1>
            <div class="player-details">
                <p><strong>Nationalité :</strong> <?php echo htmlspecialchars($JoueurDetails['Pays']); ?></p>
                <p><strong>Position Préférée:</strong> <?php echo htmlspecialchars($JoueurDetails['Poste']); ?></p>
                <p><strong>Statut :</strong> <?php echo htmlspecialchars($JoueurDetails['Statut']); ?></p>
                <h2>Statistique</h2>
            </div>
        </div>
        <div class="player-stats">
            <div class="stat">
                <span class="stat-number"><?php echo $CountTotaldeMatchs; ?> / <?php echo $TotalMatchsEquipe; ?></span>
                <span class="stat-label">Matchs Joués</span>
            </div>
            <div class="stat">
                <span class="stat-number"><?php echo $victoires; ?></span>
                <span class="stat-label">Victoires</span>
            </div>
            <div class="stat">
                <span class="stat-number"><?php echo $defaites; ?></span>
                <span class="stat-label">Défaites</span>
            </div>
            <div class="stat">
                <span class="stat-number"><?php echo $TotalBut; ?></span>
                <span class="stat-label">Buts Marqués</span>
            </div>
            <div class="stat">
                <?php 
                    if ($CountTotaldeMatchs > 0) {
                        $average = number_format($TotalBut / $CountTotaldeMatchs, 2);
                    } else {
                        $average = 0;
                    }
                ?>
                <span class="stat-number"><?php echo $average; ?></span>
                <span class="stat-label">Buts par Match</span>
            </div>
            <div class="stat">
                <span class="stat-number"><?php echo $matchsNuls; ?></span>
                <span class="stat-label">Matchs Nuls</span>
            </div>
            <div class="stat">
                <span class="stat-number"><?php echo $ButEquipeParMatchs; ?></span>
                <span class="stat-label">But en équipe par Match</span>
            </div>
            <div class="stat">
                <span class="stat-number"><?php echo $ButConcedeEquipeParMatchs; ?></span>
                <span class="stat-label">Concédé en équipe par Match</span>
            </div>
            <div class="stat">
                <span class="stat-number"><?php echo number_format($rapportVictoiresParMatch, 2); ?></span>
                <span class="stat-label">Victoires par Match</span>
            </div>
        </div>
    </div>
</div>


<?php if ($CountTotaldeMatchs > 0): ?>
    <div class="position-title">Derniers matchs joués</div>

    <?php
    $clubs = club();
    $premierClub = $clubs[0];
    $deuxiemeClub = $clubs[1];
    foreach ($TotalDeMatch as $match) {
    ?>
    <div id="containerMatchCenter">
        <div id="containerMatch">
            <span id="contextMatch">
                <?= strftime('%A %d %B %Y', strtotime($match["DateMatch"])); ?>
            </span>

            <div id="containerMatch1">
                <div id="containerMatchResultat">
                    <div id="equipeMatch">
                        <span class="nomAdversaire">
                            <?php
                            foreach ($clubs as $club) {
                                if ($match["Adversaire"] == "CERGY SELECAO" and ($match["DateMatch"] < "2023-01-01")) {
                                    echo $deuxiemeClub['Nom'] . '<br>';
                                    break;
                                } else {
                                    echo $premierClub['Nom'] . '<br>';
                                    break;
                                }
                            }
                            ?>
                        </span>

                        <img id="imgMatch" src="<?= $match["Adversaire"] == "CERGY SELECAO" && strtotime($match["DateMatch"]) < strtotime("2023-01-01") ? 'img/tnkmannschaft2.png' : 'img/tnklogo.png'; ?>">
                        <div id="resultat" class="<?= $match["ScoreTNK"] > $match["ScoreAdversaires"] ? 'result-win' : ($match["ScoreTNK"] == $match["ScoreAdversaires"] ? 'result-draw' : 'result-loss'); ?>">
                            <span><?= $match["ScoreTNK"] ?></span> - <span><?= $match["ScoreAdversaires"] ?></span>
                        </div>
                        <img id="imgMatch" src="img/<?= displayLogo($match["Adversaire"]); ?>">
                        <span class="nomAdversaire"><?= $match["Adversaire"] ?></span>
                    </div>
                </div>
                <span><a style="text-decoration: none; color: #daf37c;" class="bilan" href="match_details.php?match_id=<?= $match['MatchID'] ?>">Découvrir</a></span>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
<?php else: ?>
    <p class="position-title">Aucun match joué</p>
<?php endif; ?>

<?php include_once 'affichage/_fin.inc.php'; ?>