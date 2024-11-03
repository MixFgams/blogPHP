    <?php

        session_start();

        include "pagesOutils/connDB.php"

    ?>

    <html>
        <link rel="stylesheet" href="listeArticle.css">
        <header>
            <?php
                include 'pagesOutils/header.php';
            ?>
        </header>
        <body>
        <main>

        <h1>Liste des articles</h1>
        <div id="search-container">
            <form method="GET">
                <label for="barreRecherche">Recherchez un article : </label>
                <input id="barreRecherche" name="barreRecherche" type="search">
                <?php
                $_isSearched = false;
                if(!empty($_GET['barreRecherche'])){
                    $_isSearched = true;
                    $sql = "SELECT id, titre, description, fk_pseudo FROM article WHERE fk_pseudo LIKE '%".$_GET['barreRecherche']."%'";
                    $result = $conn->query($sql);
                    echo "<h2>Articles trouvés avec le pseudo : " . htmlspecialchars($_GET['barreRecherche']) . "</h2>";
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id=$row['id'];
                            echo "<section class='article'>
                            <h2>" . $row["titre"] . "</h2>
                            <p>" . $row["description"] . "</p>
                            <div class='article-footer'>
                                <span class='auteur'>Auteur : " . $row["fk_pseudo"] . "</span>
                            </div>
                            <a href='afficherArticle.php?id=$id'><p class='lienArticle'>Afficher plus</p></a>
                        </section>";
                        }
                    } else {
                        echo "<p>Aucun article trouvé avec le pseudo : " . htmlspecialchars($_GET['barreRecherche']) . "</p>";
                    }
                }
                ?>
            </form>
        </div>
        <?php
            if($_isSearched == false){
                $sql = "SELECT id, titre, description, fk_pseudo FROM article";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id=$row['id'];
                        echo "<section class='article'>
                            <h2>" . $row["titre"] . "</h2>
                            <p>" . $row["description"] . "</p>
                            <div class='article-footer'>
                                <span class='auteur'>Auteur : " . $row["fk_pseudo"] . "</span>
                            </div>
                            <a href='afficherArticle.php?id=$id'><p class='lienArticle'>Afficher plus</p></a>
                        </section>";
                    }
                } else {
                    echo "Aucun article trouvé.";
                }
            }

        ?>

        <?php

        ?>
        </main>
        </body>
        <?php
            include 'pagesOutils/footer.php'
        ?>
    </html>