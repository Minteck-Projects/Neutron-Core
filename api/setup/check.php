<?php

// require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("It works!");

if (substr($_SERVER['SERVER_PROTOCOL'], 0, 4) != "HTTP") {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le protocole de transmission utilisé n'est pas supporté");
}

if ($_SERVER['REQUEST_METHOD'] != "GET") {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("La méthode de requête n'est pas supportée par ce type de requête à l'API");
}

if ($_SERVER['SCRIPT_NAME'] != "/api/setup/check.php") {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("L'API n'est pas installé correctement");
}

if (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') !== false) {} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le navigateur ne supporte pas le type de pages web utilisé par le logiciel");
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/upload")) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/resources/upload");
}

ob_start();
phpinfo();
$data = ob_get_contents();
ob_clean();
if (strpos($data, '<tr><td class="e">GD Support </td><td class="v">enabled </td></tr>') !== false) {} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("La librairie GD2 n'est pas installée ou activée sur ce serveur");
}

if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false) {} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Votre navigateur n'est pas supporté, merci d'utiliser Firefox ou un autre navigateur récent et mis à jour");
}

if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'iOS') !== false) {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Vous ne pouvez pas configurer le logiciel depuis un téléphone mobile, merci de passer par un ordinateur");
}

require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");