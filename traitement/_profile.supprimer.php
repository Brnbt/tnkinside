<?php
session_start();
include_once '_fonctions.inc.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Vérifier si la demande de suppression a été envoyée via la méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer le nom d'utilisateur de la session
    $username = $_SESSION['username'];

    // Appeler une fonction pour supprimer le compte de l'utilisateur
    if (supprimerCompte($username)) {
        // Si la suppression est réussie, déconnectez l'utilisateur et redirigez-le vers la page d'accueil
        session_destroy();
        header('Location: index.php');
        exit();
    } else {
        // Si la suppression échoue, redirigez l'utilisateur vers une page d'erreur ou affichez un message d'erreur
        echo "Erreur : Échec de la suppression du compte.";
        exit();
    }
} else {
    // Si la demande n'est pas envoyée via la méthode POST, redirigez l'utilisateur vers la page d'accueil
    header('Location: index.php');
    exit();
}
?>
