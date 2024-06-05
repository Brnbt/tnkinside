<?php
session_start();
include_once '_fonctions.inc.php';

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'adminbbet') {
    // Redirection si l'utilisateur n'est pas autorisé
    header("Location: calendrier.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si toutes les données nécessaires sont présentes
    if (isset($_POST['match_id'], $_POST['composition_img_link']) && !empty($_POST['composition_img_link'])) {
        $matchId = $_POST['match_id'];
        $compositionImg = $_POST['composition_img_link'];
        
        // Mettre à jour la base de données avec le lien de l'image
        if (ajouterCompositionImg($matchId, $compositionImg)) {
            // Redirection vers la page des détails du match
            header("Location: /bolista/match_details.php?match_id=" . $matchId);
            exit;
        } else {
            echo "Erreur lors de la mise à jour de la base de données.";
        }
    } else {
        echo "Veuillez saisir un lien vers l'image.";
    }
} else {
    echo "Méthode de requête non autorisée.";
}
?>
