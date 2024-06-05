<?php include_once 'affichage/_debut.inc.php'; ?>
<title>Effectif | Site Officiel TNK inside</title>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="TNK">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="apple-touch-icon" href="img/tnkicologo.png">
<link rel="icon" type="image/png" href="img/tnkicologo.png">
<link rel="apple-touch-startup-image" href="tnklogo.png">

<style>
#calendrier {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-evenly;
  padding: 20px;
  margin: auto;
}

.position-title {
  width: 100%;
  font-size: 24px;
  font-weight: bold;
  margin-top: 20px;
  color: #fff;
  text-align: center;
}

.player {
  flex: 0 1 calc(33.33% - 20px);
  box-sizing: border-box;
  border-radius: 8px;
  overflow: hidden;
  transition: transform 0.2s;
  margin-bottom: 10px;
  margin-top: 10px;
  text-align: center;
  color: #fff;
  padding: 20px;
  cursor: pointer;
  position: relative;
  background-color: #0d0f13;
  border: 1px solid #1d2026;
}

.player-renforts{
  border: 1px solid #C6DD71;
}

.player-ancien{
  border: 1px solid #C25151;
}

.player:hover {
  transform: scale(1.03);
}

.player-name {
  font-size: 20px;
  font-weight: bold;
  color: white;
  margin: 10px 0 5px;
}

.player-details {
  margin: 5px 0;
  color: white;
  font-size: 16px;
}

.player-details:hover{
  color: #daf37c;
}

.player-club {
  width: 30px; 
  height: auto;
  position: absolute;
  top: 10px;
  right: 10px;
}

.player-image {
  width: 260px; 
  height: auto;
}


.player-number {
  position: absolute;
  top: 10px;
  left: 10px;
  font-size: 24px;
  color: #ccc;
}

.player-position {
  font-size: 18px;
  color: #daf37c;
  margin-bottom: 5px;
}

.fiche-joueur {
  font-size: 16px;
  color: #ccc;
  margin-top: 20px;
  text-transform: uppercase;
}

@media (max-width: 768px) {
  .player {
    flex: 0 1 100%;
  }

  #mediacalenderhide {
    display: none;
  }
}
</style>

<?php include_once 'affichage/_debut.inc.php'; ?>
<title>Effectif | Site Officiel TNK inside</title>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="TNK">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="apple-touch-icon" href="img/tnkicologo.png">
<link rel="icon" type="image/png" href="img/tnkicologo.png">
<link rel="apple-touch-startup-image" href="tnklogo.png">

<style>
/* ... (votre CSS existant) ... */
</style>

<?php if (isset($_SESSION['username'])) {
  if ($_SESSION['username'] === 'adminbbet') {
    include_once 'formulaire/_effectif.formulaire.php';
  }
} ?>

<section class="calendrier" id="calendrier">
  <?php
$listeJoueurs = listeJoueurs();

// Organiser les joueurs par statut
$playersByStatus = [
    'Fondateur' => [],
    'Occasionnel' => []
];

foreach ($listeJoueurs as $joueur) {
    $statut = $joueur["Statut"];
    if ($statut === 'Disponible' || $statut === 'Indisponible') {
        $playersByStatus['Fondateur'][] = $joueur;
    } else {
        $playersByStatus['Occasionnel'][] = $joueur;
    }
}

// Afficher les joueurs par statut
foreach ($playersByStatus as $statut => $joueurs) {
    echo '<div class="position-title">' . $statut . '</div>';
    $count = 0;
    foreach ($joueurs as $joueur) {
        $count++;
        if ($count > 3) {
            $count = 1;
            echo '<div style="clear:both;"></div>';
        }

        $matchesPlayed = 0;
        $matchesPlayedList = nombreMatchsJoues();
        foreach ($matchesPlayedList as $match) {
            if ($match['Surnom'] === $joueur['Surnom']) {
                $matchesPlayed = $match['NombreMatchs'];
                break;
            }
        }

        $playerStatusClass = ($joueur["Statut"] === 'Indisponible') ? 'player-ancien' : '';
        if ($joueur["Club"] === '3') {
            $playerStatusClass = 'player-renforts';
            $playerImageSrc = 'img/imgteam/mannschaftlogo.png';
        } 
        elseif ($joueur["Club"] === '2') {
          $playerStatusClass = 'player-renforts';
          $playerImageSrc = 'img/imgteam/tnkoutsidelogo.png';
        }
        elseif ($joueur["Club"] === '6') {
          $playerStatusClass = 'player-renforts';
          $playerImageSrc = 'img/imgteam/hednubsfclogo2.png';
        }
        elseif ($joueur["Club"] === '5') {
          $playerStatusClass = 'player-renforts';
          $playerImageSrc = 'img/imgteam/brazillogo.png';
        }
        elseif ($joueur["Club"] === '4') {
          $playerStatusClass = 'player-renforts';
          $playerImageSrc = 'img/imgteam/BTSSNIRLOGO.png';
        } else {
            $playerImageSrc = 'img/tnklogo.png';
        }

        $playerImage2Src = 'img/mbappse.png';

        echo '<div id="effectif" class="player ' . $playerStatusClass . '" data-numero="' . $joueur["Numero"] . '">';
        echo '<div class="player-number">' . $joueur["Numero"] . '</div>';
        echo '<img id="mediacalenderhide" class="player-club" src="'. $playerImageSrc .'" alt="Player Image">';
        echo '<div id="effectif-pose" class="player-info">';
        echo '<p class="player-position">' . $joueur["Poste"] . '</p>';
        echo '<h2 class="player-name" id="effectiff">' . $joueur["Surnom"] . '</h2>';
        echo '<span><a style="text-decoration: none;" class="player-details" href="effectif_details.php?joueur_numero=' .  $joueur["Numero"] . '">Fiche du joueur</a></span>';
        echo '</div>';
        echo '</div>';
    }
}
?>
</section>

<div id='space'></div>

<script>
document.querySelectorAll('.player').forEach(player => {
  player.addEventListener('click', function() {
    const numero = this.getAttribute('data-numero');
    window.location.href = 'effectif_details.php?joueur_numero=' + numero;
  });
});
</script>

<?php include_once 'affichage/_fin.inc.php'; ?>
