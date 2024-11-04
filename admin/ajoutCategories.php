<?php
session_start();
include "../pagesOutils/connDB.php";
include "../pagesOutils/connected.php";

// Récupère l'email de l'utilisateur connecté
$idUser = $_SESSION['idUser'];
$sqlUser = "SELECT email FROM utilisateur WHERE id = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("i", $idUser);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

if ($resultUser->num_rows > 0) {
    $rowUser = $resultUser->fetch_assoc();
    $email = $rowUser['email'];

    // Vérifie si l'email est celui de l'administrateur
    if ($email !== 'admin@localhost.fr') {
        echo "Accès refusé. Vous n'êtes pas administrateur.";
        exit;
    }
} else {
    echo "Utilisateur non trouvé.";
    exit;
}


// Ajout d'une nouvelle catégorie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $nomCategorie = $_POST['nom_categorie'];
    $sqlInsert = "INSERT INTO categorie (nom) VALUES (?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("s", $nomCategorie);
    $stmtInsert->execute();
}

// Modification d'une catégorie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    $categorieId = $_POST['categorie_id'];
    $nouveauNom = $_POST['nouveau_nom'];
    $sqlUpdate = "UPDATE categorie SET nom = ? WHERE id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("si", $nouveauNom, $categorieId);
    $stmtUpdate->execute();
}

// Suppression d'une catégorie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer'])) {
    $categorieId = $_POST['categorie_id'];
    $sqlDelete = "DELETE FROM categorie WHERE id = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("i", $categorieId);
    $stmtDelete->execute();
}

// Récupération des catégories existantes
$sqlCategories = "SELECT * FROM categorie";
$resultCategories = $conn->query($sqlCategories);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="ajoutCategories.css">
        <title>Gestion des Catégories - Admin</title>
    </head>

    <header>
        <nav class="header-nav">
            <a href="../listeArticle.php"><img src="../img/obLogo.png" alt="Logo OB"></a>
            <a href="../listeArticle.php">Accueil</a>
            <a href="../creationArticle.php">Création d'article</a>
            <a href="../aPropos.php">À propos</a>
            <a href="../profile.php">Votre Profile</a>
        </nav>
    </header>
    <body>
        <main>

        <h1 class="titre-principal">Gestion des Catégories</h1>

        <h2>Ajouter une nouvelle catégorie</h2>
        <form method="post">
            <label for="nom_categorie">Nom de la catégorie :</label>
            <input type="text" id="nom_categorie" name="nom_categorie" required>
            <button type="submit" name="ajouter">Ajouter</button>
        </form>

        <h2>Catégories existantes</h2>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $resultCategories->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="categorie_id" value="<?php echo $row['id']; ?>">
                            <input type="text" name="nouveau_nom" value="<?php echo $row['nom']; ?>" required>
                            <button type="submit" name="modifier">Modifier</button>
                        </form>
                    </td>
                    <td>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="categorie_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        </main>
    </body>
    <footer>
        <nav class="footer-nav">
            <a href="../acceuil.php"><img src="../img/obLogo.png" alt="Logo OB"></a>
            <a href="mailto:FaroukMohamed.Bendeddouche@outlook.com">Contacter l'assistance</a>
            <a href="../FAQ.php">FAQ</a>
            <a href="../conditionsUtilisation.php">Conditions et confidentialité</a>
            <a href="../connexion.php">Connexion</a>
        </nav>
        <p id="droits-footer">
            @OB 2024 - Tout contenu externe reste la propriété du propriétaire légitime
        </p>
    </footer>
</html>

