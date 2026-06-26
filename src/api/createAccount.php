<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../utils.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $error = urlencode('Wrong Request Method On Request');
    redirect("/register?error={$error}");
    exit;
}



if (!mustAllExist($_POST['username'], $_POST['password'], $_POST['first_name'], $_POST['last_name'],$_POST['address'])) {
    $error = urlencode('Field Validation Failed');
    redirect("/register?error={$error}");
    exit;

}


require_once __DIR__ . '/../sqlhandler.php';

$db = new SQLConnection();
$username = strtolower($_POST['username']);
$countForUsername = $db->getWithSql(
    "SELECT COUNT(*) AS count FROM User WHERE username = :username",
    ['username' => $username]
);

$usernameExists = $countForUsername[0]['count'] > 0;
if ($usernameExists) {
    $error = urlencode('Username Already Exists');
    redirect("/register?error={$error}");
    exit;
}
$creationParams = [
    'username' => $username,
    'password' => password_hash($_POST['password'], PASSWORD_ARGON2ID),
    'first_name' => $_POST['first_name'] ?? '',
    'last_name' => $_POST['last_name'] ?? '',
    'address' => $_POST['address'] ?? ''
];
$db->executeWithSql(
    "INSERT INTO User (username, password,first_name,last_name, role,address) VALUES (:username, :password,:first_name,:last_name,'Client', :address)",
    $creationParams
);

$db->destroy();
redirect("/login?success=" . urlencode('Account Created Successfully, you can now login on this page'));
