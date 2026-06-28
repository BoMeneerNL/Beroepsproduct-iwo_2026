<?php
require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/loaders/templateloader.php';
require_once __DIR__ . '/sqlhandler.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

printTemplate("pre_content", templateData: ["siteTitle" => "Klantenlijst", "lang" => "nl"]);
printTemplate("load_css", ["css_location" => "/styles/tables.css"]);
if(!isLoggedIn()){
    ?>
    <p>Deze pagina is alleen toegankelijk voor beheerders.</p>
    <?php
    printTemplate("post_content");
    exit();
}
if(!$_SESSION['user_data']['role'] == "Personnel"){
    ?>
    <p>Deze pagina is alleen toegankelijk voor personeel.</p>
    <?php
    printTemplate("post_content");
    exit();
}

$db = new SQLConnection();
$klanten = $db->getWithSql("SELECT username,address,first_name,last_name FROM User WHERE role = 'Client'");



if(count($klanten) < 1){
    ?>
    <p>Geen klanten gevonden.</p>
    <?php
}
else{
    ?>
    <table class="klantenlijst-tabel">
        <thead>
            <tr>
                <th>Gebruikersnaam</th>
                <th>Adres</th>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($klanten as $klant): ?>
                <tr>
                    <td><?php echo htmlspecialchars($klant['username']); ?></td>
                    <td><?php echo htmlspecialchars($klant['address'] ?? "Geen adres bekend"); ?></td>
                    <td><?php echo htmlspecialchars($klant['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($klant['last_name']); ?></td>
                    <td><ul>
                        <li><a href="/klant?uname=<?php echo $klant['username']; ?>">Klant bekijken</a></li>
                    </ul></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}


printTemplate("post_content");