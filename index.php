<?php

/*

Minteck Projects CMS Homepage

If you see this text on your browser, PHP is not installed or
enabled on your server. Download it at https://php.net or
using your package manager.

*/

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/main.php"; render('index');
} else {
    header("Location: /cms-special/setup");
    die();
}