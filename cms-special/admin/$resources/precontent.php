<?php

require $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php";

$pageid = explode("/", $_SERVER['REQUEST_URI'])[3];
if (isset(explode("/", $_SERVER['REQUEST_URI'])[4])) {
    if (explode("/", $_SERVER['REQUEST_URI'])[4] != "index.php" && substr(explode("/", $_SERVER['REQUEST_URI'])[4], 0, 1) != "?" && substr(explode("/", $_SERVER['REQUEST_URI'])[4], 0, 1) != "#") {
        if (isset($lang["admin-titles"][$pageid]->subpages)) {
            $subpageid = explode("/", $_SERVER['REQUEST_URI'])[4];
            $subpageel = (array)$lang["admin-titles"][$pageid]->subpages;
        } else {
            $subpageid = "";
        }
    } else {
        $subpageid = "";
    }
} else {
    $subpageid = "";
}

if (isset($lang["admin-titles"][$pageid])) {
    if (isset($lang["admin-titles"][$pageid]->dom) && isset($lang["admin-titles"][$pageid]->header)) {
        if (isset($lang["admin-titles"][$pageid]->subpages)) {
            if ($subpageid != "") {
                $subpages = $lang["admin-titles"][$pageid]->subpages;
                if (isset($subpageel)) {
                    if (isset($subpageel[$subpageid])) {
                        $pageConfig = [ "domName" => $subpageel[$subpageid]->dom . " — " . $lang["admin-titles"][$pageid]->dom, "headerName" => $subpageel[$subpageid]->header ];
                    } else {
                        $pageConfig = [ "domName" => $lang["admin-titles"]["fallback-subpages"] . " — " . $lang["admin-titles"][$pageid]->dom, "headerName" => $lang["admin-titles"]["fallback-subpages"] ];
                    }
                } else {
                    $pageConfig = [ "domName" => $lang["admin-titles"][$pageid]->dom, "headerName" => $lang["admin-titles"][$pageid]->header ];
                }
            } else {
                $pageConfig = [ "domName" => $lang["admin-titles"][$pageid]->dom, "headerName" => $lang["admin-titles"][$pageid]->header ];
            }
        } else {
            $pageConfig = [ "domName" => $lang["admin-titles"][$pageid]->dom, "headerName" => $lang["admin-titles"][$pageid]->header ];
        }
    } else {
        $pageConfig = [ "domName" => $lang["admin-titles"]["fallback"]->dom, "headerName" => $lang["admin-titles"]["fallback"]->header ];
    }
} else {
    $pageConfig = [ "domName" => $lang["admin-titles"]["fallback"], "headerName" => $lang["admin-titles"]["fallback"] ];
}

$invalid = false;

if (isset($_COOKIE['_MPCMS_ADMIN_TOKEN']) && $_COOKIE['_MPCMS_ADMIN_TOKEN'] != "." && $_COOKIE['_MPCMS_ADMIN_TOKEN'] != ".." && $_COOKIE['_MPCMS_ADMIN_TOKEN'] != "/") {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['_MPCMS_ADMIN_TOKEN'])) {

    } else {
        die("<script>location.href = '/cms-special/admin/?pr=" . str_replace("/index.php", "", $_SERVER['SCRIPT_NAME']) . "&pa=" . urlencode("?" . explode("?", $_SERVER['REQUEST_URI'])[1]) . "'</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/?pr=" . str_replace("/index.php", "", $_SERVER['SCRIPT_NAME']) . "&pa=" . urlencode("?" . explode("?", $_SERVER['REQUEST_URI'])[1]) . "'</script>");
}

if (isset($_POST['password'])) {
    if (password_verify($_POST['password'], file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/password"))) {
        die("<script>location.href = '/cms-special/admin/home';</script>");
        return;
    } else {
        $invalid = true;
    }
}

?>

<?php ob_start();echo("<!--\n\n" . str_replace('%year%', date('Y'), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license")) . "\n\n-->") ?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    $ready = true;
} else {
    $ready = false;
}

function startsWith ($string, $startString) {
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

function getData(string $dir, $ignoreUploadDir = false) {
    global $size;
    $dircontent = scandir($dir);
    foreach ($dircontent as $direl) {
        if (($ignoreUploadDir && ($direl == "/upload" || $dir . "/" . $direl == $_SERVER['DOCUMENT_ROOT'] . "/resources/upload")) || $direl == ".git") {} else {
            if ($direl == "." || $direl == "..") {} else {
                if (is_link($dir . "/" . $direl)) {} else {
                    if (is_dir($dir . "/" . $direl)) {
                        getData($dir . "/" . $direl);
                    } else {
			try {
			    $size = $size + filesize($dir . "/" . $direl);
			} catch (Error $err) {}
                    }
                }
            }
        }
    }
}

function isJson(string $json) {
    json_decode($json);
    return (json_last_error() == JSON_ERROR_NONE);
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/headers/preprocessor.php";

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/resources/css/fonts-import.css">
    <link rel="stylesheet" href="/resources/css/alerts.css">
    <link href="<?= $_MD_INCLUDES ?>/material-components-web.min.css" rel="stylesheet">
    <script src="<?= $_MD_INCLUDES ?>/material-components-web.min.js"></script>
    <link rel="stylesheet" href="<?= $_MDI_PATH ?>">
    <link rel="stylesheet" href="/resources/css/admin.css">
    <link rel="stylesheet" href="/resources/css/ui.css">
    <link rel="stylesheet" href="/resources/css/codename.css">
    <script src="/cms-special/admin/$resources/admin.js"></script>

    <link rel="preload" href="/resources/css/fonts-import.css" as="style">
    <link rel="preload" href="/resources/css/alerts.css" as="style">
    <link rel="preload" href="/resources/css/admin.css" as="style">
    <link rel="preload" href="/resources/css/ui.css" as="style">
    <link rel="preload" href="/cms-special/admin/$resources/common.css" as="style">
    <link rel="preload" href="/cms-special/admin/$resources/index.css" as="style">
    <link rel="preload" href="/cms-special/admin/$resources/responsive.css" as="style">
    <link rel="preload" href="/cms-special/admin/$resources/index-dark.css" as="style">
    <link rel="preload" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/icon?family=Material+Icons" as="style">
    <link rel="preload" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js" as="script">
    <link rel="preload" href="/cms-special/admin/$resources/admin.js" as="script">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/headers/documenthead.php"; ?>

    <?php

    if (!isset($loadEditor)) {
        $loadEditor = true;
    }

    if ($loadEditor) {
        echo('<script src="/resources/js/ckeditor5/ckeditor.js"></script><script src="/resources/js/ckeditor5/translations/fr.js"></script>');
    }

    ?>
    <?php
        if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/theme") == "dark") {
            echo('<link rel="stylesheet" href="/cms-special/admin/$resources/index-dark.css">');
        } elseif (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/theme") == "auto") {
            echo('<link rel="stylesheet" href="/cms-special/admin/$resources/index-auto.css">');
        } else {
            echo('<link rel="stylesheet" href="/cms-special/admin/$resources/index.css">');
        }
    ?>
    <link rel="stylesheet" href="/resources/lib/pushbar.js/library.css">
    <script src="/resources/lib/pushbar.js/library.js"></script>
    <title><?php

    if ($ready) {
        echo($pageConfig['domName'] . " — {$lang["admin-titles"]["suffix"]} — " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
    } else {
        echo($pageConfig['domName'] . " — {$lang["admin-titles"]["suffix"]} — MPCMS");
    }

    ?></title>
    <?php
        if (!$ready) {
            die("<script>location.href = '/cms-special/setup';</script></head>");
        }
    ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/header.php"; ?>
    <?php

    getData($_SERVER['DOCUMENT_ROOT']);
    $sizestr = $size . " " . $lang["sizes"]["bytes"];
    if ($size > 1024) {
        if ($size > 1048576) {
            if ($size > 1073741824) {
                $sizestr = round($size / 1073741824, 2) . " " . $lang["sizes"]["gib"];
            } else {
                $sizestr = round($size / 1048576, 2) . " " . $lang["sizes"]["mib"];
            }
        } else {
            $sizestr = round($size / 1024, 2) . " " . $lang["sizes"]["kib"];
        }
    } else {
        $sizestr = $size . " " . $lang["sizes"]["bytes"];
    }
    $sizestr = str_replace(".", $lang["sizes"]["separator"], $sizestr);

    ?>
</head>
<body id="settings" style="overflow-x:hidden;">
    <?php

    require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/headers/documentbody.php";

    $path = str_replace("/index.php", "", $_SERVER['SCRIPT_NAME']);
    $name = $pageConfig['headerName'];

    ?>
    <div id="admin">
        <?php
        
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/updates")) {
            echo("<div id=\"updates-available\">" . $lang["admin-home"]["updates"][0] . " — <a href=\"/cms-special/admin/updates\">" . $lang["admin-home"]["updates"][1] . "</a></div>");
            $updatable = true;
        } else {
            $updatable = false;
        }
        
        ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/header.php"; ?>
        <div id="app-grid">
            <main class="main-content" id="main-content">
                <div id="version-place"><a class="discreet" href="/cms-special/admin/about"><?= str_replace("#", substr(md5(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")), 0, 2), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")) ?></a></div>
                <div class="mdc-top-app-bar--fixed-adjust">
