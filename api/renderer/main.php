<?php

function render(string $page) {
    if ($page == "index") {
        $MPCMSRendererPageNameValue = "index";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/homepage.php";
    } else {
        $MPCMSRendererPageNameValue = $page;
        include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/pages.php";
    }
}

function renderSpecial(string $markup, string $displayName = "Page") {
    $MPCMSRendererPageMarkup = $markup;
    $MPCMSRendererPageMarkupDN = $displayName;
    include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/special.php";
}