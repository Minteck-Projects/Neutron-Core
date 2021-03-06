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

header("Content-Type: application/json");

function error($errno, $errmsg) {
    if (strpos($errmsg, "Not Found") !== false) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("{\"error\":null,\"updates\":[]}");
    } else {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("{\"error\":\"" . str_replace("\"", "\\\"", trim($errmsg)) . "\",\"updates\":[]}");
    }
}

set_error_handler("error");

$obj = [
    'error' => null,
    'updates' => []
];
$version = explode("-", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version"))[0];
$json = json_decode(file_get_contents(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/update") . "/" . $version . "/updates.json"));

if (json_last_error() != JSON_ERROR_NONE) {
    $obj["error"] = "Received data is not valid JSON.";
}

if ($json->version->name != $version) {
    $obj["error"] = "Version mismatch. Expecting " . $version . " but got " . $json->version->name;
}

foreach ($json->updates as $update) {
    if (version_compare($version, $update->target) == -1) { // Update not installed
        array_push($obj['updates'], $update);
    }
}

require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit(json_encode($obj, JSON_PRETTY_PRINT));