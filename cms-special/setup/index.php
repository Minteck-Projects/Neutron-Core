<?php ob_start();echo("<!--\n\n" . str_replace('%year%', date('Y'), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license")) . "\n\n-->") ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/api/lang/setup.php"; ?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    $ready = true;
} else {
    $ready = false;
}

?>

<!DOCTYPE html>
<html lang="<?= $langsel ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/resources/css/setup.css">
    <link rel="stylesheet" href="/resources/css/fonts-import.css">
    <link rel="stylesheet" href="/resources/css/ui.css">
    <title><?php

    if ($ready) {
        if (!isset($lang)) {
            echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
        } else {
            echo($lang["setup"]["ititle"] . " - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
        }
    } else {
        if (!isset($lang)) {
            echo("Minteck Projects CMS");
        } else {
            echo($lang["setup"]["ititle"] . " - Minteck Projects CMS");
        }
    }

    ?></title>
</head>
<body>
    <?php

    if ($ready) {
        // If the website is ready, render the headers and stop here
        die("<script>location.href = '/';</script></body></html>");
    }

    ?>
    <?= $nolang ? "" : '<script>
    window.onbeforeunload = function (e) {
    e = e || window.event;

    // For IE and Firefox prior to version 4
    if (e) {
        e.returnValue = "<!>";
    }

        // For Safari
        return "<!>";
    };
    </script>' ?>
    <script src="/resources/js/jquery.js"></script>
    <div class="centered box hide" id="00-error">
        <h2 id="00-error-title"><?= $lang['setup']['defaulterr'][0] ?></h2>
        <span id="00-error-message"><?= $lang['setup']['defaulterr'][1] ?></span><br><br>
        <img src="/resources/image/config_restart.svg" onclick="reloadPage()" class="icon_button"><br><small><?= $lang['setup']['defaulterr'][2] ?></small>
    </div>
    <div class="centered box<?= $nolang ? "" : " hide" ?>" id="00-language">
        <h2>Minteck Projects CMS</h2>
        <p>
        <select id="00-language-select">
            <?php

            $langs = scandir($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n");
            foreach ($langs as $language) {
                if ($language != "." && $language != ".." && $language != ".htaccess") {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n/" . $language . "/\$metadata.json")) {
                        echo("<option value=\"" . $language . "\">");
                        echo(json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n/" . $language . "/\$metadata.json"))->localized_name . " — " . json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n/" . $language . "/\$metadata.json"))->name);
                        echo("</option>");
                    }
                }
            }

            ?>
        </select>
        </p>
        <input type="button" value="OK" onclick="location.href = '?lang=' + document.getElementById('00-language-select').value">
    </div>
    <div class="centered box<?= $nolang ? " hide" : "" ?>" id="01-loader">
        <h2><?= $lang['setup']['sections'][0] ?></h2>
        <img src="/resources/image/storeloader.svg" class="loader">
    </div>
    <div class="centered box hide" id="02-check">
        <h2><?= $lang['setup']['sections'][1] ?></h2>
        <img src="/resources/image/storeloader.svg" class="loader">
    </div>
    <div class="centered box hide" id="03-welcome">
        <h2><?= $lang['setup']['sections'][2] ?></h2>
        <p><?= $lang['setup']['welcome'][0] ?></p>
        <p><?= $lang['setup']['welcome'][1] ?></p>
        <p><?= $lang['setup']['welcome'][2] ?></p>
        <img src="/resources/image/config_next.svg" onclick="document.title = '<?= $lang["setup"]["steps"][7] . " - " . $lang["setup"]["ititle"] ?> - Minteck Projects CMS';switchPage('03-welcome', '04-name');" class="icon_button"><br><small><?= $lang['setup']['links'][4] ?></small>
    </div>
    <div class="centered box hide" id="04-name">
        <h2><?= $lang['setup']['sections'][3] ?></h2>
        <p><?= $lang['setup']['name'][0] ?></p>
        <p><?= $lang['setup']['name'][1] ?></p>
        <input id="04-name-field" type="text" onchange="validateName()" onkeyup="validateName()" onkeydown="validateName()" placeholder="Nom de votre site"><br><p id="04-name-tip" class="tip-red"><?= $lang['setup']['sitename'][0] ?></p>
        <img src="/resources/image/config_next.svg" onclick="Name_ChangeIfOk()" class="icon_button"><br><small><?= $lang['setup']['links'][3] ?></small>
    </div>
    <div class="centered box hide" id="05-icon">
        <h2><?= $lang['setup']['sections'][4] ?></h2>
        <p><?= $lang['setup']['logo'][0] ?></p>
        <p><?= $lang['setup']['logo'][1] ?></p>
        <input id="05-icon-file" type="file" onchange="Icon_Validate()" style="display:none;width:0;height:0;left:0;top:0;"><img id="05-icon-img" src="/resources/image/config_file_import.svg" onclick="Icon_UploadFile()" class="icon_button"><br><small><?= $lang['setup']['logo'][2] ?></small><br><br>
        <img src="/resources/image/config_next.svg" onclick="document.title = '<?= $lang["setup"]["steps"][8] . " - " . $lang["setup"]["ititle"] ?> - Minteck Projects CMS';switchPage('05-icon', '06-terms');" class="icon_button"><br><small><?= $lang['setup']['links'][3] ?></small>
    </div>
    <div class="centered box hide" id="06-terms">
        <h2><?= $lang['setup']['sections'][5] ?></h2>
        <p><?= $lang['setup']['license'] ?></p>
        <iframe class="termsbox" src="/resources/lib/license.html" style="width:100%;"></iframe><br><br>
        <img src="/resources/image/config_next.svg" onclick="document.title = '<?= $lang["setup"]["steps"][9] . " - " . $lang["setup"]["ititle"] ?> - Minteck Projects CMS';switchPage('06-terms', '07-finish');" class="icon_button"><br><small><?= $lang['setup']['links'][2] ?></small>
    </div>
    <div class="centered box hide" id="07-finish">
        <h2><?= $lang['setup']['sections'][6] ?></h2>
        <p><?= $lang['setup']['confirm'][0] ?></p>
        <p><?= $lang['setup']['confirm'][1] ?></p>
        <img src="/resources/image/config_finish.svg" onclick="upload()" class="icon_button"><br><small><?= $lang['setup']['links'][1] ?></small>
    </div>
    <div class="centered box hide" id="08-checking">
        <h2><?= $lang['setup']['upload'][0] ?></h2>
        <img src="/resources/image/storeloader.svg" class="finisher loadblink"><br><br><small><?= $lang['setup']['warning'][0] ?><br><?= $lang['setup']['warning'][1] ?></small>
    </div>
    <div class="centered box hide" id="09-uploading">
        <h2><?= $lang['setup']['upload'][1] ?></h2>
        <img src="/resources/image/storeloader.svg" class="finisher loadblink"><br><br><small><?= $lang['setup']['warning'][0] ?><br><?= $lang['setup']['warning'][1] ?></small>
    </div>
    <div class="centered box hide" id="10-summing">
        <h2><?= $lang['setup']['upload'][2] ?></h2>
        <img src="/resources/image/storeloader.svg" class="finisher loadblink"><br><br><small><?= $lang['setup']['warning'][0] ?><br><?= $lang['setup']['warning'][1] ?></small>
    </div>
    <div class="centered box hide" id="11-performance">
        <h2><?= $lang['setup']['upload'][3] ?></h2>
        <img src="/resources/image/storeloader.svg" class="finisher loadblink"><br><br><small><?= $lang['setup']['warning'][0] ?><br><?= $lang['setup']['warning'][1] ?></small>
    </div>
    <div class="centered box hide" id="12-done">
        <h2><?= $lang['setup']['done'][0] ?></h2>
        <p><?= $lang['setup']['done'][1] ?></p>
        <p><?= $lang['setup']['done'][2] ?> <b>MPCMS-usr-motdepasse</b><?= $lang['setup']['done'][3] ?></p>
        <img src="/resources/image/config_explore.svg" onclick="location.href = '/'" class="icon_button"><br><small><?= $lang['setup']['links'][0] ?></small>
    </div>
    <?= $nolang ? "" : '<script src="/resources/js/setup-ui.js.php?lang=' . $langsel . '"></script>' ?>
</body>
</html>