<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .actualites-container {
            display: flex;
            justify-content: space-evenly;
            margin-top: 20px;
            overflow-x: auto;
            padding-bottom: 20px;
            align-items: center;
            flex-wrap: wrap;
            
        }

        .actualite {
            background-color: #0d0f13;
            border-radius: 10px;
            border: 1px solid #1d2026;
            padding: 15px;
            margin-bottom: 20px;
            overflow: hidden;
            text-align: center;
            flex: 1 1 30%;
            max-width: 30%;
            box-sizing: border-box;
            transition: transform 0.7s;
            text-decoration: none;
        }

        .actualite:hover{
        transform: scale(1.05);
        }

        .actualite img {
            border-radius: 10px;
            margin-bottom: 10px;
            display: block;
            width: 100%;
            height: auto;
            max-width: 100%;
        }

        .contenu {
            margin:auto;
            text-align: center;
            text-decoration: none;
            color: white;
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
            width: 100%;
        }

        .contenu p:first-child {
            margin-top: 5px;
        }

        .contenu p:last-child {
            margin-bottom: 0;
        }

        .voirmatch {
            margin-top: 30px;
            text-align: center;
            padding: 6px 2px;
        }

        .voirmatch a {
            padding: 9px 25px;
            text-decoration: none;
            font-weight: bold;
            color: rgb(255, 253, 253);
            border: none;
            background-color: #0d0f13;
            border: #1d2026 1px solid;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.8s ease 0s;
        }

        .voirmatch a:hover {
            color: #daf37c;
            background-color: #0d0f13;
            border: #1e232d 1px solid;
        }

        iframe{
            border-radius: 18px;
        }

        @media (max-width: 1200px) {
            .actualite {
                flex: 1 1 45%;
                max-width: 45%;
            }
        }

        @media (max-width: 768px) {
            .actualite {
                flex: 1 1 100%;
                max-width: 90%;
            }
        }

        .video-container {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 aspect ratio (height/width * 100) */
            margin-bottom: 10px;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
    <title>Actualités</title>
</head>

<?php
$actualites = getAllActualites();

if (!empty($actualites)) {
    usort($actualites, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    $troisDernieresActualites = array_slice($actualites, 0, 3);
?>
<div class="actualites-container">
    <?php 
    $count = 1;
    foreach ($troisDernieresActualites as $actualite) { ?>
        <a href="actualites_details.php?actualites_id=<?php echo $actualite['id']; ?>" class="actualite actualite-<?php echo $count; ?>">
            <div>
                <?php if (!empty($actualite['image_url'])) { ?>
                    <img class="image-actualite" src="img/actualite/uploads/<?php echo $actualite['image_url']; ?>" alt="Image de l'actualité">
                <?php } ?>

                <?php 
                if (!empty($actualite['video_url'])) {
                    $video_id = "";
                    if (strpos($actualite['video_url'], 'youtube.com') !== false || strpos($actualite['video_url'], 'youtu.be') !== false) {
                        $query_string = parse_url($actualite['video_url'], PHP_URL_QUERY);
                        parse_str($query_string, $params);
                        $video_id = $params['v'] ?? ''; 
                    }
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
                    <?php 
                        $contenu = $actualite['contenu'];
                        if (strlen($contenu) > 160) {
                            $contenu = substr($contenu, 0, 160) . '...';
                        }
                        echo $contenu;
                    ?>               
                </div>
            </div>
        </a>
    <?php 
    $count++;
    } ?>
</div>
<?php
} else {
    echo "Aucune actualité trouvée.";
}
?>
<div class="voirmatch">
    <a href="actualites.php">VOIR TOUTES LES ACTUALITÉS</a>
</div>

