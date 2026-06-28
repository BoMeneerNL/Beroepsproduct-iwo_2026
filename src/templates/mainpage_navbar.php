<?php
require_once __DIR__ . '/../utils.php';
disallowDirectAccess(__FILE__);

printTemplate("load_css", ["css_location" => "/styles/menus.css"]);
?>
<nav id="site-nav">
    <ul>
        <?php
        if (isset($templateData['productTypes']) && is_array($templateData['productTypes'])) {
            foreach ($templateData['productTypes'] as $productType) {
                $productType = htmlspecialchars($productType);
                echo "<li><a href=\"/#{$productType}\">{$productType}</a></li>";
            }
        }

        ?>
    </ul>
    <ul>
        <li>
            <form>
                <input type="text" name="prodse" placeholder="Zoeken..." required>
                <button type="submit">Zoeken</button>
            </form>
        </li>
    </ul>
    <ul>
        <li><a href="/privacy-verklaring">Privacyverklaring</a></li>
        <li><a href="/cart">Winkelwagen</a></li>
        <?php 
       if(isLoggedIn()){
            if($_SESSION['user_data']['role'] == "Personnel"){
                ?>
                <li><a href="/bestellingen">Bestellingen</a></li>
                <li><a href="/klanten">Klanten</a></li>
                <?php
            }
            else{
                ?>
                <li><a href="/mijn-bestellingen">Mijn bestellingen</a></li>
                <?php
            }
        }
            
        else{
            ?>
            <li><a href="/login">Inloggen</a></li>
            <li><a href="/register">Registreren</a></li>
            <?php
        }
        
        ?>

    </ul>
</nav>