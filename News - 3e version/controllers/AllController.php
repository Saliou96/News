<?php
// controllers/allcontroller.php

require_once __DIR__ . '/../models/DB.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/Categorie.php';

class AllController
{
    public function getArticles($categorieId = null)
    {
        $articles = array();

        $con = DB::getCon();

        $categoryFilter = isset($_GET['category']) ? $_GET['category'] : 'all';
        $sql = "SELECT * FROM Article";
        if ($categoryFilter !== 'all') {
            $sql .= " WHERE categorie = " . $categoryFilter;
        }

        $query = $sql;
        $res = mysqli_query($con, $query);

        while ($row = mysqli_fetch_assoc($res)) {
            $article = new Article($row['titre'], $row['contenu'], $row['categorie']);
            $articles[] = $article;
        }

        return $articles;
    }

    public function getCategories()
    {
        $categories = array();

        $con = DB::getCon();

        $query = "SELECT * FROM Categorie";
        $res = mysqli_query($con, $query);

        while ($row = mysqli_fetch_assoc($res)) {
            $categorie = new Categorie($row['id'], $row['libelle']);
            $categories[] = $categorie;
        }

        return $categories;
    }

    public function createArticle($titre, $contenu, $categorie)
    {
        $con = DB::getCon();
        $titre = mysqli_real_escape_string($con, $titre);
        $contenu = mysqli_real_escape_string($con, $contenu);
        $categorie = (int)$categorie; // Assurez-vous que la catégorie est un entier

        $sql = "INSERT INTO Article (titre, contenu, categorie) VALUES ('$titre', '$contenu', $categorie)";
        $result = mysqli_query($con, $sql);

        return $result;
    }

    public function updateArticle($titre, $contenu, $categorie)
    {
        $con = DB::getCon();
        $titre = mysqli_real_escape_string($con, $titre);
        $contenu = mysqli_real_escape_string($con, $contenu);
        $categorie = (int)$categorie; // Assurez-vous que la catégorie est un entier

        $sql = "UPDATE Article SET contenu='$contenu', categorie=$categorie WHERE titre='$titre'";
        $result = mysqli_query($con, $sql);

        return $result;
    }

    public function deleteArticle($titre)
    {
        $con = DB::getCon();
        $titre = mysqli_real_escape_string($con, $titre);

        $sql = "DELETE FROM Article WHERE titre='$titre'";
        $result = mysqli_query($con, $sql);

        return $result;
    }

    public function createCategorie($libelle)
    {
        $con = DB::getCon();
        $libelle = mysqli_real_escape_string($con, $libelle);

        $sql = "INSERT INTO Categorie (libelle) VALUES ('$libelle')";
        $result = mysqli_query($con, $sql);

        return $result;
    }

    public function updateCategorie($categorieId, $libelle)
    {
        $con = DB::getCon();
        $libelle = mysqli_real_escape_string($con, $libelle);
        $categorieId = (int)$categorieId; // Assurez-vous que l'ID de la catégorie est un entier

        $sql = "UPDATE Categorie SET libelle='$libelle' WHERE id=$categorieId";
        $result = mysqli_query($con, $sql);

        return $result;
    }

    public function deleteCategorie($categorieId)
    {
        $con = DB::getCon();
        $categorieId = (int)$categorieId; // Assurez-vous que l'ID de la catégorie est un entier

        $sql = "DELETE FROM Categorie WHERE id=$categorieId";
        $result = mysqli_query($con, $sql);

        return $result;
    }

    public function getCategorieById($categorieId)
    {
        $con = DB::getCon();
        $categorieId = (int)$categorieId;

        $query = "SELECT * FROM Categorie WHERE id = $categorieId";
        $res = mysqli_query($con, $query);

        $row = mysqli_fetch_assoc($res);
        $categorie = new Categorie($row['id'], $row['libelle']);

        return $categorie;
    }

    public function getArticleByTitre($titre)
    {
        $con = DB::getCon();
        $titre = mysqli_real_escape_string($con, $titre);

        $query = "SELECT * FROM Article WHERE titre = '$titre'";
        $res = mysqli_query($con, $query);

        $row = mysqli_fetch_assoc($res);
        $article = new Article($row['titre'], $row['contenu'], $row['categorie']);

        return $article;
    }
}
?>
