<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php"; ?>
<?php

if (isset($_COOKIE['ADMIN_TOKEN']) && $_COOKIE['ADMIN_TOKEN'] != "." && $_COOKIE['ADMIN_TOKEN'] != ".." && $_COOKIE['ADMIN_TOKEN'] != "/") {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/advanced/regedit&pa='</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/advanced/regedit&pa='</script>");
}

if (isset($_GET['key'])) {
    $key = $_GET['key'];
    if ($key == "HKWC") {
        $keyfull = "HKEY_WEBSITE_CONTENT";
        $root = $_SERVER['DOCUMENT_ROOT'] . "/data/webcontent";
    }
    if ($key == "HKST") {
        $keyfull = "HKEY_SESSION_TOKENS";
        $root = $_SERVER['DOCUMENT_ROOT'] . "/data/tokens";
    }
    if ($key == "HKUR") {
        $keyfull = "HKEY_UPLOADS_ROOT";
        $root = $_SERVER['DOCUMENT_ROOT'] . "/resources/upload";
    }
    if (!isset($keyfull)) {
        die("<script>location.href = '/cms-special/admin/regedit'</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/regedit'</script>");
}

if (isset($_GET['path'])) {
    $path = $_GET['path'];
} else {
    $path = "";
}

if ($path == "/") {
    $path = "";
}

$types = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n/" . $langsel . "/filetypes.json"));

function getDescription($fileuri) {
    global $types;
    global $path;
    if ($path == "/") {
        $newpath = "";
    } else {
        $newpath = $path;
    }
    $tarray = (array)$types;
    if (substr($fileuri, 0, 9) == "semantic_") {
        return $types->_semantic;
    } else {
        if (isset($tarray[$newpath . "/" . $fileuri])) {
            return $tarray[$newpath . "/" . $fileuri];
        } else {
            return $types->_unknown;
        }
    }
}

function startsWith ($string, $startString) {
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

function endsWith($string, $endString) {
    $len = strlen($endString);
    if ($len == 0) {
        return true;
    }
    return (substr($string, -$len) === $endString);
}

function includes($string, $substring) {
    if (strpos($string, $substring) !== false) {
        return true;
    } else {
        return false;
    };
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $lang["admin-advanced-regedit"]["win"] ?></title>
    <link rel="stylesheet" href="/resources/css/regedit.css">
</head>
<body>
    <h1><?= $lang["admin-advanced-regedit"]["title"] ?></h1>
    <h3>/<?= $keyfull ?><?= $path ?></h3>
    <?php

    echo("<small>");

    if ($path == "") {
        echo('<a href="/cms-special/admin/advanced/regedit">Dossier parent</a>');
    } else {
        echo('<a href="/cms-special/admin/advanced/regedit/view/?key=' . $key . '&path='. dirname($path) . '">' . $lang["admin-advanced-regedit"]["parent"] . '</a>');
    }

    if (!is_dir($root . $path)) {
        if (startsWith($path, "/pages")) {
            echo(" | <a href=\"/cms-special/admin/pages/edit/?slug=" . basename($path) . "\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/caldb.json")) {
            echo(" | <a href=\"/cms-special/admin/calendar\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/widgets.json")) {
            echo(" | <a href=\"/cms-special/admin/plugins\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/galery")) {
            echo(" | <a href=\"/cms-special/admin/galery\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/footer")) {
            echo(" | <a href=\"/cms-special/admin/appearance\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/sitename")) {
            echo(" | <a href=\"/cms-special/admin/appearance\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/darktheme-enabled")) {
            echo(" | <a href=\"/cms-special/admin/customization\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/ubuntufont-enabled")) {
            echo(" | <a href=\"/cms-special/admin/customization\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/ubuntulfont-enabled")) {
            echo(" | <a href=\"/cms-special/admin/customization\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/suru-enabled")) {
            echo(" | <a href=\"/cms-special/admin/customization\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/classic-enabled")) {
            echo(" | <a href=\"/cms-special/admin/customization\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/customSettings.json")) {
            echo(" | <a href=\"/cms-special/admin/advanced/jsonconf\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/password")) {
            echo(" | <a href=\"/cms-special/admin/appearance\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/store")) {
            echo(" | <a href=\"/cms-special/admin/store\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/semantic_")) {
            echo(" | <a href=\"/cms-special/admin/semantic\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/system.log")) {
            echo(" | <a href=\"/cms-special/admin/logs\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/widget-notes-data")) {
            echo(" | <a href=\"/cms-special/admin/plugins/widget-notes-configure\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/widget-contact-data")) {
            echo(" | <a href=\"/cms-special/admin/plugins/widget-contact-configure\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/stats")) {
            echo(" | <a href=\"/cms-special/admin/stats\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/picdb.json")) {
            echo(" | <a href=\"/cms-special/admin/galery\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
        if (startsWith($path, "/calendar_events")) {
            echo(" | <a href=\"/cms-special/admin/calendar\">" . $lang["admin-advanced-regedit"]["edit"] . "</a>");
        }
    }

    echo("</small><br>");

    if (is_dir($root . $path)) {
        foreach (scandir($root . $path) as $file) {
            if ($file != "." && $file != "..") {
                if ($key == "HKWC") {
                    if (is_dir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent" . $path . "/" . $file)) {
                        echo('<img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/folder.svg"><a href="/cms-special/admin/advanced/regedit/view/?key=' . $key . '&path=' . $path . "/" . $file . '">' . $file . '</a> <i>(' . getDescription($file) . ')</i><br>');
                    } else {
                        if (substr($file, -5) == ".json") {
                            echo('<img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/json.svg"><a href="/cms-special/admin/advanced/regedit/view/?key=' . $key . '&path=' . $path . "/" . $file . '">' . $file . '</a> <i>(' . getDescription($file) . ')</i><br>');
                        } else {
                            if ($path == "/pages") {
                                echo('<img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/page.svg"><a href="/cms-special/admin/advanced/regedit/view/?key=' . $key . '&path=' . $path . "/" . $file . '">' . $file . '</a> <i>(' . $types->_page . ')</i><br>');
                            } else {
                                if ($path == "/pagetypes") {
                                    echo('<img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/data.svg"><a href="/cms-special/admin/advanced/regedit/view/?key=' . $key . '&path=' . $path . "/" . $file . '">' . $file . '</a> <i>(' . $types->_pagetype . ')</i><br>');
                                } else {
                                    if ($path == "/galery/categories") {
                                        echo('<img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/data.svg"><a href="/cms-special/admin/advanced/regedit/view/?key=' . $key . '&path=' . $path . "/" . $file . '">' . $file . '</a> <i>(' . $types->_galery_cat . ')</i><br>');
                                    } else {
                                        if ($path == "/galery/pictures") {
                                            echo('<img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/image.svg"><a href="/cms-special/admin/advanced/regedit/view/?key=' . $key . '&path=' . $path . "/" . $file . '">' . $file . '</a> <i>(' . $types->_galery_pic . ')</i><br>');
                                        } else {
                                            echo('<img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/data.svg"><a href="/cms-special/admin/advanced/regedit/view/?key=' . $key . '&path=' . $path . "/" . $file . '">' . $file . '</a> <i>(' . getDescription($file) . ')</i><br>');
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($key == "HKST") {
                        echo('<img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/token.svg"><a href="/cms-special/admin/advanced/regedit/view/?key=' . $key . '&path=' . $path . "/" . $file . '">' . $file . '</a> <i>(' . $lang["admin-advanced-regedit"]["token"] . ')</i><br>');
                    } else {
                        if ($file == ".gitkeep") {
                            echo('<img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/special.svg"><a href="/cms-special/admin/advanced/regedit/view/?key=' . $key . '&path=' . $path . "/" . $file . '">' . $file . '</a> <i>(' . $lang["admin-advanced-regedit"]["git"] . ')</i><br>');
                        } else {
                            if ($file == "siteicon.png") {
                                echo('<img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/icon.svg"><a href="/cms-special/admin/advanced/regedit/view/?key=' . $key . '&path=' . $path . "/" . $file . '">' . $file . '</a> <i>(' . $lang["admin-advanced-regedit"]["logocomp"] . ')</i><br>');
                            } else {
                                if ($file == "siteicon-uncomp.png") {
                                    echo('<img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/icon.svg"><a href="/cms-special/admin/advanced/regedit/view/?key=' . $key . '&path=' . $path . "/" . $file . '">' . $file . '</a> <i>(' . $lang["admin-advanced-regedit"]["logo"] . ')</i><br>');
                                } else {
                                    if ($file == "banner.jpg") {
                                        echo('<img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/icon.svg"><a href="/cms-special/admin/advanced/regedit/view/?key=' . $key . '&path=' . $path . "/" . $file . '">' . $file . '</a> <i>(' . $lang["admin-advanced-regedit"]["banner"] . ')</i><br>');
                                    } else {
                                        echo('<img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/image.svg"><a href="/cms-special/admin/advanced/regedit/view/?key=' . $key . '&path=' . $path . "/" . $file . '">' . $file . '</a> <i>(' . $lang["admin-advanced-regedit"]["gallery"] . ')</i><br>');
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    } else {
        $file = basename($path);
        if ($key == "HKST") {
            echo($lang["admin-advanced-regedit"]["tokenview"]);
        }
        if ($key == "HKWC") {
            echo('<code class="fcontent">' . str_replace("\n", "<br>", str_replace(">", "&gt;", str_replace("<", "&lt;", str_replace(" ", "&nbsp;", file_get_contents($root . $path))))) . '</code>');
        }
        if ($key == "HKUR") {
            if ($file == ".gitkeep") {
                echo('<code class="fcontent">' . str_replace("\n", "<br>", str_replace(">", "&gt;", str_replace("<", "&lt;", str_replace(" ", "&nbsp;", file_get_contents($root . $path))))) . '</code>');
            } else {
                if ($file == "siteicon.png") {
                    echo('<img style="vertical-align:middle;max-height:100%;max-width:100%;" src="/resources/upload/' . $file . '">');
                } else {
                    if ($file == "siteicon-uncomp.png") {
                        echo('<img style="vertical-align:middle;max-height:100%;max-width:100%;" src="/resources/upload/' . $file . '">');
                    } else {
                        echo('<img style="vertical-align:middle;max-height:100%;max-width:100%;" src="/resources/upload/' . $file . '">');
                    }
                }
            }
        }
    }

    ?>
</body>
</html>
