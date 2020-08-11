<?php

function render(string $page) {
    global $MPCMSRendererPageNameValue;

    if ($page == "index") {
        $MPCMSRendererPageNameValue = "index";
        rlgps("Processing website homepage");
        require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/homepage.php";
    } else {
        $MPCMSRendererPageNameValue = $page;
        rlgps("Processing /{$page}");
        require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/pages.php";
    }
}

function renderSpecial(string $markup, string $displayName = "Page") {
    global $MPCMSRendererPageMarkup;
    global $MPCMSRendererPageMarkupDN;

    $MPCMSRendererPageMarkup = $markup;
    $MPCMSRendererPageMarkupDN = $displayName;
    rlgps("Processing special page");
    require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/special.php";
}