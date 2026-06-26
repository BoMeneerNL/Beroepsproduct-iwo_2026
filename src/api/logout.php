<?php
require_once __DIR__ . '/../utils.php';
$_SESSION = [];
if(session_status() === PHP_SESSION_ACTIVE) {
    session_unset();
   session_destroy();
}
redirect("/login?success=" . urlencode('You have been logged out successfully'));