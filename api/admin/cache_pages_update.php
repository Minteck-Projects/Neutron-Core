<?php

$customSettings = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json"));
global $cache;
$cache = "";

function append(string $text) {
    global $cache;
    $cache = $cache . $text;
}

function compareASCII($a, $b) {
    $at = iconv('UTF-8', 'ASCII//TRANSLIT', $a);
    $bt = iconv('UTF-8', 'ASCII//TRANSLIT', $b);
    return strcmp($at, $bt);
}

$pages = scandir($_SERVER['DOCUMENT_ROOT']);
uasort($pages, 'compareASCII');
$index = 0;
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/enabled")) {$index = 1;}
append("@home|@indexHomeIcon");
foreach ($pages as $page) {
    if ((($page != ".." && $page != ".") && $index < 6) && (is_dir($_SERVER['DOCUMENT_ROOT'] . "/" . $page)) && (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename")) && (!in_array($page, $customSettings->hiddenPages))) {
        append("\n{$page}|" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename"));
        $index++;
    }
}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/enabled")) {
    append("\n@galery|" . $lang["viewer"]["galery"]);
}

file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist.mtd", $cache);

$cache = "";
$index = 0;
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/enabled")) {$index = 1;}
append("@home|@indexHomeIcon");
foreach ($pages as $page) {
    if ((($page != ".." && $page != ".")) && (is_dir($_SERVER['DOCUMENT_ROOT'] . "/" . $page)) && (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename")) && (!in_array($page, $customSettings->hiddenPages))) {
        append("\n{$page}|" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename"));
        $index++;
    }
}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/enabled")) {
    append("\n@galery|" . $lang["viewer"]["galery"]);
}

file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-full.mtd", $cache);

/* --------------------------- */
// Retro compatibility with the old renderer
$cache = "";

$pages = scandir($_SERVER['DOCUMENT_ROOT']);
uasort($pages, 'compareASCII');
foreach ($pages as $page) {
    if ($page != ".." && $page != ".") {
        if (is_dir($_SERVER['DOCUMENT_ROOT'] . "/" . $page)) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename")) {
                if (!in_array($page, $customSettings->hiddenPages)) {
                    append("<a href=\"/{$page}\" title=\"/{$page}\" class=\"menulink-desktop\">" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename") . "</a>");
                }
            }
        }
    }
}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/enabled")) {append("<a href=\"/cms-special/galery\" title=\"/cms-special/galery\" class=\"menulink-desktop\">" . $lang["viewer"]["galery"] . "</a>");}

file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-old.mtd", $cache);