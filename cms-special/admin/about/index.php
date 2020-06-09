<?php $pageConfig = [ "domName" => "Mise à jour et sécurité", "headerName" => "Mise à jour et sécurité" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <?php

        $currentVersionP = str_replace("#", substr(md5(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")), 0, 2), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version"));
        $channel = explode("-", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version"))[2];
        $currentVersion = explode("-", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version"))[0];
        $currentVersionS = $currentVersion;
        if (explode('|', trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/experimental")))[0] == "1") {
            $currentVersion = explode('|', trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/experimental")))[1];
        }
        $latestVersion = trim(file_get_contents("https://gitlab.com/minteck-projects/mpcms/changelog/raw/master/latest_version"));
        $latestVersionP = str_replace("#", substr(md5($latestVersion . "-#-" . $channel), 0, 2), $latestVersion . "-#-" . $channel);
        $returned = false;

        if (version_compare($currentVersion, $latestVersion) >= 1 || explode('|', trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/experimental")))[0] == "1") {
            echo("<div id=\"protect\" class=\"s1\"><b>" . $lang['admin-about']['updates']->beta[0] . "</b><br>" . $lang['admin-about']['updates']->beta[1] . "</div>");
            $returned = true;
        }

        if (!$returned) {
            if (!strpos($currentVersion, 'LTS') !== false) {
                if (version_compare($currentVersion, $latestVersion) <= -1) {
                    echo("<div id=\"protect\" class=\"s0\"><b>" . $lang['admin-about']['updates']->newversion[0] . "</b><br>" . $lang['admin-about']['updates']->newversion[1] . "</div>");
                }
            } else {
                if (implode("", explode(".", explode(" ", $latestVersion)[0])) - implode("", explode(".", explode(" ", $currentVersion)[0])) >= 3) {
                    echo("<div id=\"protect\" class=\"s0\"><b>" . $lang['admin-about']['updates']->ltsend[0] . "</b><br>" . $lang['admin-about']['updates']->ltsend[1] . "</div>");
                } else {
                    if (version_compare($currentVersion, $latestVersion) <= -1) {
                        echo("<div id=\"protect\" class=\"s2\"><b>" . $lang['admin-about']['updates']->ltsnew[0] . "</b><br>" . $lang['admin-about']['updates']->ltsnew[1] . "</div><br>");
                    } else {
                        echo("<div id=\"protect\" class=\"s2\"><b>" . $lang['admin-about']['updates']->ltsuptodate[0] . "</b><br>" . $lang['admin-about']['updates']->ltsuptodate[1] . "</div><br>");
                        $returned = true;
                    }
                }
            }
        }

        if (version_compare($currentVersion, $latestVersion) == 0 && !$returned) {
            echo("<div id=\"protect\" class=\"s2\"><b>" . $lang['admin-about']['updates']->uptodate[0] . "</b><br>" . $lang['admin-about']['updates']->uptodate[1] . "</div><br>");
        }

        ?>
    <h3><?= $lang["admin-about"]["info"] ?></h3>
    <ul><li>
    <?php

    if (version_compare($currentVersion, $latestVersion) == 0) {
        echo("" . $lang['admin-about']['version']->prefix . " <b>" . $currentVersionP . "</b>");
    } else {
        if (version_compare($currentVersion, $latestVersion) <= -1) {
            echo("" . $lang['admin-about']['version']->prefix . " <b>" . $currentVersionP . "</b>" . $lang['admin-about']['version']->update . " <b>" . $latestVersionP . "</b>");
        } else {
            echo("" . $lang['admin-about']['version']->prefix . " <b>" . $currentVersionP . "</b>" . $lang['admin-about']['version']->beta . " <b>" . $latestVersionP . "</b>");
        }
    }
    echo("</li>");

    if (version_compare($currentVersion, $latestVersion) >= 1 || explode('|', trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/experimental")))[0] == "1") {
        $upchan = "dev";
    } else {
        if (!strpos($currentVersion, 'LTS') !== false) {
            $upchan = "esr";
        } else {
            $upchan = "stable";
        }
    }

    echo("<li>" . $lang['admin-about']['version']->channel . " <b>" . $upchan . "</b>" . "</li>");
    echo("<li><a href='/cms-special/admin/distrib'>" . $lang['admin-about']['version']->distrib . "</a></li>");

    $size = 0;
    getData($_SERVER['DOCUMENT_ROOT']);
    $sizestr = $size . " " . $lang["sizes"]["bytes"] . "";
    if ($size > 1024) {
        if ($size > 1048576) {
            if ($size > 1073741824) {
                $sizestr = round($size / 1073741824, 3) . " " . $lang["sizes"]["gibibytes"] . "";
            } else {
                $sizestr = round($size / 1048576, 3) . " " . $lang["sizes"]["mebibytes"] . "";
            }
        } else {
            $sizestr = round($size / 1024, 3) . " " . $lang["sizes"]["kibibytes"] . "";
        }
    } else {
        $sizestr = $size . " " . $lang["sizes"]["bytes"] . "";
    }

    $sizestr = str_replace(".", ",", $sizestr);

    echo("<li>" . $lang["admin-about"]["diskspace"][0] . " <b>" . $sizestr . "</b> " . $lang["admin-about"]["diskspace"][1] . "</li>");

    ?>
    </ul>
    <h3><?= $lang["admin-about"]["disk"] ?></h3>
    <meter id="storagebar" value="0" max="1"></meter>
    <span style="margin-left: 10px;"></span>
    <?php

    $globalSize = $size;

    $size = 0;
    getData($_SERVER['DOCUMENT_ROOT'] . "/api");
    $mpcmsSize = $size;
    getData($_SERVER['DOCUMENT_ROOT'] . "/cms-special");
    $mpcmsSize = $mpcmsSize + $size;
    getData($_SERVER['DOCUMENT_ROOT'] . "/widgets");
    $mpcmsSize = $mpcmsSize + $size;

    $size = 0;
    getData($_SERVER['DOCUMENT_ROOT'] . "/data");
    $dataSize = $size;

    $calSize = filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json");
    $confSize = filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json") + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/password") + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/footer");
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-notes-data")) {
        $confSize = $confSize + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-notes-data");
    }
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-contact-data")) {
        $confSize = $confSize + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-contact-data");
    }

    $size = 0;
    getData($_SERVER['DOCUMENT_ROOT'] . "/resources");
    $resSize = $size;

    ?>
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;">
    <span><span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:#8bcf69;position:relative;width:15px;height:15px;display:inline-block;"></span><span style="margin-right:30px;"><?= $lang["admin-about"]["categories"]->system ?> (<?= round(($mpcmsSize*100)/$globalSize, 2) ?>%)</span></span>
    <span><span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:#e6d450;position:relative;width:15px;height:15px;display:inline-block;"></span><span style="margin-right:30px;"><?= $lang["admin-about"]["categories"]->config ?> (<?= round(($dataSize*100)/$globalSize, 2) ?>%)</span></span>
    <span><span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:#cf82bf;position:relative;width:15px;height:15px;display:inline-block;"></span><span style="margin-right:30px;"><?= $lang["admin-about"]["categories"]->resources ?> (<?= round(($resSize*100)/$globalSize, 2) ?>%)</span></span>
    <span><span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:gray;position:relative;width:15px;height:15px;display:inline-block;"></span><span style="margin-right:30px;"><?= $lang["admin-about"]["categories"]->misc ?></span></span>
    </div>
    <!-- <?= $globalSize - ($mpcmsSize + $dataSize + $resSize) ?>
    <?= "<br>" ?>
    <?= (($mpcmsSize + $dataSize + $resSize) * 100)/$globalSize ?> -->
    <style>
        #storagebar {
            width: 100%; /* To support legacy browsers */
            width: calc(100% - 16px);
            margin: 8px;
            border-radius: 5px;
            box-shadow: 0 5px 5px -5px #999 inset;
            background-image: linear-gradient(
                90deg,
                #8bcf69 <?= round(($mpcmsSize*100)/$globalSize, 2) ?>%,
                #e6d450 <?= round(($mpcmsSize*100)/$globalSize, 2) ?>%,
                #e6d450 <?= round(($dataSize*100)/$globalSize, 2) ?>%,
                #cf82bf <?= round(($dataSize*100)/$globalSize, 2) ?>%,
                #cf82bf <?= round(($resSize*100)/$globalSize, 2) ?>%,
                gray <?= round(($resSize*100)/$globalSize, 2) ?>%,
                gray 100%
            );
            background-size: 100% 100%;
        }
    </style>
    <h3><?= $lang["admin-about"]["changes"] ?></h3>
    <h4><?= $lang["admin-about"]["current"] ?> (<?= $currentVersionS ?>)</h4>
    <?php

    if (!startsWith(file_get_contents("https://gitlab.com/minteck-projects/mpcms/changelog/raw/master/changelog/" . str_replace(" ", "%20", $currentVersion),false,stream_context_create(['http' => ['ignore_errors' => true,],])), "<!DOCTYPE")) {
        echo(file_get_contents("https://gitlab.com/minteck-projects/mpcms/changelog/raw/master/changelog/" . str_replace(" ", "%20", $currentVersion),false,stream_context_create(['http' => ['ignore_errors' => true,],])));
    } else {
        echo("<i>" . $lang["admin-about"]["nolog"] . "</i>");
    }

    ?>
    <?php

    if (version_compare($currentVersion, $latestVersion) == 0) {
    } else {
        if (version_compare($currentVersion, $latestVersion) <= -1) {
            echo("<h4>" . $lang["admin-about"]["stable"] . " (" . $latestVersion . ")</h4>");
        } else {
            echo("<h4>" . $lang["admin-about"]["beta"] . " (" . $latestVersion . ")</h4>");
        }
        if (!startsWith(file_get_contents("https://gitlab.com/minteck-projects/mpcms/changelog/raw/master/changelog/" . str_replace(" ", "%20", $latestVersion),false,stream_context_create(['http' => ['ignore_errors' => true,],])), "<!DOCTYPE")) {
            echo(file_get_contents("https://gitlab.com/minteck-projects/mpcms/changelog/raw/master/changelog/" . str_replace(" ", "%20", $latestVersion),false,stream_context_create(['http' => ['ignore_errors' => true,],])));
        } else {
            echo("<i>" . $lang["admin-about"]["nolog"] . "</i>");
        }
    }

    ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>
