<?php
require_once 'traitement/_fonctions.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matchId = $_POST['match_id'];
    $joueurs = $_POST['joueurs']; // Tableau des IDs de joueurs sélectionnés

    $composition = implode(',', $joueurs); // Convertir le tableau en chaîne séparée par des virgules

    if (ajouterJoueursAuMatch($matchId, $composition)) {
        header("Location: match_details.php?match_id=$matchId");
        exit;
    } else {
        echo "Erreur lors de l'ajout des joueurs.";
    }
}

$matchId = $_GET['match_id'];
$joueurs = getAllJoueurs();

// Récupérer la composition de l'équipe pour ce match
$composition = getCompositionDuMatch($matchId);

// Sort players by position
function sortByPosition($a, $b) {
    $positions = ['Gardien', 'Defenseur', 'Milieu', 'Attaquant'];
    return array_search($a['Poste'], $positions) - array_search($b['Poste'], $positions);
}

usort($joueurs, 'sortByPosition');
?>

<?php include_once 'affichage/_debut.inc.php'; ?>

<title>Ajouter des joueurs</title>
<style>
    .container {
        font-family: Arial, sans-serif;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .form-container {
        border: 1px solid #1d2026;
        background: #0d0f13;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        width: 100%;
    }

    .form-title {
        text-align: center;
        color: #daf37c;
        margin-bottom: 20px;
    }

    .player-section {
        margin-bottom: 20px;
    }

    .player-section h2 {
        color: #fff;
        margin-bottom: 10px;
    }

    .player-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 10px;
    }

    .player-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border: 1px solid #1d2026;
        border-radius: 4px;
        background-color: #1d2026;
    }

    .player-box label {
        display: flex;
        align-items: center;
        font-size: 16px;
        color: #fff;
        width: 100%;
    }

    .player-info {
        display: flex;
        align-items: center;
    }

    .form-checkbox {
        margin-right: 15px;
    }

    .form-button {
        color: black;
        background-color:  #daf37c;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        border-radius: 4px;
        cursor: pointer;
        transition: 0.3s ease;
        width: 100%;
        margin-top: 20px;
    }

    .form-button:hover {
        background-color: black;
        color: #daf37c;
    }

    .back-button {
        color: black;
        background-color: red;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
        margin-top: 10px;
    }

    .back-button:hover {
        background-color: black;
        color: #f37c7c;
    }

    @media (min-width: 600px) {
        .player-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 900px) {
        .player-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
</style>

<div class="container">
    <div class="form-container">
        <h1 class="form-title">Ajouter des joueurs au match</h1>
        <form method="post">
            <input type="hidden" name="match_id" value="<?= $matchId ?>">
            
            <?php 
            $currentPosition = '';
// Vérifier si $composition est null et lui attribuer une chaîne vide si nécessaire
$composition = $composition ?? '';

// Convertir la chaîne en tableau pour faciliter la vérification
$compositionArray = explode(',', $composition);
            
            foreach ($joueurs as $joueur): 
                if ($joueur['Poste'] !== $currentPosition):
                    if ($currentPosition !== ''):
                        // Close the previous player-grid div
                        echo '</div></div>';
                    endif;
                    $currentPosition = $joueur['Poste'];
            ?>
                    <div class="player-section">
                        <h2><?= ucfirst($currentPosition) ?></h2>
                        <div class="player-grid">
            <?php 
                endif;

                // Vérifier si le joueur est déjà dans la composition de l'équipe
                $checked = in_array($joueur['Numero'], $compositionArray) ? 'checked' : '';
            ?>
                            <div class="player-box">
                                <label>
                                    <input class="form-checkbox" type="checkbox" name="joueurs[]" value="<?= $joueur['Numero'] ?>" <?= $checked ?>>
                                    <div class="player-info">
                                        <?= $joueur['Surnom'] ?>
                                    </div>
                                </label>
                            </div>
            <?php endforeach; ?>
                        </div>
                    </div> <!-- Close the last player-section div -->

            <button class="form-button" type="submit">Ajouter</button>
        </form>
        <button class="back-button" onclick="history.back()">Retour</button>
    </div>
</div>

<div style="height: 200px;"></div>

<?php include_once 'affichage/_fin.inc.php'; ?>
