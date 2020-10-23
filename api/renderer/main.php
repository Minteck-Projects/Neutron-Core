<?php
global $_VERSION;

require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/includes/cache.php";
ob_start();

function rlgps(string $message) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/renderer.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/renderer.log") . "\n" . "... " . $message);
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/oldRenderer")) {
    $_VERSION = "2.1.0";
    $_RENDERER = "CyclicCMS";
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/renderer.log", "Using CyclicCMS version " . $_VERSION);
    require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/wrapper.php";
} else {
    $_VERSION = "1.6";
    $_RENDERER = "JustAWebsite";
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/renderer.log", "Using JustAWebsite version " . $_VERSION);
    require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer-old/render.php";
}