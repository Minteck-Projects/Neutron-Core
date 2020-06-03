<?php include $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php" ?>

<?php

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
        echo("<script>console.log('{$_SERVER['REMOTE_ADDR']}: {$ipb_args[0]} requests this minute.");
        if ($ipb_args[0] >= 10) {
            echo(" Next request will be tempban.");
        }
        echo("')</script>");
    } else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList/" . $ip, "1|" . date('YmdHi'));
        echo("<script>console.log('{$_SERVER['REMOTE_ADDR']}: 1 requests this minute.')</script>");
    }
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache")) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache");
}

?>

<?php

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
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps")) {
        $bans = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps");
        $banscount = 0;
        foreach ($bans as $ban) {
            if ($ban != "." && $ban != "..") {
                if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps/" . $ban) == date('Ymd')) {
                    $banscount = $banscount + 1;
                }
            }
        }
        if ($banscount >= 5) {
            ob_end_clean();
            header("HTTP/1.1 503 Service Unavailable");
            die("<title>503 Service Unavailable</title><center><h1>503 Service Unavailable</h1><hr>{$_SERVER['SERVER_SIGNATURE']}</center>");
        }
    }

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

function dataValid($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
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


if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/styles.json")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/styles.json", "[]");
}

?>
<link rel="stylesheet" href="/resources/upload/styles.css">
<script src="/resources/js/jquery.js"></script>

<?php

//
// Tout le code inséré ici affectera TOUTES LES PAGES du site, incluant les pages d'administration
//

function errors($level, $description, $file, $line) {
    global $lang;
    if ($level == E_USER_ERROR) {
	if (strpos($description, "filesize()") === false) {
	    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/ERROR - " . $file . ":" . $line . " - " . $description . "\n\n");
            } else {
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/ERROR - " . $file . ":" . $line . " - " . $description . "\n\n");
            }
        }
    }
    if ($level == E_USER_WARNING) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/WARNING - " . $file . ":" . $line . " - " . $description . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/WARNING - " . $file . ":" . $line . " - " . $description . "\n\n");
        }
    }
    if ($level == E_USER_NOTICE) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/NOTICE - " . $file . ":" . $line . " - " . $description . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/NOTICE - " . $file . ":" . $line . " - " . $description . "\n\n");
        }
    }
    if ($level != E_USER_NOTICE && $level != E_USER_ERROR && $level != E_USER_WARNING) {
        if (strpos($description, "filesize()") === false) {
	    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/UNKNOWN - " . $file . ":" . $line . " - " . $description . "\n\n");
            } else {
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/UNKNOWN - " . $file . ":" . $line . " - " . $description . "\n\n");
            }
        }
    }
    if (strpos($description, "filesize()") === false) {
        echo('<p><table class="message_error"><tbody><tr><td><img src="/resources/image/message_error.svg" class="message_img"></td><td style="width:100%;"><p>' . $lang["header"]["phpError"][0] . '</p><p>' . $lang["header"]["phpError"][1] . ' <b>PHP-INTERNAL-ERROR/</b></p><p>' . $lang["header"]["phpError"][2] . '</p></td></tr></tbody></table></p>');
    }
    return true;
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    set_error_handler("errors");
} else {
    return;
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
    if (strpos($_SERVER['HTTP_USER_AGENT'], "MinteckProjectsAutoUptime") !== false) {} else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - INTERFACE/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
} else {
    if (strpos($_SERVER['HTTP_USER_AGENT'], "MinteckProjectsAutoUptime") !== false) {} else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - INTERFACE/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
}

try {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats")) {} else {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/")) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats");
        }
    }

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/")) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d"))) {
            if (strpos($_SERVER['HTTP_USER_AGENT'], "MinteckProjectsAutoUptime") !== false) {} else {
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

// file_get_contents("unexistingfile");

?>

<div id="snowapi-placeholder"><div snowapi-enable-snowfall></div></div>
<?= "<script>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/global.js") . "</script>" ?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/classic-enabled")) {
    echo('<script src="/resources/themes/icons/classic.js"></script>');
}

?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntufont-enabled")) {
    echo('<link rel="stylesheet" href="/resources/themes/fonts/ubuntu.css">');
}

?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntulfont-enabled")) {
    echo('<link rel="stylesheet" href="/resources/themes/fonts/ubuntu-light.css">');
}

?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/darktheme-enabled")) {
    echo('<link rel="stylesheet" href="/resources/themes/colors/dark.css">');
    echo('<script src="/resources/themes/colors/dark.js"></script>');
}

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

<div id="snackbar"><?= $lang["header"]["snackbarDefault"] ?></div>

<script>

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

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
