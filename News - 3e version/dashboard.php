<?php

session_start();

// Check if the admin is logged in, if not, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require './controllers/AllController.php';

$all = new AllController();

// Handle form submissions for creating a new article
if (isset($_POST['create_article'])) {
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $categorie = $_POST['categorie'];

    $all->createArticle($titre, $contenu, $categorie);
}

// Handle form submissions for creating a new category
if (isset($_POST['create_category'])) {
    $libelle = $_POST['libelle'];

    $all->createCategorie($libelle);
}

$articles = $all->getArticles();
$categories = $all->getCategories();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestion des articles et catégories</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div id="wrapper" class="grid	min-h-screen" style="grid-template-rows: auto 1fr auto;">
        <header class="bg-blue-500 p-4">
            <div class="container mx-auto">
                <h1 class="text-white font-bold text-3xl">Dashboard - Gestion des articles et catégories</h1>
            </div>
        </header>
        <!-- Add a link to the homepage -->
        <div class="text-center mt-4">
            <a href="index.php" class="text-blue-500 hover:underline">Retour à la page d'accueil</a>
        </div>

        <div class="container mx-auto py-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mx-5">

                <!-- Articles Section -->
                <section class="md:col-span-1 bg-white p-4 rounded-lg">
                    <h2 class="text-lg font-semibold mb-4 bg-blue-500 rounded-lg text-white px-4 py-2">Articles</h2>
                    <form action="" method="POST">
                        <div class="mb-4">
                            <label for="titre" class="block text-gray-700 font-semibold">Titre</label>
                            <input type="text" name="titre" id="titre" required
                                class="w-full rounded-md px-3 py-2 border focus:outline-none focus:ring focus:border-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="contenu" class="block text-gray-700 font-semibold">Contenu</label>
                            <textarea name="contenu" id="contenu" required
                                class="w-full rounded-md px-3 py-2 border focus:outline-none focus:ring focus:border-blue-500"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="categorie" class="block text-gray-700 font-semibold">Catégorie</label>
                            <select name="categorie" id="categorie" required
                                class="w-full rounded-md px-3 py-2 border focus:outline-none focus:ring focus:border-blue-500">
                                <option value="">Sélectionner une catégorie</option>
                                <?php
                                foreach ($categories as $categorie) {
                                    echo '<option value="' . $categorie->getId() . '">' . $categorie->getLibelle() . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" name="create_article"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Ajouter un article
                        </button>
                    </form>

                    <hr class="my-4">

                    <h3 class="text-lg font-semibold mb-2">Liste des articles</h3>
                    <?php
                    if (!empty($articles)) {
                        echo '<ul class="list-disc pl-8">';
                        foreach ($articles as $article) {
                            echo '<li class="mb-2">';
                            echo '<strong>' . $article->getTitre() . '</strong> - Catégorie: ' . $article->getCategorie() . '<br>';
                            echo '<p>' . $article->getContenu() . '</p>';
                            echo '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo "<p class='text-gray-600'>Aucun article trouvé.</p>";
                    }
                    ?>
                </section>

                <!-- Categories Section -->
                <section class="md:col-span-1 bg-white p-4 rounded-lg">
                    <h2 class="text-lg font-semibold mb-4 bg-blue-500 rounded-lg text-white px-4 py-2">Catégories</h2>
                    <form action="" method="POST">
                        <div class="mb-4">
                            <label for="libelle" class="block text-gray-700 font-semibold">Libellé</label>
                            <input type="text" name="libelle" id="libelle" required
                                class="w-full rounded-md px-3 py-2 border focus:outline-none focus:ring focus:border-blue-500">
                        </div>
                        <button type="submit" name="create_category"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Ajouter une catégorie
                        </button>
                    </form>

                    <hr class="my-4">

                    <h3 class="text-lg font-semibold mb-2">Liste des catégories</h3>
                    <?php
                    if (!empty($categories)) {
                        echo '<ul class="list-disc pl-8">';
                        foreach ($categories as $categorie) {
                            echo '<li class="mb-2">';
                            echo '<strong>ID: ' . $categorie->getId() . '</strong> - Libellé: ' . $categorie->getLibelle() . '<br>';
                            echo '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo "<p class='text-gray-600'>Aucune catégorie trouvée.</p>";
                    }
                    ?>
                </section>

            </div>
        </div>

        <footer class="bg-blue-500 p-4 text-center text-white">
            <p>&copy; Dashboard - Gestion des articles et catégories - 2023 - Tous droits réservés.</p>
        </footer>

    </div>
</body>

</html>