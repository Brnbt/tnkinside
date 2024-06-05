<?php

require_once '_fonctions.inc.php';


// Vérifier si le formulaire a été soumis

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupérer les valeurs du formulaire
  $numero = $_POST['numero'];
  $surnom = $_POST['surnom'];
  $pays = $_POST['pays'];
  $poste = $_POST['poste'];
  $statut = $_POST['statut'];

  // Appeler la fonction pour ajouter le joueur
  if (ajouterJoueur($numero, $surnom, $pays, $poste, $statut)) {
    header("Location: " . $_SERVER['HTTP_REFERER']);

  } else {
    $loginError = "Invalid username or password. Please try again.";
  }
}
?>