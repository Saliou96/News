<?php

require './controllers/AllController.php';

$all = new AllController();
$articles = $all->getArticles();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Site d'actualités</title>
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

<body>
  <div id="wrapper" class="grid	min-h-screen" style="grid-template-rows: auto 1fr auto;">
    <header class="bg-blue-500 p-4">
      <div class="container mx-auto">
        <h1 class="text-white font-bold text-3xl">SenActu</h1>
      </div>
    </header>

    <div class="container mx-auto py-5">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mx-5">
        <!-- Sidebar -->
        <aside class="md:col-span-1 text-center">
          <h2 class="text-lg font-semibold mb-4 bg-blue-500 rounded-lg text-white">Catégories</h2>
          <ul>
            <li><a href="?category=all" class="category-link">Toutes les catégories</a></li>
            <?php
            // Vérifier s'il y a des catégories
            $categories = $all->getCategories();
            foreach ($categories as $categorie) {
              $idcategory = $categorie->getId();
              $categoryName = $categorie->getLibelle();
              echo '<li class="mt-5 rounded-lg hover:bg-blue-100 "><a href="?category=' . $idcategory . '" class="category-link">' . $categoryName . '</a></li>';
            }
            ?>
          </ul>
        </aside>

        <!-- Main Content -->
        <main class="md:col-span-2">
          <h2 class="text-lg font-semibold mb-4 bg-blue-500 rounded-lg text-white text-center">Actualités</h2>
          <h3></h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="news-container">

            <?php
            // Vérifier s'il y a des articles
            $articles = $all->getArticles();
            if (!empty($articles)) {
              foreach ($articles as $article):
                echo '<div class="bg-white p-4">';
                echo '<h3 class="text-lg font-semibold">' . $article->getTitre() . '</h3>';
                echo '<p>' . $article->getContenu() . '</p>';
                echo '</div>';
              endforeach;
            } else {
              echo "Aucun article trouvé.";
            }


            ?>
          </div>
        </main>
      </div>
    </div>

    <footer class="bg-blue-500 p-4 text-center text-white">
      <p>&copy; SenActu - 2023 - Tous droits réservés.</p>
    </footer>

  </div>
</body>

</html>