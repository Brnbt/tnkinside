<?php

require_once '_fonctions.inc.php';

if (isset($_POST['supprimer'])) {
    // Vérifier si le champ surnom est rempli
    if (isset($_POST['surnom']) && !empty($_POST['surnom'])) {
        $surnom = $_POST['surnom'];

        // Appeler la fonction pour supprimer le joueur par son surnom
        if (supprimerJoueur($surnom)) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            echo "Joueur avec surnom $surnom supprimé avec succès.<br>";
        }
    } else {
    }
}
?>