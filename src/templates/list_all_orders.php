<?php
require_once __DIR__ . '/../utils.php';
disallowDirectAccess(__FILE__);

if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once __DIR__ . "/../sqlhandler.php";




if(!isLoggedIn()){
    ?>
    <p>Om je vorige bestellingen te bekijken moet je ingelogd zijn.</p>
    <span>Je kan <a href="/login">hier inloggen</a> of <a href="/register">hier registreren</a>.</span>

<?php
}
else{
    try{
    $db = new SQLConnection();
    $bestellingen = [];
    if($_SESSION['user_data']['role'] == "Personnel"){
        $bestellingen = $db->getWithSql("SELECT * FROM Pizza_Order");
    }
    else{
        $bestellingen = $db->getWithSql("SELECT * FROM Pizza_Order");

    }
    }
    catch(Exception $e){
        echo "Er is een fout opgetreden bij het ophalen van de bestellingen: " . $e->getMessage();
        exit;
    }
}



