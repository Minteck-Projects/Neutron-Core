<?php

$_MD_INCLUDES = "https://unpkg.com/material-components-web@latest/dist"; // Path to Material Design files, can be changed if files are bundled with the code
$_MDI_PATH = "https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined"; // Path to Material Icons font, can be changed if files are bundled with the code

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

// Language Loader
include $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php";

// Hash the IP address (because storing raw IP without reason is illegal)
function ipHash() {
    $hash = str_replace("/", "-", str_replace(":", "-", password_hash($_SERVER['REMOTE_ADDR'], PASSWORD_BCRYPT, ['cost' => 5,'salt' => "MinteckProjectsCmsIpBan",])));
    return $hash;
}

// Anti-DDoS feature, which will be used only if admin enabled it
function ipbPush() {
    $ip = ipHash(); // Hash the IP address
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList")) {
        mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList"); // Create bans directory if it doesn't exists
    }
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList/" . $ip)) { // If user is already registered
        $ipb = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList/" . $ip);
        $ipb_args = explode('|', $ipb);
        if ($ipb_args[1] == date('YmdHi')) {
            (int)$ipb_args[0] = (int)trim($ipb_args[0]) + 1;
            if ($ipb_args[0] >= 15) {
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
        // echo("<script>console.log('{$_SERVER['R²EMOTE_ADDR']}: {$ipb_args[0]} requests this minute.");
        if ($ipb_args[0] >= 10) {
            // echo(" Next request will be tempban.");
        }
        // echo("')</script>");
    } else { // If user is new
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList/" . $ip, "1|" . date('YmdHi'));
        // echo("<script>console.log('{$_SERVER['REMOTE_ADDR']}: 1 requests this minute.')</script>");
    }
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache")) { // Cache directory
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache");
}

// Anti-DDOS enabler
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_antiDdos")) { // Show 429 Too Many Requests and abort if user is blocked
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
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps")) { // Show 503 Service Unavailable if many users are blocked → prevent IP-changing DDoS
    $bans = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps");
    $banscount = 0;
    foreach ($bans as $ban) {
        if ($ban != "." && $ban != "..") {
            if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps/" . $ban) == date('Ymd')) {
                $banscount = $banscount + 1;
            }
        }
    }
    if ($banscount >= 10) {
        ob_end_clean();
        header("HTTP/1.1 503 Service Unavailable");
        die("<title>503 Service Unavailable</title><center><h1>503 Service Unavailable</h1><hr>{$_SERVER['SERVER_SIGNATURE']}</center>");
    }
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
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
    if (strpos($_SERVER['HTTP_USER_AGENT'], "MinteckProjectsAutoUptime") !== false) {} else { // Don't log for Auto-Uptime bot
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - INTERFACE/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
} else {
    if (strpos($_SERVER['HTTP_USER_AGENT'], "MinteckProjectsAutoUptime") !== false) {} else { // Don't log for Auto-Uptime bot
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - INTERFACE/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
}

try { // Failing is not important
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
}