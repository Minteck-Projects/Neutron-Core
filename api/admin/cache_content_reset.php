<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache")) {
    $dir = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache");
    foreach ($dir as $file) {
        if (!($file == "." || $file == ".." || $file == ".htaccess")) {
            if (substr($file, 0, 5) == "page-") {
                unlink($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/$file");
            }
        }
    }
}