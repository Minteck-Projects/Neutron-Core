<?php

function render(string $name) {
    if (!cacheCheck($name)) {
        if ($name == "index") {
            require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer-old/homepage.php";

            $content = ob_get_contents();
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/page-index", $content);
            require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/debug.php";debugDump();
        } else {
            $MPCMSRendererPageNameValue = $name;
            require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer-old/init.php";

            $content = ob_get_contents();
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/page-" . $name, $content);
            require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/debug.php";debugDump();
        }   
    } else {
        rlgps("Received page from cache");
    }
}

function renderSpecial(string $markup, string $displayName = "Page") {
    $MPCMSRendererPageMarkup = $markup;
    $MPCMSRendererPageMarkupDN = $displayName;
    rlgps("Special page");
    require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer-old/init.php";
}