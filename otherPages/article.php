<?php

class Article
{
    public $id=0;
    public $img = '';
    public $titre='';
    public $desc='';
    public $cat = [];
    public $pseudo = '';
    public $comm = [];
    
    public function displayArticle(){
        //echo "<img src= $this->img/>";
        echo "$this->titre";
        echo "$this->desc";
        echo "$this->pseudo";
        for($i=0;$i<count($this->comm);$i++){
        echo"$this->comm";}
    }

}


?>

<html>
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="img/obLogo.png" type="image/x-icon">
        <link rel="stylesheet" href="otherPages/connexion.css"> 
        <title>Connexion</title>
    </head>
    <body>
        
    </body>
</html>