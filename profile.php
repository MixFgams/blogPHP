<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['idUser'])) {
    header("location: connexion.php");
    exit();
}

include "pagesOutils/connDB.php";

$idUser = $_SESSION['idUser'];

// Récupérer le pseudo et l'email de l'utilisateur connecté
$sqlUser = "SELECT pseudo, email FROM utilisateur WHERE id = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("i", $idUser);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$user = $resultUser->fetch_assoc();
$pseudo = $user['pseudo'];
$email = $user['email']; 

// Gestion des modifications et suppressions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Modifier un commentaire
    if (isset($_POST['modifier_commentaire'])) {
        $commentaire_id = $_POST['commentaire_id'];
        $new_commentaire = $_POST['new_commentaire'];

        $sqlUpdateCommentaire = "UPDATE commentaire SET description = ? WHERE id = ?";
        $stmtUpdateCommentaire = $conn->prepare($sqlUpdateCommentaire);
        $stmtUpdateCommentaire->bind_param("si", $new_commentaire, $commentaire_id);
        $stmtUpdateCommentaire->execute();
        header("Location: profile.php");
        exit();
    }

    // Supprimer un commentaire
    if (isset($_POST['supprimer_commentaire'])) {
        $commentaire_id = $_POST['commentaire_id'];

        $sqlDeleteArticleCommentaire = "DELETE FROM article_commentaire WHERE commentaire_id = ?";
        $stmtDeleteArticleCommentaire = $conn->prepare($sqlDeleteArticleCommentaire);
        $stmtDeleteArticleCommentaire->bind_param("i", $commentaire_id);
        $stmtDeleteArticleCommentaire->execute();

        $sqlDeleteCommentaire = "DELETE FROM commentaire WHERE id = ?";
        $stmtDeleteCommentaire = $conn->prepare($sqlDeleteCommentaire);
        $stmtDeleteCommentaire->bind_param("i", $commentaire_id);
        $stmtDeleteCommentaire->execute();
        header("Location: profile.php");
        exit();
    }

    // Modifier un article
    if (isset($_POST['modifier_article'])) {
        $article_id = $_POST['article_id'];
        $new_titre = $_POST['new_titre'];
        $new_description = $_POST['new_description'];

        $sqlUpdateArticle = "UPDATE article SET titre = ?, description = ? WHERE id = ?";
        $stmtUpdateArticle = $conn->prepare($sqlUpdateArticle);
        $stmtUpdateArticle->bind_param("ssi", $new_titre, $new_description, $article_id);
        $stmtUpdateArticle->execute();
        header("Location: profile.php");
        exit();
    }

    // Supprimer un article
    if (isset($_POST['supprimer_article'])) {
        $article_id = $_POST['article_id'];

        $sqlDeleteArticle = "DELETE FROM article WHERE id = ?";
        $stmtDeleteArticle = $conn->prepare($sqlDeleteArticle);
        $stmtDeleteArticle->bind_param("i", $article_id);
        $stmtDeleteArticle->execute();
        header("Location: profile.php");
        exit();
    }
}

// Récupération des commentaires de l'utilisateur
$sqlCommentaires = "SELECT commentaire.id, commentaire.description, article.titre AS article_titre 
                    FROM commentaire 
                    JOIN article_commentaire ON commentaire.id = article_commentaire.commentaire_id
                    JOIN article ON article.id = article_commentaire.article_id
                    WHERE commentaire.fk_pseudo = ?";
$stmtCommentaires = $conn->prepare($sqlCommentaires);
$stmtCommentaires->bind_param("s", $pseudo);
$stmtCommentaires->execute();
$resultCommentaires = $stmtCommentaires->get_result();

// Récupération des articles de l'utilisateur
$sqlArticles = "SELECT id, titre, description 
                FROM article 
                WHERE fk_pseudo = ? 
                ORDER BY id DESC";
$stmtArticles = $conn->prepare($sqlArticles);
$stmtArticles->bind_param("s", $pseudo);
$stmtArticles->execute();
$resultArticles = $stmtArticles->get_result();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Votre Profil</title>
        <link rel="icon" href="img/obLogo.png" type="image/x-icon">
        <link rel="stylesheet" href="profile.css">
    </head>

    <?php include "pagesOutils/header.php" ?>

    <body>
        <main>
            <h1>Profil de <?= htmlspecialchars($pseudo) ?></h1>

            <?php if ($email === 'admin@localhost.fr' && $pseudo === 'admin'): ?>
                <section>
                    <h2>Admin Access</h2>
                    <p><a href="admin/ajoutCategories.php">Ajouter une Catégorie</a></p>
                </section>
            <?php endif; ?>
            
            <section>
                <h2>Vos Commentaires</h2>
                <?php if ($resultCommentaires->num_rows > 0): ?>
                    <ul>
                        <?php while ($commentaire = $resultCommentaires->fetch_assoc()): ?>
                            <li>
                                <p>Commentaire sur "<?= htmlspecialchars($commentaire['article_titre']) ?>" :</p>
                                <form method="post" action="">
                                    <input type="hidden" name="commentaire_id" value="<?= $commentaire['id'] ?>">
                                    <input type="text" name="new_commentaire" value="<?= htmlspecialchars($commentaire['description']) ?>" required>
                                    <button type="submit" name="modifier_commentaire">Modifier</button>
                                </form>
                                <form method="post" action="">
                                    <input type="hidden" name="commentaire_id" value="<?= $commentaire['id'] ?>">
                                    <button type="submit" name="supprimer_commentaire" onclick="return confirm('Voulez-vous vraiment supprimer ce commentaire ?');">Supprimer</button>
                                </form>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>Vous n'avez publié aucun commentaire.</p>
                <?php endif; ?>
            </section>

            <section>
                <h2>Vos Articles</h2>
                <?php if ($resultArticles->num_rows > 0): ?>
                    <ul>
                        <?php while ($article = $resultArticles->fetch_assoc()): ?>
                            <form method="post" action="">
                                <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                                <input type="text" name="new_titre" value="<?= htmlspecialchars($article['titre']) ?>" required>
                                <textarea name="new_description" required><?= htmlspecialchars($article['description']) ?></textarea>
                                <button type="submit" name="modifier_article">Modifier</button>
                            </form>
                            <form method="post" action="">
                                <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                                <button type="submit" name="supprimer_article" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?');">Supprimer</button>
                            </form>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>Vous n'avez publié aucun article.</p>
                <?php endif; ?>
            </section>
        </main>

        <?php include "pagesOutils/footer.php" ?>
    </body>
</html>
