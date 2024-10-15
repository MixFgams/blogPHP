<?
require_once('connexion.php');

    
    $cat_add=""; //catégorie ajoutée 
    $cat=[]; //tab d'indice de catégorie
    $idart;  //id de l'article utilisé pour la modif de la table de relation Article-Catégorie
    $idcat;  //id de la catégorie utilisée pour la modif de la table de relation Article-Catégorie


if ('REQUESTED_METHOD'==='POST'){
    $_SESSION['art']=$_POST['art'];
    $_SESSION['desc']=$_POST['desc'];
    $_SESSION['cat']=$_POST['cat'];
    for($j=0;$j<strlen($_SESSION['cat']);$j++){
        $indice=0;
        if($_SESSION[$j]==','){
            $requete="select id from Categorie where nom=?";
            $cat[$indice]=exec_request($requete, 'd', $cat_add);
            $indice++;
        }
        else{
            $cat_add.=$_SESSION['cat'][$j];
        }
    }
    $_SESSION['pseudo']=$_POST['pseudo'];

    if (!empty($_SESSION['art'])&& !empty($_SESSION['desc']) && !empty($cat) && !empty($_SESSION['pseudo'])) {

        $requete='insert into Article(titre,description,pseudo) values(?,?,?,?)';
        exec_request($requete,'sss',[$_SESSION['art'], $_SESSION['desc'],$_SESSION['pseudo']]);



        $requete='insert into Article-Categorie(id_article, id_categorie) values(?,?)';
        exec_request($requete,'dd',[$idart, $idcat]);
        header('Location: accueil.php');
    }
    
}


?>

<html>
    <header>
        Création d'article
    </header>
    <body>
        <form method='POST'>
    <label>Entrez le nom du nouvel article a créé</label>
    <input type="text" name=art id=art minlength=2>
    <label>Décrivez le nouvel article</label>
    <input type="text area" name=desc id=desc minlength=2>
    <label>Catégories impliquées (séparées par une virgule) : </label>
    <input type="text area" name=cat id=cat minlength=2 required>
    <label>Entrez votre pseudo : </label>
    <input type="text" name=pseudo id=pseudo required>
    <input type="submit" value="insert">
        </form>
    </body>

</html>
