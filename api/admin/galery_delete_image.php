<?php

if (isset($_COOKIE['ADMIN_TOKEN']) && $_COOKIE['ADMIN_TOKEN'] != "." && $_COOKIE['ADMIN_TOKEN'] != ".." && $_COOKIE['ADMIN_TOKEN'] != "/") {
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

if (isset($_POST['id'])) {
    // die($_POST['id']);
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $_POST['id'])) {
        $url = explode('|', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $_POST['id']))[0];
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $_POST['id'])) {
            unlink($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $_POST['id']);
        }
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $url)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . $url);
        }
        die("ok");
    }
} else {
    die("Pas d'identifiant");
}
