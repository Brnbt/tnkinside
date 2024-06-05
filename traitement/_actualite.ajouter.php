<?php
// Inclure le fichier de fonctions
require_once '_fonctions.inc.php';

// Vérifier si le formulaire d'ajout a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $date = $_POST['date'];
    $video_url = $_POST['video_url']; // Récupérer le lien de la vidéo YouTube ou du tweet
    
    // Extraire l'identifiant de la vidéo YouTube ou du tweet à partir du lien
    $video_id = ""; // Initialiser une variable pour stocker l'identifiant de la vidéo ou du tweet
    
    // Vérifier si c'est un lien YouTube
    if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
        // Extraire l'identifiant de la vidéo YouTube
        $query_string = parse_url($video_url, PHP_URL_QUERY);
        parse_str($query_string, $params);
        $video_id = $params['v'] ?? ''; // Si c'est une vidéo YouTube, récupérer l'identifiant
    }
    
    // Initialiser la variable pour le nom du fichier d'image
    $image_name = null;

    // Vérifier si un fichier d'image a été téléchargé
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Récupérer les informations sur le fichier
        $file_tmp_name = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        
        // Définir le répertoire de destination relatif au script actuel
        $upload_directory = '../img/actualite/uploads/'; // Ajustez le chemin pour qu'il soit relatif à votre script

        // Créer le répertoire s'il n'existe pas
        if (!is_dir($upload_directory)) {
            mkdir($upload_directory, 0755, true);
        }

        // Créer un nom unique pour le fichier
        $file_destination = $upload_directory . uniqid() . '_' . $file_name;
        
        // Déplacer le fichier téléchargé vers le répertoire de destination
        if (move_uploaded_file($file_tmp_name, $file_destination)) {
            // Si l'image est téléchargée avec succès, obtenir uniquement le nom du fichier
            $image_name = basename($file_destination);
        } else {
            // Gérer l'erreur si le déplacement du fichier a échoué
            echo "Erreur : Impossible de déplacer le fichier téléchargé.";
            exit();
        }
    }
    
    // Appeler la fonction pour ajouter l'actualité avec le contenu mis à jour
    if (ajouterActualite($titre, $contenu, $date, $image_name, $video_url)) {
        // Rediriger avec un message de succès
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // Rediriger avec un message d'erreur
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    // Si le formulaire n'a pas été soumis via la méthode POST, rediriger l'utilisateur vers une autre page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
