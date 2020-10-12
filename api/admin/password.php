<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

if (isset($_POST['oldpass'])) {
    if (trim($_POST['oldpass']) == "") {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Certains champs sont manquants, vides, ou ne contiennent que des espaces");
    }
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Certains champs sont manquants, vides, ou ne contiennent que des espaces");
}

if (isset($_POST['newpass'])) {
    if (trim($_POST['newpass']) == "") {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Certains champs sont manquants, vides, ou ne contiennent que des espaces");
    }
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Certains champs sont manquants, vides, ou ne contiennent que des espaces");
}

if (isset($_POST['newpassr'])) {
    if (trim($_POST['newpassr']) == "") {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Certains champs sont manquants, vides, ou ne contiennent que des espaces");
    }
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Certains champs sont manquants, vides, ou ne contiennent que des espaces");
}

if (password_verify($_POST['oldpass'], file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/password"))) {
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("L'ancien mot de passe est incorrect");
}

if (strlen($_POST['newpass']) < 8) {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Pour votre sécurité, les mots de passes doivent être long d'au moins 8 caractères. Ajoutez en encore " . (8 - strlen($_POST['newpass'])) . " pour que votre mot de passe ait 8 caractères");
}

if ($_POST['newpass'] == $_POST['newpassr']) {} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Les deux nouveaux mots de passes ne correspondent pas");
}

if (isset($_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN']) && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != ".." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "/") {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'])) {
        $tokens = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/tokens");
        foreach ($tokens as $token) {
            if ($token == "." || $token == "..") {} else {
                unlink($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $token);
            }
        }
    } else {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
        }
    }
} else {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    } else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
}

file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/password", password_hash($_POST['newpass'], PASSWORD_BCRYPT, ['cost' => 12,]));
require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");