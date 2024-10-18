<?php
require_once('connexion.php');

$cat_add = ""; // catégorie ajoutée
$cat = []; // tableau des indices de catégories
$idart = null;  // id de l'article utilisé pour la modif de la table de relation Article-Categorie

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $_SESSION['art'] = $_POST['art'];
    $_SESSION['desc'] = $_POST['desc'];
    $_SESSION['cat'] = $_POST['cat'];
    $_SESSION['pseudo'] = $_POST['pseudo'];

    // séparation des catégories par virgule
    $categories = explode(',', $_SESSION['cat']);

    if (!empty($_SESSION['art']) && !empty($_SESSION['desc']) && !empty($categories) && !empty($_SESSION['pseudo'])) {

        // insertion de l'article dans la table Article
        $requete = 'INSERT INTO Article (titre, description, pseudo) VALUES (?, ?, ?)';
        exec_request($requete, 'sss', [$_SESSION['art'], $_SESSION['desc'], $_SESSION['pseudo']]);

        $idart = $_SESSION['connect']->insert_id;

        foreach ($categories as $cat_name) {

            $cat_name = trim($cat_name);
            if (!empty($cat_name)) {
                $requete = "SELECT id FROM Categorie WHERE nom = ?";
                $result = exec_request($requete, 's', [$cat_name]);

                if ($result->num_rows > 0) {
                    //si la catégorie existe
                    $row = $result->fetch_assoc(); //récupère le résultat de la requete
                    $idcat = $row['id'];
                } else {
                    //sinon on insère la nouvelle catégorie et récupère son ID
                    $requete = 'INSERT INTO Categorie (nom) VALUES (?)';
                    exec_request($requete, 's', [$cat_name]);
                    $idcat = $_SESSION['connect']->insert_id;
                }

                // insertion dans la table de relation Article_Categorie
                $requete = 'INSERT INTO Article_Categorie (id_article, id_categorie) VALUES (?, ?)';
                exec_request($requete, 'ii', [$idart, $idcat]);
            }
        }

        header('Location: accueil.php');
        exit();
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}

?>

<html>
    <header>
        <h2>Création d'article</h2>
    </header>
    <body>
        <form method='POST'>
            <label>Entrez le nom du nouvel article à créer :</label>
            <br>
            <input type="text" name="art" id="art" minlength="2" required>
            <br>
            <label>Décrivez le nouvel article :</label>
            <br>
            <textarea name="desc" id="desc" minlength="2" required></textarea>
            <br>
            <label>Catégories impliquées (séparées par une virgule) :</label>
            <br>
            <textarea name="cat" id="cat" minlength="2" required></textarea>
            <br>
            <label>Entrez votre pseudo :</label>
            <br>
            <input type="text" name="pseudo" id="pseudo" required>
            <br>
            <input type="submit" value="Créer l'article">
        </form>
    </body>
</html>