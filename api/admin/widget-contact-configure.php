<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

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

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $email = str_replace('>', '&gt;', $email);
    $email = str_replace('<', '&lt;', $email);
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Informations manquantes");
}

if (isset($_POST['address'])) {
    $address = $_POST['address'];
    $address = str_replace('>', '&gt;', $address);
    $address = str_replace('<', '&lt;', $address);
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Informations manquantes");
}

if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
    $phone = str_replace('>', '&gt;', $phone);
    $phone = str_replace('<', '&lt;', $phone);
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Informations manquantes");
}

if (isset($_POST['people'])) {
    $people = $_POST['people'];
    $people = str_replace('>', '&gt;', $people);
    $people = str_replace('<', '&lt;', $people);
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Informations manquantes");
}

if (strpos($people, '|') !== false || strpos($phone, '|') !== false || strpos($address, '|') !== false || strpos($email, '|') !== false) {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Un ou plusieurs champs ont des valeurs contenants des caractères invalides");
}

file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-contact-data", $phone . "|" . $email . "|" . $address . "|" . $people);
require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");