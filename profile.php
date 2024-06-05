<?php 
include_once 'affichage/_debut.inc.php'; 
include_once 'traitement/_fonctions.inc.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $message = 'Le nouveau mot de passe et la confirmation ne correspondent pas.';
    } else {
        if (changerMotDePasse($username, $oldPassword, $newPassword)) {
            $message = 'Mot de passe changé avec succès.';
        } else {
            $message = 'Échec de la modification du mot de passe. Veuillez vérifier votre ancien mot de passe.';
        }
    }
}

$username = $_SESSION['username'];
try {
    $pdo = gestionnaireDeConnexion();
    $query = $pdo->prepare("SELECT * FROM utilisateurs WHERE username = :username");
    $query->bindParam(":username", $username);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "Erreur : Utilisateur non trouvé.";
        exit();
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil de <?php echo htmlspecialchars($username); ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
    .container {
        display: flex;
        width: 100%;
        max-width: 1200px;
        background-color: #0d0f13;
        color: white;
        border: 1px solid #1d2026;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        justify-content: center;
        margin: auto;
    }
    .sidebar {
        width: 200px;
        border-right: 1px solid #ccc;
        padding: 20px;
        background-color: #191c23;
    }
    .sidebar a {
        display: block;
        padding: 10px;
        margin-bottom: 10px;
        text-decoration: none;
        color: white;
        border: 1px solid #5c6169;
        border-radius: 5px;
        text-align: center;
        background-color: #33373d;
    }
    .sidebar a:hover {
        background-color: #0d0f13;
        color: #daf37c;
    }
    .content {
        padding: 20px;
        flex-grow: 1;
    }
    .section {
        display: none;
    }
    .section.active {
        display: block;
    }
    .form-group {
        margin-bottom: 15px;
        color: white;
    }
    
    .form-group a{
        color : white;
        text-decoration :none;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }
    .form-group input,
    .form-group select {
        width: 50%;
        padding: 8px;
        box-sizing: border-box;
    }
    .form-group input[type="submit"] {
        width: auto;
        color: black;
        background-color:  #daf37c;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        padding: 10px 20px;
        transition: background-color 0.3s ease;

    }

    .form-group input[type="submit"]:hover {
    background-color: black;
    color: #daf37c;
    }

    .message.success {
        color: green;
    }

    .message.error {
        color: red;
    }

    .btn-supprimer {
    transition: background-color 0.3s ease;
    background-color: red;
    color: black;
    border-radius: 10px; 
    padding: 5px 10px; 
    font-size: 14px;
    border: none; 
    cursor: pointer; 
    width: auto;
}

.btn-supprimer:hover{
    background-color: black;
    color: red;
}


</style>

    <script>
        function showSection(sectionId) {
            var sections = document.getElementsByClassName('section');
            for (var i = 0; i < sections.length; i++) {
                sections[i].classList.remove('active');
            }
            document.getElementById(sectionId).classList.add('active');
        }
    </script>

<script>
    function confirmDelete() {
        if (confirm("Voulez-vous vraiment supprimer votre compte ?")) {
            document.getElementById("deleteForm").submit();
        }
    }
</script>


</head>
<body>
    <h1 id="titre" style="text-align: center;">Modifier  le profil</h1>
    <div class="container">
        <div class="sidebar">
            <a href="#personal-info" onclick="showSection('personal-info')">Informations personnelles</a>
            <a href="#account-security" onclick="showSection('account-security')">Sécurité du compte</a>
            <a href="#display-preferences" onclick="showSection('display-preferences')">Préférences d'affichage</a>
            <a href="#support-assistance" onclick="showSection('support-assistance')">Support et assistance</a>
        </div>
        <div class="content">
            <div id="personal-info" class="section active">
                <h2>Informations personnelles</h2>
                <form>
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur :</label>
                        <input type="text" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="email" id="email" value="<?php echo htmlspecialchars($user['mail']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="phone">Numéro de téléphone :</label>
                        <input type="text" id="phone" value="<?php echo htmlspecialchars($user['mobile']); ?>" disabled>
                    </div>
                </form>
            </div>
<div id="account-security" class="section">
    <h2>Sécurité du compte</h2>
    <form method="post">
        <div class="form-group">
            <label for="old_password">Ancien mot de passe :</label>
            <input type="password" id="old_password" name="old_password" required>
        </div>
        <div class="form-group">
            <label for="new_password">Nouveau mot de passe :</label>
            <input type="password" id="new_password" name="new_password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirmer le nouveau mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <div class="form-group">
        <input type="submit" value="Changer le mot de passe" class="btn-changer-mot-de-passe">
    </div>
        <?php if ($message): ?>
            <p class="message <?php echo strpos($message, 'succès') !== false ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>
    </form>
    <form id="deleteForm" action="_profile.supprimer.php" method="post">
    <div class="form-group">
        <input type="button" value="Supprimer le compte" onclick="confirmDelete()" class="btn-supprimer">
    </div>
</form>





</div>

            <div id="display-preferences" class="section">
                <h2>Préférences d'affichage et d'interface</h2>
                <form action="update_display.php" method="post">
                </form>
            </div>
            <div id="support-assistance" class="section">
                <h2>Support et assistance</h2>
                <form>
                    <div class="form-group">
                        <a href="support.php">Contacter le support</a>
                    </div>
                    <div class="form-group">
                        <a href="aide.php">Centre d'aide</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div style="height: 200px"></div>
</body>
</html>

<?php 
 include_once 'affichage/_fin.inc.php'; ?>
