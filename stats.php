<?php include_once 'affichage/_debut.inc.php'; ?>
<title>Stats | Site Officiel TNK inside</title>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=device-width, initial-scale=1" />

<section id="stats">
  <div class="stats">
    <div class="nombrevictoires">
      <p>Buts marqués</p>
      <p class="victoire">
        <?php echo compterButsMarques(); ?>
      </p>
    </div>
    
    <canvas id="butMarqueButConcede"></canvas>

    <div class="nombredefaites">
      <p>Buts concédés</p>
      <p class="defaite">
        <?php echo compterButsAdversairesConcedes(); ?>
      </p>
    </div>
  </div>

  <div class="stats">
    <div class="nombrevictoires">
      <p>Différence de buts</p>
      <p class="<?php if (differenceButs() < 0) {
        echo "defaite";
      } elseif (differenceButs() > 0) {
        echo "victoire";
      } else {
        echo "nul";
      }

      ?>">
        <?php echo differenceButs(); ?>
      </p>
    </div>
  </div>

  <div class="stats">
    <div class="nombrevictoires">
      <p>Total de matchs</p>
      <p class="nul">
        <?php echo compterMatchsTotal(); ?>
      </p>
    </div>
    <div class="nombrevictoires">
      <p>Victoires</p>
      <p class="victoire">
        <?php echo compterMatchsVictoires(); ?>
      </p>
    </div>
    <div class="nombredefaites">
      <p>Defaites</p>
      <p class="defaite">
        <?php echo compterMatchsDefaites(); ?>
      </p>
    </div>
    <div class="nombrenuls">
      <p>Nuls</p>
      <p class="nul">0</p>
    </div>
  </div>

  <div class="stats">
    <div class="nombrenuls">
      <p>Joueurs dans l'effectif</p>
      <p class="nul">
        <?php echo compterJoueursEffectifs(); ?>
      </p>
    </div>
  </div>

  <div class="stats">
    <div class="nombrevictoires">
      <p>Adversaires affrontés</p>
      <p class="nul">
        <?php echo compterAdversaireTotal(); ?>
      </p>
    </div>
    <div class="nombrevictoires">
      <p>Adversaire le plus affronté</p>
      <p class="nul">
        <?php echo nomAdversairePlusaffronte(); ?>
      </p>
    </div>
  </div>

  <div class="stats">
  <div class="nombrevictoires">
    <p>Joueur le plus capé</p>
    <?php 
    $joueurInfo = joueurPlusJoue();
    if ($joueurInfo !== null) {
        echo '<p class="nul">' . $joueurInfo["surnom"] . '</p>';
        echo '<p class="nul">Nombre de matchs : ' . $joueurInfo["nombreMatchs"] . '</p>';
    } else {
        echo '<p class="nul">Aucun joueur trouvé.</p>';
    }
    ?>
  </div>

  <div class="nombrevictoires">
        <p>Meilleur buteur du club</p>
        <?php 
        $meilleurButeur = meilleurButeur();
        if ($meilleurButeur !== false) {
            echo '<p class="nul">' . $meilleurButeur["Surnom"] . '</p>';
            echo '<p class="nul">Nombre de buts : ' . $meilleurButeur["TotalButs"] . '</p>';
        } else {
            echo '<p class="nul">Aucun buteur trouvé.</p>';
        }
        ?>
    </div>

</div>

</section>

<?php include_once 'affichage/_fin.inc.php'; ?>



<script>
  const ctx = document.getElementById('butMarqueButConcede');

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['BUTS CONCÉDÉS', 'BUTS MARQUÉS'],
      datasets: [{
        backgroundColor: ['red', 'greenyellow'],
        borderColor: ['black', 'black'],
        data: [<?php echo compterButsAdversairesConcedes(); ?>, <?php echo compterButsMarques(); ?>],
        borderWidth: 1
      }]
    },
    options: {
      responsive: false,
      maintainAspectRatio: false,
      width: 400,
      height: 400,
      plugins: {
        legend: {
          display: false
        }
      }
    }
  });

  ctx.addEventListener("mouseenter", function () {
  });

  ctx.addEventListener("mouseleave", function () {
  });
</script>

<style>
  body {
  margin: 0;
  padding: 0;
}

#stats {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.stats {
  display: flex;
  justify-content: space-around;
  align-items: center;
  flex-wrap: wrap;
  margin-bottom: 20px;
  border: 1px solid #1d2026;
  padding: 20px;
  border-radius: 10px;
  background-color: #0d0f13;
  color: white;
}

.stats p {
  margin: 5px 0;
  font-size: 18px;
  text-align: center;
}

.nombrevictoires, .nombredefaites, .nombrenuls {
  flex: 1;
  margin: 10px;
}

.victoire {
  color: greenyellow;
  font-weight: bold;
}

.defaite {
  color: red;
  font-weight: bold;
}

.nul {
  color: gray;
  font-weight: bold;
}

canvas {
  margin: 20px auto;
  display: block;
  max-width: 100%;
}

@media (max-width: 768px) {
  .stats {
    flex-direction: column;
  }
  
  .nombrevictoires, .nombredefaites, .nombrenuls {
    margin: 10px 0;
  }
}

</style>