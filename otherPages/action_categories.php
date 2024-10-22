<?php
require_once('connexion.php');

function valid_modif(){
    return (isset($_POST['valider']) && ($_SERVER['REQUEST_METHOD'] === 'POST'));
}

function verif_admin(){
    return ($_SESSION['pw']==="admin69IUT" && $_SESSION['email']==="admin@localhost.fr");
}


if ($_SESSION['connected'] && verif_admin()){
    if (isset($_POST['create'])){
        echo "<form method='POST'>
                <label>Entrez le nom de la catégorie à créer</label>
                <input type='text' name='newcat' id='newcat' placeholder='nom catégorie à créer' required>
            </form>";
        if (!empty($_POST['newcat']) && valid_modif()){
            $requete='insert into Categorie values (?)';
            exec_request($requete, 's', [$_POST['newcat']]);
        }
    }
    else if (isset($_POST['update'])){
        echo "<form method='POST'>
                <label>Entrez le nom de la catégorie à modifier</label>
                <input type='text' name='catmodif' id='catmodif' placeholder='nom catégorie à modifier' required>
                <label>Entrez le nouveau nom</label>
                <input type='text' name='newname' id='newname' placeholder='nom catégorie' required>
            </form>";
            if (!empty($_POST['newcat'] ) && valid_modif()){
                $requete="select id from Categorie where nom=?";
                $id=exec_request($requete, 's', [$_POST['catmodif']]);
                $requete='update Categorie set nom=? where id=?';
                exec_request($requete, 'i', [$_POST['newname'], $_POST['id']]);
            }

    }
    else if(isset($_POST['read'])){
        echo "<form method='POST'>
                <label>Entrez le nom de la catégorie à afficher</label>
                <input type='text' name='cataffich' id='cataffich' placeholder='nom catégorie à afficher' required>
            </form>";
            if (!empty($_POST['cataffich']) && valid_modif()){
                $requete='select * from Categorie where nom=?';
                exec_request($requete, 's', [$_POST['cataffich']]);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { // pour chaque ligne renvoyée
                        echo "Catégorie: " . htmlspecialchars($row['nom']) . "<br>"; // affiche le nom de la catégorie. htmlspecialchars rajoute une sécurité dans son affichage du nom
                    }
                } else {
                    echo "Aucune catégorie trouvée.";
                }
            }
    }
    else if (isset($_POST['delete'])){
        echo "<form method='POST'>
                <label>Entrez le nom de la catégorie à supprimer</label>
                <input type='text' name='catdelete' id='catdelete' placeholder='nom catégorie à supprimer' required>
            </form>";
            if (!empty($_POST['catdelete']) && valid_modif()){
                $requete='delete from Categorie where nom=?';
                exec_request($requete, 's', [$_POST['catdelete']]);
            }
    }
}
elseif ($_SESSION['connect']->$DBusername!=="root"){
    header('Location: ../index.php');
    exit();
}
else{
    header('Location: connexion.php');
    exit();
}


?>

<html>
    <body>

        <button value="create">Créer</button>
        <button value="update">Modifier</button>
        <button value="read">Afficher</button>
        <button value="delete">Supprimer</button>

        <input type='submit' value='valider'>
    </body>

</html>
