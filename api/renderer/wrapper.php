<?php

function render(string $page) {
    global $MPCMSRendererPageNameValue;

    if ($page == "index") {
        $MPCMSRendererPageNameValue = "index";
        rlgps("Processing website homepage");
        if (!cacheCheck("index")) {
            require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/homepage.php";

            $content = ob_get_contents();
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/page-index", $content);
            require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/debug.php";debugDump();
        } else {
            rlgps("Received page from cache");
        }
    } else {
        $MPCMSRendererPageNameValue = $page;
        rlgps("Processing /{$page}");
        if (!cacheCheck($page)) {
            require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/pages.php";

            $content = ob_get_contents();
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/page-" . $page, $content);
            require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/debug.php";debugDump();
        } else {
            rlgps("Received page from cache");
        }
    }
}

function renderSpecial(string $markup, string $displayName = "Page") {
    global $MPCMSRendererPageMarkup;
    global $MPCMSRendererPageMarkupDN;

    $MPCMSRendererPageMarkup = $markup;
    $MPCMSRendererPageMarkupDN = $displayName;
    rlgps("Processing special page");
    require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/special.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/debug.php";debugDump();
}