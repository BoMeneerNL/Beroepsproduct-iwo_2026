<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once "loaders/templateloader.php";

printTemplate("pre_content", templateData: ["siteTitle" => "Register", "lang" => "nl"]);
printTemplate("load_css", templateData: ["css_location" => "/styles/forms.css"]);

?>
<div class="center-content-middle">
    <form method="post" action="/api/createAccount" class="form-container">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required autocomplete="username">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required autocomplete="new-password">

        <div class="grid-container">
            <div>
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>

            <div>
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
        </div>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
        <input type="submit" value="Register">
    </form>
</div>
<?php
printTemplate("post_content");