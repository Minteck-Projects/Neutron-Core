<?php

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

if (isset($_POST['category'])) {
    $category = trim($_POST['category']);
    $category = str_replace('>', '&gt;', $category);
    $category = str_replace('<', '&lt;', $category);
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Pas de nom donné");
}

$slug = preg_replace("/[^0-9a-zA-Z ]/m", "", $category );
$slug = str_replace(" ", "-", $slug);
$slug = strtolower($slug);

if ($slug == "unclassed") {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Vous ne pouvez pas utiliser un nom réservé par le système");
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories/" . $slug)) {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Une catégorie du même nom ou d'un nom similaire existe déjà");
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories/" . $slug, $category);
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
}