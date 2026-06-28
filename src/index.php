<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once 'sqlhandler.php';
require_once 'loaders/templateloader.php';
require_once 'utils.php';

$db = new SQLConnection();
$searchTerm = $_GET['prodse'] ?? "";
$producten = groupByArrayKey("type_id", $db->getWithSql("select name,price,image_link,type_id from Product WHERE name LIKE :searchTerm", [":searchTerm" => "%$searchTerm%"]));
printTemplate('pre_content', ["siteTitle" => "Main page", "lang" => "nl"]);
printTemplate('load_css', ["css_location" => "/styles/menus.css"]);
printTemplate('php%mainpage_navbar', [
    'productTypes' => array_keys($producten)
]);

?>
<main>
    <h1>Menu</h1>
    <?php
    $productIngredientsDb = $db->getWithSql("SELECT product_name, ingredient_name FROM Product_Ingredient");
    $productIngredients = [];
    foreach ($productIngredientsDb as $row) {
        $productIngredients[$row['product_name']][] = $row['ingredient_name'];
    }
    if (empty($producten)) {
        ?>
        <p>Geen producten gevonden voor de zoekterm "<?php echo htmlspecialchars($searchTerm); ?>".</p>
        <?php
        printTemplate('post_content');
        exit;
    }
    foreach ($producten as $productType => $productItems) {
        if (empty($productItems)) {
            continue;
        }
        $productType = htmlspecialchars($productType);
        echo "<h2 id=\"{$productType}\"> {$productType}</h2>";
        echo "<div class='menu-wrapper'>";
        foreach ($productItems as $productItem) {
            $productName = htmlspecialchars($productItem['name']);
            $productPrice = number_format($productItem['price'], 2);
            $productImageURL = htmlspecialchars($productItem['image_link'] ?? 'https://www.lighting.philips.com.br/content/dam/b2b-philips-lighting/ecat-fallback.png');
            printTemplate('menu_item', [
                'productName' => htmlspecialchars($productName),
                'productPrice' => htmlspecialchars($productPrice),
                'productImageURL' => htmlspecialchars($productImageURL),
                'productIngredients' => htmlspecialchars(implode(", ", $productIngredients[$productName] ?? ["Geen ingrediënten bekend"]))
            ]);
        }
        echo "</div>";
    }
    ?>
    </div>
    <p>
    </p>
</main>
<?php

printTemplate('post_content');
?>