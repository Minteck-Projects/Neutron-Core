<?php ob_start();echo("<!--\n\n" . str_replace('%year%', date('Y'), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license")) . "\n\n-->") ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php"; ?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    $ready = true;
} else {
    $ready = false;
}

$nolang = false;

require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/headers/preprocessor.php";

if (isset($_COOKIE['ADMIN_TOKEN']) && $_COOKIE['ADMIN_TOKEN'] != "." && $_COOKIE['ADMIN_TOKEN'] != ".." && $_COOKIE['ADMIN_TOKEN'] != "/") {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("<script>location.href = '/cms-special/admin/?pr=" . str_replace("/index.php", "", $_SERVER['SCRIPT_NAME']) . "&pa=" . urlencode("?" . explode("?", $_SERVER['REQUEST_URI'])[1]) . "'</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/?pr=" . str_replace("/index.php", "", $_SERVER['SCRIPT_NAME']) . "&pa=" . urlencode("?" . explode("?", $_SERVER['REQUEST_URI'])[1]) . "'</script>");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/resources/css/fonts-import.css">
    <link rel="stylesheet" href="/resources/css/ui.css">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/headers/documenthead.php"; ?>

    <?php
        if (!$ready) {
            die("<script>location.href = '/cms-special/setup';</script></head>");
        }
    ?>
    <title><?php

    if ($ready) {
        if (!isset($lang)) {
            echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
        } else {
            echo($lang["ota"]["ititle"] . " - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
        }
    } else {
        if (!isset($lang)) {
            echo("Minteck Projects CMS");
        } else {
            echo($lang["ota"]["ititle"] . " - Minteck Projects CMS");
        }
    }

    ?></title>
</head>
<body>
    <?php

    ?>
    <?= $nolang ? "" : '<script>
    // window.onbeforeunload = function (e) {
    // e = e || window.event;

    // // For IE and Firefox prior to version 4
    // if (e) {
    //     e.returnValue = "<!>";
    // }

    //     // For Safari
    //     return "<!>";
    // };
    </script>' ?>
    <script src="/resources/js/jquery.js"></script>
    <div class="centered box hide" id="00-error">
        <h2 id="00-error-title"><?= $lang['setup']['defaulterr'][0] ?></h2>
        <span id="00-error-message"><?= $lang['setup']['defaulterr'][1] ?></span><br><br>
        <img src="/resources/image/config_restart.svg" onclick="reloadPage()" class="icon_button"><br><small><?= $lang['ota']['restart'] ?></small>
    </div>
    <div class="centered box hide" id="00-uptodate">
        <h2><?= $lang['ota']['uptodate'][0] ?></h2>
        <span><?= $lang['ota']['uptodate'][1] ?></span><br><br>
        <img src="/resources/image/config_restart.svg" onclick="location.href='/cms-special/admin/home';" class="icon_button"><br><small><?= $lang['ota']['uptodate'][2] ?></small>
    </div>
    <div class="centered box" id="02-loader">
        <h2><?= $lang['ota']['sections'][1] ?></h2>
        <img src="/resources/image/storeloader.svg" class="loader">
    </div>
    <div class="centered box hide" id="03-welcome">
        <h2><?= $lang['ota']['sections'][2] ?></h2>
        <p><?= $lang['ota']['welcome'][0] ?></p>
        <p><?= $lang['ota']['welcome'][1] ?></p>
        <p><?= $lang['ota']['welcome'][2] ?></p>
        <p><?= $lang['ota']['welcome'][3] ?></p>
        <img src="/resources/image/config_next.svg" onclick="document.title = '<?= $lang["ota"]["steps"][3] . " - " . $lang["ota"]["ititle"] ?> - Minteck Projects CMS';switchPage('03-welcome', '04-search');checkForUpdates();" class="icon_button"><br><small><?= $lang['setup']['links'][4] ?></small>
    </div>
    <div class="centered box hide" id="04-search">
        <h2><?= $lang['ota']['sections'][3] ?></h2>
        <img src="/resources/image/storeloader.svg" class="loader"><br>
        <p><small>
        <?= $lang["ota"]["finfo"]->version ?><?= explode("-", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version"))[0]; ?><br>
        <?= $lang["ota"]["finfo"]->server ?><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/update"); ?>
        </small></p>
        <p><span class="update-cancel" onclick="location.href='/cms-special/admin/home';"><?= $lang['ota']['cancel'][0] ?></span></p>
    </div>
    <div class="centered box hide" id="05-updates">
        <h2><?= $lang['ota']['sections'][4] ?></h2>
        <p id="updates-list"></p>
        <small style="color:orange;"><?= $lang['ota']['price'][0] ?><span id="updates-ttsize">0</span><?= $lang['ota']['price'][1] ?></small><br>
        <img src="/resources/image/config_next.svg" onclick="document.title = '<?= $lang["ota"]["steps"][5] . " - " . $lang["ota"]["ititle"] ?> - Minteck Projects CMS';switchPage('05-updates', '06-install');installUpdates()" class="icon_button"><br><small><?= $lang['ota']['install'] ?></small>
    </div>
    <div class="centered box hide" id="06-install">
        <h2><?= $lang['ota']['installing'] ?></h2>
        <img src="/resources/image/storeloader.svg" class="finisher loadblink"><br><br><small><?= $lang['ota']['warning'] ?></small>
    </div>
    <div class="centered box hide" id="07-done">
    <h2><?= $lang['ota']['done'][0] ?></h2>
        <p><?= $lang['ota']['done'][1] ?></p>
        <p><?= $lang['ota']['done'][2] ?></p>
        <img src="/resources/image/config_explore.svg" onclick="location.href = '/'" class="icon_button"><br><small><?= $lang['ota']['finish'] ?></small>
    </div>
    <?= $nolang ? "" : '<script src="/resources/js/ota-ui.js.php?lang=' . $langsel . '"></script>' ?>

    <link rel="stylesheet" href="/resources/css/setup.css">
</body>
</html>