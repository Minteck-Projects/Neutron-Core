<?php

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
        echo("<script>console.log('{$_SERVER['REMOTE_ADDR']}: {$ipb_args[0]} requests this minute.");
        if ($ipb_args[0] >= 10) {
            echo(" Next request will be tempban.");
        }
        echo("')</script>");
    } else { // If user is new
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList/" . $ip, "1|" . date('YmdHi'));
        echo("<script>console.log('{$_SERVER['REMOTE_ADDR']}: 1 requests this minute.')</script>");
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

// Preloader, if enabled
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_resourcesPreload")) {
    echo('<link rel="preload" href="/resources/themes/colors/dark.js" as="script">');
    echo('<link rel="preload" href="/resources/themes/icons/classic.js" as="script">');
    echo('<link rel="preload" href="/resources/themes/icons/suru.js" as="script">');
    echo('<link rel="preload" href="/resources/js/right-click.js" as="script">');
    echo('<link rel="preload" href="/resources/js/jquery.js" as="script">');
    echo('<link rel="preload" href="/resources/lib/pushbar.js/library.js" as="script">');
    echo('<link rel="preload" href="/resources/lib/pushbar.js/library.css" as="style">');
    echo('<link rel="preload" href="/resources/css/ui.css" as="style">');
    echo('<link rel="preload" href="/resources/css/snowapi.css" as="style">');
    echo('<link rel="preload" href="/resources/css/setup.css" as="style">');
    echo('<link rel="preload" href="/resources/css/right-click.css" as="style">');
    echo('<link rel="preload" href="/resources/css/preview.css" as="style">');
    echo('<link rel="preload" href="/resources/css/main.css" as="style">');
    echo('<link rel="preload" href="/resources/css/fonts-import.css" as="style">');
    echo('<link rel="preload" href="/resources/css/error.css" as="style">');
    echo('<link rel="preload" href="/resources/css/admin.css" as="style">');
}

// Function to check if a JSON string is valid
function dataValid($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

// This will run only if the website is ready
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    // Custom settings parser
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json")) {
        if (dataValid(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json"))) {
            $customSettings = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json"));
            if (isset($customSettings->AfficherBoutonAdministration) && isset($customSettings->AdministrationBarreNavigation) && isset($customSettings->RessourcesPersonnalisées) && isset($customSettings->RessourcesPersonnalisées->CSS) && isset($customSettings->RessourcesPersonnalisées->JS) && isset($customSettings->PagesMasquées)) {
                if (!$customSettings->AfficherBoutonAdministration) {
                    echo("<style>#siteadmin-button{display:none;}</style>");
                }
                if (!$customSettings->AdministrationBarreNavigation) {
                    echo("<style>#settings #navigation{display:none;}</style>");
                }
                echo("<style type=\"text/css\">" . $customSettings->RessourcesPersonnalisées->CSS . "</style>");
                echo("<script type=\"text/javascript\">" . $customSettings->RessourcesPersonnalisées->JS . "</script>");
            } else {
                die("<h1>" . $lang["header"]["internalError"][0] . "</h1><p>" . $lang["header"]["internalError"][1] . "</p><p>" . $lang["header"]["internalError"][2] . "<code>/data/webcontent/customSettings.json</code>" . $lang["header"]["internalError"][3] . "</p><hr><i>Minteck Projects CMS " . str_replace("#", substr(md5(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")), 0, 2), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")) . " " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/codename") . "</i>");
            }
        } else {
            die("<h1>" . $lang["header"]["internalError"][0] . "</h1><p>" . $lang["header"]["internalError"][4] . "</p><p>" . $lang["header"]["internalError"][2] . "<code>/data/webcontent/customSettings.json</code>" . $lang["header"]["internalError"][3] . "</p><hr><i>Minteck Projects CMS " . str_replace("#", substr(md5(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")), 0, 2), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")) . " " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/codename") . "</i>");
        }
    } else {
        // TODO: Due to i18n, change custom settings to english names, and require migration at user-end
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json", "{
    \"RessourcesPersonnalisées\": {
        \"CSS\": \"\",
        \"JS\": \"\"
    },
    \"PagesMasquées\": [],
    \"AfficherBoutonAdministration\": true,
    \"AdministrationBarreNavigation\": true
}");
    }
}


// Custom Styles, create directory
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/styles.json")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/styles.json", "[]");
}

echo('<link rel="stylesheet" href="/resources/upload/styles.css">'); // Custom styles loader
echo('<script src="/resources/js/jquery.js"></script>'); // JQuery, used at almost all pages

// Error Handler
function errors($level, $description, $file, $line) {
    global $lang;
    if ($level == E_USER_ERROR) { // Internal Error
	if (strpos($description, "filesize()") === false) {
	    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/ERROR - " . $file . ":" . $line . " - " . $description . "\n\n");
            } else {
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/ERROR - " . $file . ":" . $line . " - " . $description . "\n\n");
            }
        }
    }
    if ($level == E_USER_WARNING) { // Warning
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/WARNING - " . $file . ":" . $line . " - " . $description . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/WARNING - " . $file . ":" . $line . " - " . $description . "\n\n");
        }
    }
    if ($level == E_USER_NOTICE) { // Notice
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/NOTICE - " . $file . ":" . $line . " - " . $description . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/NOTICE - " . $file . ":" . $line . " - " . $description . "\n\n");
        }
    }
    if ($level != E_USER_NOTICE && $level != E_USER_ERROR && $level != E_USER_WARNING) { // Unknown Error
        if (strpos($description, "filesize()") === false) { // Don't show error for 'filesize()' fail (bug on Windows servers)
	    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/UNKNOWN - " . $file . ":" . $line . " - " . $description . "\n\n");
            } else {
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/UNKNOWN - " . $file . ":" . $line . " - " . $description . "\n\n");
            }
        }
    }
    if (strpos($description, "filesize()") === false) { // Don't show error for 'filesize()' fail (bug on Windows servers)
        echo('<p><table class="message_error"><tbody><tr><td><img src="/resources/image/message_error.svg" class="message_img"></td><td style="width:100%;"><p>' . $lang["header"]["phpError"][0] . '</p><p>' . $lang["header"]["phpError"][1] . ' <b>PHP-INTERNAL-ERROR/</b></p><p>' . $lang["header"]["phpError"][2] . '</p></td></tr></tbody></table></p>');
    }
    return true;
}

// Enable error handler only if website ready
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    set_error_handler("errors");
} else {
    return;
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

echo('<div id="snowapi-placeholder"><div snowapi-enable-snowfall></div></div>'); // SnowAPI Main Wrapper, used for Xmas Mode plugin

echo("<script>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/global.js") . "</script>"); // Global Scripts

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntufont-enabled")) { // Change font to Ubuntu if enabled
    echo('<link rel="stylesheet" href="/resources/themes/fonts/ubuntu.css">');
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntulfont-enabled")) { // Change font to Ubuntu Light if enabled
    echo('<link rel="stylesheet" href="/resources/themes/fonts/ubuntu-light.css">');
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/darktheme-enabled")) { // Load Dark Theme if enabled
    echo('<link rel="stylesheet" href="/resources/themes/colors/dark.css">');
    echo('<script src="/resources/themes/colors/dark.js"></script>');
}

// END of PHP header functions
?>

<!-- Program JavaScript Error — taken from pMessage, a prototype of online messaging system -->
<pjse-placeholder class="hide">
        <pjse-window>
            <pjse-window-inner>
                <pjse-title><?= $lang["header"]["pjseDefault"][0] ?></pjse-title>
                <pjse-message><?= $lang["header"]["pjseDefault"][1] ?></pjse-message><br><br>
                <pjse-close onclick="closeError()"><span><?= $lang["header"]["pjseDefault"][2] ?></span></pjse-close>
            </pjse-window-inner>
        </pjse-window>
    </pjse-placeholder>

<!-- Snackbar, used for minor errors or messages -->
<div id="snackbar"><?= $lang["header"]["snackbarDefault"] ?></div>

<script>

// Replace all prototype for strings, using RegExp
String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

// JavaScript Error Handler
roo_alert = false;

function alert_full(text, refreshOnOk) {
    try {
        if (text == "ResizeObserver loop completed with undelivered notifications.") {
            return;
        }
        if (typeof refreshOnOk == "boolean") {
            roo_alert = refreshOnOk;
        }
        if (typeof text == "string") {
            document.querySelector('pjse-message').innerHTML = text.replaceAll(">", "&gt;").replaceAll("<", "&lt;").replaceAll("\n", "<br>")
        } else {
            document.querySelector('pjse-message').innerHTML = "<?= $lang["header"]["pjseDefault"][1] ?>"
        }
        $("pjse-placeholder").fadeIn(200)
        document.querySelector('body').childNodes.forEach((el) => {
            if (typeof el.classList != "undefined") {
                if (el.localName != "pjse-placeholder") {
                    el.classList.add("pjse-blurry")
                }
            }
        })
    } catch (err) {
        alert("<?= $lang["header"]["errorError"] ?>");
    }
}

function alert(text, refreshOnOk) {
    if (typeof refreshOnOk == "boolean") {
        if (refreshOnOk == true) {
            console.warn("The refresh on OK feature isn't available on new errors, showing the legacy one");
            alert_full(text, refreshOnOk)
            return;
        }
    }
    var x = document.getElementById("snackbar");

    if (typeof text == "string") {
        x.innerHTML = text.replaceAll(">", "&gt;").replaceAll("<", "&lt;").replaceAll("\n", "<br>");
    } else {
        x.innerHTML = "<?= $lang["header"]["snackbarDefault"] ?>";
    }

    x.className = "snackbar_show";

    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
}

function closeError() {
    $("pjse-placeholder").fadeOut(200)
    document.querySelector('body').childNodes.forEach((el) => {
        if (typeof el.classList != "undefined") {
            if (el.localName != "pjse-placeholder") {
                el.classList.remove("pjse-blurry")
            }
        }
    })
    if (roo_alert) {
        reloadPage()
    }
}

</script>
<!-- END of Minteck Projects CMS Header file -->