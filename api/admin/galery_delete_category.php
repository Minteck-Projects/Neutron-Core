<?php

if (isset($_COOKIE['_MPCMS_ADMIN_TOKEN']) && $_COOKIE['_MPCMS_ADMIN_TOKEN'] != "." && $_COOKIE['_MPCMS_ADMIN_TOKEN'] != ".." && $_COOKIE['_MPCMS_ADMIN_TOKEN'] != "/") {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['_MPCMS_ADMIN_TOKEN'])) {

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

$slug = $_POST['id'];

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories/" . $slug)) {
    $pictures = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures");
    foreach ($pictures as $picture) {
        if ($picture == "." || $picture == "..") {} else {
            $raw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $picture);
            $args = explode('|', $raw);
            if ($args == $raw) {
                die("Les métadonnées d'une image ({$picture}) sont corrompues, veuillez supprimer le lien dans /data/webcontent/galery/pictures");
            }
            if ($args[1] == $slug) {
                $args[1] = "unclassed";
            } else {
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories/" . $args[1]) || $args[1] == "unclassed") {} else {
                    die("Une image ({$picture}) fait référence à une catégorie qui n'existe pas, veuillez supprimer ou modifier le lien dans /data/webcontent/galery/pictures");
                }
            }
            $newraw = implode("|", $args);
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $picture, $newraw);
        }
    }
    unlink($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories/" . $slug);
    die("ok");
} else {
    die("Cette catégorie n'existe pas");
}