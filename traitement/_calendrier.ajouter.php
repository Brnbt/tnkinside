<?php

require_once '_fonctions.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Adversaire = $_POST['Adversaire'];
    $TypeMatch = $_POST['TypeMatch'];
    $Stade = $_POST['Stade'];
    $DateMatch = $_POST['DateMatch'];
    $ScoreAdversaires = $_POST['ScoreAdversaires'];
    $ScoreTNK = $_POST['ScoreTNK'];



    if (ajouterMatch($Adversaire, $TypeMatch, $Stade, $DateMatch, $ScoreAdversaires, $ScoreTNK)) {
        header("Location: " . $_SERVER['HTTP_REFERER']);

    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);

    }



}
?>