<?php
require_once 'traitement/_fonctions.inc.php';

if (isset($_GET['match_id'])) {
    $matchId = $_GET['match_id'];
    $match = getMatchById($matchId);
    $joueurs = getJoueursByMatch($match['CompositionEquipe'], $matchId);
    $nombreJoueurs = count($joueurs);
    $compositionImg = getCompositionImageByMatchId($matchId);

} else {
    header("Location: calendrier.php");
    exit;
}
?>

<?php include_once 'affichage/_debut.inc.php'; ?>

<title>Détails du Match | Site Officiel TNK inside</title>

<div class="container">
    <div class="match-info">
        <?php if ($match): ?>
            <h1 class="match-title">Feuille de match</h1>
            <p class="match-detail"><?= strftime('%A %d %B %Y', strtotime($match["DateMatch"])); ?></p>
            <p class="match-detail"><?= htmlspecialchars($match["TypeMatch"]) ?></p>
            <p class="match-detail">Adversaire : <?= htmlspecialchars($match["Adversaire"]) ?></p>
            <p class="match-detail">Score : <?= htmlspecialchars($match["ScoreTNK"]) ?> - <?= htmlspecialchars($match["ScoreAdversaires"]) ?></p>
            <p class="match-detail"><?= htmlspecialchars($match["Stade"]) ?></p>
            <p class="match-detail">Match à <?= $nombreJoueurs ?></p>
            <h3 class="team-composition-title">Composition de l'équipe :</h3>
            <?php if ($joueurs): ?>
                <ul class="team-list">
                    <?php foreach ($joueurs as $joueur): ?>
                        <li class="team-list-item">
                            <?= htmlspecialchars($joueur['Surnom']) ?>
                            <?php if ($joueur['NombreButs'] > 0): ?>
                                <?php for ($i = 0; $i < $joueur['NombreButs']; $i++): ?>
                                    <i class="fas fa-futbol"></i>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="no-players">Aucun joueur ajouté pour ce match.</p>
            <?php endif; ?>
            <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'adminbbet'): ?>
                <a class="add-players-link" href="add_players.php?match_id=<?= urlencode($matchId) ?>">Ajouter joueurs</a>
            <?php endif; ?>
        <?php else: ?>
            <p class="match-not-found">Match introuvable.</p>
        <?php endif; ?>
        <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'adminbbet'): ?>

            <form action="traitement/_but.traitement.php" method="POST" class="goals-form">
                <h3 class="team-composition-title">Buts par joueur :</h3>
                <input type="hidden" name="match_id" value="<?= $matchId ?>">
                <?php foreach ($joueurs as $joueur): ?>
                    <div class="goal-input-group">
                        <label for="buts_<?= $joueur['Numero'] ?>" class="goal-label"><?= htmlspecialchars($joueur['Surnom']) ?> :</label>
                        <input type="number" name="buts[<?= $joueur['Numero'] ?>]" id="buts_<?= $joueur['Numero'] ?>" min="0" value="<?= htmlspecialchars($joueur['NombreButs']) ?>" class="goal-input">
                    </div>
                <?php endforeach; ?>
                <input type="submit" value="Enregistrer les buts" class="submit-goals-button">
            </form>

            <form action="traitement/_position.traitement.php" method="POST" class="positions-form">
                <h3 class="team-composition-title">Postes par joueur :</h3>
                <input type="hidden" name="match_id" value="<?= $matchId ?>">
                <?php foreach ($joueurs as $joueur): ?>
                    <div class="position-input-group">
                        <label for="position_<?= $joueur['Numero'] ?>" class="position-label"><?= htmlspecialchars($joueur['Surnom']) ?> :</label>
                        <select name="positions[<?= $joueur['Numero'] ?>][poste]" id="position_<?= $joueur['Numero'] ?>" class="position-select">
                            <option value="Gardien" <?= $joueur['Poste'] == 'Gardien' ? 'selected' : '' ?>>Gardien</option>
                            <option value="DefenseurGauche" <?= $joueur['Poste'] == 'DefenseurGauche' ? 'selected' : '' ?>>Défenseur Gauche</option>
                            <option value="DefenseurCentral" <?= $joueur['Poste'] == 'DefenseurCentral' ? 'selected' : '' ?>>Défenseur Central</option>
                            <option value="DefenseurCentralGauche" <?= $joueur['Poste'] == 'DefenseurCentralGauche' ? 'selected' : '' ?>>Défenseur Central Gauche</option>
                            <option value="DefenseurCentralDroite" <?= $joueur['Poste'] == 'DefenseurCentralDroite' ? 'selected' : '' ?>>Défenseur Central Droite</option>
                            <option value="DefenseurDroit" <?= $joueur['Poste'] == 'DefenseurDroit' ? 'selected' : '' ?>>Défenseur Droit</option>
                            <option value="MilieuGauche" <?= $joueur['Poste'] == 'MilieuGauche' ? 'selected' : '' ?>>Milieu Gauche</option>
                            <option value="MilieuCentral" <?= $joueur['Poste'] == 'MilieuCentral' ? 'selected' : '' ?>>Milieu Central</option>
                            <option value="MilieuDroit" <?= $joueur['Poste'] == 'MilieuDroit' ? 'selected' : '' ?>>Milieu Droit</option>
                            <option value="AttaquantGauche" <?= $joueur['Poste'] == 'AttaquantGauche' ? 'selected' : '' ?>>Attaquant Gauche</option>
                            <option value="AttaquantCentral" <?= $joueur['Poste'] == 'AttaquantCentral' ? 'selected' : '' ?>>Attaquant Central</option>
                            <option value="AttaquantDroit" <?= $joueur['Poste'] == 'AttaquantDroit' ? 'selected' : '' ?>>Attaquant Droit</option>
                        </select>
                    </div>
                <?php endforeach; ?>
                <input type="submit" value="Enregistrer les postes" class="submit-positions-button">
            </form>

        <?php endif; ?>

        <a class="back-link" href="calendrier.php">Retour au calendrier</a>

        <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'adminbbet'): ?>
    <form id="delete-match-form" action="traitement/_calendrier.supprimer.php" method="POST">
        <input type="hidden" name="match_id" value="<?= $matchId ?>">
        <input type="submit" value="Supprimer le match" class="delete-match-button">
    </form>
<?php endif; ?>         

    </div>

    <div class="field">
        <?php
$positions = [
    'Gardien' => 'position-1',
    'DefenseurGauche' => 'position-2',
    'DefenseurCentral' => 'position-3',
    'DefenseurCentralGauche' => 'position-31',
    'DefenseurCentralDroite' => 'position-32',
    'DefenseurDroit' => 'position-4',
    'MilieuGauche' => 'position-5',
    'MilieuCentral' => 'position-6',
    'MilieuDroit' => 'position-7',
    'AttaquantGauche' => 'position-8',
    'AttaquantCentral' => 'position-9',
    'AttaquantDroit' => 'position-10',
];

        foreach ($joueurs as $joueur) {
            $positionClass = isset($positions[$joueur['Poste']]) ? $positions[$joueur['Poste']] : 'position-0';
            echo '<div class="grid-position ' . $positionClass . '">';
            echo '<div class="player">';
            echo '<span>' . htmlspecialchars($joueur['Numero']) . '</span>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>
/
<?php include_once 'affichage/_fin.inc.php'; ?>

<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="closes">&times;</span>
        <p>Voulez-vous vraiment supprimer ce match ?</p>
        <button id="confirmDelete" class="confirm-button">Oui</button>
        <button id="cancelDelete" class="cancel-button">Non</button>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const players = document.querySelectorAll('.grid-position');

    players.forEach(player => {
        player.style.position = "absolute";
        const position = player.classList[1];
        
        switch (position) {
            case 'position-1': player.style.top = '85%'; player.style.left = '50%'; break;
            case 'position-2': player.style.top = '70%'; player.style.left = '15%'; break;
            case 'position-3': player.style.top = '70%'; player.style.left = '50%'; break;
            case 'position-31': player.style.top = '70%'; player.style.left = '50%'; break;
            case 'position-32': player.style.top = '70%'; player.style.left = '50%'; break;
            case 'position-4': player.style.top = '70%'; player.style.left = '85%'; break;
            case 'position-5': player.style.top = '50%'; player.style.left = '15%'; break;
            case 'position-6': player.style.top = '50%'; player.style.left = '50%'; break;
            case 'position-7': player.style.top = '50%'; player.style.left = '85%'; break;
            case 'position-8': player.style.top = '30%'; player.style.left = '15%'; break;
            case 'position-9': player.style.top = '30%'; player.style.left = '50%'; break;
            case 'position-10': player.style.top = '30%'; player.style.left = '85%'; break;
        }
    });
});
</script>

<style>

.modal-content {
    margin: 15% auto;
    padding: 20px;
    width: 80%;
    border-radius :8px;
}

.closes {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.closes:hover,
.closes:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.confirm-button, .cancel-button {
    padding: 10px 20px;
    margin: 10px;
    cursor: pointer;
    border-radius :8px;
}

.confirm-button {
    background-color: red;
    color: white;
    border: none;
}

.cancel-button {
    background-color: grey;
    color: white;
    border: none;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.container {
    border: 1px solid #1d2026;
    max-width: 800px;
    margin: 20px auto;
    background-color: #0d0f13;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
}

.match-info {
    margin-bottom: 20px;
    flex: 1;

}

.match-title {
    font-size: 24px;
    margin-bottom: 10px;
    color: #daf37c;

}

.match-detail {
    font-size: 16px;
    margin-bottom: 5px;
    color: #fff;

}

.team-composition-title {
    font-size: 20px;
    margin-bottom: 10px;
    color: #daf37c;

}

.team-list {
    list-style-type: none;
}

.team-list-item {
    border: 1px solid #1d2026;
    background: #1d2026;
    margin: 10px 0;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    color: white;
    transition: 0.3s all ease;

}
.team-list-item:hover{
    background: #24282F;
}

.no-players {
    font-style: italic;
    color: red;
}

.add-players-link {
    display: block;
    margin-top: 10px;
    font-size: 16px;
}

.composition-form,
.goals-form,
.positions-form {
    margin-top: 20px;
}

.composition-input-group,
.goal-input-group,
.position-input-group {
    margin-bottom: 10px;
}

.composition-label,
.goal-label,
.position-label {
    display: block;
    font-size: 16px;
    margin-bottom: 5px;
}

.composition-input,
.goal-input,
.position-select {
    width: 100%;
    padding: 8px;
    font-size: 16px;
    border-radius: 4px;
}

.goals-form {
    margin-top: 20px;
    padding: 20px;
    border: 1px solid #1d2026;
    background-color: #0d0f13;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px;
}

.goal-input-group {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.goal-label {
    flex: 1;
    color: white;
    margin-bottom: 5px;
}

.goal-input {
    flex: 1;
    padding: 5px;
    border: 1px solid #1d2026;
    border-radius: 3px;
    background-color: #1d2026;
    color: white;
    width: 80px;
    text-align: center;
}


.submit-composition-button,
.submit-goals-button,
.submit-positions-button,
.back-link,
.add-players-link {
    cursor: pointer;
    border: 1px solid #daf37c;
    display: inline-block;
    margin: 20px 0;
    padding: 10px 20px;
    text-decoration: none;
    color: black;
    background-color: #daf37c;
    border-radius: 5px;
    transition: 0.3s ease;
    font-size: 15px;
}

.submit-composition-button:hover,
.submit-goals-button:hover,
.submit-positions-button:hover,
.back-link:hover,
.add-players-link:hover {
    background-color: black;
    color: #daf37c;
    border: 1px solid black;
}

.delete-match-button {
    border: 1px solid red;
    display: inline-block;
    margin: 20px 0;
    padding: 10px 20px;
    text-decoration: none;
    color: black;
    background-color: red;
    border-radius: 5px;
    transition: 0.3s ease;
    font-size: 15px;
}

.delete-match-button:hover {
    background-color: black;
    color: red;
    border: 1px solid black;
}

.field {
    position: relative;
    height: 400px;
    margin-top: 20px;
    background-color: #c0c0c0;
    border-radius: 5px;
    overflow: hidden;
}

.grid-position {
    position: absolute;
    background-color: #daf37c;
    border: 1px solid #daf37c;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 15px;
    transition: 0.5s ease;

}

.grid-position:hover {
    background-color: black;
    border: 1px solid black;
    color: #daf37c;

}

.player span {
    text-align: center;
}

.position-0 { top: 50%; left: 50%; transform: translate(-50%, -50%); }
.position-1 { top: 85%; left: 50%; transform: translateX(-50%); }
.position-2 { top: 70%; left: 15%; }
.position-3 { top: 70%; left: 50%; transform: translateX(-50%); }
.position-31 { top: 70%; left: 50%; transform: translateX(-140%); }
.position-32 { top: 70%; left: 50%; transform: translateX(40%); }
.position-4 { top: 70%; left: 85%; transform: translateX(-100%); }
.position-5 { top: 50%; left: 15%; }
.position-6 { top: 50%; left: 50%; transform: translate(-50%, -50%); }
.position-7 { top: 50%; left: 85%; transform: translateX(-100%);}
.position-8 { top: 30%; left: 15%; }
.position-9 { top: 30%; left: 50%; transform: translateX(-50%); }
.position-10 { top: 30%; left: 85%; transform: translateX(-100%);}



.field {
    width: 400px; /* Largeur du terrain */
    height: 550px; /* Hauteur du terrain */
    margin-left: 20px; /* Espace entre la fiche des joueurs et le terrain */
    margin-right: 20px; /* Espace entre la fiche des joueurs et le terrain */
    position: relative; /* Ajout de position relative */
    background-image: url('img/terrain.png');
    transition: 0.7s ease;


}
.field:hover{
    background-image: url('img/terrain2.png');
    transition: 0.7s ease;

}

.positions-form {
    padding: 20px;
    border: 1px solid #1d2026;
    background-color: #0d0f13;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px;

}

.position-input-group {
    margin-bottom: 20px;
}

.position-label {
    display: block;
    font-size: 16px;
    margin-bottom: 5px;
    color: #daf37c;
}

.position-select {
    width: 100%;
    padding: 8px;
    font-size: 16px;
    border-radius: 4px;
    background-color: #1d2026;
    color: white;
}

.submit-positions-button {
    cursor: pointer;
    border: 1px solid #daf37c;
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    text-decoration: none;
    color: black;
    background-color: #daf37c;
    border-radius: 5px;
    transition: 0.3s ease;
    font-size: 15px;
}

.submit-positions-button:hover {
    background-color: black;
    color: #daf37c;
    border: 1px solid black;
}

.error-message {
    color: red;
}

@media screen and (max-width: 768px) {
  .container {
    flex-direction: column-reverse;
  }

  .field {
    background-color: #0d0f13;
    width: 100%;
    margin: 20px auto;
    position: relative;
    height: 400px;
    margin-top: 20px;
    background-image: url('img/terrain.png');
    background-repeat: no-repeat; 
    background-size: contain; 
    background-position: center; 
    border-radius: 5px;
    overflow: hidden; 
  }
}

</Style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="traitement/_but.traitement.php"]');
    const scoreTNK = <?= $match['ScoreTNK'] ?>;
    const errorMsg = document.createElement('p');
    errorMsg.style.color = 'red';

    form.addEventListener('submit', function(event) {
        const butsInputs = form.querySelectorAll('input[name^="buts"]');
        let totalButs = 0;
        
        butsInputs.forEach(input => {
            totalButs += parseInt(input.value) || 0;
        });

        if (totalButs > scoreTNK) {
            event.preventDefault();
            errorMsg.textContent = 'Le total des buts ne peut être dépasser.';
            form.insertBefore(errorMsg, form.firstChild);
        }

        if (totalButs < scoreTNK) {
            event.preventDefault();
            errorMsg.textContent = 'Le total des buts ne peut être inférieur.';
form.insertBefore(errorMsg, form.firstChild);
}
});
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteMatchForm = document.getElementById('delete-match-form');
    const deleteModal = document.getElementById('deleteModal');
    const confirmDeleteButton = document.getElementById('confirmDelete');
    const cancelDeleteButton = document.getElementById('cancelDelete');
    const closeButton = document.getElementsByClassName('closes')[0];

    if (deleteMatchForm) {
        deleteMatchForm.addEventListener('submit', function(event) {
            event.preventDefault();
            deleteModal.style.display = 'block';
        });
    }

    confirmDeleteButton.onclick = function() {
        deleteMatchForm.submit();
    }

    cancelDeleteButton.onclick = function() {
        deleteModal.style.display = 'none';
    }

    closeButton.onclick = function() {
        deleteModal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == deleteModal) {
            deleteModal.style.display = 'none';
        }
    }
});

</script>