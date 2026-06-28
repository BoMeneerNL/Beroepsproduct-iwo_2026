<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once "utils.php";


require_once "loaders/templateloader.php";

printTemplate("pre_content", templateData: ["siteTitle" => "Login", "lang" => "nl"]);
printTemplate("load_css", templateData: ["css_location" => "/styles/forms.css"]);

?>

<div class="center-content-middle">
    <form method="post" action="/api/login" class="form-container">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required autocomplete="username">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required autocomplete="current-password">
        <input type="submit" value="Login">
    </form>
</div>

<?php
printTemplate("post_content");