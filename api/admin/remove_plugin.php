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

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db))) {
    die("Extension pas installée");
}
try {
    unlink($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db) . "/name");
    unlink($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db) . "/description");
    unlink($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db) . "/author");
    unlink($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db) . "/source.php");
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db) . "/cms-store")) {
        unlink($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db) . "/cms-store");
    }
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db) . "/config")) {
        unlink($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db) . "/config");
    }
    try {
        rmdir($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db));
    } catch (Warning $err) {
        die("Le dossier de l'extension n'est pas vide : l'extension à été modifiée. Merci de la désinstaller manuellement en supprimant son dossier");
    }
    die("ok");
} catch (Warning $err) {
    die("Une erreur s'est produite lors de la suppression des fichiers de l'extension");
}