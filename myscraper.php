<?php
require_once ("database.php");
include "email_scraper.php";

//$url = 'https://github.com/nyxgeek/username-lists/blob/master/usernames-top100/usernames_gmail.com.txt';



if (isset($_POST['submit'])){
    if (!empty($_POST['url'])){
        $url = htmlspecialchars($_POST['url']);
        $emails = scrape_email($url);
        foreach ($emails as $email) {
            $database->insert("Emails", [
                "email"=>$email,
                ]);
        };

    }
}



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scraper Emails</title>
</head>
<body>
    <form action="" method="POST">

    <label for="url">Enter an https:// URL:</label>
    <input type="url" name="url" id="url" placeholder="https://example.com" pattern="https://.*" size="30" required>
    
    <input type="submit" name="submit" value="envoyer">
    </form>
</body>
</html>