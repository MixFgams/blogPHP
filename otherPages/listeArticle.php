<?php

    session_start();
    // Connexion à la base de données
    $DBservername = "localhost";
    $DBusername = "root";
    $DBpassword = "";
    $DBdatabase = "blog";

    $conn = new mysqli($DBservername, $DBusername, $DBpassword, $DBdatabase);
    $_SESSION['connect']=$conn;

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }


?>

<html>
    <link rel="stylesheet" href="../style.css">
    <header>
        <?php
            include 'header.php';
        ?>
        <h1>Liste des articles</h1>
    </header>
    <body>
    <?php
        $sql = "SELECT id, titre, description, fk_pseudo FROM article";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<section class='article'>
                        <h2>" . $row["titre"] . "</h2>
                        <p>" . $row["description"] . "</p>
                        <div class='article-footer'>
                            <span class='auteur'>Auteur : " . $row["fk_pseudo"] . "</span>
                        </div>
                        <a href=''><p class='lienArticle'>Afficher plus</p></a>
                      </section>";
            }
        } else {
            echo "Aucun article trouvé.";
        }
    ?>
    </body>
    <?php
        include 'footer.php'
    ?>
</html>
