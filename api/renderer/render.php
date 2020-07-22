<?php

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/oldRenderer")) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/wrapper.php";
} else {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer-old/render.php";
}