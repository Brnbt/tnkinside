<?php

function gestionnaireDeConnexion()
{
    $user = 'brn';
    $pass = 'brn';
    $dsn = 'mysql:host=localhost;dbname=bolista';

    try {
        $database = new PDO($dsn, $user, $pass);
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $database;
    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }
}


function verifierUtilisateur($username, $password)
{
    $pdo = gestionnaireDeConnexion();

    $query = $pdo->prepare("SELECT id FROM utilisateurs WHERE username = :username AND password = :password");
    $query->bindParam(":username", $username);
    $query->bindParam(":password", $password);

    if ($query->execute()) {
        $resultat = $query->fetch(PDO::FETCH_ASSOC);
        if ($resultat) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function getMatchById($matchId) {
    $pdo = gestionnaireDeConnexion();
    try {
        $query = "SELECT * FROM matchs WHERE MatchID = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$matchId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function getJoueursByMatch($composition, $matchId) {
    $pdo = gestionnaireDeConnexion();

    // Vérifier si $composition est une chaîne de caractères non vide
    if (!is_string($composition) || empty($composition)) {
        return [];  // Retourner un tableau vide ou gérer l'erreur selon vos besoins
    }

    $joueurs = explode(',', $composition);
    $placeholders = implode(',', array_fill(0, count($joueurs), '?'));

    $query = "
        SELECT j.Surnom, j.Numero, IFNULL(b.NombreButs, 0) AS NombreButs, p.Poste
        FROM joueurs j
        LEFT JOIN buts b ON j.Numero = b.NumeroJoueur AND b.MatchID = ?
        LEFT JOIN positions p ON j.Numero = p.NumeroJoueur AND p.MatchID = ?
        WHERE j.Numero IN ($placeholders)
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute(array_merge([$matchId, $matchId], $joueurs));

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



function ajouterJoueursAuMatch($matchId, $composition) {
    $pdo = gestionnaireDeConnexion();
    try {
        $query = "UPDATE matchs SET CompositionEquipe = ? WHERE MatchID = ?";
        $stmt = $pdo->prepare($query);
        return $stmt->execute([$composition, $matchId]);
    } catch (PDOException $e) {
        // Gestion des erreurs
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}

function getAllJoueurs() {
    $pdo = gestionnaireDeConnexion();
    try {
        $query = "SELECT * FROM joueurs";
        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function ajouterActualite($titre, $contenu, $date, $image_url = null, $video_url = null)
{
    try {
        $pdo = gestionnaireDeConnexion();

        // Préparez la requête pour insérer une nouvelle actualité
        $query = $pdo->prepare("INSERT INTO actualites (titre, contenu, date, image_url, video_url) VALUES (:titre, :contenu, :date, :image_url, :video_url)");
        $query->bindParam(":titre", $titre);
        $query->bindParam(":contenu", $contenu);
        $query->bindParam(":date", $date);
        $query->bindParam(":image_url", $image_url);
        $query->bindParam(":video_url", $video_url);

        // Exécuter la requête
        if ($query->execute()) {
            return true; // Retourner vrai si l'ajout est réussi
        } else {
            return false; // Retourner faux si l'ajout a échoué
        }
    } catch (Exception $e) {
        // Gérer les exceptions
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}

function supprimerActualite($id)
{
    try {
        $pdo = gestionnaireDeConnexion();

        // Récupérer le chemin de l'image à partir de la base de données
        $query = $pdo->prepare("SELECT image_url FROM actualites WHERE id = :id");
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();
        $actualite = $query->fetch(PDO::FETCH_ASSOC);

        if ($actualite && !empty($actualite['image_url'])) {
            // Chemin relatif au script actuel
            $image_path = '../img/actualite/uploads/' . $actualite['image_url'];

            // Vérifier si le fichier existe et le supprimer
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        // Préparer la requête pour supprimer l'actualité
        $query = $pdo->prepare("DELETE FROM actualites WHERE id = :id");
        $query->bindParam(":id", $id, PDO::PARAM_INT);

        // Exécuter la requête
        return $query->execute();
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}

function getYouTubeVideoId($video_url) {
    $video_id = '';
    $parsed_url = parse_url($video_url);
    if (isset($parsed_url['query'])) {
        parse_str($parsed_url['query'], $query_params);
        if (isset($query_params['v'])) {
            $video_id = $query_params['v'];
        }
    }
    return $video_id;
}

function getAllActualites()
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT * FROM actualites";
    $pdoStatement = $pdo->query($requeteSql);
    $liste_actualites = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    return $liste_actualites;
}

function getActualiteById($id)
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT * FROM actualites WHERE id = ?";
    $pdoStatement = $pdo->prepare($requeteSql);
    $pdoStatement->execute([$id]);
    $actualite = $pdoStatement->fetch(PDO::FETCH_ASSOC);
    return $actualite;
}


function modifierInformationsUtilisateur($username, $email, $mobile)
{
    $pdo = gestionnaireDeConnexion();

    // Préparez la requête pour mettre à jour les informations de l'utilisateur
    $query = $pdo->prepare("UPDATE utilisateurs SET mail = :email, mobile = :mobile WHERE username = :username");
    $query->bindParam(":email", $email);
    $query->bindParam(":mobile", $mobile);
    $query->bindParam(":username", $username);

    // Exécuter la requête
    if ($query->execute()) {
        return true; // Retourner vrai si la modification a réussi
    } else {
        return false; // Retourner faux si la modification a échoué
    }
}

function supprimerCompte($username) {
    try {
        $pdo = gestionnaireDeConnexion();
        // Écrire la requête SQL pour supprimer le compte de l'utilisateur de la table appropriée
        $query = $pdo->prepare("DELETE FROM utilisateurs WHERE username = :username");
        $query->bindParam(":username", $username);
        $query->execute();
        // Retourner true si la suppression est réussie
        return true;
    } catch (Exception $e) {
        // Retourner false en cas d'erreur lors de la suppression
        return false;
    }
}

function inscrireUtilisateur($mail, $username, $password, $mobile)
{
    $pdo = gestionnaireDeConnexion();

    $query = $pdo->prepare("INSERT INTO utilisateurs (mail, username, password, mobile) VALUES (:mail, :username, :password, :mobile)");
    $query->bindParam(":mail", $mail);
    $query->bindParam(":username", $username);
    $query->bindParam(":password", $password);
    $query->bindParam(":mobile", $mobile);

    if ($query->execute()) {
        return true;
    } else {
        return false;
    }
}

function getHashedPasswordFromDatabase($username)
{
    $pdo = gestionnaireDeConnexion();
    $query = $pdo->prepare("SELECT password FROM utilisateurs WHERE username = :username");
    $query->bindParam(":username", $username);

    if ($query->execute()) {
        $resultat = $query->fetch(PDO::FETCH_ASSOC);
        if ($resultat) {
            return $resultat['password'];
        }
    }

    return false;
}

function utilisateurExiste($username)
{
    $pdo = gestionnaireDeConnexion();

    $query = $pdo->prepare("SELECT id FROM utilisateurs WHERE username = :username");
    $query->bindParam(":username", $username);

    if ($query->execute()) {
        $resultat = $query->fetch(PDO::FETCH_ASSOC);
        if ($resultat) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function changerMotDePasse($username, $oldPassword, $newPassword) {
    try {
        $pdo = gestionnaireDeConnexion();
        // Vérifier l'ancien mot de passe
        $query = $pdo->prepare("SELECT password FROM utilisateurs WHERE username = :username");
        $query->bindParam(":username", $username);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "Utilisateur non trouvé";
            return false;
        }

        // Vérifiez si l'ancien mot de passe est correct
        if (!password_verify($oldPassword, $user['password'])) {
            echo "Ancien mot de passe incorrect";
            return false;
        }

        // Hacher le nouveau mot de passe
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Mettre à jour le mot de passe dans la base de données
        $updateQuery = $pdo->prepare("UPDATE utilisateurs SET password = :newPassword WHERE username = :username");
        $updateQuery->bindParam(":newPassword", $hashedNewPassword);
        $updateQuery->bindParam(":username", $username);

        if ($updateQuery->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}


function listeLieuxDistincts()
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT DISTINCT Stade FROM matchs";
    $pdoStatement = $pdo->query($requeteSql);
    $listeLieux = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    return $listeLieux;
}

function listeStade()
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT Nom, Ville FROM stade";
    $pdoStatement = $pdo->query($requeteSql);
    $listeLieux = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);



    return $listeLieux;
}

function club()
{

    $pdo = gestionnaireDeConnexion();
    $requeteSql = "select * from club";
    $pdoStatement = $pdo->query($requeteSql);
    $club = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    return $club;

}

function meilleurButeur() {
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT joueurs.Surnom, joueurs.Numero, SUM(buts.NombreButs) AS TotalButs FROM joueurs JOIN buts ON joueurs.Numero = buts.NumeroJoueur GROUP BY joueurs.Numero ORDER BY TotalButs DESC LIMIT 1";
    $pdoStatement = $pdo->query($requeteSql);
    return $pdoStatement->fetch(PDO::FETCH_ASSOC);
}



function listeJoueurs()
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT joueurs.*, IFNULL(SUM(buts.NombreButs), 0) AS TotalButs
                   FROM joueurs
                   LEFT JOIN buts ON joueurs.Numero = buts.NumeroJoueur
                   GROUP BY joueurs.Numero";
    $pdoStatement = $pdo->query($requeteSql);
    $listeJoueurs = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    return $listeJoueurs;
}

function getMatchesByPlayer($playerNumber)
{
    $pdo = gestionnaireDeConnexion();
    try {
        // Construire la chaîne de recherche avec des délimiteurs appropriés
        $query = "
        SELECT * 
        FROM `matchs`
        WHERE `CompositionEquipe` LIKE :playerNumberStart
        OR `CompositionEquipe` LIKE :playerNumberMiddle
        OR `CompositionEquipe` LIKE :playerNumberEnd
        OR `CompositionEquipe` = :playerNumberExact;
        ";
        $stmt = $pdo->prepare($query);

        // Ajouter les délimiteurs autour du numéro de joueur
        $playerNumberStart = "$playerNumber,%";
        $playerNumberMiddle = "%,$playerNumber,%";
        $playerNumberEnd = "%,$playerNumber";
        $playerNumberExact = "$playerNumber";

        // Lier les paramètres
        $stmt->bindParam(':playerNumberStart', $playerNumberStart, PDO::PARAM_STR);
        $stmt->bindParam(':playerNumberMiddle', $playerNumberMiddle, PDO::PARAM_STR);
        $stmt->bindParam(':playerNumberEnd', $playerNumberEnd, PDO::PARAM_STR);
        $stmt->bindParam(':playerNumberExact', $playerNumberExact, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return [];
    }
}


function getButConcedeEquipeByPlayer($playerNumber)
{
    $pdo = gestionnaireDeConnexion();
    try {
        $query = "
        SELECT SUM(ScoreAdversaires) AS ButsEquipe
        FROM `matchs`
        WHERE `CompositionEquipe` LIKE :playerNumber;
        ";
        $stmt = $pdo->prepare($query);
        // Ajoutez les caractères de pourcentage autour du numéro de joueur
        $playerNumber = "%$playerNumber%";
        $stmt->bindParam(':playerNumber', $playerNumber, PDO::PARAM_STR);
        $stmt->execute();
        
        // Récupérez le résultat sous forme de tableau associatif
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['ButsEquipe'] : 0; // Retournez la valeur ou 0 si aucun résultat
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return 0; // Retournez 0 en cas d'erreur
    }
}

function getButEquipeByPlayer($playerNumber)
{
    $pdo = gestionnaireDeConnexion();
    try {
        $query = "
        SELECT SUM(ScoreTNK) AS ButsEquipe
        FROM `matchs`
        WHERE `CompositionEquipe` LIKE :playerNumber;
        ";
        $stmt = $pdo->prepare($query);
        // Ajoutez les caractères de pourcentage autour du numéro de joueur
        $playerNumber = "%$playerNumber%";
        $stmt->bindParam(':playerNumber', $playerNumber, PDO::PARAM_STR);
        $stmt->execute();
        
        // Récupérez le résultat sous forme de tableau associatif
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['ButsEquipe'] : 0; // Retournez la valeur ou 0 si aucun résultat
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return 0; // Retournez 0 en cas d'erreur
    }
}


function getTotalGoalsByPlayer($playerNumber)
{
    $pdo = gestionnaireDeConnexion();
    try {
        $query = "
        SELECT SUM(NombreButs) AS TotalButs
        FROM `buts`
        WHERE `NumeroJoueur` = :playerNumber;
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':playerNumber', $playerNumber, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['TotalButs'] !== null ? $result['TotalButs'] : 0;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return 0;
    }
}



function nombreMatchsJoues()
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT joueurs.Surnom, COUNT(DISTINCT matchs.MatchID) AS NombreMatchs
                   FROM joueurs
                   LEFT JOIN buts ON joueurs.Numero = buts.NumeroJoueur
                   LEFT JOIN matchs ON buts.MatchID = matchs.MatchID
                   GROUP BY joueurs.Numero";
    $pdoStatement = $pdo->query($requeteSql);
    $listeNombreMatchs = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    return $listeNombreMatchs;
}



function getJoueurs() {
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "select Surnom from joueurs";
    $pdoStatement = $pdo->query($requeteSql);
    $listeJoueurs = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    return $listeJoueurs;
}

function getPlayerDetails($joueurID) {
    $pdo = gestionnaireDeConnexion();
    try {
        $query = "SELECT * FROM joueurs WHERE Numero = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$joueurID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

// Fonction pour obtenir la liste des noms d'adversaires depuis la table "adversaire"
function listeAdversaires()
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT nom FROM adversaire";
    $pdoStatement = $pdo->query($requeteSql);
    $listeAdversaires = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    return $listeAdversaires;
}


function listematchs()
{

    $pdo = gestionnaireDeConnexion();
    $requeteSql = "select * from matchs order by DateMatch DESC";
    $pdoStatement = $pdo->query($requeteSql);
    $listematchs = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    return $listematchs;
}

function listematchs2()
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT MatchID FROM matchs ORDER BY DateMatch DESC";
    $pdoStatement = $pdo->query($requeteSql);
    $listematchs = $pdoStatement->fetchAll(PDO::FETCH_COLUMN);
    return $listematchs;
}


function afficherDateEnFrancais($date)
{
    // Définir le locale en français
    setlocale(LC_TIME, 'fr_FR.utf8', 'fra', 'fr_FR', 'fr');
    
    // Convertir la date en encodage UTF-8
    $date = mb_convert_encoding($date, 'UTF-8', 'auto');

    // Vérifier si la date est valide
    $timestamp = strtotime($date);
    if ($timestamp === false) {
        return "Date invalide";
    }

    // Formater la date en français
    $formattedDate = strftime('%A %d %B %Y', $timestamp);
    $formattedDate = ucfirst($formattedDate);

    return $formattedDate;
}



function displayLogo($adversaire)
{
    switch ($adversaire) {
        case 'BAYER 04':
            return 'imgteam/Bayer04logo.png';
        case 'TANUKI TEAM':
            return 'imgteam/tnk2020.png';
        case 'TNK FC':
            return 'imgteam/tnk2021.png';
        case 'TANUKI FC':
            return 'imgteam/tnk2022.png';
        case 'TNK OUTSIDE':
            return 'imgteam/tnkoutsidelogo.png';
        case 'DORTMUND':
            return 'imgteam/dortmundlogo.png';
        case 'BAYERN':
            return 'imgteam/bayernlogo.png';
        case 'HOUILLES AC':
            return 'imgteam/houillesaclogo.png';
        case 'MCES':
            return 'imgteam/mceslogo.png';
        case 'GO':
            return 'imgteam/gologo.png';
        case 'OPLON':
            return 'imgteam/oplonlogo.png';
        case 'G2':
            return 'imgteam/g2logo.png';
        case 'TOTTENHAM':
            return 'imgteam/tottenhamlogo.png';
        case 'JUVENTUS':
            return 'imgteam/juventuslogo.png';
        case 'LYON':
            return 'imgteam/lyonlogo.png';
        case 'MONACO':
            return 'imgteam/monacoaslogo.png';
        case 'DVM':
            return 'imgteam/dvmlogo.png';
        case 'INTER MILAN':
            return 'imgteam/intermilanlogo.png';
        case 'MILAN AC':
            return 'imgteam/milanaclogo.png';
        case 'ARSENAL':
            return 'imgteam/arsenallogo.png';
        case 'CHELSEA':
            return 'imgteam/chelsealogo.png';
        case 'MANCHESTER CITY':
            return 'imgteam/manchestercitylogo.png';
        case 'LIVERPOOL':
            return 'imgteam/liverpoollogo.png';
        case 'BARCELONA':
            return 'imgteam/barcelonalogo.png';
        case 'LIQUID':
            return 'imgteam/teamliquidlogo.png';
        case 'LE FIVE':
            return 'imgteam/lefivelogo.png';
        case 'URBAN SOCCER':
            return 'imgteam/urbansoccerlogo.png';
        case 'ZIDANE FC':
            return 'imgteam/zidanefclogo.png';
        case 'REAL MADRID':
            return 'imgteam/realmadridlogo.png';
        case 'PARIS FC':
            return 'imgteam/parisfclogo.png';
        case 'RACING CF':
            return 'imgteam/Racingcflogo.png';
        case 'PARIS 13':
            return 'imgteam/paris13logo.png';
        case 'RED STAR':
            return 'imgteam/redstarfclogo.png';
        case 'JOBLIFE':
            return 'imgteam/joblifelogo.png';
        case 'SOLARY':
            return 'imgteam/solarylogo.png';
        case 'VITALITY':
            return 'imgteam/vitalitylogo.png';
        case 'MANCHESTER UTD':
            return 'imgteam/manchesterutdlogo.png';
        case 'FNATIC':
            return 'imgteam/fnaticlogo.png';
        case 'GENTLE MATES':
            return 'imgteam/m8logo.png';
        case 'PARIS SG':
            return 'imgteam/psglogo.png';
        case 'KARMINE CORP':
            return 'imgteam/karminecorplogo.png';
        case 'MASIA UTD':
            return 'imgteam/masiaunitedlogo.png';
        case 'ARGENTEUIL FC':
            return 'imgteam/argenteuilfclogo.png';
        case 'BABINKS FC':
            return 'imgteam/fcbabinkslogo.png';
        case 'MANNSCHAFT':
            return 'imgteam/mannschaftlogo.png';
        case 'BTS SNIR':
            return 'imgteam/BTSSNIRLOGO.png';
        case 'BADR FC':
            return 'imgteam/hednubsfclogo2.png';
        case 'CERGY SELECAO':
            return 'imgteam/brazillogo.png';
        case 'CDA INCENDIE':
            return 'imgteam/cdalogo.png';
        case 'MANITA FC':
            return 'imgteam/fcmanitalogo.png';
        case 'BTS SIO':
            return 'imgteam/btssiologo.png';
        default:
            return $adversaire['CheminImage'];
    }
}

function displayLogoTNK($tnk)
{
    switch ($tnk) {
        case 'TNK INSIDE':
            return 'tnklogo.png';
        case 'TNK MANNSCHAFT':
            return 'tnkmannschaft.png';

        default:
            return $tnk['CheminImage'];
    }
}

function ajouterJoueur($numero, $surnom, $pays, $poste, $statut)
{
    // Se connecter à la base de données
    $pdo = gestionnaireDeConnexion();

    // Requête pour insérer les valeurs dans la table "joueurs"
    $query = $pdo->prepare("INSERT INTO joueurs (numero, surnom, pays, poste, statut) VALUES (:numero, :surnom, :pays, :poste, :statut)");
    $query->bindParam(":numero", $numero);
    $query->bindParam(":surnom", $surnom);
    $query->bindParam(":pays", $pays);
    $query->bindParam(":poste", $poste);
    $query->bindParam(":statut", $statut);

    // Exécuter la requête
    if ($query->execute()) {
        return true; // Retourner vrai si l'ajout a réussi
    } else {
        return false; // Retourner faux si l'ajout a échoué
    }
}

function supprimerJoueur($surnom)
{
    $pdo = gestionnaireDeConnexion();

    $query = $pdo->prepare("DELETE FROM joueurs WHERE surnom = :surnom");
    $query->bindParam(":surnom", $surnom);

    if ($query->execute()) {
        return true;
    } else {
        return false;
    }
}

function modifierJoueur($ancien_surnom, $nouveau_numero, $nouveau_surnom, $nouveau_pays, $nouveau_poste, $nouveau_statut)
{
    // Se connecter à la base de données
    $pdo = gestionnaireDeConnexion();

    // Requête pour mettre à jour les valeurs dans la table "joueurs"
    $query = $pdo->prepare("UPDATE joueurs SET numero = :nouveau_numero, surnom = :nouveau_surnom, pays = :nouveau_pays, poste = :nouveau_poste, statut = :nouveau_statut WHERE surnom = :ancien_surnom");
    $query->bindParam(":nouveau_numero", $nouveau_numero);
    $query->bindParam(":nouveau_surnom", $nouveau_surnom);
    $query->bindParam(":nouveau_pays", $nouveau_pays);
    $query->bindParam(":nouveau_poste", $nouveau_poste);
    $query->bindParam(":nouveau_statut", $nouveau_statut);
    $query->bindParam(":ancien_surnom", $ancien_surnom);

    // Exécuter la requête
    if ($query->execute()) {
        return true; // Retourner vrai si la modification a réussi
    } else {
        return false; // Retourner faux si la modification a échoué
    }
}


function ajouterMatch($Adversaire, $TypeMatch, $Stade, $DateMatch, $ScoreAdversaires, $ScoreTNK)
{

    $pdo = gestionnaireDeConnexion();


    $query = $pdo->prepare("INSERT INTO matchs (Adversaire, TypeMatch, Stade, DateMatch, ScoreAdversaires, ScoreTNK) VALUES (:Adversaire, :TypeMatch, :Stade, :DateMatch, :ScoreAdversaires, :ScoreTNK)");
    $query->bindParam(":Adversaire", $Adversaire);
    $query->bindParam(":TypeMatch", $TypeMatch);
    $query->bindParam(":Stade", $Stade);
    $query->bindParam(":DateMatch", $DateMatch);
    $query->bindParam(":ScoreAdversaires", $ScoreAdversaires);
    $query->bindParam(":ScoreTNK", $ScoreTNK);


    if ($query->execute()) {
        return true;
    } else {
        return false;
    }
}

function supprimerMatch($Adversaire, $DateMatch) {
    $pdo = gestionnaireDeConnexion();

    $query = $pdo->prepare("DELETE FROM matchs WHERE Adversaire = :Adversaire AND DateMatch = :DateMatch");
    $query->bindParam(":Adversaire", $Adversaire);
    $query->bindParam(":DateMatch", $DateMatch);

    if ($query->execute()) {
        return true; // Retourner vrai si la suppression a réussi
    } else {
        return false; // Retourner faux si la suppression a échoué
    }
}

function supprimerMatch2($matchId) {
    $pdo = gestionnaireDeConnexion();

    try {
        $query = $pdo->prepare("DELETE FROM matchs WHERE MatchID = :matchId");
        $query->bindParam(":matchId", $matchId);

        if ($query->execute()) {
            return true; // Retourner vrai si la suppression a réussi
        } else {
            return false; // Retourner faux si la suppression a échoué
        }
    } catch(PDOException $e) {
        // Gérer les erreurs de connexion à la base de données
        echo "Erreur de connexion : " . $e->getMessage();
        return false;
    }
}






function getDrapeau($pays)
{
    $pays_classes = array(
        'Algerie' => 'fi fi-dz',
        'France' => 'fi fi-fr',
        'Centrafrique' => 'fi fi-cf',
        'Maroc' => 'fi fi-ma',
        'Portugal' => 'fi fi-pt',
        'Haiti' => 'fi fi-ht',
        'Espagne' => 'fi fi-es',
        'Tunisie' => 'fi fi-tn',
        'Nigeria' => 'fi fi-ng',
        'Congo' => 'fi fi-cg',
        'Republique démocratique du Congo' => 'fi fi-cd',
        'Vietnam' => 'fi fi-vn',
        'Japon' => 'fi fi-jp',
        'Bresil' => 'fi fi-br',
        'Turquie' => 'fi fi-tr',
        'Ile de la Réunion' => 'fi fi-re',
        'Guadeloupe' => 'fi fi-gp',
        'Martinique' => 'fi fi-mq',
        'Senegal' => 'fi fi-sn',
        'Mali' => 'fi fi-ml',
        'Cote d\'Ivoire' => 'fi fi-ci',
        'Egypte' => 'fi fi-eg',
        'Cap-Vert' => 'fi fi-cv',

    );

    // Vérifier si le pays existe dans le tableau des classes
    if (array_key_exists($pays, $pays_classes)) {
        // Si oui, retourner la classe associée au pays
        return $pays_classes[$pays];
    } else {
        // Si le pays n'est pas trouvé dans le tableau, retourner une classe de drapeau par défaut
        return 'fi fi-xx'; // Remplacez 'bx bx-flag' par la classe de drapeau par défaut
    }
}

function ajouterComposition($matchId, $composition) {
    $pdo = gestionnaireDeConnexion();

    try {
        $query = "UPDATE matchs SET CompositionEquipe = ? WHERE MatchID = ?";
        $stmt = $pdo->prepare($query);
        return $stmt->execute([$composition, $matchId]);
    } catch (PDOException $e) {
        return false;
    }
}

function getCompositionDuMatch($matchId) {
    $pdo = gestionnaireDeConnexion();

    try {
        $query = "SELECT CompositionEquipe FROM matchs WHERE MatchID = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$matchId]);
        $result = $stmt->fetchColumn();
        return $result !== false ? $result : ''; // Si la composition est vide, retourne une chaîne vide
    } catch (PDOException $e) {
        return ''; // En cas d'erreur, retourne une chaîne vide
    }
}


function compterButsAdversairesConcedes()
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT SUM(ScoreAdversaires) AS total_buts_adversaires_concedes FROM matchs";
    $pdoStatement = $pdo->query($requeteSql);
    $resultat = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    $nombre_buts_adversaires_concedes = $resultat['total_buts_adversaires_concedes'];

    return $nombre_buts_adversaires_concedes;
}

function compterButsMarques()
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT SUM(ScoreTNK) AS total_buts_marques FROM matchs";
    $pdoStatement = $pdo->query($requeteSql);
    $resultat = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    $nombre_buts_marques = $resultat['total_buts_marques'];

    return $nombre_buts_marques;
}

function differenceButs()
{
    $buts_marques = compterButsMarques();
    $buts_concedes = compterButsAdversairesConcedes();

    $difference_buts = $buts_marques - $buts_concedes;

    return $difference_buts;
}

function getCompositionImageByMatchId($matchId) {
    $pdo = gestionnaireDeConnexion();

    try {
        $query = "SELECT CompositionImg FROM matchs WHERE MatchID = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$matchId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && isset($result['CompositionImg'])) {
            return $result['CompositionImg'];
        } else {
            // Retourner une image par défaut si aucune image n'est trouvée
            return "https://cdn.lineup-builder.co.uk/lineups/665466e821fcf1f1d3f1b146?t=1716807412012";
        }
    } catch (PDOException $e) {
        // Gérer les erreurs de requête
        return "https://cdn.lineup-builder.co.uk/lineups/665466e821fcf1f1d3f1b146?t=1716807412012";
    }
}

function ajouterCompositionImg($matchId, $compositionImg) {
    $pdo = gestionnaireDeConnexion();

    try {
        $query = "UPDATE matchs SET compositionImg = ? WHERE MatchID = ?";
        $stmt = $pdo->prepare($query);
        return $stmt->execute([$compositionImg, $matchId]);
    } catch (PDOException $e) {
        return false;
    }
}


function compterMatchsTotal()
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT COUNT(*) AS total_matchs FROM matchs";
    $pdoStatement = $pdo->query($requeteSql);
    $resultat = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    $total_matchs = $resultat['total_matchs'];

    return $total_matchs;
}

function compterAdversaireTotal()
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT  COUNT(distinct Adversaire) AS AdversaireTotal FROM matchs";
    $pdoStatement = $pdo->query($requeteSql);
    $resultat = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    $total_matchs = $resultat['AdversaireTotal'];

    return $total_matchs;
}
function nomAdversairePlusaffronte()
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT Adversaire, COUNT(*) AS NombreAffrontements
    FROM matchs
    GROUP BY Adversaire
    ORDER BY NombreAffrontements DESC
    LIMIT 1;
    ";
    $pdoStatement = $pdo->query($requeteSql);
    $resultat = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    $total_matchs = $resultat['Adversaire'];

    return $total_matchs;
}

function NombreNomAdversairePlusaffronte()
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT Adversaire, COUNT(*) AS NombreAffrontements
    FROM matchs
    GROUP BY Adversaire
    ORDER BY NombreAffrontements DESC
    LIMIT 1;
    ";
    $pdoStatement = $pdo->query($requeteSql);
    $resultat = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    $total_matchs = $resultat['NombreAffrontements'];

    return $total_matchs;
}

function ajouterButsJoueur($matchId, $numeroJoueur, $nombreButs) {
    $pdo = gestionnaireDeConnexion();

    try {
        $query = "INSERT INTO buts (MatchID, NumeroJoueur, NombreButs)
                  VALUES (?, ?, ?)
                  ON DUPLICATE KEY UPDATE NombreButs = VALUES(NombreButs)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$matchId, $numeroJoueur, $nombreButs]);
        
        return true;
    } catch (PDOException $e) {
        return false;
    }
}



function compterMatchsDefaites()
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT COUNT(*) AS total_matchs_defaites FROM matchs WHERE ScoreAdversaires > ScoreTNK";
    $pdoStatement = $pdo->query($requeteSql);
    $resultat = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    $nombre_matchs_defaites = $resultat['total_matchs_defaites'];

    return $nombre_matchs_defaites;
}

function compterMatchsVictoires()
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT COUNT(*) AS total_matchs_victoires FROM matchs WHERE ScoreTNK > ScoreAdversaires";
    $pdoStatement = $pdo->query($requeteSql);
    $resultat = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    $nombre_matchs_victoires = $resultat['total_matchs_victoires'];

    return $nombre_matchs_victoires;
}

function compterJoueursEffectifs()
{
    $pdo = gestionnaireDeConnexion();
    $requeteSql = "SELECT COUNT(*) AS total_joueurs_effectifs FROM joueurs WHERE STATUT='Disponible'";
    $pdoStatement = $pdo->query($requeteSql);
    $resultat = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    $total_joueurs_effectifs = $resultat['total_joueurs_effectifs'];

    return $total_joueurs_effectifs;
}

function joueurPlusJoue() {
    try {
        $pdo = gestionnaireDeConnexion();

        $query = "SELECT Numero, COUNT(*) AS nbMatchs FROM matchs, joueurs WHERE FIND_IN_SET(joueurs.Numero, matchs.CompositionEquipe) GROUP BY Numero ORDER BY nbMatchs DESC LIMIT 1";

        $pdoStatement = $pdo->query($query);

        $row = $pdoStatement->fetch(PDO::FETCH_ASSOC);
        $joueurNumero = $row['Numero'];
        $nombreMatchs = $row['nbMatchs'];

        $queryJoueur = "SELECT * FROM joueurs WHERE Numero = :numero";
        $queryJoueurParams = array(":numero" => $joueurNumero);

        $queryJoueurStatement = $pdo->prepare($queryJoueur);
        $queryJoueurStatement->execute($queryJoueurParams);

        $joueur = $queryJoueurStatement->fetch(PDO::FETCH_ASSOC);

        $pdo = null;

        return array("surnom" => $joueur['Surnom'], "nombreMatchs" => $nombreMatchs); // Retourne le surnom du joueur et le nombre de matchs joués
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
        return null;
    }
}



