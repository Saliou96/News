<?php
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
}