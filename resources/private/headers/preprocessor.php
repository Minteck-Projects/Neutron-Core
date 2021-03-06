<?php

if (!function_exists("rlgps")) {
    function rlgps(string $message) {}
}

// Check if website is ready
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    $ready = true;
} else {
    $ready = false;
}

$_MD_INCLUDES = "/resources/lib/material"; // Path to Material Design files, can be changed if files are bundled with the code
$_MDI_PATH = "/resources/lib/material/iconfont.css"; // Path to Material Icons font, can be changed if files are bundled with the code

// Generate favicon if not yet generated
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/favicon.png") && $ready) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/api/engine-cyclic/components/favicon.php";
}

// Dark/light/dynamic theme + color
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/theme") && $ready) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/theme", "auto");
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/color") && $ready) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/color", "blue");
}

// Trim Build Values
try {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version", trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")));
} catch (E_WARNING $err) {}
try {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/api/codename", trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/codename")));
} catch (E_WARNING $err) {}
try {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/api/experimental", trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/experimental")));
} catch (E_WARNING $err) {}
try {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/api/public", trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/public")));
} catch (E_WARNING $err) {}
try {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/api/bugs", trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/bugs")));
} catch (E_WARNING $err) {}

// Functions to get localized name and description of a plugin
function getDescription($config) {
    $langsel = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/lang");

    if (isset($config->description->$langsel)) {
        return $config->description->$langsel;
    } else {
        return $config->description->en;
    }
}

function getName($config) {
    $langsel = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/lang");

    if (isset($config->name->$langsel)) {
        return $config->name->$langsel;
    } else {
        return $config->name->en;
    }
}

// Language Loader
require $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php";

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache") && $ready) { // Cache directory
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache");
}

// Function to check if a JSON string is valid
function dataValid($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

// Custom Styles, create directory
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/styles.json")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/styles.json", "[]");
}

// Connections Log
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") && $ready) {
    if (strpos($_SERVER['HTTP_USER_AGENT'], "MinteckProjectsAutoUptime") !== false) {} else { // Don't log for Auto-Uptime bot
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - INTERFACE/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
} else {
    if (strpos($_SERVER['HTTP_USER_AGENT'], "MinteckProjectsAutoUptime") !== false || !$ready) {} else { // Don't log for Auto-Uptime bot
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - INTERFACE/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
}

// Migrate old "adminkey" to new "authkey"
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/adminkey")) {
    copy($_SERVER['DOCUMENT_ROOT'] . "/data/adminkey", $_SERVER['DOCUMENT_ROOT'] . "/data/authkey");
    unlink($_SERVER['DOCUMENT_ROOT'] . "/data/adminkey");
}

/* Old statistics system, not used anymore */
/*try { // Failing is not important
    // Statistics directory
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats")) {} else {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats");
        }
    }

    // Only if website ready
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/")) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d"))) {
            if (strpos($_SERVER['HTTP_USER_AGENT'], "MinteckProjectsAutoUptime") !== false) {} else { // Don't log for Auto-Uptime bot
                (int)$actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d"));
                $actual = $actual + 1;
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d"), $actual);
            }
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d"), "1");
        }
    }
} catch (E_WARNING $err) {
}*/

// New statistics system
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats")) {} else {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
        mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats");
    }
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/")) {
    if (isset($_SERVER['REMOTE_ADDR']) && file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats")) {
        //$hash = @password_hash($_SERVER['REMOTE_ADDR'], PASSWORD_DEFAULT, [ "salt" => "net.minteckprojects.fns.neutron.stats" ]); // Storing IP addresses is illegal in EU, so just a hashed IP addresses
        $hash = md5($_SERVER['REMOTE_ADDR']); // Changed to MD5 sum instead of encrypted IP because salt not supported anymore
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats/" . date('Y'))) {} else {
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats/" . date('Y'));
        }
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats/" . date('Y') . "/" . date('m'))) {} else {
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats/" . date('Y') . "/" . date('m'));
        }
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats/" . date('Y') . "/" . date('m') . "/" . date('d'))) {
            $file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats/" . date('Y') . "/" . date('m') . "/" . date('d'));
            $lines = explode("\n", $file);

            $already = false;
            foreach ($lines as $line) {
                if (trim($line) == "" || trim($line) == "\n") {} else {
                    if (trim($line) == trim($hash)) {
                        $already = true;
                    }
                }
            }

            if (!$already) {
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats/" . date('Y') . "/" . date('m') . "/" . date('d'), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats/" . date('Y') . "/" . date('m') . "/" . date('d')) . $hash . "\n");    
            }
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats/" . date('Y') . "/" . date('m') . "/" . date('d'), $hash . "\n");
        }
    }
}

// Check for updates at random intervals
if (rand(0, 10) == 5) {
    try {
        $version = explode("-", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version"))[0];
        $json = json_decode(@file_get_contents(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/update") . "/" . $version . "/updates.json"));

        if (isset($json)) {
            if (json_last_error() != JSON_ERROR_NONE) {
                $updates = -1;
            }

            if ($json->version->name != $version) {
                $updates = -1;
            }
        
            foreach ($json->updates as $update) {
                if (!isset($updates)) {
                    $updates = 1;
                }
            }
        
            if (!isset($updates)) {
                $updates = 0;
            }
        } else {
            $updates = -1;
        }

        if ($updates == 1) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/updates", "");
        } else {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/updates")) {
                unlink($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/updates");
            }
        }
    } catch (E_WARNING $err) {}
}
