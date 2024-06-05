<?php

if ($_SESSION['username'] !== 'adminbbet') {
    header('Location: /bolista/index.php');
    exit();
}

$actualites = getAllActualites();

// Trier les actualités par date décroissante
usort($actualites, function($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});

?>

<div class="forms-container">
    <section class="section-container">
        <div class="form-container">
            <h2 class="form-title">Ajouter une actualité</h2>
            <form action="traitement/_actualite.ajouter.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <label class="form-label" for="titre">Titre :</label>
                    <input class="form-input" type="text" id="titre" name="titre" required>
                </div>
                <div class="form-row">
                    <label class="form-label" for="contenu">Contenu :</label>
                    <textarea class="form-input" id="contenu" name="contenu" rows="4" required></textarea>
                </div>
                <div class="form-row">
                    <label class="form-label" for="date">Date :</label>
                    <input class="form-input" type="date" id="date" name="date" required>
                </div>
                <div class="form-row">
                    <label class="form-label" for="image">Image :</label>
                    <input class="form-input" type="file" id="image" name="image" accept="image/*">
                </div>
                <div class="form-row">
                    <label class="form-label" for="video_url">Lien de la vidéo YouTube :</label>
                    <input class="form-input" type="url" id="video_url" name="video_url" placeholder="https://www.youtube.com/watch?v=xxxxxx">
                </div>
                <div class="form-row">
                    <input class="form-submit" type="submit" value="Ajouter">
                </div>
            </form>
        </div>
    </section>

    <section class="section-container">
        <div class="form-container">
            <h2 class="form-title">Supprimer une actualité</h2>
            <form action="traitement/_actualite.supprimer.php" method="post">
                <div class="form-row">
                    <label class="form-label" for="actualite">Sélectionnez une actualité :</label>
                    <select class="form-input" id="actualite" name="actualite_id" required>
                        <?php foreach ($actualites as $actualite) : ?>
                            <option value="<?= $actualite['id'] ?>"><?= htmlspecialchars($actualite['titre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-row">
                    <input class="form-submit" type="submit" value="Supprimer">
                </div>
            </form>
        </div>
    </section>
</div>

<style>

/* Changement du fond des champs d'entrée */
.form-input {
    background-color: #090a0d;
    border-radius: 5px; 
    padding: 10px; 
    box-sizing: border-box; 
    color: white;
    border: 1px solid #1d2026;
    width: 100%; /* Assure que l'input prend toute la largeur disponible */
}

.form-submit {
    transition: background-color 0.3s ease;
    color: black;
    background-color:  #daf37c;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.form-submit:hover{
    background-color: black;
    color: #daf37c;
}

.section-container {
    padding: 20px;
    border: 1px solid #1d2026;
    background-color: #0d0f13;
    border-radius: 10px;
    width: 45%; 
    max-width: 500px; 
    margin: 10px; 
    color:white;
}

.form-container {
    width: auto;
}

.form-title {
    font-size: 24px;
    margin-bottom: 20px;
}

.form-label {
    font-weight: bold;
    width: 100%; /* Assure que le label prend toute la largeur */
    margin-bottom: 5px; /* Ajoute de l'espace sous le label */
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 10px;
    width: 100%;
}

.error-message {
    color: red;
    margin-top: 5px;
    font-size: 14px;
}

.forms-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

/* Style du bouton "Choisir un fichier" */
.form-input[type="file"] {
    color: white;
    background-color: #090a0d;
    border: 1px solid #1d2026;
    border-radius: 5px;
    padding: 10px;
    width: 100%;
    box-sizing: border-box;
}

.form-input[type="file"]::-webkit-file-upload-button:hover{
    background-color: black;
    color: #daf37c;
}

.form-input[type="file"]::-webkit-file-upload-button {
    color: black;
    background-color:  #daf37c;
    border: 1px solid #1d2026;
    border-radius: 5px;
    padding: 10px;
    cursor: pointer;
}


/* Responsive adjustments */
@media (max-width: 768px) {
    .section-container {
        width: 100%;
        margin: 10px 0;
    }
}

</style>
