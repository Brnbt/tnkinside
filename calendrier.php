<?php include_once 'affichage/_debut.inc.php'; ?>
<title>Calendrier | Site Officiel TNK inside</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />

<?php if (isset($_SESSION['username'])) {
  if ($_SESSION['username'] === 'adminbbet') {
    include_once 'formulaire/_calendrier.formulaire.php';
  }
}
?>

<?php
function getSaison($date) {
    $annee = date('Y', strtotime($date));
    if (date('n', strtotime($date)) < 8) {
        $annee--;
    }
    return $annee . '/' . ($annee + 1);
}

function getStatsMatch($matchs) {
    $gagnes = 0;
    $nuls = 0;
    $perdus = 0;
    $butsMarques = 0;
    $butsConcedes = 0;

    foreach ($matchs as $match) {
        if ($match["ScoreTNK"] > $match["ScoreAdversaires"]) {
            $gagnes++;
        } elseif ($match["ScoreTNK"] == $match["ScoreAdversaires"]) {
            $nuls++;
        } else {
            $perdus++;
        }

        // Calcul du nombre de buts marqués et concédés
        $butsMarques += $match["ScoreTNK"];
        $butsConcedes += $match["ScoreAdversaires"];
    }

    return array("gagnes" => $gagnes, "nuls" => $nuls, "perdus" => $perdus, "butsMarques" => $butsMarques, "butsConcedes" => $butsConcedes);
}

// Récupération des matchs
$listematchs = listematchs();

// Initialisation d'un tableau pour stocker les matchs par saison
$matchsParSaison = array();

// Regroupement des matchs par saison
foreach ($listematchs as $match) {
    $saison = getSaison($match["DateMatch"]);
    if (!isset($matchsParSaison[$saison])) {
        $matchsParSaison[$saison] = array();
    }
    $matchsParSaison[$saison][] = $match;
}

// Affichage des matchs par saison
foreach ($matchsParSaison as $saison => $matchs) {
    // Obtenir les statistiques des matchs de la saison
    $statsMatch = getStatsMatch($matchs);
    $gagnes = $statsMatch["gagnes"];
    $nuls = $statsMatch["nuls"];
    $perdus = $statsMatch["perdus"];
    $butsMarques = $statsMatch["butsMarques"];
    $butsConcedes = $statsMatch["butsConcedes"];
    $differenceButs = $butsMarques - $butsConcedes;
    $nbmatch = $gagnes + $perdus;
    $saisonId = 'saison_' . str_replace('/', '_', $saison);

    echo "<table id='tableau' class='tableau' style='border-radius: 8px; background-color: #0d0f13; text-align: center; border-spacing: 10px; border: 2px solid #1d2026; margin-top: 10px; width: 300px; margin-left: auto; margin-right: auto; margin-bottom: 30px'>";
    
    echo "<tr>";
    echo "<th>MJ</th>";
    echo "<th>G</th>";
    echo "<th>N</th>";
    echo "<th>P</th>";
    echo "<th>BP</th>";
    echo "<th>BC</th>";
    echo "<th>DB</th>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td>$nbmatch</td>";
    echo "<td style='color: greenyellow;'>$gagnes</td>";
    echo "<td style='color: grey;'>$nuls</td>";
    echo "<td style='color: red;'>$perdus</td>";
    echo "<td>$butsMarques</td>";
    echo "<td>$butsConcedes</td>";
    echo "<td>$differenceButs</td>";
    echo "</tr>";
    
    // Fin du tableau
    echo "</table>";

    echo "<div id='$saisonId'>";
    
    // Affichage des matchs de la saison
    foreach ($matchs as $match) {
        // Récupération des clubs
        $clubs = club();
        $premierClub = $clubs[0];
        $deuxiemeClub = $clubs[1];
        
        // Affichage de chaque match
        ?>
<div id="containerMatchCenter">
        <div id="containerMatch" data-match-id="<?= $match['MatchID'] ?>">
            <span id="contextMatch">
                <?= strftime('%A %d %B %Y', strtotime($match["DateMatch"])); ?>
            </span>
            <div id="containerMatch1">
                <span style="color: gray;font-family: 'Krona One', sans-serif;" id="mediacalenderhide">
                    <?= $match["TypeMatch"] ?>
                </span>
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
                <span><a style="text-decoration: none; font-family: 'Krona One', sans-serif;" class="bilan" href="match_details.php?match_id=<?= $match['MatchID'] ?>">Découvrir</a></span>
            </div>
            <span><a id="contextMatch" style="color: gray; "><?= $match["Stade"] ?></a></span>
        </div>
    </div>
        <?php
    }
    echo "</div>";
}
?>

<div id='space'></div>

<?php include_once 'affichage/_fin.inc.php'; ?>

<style>

table{
    transition: transform 0.2s;
}

table:hover{
    transform: scale(1.05);
}

.bilan {
    color: #daf37c;
}

#resultat {
    background-color: #111213;
    padding: 10px;
    border: 1px solid #1d2026;
    border-radius: 8px;
}

#containerMatchCenter {
    display: flex;
    justify-content: center;
    padding-bottom: 10px;
}

#containerMatch {
    border: 1px solid #1d2026;
    background-color: #0d0f13;
    padding: 10px;
    text-align: center;
    padding: 15px;
    width: 70%;
    text-align: center;
    border-radius: 5px;
    transition: transform 0.2s;
    cursor: pointer;

}

#containerMatch:hover{
    transform: scale(1.05);

}

#containerMatch1 {
    color: white;
    padding: 10px;
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    font-weight: bold;
}

#imgMatch {
    width: 70px;
    padding-left: 10px;
    padding-right: 10px;
}

#containerMatchResultat,
#equipeMatch {
    display: flex;
    align-items: center;
}

#contextMatch {
    color: #ffffff;
    text-decoration: none;
}

.nomAdversaire {
    display: inline-block;
}

/* Styles pour les appareils mobiles */
@media (max-width: 600px) {
    #containerMatch {
        width: 90%;
        padding: 10px;
    }

    #containerMatch1 {
        flex-direction: column;
        align-items: center;
    }

    #imgMatch {
        width: 70px;
        padding: 5px;
    }

    #resultat {
        padding: 5px;
    }

    .nomAdversaire, #contextMatch{
        display: none; 
    }
}
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var matchDivs = document.querySelectorAll('#containerMatch');

        matchDivs.forEach(function (div) {
            div.addEventListener('click', function () {
                var matchId = this.getAttribute('data-match-id');
                if (matchId) {
                    window.location.href = 'match_details.php?match_id=' + matchId;
                }
            });
        });
    });
</script>
