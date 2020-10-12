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

function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

$uuid = gen_uuid();

if (isset($_POST['category'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories/" . $_POST['category'])) {

    } else {
        if ($_POST['category'] != "unclassed") {
            require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Catégorie innexistante");
        }
    }
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Pas de catégorie");
}

if (isset($_FILES['file'])) {
    if ($_FILES['file']['error'] == 1) {
        $maxsize = ini_get('upload_max_filesize');
        if ($maxsize > 1000) {
            if ($maxsize > 1000000) {
                $maxsizestr = round($maxsize / 1000000, 2) . " Mio";
            } else {
                $maxsizestr = round($maxsize / 1000, 2) . " Kio";
            }
        } else {
            $maxsizestr = $maxsize . " octets";
        }
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("La taille du fichier de la photo dépasse la taille maximale imposée par le serveur ({$maxsizestr})");
    }
    if ($_FILES['file']['error'] == 2) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("La taille maximale du fichier de formulaire à été dépassée");
    }
    if ($_FILES['file']['error'] == 3) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("La photo est incomplète (n'a pas été transmise entièrement)");
    }
    if ($_FILES['file']['error'] == 4) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("La photo est renseignée au serveur, mais elle n'a pas été transmise");
    }
    if ($_FILES['file']['error'] == 6) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Aucun dossier temporaire présent sur le serveur");
    }
    if ($_FILES['file']['error'] == 7) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Impossible d'écrire sur le disque");
    }
    if ($_FILES['file']['error'] == 8) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Un autre programme à interrompu la transmission du fichier");
    }
    if ($_FILES['file']['type'] != "image/png" && $_FILES['file']['type'] != "image/jpeg" && $_FILES['file']['type'] != "image/gif") {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le type de fichier de la photo n'est pas supporté. Merci d'utiliser une image PNG, JPEG, ou GIF, et non une image du type " . strtoupper(str_ireplace("image/", "", $_FILES['file']['type'])) . ".");
    }
    if ($_FILES['file']['error'] == 0) {
        if (/*!*//* <-- Fonction de test, décommentez le "!" pour forcer l'affichage de ce message */file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $uuid)) {
            echo("Vous êtes tombé sur une erreur très rare, bravo à vous !\n\nPrenez rapidement ce message en capture d'écran et transmettez le aux développeurs de Neutron.\n\nVous pouvez leur donner cette adresse de galerie Neutron comme preuve :\nmpcms-gallery://" . $uuid . "@");
            if (isset($_SERVER['HTTP_HOST'])) {
                echo($_SERVER['HTTP_HOST']);
            } else {
                if (isset($_SERVER['SERVER_NAME'])) {
                    echo($_SERVER['SERVER_NAME']);
                } else {
                    echo("unknown");
                }
            }
            echo("\n\nVotre site doit être publiquement accessible et vous ne devez pas avoir modifié Neutron pour que votre trouvaille soit référencée.");
            exit;
        }
        imagejpeg(imagecreatefromstring(file_get_contents($_FILES['file']['tmp_name'])), $_SERVER['DOCUMENT_ROOT'] . "/resources/upload/" . $uuid . ".jpg");
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $uuid, "/resources/upload/" . $uuid . ".jpg" . "|" . $_POST['category']);
        unlink($_FILES['file']['tmp_name']);
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/picdb.json")) {

        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/picdb.json", "{\"" . $_POST['category'] . "\":[\"" . $uuid . "\"]}");
        }
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
    }
}