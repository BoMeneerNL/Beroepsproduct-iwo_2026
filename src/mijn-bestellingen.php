<?php
require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/loaders/templateloader.php';
require_once __DIR__ . '/sqlhandler.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$db = new SQLConnection();
printTemplate("pre_content", templateData: ["siteTitle" => "Bestellingen", "lang" => "nl"]);
printTemplate("load_css", ["css_location" => "/styles/tables.css"]);

?>
<main>
    <?php
    if(!isLoggedIn()){
        ?>
        <p>Je moet ingelogd zijn om je bestellingen te bekijken.</p>
        <p>
            <a href="/login">Inloggen</a> 
            of 
            <a href="/register">Registreren</a>
        </p>
        <?php
        printTemplate("post_content");
        exit;
    }
    $orders = $db->getWithSql("SELECT Pizza_Order.order_id, Pizza_Order.datetime, Pizza_Order.status, Pizza_Order.address, Pizza_Order_Product.product_name, Pizza_Order_Product.quantity
FROM Pizza_Order
INNER JOIN Pizza_Order_Product ON Pizza_Order.order_id = Pizza_Order_Product.order_id INNER JOIN Product ON Pizza_Order_Product.product_name = Product.name
WHERE Pizza_Order.client_username = :username
", [
        'username' => $_SESSION['user_data']['username']
    ]);
    $orderList = [];
    foreach ($orders as $order) {
       $orderList[$order['order_id']][] = [
            'datetime' => $order['datetime'],
            'status' => $order['status'],
            'address' => $order['address'],
            'product_name' => $order['product_name'],
            'quantity' => $order['quantity']
        ];
    }

    ?>
<main>
    <table class="product-table">
        <thead>
            <tr>
                <th>Bestelling ID</th>
                <th>Datum</th>
                <th>Status</th>
                <th>Adres</th>
                <th>Producten</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderList as $orderId => $orderDetails): ?>
                <tr>
                    <td><?php echo htmlspecialchars($orderId); ?></td>
                    <td><?php echo htmlspecialchars($orderDetails[0]['datetime']); ?></td>
                    <td><?php echo htmlspecialchars(resolveStatus($orderDetails[0]['status'])); ?></td>
                    <td><?php echo htmlspecialchars($orderDetails[0]['address']); ?></td>
                    <td>
                        <ul>
                            <?php foreach ($orderDetails as $detail): ?>
                                <li><?php echo htmlspecialchars($detail['product_name']); ?> (<?php echo htmlspecialchars($detail['quantity'] ?? "?"); ?>x)</li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td>
                        <a href="/bestelling?bestelling_id=<?php echo urlencode($orderId); ?>">Bestelling bekijken</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

    <?php

    printTemplate("post_content");
    ?>
