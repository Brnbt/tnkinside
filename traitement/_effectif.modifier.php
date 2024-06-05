<?php

require_once '_fonctions.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ancien_surnom = $_POST["ancien_surnom"];
    $nouveau_numero = $_POST["nouveau_numero"];
    $nouveau_surnom = $_POST["nouveau_surnom"];
    $nouveau_pays = $_POST["nouveau_pays"];
    $nouveau_poste = $_POST["nouveau_poste"];
    $nouveau_statut = $_POST["nouveau_statut"];

    // Inclure ici la fonction gestionnaireDeConnexion() si ce n'est pas déjà fait

    // Appeler la fonction pour modifier le joueur
    if (modifierJoueur($ancien_surnom, $nouveau_numero, $nouveau_surnom, $nouveau_pays, $nouveau_poste, $nouveau_statut)) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}
?>