<header>
    <nav>
        <ul>
            <li><a href="/">All</a></li>
            <?php
            $categories = $articleCategorieController->getCategories();
            foreach ($categories as $categorie) {
                $idCat = $categorie->getId();
                $libCat = $categorie->getLibelle();
                echo '<li><a href="?categorie=' . $idCat . '">' . $libCat . '</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>
