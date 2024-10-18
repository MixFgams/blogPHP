
<?php 
session_start();

$DBservername = "localhost";
$DBusername = "root"; 
$DBpassword = "";  
$DBdatabase = "hangman_game";

$conn = new mysqli($DBservername, $DBusername, $DBpassword, $DBdatabase);
$_SESSION['connect']=$conn;
$_SESSION['connected']=false;

if ($conn->connect_error) {
    error_log( "Connection failed: " . $conn->connect_error);
}

function exec_request($request, $types, $listeparam){
    $loginPassword= $_SESSION['connect']->prepare($request); //prépare la requête pour l'exécution
    if ($loginPassword){
    $loginPassword->bind_param($types, $listeparam); //lit le password de login pour la requête préparée. 's' précise le type String
    $loginPassword->execute();
    return $loginPassword->get_result();
    }
    else{
        die("erreur dans la requête " . $_SESSION['connect']->error);
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['mail']) && !empty($_POST['password']) && !empty($_POST['pseudo'])) {
        $pseudo=$_POST['pseudo'];
        $mail=$_POST['mail'];
        $password=$_POST['pw'];
        $requete="select motDePasse from utilisateur where pseudo=? and motDePasse= ? and email= ?";
        if (exec_request($requete,'s',[$pseudo, $password, $mail])->num_rows>0){
            $row = $result->fetch_assoc(); //ligne de données sql renvoyée
            if (password_verify($password, $row['password'])) { //check si le password hashé correspond
            $_SESSION['connected']=true;
            $_SESSION['mail']=$_POST['mail'];  
            $_SESSION['pw']=$_POST['pw'];
            header('Location: index.php');
            exit();
            }
        }
        else{
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $requete="insert into uilisateur (pseudo, email, motDePasse) values (? , ?)";
            exec_request($requete, 'ss', [$pseudo, $email, $hashed_password]);
            echo "Compte créé avec succès";
        }
    }
    else{
        echo "Veuillez rentrer les champs indiqués";
    }
}

?>

<html>
    <head>
        <link rel="icon" src="img/obLogo.png" type="image/x-icon">
        <link rel="stylesheet" href="style.css">
        <script src="script.js"></script>
    </head>
    <body>
        <form method="post" action="index.php">
            <label>Connexion</label>
            <br>
            <input type="text" name="pseudo" id="pseudo"  placeholder="pseudo" minlength="4" required>
            <br>
            <input type="text" name="mail" id="mail"  placeholder="email"minlength="4" required>
            <br>
            <input type="password" name="pw" id="pw" placeholder="mot de passe" minlength="4" maxlength="12" required>
            <br>
            <input type="submit" value="connexion">
        </form>
    </body>
</html>
