<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['idUser'])) {
    header("location: connexion.php");
    exit();
}

include "pagesOutils/connDB.php";

// Récupère le pseudo de l'utilisateur connecté
$idUser = $_SESSION['idUser'];
$sqlPseudo = "SELECT pseudo FROM utilisateur WHERE id = ?";
$stmtPseudo = $conn->prepare($sqlPseudo);
$stmtPseudo->bind_param("i", $idUser);
$stmtPseudo->execute();
$resultPseudo = $stmtPseudo->get_result();

if ($resultPseudo->num_rows > 0) {
    $user = $resultPseudo->fetch_assoc();
    $pseudo = $user['pseudo'];
} else {
    echo "Utilisateur non trouvé.";
    exit();
}

// Récupère les catégories existantes
$sqlCategories = "SELECT id, nom FROM categorie";
$resultCategories = $conn->query($sqlCategories);
$categories = [];
while ($row = $resultCategories->fetch_assoc()) {
    $categories[] = $row;
}

// Gestion de l'envoi du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['titre']) && !empty($_POST['description'])) {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $selectedCategories = isset($_POST['categories']) ? $_POST['categories'] : [];

    // Insertion de l'article dans la table `article`
    $sqlInsert = "INSERT INTO article (titre, description, fk_pseudo) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("sss", $titre, $description, $pseudo);
    $stmtInsert->execute();

    $articleId = $stmtInsert->insert_id;

    // Insertion des catégories sélectionnées dans la table `article_categorie`
    $sqlInsertCategory = "INSERT INTO article_categorie (article_id, categorie_id) VALUES (?, ?)";
    $stmtCategory = $conn->prepare($sqlInsertCategory);
    foreach ($selectedCategories as $categoryId) {
        $stmtCategory->bind_param("ii", $articleId, $categoryId);
        $stmtCategory->execute();
    }

    // Redirection après la création de l'article
    header("Location: afficherArticle.php?id=" . $articleId);
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="img/obLogo.png" type="image/x-icon">
        <link rel="stylesheet" href="creationArticle.css">
        <title>Créer un article</title>
    </head>

    <?php include "pagesOutils/header.php" ?>
    
    <body>
        <h1>Créer un nouvel article</h1>
        <form method="post">
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" required>
            
            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>
            
            <label for="categories">Catégories :</label>
            <div id="categories">
                <?php foreach ($categories as $categorie): ?>
                    <div>
                        <input type="checkbox" id="categorie_<?php echo $categorie['id']; ?>" name="categories[]" value="<?php echo $categorie['id']; ?>">
                        <label for="categorie_<?php echo $categorie['id']; ?>"><?php echo htmlspecialchars($categorie['nom']); ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit">Publier</button>
        </form>
    </body>

    <?php include "pagesOutils/footer.php" ?>

</html>
