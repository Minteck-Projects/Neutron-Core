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

if (isset($_POST['setting'])) {
    if (isset($_POST['value'])) {
        if ($_POST['value'] == "true") {
        } else if ($_POST['value'] == "false") {
        } else {
            die("Valeur incorrecte");
        }
    } else {
        die("Aucune valeur spécifiée");
    }
} else {
    die("Aucun paramètre sélectionné");
}

$slug = preg_replace("/[^0-9a-zA-Z ]/m", "", $_POST['setting']);
$slug = str_replace(" ", "-", $slug);

if ($slug != $_POST['setting']) {
    die("Nom du paramètre incorrect");
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_" . $slug)) {
    if ($_POST['value'] == "true") {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_" . $slug, "");
    }
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_" . $slug)) {
    if ($_POST['value'] == "false") {
        unlink($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_" . $slug);
    }
}

die("ok");