
<?php 
session_start();

$DBservername = "localhost";
$DBusername = "root"; 
$DBpassword = "";  
$DBdatabase = "blog";

$conn = new mysqli($DBservername, $DBusername, $DBpassword, $DBdatabase);
$_SESSION['connect']=$conn;
$_SESSION['connected']=false;

if ($conn->connect_error) {
    error_log( "Connection failed: " . $conn->connect_error);
}

function exec_request($request, $types, $listeparam){
    //exécute la requête passée en paramètre
    // arguments : requête -> string , type -> string et tableau de paramètres -> tab
    $loginPassword= $_SESSION['connect']->prepare($request); //prépare la requête pour l'exécution
    if ($loginPassword){
    $loginPassword->bind_param($types, ...$listeparam); //lit le password de login pour la requête préparée. 's' précise le type String
    $loginPassword->execute();
    return $loginPassword->get_result();
    }
    else{
        die("erreur dans la requête " . $_SESSION['connect']->error);
    }
}
$feedback='';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['mail']) && !empty($_POST['pw']) && !empty($_POST['pseudo'])) {
        $pseudo = $_POST['pseudo'];
        $mail = $_POST['mail'];
        $password = $_POST['pw'];
        
        $requete="select count(*) as count from utilisateur where pseudo=?";
        $result = exec_request($requete, 's', [$pseudo]);
        $result = $result->fetch_assoc();


        if ($result['count'] > 0){
            $requete = "SELECT motDePasse FROM utilisateur WHERE pseudo=?";
            $result = exec_request($requete, 's', [$pseudo]);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc(); // ligne de données SQL renvoyée
                if (password_verify($password, $row['motDePasse'])) { // check si le password hashé correspond
                    $_SESSION['connected'] = true;
                    $_SESSION['mail'] = $mail;  
                    $_SESSION['pw'] = $password;
                    header('Location: ../index.php');
                    exit();
                }
                else{
                    $feedback="Mot de passe incorrect.";
                    }
                } 
            }
        else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $requete = "INSERT INTO utilisateur (pseudo, email, motDePasse) VALUES (?, ?, ?)";
            exec_request($requete, 'sss', [$pseudo, $mail, $hashed_password]);
            $feedback="Compte créé avec succès.";
            header('Location: ../index.php');
            exit();
        }
    } 
    else {
        $feedback= "Veuillez rentrer les champs indiqués.";
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
                <input type="password" name="pw" id="pw" placeholder="Mot de passe" minlength="4" maxlength="12" required>
                <input type="submit" value="Connexion" class="form-submit-button">

                <!-- Affiche le message ici -->
                <?php if (!empty($feedback)): ?>
                    <p><?php echo $feedback; ?></p>
                <?php endif; ?>

            </form>
        </div>
    </body>
</html>
