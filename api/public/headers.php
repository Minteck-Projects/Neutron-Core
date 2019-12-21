<?php

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    die("Le site n'a pas été installé, les opérations de l'API ne sont pas disponibles pour l'instant");
}

function ipHash() {
    $hash = str_replace("/", "-", str_replace(":", "-", password_hash($_SERVER['REMOTE_ADDR'], PASSWORD_BCRYPT, ['cost' => 5,'salt' => "MinteckProjectsCmsIpBan",])));
    return $hash;
}

function ipbPush() {
    $ip = ipHash();
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList")) {
        mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList");
    }
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList/" . $ip)) {
        $ipb = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList/" . $ip);
        $ipb_args = explode('|', $ipb);
        if ($ipb_args[1] == date('YmdHi')) {
            (int)$ipb_args[0] = (int)trim($ipb_args[0]) + 1;
            if ($ipb_args[0] >= 10) {
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps")) {
                    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps");
                }
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps/" . ipHash(), date('Ymd'));
            }
        } else {
            (int)$ipb_args[0] = 1;
            $ipb_args[1] = date('YmdHi');
        }
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList/" . $ip, implode("|", $ipb_args));
    } else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList/" . $ip, "1|" . date('YmdHi'));
    }
}

function dataValid($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_antiDdos")) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps/" . ipHash())) {
        if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps/" . ipHash()) == date('Ymd')) {
            ob_end_clean();
            header("HTTP/1.1 429 Too Many Requests");
            die("<title>429 Too Many Requests</title><center><h1>429 Too Many Requests</h1><hr>{$_SERVER['SERVER_SIGNATURE']}</center>");
        } else {
            ipbPush();
        }
    } else {
        ipbPush();
    }
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json")) {
    if (dataValid(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json"))) {
        $customSettings = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json"));
        if (isset($customSettings->AfficherBoutonAdministration) && isset($customSettings->AdministrationBarreNavigation) && isset($customSettings->RessourcesPersonnalisées) && isset($customSettings->RessourcesPersonnalisées->CSS) && isset($customSettings->RessourcesPersonnalisées->JS) && isset($customSettings->PagesMasquées)) {
        } else {
            header("Content-Type: application/json");
            header("HTTP/1.1 500 API Error");
            die(json_encode(array(
                'error' => "E_SYSTEM_ASETTINGS",
                'message' => "Advanced Settings are corrupted"
            )));
        }
    } else {
        header("Content-Type: application/json");
        header("HTTP/1.1 500 API Error");
        die(json_encode(array(
            'error' => "E_SYSTEM_ASETTINGS",
            'message' => "Advanced Settings are corrupted"
        )));
    }
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json", "{\n\"RessourcesPersonnalisées\": {\n    \"CSS\": \"\",\n    \"JS\": \"\"\n},\n\"PagesMasquées\": [],\n\"AfficherBoutonAdministration\": true,\n\"AdministrationBarreNavigation\": true\n}");
    if (dataValid(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json"))) {
        $customSettings = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json"));
        if (isset($customSettings->AfficherBoutonAdministration) && isset($customSettings->AdministrationBarreNavigation) && isset($customSettings->RessourcesPersonnalisées) && isset($customSettings->RessourcesPersonnalisées->CSS) && isset($customSettings->RessourcesPersonnalisées->JS) && isset($customSettings->PagesMasquées)) {
        } else {
            header("Content-Type: application/json");
            header("HTTP/1.1 500 API Error");
            die(json_encode(array(
                'error' => "E_SYSTEM_ASETTINGS",
                'message' => "Advanced Settings are corrupted"
            )));
        }
    } else {
        header("Content-Type: application/json");
        header("HTTP/1.1 500 API Error");
        die(json_encode(array(
            'error' => "E_SYSTEM_ASETTINGS",
            'message' => "Advanced Settings are corrupted"
        )));
    }
}