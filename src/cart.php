<?php
include_once __DIR__ . '/sqlhandler.php';
include_once __DIR__ . '/utils.php';
include_once __DIR__ . '/loaders/templateloader.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();

}

printTemplate('pre_content', ["siteTitle" => "Main page", "lang" => "nl"]);
printTemplate('load_css', ["css_location" => "/styles/tables.css"]);

$cart = getDoubleValuesAmount($_SESSION['cart'] ?? []);
if (empty($cart)) {
    ?>
    <main>
        <p>Je hebt momenteel geen producten in je winkelwagen</p>
        <p>Heb je zin in iets lekkers? <a href="/">Bekijk onze producten hier</a></p>
    </main>
    <?php

    printTemplate('post_content');
    exit;
}
$producten = [];
$db = new SQLConnection();
foreach ($cart as $productName => $amount) {
    $product = $db->getWithSql("SELECT price,image_link FROM Product WHERE name = :name", ["name" => $productName]);
    if ($product === false) {
        continue;
    }
    array_push($producten, [
        "name" => $productName,
        "amount" => $amount,
        "price" => $product[0]['price'],
        "image" => $product[0]['image_link']
    ]);
    $_SESSION['cart_clean'] = $producten;
}
?>
<main>
    <h1>Winkelwagen</h1>
    <table class="product-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Aantal</th>
                <th>Prijs per stuk</th>
                <th>Totaal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalPrice = 0;
            foreach ($producten as $product) {
                $productName = htmlspecialchars($product['name']);
                $amount = htmlspecialchars($product['amount']);
                $price = number_format($product['price'], 2);
                $total = number_format($product['price'] * $amount, 2);
                $totalPrice += $product['price'] * $amount;
                ?>
                <tr>
                    <td>
                        <div class="product-cell">
                            <img src="<?php echo $product['image'] ?? "https://www.lighting.philips.com.br/content/dam/b2b-philips-lighting/ecat-fallback.png" ?>" alt="<?php echo $productName; ?>">
                            <span><?php echo $productName; ?></span>
                        </div>
                    </td>
                    <td><?php echo $amount; ?></td>
                    <td>€<?php echo $price; ?></td>
                    <td>€<?php echo $total; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="cart-total">
        <h2>Totaalprijs: €<?php echo number_format($totalPrice, 2); ?></h2>
        <form action="/api/plaatsBestelling" method="post">
            <?php
            $prefilled_name = $_SESSION['user_data']['first_name'] ?? '';
            $prefilled_name .= ' ' . ($_SESSION['user_data']['last_name'] ?? '');
            $prefilled_address = $_SESSION['user_data']['address'] ?? '';
            ?>
            <input name="name" type="text" placeholder="Voer uw naam in" required value="<?php echo htmlspecialchars($prefilled_name); ?>">
            <input name="address" type="text" placeholder="Voer uw adres in" required value="<?php echo htmlspecialchars($prefilled_address); ?>">
            <input type="submit" value="Bestelling afronden">
        </form>
</main>