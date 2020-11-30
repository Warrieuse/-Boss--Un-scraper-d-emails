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
                $data = $database->select("Emails", "*");
                //echo display_table();
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
    <form action="" method="POST">

    <label for="url">Enter an https:// URL:</label>
    <input type="url" name="url" id="url" placeholder="https://example.com" pattern="https://.*" size="30" required>

    <input type="submit" name="submit" value="envoyer">
    </form>

    <main class="container">
        <div class="row">
            <section class="col-12">
                <table class="table">
                    <thead>
                        <th>Voici la liste de tout les emails inscrits.</th>
                    </thead>
                    <tbody>
                        <?php foreach($data as $email){
                            while ($a <= 10) {
                                # code...
                            }?>
                        <tr>
                            <td><?php $email?></td>
                        </tr>
                        <?php }?>

                    </tbody>
                </table>
            </section>

        </div>
    </main>
</body>
</html>