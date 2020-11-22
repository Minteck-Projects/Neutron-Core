<?php

global $_FNSN_DUMP_STARTDATE;
$_FNSN_DUMP_STARTDATE = new DateTime("now");

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

// This will run only if the website is ready
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    // Custom settings parser
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json")) {
        if (dataValid(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json"))) {
            $customSettings = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json"));
            if (isset($customSettings->AfficherBoutonAdministration) && isset($customSettings->AdministrationBarreNavigation) && isset($customSettings->RessourcesPersonnalisées) && isset($customSettings->RessourcesPersonnalisées->CSS) && isset($customSettings->RessourcesPersonnalisées->JS) && isset($customSettings->PagesMasquées)) { // If it's using the old system, delete the file and generate a new one.
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json.bak", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json"));
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/headers/csettings-base.json"));
                $continue = true;
            } else {
                $continue = true;
            }
            if ($continue) {
                if (isset($customSettings->showAdminButton) && isset($customSettings->customResources) && isset($customSettings->customResources->styles) && isset($customSettings->customResources->script) && isset($customSettings->hiddenPages)) {
                    if (!$customSettings->showAdminButton) {
                        echo("<style>#siteadmin-button{display:none;}</style>");
                    }
                    echo("<style type=\"text/css\">" . $customSettings->customResources->styles . "</style>");
                    echo("<script type=\"text/javascript\">" . $customSettings->customResources->script . "</script>");
                } else {
                    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("<h1>" . $lang["header"]["internalError"][0] . "</h1><p>" . $lang["header"]["internalError"][1] . "</p><p>" . $lang["header"]["internalError"][2] . "<code>/data/webcontent/customSettings.json</code>" . $lang["header"]["internalError"][3] . "</p><hr><i> " . str_replace("#", substr(md5(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")), 0, 2), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")) . " " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/codename") . "</i>");
                }
            }
        } else {
            require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("<h1>" . $lang["header"]["internalError"][0] . "</h1><p>" . $lang["header"]["internalError"][4] . "</p><p>" . $lang["header"]["internalError"][2] . "<code>/data/webcontent/customSettings.json</code>" . $lang["header"]["internalError"][3] . "</p><hr><i> " . str_replace("#", substr(md5(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")), 0, 2), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")) . " " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/codename") . "</i>");
        }
    } else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/headers/csettings-base.json"));
    }
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/styles.css")) {
    echo('<link rel="stylesheet" href="/resources/upload/styles.css">'); // Custom styles loader
}
echo('<script src="/resources/js/jquery.js"></script>'); // JQuery, used at almost all pages

echo("<script>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/global.js") . "</script>"); // Global Scripts

?>

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
