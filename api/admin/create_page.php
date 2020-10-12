<?php

// require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("API pas prêt");

if (isset($_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN']) && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != ".." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "/") {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'])) {

    } else {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Jeton d'authentification invalide");
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
        }
    }
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Jeton d'authentification invalide");
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    } else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

if (isset($_POST['type'])) {} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Aucun type de page défini");
}

if (isset($_POST['title'])) {} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Aucun titre défini");
}

if (isset($_POST['content'])) {} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Aucun contenu n'a été spécifié");
}

$title = $_POST['title'];
$title = str_replace('>', '&gt;', $title);
$title = str_replace('<', '&lt;', $title);
if (substr($title, 0, 1) == " " || substr($title, 0, 1) == "-" || substr($title, 0, 1) == " " || substr($title, 0, 1) == "_" || substr($title, 0, 1) == "@" || substr($title, 0, 1) == "|" || substr($title, 0, 1) == "'" || substr($title, 0, 1) == "\"" || substr($title, 0, 1) == "~" || substr($title, 0, 1) == "&" || substr($title, 0, 1) == "=") {
    $prefixed = true;
} else {
    $prefixed = false;
}
$type = $_POST['type'];
$content = $_POST['content'];

$slug = preg_replace("/[^0-9a-zA-Z ]/m", "", $title );
$slug = str_replace(" ", "-", $slug);
$slug = strtolower($slug);

if ($prefixed) {
    $slug = "-" . $slug;
}

if (trim($title) == "") {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le titre ne peut pas être vide");
}

if ($slug == "api" || $slug == "cms-special" || $slug == "galery" || $slug == "cms-unrelated" || $slug == "vendor" || $slug == "data" || $slug == "resources" || $slug == "widgets" || $slug == "-htaccess" || $slug == "index" || $slug == "index-php") {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Vous ne pouvez pas utiliser un nom réservé en interne par le logiciel");
}

if (strlen($slug) > 70) {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le nom de la page est trop long");
}

if ($type != "0" && $type != "1") {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le type de page est inconnu");
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $slug)) {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Une page du même nom existe déjà");
}

file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $slug, $content);
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes/" . $slug, $type);
mkdir($_SERVER['DOCUMENT_ROOT'] . "/" . $slug);
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $slug . "/index.php", '<?php require_once $_SERVER[\'DOCUMENT_ROOT\'] . "/api/renderer/render.php"; render(\'' . $slug . '\'); ?>');
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $slug . "/pagename", $title);
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/admin/cache_pages_update.php";
require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");