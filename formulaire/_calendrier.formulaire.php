<?php
if ($_SESSION['username'] !== 'adminbbet') {
    header('Location: /bolista/index.php');
    exit();
}
?>

<title>Formulaire de saisie de match</title>

<style>
  #formebackground {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: flex-start;
    padding: 20px;
    gap: 20px; /* Espace entre les deux formulaires */
  }

  .form-container {
    width: 100%;
    max-width: 480px;  /* Limite la largeur maximale des formulaires */
    padding: 20px;
    background-color: #0d0f13;
    border-radius: 10px;
    border: 1px solid #1d2026;
    box-sizing: border-box;
    flex: 1 1 480px; /* Flex grow, shrink et basis pour une largeur réactive */
  }

  form label {
    display: block;
    width: 100%;
    font-weight: bold;
    color: white;
    margin-bottom: 5px;
  }

  form input[type="text"],
  form input[type="number"],
  form input[type="date"],
  form select {
    width: 100%;
    padding: 10px;
    color: white;
    background-color: #090a0d;
    border: 1px solid #1d2026;
    border-radius: 5px;
    margin-bottom: 10px;
    box-sizing: border-box;
  }

  form input[type="submit"] {
    width: 100%;
    padding: 10px;
    color: black;
    background-color:  #daf37c;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    transition: background-color 0.3s ease;

  }

  form input[type="submit"]:hover {
    background-color: black;
    color: #daf37c;
    }

  .form-row {
    margin-bottom: 10px;
  }
</style>

<section id="formebackground">
  <div class="form-container">
    <form id="formcalendrier" action="traitement/_calendrier.ajouter.php" method="post">
      <div class="form-row">
        <label for="Adversaire">Adversaire :</label>
        <select id="Adversaire" name="Adversaire" required>
          <?php $listeAdversaires = listeAdversaires();
          foreach ($listeAdversaires as $adversaire): ?>
            <option value="<?php echo $adversaire['nom']; ?>"><?php echo $adversaire['nom']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-row">
        <label for="TypeMatch">Type de Match :</label>
        <select id="TypeMatch" name="TypeMatch" required>
          <option value="Amical">Amical</option>
          <option value="Tournoi">Tournoi</option>
          <option value="Championnat">Championnat</option>
        </select>
      </div>

      <div class="form-row">
        <label for="ScoreAdversaires">Buts Adversaires :</label>
        <input type="number" id="ScoreAdversaires" name="ScoreAdversaires" min="0" required>
      </div>

      <div class="form-row">
        <label for="ScoreTNK">Buts TNK :</label>
        <input type="number" id="ScoreTNK" name="ScoreTNK" min="0" required>
      </div>

      <div class="form-row">
        <label for="Stade">Lieu :</label>
        <select id="Stade" name="Stade" required>
          <?php $listeLieux = listeStade();
          foreach ($listeLieux as $Stade): ?>
            <option value="<?php echo $Stade['Nom'] . ' - ' . $Stade['Ville']; ?>">
              <?php echo $Stade['Nom'] . ' - ' . $Stade['Ville']; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-row">
        <label for="DateMatch">Date :</label>
        <input type="date" id="DateMatch" name="DateMatch" required>
      </div>

      <input type="submit" value="Ajouter un match">
    </form>
  </div>

  <div class="form-container">
  <form id="formcalendriers" method="post" action="traitement/_calendrier.supprimer.php" onsubmit="return confirmDelete();">
        <div class="form-row">
            <label for="Adversaire">Adversaire :</label>
            <select id="Adversaire" name="Adversaire" required>
                <?php $listeAdversaires = listeAdversaires();
                foreach ($listeAdversaires as $adversaire): ?>
                    <option value="<?php echo $adversaire['nom']; ?>"><?php echo $adversaire['nom']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-row">
            <label for="DateMatch">Date :</label>
            <input type="date" id="DateMatch" name="DateMatch" required>
        </div>

        <input type="submit" value="Supprimer un match">
    </form>
</div>

</section>
<script>
    function confirmDelete() {
        return confirm('Voulez-vous vraiment supprimer ce match ?');
    }
</script>
