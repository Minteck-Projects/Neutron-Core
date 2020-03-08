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
foreach ($pages as $page) {
    if ($page != ".." && $page != ".") {
        if (is_dir($_SERVER['DOCUMENT_ROOT'] . "/" . $page)) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename")) {
                if (!in_array($page, $customSettings->PagesMasquées)) {
                    append("<a href=\"/{$page}\" title=\"/{$page}\" class=\"menulink-desktop\">" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename") . "</a>");
                }
            }
        }
    }
}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/enabled")) {append("<a href=\"/cms-special/galery\" title=\"/cms-special/galery\" class=\"menulink-desktop\">" . $lang["viewer"]["galery"] . "</a>");}

file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist.mtd", $cache);