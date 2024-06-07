<?php include_once 'affichage/_debut.inc.php'; ?>

<title>Actualités | Site Officiel TNK inside</title>

<?php if (isset($_SESSION['username'])) {
  if ($_SESSION['username'] === 'adminbbet') {
    include_once 'formulaire/_actualite.formulaire.php';
  }
}
?>

<?php
$actualites = getAllActualites();

usort($actualites, function($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});

if (!empty($actualites)) {
    
    $groupesActualites = array_chunk($actualites, 3);
    
    foreach ($groupesActualites as $groupe) {
        ?>
        <div class="actualites-container">
            <?php 
            foreach ($groupe as $actualite) { ?>
                <div class="actualite" style="border: 1px solid #1d2026;">
                    <a href="actualites_details.php?actualites_id=<?php echo $actualite['id']; ?>" class="actualite actualite-<?php echo $count; ?>">
                    <?php if (!empty($actualite['image_url'])) { ?>
                        <img class="image-actualite" src="img/actualite/uploads/<?php echo $actualite['image_url']; ?>" alt="Image de l'actualité">
                    <?php } ?>

                    <?php 
                    if (!empty($actualite['video_url'])) {
                        $video_id = ""; // Initialiser une variable pour stocker l'identifiant de la vidéo
                        if (strpos($actualite['video_url'], 'youtube.com') !== false || strpos($actualite['video_url'], 'youtu.be') !== false) {
                            // Extraire l'identifiant de la vidéo YouTube
                            $query_string = parse_url($actualite['video_url'], PHP_URL_QUERY);
                            parse_str($query_string, $params);
                            $video_id = $params['v'] ?? ''; // Si c'est une vidéo YouTube, récupérer l'identifiant
                        }
                        // Afficher la vidéo dans un iframe
                        if (!empty($video_id)) {
                            echo '<div class="video-container"><iframe src="https://www.youtube.com/embed/' . $video_id . '" frameborder="0" allowfullscreen></iframe></div>';
                        }
                    }
                    ?>
                    <div class="contenu">
                        <h2><?php echo $actualite['titre']; ?></h2>
                        <div style='height: 10px'></div>
                        <p><?php echo $actualite['date']; ?></p>
                        <div style='height: 10px'></div>
                        <p>
                        <?php 
                            $contenu = $actualite['contenu'];
                            if (strlen($contenu) > 160) {
                                $contenu = substr($contenu, 0, 160) . '...';
                             }
                            echo $contenu;
                        ?>
                        </p>
                    </div>
                    </a>
                </div>
            <?php } ?>
        </div>
        <?php
    }
} else {
    echo "Aucune actualité trouvée.";
}
?>


<style>
    .actualites-container {
        display: flex;
        justify-content: space-evenly;
        margin-top: 20px;
        padding-bottom: 20px;
        align-items: stretch; /* Align items to stretch */
        flex-wrap: wrap;
    }

    .actualite {
        background-color: #0d0f13;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        overflow: hidden;
        flex-basis: calc(33.33% - 20px); 
        box-sizing: border-box; 
        position: relative;
        transition: transform 0.2s;
    }

    .actualite:hover {
        transform: scale(1.03);
    }

    .actualite a {
        text-decoration: none; 
    }

    .actualite:last-child {
        margin-right: 0; 
    }

    .actualite img {
        border-radius: 10px;
        margin-bottom: 10px;
        display: block;
        width: 100%; 
        height: auto; 
    }

    .contenu {
        text-align: center;
    }

    .contenu h2 {
        font-size: 18px;
        color: #daf37c;
        margin-bottom: 5px;
    }

    .contenu p {
        font-size: 14px;
        color: #ffffff;
        margin-bottom: 5px;
    }

    .contenu p:first-child {
        margin-top: 5px;
    }

    .contenu p:last-child {
        margin-bottom: 0;
    }

    .video-container {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* Maintain 16:9 aspect ratio */
        margin-bottom: 10px; /* Add margin to separate from other content */
    }

    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 10px; /* Match the border radius of other elements */
    }

    .lightbox {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .lightbox img {
        max-width: 90%;
        max-height: 90%;
    }

    @media (max-width: 600px) {
        .actualites-container {
            flex-direction: column;
            align-items: center;
            width: 90%;
            margin : auto;
            margin-top: 10px;
        }

        .actualite {
            flex-basis: 100%;
            margin-bottom: 20px;
        }

        .contenu h2 {
            font-size: 16px;
        }

        .contenu p {
            font-size: 12px;
        }

        .video-container iframe {
            width: 100%;
            height: auto;
        }
    }
</style>

<?php include_once 'affichage/_fin.inc.php'; ?>
