<?php

header("Content-Type: application/json");
$data = array();

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {} else {
        die("\"Invalid token\"");
    }
} else {
    die("\"Invalid token\"");
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    die("\"Website not installed\"");
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/.htaccess")) {
    array_push($data, [
        "code" => "SECURE_HTACCESS",
        "severity" => 0,
        "message" => "Votre site contient un fichier .htaccess. Utiliser des directives incorrectement peut rendre vulnérable votre site..."
    ]);
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/cms-unrelated")) {
    if (count(scandir($_SERVER['DOCUMENT_ROOT'] . "/cms-unrelated")) > 2) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/cms-unrelated/.gitkeep")) {
            if (count(scandir($_SERVER['DOCUMENT_ROOT'] . "/cms-unrelated")) > 3) {
                array_push($data, [
                    "code" => "SECURE_UNRELATED",
                    "severity" => 0,
                    "message" => "Vous avez placé du contenu dans le dossier /cms-unrelated, IL NE S'AGIT PAS D'UN DOSSIER PRIVÉ..."
                ]);
            }
        } else {
            array_push($data, [
                "code" => "SECURE_UNRELATED",
                "severity" => 0,
                "message" => "Vous avez placé du contenu dans le dossier /cms-unrelated, IL NE S'AGIT PAS D'UN DOSSIER PRIVÉ..."
            ]);
        }
    }
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/adminkey")) {
    if (strlen(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/adminkey")) < 8) {
        array_push($data, [
            "code" => "SECURE_PASSWORD",
            "severity" => 1,
            "message" => "Le mot de passe de l'administrateur système de respecte pas les critères de sécurité"
        ]);
    }
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_antiDdos")) {
    array_push($data, [
        "code" => "SECURE_DENIALOS",
        "severity" => 2,
        "message" => "La protection anti-DDoS n'est pas activée"
    ]);
}

die(json_encode($data, JSON_PRETTY_PRINT));