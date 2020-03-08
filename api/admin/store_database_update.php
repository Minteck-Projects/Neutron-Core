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

try {
    $packages = file_get_contents("https://gitlab.com/minteck-projects/mpcms/plugins/raw/master/plugins.list");
    $packageslist = explode("\n", $packages);
    $packagesjson = new stdClass();
    foreach ($packageslist as $package) {
        if (trim($package) != "") {
            $packagesjson->$package = new stdClass();
            try {
                $packageinfo = file_get_contents("https://gitlab.com/minteck-projects/mpcms/plugins/raw/master/" . $package . "/store.json");
                $packageinfojson = json_decode($packageinfo);
                $packagesjson->$package = $packageinfojson;
            } catch (Warning $err) {
                die("Erreur d'incorporation du packet " . $package . " lors de l'obtention ou le décodage du fichier store");
            }
        }
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store/packages.json", json_encode($packagesjson, JSON_PRETTY_PRINT));
    die("ok");
} catch (Warning $err) {
    die("Impossible de récupérer la liste des extensions");
}