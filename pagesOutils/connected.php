<?php
    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION['idUser'])) {
        header("Location: ../connexion.php"); // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
        exit;
    }
?>