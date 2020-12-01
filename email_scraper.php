<?php

$url = 'http://computerandu.wordpress.com/2011/06/29/how-to-get-google-invite/';
$emails = scrape_email($url);
echo implode(' ',$emails);// $emails est un array

function scrape_email($url) {
    if ( !is_string($url) ) {// si ce n'est pas une chaine de caractère
        return ''; 
    }
    //$result = @file_get_contents($url);
    $result = @curl_get_contents($url);//si le function curl-get-contents 
    //retourne une erreur la function s'execute quand même
    //MEME SI c'est une chose à éviter
    
    if ($result === FALSE) {
        return '';
    }
    
    // Convert to lowercase
    $result = strtolower($result);
    
    // Replace EMAIL DOT COM
    $result = preg_replace('#[(\\[\\<]?AT[)\\]\\>]?\\s*(\\w*)\\s*[(\\[\\<]?DOT[)\\]\\>]?\\s*[a-z]{3}#ms', '@$1.com', $result);

    // Email matches
    preg_match_all('#\\b([\\w\\._]*)[\\s(]*@[\\s)]*([\\w_\\-]{3,})\\s*\\.\\s*([a-z]{3})\\b#msi', $result, $matches);
    
    $usernames = $matches[1];
    $accounts = $matches[2];
    $suffixes = $matches[3];
    $emails = array();
    for ($i = 0; $i < count($usernames); $i++) {
        $emails[$i] = $usernames[$i] . '@' . $accounts[$i] . '.' . $suffixes[$i];
    }
    
    return $emails;
}

function clean($str) {
    if ( !is_string($str) ) {
        return '';
    } else {
        return trim(strtolower($str));
    }
}

function curl_get_contents($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);//TRUE pour inclure l'en-tête dans la valeur de retour. 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);//TRUE pour retourner le transfert en tant que chaîne de caractères de la valeur retournée par curl_exec() au lieu de l'afficher directement. 
    // For https connections, we do not require SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//FALSE pour arrêter cURL de vérifier le certificat du pair. Les certificats alternatifs à vérifier contre peuvent être spécifiés avec l'option CURLOPT_CAINFO ou un répertoire de certificat peut être spécifié avec l'option CURLOPT_CAPATH. 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);//Le nombre de secondes à attendre durant la tentative de connexion. Utiliser 0 pour attendre indéfiniment. 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);//TRUE pour suivre tous les en-têtes "Location: " que le serveur envoie dans les en-têtes HTTP (à noter que ceci est récursif, PHP suivra tous les en-têtes "Location: " qui lui sont envoyés à moins que CURLOPT_MAXREDIRS ne soit définie). 
    curl_setopt($ch, CURLOPT_MAXREDIRS, 5);//Le nombre maximal de redirections HTTP à suivre. Utilisez cette option avec l'option CURLOPT_FOLLOWLOCATION. 
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    $content = curl_exec($ch);//Exécute une session cURL
    //$error = curl_error($ch);
    //$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);//Ferme une session CURL
    return $content;
}

?>
