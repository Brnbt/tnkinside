<?php
require_once 'traitement/_fonctions.inc.php';

if (isset($_GET['actualites_id'])) {
    $actualiteID = $_GET['actualites_id'];
    $ActualiteDetails = getActualiteById($actualiteID);
    $video_id = getYouTubeVideoId($ActualiteDetails['video_url']);
}

include_once 'affichage/_debut.inc.php';
?>

<title>Actualités | Site Officiel TNK inside</title>

<div class="article">
       
    <h2><?php echo $ActualiteDetails['titre']; ?></h2>
    <?php if ($ActualiteDetails['image_url']) : ?>
        <img src="img/actualite/uploads/<?php echo $ActualiteDetails['image_url']; ?>" alt="Image de l'actualité">
    <?php endif; ?>
    <?php if ($video_id) : ?>
        <div class="video-container">
            <iframe src="https://www.youtube.com/embed/<?php echo $video_id; ?>" frameborder="0" allowfullscreen></iframe>
        </div>
    <?php endif; ?>
    <p>Date : <?php echo $ActualiteDetails['date']; ?></p>
    <div class="contenu">
        <?php echo $ActualiteDetails['contenu']; ?>
    </div>
</div>

<?php include_once 'affichage/_fin.inc.php'; ?>


<style>
.article {
    margin: 20px auto;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    padding: 10px;
}

.article h2 {
    font-size: 2rem;
    color: #FFF;
    margin: auto;

    margin-bottom: 1rem;
}

.article p {
    font-size: 0.875rem;
    color: #888;
    margin-bottom: 10px;
    width:40%;
    margin: auto;

}

.article img {
    max-width: 100%;
    border-radius: 15px;
    margin-bottom: 1rem;
}

.article .video-container {
    position: relative;
    width: 100%;
    margin-bottom: 1rem;
}

.article iframe {
    width: 50%;
    height: 500px;
    border: none;
    border-radius: 15px;
    margin-bottom: 10px;
}

.article .contenu {
    font-size: 1rem;
    color: #FFF;
    line-height: 1.6;
    text-align: center;
    margin: 0 auto;
    width:50%;
}

</style>
