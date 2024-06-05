<?php
require_once '_fonctions.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actualite_id = $_POST['actualite_id'];

    if (supprimerActualite($actualite_id)) {
        // Rediriger avec un message de succès
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // Rediriger avec un message d'erreur
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
