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
        echo "<img src= $this->img/>";
        echo "$this->titre";
        echo "$this->desc";
        echo "$this->pseudo";


    }

}


?>