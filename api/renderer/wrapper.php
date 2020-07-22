<?php

function render(string $page) {
    global $MPCMSRendererPageNameValue;

    if ($page == "index") {
        $MPCMSRendererPageNameValue = "index";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/homepage.php";
    } else {
        $MPCMSRendererPageNameValue = $page;
        require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/pages.php";
    }
}

function renderSpecial(string $markup, string $displayName = "Page") {
    global $MPCMSRendererPageMarkup;
    global $MPCMSRendererPageMarkupDN;

    $MPCMSRendererPageMarkup = $markup;
    $MPCMSRendererPageMarkupDN = $displayName;
    require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/special.php";
}