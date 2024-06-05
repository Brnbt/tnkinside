<?php
require_once '_fonctions.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['Adversaire']) && !empty($_POST['DateMatch'])) {
        $Adversaire = $_POST['Adversaire'];
        $DateMatch = $_POST['DateMatch'];

        if (supprimerMatch($Adversaire, $DateMatch)) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "Échec de la suppression du match.";
        }
    } elseif (!empty($_POST['match_id'])) {
        $matchId = $_POST['match_id'];

        if (supprimerMatch2($matchId)) {
            header('Location: ../calendrier.php');
            exit();
        } else {
            echo "Échec de la suppression du match.";
        }
    } else {
        header('Location: ../calendrier.php');
        exit();
    }
} else {
    header('Location: ../calendrier.php');
    exit();
}
?>
