<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Formulaire d'ajout d'effectif</title>
<style>
  #forme {
    display: flex;
    justify-content: center; /* Pour centrer les formulaires horizontalement */
  }

  .form-container {
    display: inline-block;
    margin-right: 20px; /* Espacement entre les formulaires */
  }

  #formcalendriers {
    max-width: 400px;
    padding: 20px;
    background-color: #0d0f13;
    border-radius: 10px;
    border: 1px solid #1d2026;
    margin-bottom: 30px;
  }

  form label {
    display: inline-block;
    width: 100px;
    font-weight: bold;
    color: white;
  }

  form input[type="text"],
  form input[type="number"],
  form select {
    color: #fff;
    width: 250px;
    padding: 5px;
    background-color: #090a0d;
    border: 1px solid #1d2026;
    border-radius: 5px;
    margin-bottom: 10px;
  }

  form input[type="submit"] {
    width: 100%;
    padding: 10px;
    color: black;
    background-color:  #daf37c;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  form input[type="submit"]:hover {
    background-color: black;
    color: #daf37c;
  }

  @media only screen and (min-width: 768px) and (max-width: 991px) {
    #forme {
      display: block; /* Affiche les formulaires en bloc */
    }

    .form-container {
      display: block; /* Affiche les conteneurs en bloc */
      margin: 0 auto 20px; /* Centre les conteneurs horizontalement */
    }
  }
</style>
</head>
<body>

<div id="forme">
  <div class="form-container">
    <form id="formcalendriers" action="traitement/_effectif.ajouter.php" method="post">
      <label for="numero">Numéro :</label>
      <input type="number" id="numero" name="numero" min="0" required><br>

      <label for="surnom">Surnom :</label>
      <input type="text" id="surnom" name="surnom" required><br>

      <label for="pays">Pays :</label>
      <select id="pays" name="pays" required>
        <option value="">Sélectionnez un pays</option>
      <option value="Angleterre">Angleterre</option>
      <option value="Algerie">Algerie</option>
      <option value="France">France</option>
      <option value="Centrafrique">Centrafrique</option>
      <option value="Maroc">Maroc</option>
      <option value="Portugal">Portugal</option>
      <option value="Haïti">Haïti</option>
      <option value="Espagne">Espagne</option>
      <option value="Tunisie">Tunisie</option>
      <option value="Nigeria">Nigeria</option>
      <option value="Congo">Congo</option>
      <option value="Republique démocratique du Congo">Republique démocratique du Congo</option>
      <option value="Vietnam">Vietnam</option>
      <option value="Japon">Japon</option>
      <option value="Brésil">Brésil</option>
      <option value="Turquie">Turquie</option>
      <option value="Ile de la Réunion">Ile de la Réunion</option>
      <option value="Guadeloupe">Guadeloupe</option>
      <option value="Martinique">Martinique</option>
      <option value="Sénégal">Sénégal</option>
      <option value="Mali">Mali</option>
      <option value="Cote d'Ivoire">Cote d'Ivoire</option>
      <option value="Egypte">Égypte</option>
      <option value="Cap-Vert">Cap-Vert</option>      </select><br>

      <label for="poste">Poste :</label>
      <select id="poste" name="poste" required>
      <option value="">Choisir</option>
      <option value="Gardien">Gardien</option>
      <option value="Defenseur">Defenseur</option>
      <option value="Milieu">Milieu</option>
      <option value="Attaquant">Attaquant</option>
      </select><br>

      <label for="statut">Statut :</label>
      <select id="statut" name="statut" required>
      <option value="Joueur">Disponible</option>
      <option value="Indisponible">Indisponible</option>
      <option value="Occasionnel">Occasionnel</option>
      </select><br>

      <input id="ajoutereffectif" type="submit" value="Ajouter">
    </form>
  </div>

  <div class="form-container">
    <form id="formcalendriers" action="traitement/_effectif.supprimer.php" method="post">
      <label for="surnom">Joueur à supprimer :</label>
      <input type="text" id="surnom" name="surnom" required><br>

      <input type="submit" name="supprimer" value="Supprimer">
    </form>
  </div>
</div>

</body>
</html>
