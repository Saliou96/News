<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "mglsi_user", "passer", "mglsi_news");

// Vérification de la connexion
if ($conn->connect_error) {
  die("La connexion à la base de données a échoué : " . $conn->connect_error);
}
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

            // Récupérer les catégories depuis la base de données
            $sql = "SELECT * FROM Categorie";
            $result = $conn->query($sql);

            // Vérifier s'il y a des catégories
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $category = $row['id'];
                $categoryName = $row['libelle'];
                echo '<li class="mt-5 rounded-lg hover:bg-blue-100 "><a href="?category=' . $category . '" class="category-link">' . $categoryName . '</a></li>';
              }
            } else {
              echo "Aucune catégorie trouvée.";
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
            

            // Construction de la requête SQL en fonction de la catégorie sélectionnée
            $categoryFilter = isset($_GET['category']) ? $_GET['category'] : 'all';
            $sql = "SELECT * FROM Article";
            if ($categoryFilter !== 'all') {
              $sql .= " WHERE categorie = " . $categoryFilter;
            }

            // Récupérer les articles depuis la base de données
            $result = $conn->query($sql);
            // Vérifier s'il y a des articles
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo '<div class="bg-white p-4">';
                echo '<h3 class="text-lg font-semibold">' . $row['titre'] . '</h3>';
                echo '<p>' . $row['contenu'] . '</p>';
                echo '</div>';
              }
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