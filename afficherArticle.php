<?php

session_start(); // Démarre la session pour gérer les informations de connexion de l'utilisateur

include "pagesOutils/connDB.php";

include "pagesOutils/connected.php";

// Initialisation des variables pour éviter des erreurs si l'id de l'article n'est pas trouvé
$titre = '';
$description = '';
$pseudoCreateur = '';
$listeCategories = '';
$listeCommentaires = '';

// Vérifie si l'ID de l'article est passé en paramètre
if (isset($_GET['id'])) {
    $idArticle = $_GET['id'];
    $_SESSION['idArticle'] = $idArticle; // Enregistre l'ID de l'article dans la session

    // Récupérer les informations de l'article (titre, description et créateur)
    $sql = "SELECT titre, description, fk_pseudo FROM article WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idArticle);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $titre = $row['titre'];
        $description = $row['description'];
        $pseudoCreateur = $row['fk_pseudo'];
    }
    
    // Récupérer les catégories associées à l'article
    $sqlCategories = "SELECT c.nom FROM categorie AS c
                      JOIN article_categorie AS ac ON c.id = ac.categorie_id
                      WHERE ac.article_id = ?";
    $stmtCategories = $conn->prepare($sqlCategories);
    $stmtCategories->bind_param("i", $idArticle);
    $stmtCategories->execute();
    $resultCategories = $stmtCategories->get_result();

    // Stocke les noms des catégories dans un tableau
    $categories = [];
    while ($rowCat = $resultCategories->fetch_assoc()) {
        $categories[] = $rowCat['nom'];
    }
    $listeCategories = implode(", ", $categories); // Convertit le tableau en chaîne séparée par des virgules

    // Récupérer les commentaires associés à l'article avec le pseudo de chaque utilisateur
    $sqlCommentaires = "SELECT com.description, u.pseudo FROM commentaire AS com
                        JOIN article_commentaire AS ac ON com.id = ac.commentaire_id
                        JOIN utilisateur AS u ON com.fk_pseudo = u.pseudo
                        WHERE ac.article_id = ?";
    $stmtCommentaires = $conn->prepare($sqlCommentaires);
    $stmtCommentaires->bind_param("i", $idArticle);
    $stmtCommentaires->execute();
    $resultCommentaires = $stmtCommentaires->get_result();

    // Prépare chaque commentaire pour l'affichage, en incluant le pseudo de l'utilisateur
    $commentaires = [];
    while ($rowComm = $resultCommentaires->fetch_assoc()) {
        // Utilise des balises personnalisées pour structurer l'affichage du pseudo et du commentaire
        $commentaires[] = "<pseudo>" . htmlspecialchars($rowComm['pseudo']) . "</pseudo> <commentaire>" . htmlspecialchars($rowComm['description']) . "</commentaire>";
    }
    $listeCommentaires = implode("", $commentaires); // Convertit le tableau de commentaires en une seule chaîne HTML
}

// Gestion de l'envoi de commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['commentaire'])) {
    $commentaire = $_POST['commentaire'];

    // Vérifie que l'utilisateur est connecté
    if (isset($_SESSION['idUser'])) {
        // Récupère le pseudo de l'utilisateur connecté à partir de l'idUser
        $sqlPseudo = "SELECT pseudo FROM utilisateur WHERE id = ?";
        $stmtPseudo = $conn->prepare($sqlPseudo);
        $stmtPseudo->bind_param("i", $_SESSION['idUser']);
        $stmtPseudo->execute();
        $resultPseudo = $stmtPseudo->get_result();

        // Vérifie si le pseudo a bien été récupéré
        if ($resultPseudo->num_rows > 0) {
            $rowPseudo = $resultPseudo->fetch_assoc();
            $pseudo = $rowPseudo['pseudo'];

            // Insertion du commentaire dans la base de données
            $sqlInsert = "INSERT INTO commentaire (description, fk_pseudo) VALUES (?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bind_param("ss", $commentaire, $pseudo);
            $stmtInsert->execute();

            // Lier le commentaire nouvellement créé à l'article
            $commentaireId = $stmtInsert->insert_id; // Récupère l'ID du commentaire inséré
            $sqlLink = "INSERT INTO article_commentaire (article_id, commentaire_id) VALUES (?, ?)";
            $stmtLink = $conn->prepare($sqlLink);
            $stmtLink->bind_param("ii", $idArticle, $commentaireId);
            $stmtLink->execute();

            // Redirection pour éviter la double soumission du formulaire
            header("Location: afficherArticle.php?id=" . $idArticle);
            exit;
        } else {
            echo "Erreur : impossible de récupérer le pseudo de l'utilisateur.";
        }
    } else {
        echo "Erreur : l'utilisateur n'est pas connecté.";
    }
}


?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/obLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="afficherArticle.css">
    <script src="script.js"></script>
    <title><?php echo htmlspecialchars($titre); ?></title>
</head>

<?php include 'pagesOutils/header.php'; ?>

<body>
<main>
    <h1><?php echo htmlspecialchars($titre); ?></h1>

    <section>
    <h2>Créateur : <span class="pseudo"><?php echo htmlspecialchars($pseudoCreateur); ?></span></h2>
    </section>

    <section>
    <h2>Catégories : </h2>
    <p class="categories"><?php echo htmlspecialchars($listeCategories); ?></p>
    </section>

    <section>
    <h2>Description : </h2>
    <p class="description"><?php echo nl2br(htmlspecialchars($description)); ?></p>
    </section>

    <section>
    <h2>Commentaires : </h2>
    <div class="commentaires">
        <?php echo $listeCommentaires; ?>
    </div>
    </section>

    <!-- Formulaire d'ajout de commentaire -->
    <section>
    <h2>Ajouter un commentaire :</h2>
    <form method="POST" class="comment-form">
        <textarea name="commentaire" rows="4" required placeholder="Écrivez votre commentaire ici..."></textarea>
        <button type="submit">Envoyer</button>
    </form>
    </section>
</main>
</body>

<?php include 'pagesOutils/footer.php'; ?>

</html>
