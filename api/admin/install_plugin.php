<?php

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("Jeton d'authentification invalide");
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
        }
    }
} else {
    die("Jeton d'authentification invalide");
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    } else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
}

if (isset($_GET['id'])) {
    $foundone = false;
    $db = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store/packages.json"));
    foreach ($db as $package) {
        if (array_search($package, (array)$db) == $_GET['id']) {
            $pf = $package;
            $name = $package->name;
            $foundone = true;
        }
    }
    if ($foundone) {
        $package = $pf;
    } else {
        $package = null;
    }
    if (!$foundone) {
        die("Paquet inconnu");
    }
} else {
    die("Pas d'identifiant de paquet");
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db))) {
    die("Extension déjà installée");
}

try {
    $source = file_get_contents("https://gitlab.com/minteck-projects/mpcms/plugins/raw/master/" . array_search($package, (array)$db) . "/source.php");
} catch (Warning $err) {
    die("Une erreur s'est produite lors de la récupération de l'extension depuis les serveurs de Minteck Projects");
}

try {
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db));
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db) . "/name", $package->name);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db) . "/description", $package->description);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db) . "/author", $package->author);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db) . "/source.php", $source);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db) . "/cms-store", "0");
    if (isset($package->config)) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db) . "/config", $package->config);
    }
    die("ok");
} catch (Warning $err) {
    die("Une erreur s'est produite lors de l'installation sur le disque de l'extension");
}