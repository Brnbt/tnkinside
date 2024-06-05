<!DOCTYPE html>
<html lang="fr">

<?php include_once 'affichage/_debut.inc.php'; ?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacter le support</title>
    <link rel="stylesheet" href="style.css">
    <!-- Ajoutez d'autres liens vers des feuilles de style ou des bibliothèques JavaScript si nécessaire -->
</head>

<body>
    <header>
        <!-- Ajoutez votre barre de navigation ici si nécessaire -->
    </header>

    <div style="height: 50px"></div>


    <main>
    <a href="javascript:history.go(-1)" style="text-decoration: none; color: white; margin-left: 450px;"><i class='bx bx-arrow-back'></i> Retour</a>
        <section class="contact-form">
            <h1>Contacter le support</h1>
            <p>Remplissez le formulaire ci-dessous pour nous contacter. Nous vous répondrons dans les plus brefs délais.</p>
            <form action="envoyer_email.php" method="POST">
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input class="inputtextemail" type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="email">Adresse e-mail :</label>
                    <input class="inputtextemail" type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="sujet">Sujet :</label>
                    <input class="inputtextemail" type="text" id="sujet" name="sujet" required>
                </div>
                <div class="form-group">
                    <label for="message">Message :</label>
                    <textarea id="message" name="message" rows="4" required></textarea>
                </div>
                <button id="buttonsub" type="submit">Envoyer</button>
            </form>
        </section>
    </main>

    <footer>
        <!-- Ajoutez votre pied de page ici si nécessaire -->
    </footer>
</body>

<style>
    body {
    font-family: 'Geologica', sans-serif;
    background-color: #090a0d;
    color: white;
    margin: 0;
    padding: 0;
}


main {
    padding: 20px;
}

.contact-form {
    max-width: 700px;
    margin: auto;
    background-color: #12151b;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

.contact-form h1 {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

.inputtextemail,
textarea {
    width: 80%;
    padding: 10px;
    border: 1px solid #1d2026;
    background-color: #090a0d;
    color: white;
    border-radius: 5px;
}

textarea {
    resize: vertical;
}

#buttonsub {
    background-color: #1d2026;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #0b0c10;
}

</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var form = document.getElementById("contact-form");

        form.addEventListener("submit", function (event) {
            // Empêcher l'envoi du formulaire par défaut
            event.preventDefault();

            // Rediriger en fonction du client de messagerie
            var email = document.getElementById("email").value;
            if (email.endsWith("@gmail.com")) {
                window.location.href = "https://mail.google.com";
            } else if (email.endsWith("@yahoo.com")) {
                window.location.href = "https://mail.yahoo.com";
            } else if (email.endsWith("@outlook.com") || email.endsWith("@hotmail.com")) {
                window.location.href = "https://outlook.live.com";
            } else {
                // Redirection par défaut si le domaine de messagerie n'est pas reconnu
                window.location.href = "https://mail.example.com";
            }
        });
    });
</script>



<?php include_once 'affichage/_fin.inc.php'; ?>

</html>
