<?php

include_once __DIR__ . '/loaders/templateloader.php';
include_once __DIR__ . '/sqlhandler.php';

$db = new SQLConnection();

if (!isset($_GET["bestelling_id"])) {
    printTemplate('pre_content', ["siteTitle" => "Main page", "lang" => "nl"]);
    ?>
    <div class="center-content-middle">
        <h1>Bestelling niet gevonden</h1>
        <p>De bestelling die u probeert te bekijken bestaat niet of is verwijderd.</p>
        <a href="/">Terug naar de hoofdpagina</a>
    </div>
    <?php
} else {
    printTemplate('pre_content', ["siteTitle" => "Main page", "lang" => "nl"]);
    printTemplate('load_css', ["css_location" => "/styles/tables.css"]);
    printTemplate('load_css', ["css_location" => "/styles/forms.css"]);
    $bestelling = $db->getWithSql('SELECT pop.quantity, p.name AS product_name, po.status,po.client_name,po.client_username, po.address, p.price, p.image_link FROM Pizza_Order_Product pop JOIN Pizza_Order po ON pop.order_id = po.order_id JOIN Product p ON pop.product_name = p.name WHERE po.order_id = :order_id', ['order_id' => $_GET["bestelling_id"]]);
    $totalPrice = 0;
    foreach ($bestelling as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }
    if (count($bestelling) > 0) {
        $customerUsername = $bestelling[0]['client_username'] ?? null;
        $canViewCustomerName = false;
        if (isLoggedIn()) {
            $canViewCustomerName = $_SESSION['user_data']['role'] === 'Personnel'
                || ($customerUsername !== null && $_SESSION['user_data']['username'] === $customerUsername);
        }
        ?>
        <div>
            <h1>Bestelling Details</h1>
            <?php
            if ($canViewCustomerName && $customerUsername !== null) {
                ?>
                <p><a href="/klant?uname=<?php echo urlencode($customerUsername); ?>"><strong>Klantnaam:</strong> <?php echo htmlspecialchars($bestelling[0]['client_name'] ?? 'Onbekend Naam'); ?></a></p>
                <?php
            } elseif ($canViewCustomerName) {
                ?>
                <p><strong>Klantnaam:</strong> <?php echo htmlspecialchars($bestelling[0]['client_name'] ?? 'Onbekend Naam'); ?></p>
                <?php
            }
            ?>
            <p><strong>Adres:</strong> <?php echo htmlspecialchars($bestelling[0]['address']); ?></p>
            <p><strong>Totaalprijs:</strong> €<?php echo number_format($totalPrice, 2) ?></p>
            <p><strong>Status:</strong> <?php echo resolveStatus(($bestelling[0]['status'])); ?></p>
            <?php
            if(isLoggedIn()){
                if($_SESSION['user_data']['role'] == "Personnel"){
                    ?>
                    <form method="post" action="/api/statusAanpassen" id="status_aanpassen_bestelling">
                        <input type="hidden" name="bestelling_id" value="<?php echo htmlspecialchars($_GET['bestelling_id']); ?>">
                        <label><strong>Status aanpassen:</strong></label><br>
                        <?php foreach (range(1, 5) as $status) { 
                            ?>
                        <label>
                            <input type="radio" name="status" value="<?php echo $status; ?>" <?php echo ($bestelling[0]['status'] == $status) ? 'checked' : ''; ?>> <?php echo resolveStatus($status) ?></label>
                        <?php
                        }?>
                        <input type="submit" value="Status Aanpassen">
                    </form>
                    <?php

                }
            }
            
            
            ?>
        </div>
        
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
                    foreach ($bestelling as $bestelling_item) {
                        $productName = htmlspecialchars($bestelling_item['product_name']);
                        $amount = htmlspecialchars($bestelling_item['quantity']);
                        $price = number_format($bestelling_item['price'], 2);
                        $total = number_format($bestelling_item['price'] * $bestelling_item['quantity'], 2);
                        $image = $bestelling_item['image_link'] ?? 'https://www.lighting.philips.com.br/content/dam/b2b-philips-lighting/ecat-fallback.png';
                        $name = htmlspecialchars($bestelling_item['client_name'] ?? 'Onbekend Naam');
                        ?>
                        <tr>
                            <td>
                                <div class="product-cell">
                                    <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo $productName; ?>">
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
        </main>
        <?php
    } else {
        ?>
        <div class="center-content-middle">
            <h1>Bestelling niet gevonden</h1>
            <p>De bestelling die u probeert te bekijken bestaat niet of is verwijderd.</p>
            <a href="/">Terug naar de hoofdpagina</a>
        </div>
        <?php
    }
}




printTemplate('post_content');