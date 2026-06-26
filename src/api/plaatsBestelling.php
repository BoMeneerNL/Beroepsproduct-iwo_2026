<?php
require_once __DIR__ . '/../utils.php';
require_once __DIR__ . '/../sqlhandler.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (empty($_SESSION['cart_clean']) || !isset($_SESSION['cart_clean'])) {
    redirect("/cart?error=" . urlencode('Your cart is empty'));
    exit;
}
$cart = $_SESSION['cart_clean'];

$db = new SQLConnection();
$name = $_POST['name'] ?? '';
$address = $_POST['address'] ?? '';
if (empty($address) || empty($name)) {
    redirect("/cart?error=" . urlencode('Address cannot be empty'));
    exit;
}
$address = htmlspecialchars($address);
$name = htmlspecialchars($name);
if (isset($_SESSION['user_data']['username'])) {
    $db->executeWithSql("INSERT INTO Pizza_Order (client_username,status,address,client_name,personnel_username,datetime)  VALUES (:username,1,:address,:name,'rdeboer',:currentTime)", [
        "username" => $_SESSION['user_data']['username'],
        "address" => $address,
        "name" => $name,
        "currentTime" => date('Y-m-d H:i:s')
    ]);
} else {
    $db->executeWithSql("INSERT INTO Pizza_Order (status,address,client_name,personnel_username,datetime)  VALUES (1,:address,:name,'rdeboer',:currentTime)", [
        "address" => $address,
        "name" => $name,
        "currentTime" => date('Y-m-d H:i:s')
    ]);
}
$latestOrderId = $db->getWithSql("SELECT MAX(order_id)  FROM Pizza_Order");
foreach ($cart as $product) {
    $db->executeWithSql("INSERT INTO Pizza_Order_Product (order_id,product_name,quantity) VALUES (:order_id,:product_name,:quantity)", [
        "order_id" => $latestOrderId[0]['MAX(order_id)'],
        "product_name" => $product['name'],
        "quantity" => $product['amount']
    ]);
}
$db->destroy();
$_SESSION['cart'] = [];
$_SESSION['cart_clean'] = [];
redirect("/bestelling?bestelling_id=" .$latestOrderId[0]['MAX(order_id)']);