<?php
session_start();
require_once '_fonctions.inc.php';

// Nombre maximal de tentatives d'inscription autorisées dans l'intervalle de temps spécifié
define('MAX_REGISTRATION_ATTEMPTS', 3);

// Intervalle de temps pour lequel les tentatives d'inscription sont comptées (en secondes)
define('INTERVAL_TIME', 60);

// Fonction pour vérifier et limiter les tentatives d'inscription
function limitRegistrationAttempts() {
    // Vérifier si la session pour les tentatives d'inscription existe déjà
    if (!isset($_SESSION['registration_attempts'])) {
        $_SESSION['registration_attempts'] = array();
    }

    // Récupérer le timestamp actuel
    $current_time = time();

    // Nettoyer les tentatives d'inscription plus anciennes que l'intervalle de temps spécifié
    foreach ($_SESSION['registration_attempts'] as $index => $attempt_time) {
        if ($current_time - $attempt_time > INTERVAL_TIME) {
            unset($_SESSION['registration_attempts'][$index]);
        }
    }

    // Vérifier le nombre de tentatives d'inscription dans l'intervalle de temps spécifié
    if (count($_SESSION['registration_attempts']) >= MAX_REGISTRATION_ATTEMPTS) {
        // Si le nombre maximal de tentatives d'inscription est dépassé, rediriger ou afficher un message d'erreur
        header("Location: /bolista/error_page.php");
        exit();
    }
}

// Vérifier et limiter les tentatives d'inscription
limitRegistrationAttempts();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nettoyage et validation des données avant l'insertion dans la base de données
    $mail = htmlspecialchars($_POST["mail"]);
    $username = htmlspecialchars($_POST["username"]);
    // Utilisez password_hash() pour hacher le mot de passe
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $mobile = htmlspecialchars($_POST["mobile"]);

    // Assurez-vous que toutes les données requises sont présentes
    if (!empty($mail) && !empty($username) && !empty($_POST["password"]) && !empty($mobile)) {
        // Vérifiez si l'utilisateur existe déjà dans la base de données
        if (utilisateurExiste($username)) {
            // Enregistrer la tentative d'inscription
            $_SESSION['registration_attempts'][] = time();

            // Redirection vers la page précédente avec un message d'erreur si l'utilisateur existe déjà
            header("Location: " . $_SERVER['HTTP_REFERER'] . "?erreur=utilisateur_existe");
            exit(); // Arrêter l'exécution du script pour éviter toute sortie supplémentaire
        } else {
            // Insérer l'utilisateur dans la base de données
            if (inscrireUtilisateur($mail, $username, $password, $mobile)) {
                // Démarrer la session et définir le nom d'utilisateur
                $_SESSION['username'] = $username;

                // Redirection vers la page précédente avec un message de succès
                header("Location: " . $_SERVER['HTTP_REFERER'] . "?success=inscription_reussie");
                exit(); // Arrêter l'exécution du script pour éviter toute sortie supplémentaire
            } else {
                echo "Erreur lors de l'inscription.";
            }
        }
    } else {
        echo "Tous les champs sont obligatoires.";
    }
} else {
    echo "Le formulaire n'a pas été soumis.";
}
?>
