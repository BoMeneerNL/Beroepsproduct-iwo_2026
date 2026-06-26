<?php
require_once __DIR__ . '/../utils.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo "Method not allowed";
    exit;
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once __DIR__ . '/../sqlhandler.php';
$db = new SQLConnection();
if (!isset($_GET['itemid'])) {
    redirect("/");
    exit;
}
$item = $_GET['itemid'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$item = $db->getWithSql(
    "SELECT name FROM Product WHERE name = :name",
    ['name' => $item]
);
if (!empty($item)) {
    if (!isset($_GET['amount'])) {
        $amount = 1;
    } else if (!is_numeric($_GET['amount']) || $_GET['amount'] <= 0) {
        $amount = 1;
    } else {
        $amount = (int) $_GET['amount'];
    }

    for ($i = 0; $i < $amount; $i++) {
        array_push($_SESSION['cart'], $item[0]['name']);
    }


}
redirect(url: "/");


