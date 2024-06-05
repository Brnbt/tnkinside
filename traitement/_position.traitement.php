<?php
include_once '_fonctions.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matchId = $_POST['match_id'];
    $positions = $_POST['positions'];

    $pdo = gestionnaireDeConnexion();

    // Supprimer les positions existantes pour ce match
    $stmt = $pdo->prepare("DELETE FROM positions WHERE MatchID = ?");
    $stmt->execute([$matchId]);

    // Insérer les nouvelles positions
    $stmt = $pdo->prepare("INSERT INTO positions (MatchID, NumeroJoueur, Poste) VALUES (?, ?, ?)");

    foreach ($positions as $numeroJoueur => $position) {
        $stmt->execute([$matchId, $numeroJoueur, $position['poste']]);
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
