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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
    <form action="" method="POST">

    <label for="url">Enter an https:// URL:</label>
    <input type="url" name="url" id="url" placeholder="https://example.com" pattern="https://.*" size="30" required>

    <input type="submit" name="submit" value="envoyer">
    </form>

            <h1>Voici la liste de tout les emails inscrits.</h1>

                <table class="table">
                        <?php $i = 0 ; // je met mon compteur à 0 (initialise compteur en français)
                         foreach($emails as $email):$i++ //à chaque boucle $i augmente de 1?>
                        <?php if ($i == 1) :?>
                            <tr>
                        <?php endif;?>

                            <td><?php echo $email ?></td>

                        <?php if ($i == 6): $i = 0; //ligne fini on fait un reset sur le i (donc on remet le compteur à 0?>
                            </tr>
                        <?php endif;?>
                        <?php endforeach;?>
                        <!-- je rajoute une condition si le nbr de email de la dernière ligne 
                        n'est pas un multiple de 6 je dois fermer la ligne avant de 
                        fermer le tableau  -->
                        <?php if ($i != 0) :?>
                            </tr>
                        <?php endif ?>
                </table>

</body>
</html>