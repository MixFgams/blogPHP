<?php 
session_start(); // Démarre la session pour permettre la gestion des connexions

// Configuration de la base de données
$DBservername = "localhost";
$DBusername = "root"; 
$DBpassword = "";  
$DBdatabase = "blog";

// Connexion à la base de données et initialisation de l'état de connexion
$conn = new mysqli($DBservername, $DBusername, $DBpassword, $DBdatabase);
$_SESSION['connected'] = false;
$_SESSION['connect'] = $conn;

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
}

// Fonction pour exécuter des requêtes préparées, utilisée pour la sécurité
function exec_request($request, $types, $listeparam){
    $stmt = $_SESSION['connect']->prepare($request);
    if ($stmt) {
        $stmt->bind_param($types, ...$listeparam);
        $stmt->execute();
        return $stmt->get_result();
    } else {
        die("Erreur dans la requête : " . $_SESSION['connect']->error);
    }
}

$feedback = ''; // Stocke les messages de retour pour l'utilisateur

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie que tous les champs requis sont remplis
    if (!empty($_POST['mail']) && !empty($_POST['pw']) && !empty($_POST['pseudo'])) {
        $pseudo = $_POST['pseudo'];
        $mail = $_POST['mail'];
        $password = $_POST['pw'];
        
        // Vérifie si le pseudo existe déjà dans la base de données
        $requete = "SELECT id, motDePasse FROM utilisateur WHERE pseudo=?";
        $result = exec_request($requete, 's', [$pseudo]);

        // Si l'utilisateur existe, vérifie le mot de passe
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['motDePasse'])) { // Vérification du mot de passe
                $_SESSION['connected'] = true; // Mise à jour de l'état de connexion
                $_SESSION['idUser'] = $row['id']; // Stockage de l'ID utilisateur pour les sessions
                header('Location: listeArticle.php'); // Redirection vers la page d'accueil
                exit();
            } else {
                $feedback = "Mot de passe incorrect.";
            }
        } else {
            // Si le pseudo n'existe pas, création d'un nouvel utilisateur
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $requete = "INSERT INTO utilisateur (pseudo, email, motDePasse) VALUES (?, ?, ?)";
            exec_request($requete, 'sss', [$pseudo, $mail, $hashed_password]);

            // Récupérer l'ID du nouvel utilisateur après insertion
            $newUserId = $conn->insert_id; // Obtient l'ID de l'utilisateur nouvellement créé
            $_SESSION['idUser'] = $newUserId;
            $_SESSION['connected'] = true; // Met à jour l'état de connexion
            header('Location: listeArticle.php'); // Redirection vers la page d'accueil
            exit();
        }
    } else {
        $feedback = "Veuillez rentrer les champs indiqués."; // Message d'erreur pour les champs vides
    }
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="img/obLogo.png" type="image/x-icon">
        <link rel="stylesheet" href="connexion.css"> 
        <script src="script.js"></script>
        <title>Connexion</title>
    </head>
    
    <body>
        <div class="form-container"> 
            <h1>Connectez-vous</h1>
            <form method="post">
                <label>Entrez vos identifiants :</label>
                <input type="text" name="pseudo" id="pseudo" placeholder="Pseudo" minlength="4" required>
                <input type="email" name="mail" id="mail" placeholder="Email" minlength="4" required> 
                <input type="password" name="pw" id="pw" placeholder="Mot de passe" minlength="4" maxlength="20" required>
                <input type="submit" value="Connexion" class="form-submit-button">

                <?php if (!empty($feedback)): ?> <!-- Affiche le message de retour si présent -->
                    <p><?php echo $feedback; ?></p>
                <?php endif; ?>
            </form>
        </div>
    </body>
</html>
