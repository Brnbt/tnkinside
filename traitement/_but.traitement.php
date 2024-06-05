<?php
require_once '_fonctions.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['match_id'], $_POST['buts'])) {
    $matchId = $_POST['match_id'];
    $buts = $_POST['buts'];

    // Récupérer les informations du match pour obtenir le score de l'équipe TNK
    $match = getMatchById($matchId);
    $scoreTNK = $match['ScoreTNK'];

    // Calculer le total des buts
    $totalButs = 0;
    foreach ($buts as $numeroJoueur => $nombreButs) {
        $totalButs += intval($nombreButs);
    }

    // Vérifier si le total des buts ne dépasse pas le score TNK
    if ($totalButs <= $scoreTNK) {
        foreach ($buts as $numeroJoueur => $nombreButs) {
            ajouterButsJoueur($matchId, $numeroJoueur, $nombreButs);
        }
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        // Rediriger avec un message d'erreur
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
    exit;
} else {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
