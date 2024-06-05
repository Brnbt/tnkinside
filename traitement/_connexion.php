<?php
session_start();
require_once '_fonctions.inc.php';

// Nombre maximal de tentatives de connexion autorisées dans l'intervalle de temps spécifié
define('MAX_CONNECTION_ATTEMPTS', 3);

// Intervalle de temps pour lequel les tentatives de connexion sont comptées (en secondes)
define('INTERVAL_TIME', 60);

// Fonction pour vérifier et limiter les tentatives de connexion
function limitConnectionAttempts() {
    // Vérifier si la session pour les tentatives de connexion existe déjà
    if (!isset($_SESSION['connection_attempts'])) {
        $_SESSION['connection_attempts'] = array();
    }

    // Récupérer le timestamp actuel
    $current_time = time();

    // Nettoyer les tentatives de connexion plus anciennes que l'intervalle de temps spécifié
    foreach ($_SESSION['connection_attempts'] as $index => $attempt_time) {
        if ($current_time - $attempt_time > INTERVAL_TIME) {
            unset($_SESSION['connection_attempts'][$index]);
        }
    }

    // Vérifier le nombre de tentatives de connexion dans l'intervalle de temps spécifié
    if (count($_SESSION['connection_attempts']) >= MAX_CONNECTION_ATTEMPTS) {
        // Si le nombre maximal de tentatives de connexion est dépassé, rediriger ou afficher un message d'erreur
        header("Location: /bolista/error_page.php");
        exit();
    }
}

// Vérifier et limiter les tentatives de connexion
limitConnectionAttempts();

// Si le formulaire de connexion est soumis
if (isset($_POST['login'])) {
    // Récupérer les données du formulaire
    $username = strtolower($_POST['username']);
    $password = $_POST['password'];

    // Vérifier les informations d'identification
    $hashed_password_from_database = getHashedPasswordFromDatabase($username);

    if ($hashed_password_from_database !== false && password_verify($password, $hashed_password_from_database)) {
        // Authentification réussie, rediriger vers la page d'accueil
        $_SESSION['username'] = $username;
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // Échec de l'authentification, enregistrer la tentative de connexion
        $_SESSION['connection_attempts'][] = time();
        $erreur_message = "Nom d'utilisateur ou mot de passe incorrect";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}

?>