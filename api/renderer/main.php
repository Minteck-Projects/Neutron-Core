<?php
global $_VERSION;

global $_FNSN_DUMP_STARTDATE;
$_FNSN_DUMP_STARTDATE = new DateTime("now");
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/includes/cache.php";
ob_start();

function rlgps(string $message) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/renderer.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/renderer.log") . "\n" . "... " . $message);
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/oldRenderer")) {
    $_VERSION = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/cyclic_version");
    $_RENDERER = "CyclicCMS";
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/renderer.log", "Using CyclicCMS version " . $_VERSION);
    require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/wrapper.php";
} else {
    $_VERSION = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/jaw_version");
    $_RENDERER = "JustAWebsite";
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/renderer.log", "Using JustAWebsite version " . $_VERSION);
    require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer-old/render.php";
}