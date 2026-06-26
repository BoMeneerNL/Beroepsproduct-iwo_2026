<?php


require_once __DIR__ . '/../utils.php';
require_once __DIR__ . '/../sqlhandler.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $error = urlencode('Wrong Request Method On Request');
    redirect("/bestelling?error={$error}");
    exit;
}
$orderId = $_POST['bestelling_id'] ?? 0;
$status = $_POST['status'] ?? 0;
if(!mustAllExist($orderId,$status)) {
    redirect("/bestelling?bestelling_id=".$orderId ?? "");
    exit;
}
if(!is_numeric($orderId) || !is_numeric($status)) {
    redirect("/bestelling?bestelling_id=".$orderId ?? "");
    exit;
}

if($status < 1 || $status > 5) {
    redirect("/bestelling?bestelling_id=".$orderId ?? "");
    exit;
}
if(!isLoggedIn()){
    redirect("/login");
    exit;
}
if($_SESSION['user_data']['role'] !== 'Personnel') {
    redirect("/bestelling?bestelling_id=".$orderId ?? "");
    exit;
}

$db = new SQLConnection();
$db->executeWithSql("UPDATE Pizza_Order SET status = :status WHERE order_id = :orderId", [
    "status" => $status,
    "orderId" => $orderId
]);
$db->destroy();
redirect("/bestelling?bestelling_id=" . $orderId);
