<?php

function render(string $name) {
    if ($name == "index") {
        require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer-old/homepage.php";
    } else {
        $MPCMSRendererPageNameValue = $name;
        require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer-old/init.php";
    }
}

function renderSpecial(string $markup, string $displayName = "Page") {
    $MPCMSRendererPageMarkup = $markup;
    $MPCMSRendererPageMarkupDN = $displayName;
    require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer-old/init.php";
}